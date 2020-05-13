<?php


namespace App\Services\Admin;


use App\DTO\SegmentsDTO;
use App\Models\Segments;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class SegmentsService extends Service
{
    public function getList(SegmentsDTO $SegmentsTO)
    {
        $builder = Segments::query();
        $SegmentsTO->getOrganizationId() && $builder->where('organization_id',  $SegmentsTO->getOrganizationId());
        $SegmentsTO->getOrganizationPlanId() && $builder->where('organization_plan_id',  $SegmentsTO->getOrganizationPlanId());
        $SegmentsTO->getName() && $builder->where('name', 'like', '%' . $SegmentsTO->getName() . '%');
        return $builder->paginate(15);
    }

    public function show($Segmentsid){
        $Segments =Segments::find($Segmentsid);
        return $Segments;
    }

    public function  removeRelevanceOrganizationPlan(SegmentsDTO $dto){
        $Segments = Segments::find($dto->getId());
        $Segments->organization_plan_id =null;
        $Segments->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public  function relevanceOrganizationPlan(SegmentsDTO $dto){
        $Segments = Segments::find($dto->getId());
        $Segments->organization_plan_id = $dto->getOrganizationPlanId();
        $Segments->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function store(SegmentsDTO $dto){
        $Segments = new Segments;
        $Segments->organization_id = $dto->getOrganizationId();
        $Segments->organization_plan_id = $dto->getOrganizationPlanId();;
        $Segments->stage_number = $dto->getStageNumber();
        $Segments->name = $dto->getName();
        $Segments->describe = $dto->getDescribe();
        $Segments->start_time = $dto->getStartTime();
        $Segments->end_time = $dto->getEndTime();
        $Segments->video_url = $dto->getVideoUrl();
        $Segments->img_url = $dto->getImgUrl();
        $Segments->submit_id = $dto->getSubmitId();
//        $Segments->check_state = 0;
        $Segments->system_version ='cqzgh';
        $Segments->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function update(SegmentsDTO $dto)
    {
        $Segments = Segments::find($dto->getId());
        $dto->getOrganizationId() && $Segments->organization_id = $dto->getOrganizationId();
        $dto->getOrganizationPlanId() && $Segments->organization_plan_id = $dto->getOrganizationPlanId();
        $Segments->stage_number = $dto->getStageNumber();
        $Segments->name = $dto->getName();
        $Segments->describe = $dto->getDescribe();
        $Segments->start_time = $dto->getStartTime();
        $Segments->end_time = $dto->getEndTime();
        $Segments->img_url = $dto->getImgUrl();
        $Segments->submit_id = $dto->getSubmitId();
//        $Segments->check_state = $dto->getCheckState();
        $Segments->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy($request)
    {
        $Segments = Segments::find($request->id);
        $Segments->delete();
        return '{"code":1000,"msg":"成功"}';
    }
}