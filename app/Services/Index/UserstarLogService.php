<?php


namespace App\Services\Index;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\UserstarLogDTO;
use App\Models\PCStarLog;
use App\Models\UserstarLog;
use App\Services\Service;

class UserstarLogService extends Service
{
    //1：今天已点过赞   0：今天未点过赞   -1：用户未关注
    public function checkUserStarLog($array)
    {
        $response = ServiceHelper::make('Index\WechatUsersService')->checkIsDel($array[0]);
        if ($response == 1) {
            $bulder = UserstarLog::query();
            $bulder->where('openid', $array[0]);
            $bulder->where('type', $array[1]);
            $bulder->where('active_id', $array[2]);
            $userStar = $bulder->orderByDesc('id')->first();
            if (empty($userStar))
                return 0;
            $dataDate = date('Y-m-d', strtotime($userStar->created_at));
            $nowDate = date('Y-m-d');

            if ($dataDate == $nowDate)
                return 1;
            else
                return 0;
        } else
            return -1;
    }

    //1:插入成功，-1:用户未关注  0:已点过赞
    public function storeUserStarLog($array)
    {
        $check = $this->checkUserStarLog($array);

        if ($check == 0) {
            $userStar = new UserstarLog();
            $userStar->openid = $array[0];
            $userStar->type = $array[1];
            $userStar->active_id = $array[2];
            $userStar->save();
            return 1;
        } elseif ($check == -1)
            return -1;
        else
            return 0;
    }

    /**
     * 判断是否点赞
     * @param $array
     * @return int
     */
    public function checkPCUserStarLog($array)
    {
        $bulder = PCStarLog::query();
        $bulder->where('ip', $array[0]);
        $bulder->where('type', $array[1]);
        $bulder->where('active_id', $array[2]);
        $userStar = $bulder->orderByDesc('id')->first();
        if (empty($userStar))
            return 0;
        $dataDate = date('Y-m-d', strtotime($userStar->created_at));
        $nowDate = date('Y-m-d');

        if ($dataDate == $nowDate)
            return 1;
        else
            return 0;
    }

    //1:插入成功， 0:已点过赞
    public function storePCUserStarLog($array)
    {
        $check = $this->checkPCUserStarLog($array);
        if ($check == 0) {
            $userStar = new PCStarLog();
            $userStar->ip = $array[0];
            $userStar->type = $array[1];
            $userStar->active_id = $array[2];
            $userStar->save();
            return 1;
        } else
            return 0;
    }
}