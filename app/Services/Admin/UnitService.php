<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/10
 * Time: 15:40
 */

namespace App\Services\Admin;


use App\DTO\UnitDTO;
use App\DTO\UnitHomePageDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\AdminUsers;
use App\Models\Unit;
use App\Models\UnitHomePage;
use App\Models\ZghStatistic;
use App\Services\Service;
use DB;

class UnitService extends Service
{
    const TYPE = [
        0 => '未设置',
        1 => '市直机关工会联合会',
        2 => '产业工会',
        3 => '区县工会',
    ];

    const HONOR = [
        0 => '否',
        1 => '是',
    ];

    public function getList(UnitDTO $dto)
    {
        $builder = Unit::query();
        $dto->getId()   && $builder->where('id', $dto->getId());
        $dto->getType() && $builder->where('type', $dto->getType());
        $dto->getName() && $builder->where('name', 'like', '%' . $dto->getName() . '%');
        $dto->getUsername() && $builder->where('username', 'like', '%' . $dto->getUsername() . '%');
        $dto->getMobile() && $builder->where('mobile', 'like', '%' . $dto->getMobile() . '%');
        $dto->getIds() && $builder->whereIn('id', $dto->getIds());
        $dto->getHonorUnit() !== null && $builder->where('honor_unit', $dto->getHonorUnit());
        $dto->getCheckStatus() !== null && $builder->where('check_status', $dto->getCheckStatus());

        if ($dto->getLocation()) {
            $units = $builder->get();
        } else {
            $units = $builder->orderByDesc('created_at')->paginate($dto->getPageSize())->appends(request()->all());
        }

        return $units;
    }

    public function getDetail(UnitDTO $dto)
    {
        $model = Unit::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('您要访问的工会不存在系统中');
        }

