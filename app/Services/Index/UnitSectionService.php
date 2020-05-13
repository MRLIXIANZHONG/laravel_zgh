<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 13:15
 */

namespace App\Services\Index;


use App\DTO\UnitSectionDTO;
use App\Models\UnitSection;
use App\Services\Service;

class UnitSectionService extends Service
{
    public function getList(UnitSectionDTO $dto)
    {
        $builder = UnitSection::query();
        !empty($dto->getUnitIds())  &&  $builder->whereIn('unit_id', $dto->getUnitIds());
        $unitSection = $builder->get();

        return $unitSection;
    }
}