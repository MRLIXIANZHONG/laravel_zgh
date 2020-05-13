<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 20:54
 */

namespace App\Services\Index;


use App\DTO\UnitDTO;
use App\Exceptions\NotFoundException;
use App\Models\Unit;
use App\Services\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UnitService extends Service
{
    protected $field = [
        'id', 'type', 'name', 'username', 'mobile', 'email', 'phone', 'address',
        'description', 'labour_star_amount', 'skill_star_amount',
        'innovate_star_amount', 'service_star_amount', 'updated_at', 'name_index'
    ];

    public function getList(UnitDTO $dto)
    {
        $builder = Unit::query();
        $dto->getIds() && $builder->whereIn('id', $dto->getIds());
        $dto->getType() && $builder->where('type', $dto->getType());
        $dto->getName() && $builder->where('name', 'like', '%'.$dto->getName().'%');
        $builder->where('check_status',1);
        $builder->orderBy('type')->orderBy('name_index');

        if ($dto->getPage() && $dto->getPageSize()) {
            $units = $builder->paginate($dto->getPageSize(),$this->field, $dto->getPage());
        } else {
            $units = $builder->get($this->field);
        }

        return $units;
    }

    public function getDetail(UnitDTO $dto)
    {
        $model = Unit::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('资源不存在');
        }

        return $model;
    }

    /**
     * 获取工会首页设置信息
     * @param $id
     * @return Builder|Model|\Illuminate\Database\Query\Builder|object
     * @throws NotFoundException
     */
    public function getHomeDetail($id)
    {
        $builder = Unit::query()->leftJoin('unit_homepage as homepage', 'homepage.unit_id', '=', 'units.id');
        $builder->where('units.id', $id);
        $builder->select('units.*', 'homepage.cover', 'homepage.theme_color as theme_color', 'homepage.page_title as page_title', 'homepage.page_describe as page_describe', 'homepage.wechat_photo as wechat_photo');
        $model = $builder->first();
        if (!$model) {
            throw new NotFoundException('资源不存在');
        }

        return $model;
    }
}