        return $model;
    }

    public function store(UnitDTO $dto)
    {
        try {
            DB::beginTransaction();
            $info = Unit::query()->where('mobile', $dto->getMobile())->first()->lockForUpdate();
            if ($info) {
                throw new InvalidArgumentException('号码已经存在');
            }
            $info = Unit::query()->where('username', $dto->getUsername())->first()->lockForUpdate();
            if ($info) {
                throw new InvalidArgumentException('联系人姓名已经存在');
            }

            $model = new Unit();
            $dto->getType() && $model->type = $dto->getType();
            $dto->getName() && $model->name = $dto->getName();
            $dto->getUsername() && $model->username = $dto->getUsername();
            $dto->getMobile() && $model->mobile = $dto->getMobile();
            $dto->getPassword() && $model->password = md5($dto->getPassword() . env('JWT_KEY'));
            $dto->getDescription() && $model->description = $dto->getDescription();
            $dto->getCheckStatus() !== null && $model->check_status = $dto->getCheckStatus();
            $dto->getHonorUnit() !== null && $model->honor_unit = $dto->getHonorUnit();
            $dto->getPhoto() && $model->photo = $dto->getPhoto();
            $dto->getShareTitle() && $model->share_title = $dto->getShareTitle();
            $dto->getShareDescription() && $model->share_description = $dto->getShareDescription();
            $model->save();

            $adminUser = new AdminUsers();
            $adminUser->username = $dto->getUsername();
            $adminUser->name = $dto->getName();
            $adminUser->password = $dto->getPassword();
            $adminUser->avatar = $dto->getPhoto();
            $adminUser->system_version = 'cqzgh';
            $adminUser->units_id = $model->id;
            $adminUser->save();

            DB::table('admin_role_users')->insert([
                'role_id'  => 2,
                'user_id'  => $adminUser->id,
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollback();
            throw new InvalidArgumentException('新增失败');
        }
        return $model;
    }

    public function update(UnitDTO $dto)
    {
        $model = Unit::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('您要访问的资源不存在');
        }

        $dto->getType() && $model->type = $dto->getType();
        $dto->getName() && $model->name = $dto->getName();
        $dto->getUsername() && $model->username = $dto->getUsername();
        $dto->getMobile() && $model->mobile = $dto->getMobile();
        //$dto->getPassword() && $model->password = md5($dto->getPassword() . env('JWT_KEY'));
        $dto->getAddress() && $model->address = $dto->getAddress();
        $dto->getDescription() && $model->description = $dto->getDescription();
        $dto->getCheckStatus() !== null && $model->check_status = $dto->getCheckStatus();
        $dto->getHonorUnit() !== null && $model->honor_unit = $dto->getHonorUnit();
        $dto->getPhoto() && $model->phone = $dto->getPhoto();
        $dto->getVirtualBrowse() && $model->virtual_browse = $dto->getVirtualBrowse();
        $dto->getVirtualStar() && $model->virtual_star = $dto->getVirtualStar();
        $dto->getShareTitle() && $model->share_title = $dto->getShareTitle();
        $dto->getShareDescription() && $model->share_description = $dto->getShareDescription();
        $dto->getShareImg()   && $model->share_img = $dto->getShareImg();
        $dto->getRejectReason() && $model->reject_reason = $dto->getRejectReason();
        $model->save();

        if ($dto->getUsername() || $dto->getName() || $dto->getPhoto()) {
            $adminUser = AdminUsers::query()->where('units_id', $dto->getId())
                ->where('org_id', null)->first();
            $dto->getUsername()  &&  $adminUser->username = $dto->getUsername();
            $dto->getName()      &&  $adminUser->name = $dto->getName();
            $dto->getPhoto()     &&  $adminUser->avatar = $dto->getPhoto();
            $adminUser->save();
        }

        return $model;
    }

    public function delete(UnitDTO $dto)
    {
        try {
            DB::beginTransaction();
            Unit::query()->where('id', $dto->getId())->delete();
            $adminUsers = AdminUsers::query()->where('units_id', $dto->getId())->where('org_id', null)->first();
            $adminUsers->delete();
            DB::table('admin_role_users')->where('user_id', $adminUsers->id)->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw new InvalidArgumentException('删除失败');
        }
        return true;
    }

    public function getHomePage(UnitHomePageDTO $DTO)
    {

        $unitHomePage = UnitHomePage::query()->where('unit_id', $DTO->getUnitId())->first();
        if ($unitHomePage)
            return $unitHomePage;
        $unit = Unit::find($DTO->getUnitId());
        if ($unit) {
            $unitHomePage = new UnitHomePage();
            $unitHomePage->unit_id = $DTO->getUnitId();
            $unitHomePage->unit_name = $unit->name;
            $unitHomePage->save();
        }
        return $unitHomePage;

    }

    /**
     * 更新主页设置
     * @param UnitHomePageDTO $DTO
     * @return string[]
     */
    public function updateHomePage(UnitHomePageDTO $DTO)
    {
        $unitHomePage = UnitHomePage::find($DTO->getId());
        $unitHomePage->unit_url = $DTO->getUnitUrl();
        $unitHomePage->cover = $DTO->getCover();
        $unitHomePage->theme_color = $DTO->getThemeColor();
        $unitHomePage->page_title = $DTO->getPageTitle();
        $unitHomePage->page_describe = $DTO->getPageDescribe();
        $unitHomePage->page_describe = $DTO->getPageDescribe();
        $unitHomePage->wechat_photo = $DTO->getWechatPhoto();

        $result = $unitHomePage->save();
        if ($result)
            return ['code' => '1000', 'message' => '成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];

    }

    public function export(UnitDTO $dto)
    {
        $statistics = ZghStatistic::query()->orderByDesc('date')->first();
        $time = data_get($statistics, 'date');

        $units = Unit::query()->where('check_status', 1)->get(['id', 'name', 'type', 'username', 'mobile', 'honor_unit']);
        $organizationStatistics = ZghStatistic::query()->whereIn('type_id', $units->pluck('id'))
            ->where('type', 2)->where('date', $time)->get();

        foreach ($organizationStatistics as $item) {
            $unit = $units->where('id', data_get($item, 'type_id'))->first();
            data_set($item, 'unit_id_name', data_get($unit, 'name'));
            data_set($item, 'type_name', self::TYPE[$unit->type]);
            data_set($item, 'mobile', data_get($unit, 'mobile'));
            data_set($item, 'username', data_get($unit, 'username'));
            data_set($item, 'honor_name', self::HONOR[$unit->honor_unit]);
        }

        return $organizationStatistics->toArray();
    }

    public function setPassword(UnitDTO $dto)
    {
        $model = Unit::query()->where('id', $dto->getId())->first();
        if (!$model) {
            throw new NotFoundException('未找到该工会');
        }
        $model->password = md5($dto->getPassword() . env('JWT_KEY'));
        $model->save();

        $adminUser = AdminUsers::query()->where('units_id', $dto->getId())
            ->where('org_id', null)->first();
        $adminUser->password = md5($dto->getPassword() . env('JWT_KEY'));
        $adminUser->save();

        return $model;
    }

    public function setVirtual(UnitDTO $dto)
    {
        $model = Unit::query()->where('id', $dto->getId())->first();
        if (!$model) {
            throw new NotFoundException('未找到该工会');
        }
        $model->virtual_browse = $dto->getVirtualBrowse();
        $model->virtual_star = $dto->getVirtualStar();
        $model->save();

        return $model;
    }
}