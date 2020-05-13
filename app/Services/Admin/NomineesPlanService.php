<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 3:45
 */

namespace App\Services\Admin;


use App\DTO\NomineeDTO;
use App\Models\Nomine;
use App\Models\NomineesPlan;
use App\Services\Service;

class NomineesPlanService extends Service
{

    public function getList(NomineeDTO $nomineeDTO)
    {

        $builder=NomineesPlan::query()->leftJoin('organizations_plan','organizations_plan.id','=','nominees_organizations_plan.organizations_plan_id');

        $nomineeDTO->getOrganizationId() && $builder->where('organizations_id' , $nomineeDTO->getOrganizationId());
        $nomineeDTO->getId() && $builder->where('nominee_id' , $nomineeDTO->getId());
        $builder->select('nominees_organizations_plan.*','organizations_plan.plan_name as plan_name');
//        dd($builder->toSql());
        return $builder->get();
    }

    public function getDetail($pnarr)
    {
        return NomineesPlan::where(['nominee_id' => $pnarr['nid'], 'organizations_plan_id' => $pnarr['pid']])->get();
    }

    //添加
    public function store()
    {

    }

    public function delete()
    {

    }

    //批量添加
    public function batchInsert($nomineePlanArr)
    {
        return NomineesPlan::insert($nomineePlanArr);
    }

    //批量删除
    public function batchDelete($nomineeId, $nomineePlanArr = [])
    {
//dd($nomineeId);
        if (count($nomineePlanArr)>0) {
            return NomineesPlan::where('nominee_id', $nomineeId)->whereNotIn('organizations_plan_id', $nomineePlanArr)->delete();
        }
        else
            return NomineesPlan::where('nominee_id', $nomineeId)->delete();
    }
}