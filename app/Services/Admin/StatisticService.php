<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 16:19
 */

namespace App\Services\Admin;


use App\DTO\StatisticDTO;
use App\Models\ZghStatistic;
use App\Services\Service;

class StatisticService extends Service
{
    public function getList(StatisticDTO $dto)
    {
        $builder = ZghStatistic::query();
        $dto->getType() !== null  &&  $builder->where('type', $dto->getType());
        if ($dto->getType() == 3) {
            $builder->orderByDesc('date')->limit(7);
        } elseif ($dto->getType() == 4) {
            $builder->orderByDesc('month')->limit(7);
        }
        $statistics = $builder->get();

        return $statistics;
    }
}