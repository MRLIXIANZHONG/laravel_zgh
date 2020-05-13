<?php


namespace App\Services\Admin;


use App\DTO\LeadersDTO;
use App\Models\Leaders;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class LeadersServices extends Service
{
    public function getList(LeadersDTO $LeadersDTO)
    {
        $builder = Leaders::query();
        $LeadersDTO->getOrganizationId() && $builder->where('organization_id',  $LeadersDTO->getOrganizationId());
        $LeadersDTO->getName() && $builder->where('name', 'like', '%' . $LeadersDTO->getName() . '%');
        if($LeadersDTO->getPagelimite()===0)
            $builder->getQuery();
        return $builder->paginate($LeadersDTO->getPagelimite());
    }

    public function getInOrganizationsPlanLeaders($arr){
        $builder = DB::select("SELECT * from leaders 
            where deleted_at is null   
            and id in 
            (select leaders_id from leaders_organizations_plan 
            where organizations_plan_id=".$arr[0].") 
            and organization_id=".$arr[1]);
        return $builder;
    }

    public function getNotInOrganizationsPlanLeaders($arr){
        $builder = DB::select("SELECT * from leaders 
            where deleted_at is null 
             and id not in 
            (select leaders_id from leaders_organizations_plan 
            where organizations_plan_id=".$arr[0].") 
            and organization_id=".$arr[1]);
        return $builder;
    }

    public function show($Leadersid){
        $Leaders =Leaders::find($Leadersid);
        return $Leaders;
    }

    public function store(LeadersDTO $dto){
        $Leaders = new Leaders;
        $Leaders->organization_id = $dto->getOrganizationId();
        $Leaders->name = $dto->getName();
        $Leaders->phone = $dto->getPhone();
        $Leaders->position = $dto->getPosition();
        $Leaders->duty = $dto->getDuty();
        $Leaders->system_version = 'cqzgh';
        $Leaders->img_url = $dto->getImgUrl();
        $Leaders->save();
       return '{"code":1000,"msg":"成功"}';
    }

    public function update(LeadersDTO $dto)
    {
        $Leaders = Leaders::find($dto->getId());
        $Leaders->organization_id = $dto->getOrganizationId();
        $Leaders->name = $dto->getName();
        $Leaders->phone = $dto->getPhone();
        $Leaders->position = $dto->getPosition();
        $Leaders->duty = $dto->getDuty();
        $Leaders->img_url = $dto->getImgUrl();
        $Leaders->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy($request)
    {
        DB::delete('delete from leaders_organizations_plan where leaders_id='.$request->id);
        
        $Leaders = Leaders::find($request->id);

        $Leaders->delete();

       return '{"code":1000,"msg":"成功"}';
    }
    
}