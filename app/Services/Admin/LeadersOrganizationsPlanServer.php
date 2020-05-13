<?php


namespace App\Services\Admin;


use App\DTO\LeadersOrganizationsPlanDTO;
use App\Models\LeadersOrganizationsPlan;
use App\Services\Service;

class LeadersOrganizationsPlanServer extends Service
{

    public function getDetail(LeadersOrganizationsPlanDTO $LeadersOrganizationsPlanDTO){

        $builder = LeadersOrganizationsPlan::query();
        $LeadersOrganizationsPlanDTO->getId() && $builder->where('id',  $LeadersOrganizationsPlanDTO->getId());
        $LeadersOrganizationsPlanDTO->getLeadersId() && $builder->where('leaders_id',  $LeadersOrganizationsPlanDTO->getLeadersId());
        $LeadersOrganizationsPlanDTO->getOrganizationsPlanId() && $builder->where('organizations_plan_id',  $LeadersOrganizationsPlanDTO->getOrganizationsPlanId());
        return  $builder->getQuery();
    }

    public function store(LeadersOrganizationsPlanDTO $LeadersOrganizationsPlanDTO){
            $leadersOrganizationsPlan=new LeadersOrganizationsPlan();
            $leadersOrganizationsPlan->leaders_id=$LeadersOrganizationsPlanDTO->getLeadersId();
            $leadersOrganizationsPlan->organizations_plan_id=$LeadersOrganizationsPlanDTO->getOrganizationsPlanId();
            $leadersOrganizationsPlan->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy(LeadersOrganizationsPlanDTO $LeadersOrganizationsPlanDTO){
        $leadersOrganizationsPlan = LeadersOrganizationsPlan::query();
        $leadersOrganizationsPlan->where('organizations_plan_id',  $LeadersOrganizationsPlanDTO->getOrganizationsPlanId());
        $leadersOrganizationsPlan->where('leaders_id',  $LeadersOrganizationsPlanDTO->getLeadersId());
        $leadersOrganizationsPlan->first();
        $leadersOrganizationsPlan->delete();
        return '{"code":1000,"msg":"成功"}';
    }
}