<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 10:59
 */

namespace App\Services\Index;


use App\DTO\CraftsmanDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\Craftsman;
use App\Services\Service;

class CraftsmanService extends Service
{
    public function getList(CraftsmanDTO $dto)
    {
        $builder = Craftsman::query();

        !empty($dto->getIds())  &&  $builder->whereIn('id', $dto->getIds());
        $dto->getUsername()     &&  $builder->where('username', 'like', '%'.$dto->getUsername().'%');
        $dto->getIsCrafts()     &&  $builder->where('is_craftsman',$dto->getIsCrafts());
        !empty($dto->getIsCraftsmans()) && $builder->whereIn('is_craftsman', $dto->getIsCraftsmans());

        if ($dto->getPage() && $dto->getPageSize()) {
            $craftsmans = $builder->paginate($dto->getPageSize());
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
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();
        if (!$craftsman) {
            throw new InvalidArgumentException('工匠未找到');
        }

        $craftsman->star = $craftsman->star + 1;
        $craftsman->save();

        return $craftsman;
    }

    public function setBrowse(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();
        $craftsman->browse_amount = $craftsman->browse_amount + 1;
        $craftsman->save();

        return $craftsman->browse_amount;
    }
}