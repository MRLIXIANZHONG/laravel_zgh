<?php


namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WechatUsersRequest;

class WechatUsersController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function checkIsDel(WechatUsersRequest $request)
    {
        $response = ServiceHelper::make('Index\WechatUsersService')->checkIsDel($request->openid);
        if($response)
            return '{"code":1000,"msg":"用户已关注"}';
        else
            return '{"code":1001,"msg":"您未关注微信公众号,请先关注微信公众号"}';
    }
}