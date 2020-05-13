<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 18:29
 */

namespace App\Services\Index;


use App\DTO\CraftsmanDTO;
use App\Exceptions\NotFoundException;
use App\Models\Craftsman;
use App\Services\Service;

class CandidateCraftsmanService extends Service
{
    public function getList(CraftsmanDTO $dto)
    {
        $builder = Craftsman::query();

        if ($dto->getPage() && $dto->getPageSize()) {
            $craftsmans = $builder->paginate($dto->getPageSize(), ['*'], 'craftsmans',$dto->getPage());
        } else {
            $craftsmans = $builder->get();
        }

        return $craftsmans;
    }

    public function getDetail(CraftsmanDTO $dto)
    {
        $model = Craftsman::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('资源未找到');
        }

        return $model;
    }

    public function star(CraftsmanDTO $dto)
    {
        Craftsman::query()->where('id', $dto->getId())->increment('star');

        return true;
    }
}