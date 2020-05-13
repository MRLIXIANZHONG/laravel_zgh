<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 7:44
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationsPlanDTO;
use App\DTO\OrganizationsWuxiaoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationsWuxiaoRequest;

class OrganizationWuxiaoController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * 获取五小列表
     * @param OrganizationsWuxiaoRequest $request
     * @return array
     */
    public function getList(OrganizationsWuxiaoRequest $request)
    {

        try {
            $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
            $data = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $data);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    /**
     * 获取五小详情
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        try {
            $wuxiao = ServiceHelper::make('Index\OrganizationWuxiaoService')->getDetail($id);
            $ip = request()->getClientIp();
            $array = [$ip, 3, $id];
            $islike = ServiceHelper::make('Index\UserstarLogService')->checkPCUserStarLog($array);
            $plan_org = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['organizationId' => $wuxiao->organization_id]));
            return array('code' => 1000, 'msg' => '成功', 'wuxiao' => $wuxiao, 'plan' => $plan_org, 'islike' => $islike);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    //移动端点赞
    public function setLike(OrganizationsWuxiaoRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $array = [$dto->getOpenid(), 3, $dto->getId()];
        $response = ServiceHelper::make('Index\UserstarLogService')->storeUserStarLog($array);
        if ($response == 1) {
            //点赞
            ServiceHelper::make('Index\OrganizationWuxiaoService')->setLike($dto->getId());
            return '{"code":1000,"msg":"点赞成功"}';
        } elseif ($response == 0)
            return '{"code":1001,"msg":"今天已点过赞"}';
        else
            return '{"code":1002,"msg":"用户未关注微信公众号,请先关注微信公众号"}';

    }

    //PC端点赞
    public function setPCLike(OrganizationsWuxiaoRequest $request)
    {
        if (!$this->checkStarTime([4,5,6])) {
            return array('code' => 1000, 'msg' => '大众评选未开始或已结束',);
        }
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $ip = request()->getClientIp();
        $array = [$ip, 3, $dto->getId()];
        $response = ServiceHelper::make('Index\UserstarLogService')->storePCUserStarLog($array);
        if ($response == 1) {
            //点赞
            ServiceHelper::make('Index\OrganizationWuxiaoService')->setLike($dto->getId());
            return array('code' => 1000, 'msg' => '点赞成功',);

        } else
            return array('code' => 1001, 'msg' => '今天已点过赞');
    }
}