<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 16:28
 */

namespace App\Services\Admin;


use App\DTO\OrganizationDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\AdminUsers;
use App\Models\Organization;
use App\Models\OrganizationIndustryMap;
use App\Models\Unit;
use App\Models\ZghStatistic;
use App\Services\Service;

class OrganizationService extends Service
{
    const ORG = [
        0  =>  '未设置',
        1  =>  '国营控股企业',
        2  =>  '行政机关',
        3  =>  '港澳台、外商投资企业',
        4  =>  '民营控股企业',
        5  =>  '事业单位',
        6  =>  '其他',
    ];

    const SPORT = [
        0   =>   '未参与',
        1   =>   '已参与',
    ];

    public function getList(OrganizationDTO $dto)
    {
        $builder = Organization::query();
        $dto->getId()  &&  $builder->where('id', $dto->getId());
        $dto->getIds() &&  $builder->whereIn('id', $dto->getIds());
        $dto->getUnitId()  &&  $builder->where('unit_id', $dto->getUnitId());
        $dto->getNewType() &&  $builder->where('new_type', $dto->getNewType());
        $dto->getName()    &&  $builder->where('name', 'like', '%'.$dto->getName().'%');
        $dto->getMobile()  &&  $builder->where('mobile', 'like', '%'.$dto->getMobile());
        $dto->getCheckState() !== null && $builder->where('check_state', $dto->getCheckState());
        !empty($dto->getCheckStates()) && $builder->whereIn('check_state', $dto->getCheckStates());
        $dto->getIsCompetition() && $builder->where('is_competition', $dto->getIsCompetition());

        $builder->orderByDesc('updated_at');

        if ($dto->getLocation()) {
            $result = $builder->get();
        } else {
            $result = $builder->paginate($dto->getPageSize())->appends(request()->all());
        }

        return $result;
    }

    public function getDetail(OrganizationDTO $dto)
    {
        $model = Organization::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('您所查看的企业未找到');
        }

