<?php


namespace App\Services\Admin;

use App\DTO\JudgesScoreDTO;
use App\Models\judgesScore;
use App\Services\Service;

class JudgesScoreService  extends Service
{
      public function store(JudgesScoreDTO $dto){
          $build = judgesScore::query();
          $build->where('judges_id', $dto->getJudgesId());
          $build->where('score_type_id', $dto->getScoreTypeId());
          $build->where('case_schemes_id', $dto->getCaseSchemesId());
          $judge=$build->first();
          if(empty($judge)){
            $judgesScore = new judgesScore;
            $judgesScore->score = $dto->getScore();
            $judgesScore->judges_id = $dto->getJudgesId();
            $judgesScore->score_type = $dto->getScoreType();
            $judgesScore->score_type_id = $dto->getScoreTypeId();
            $judgesScore->case_schemes_id = $dto->getCaseSchemesId();
            $judgesScore->save();
          }
          else{
            $judge->score=$dto->getScore();
            $judge->save();
          }
          
          return '{"code":1000,"msg":"操作成功"}';
      }
}