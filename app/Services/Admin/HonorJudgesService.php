<?php


namespace App\Services\Admin;


use App\DTO\HonorJudgesDTO;
use App\Models\HonorJudges;

class HonorJudgesService
{
    public function getList(HonorJudgesDTO $HonorJudgesDTO)
    {
        $builder = HonorJudges::query();
        $HonorJudgesDTO->getJudgesid() && $builder->where('Judges_id',  $HonorJudgesDTO->getJudgesid());
        $HonorJudgesDTO->getName() && $builder->where('name', 'like', '%' . $HonorJudgesDTO->getName() . '%');
        if($HonorJudgesDTO->getPagelimete()===0)
            $builder->getQuery();
        return $builder->paginate($HonorJudgesDTO->getPagelimete());
    }

    public function getInOrganizationsPlanHonorJudges($arr){
        $builder = DB::select("SELECT * from honorjudges 
            where id in 
            (select HonorJudges_id from HonorJudges_organizations_plan 
            where organizations_plan_id=".$arr[0].") 
            and organization_id=".$arr[1]);
        return $builder;
    }

    public function getNotInOrganizationsPlanHonorJudges($arr){
        $builder = DB::select("SELECT * from honorjudges 
            where id not in 
            (select HonorJudges_id from HonorJudges_organizations_plan 
            where organizations_plan_id=".$arr[0].") 
            and organization_id=".$arr[1]);
        return $builder;
    }

    public function show($HonorJudgesid){
        $HonorJudges =HonorJudges::find($HonorJudgesid);
        return $HonorJudges;
    }

    public function store(HonorJudgesDTO $dto){
        $HonorJudges = new HonorJudges;
        $HonorJudges->name = $dto->getName();
        $HonorJudges->honor_time = $dto->getHonorTime();
        $HonorJudges->content = $dto->getContent();
        $HonorJudges->img_url = $dto->getImgUrl();
        $HonorJudges->judges_id = $dto->getJudgesid();
        $HonorJudges->system_version = 'cqzgh';
        $HonorJudges->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function update(HonorJudgesDTO $dto)
    {
        $HonorJudges = HonorJudges::find($dto->getId());
        $HonorJudges->name = $dto->getName();
        $HonorJudges->honor_time = $dto->getHonorTime();
        $HonorJudges->content = $dto->getContent();
        $HonorJudges->img_url = $dto->getImgUrl();
        $HonorJudges->judges_id = $dto->getJudgesid();
        $HonorJudges->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy($request)
    {
        $HonorJudges = HonorJudges::find($request->id);

        $HonorJudges->delete();

        return '{"code":1000,"msg":"成功"}';
    }
}