<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/8
 * Time: 16:21
 */

namespace App\Services\Admin;


use App\DTO\IndustryDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\Industry;
use App\Services\Service;

class IndustryService extends Service
{
    public function getList(IndustryDTO $dto)
    {
        $builder = Industry::query();
        $dto->getIndustryName()  &&  $builder->where('industry_name', 'like', '%'.$dto->getIndustryName().'%');

        $builder->orderByDesc('updated_at');

        if ($dto->getLocation()) {
            $industries = $builder->get();
        } else {
            $industries = $builder->paginate($dto->getPageSize());
        }

        return $industries;
    }

    public function store(IndustryDTO $dto)
    {
        $model = Industry::query()->where('industry_name', $dto->getIndustryName())->first();
        if ($model) {
            throw new InvalidArgumentException('请不要填写重复的标签名');
        }

        $model = new Industry();
        $model->industry_name = $dto->getIndustryName();
        $dto->getDescription()  &&  $model->description = $dto->getDescription();
        $model->save();

        return $model;
    }

    public function getDetail(IndustryDTO $dto)
    {
        $model = Industry::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('没有找到需要修改的标签');
        }
        return $model;
    }

    public function update(IndustryDTO $dto)
    {
        $count = Industry::query()->where('industry_name', $dto->getIndustryName())
            ->whereNotIn('id', [$dto->getId()])->count();

        if ($count > 0) {
            throw new InvalidArgumentException('请不要填写重复的标签名');
        }

        $model = Industry::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('没有找到需要修改的标签');
        }

        $model->industry_name = $dto->getIndustryName();
        $dto->getDescription()  &&  $model->description = $dto->getDescription();
        $model->save();

        return $model;
    }

    public function delete(IndustryDTO $dto)
    {
        return Industry::query()->where('id', $dto->getId())->delete();
    }
}