<?php


namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\UserstarLogDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserstarLogRequest;

class UserstarLogController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function checkUserStarLog(UserstarLogRequest $request){
        $array=[$request->openid,$request->type,$request->active_id];
        $response = ServiceHelper::make('Index\UserstarLogService')->checkUserStarLog($array);
        if($response==0)
             return '{"code":1000,"msg":"今天未点过赞"}';
        elseif ($response==1)
            return '{"code":1001,"msg":"今天已点过赞"}';
        else
            return '{"code":1002,"msg":"您未关注微信公众号,请先关注微信公众号"}';
    }

    public function storeUserStarLog(UserstarLogRequest $request){
        $dto = $this->requestHelper->makeDTO(UserstarLogDTO::class, $request);
        $response = ServiceHelper::make('Index\UserstarLogService')->storeUserStarLog($dto);
        if($response==0)
            return '{"code":1001,"msg":"已点过赞"}';
        elseif ($response==1)
            return '{"code":1000,"msg":"点赞成功"}';
        else
            return '{"code":1002,"msg":"您未关注微信公众号,请先关注微信公众号"}';
    }
}