<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/12
 * Time: 23:42
 */

namespace App\Services\Admin;


use App\DTO\CraftsmanDTO;
use App\Exceptions\NotFoundException;
use App\Models\HistoryCraftsman;
use App\Services\Service;

class HistoryCraftsmanService extends Service
{
    public function getList(CraftsmanDTO $dto)
    {
        $builder = HistoryCraftsman::query();
        $dto->getUsername()   &&   $builder->where('username', 'like', '%'.$dto->getUsername().'%');
        $dto->getMobile()     &&   $builder->where('mobile', 'like', '%'.$dto->getMobile().'%');
        $dto->getUnitName()   &&   $builder->where('unit_name', 'like', '%'.$dto->getUnitName().'%');
        $dto->getYears()      &&   $builder->where('years', $dto->getYears());
        $builder->orderByDesc('updated_at');
        $craftsmans = $builder->paginate($dto->getPageSize())->appends(request()->all());

        return $craftsmans;
    }

    public function getDetail(CraftsmanDTO $dto)
    {
        $model = HistoryCraftsman::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('您所查看的工匠未找到');
        }

        return $model;
    }

    public function store(CraftsmanDTO $dto)
    {
        $craftsman = new HistoryCraftsman();
        $dto->getUsername()  &&  $craftsman->username = $dto->getUsername();
        $dto->getMobile()    &&  $craftsman->mobile = $dto->getMobile();
        $dto->getUnitName()  &&  $craftsman->unit_name = $dto->getUnitName();
        $dto->getYears()     &&  $craftsman->years = $dto->getYears();
        $dto->getPhoto()     &&  $craftsman->photo = $dto->getPhoto();
        $dto->getDescribe()  &&  $craftsman->describe = $dto->getDescribe();
        $craftsman->save();

        return $craftsman;
    }

    public function update(CraftsmanDTO $dto)
    {
        $model = HistoryCraftsman::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('未找到资源');
        }

        $dto->getUsername()  &&  $model->username = $dto->getUsername();
        $dto->getMobile()    &&  $model->mobile = $dto->getMobile();
        $dto->getUnitName()  &&  $model->unit_name = $dto->getUnitName();
        $dto->getYears()     &&  $model->years = $dto->getYears();
        $dto->getPhoto()     &&  $model->photo = $dto->getPhoto();
        $dto->getDescribe()  &&  $model->describe = $dto->getDescribe();
        $model->save();

        return $model;
    }

    public function delete(CraftsmanDTO $dto)
    {
        return HistoryCraftsman::query()->where('id', $dto->getId())->delete();
    }

}