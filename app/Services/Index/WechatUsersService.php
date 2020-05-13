<?php


namespace App\Services\Index;


use App\Models\WechatUsers;
use App\Services\Service;

class WechatUsersService extends Service
{
    //0:未关注   1：已关注
    public function checkIsDel($openid)
    {
        $builder = WechatUsers::query();
        $builder->where('openid', $openid);

        $wechatUsers = $builder->first();

        if (empty($wechatUsers)) {
            return 0;
        }
        if ($wechatUsers->isdel === 1)
            return 1;
        else
            return 0;
    }
}