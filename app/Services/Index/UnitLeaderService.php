<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 13:04
 */

namespace App\Services\Index;


use App\DTO\UnitLeaderDTO;
use App\Models\UnitLeader;
use App\Services\Service;

class UnitLeaderService extends Service
{
    public function getList(UnitLeaderDTO $dto)
    {
        $builder = UnitLeader::query();
        !empty($dto->getUnitIds()) && $builder->whereIn('unit_id', $dto->getUnitIds());
        $leaders = $builder->get();

        return $leaders;
    }

}