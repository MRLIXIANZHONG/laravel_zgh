<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/14
 * Time: 22:37
 */

namespace App\Services\Index;


use App\DTO\segmentsDTO;
use App\Exceptions\NotFoundException;
use App\Models\Segments;
use App\Services\Service;

class SegmentsService extends Service
{
    public function getList(segmentsDTO $dto)
    {
        $builder = Segments::query();
        $segments = $builder->get();

        return $segments;
    }

    public function getDetail(segmentsDTO $dto)
    {
        $model = Segments::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('资源未找到');
        }

        return $model;
    }
}