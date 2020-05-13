<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 11:25
 */

namespace App\Services\Index;


use App\DTO\CraftsmanDTO;
use App\Exceptions\NotFoundException;
use App\Models\HistoryCraftsman;
use App\Services\Service;

class HistoryCraftsmanService extends Service
{
    public function getList(CraftsmanDTO $dto)
    {
        $builder = HistoryCraftsman::query();
        $dto->getYears()  &&  $builder->where('years', $dto->getYears());
        $dto->getIds()    &&  $builder->whereIn('id', $dto->getIds());
        $dto->getUsername()  &&  $builder->where('username', 'like', '%'.$dto->getUsername().'%');

        if ($dto->getPage() && $dto->getPageSize()) {
            $historyCraftsmans = $builder->paginate($dto->getPageSize(), ['*'], 'history_craftsmans',$dto->getPage());
        } else {
            $historyCraftsmans = $builder->get();
        }

        return $historyCraftsmans;
    }

    public function getDetail(CraftsmanDTO $dto)
    {
        $model = HistoryCraftsman::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('资源不存在');
        }

        return $model;
    }
}