        return $model;
    }

    public function store(OrganizationDTO $dto)
    {
        $info = Organization::query()->where('mobile', $dto->getMobile())->first();

        if ($info) {
            throw new InvalidArgumentException('您所填写的号码已经存在');
        }

        $model = new Organization();
        $dto->getName()  &&  $model->name = $dto->getName();
        $dto->getUsername()   && $model->username = $dto->getUsername();
        $dto->getMobile()   &&  $model->mobile = $dto->getMobile();
        $dto->getUnitId()   &&  $model->unit_id = $dto->getUnitId();
        $dto->getWebsite()  &&  $model->website = $dto->getWebsite();
        $dto->getPhoto()    &&  $model->photo = $dto->getPhoto();
        $dto->getPlanName() &&  $model->plan_name = $dto->getPlanName();
        $dto->getSummary()  &&  $model->summary = $dto->getSummary();
        $dto->getContent()  &&  $model->content = $dto->getContent();
        $dto->getTargetTask()  &&  $model->target_task = $dto->getTargetTask();
        $dto->getAchievementTarget()  &&  $model->achievement_target = $dto->getAchievementTarget();
        $dto->getMeasures()  &&  $model->measures = $dto->getMeasures();
        $dto->getCommend()   &&  $model->commend = $dto->getCommend();
        $dto->getImgUrl()    &&  $model->img_url = $dto->getImgUrl();
        $dto->getStaffsInfo()  && $model->staffs_info = $dto->getStaffsInfo();
        $dto->getStaffCount()  && $model->staff_count = $dto->getStaffCount();
        $dto->getFarmerCount() && $model->farmer_count = $dto->getFarmerCount();
        $dto->getAccount()    &&  $model->account = $dto->getAccount();
        $dto->getBankName()   &&  $model->bank_name = $dto->getBankName();
        $dto->getCheckTime()  &&  $model->check_time = $dto->getCheckTime();
        $dto->getCheckState() !== null && $model->check_state = $dto->getCheckState();
        $dto->getNewType() && $model->new_type=$dto->getNewType();
//        $dto->getStarCount()  &&  $model->star_count = $dto->getStarCount();
//        $dto->getBrowseCount() && $model->browse_count = $dto->getBrowseCount();
        $model->save();

        return $model;
    }

    public function update(OrganizationDTO $dto)
    {
        $model = Organization::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('没有找到该企业');
        }

        $dto->getName()  &&  $model->name = $dto->getName();
        $dto->getUsername()   && $model->username = $dto->getUsername();
        $dto->getMobile()   &&  $model->mobile = $dto->getMobile();
        $dto->getUnitId()   &&  $model->unit_id = $dto->getUnitId();
        $dto->getWebsite()  &&  $model->website = $dto->getWebsite();
        $dto->getPhoto()    &&  $model->photo = $dto->getPhoto();
        $dto->getPlanName() &&  $model->plan_name = $dto->getPlanName();
        $dto->getSummary()  &&  $model->summary = $dto->getSummary();
        $dto->getContent()  &&  $model->content = $dto->getContent();
        $dto->getTargetTask()  &&  $model->target_task = $dto->getTargetTask();
        $dto->getAchievementTarget()  &&  $model->achievement_target = $dto->getAchievementTarget();
        $dto->getMeasures()  &&  $model->measures = $dto->getMeasures();
        $dto->getCommend()   &&  $model->commend = $dto->getCommend();
        $dto->getImgUrl()    &&  $model->img_url = $dto->getImgUrl();
        $dto->getStaffsInfo()  && $model->staffs_info = $dto->getStaffsInfo();
        $dto->getCheckState()  && $model->check_state = $dto->getCheckState();
        $dto->getStaffCount()  && $model->staff_count = $dto->getStaffCount();
        $dto->getFarmerCount() && $model->farmer_count = $dto->getFarmerCount();
        $dto->getAccount()    &&  $model->account = $dto->getAccount();
        $dto->getBankName()   &&  $model->bank_name = $dto->getBankName();
        $dto->getCheckTime()  &&  $model->check_time = $dto->getCheckTime();
        $dto->getVirtualStar() && $model->virtual_star = $dto->getVirtualStar();
        $dto->getVirtualBrowse() && $model->virtual_browse = $dto->getVirtualBrowse();
        $dto->getRejectReason()  && $model->reject_reason = $dto->getRejectReason();
        $dto->getIsCompetition() !== null && $model->is_competition = $dto->getIsCompetition();
        $dto->getShareTitle()  && $model->share_title = $dto->getShareTitle();
        $dto->getShareDescription() && $model->share_description = $dto->getShareDescription();
        $dto->getShareImg()    && $model->share_img = $dto->getShareImg();
        $dto->getNewType() && $model->new_type=$dto->getNewType();
        $model->save();

        if (!empty($dto->getIndustryTag())) {
            OrganizationIndustryMap::query()->where('organization_id', $dto->getId())->delete();
            $datas = [];
            foreach ($dto->getIndustryTag() as $item) {
                $data['organization_id'] = $dto->getId();
                $data['industry_id'] = $item;
                $datas[] = $data;
            }
            OrganizationIndustryMap::query()->insert($datas);
        }

        if ($dto->getUsername() || $dto->getName() || $dto->getPhoto()) {
            $adminUser = AdminUsers::query()->where('org_id', $dto->getId())->first();
            $dto->getUsername() && $adminUser->username = $dto->getUsername();
            $dto->getName()     && $adminUser->name = $dto->getName();
            $dto->getPhoto()    && $adminUser->avatar = $dto->getPhoto();
            $adminUser->save();
        }

        return $model;
    }

    public function delete(OrganizationDTO $dto)
    {
        return Organization::query()->where('id', $dto->getId())->delete();
    }

    public function export(OrganizationDTO $dto)
    {
        $statistics = ZghStatistic::query()->orderByDesc('date')->first();
        $time = data_get($statistics, 'date');

        $units = Unit::query()->where('check_status',1)->get(['id','name']);

        $builder = Organization::query()->where('check_state',2);
        $dto->getUnitId() && $builder->where('unit_id', $dto->getUnitId());
        $organizations = $builder->get(['id','name','unit_id','new_type','mobile','username','is_competition']);

        $organizationStatistics = ZghStatistic::query()->whereIn('type_id', $organizations->pluck('id'))
            ->where('type', 1)->where('date', $time)->get();

        foreach ($organizationStatistics as $item) {
            $organization = $organizations->where('id', $item->type_id)->first();
            $unit = $units->where('id', data_get($organization, 'unit_id'))->first();
            data_set($item, 'organization_id_name',data_get($organization,'name'));
            data_set($item, 'unit_id_name', data_get($unit,'name'));
            data_set($item, 'new_type_name', self::ORG[$organization->new_type]);
            data_set($item, 'mobile', data_get($organization, 'mobile'));
            data_set($item, 'username', data_get($organization, 'username'));
            data_set($item, 'competition_name', self::SPORT[$organization->is_competition]);
        }

        return $organizationStatistics->toArray();
    }

    public function setPassword(OrganizationDTO $dto)
    {
        $model = Organization::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('没有找到该企业');
        }
        $dto->getPassword() !== null  && $model->password = md5($dto->getPassword().env('JWT_KEY'));
        $model->save();

        $adminUser = AdminUsers::query()->where('org_id', $dto->getId())->first();
        $adminUser->password = md5($dto->getPassword().env('JWT_KEY'));

        return $model;
    }

    public function setVirtual(OrganizationDTO $dto)
    {
        $organization = Organization::query()->where('id', $dto->getId())->first();
        if (!$organization) {
            throw new InvalidArgumentException('企业不存在');
        }
        $organization->virtual_browse = $dto->getVirtualBrowse();
        $organization->virtual_star = $dto->getVirtualStar();
        $organization->save();

        return $organization;
    }

}