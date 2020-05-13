<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/11
 * Time: 21:13
 */

namespace App\Services\Admin;


use App\DTO\CraftsmanDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\CaseSchemes;
use App\Models\Craftsman;
use App\Models\CraftsmanExtend;
use App\Models\Organization;
use App\Models\Unit;
use App\Services\Service;
use DB;

class CraftsmanService extends Service
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

    const HUJ = [
        0   =>  '未推选',
        1   =>  '候选',
        2   =>  '工匠',
    ];

    public function getList(CraftsmanDTO $dto)
    {
        $builder = Craftsman::query();
        $dto->getUsername()  &&  $builder->where('username', 'like', '%'.$dto->getUsername().'%');
        $dto->getMobile()    &&  $builder->where('mobile', 'like', '%'.$dto->getMobile().'%');
        $dto->getUnitName()  &&  $builder->where('unit_name', 'like', '%'.$dto->getUnitName().'%');
        $dto->getOrganizationId()  &&  $builder->where('organization_id', $dto->getOrganizationId());
        $dto->getUnitId()  &&  $builder->where('unit_id', $dto->getUnitId());
        $dto->getActiveIds() && $builder->whereIn('active_id', $dto->getActiveIds());
//        $dto->getFrom()      &&  $builder->where('from', $dto->getFrom());
        $dto->getIsCraftsman() !== null && $builder->where('is_craftsman', $dto->getIsCraftsman());
        !empty($dto->getIsCraftsmans()) && $builder->whereIn('is_craftsman', $dto->getIsCraftsmans());
        !empty($dto->getCheckStatus()) && $builder->whereIn('check_status', $dto->getCheckStatus());

        //$craftsmans = $builder->orderByDesc('browse_total')->orderByDesc('star_total')
        $craftsmans = $builder->orderByDesc('updated_at')
            ->paginate($dto->getPageSize())->appends(request()->all());

        return $craftsmans;
    }

    public function getCandidateList(CraftsmanDTO $dto)
    {
        $builder = Craftsman::query();
        $dto->getUsername()  &&  $builder->where('username', 'like', '%'.$dto->getUsername().'%');
        $dto->getMobile()    &&  $builder->where('mobile', 'like', '%'.$dto->getMobile().'%');
        $dto->getUnitName()  &&  $builder->where('unit_name', 'like', '%'.$dto->getUnitName().'%');
        $dto->getOrganizationId()  &&  $builder->where('organization_id', $dto->getOrganizationId());
        $dto->getUnitId()  &&  $builder->where('unit_id', $dto->getUnitId());
        $dto->getActiveIds() && $builder->whereIn('active_id', $dto->getActiveIds());
        $dto->getIsCraftsman() !== null && $builder->where('is_craftsman', $dto->getIsCraftsman());
        !empty($dto->getIsCraftsmans()) && $builder->whereIn('is_craftsman', $dto->getIsCraftsmans());
        !empty($dto->getCheckStatus()) && $builder->whereIn('check_status', $dto->getCheckStatus());

        $craftsmans = $builder->orderByDesc('browse_total')->orderByDesc('star_total')
            ->paginate($dto->getPageSize())->appends(request()->all());

        return $craftsmans;
    }

    public function getDetail(CraftsmanDTO $dto)
    {
        $model = Craftsman::query()->find($dto->getId());

        if (!$model) {
            throw new NotFoundException('您所查看的工匠未找到');
        }

        return $model;
    }

    public function store(CraftsmanDTO $dto)
    {
        $info = Craftsman::query()->where('mobile', $dto->getMobile())->first();
        if ($info) {
            throw new InvalidArgumentException('手机号已经存在');
        }

        $craftsman = new Craftsman();
        $dto->getUsername()  &&  $craftsman->username = $dto->getUsername();
        $dto->getPhoto()     &&  $craftsman->photo = $dto->getPhoto();
        $dto->getMobile()    &&  $craftsman->mobile = $dto->getMobile();
        $dto->getUnitId()   &&  $craftsman->unit_id = $dto->getUnitId();
        $dto->getOrganizationId() && $craftsman->organization_id = $dto->getOrganizationId();
        $dto->getUnitName()  &&  $craftsman->unit_name = $dto->getUnitName();
        $dto->getBankCard()  &&  $craftsman->bank_card = $dto->getBankCard();
        $dto->getBankUsername()  &&  $craftsman->bank_username = $dto->getBankUsername();
        $dto->getBankName()  &&  $craftsman->bank_name = $dto->getBankName();
        //$dto->getFrom()      &&  $craftsman->from = $dto->getFrom();
        $dto->getVideo()     &&  $craftsman->video = $dto->getVideo();
        $dto->getImage()     &&  $craftsman->image = $dto->getImage();
        $dto->getHonor()     &&  $craftsman->honor = $dto->getHonor();
        $dto->getDescribe()  &&  $craftsman->describe = $dto->getDescribe();
        $dto->getActiveId()  &&  $craftsman->active_id = $dto->getActiveId();
        $dto->getShareTitle()  &&  $craftsman->share_title = $dto->getShareTitle();
        $dto->getSharePhoto()  &&  $craftsman->share_photo = $dto->getPhoto();
        $dto->getShareDescription()  &&  $craftsman->share_description = $dto->getShareDescription();
        $dto->getVideoCover()  &&  $craftsman->video_cover = $dto->getVideoCover();
        $dto->getIsPartyMember() !== null && $craftsman->is_party_member = $dto->getIsPartyMember();
        $dto->getBankPhoto()   &&   $craftsman->bank_photo = $dto->getBankPhoto();
        $craftsman->save();

        return $craftsman;
    }

    public function update(CraftsmanDTO $dto)
    {
        $model = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('未找到资源');
        }

        $dto->getUsername()  &&  $model->username = $dto->getUsername();
        $dto->getPhoto()     &&  $model->photo = $dto->getPhoto();
        $dto->getUnitsId()   &&  $model->unit_id = $dto->getUnitsId();
        $dto->getOrganizationId() && $model->organization_id = $dto->getOrganizationId();
        $dto->getMobile()    &&  $model->mobile = $dto->getMobile();
        $dto->getUnitName()  &&  $model->unit_name = $dto->getUnitName();
        $dto->getBankCard()  &&  $model->bank_card = $dto->getBankCard();
        $dto->getBankUsername()  &&  $model->bank_username = $dto->getBankUsername();
        $dto->getBankName()  &&  $model->bank_name = $dto->getBankName();
        $dto->getFrom()      &&  $model->from = $dto->getFrom();
        $dto->getVideo()     &&  $model->video = $dto->getVideo();
        $dto->getImage()     &&  $model->image = $dto->getImage();
        $dto->getHonor()     &&  $model->honor = $dto->getHonor();
        $dto->getDescribe()  &&  $model->describe = $dto->getDescribe();
        $dto->getRejectReason()  && $model->reject_reason = $dto->getRejectReason();
        $dto->getIsCraftsman() && $model->is_craftsman = $dto->getIsCraftsman();
        !empty($dto->getCheckStatus()) && $model->check_status = $dto->getCheckStatus()[0];
        $dto->getShareTitle()  &&  $model->share_title = $dto->getShareTitle();
        $dto->getSharePhoto()  &&  $model->share_photo = $dto->getPhoto();
        $dto->getShareDescription()  &&  $model->share_description = $dto->getShareDescription();
        $dto->getVideoCover()  &&  $model->video_cover = $dto->getVideoCover();
        $dto->getIsPartyMember() !== null && $model->is_party_member = $dto->getIsPartyMember();
        $dto->getBankPhoto()   &&   $model->bank_photo = $dto->getBankPhoto();
        $model->save();

        return $model;
    }

    public function delete(CraftsmanDTO $dto)
    {
        try {
            DB::beginTransaction();
            $craftsman = Craftsman::query()->where('id', $dto->getId())->first();
            if (!$craftsman) {
                throw new NotFoundException('工匠未找到');
            }
            $craftsman->delete();

            CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
                ->where('type', 2)->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
        }

        return true;
    }

    public function export(CraftsmanDTO $dto)
    {
        $builder = Craftsman::query();
        $dto->getIsCraftsman() && $builder->whereIn('is_craftsman', [$dto->getIsCraftsman()]);
        $craftsmans = $builder->get();

        $units = Unit::query()->whereIn('id', $craftsmans->pluck('unit_id'))->get(['id','name']);
        $organizations = Organization::query()->whereIn('id', $craftsmans->pluck('organization_id'))
            ->get(['id','new_type','username','mobile']);

        $orgIds = implode(',', $organizations->pluck('id')->toArray());
        $orgIds = $orgIds != '' ?: 0;
        $industries = collect(DB::select("select `oim`.`organization_id`,`it`.`industry_name` from `organization_industry_maps` as `oim` left join 
        `industry_tag` as `it` on `oim`.`industry_id` = `it`.`id` where `oim`.`organization_id` in ($orgIds)"));

        foreach ($craftsmans as $craftsman) {
            $unit = $units->where('id', $craftsman->unit_id)->first();
            $organization = $organizations->where('id', $craftsman->organization_id)->first();
            $industry = $industries->where('organization_id', $craftsman->organization_id);
            if ($industry->isNotEmpty()) {
                $indusStr = implode(',', $industry->pluck('industry_name')->toArray());
            } else {
                $indusStr = '';
            }
            data_set($craftsman, 'organization_id_name', data_get($organization, 'name', ''));
            data_set($craftsman, 'unit_id_name', data_get($unit, 'name', ''));
            data_set($craftsman, 'industries_name', $indusStr);
            data_set($craftsman, 'organization_id_username', data_get($organization, 'username', ''));
            data_set($craftsman, 'organization_id_mobile', data_get($organization, 'mobile', ''));

            if ($organization === null) {
                data_set($craftsman, 'new_type_name', '未设置');
            } else {
                data_set($craftsman, 'new_type_name', isset(self::ORG[$organization->new_type]) ? self::ORG[$organization->new_type] : '未设置');
            }

            data_set($craftsman, 'hj_status', self::HUJ[$craftsman->is_craftsman]);
            data_set($craftsman, 'check_status_name', $this->checkStatus[$craftsman->check_status]);
        }

        return $craftsmans->toArray();
    }

    public function setVirtual(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }
        $dto->getVirtualStar() && $craftsman->virtual_star = $dto->getVirtualStar();
        $dto->getVirtualBrowse() && $craftsman->virtual_browse = $dto->getVirtualBrowse();
        $craftsman->save();

        return $craftsman;
    }

    public function pull(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        $craftsman->check_status = $dto->getCheckStatus()[0];
        $craftsman->is_craftsman = $dto->getIsCraftsman();
        $craftsman->active_id = $dto->getActiveId();
        $craftsman->save();

        return $craftsman;
    }

    public function checkCraftsman(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        $craftsman->check_status = $dto->getCheckStatus()[0];
        $craftsman->save();

        return $craftsman;
    }

    public function rejectCraftsman(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        if($craftsman->is_craftsman === 2) {
            throw new InvalidArgumentException('已经获奖巴渝工匠，不能驳回');
        }

        $craftsman->check_status = $dto->getCheckStatus()[0];
        $craftsman->save();

        return $craftsman;
    }

    public function setCraftsman(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        if ($craftsman->check_status < 9) {
            throw new InvalidArgumentException('总工会审核未通过，暂不能设置为工匠');
        }

        $craftsman->is_craftsman = $dto->getIsCraftsman();
        $craftsman->save();

        return $craftsman;
    }

    public function expertScore(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        $craftsman->score = $dto->getScore();
        $craftsman->save();

        return $craftsman;
    }

    public function storeCraftsmanHonor(CraftsmanDTO $dto)
    {
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();

        if (!$craftsman) {
            throw new InvalidArgumentException('该工匠未找到');
        }

        $craftsmanExtend = new CraftsmanExtend();
        $craftsmanExtend->type = 2;
        $craftsmanExtend->craftsman_id = $dto->getId();
        $dto->getHonorName()  &&  $craftsmanExtend->honor_name = $dto->getHonorName();
        $dto->getHonorDescription()  &&  $craftsmanExtend->honor_description = $dto->getHonorDescription();
        $dto->getHonorTime()  &&  $craftsmanExtend->honor_time = $dto->getHonorTime();
        $dto->getHonorImage()  &&  $craftsmanExtend->honor_image = $dto->getHonorImage();
        $craftsmanExtend->save();

        return $craftsmanExtend;
    }
}