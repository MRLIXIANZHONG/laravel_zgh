<?php


namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationsPlanDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationsPlanRequest;
use App\Models\OrganizationsPlan;
use http\Exception;

class OrganizationsPlanController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }
    
    //企业方案统计信息
     public function getOrganizationsPlanStatisticsCount(OrganizationsPlanRequest $request){
         try {
             $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
             $data = ServiceHelper::make('Index\OrganizationsPlanService')->getOrganizationsPlanStatisticsCount($dto);
             return array('code' => 1000, 'msg' => '成功', 'data' => $data);
         } catch (Exception $e) {
             return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
         }
     }

     //优秀方案企业列表
    public function index(OrganizationsPlanRequest $request){
        try {
            $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
            $data = ServiceHelper::make('Index\OrganizationsPlanService')->getList($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $data);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function excellentIndex(OrganizationsPlanRequest $request){
        try {
            $array=["industry_tag_id"=>$request->industry_tag_id,"units_id"=>$request->units_id,'organizationstype'=>$request->$request];
            $data = ServiceHelper::make('Index\OrganizationsPlanService')->excellentOrganizationsPlanList($array);
            return array('code' => 1000, 'msg' => '成功', 'data' => $data);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function getDetail(OrganizationsPlanRequest $request){
        try {
            $data = ServiceHelper::make('Index\OrganizationsPlanService')->getDetail($request->id);
            $ip=request()->getClientIp();
            array_push($data,ServiceHelper::make('Index\UserstarLogService')->checkPCUserStarLog([$ip,1,(int)$request->id]));
            return array('code' => 1000, 'msg' => '成功', 'data' => $data);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    //点赞功能
    public function setStarCount(OrganizationsPlanRequest $request)
    {
        try {
            if(!$this->checkStarTime([7])) {
                return '{"code":1000,"msg":"大众评选未开始或已结束"}';
            }
            $array=[$request->id,$request->openid];
            $state= ServiceHelper::make('Index\UserstarLogService')->checkUserStarLog([$array[1],1,$array[0]]);
            if($state==0)  {
                $response = ServiceHelper::make('Index\OrganizationsPlanService')->setStarCount($array[0]);
                return  $response;
            }
            elseif ($state==1)
                return   array('code' => 1000, 'msg' => '已点赞', 'data' => []);
            else
                return   array('code' => 1000, 'msg' => '用户未关注微信公众号,请先关注微信公众号', 'data' => []);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function planPCStar(OrganizationsPlanRequest $request){
        $ip=request()->getClientIp();

        if(!$this->checkStarTime([7])) {
            return '{"code":1000,"msg":"大众评选未开始或已结束"}';
        }
        $array=[$ip,1,$request->id];
        $response = ServiceHelper::make('Index\UserstarLogService')->storePCUserStarLog($array);
        if($response) {
            //点赞
            ServiceHelper::make('Index\OrganizationsPlanService')->setStarCount($array[2]);
            return '{"code":1000,"msg":"点赞成功"}';
        }
        else
            return '{"code":1001,"msg":"今天已点过赞"}';
    }

    //浏览功能
    public function setBrowseCount(OrganizationsPlanRequest $request)
    {
        try {
            ServiceHelper::make('Index\OrganizationsPlanService')->setBrowseCount($request->id);
            return array('code' => 1000, 'msg' => '成功');
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function unitStatistics(){
        try {
            $response = ServiceHelper::make('Index\OrganizationsPlanService')->unitStatistics();
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }
}