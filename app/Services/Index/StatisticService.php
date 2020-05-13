<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 16:19
 */

namespace App\Services\Index;


use App\DTO\StatisticDTO;
use App\Models\ZghStatistic;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class StatisticService extends Service
{
    public function getList(StatisticDTO $dto)
    {
        $builder = ZghStatistic::query();
        $dto->getType() !== null && $builder->where('type', $dto->getType());
        if ($dto->getType() == 3) {
            $builder->orderByDesc('date')->limit(7);
        } elseif ($dto->getType() == 4) {
            $builder->orderByDesc('month')->limit(7);
        }
        $statistics = $builder->get();

        return $statistics;
    }

    //StatisticDTO $dto,beginTime 开始时间，EndTime 结束事件，
    public function getListByDateTime($array)
    {
//        $builder = ZghStatistic::query();
//        $array[0]->getType() && $builder->where('type',$array[0]->getType());
//        $builder->where('date','>=',$array[1]);
//        $builder->where('date','<=',$array[2]);
//        return  $builder->get();
        $builder = DB::select("
             select
             SUM(organization_count) as organization_count,
             SUM(fa_tb) as fa_tb,
             SUM(browse_amount) as browse_amount,
             SUM(star_amount) as star_amount, 
             SUM(staff_count) as staff_count,
             SUM(organization_plan_count) as organization_plan_count,
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = ? and
              `date` >=? and
              `date` <= ? group by `date`
        ", [$array[0]->getType(), $array[1], $array[2]]);
        return $builder;
    }

    //StatisticDTO $dto,beginMouth 开始时间，EndMouth 结束事件，
    public function getListByMouth($array)
    {
//        $builder = ZghStatistic::query();
//        $array[0]->getType() && $builder->where('type',$array[0]->getType());
//        $builder->where('month','>=',$array[1]);
//        $builder->where('month','<=',$array[2]);
//        return  $builder->get();

        $builder = DB::select("
             select
             SUM(organization_count) as organization_count,
             SUM(fa_tb) as fa_tb,
             SUM(browse_amount) as browse_amount,
             SUM(star_amount) as star_amount,
             SUM(staff_count) as staff_count,
             SUM(organization_plan_count) as organization_plan_count,
             CONCAT(month,'月')  as count_time
              from `zgh_statistics` where
              `type` = ? and
              `month` >=? and
              `month` <= ? group by `month`
        ", [$array[0]->getType(), $array[1], $array[2]]);
        return $builder;
    }

    //工会下企业排名
    public function organizationOrderByUnits($checkCount)
    {
        $builder = ZghStatistic::query();
        $builder->join('units', 'zgh_statistics.type_id', 'units.id');
        $builder->where('zgh_statistics.type', 2);
        $builder->select('units.name as uname', 'units.type as utype', 'zgh_statistics.organization_count as ocount', 'zgh_statistics.organization_plan_count as pcount');
        $builder->orderByDesc('organization_count')->limit($checkCount);
        return $builder->get();
    }

    //移动端总工会统计接口
    //$array[$StatisticDTO,$checkCount,$timeType,$beginTime,$endTime]
    //$checkCount 工会企业排名数量 ,$checkCount 工会企业排名数量 ,$TimeType 0是查月份 1是查日期,$beginTime 开始时间 $endTime 结束时间
    public function adminunionModel($array)
    {
        $Orders = $this->organizationOrderByUnits($array[1]);
        if ($array[2] == 0)
            $statisticList = $this->getListByMouth([$array[0], $array[3], $array[4]]);
        else
            $statisticList = $this->getListByDateTime([$array[0], $array[3], $array[4]]);
        return [$Orders, $statisticList];
    }


    //移动基层工会
    //$array[$StatisticDTO,$checkCount,$timeType,$beginTime,$endTime]
    //$checkCount 工会企业排名数量 ,$checkCount 工会企业排名数量 ,$TimeType 0是查月份 1是查日期,$beginTime 开始时间 $endTime 结束时间
    public function unionModel($array)
    {
        if ($array[1] == 0)
            $statisticList = $this->getListByMouthUnion([$array[0], $array[2], $array[3]]);
        else
            $statisticList = $this->getListByDateTimeUnion([$array[0], $array[2], $array[3]]);
        return [$statisticList];
    }


    //StatisticDTO $dto,beginTime 开始时间，EndTime 结束事件，
    public function getListByDateTimeUnion($array)
    {
//        $builder = ZghStatistic::query();
//        $array[0]->getType() && $builder->where('type',$array[0]->getType());
//        $builder->where('date','>=',$array[1]);
//        $builder->where('date','<=',$array[2]);
//        return  $builder->get();
        $builder = DB::select("
             select
             SUM(fa_cs) as fa_tb,
             SUM(yxgr_yd) as yxgr_yd,
             SUM(wx_yd) as wx_yd,
             SUM(xw_tb) as xw_tb,
             SUM(browse_amount) as browse_amount,
             SUM(star_amount) as star_amount, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `type_id` = ? and
              `date` >=? and
              `date` <= ? group by `date`
        ", [$array[0], $array[1], $array[2]]);

        return $builder;
    }

    //StatisticDTO $dto,beginMouth 开始时间，EndMouth 结束事件，
    public function getListByMouthUnion($array)
    {
//        $builder = ZghStatistic::query();
//        $array[0]->getType() && $builder->where('type',$array[0]->getType());
//        $builder->where('month','>=',$array[1]);
//        $builder->where('month','<=',$array[2]);
//        return  $builder->get();

        $builder = DB::select("
             select
             SUM(fa_cs) as fa_cs,
             SUM(yxgr_yd) as yxgr_yd,
             SUM(wx_yd) as wx_yd,
             SUM(xw_tb) as xw_tb,
             SUM(browse_amount) as browse_amount,
             SUM(star_amount) as star_amount, 
             CONCAT(month,'月')  as count_time
              from `zgh_statistics` where
              `type` = 1 and
              `type_id` = ? and
              `month` >=? and
              `month` <= ? group by `month`
        ", [$array[0], $array[1], $array[2]]);
        return $builder;
    }

}