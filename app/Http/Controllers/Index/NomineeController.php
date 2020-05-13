<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 6:34
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\NomineeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NomineesRequest;
use Symfony\Component\HttpFoundation\Request;
use function EasyWeChat\Kernel\Support\get_client_ip;

class NomineeController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {

        $this->requestHelper = $requestHelper;
    }

    public function getList(NomineesRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);

        try {
            $nomineeService = ServiceHelper::make('Index\NomineeService');
            $industryService = ServiceHelper::make('Index\IndustryService');
            $nomineeList = $nomineeService->getList($dto);
           // $industryList=$industryService->getList();


            return array('code' => 1000, 'msg' => '成功', 'nomineeList' => $nomineeList);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }

    }
    //获取优秀个人详情
    public function getdetail($id)
    {
      //  dd(request()->getClientIp());
        try {
            $nomineeService = ServiceHelper::make('Index\NomineeService');
            $userPCstarLogService = ServiceHelper::make('Index\UserstarLogService');
            $ip=request()->getClientIp();
            $islike=$userPCstarLogService->checkPCUserStarLog([$ip,2,$id]);
            $nomineeExperienceList = $nomineeService->getExperienceList($id);
            $nominee = $nomineeService->getDetail($id);
            $nominessImgList = $nomineeService->getNominessImg($id);
            $nomineeVideoList = $nomineeService->getNominessVideo($id);
            $nomineePlanList = $nomineeService->getNomineePlan($id);
            //获取参与的方案
            return array('code' => 1000, 'msg' => '成功',
                'nominee' => $nominee,
                'islike'=>$islike,
                'nomineeExperienceList' => $nomineeExperienceList,
                'nominessImgList' => $nominessImgList,
                'nomineeVideoList' => $nomineeVideoList,
                'planlist'=>$nomineePlanList);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function  star(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);

        $array=[$dto->getOpenid(),2,$dto->getId()];
        $response = ServiceHelper::make('Index\UserstarLogService')->storeUserStarLog($array);
        if($response==1) {
            //点赞
            ServiceHelper::make('Index\NomineeService')->setLike($dto->getId());
            return '{"code":1000,"msg":"点赞成功"}';
        }
        elseif ($response==0)
            return '{"code":1001,"msg":"今天已点过赞"}';
        else
            return '{"code":1002,"msg":"用户未关注微信公众号,请先关注微信公众号"}';

    }
    public function  pcstar(NomineesRequest $request)
    {
        if (!$this->checkStarTime([1,2,3])) {
            return '{"code":1000,"msg":"大众评选阶段未开始或已结束"}';
        }
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        $ip=request()->getClientIp();
        $array=[$ip,2,$dto->getId()];
        $response = ServiceHelper::make('Index\UserstarLogService')->storePCUserStarLog($array);
        if($response) {
            //点赞
            ServiceHelper::make('Index\NomineeService')->setLike($dto->getId());
            return '{"code":1000,"msg":"点赞成功"}';
        }
        else
            return '{"code":1001,"msg":"今天已点过赞"}';


    }
}