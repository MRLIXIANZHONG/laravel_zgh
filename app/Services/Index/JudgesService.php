<?php


namespace App\Services\Index;


use App\DTO\JudgesDTO;
use App\Models\Judges;
use App\Models\honorJudges;

use App\Services\Service;

class JudgesService extends Service
{
    public function getList(JudgesDTO $JudgesDTO)
    {
        $builder = Judges::query()->leftJoin("industry_tag", 'judges.industry', '=', 'industry_tag.id')->select(["judges.*", "industry_tag.industry_name as nominee_industry_name"]);
        $JudgesDTO->getIsrecommend() && $builder->where('isrecommend', $JudgesDTO->getIsrecommend());
        $JudgesDTO->getKind() && $builder->where('kind', $JudgesDTO->getKind());
        $JudgesDTO->getIndustry() && $builder->where('industry', $JudgesDTO->getIndustry());
        $JudgesDTO->getName() && $builder->where('name', 'like', '%' . $JudgesDTO->getName() . '%');
        $JudgesDTO->getIsrecommend() && $builder->where('isrecommend',  $JudgesDTO->getIsrecommend());
        return $builder->paginate($JudgesDTO->getPageSize());
    }

    public function show($judgesId)
    {
        return Judges::query()->leftJoin("industry_tag", 'judges.industry', '=', 'industry_tag.id')->select(["judges.*", "industry_tag.industry_name as nominee_industry_name"])->find($judgesId);
    }

    public function getHonorList($id)
    {
        $builder = honorJudges::query();
        $builder->where('Judges_id', $id);
        return $builder->get();
    }

}