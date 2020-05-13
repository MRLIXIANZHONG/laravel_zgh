<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\CaseSchemes;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $checkStatus = [
        0  => '企业未推送',
        1  => '企业已推送',
        2  => '上级工会驳回',
//        2  => '上级工会未审核',
        3  => '上级工会已审核',
        4  => '活动方驳回',
//        5  => '活动方未审核',
        6  => '活动方已审核',
        7  => '总工会驳回',
//        8  => '总工会未审核',
        9  => '总工会已审核',
        10 => '大众评选已开始',
        11 => '大众评选已结束',
        12 => '专家评选开已始',
        13 => '专家评选已结束',
    ];

    protected $admin = [3,6,9,10,11,12,13];

    protected $sz = [3,6,9,10,11,12,13];

    protected $gh = [1,3,4,6,7,9,10,11,12,13];

    protected $qy = [0,1,2,3,4,6,7,9,10,11,12,13];

    protected $pw = [12,13];

    public function checkStarTime(array $arr)
    {
        $time = date('Y-m-d H:i:s', time());
        $caseSchemes = CaseSchemes::query()->where('is_open',1)
            ->where('public_is_open',1)->whereIn('type', $arr)
            ->where('public_stime','<=', $time)->where('public_etime','>=' ,$time)->first();

        if (!$caseSchemes) {
            //throw new NotFoundException('赛事点赞阶段暂未开启，敬请期待');
            return false;
        }

        return true;
    }
}
