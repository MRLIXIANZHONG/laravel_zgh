<?php


namespace App\Services\Admin;


use App\DTO\BannerDTO;
use App\DTO\Special_manageDTO;
use App\Models\Special_manage;
use App\Services\Service;

class Special_manageService extends Service
{
    /**
     * 获取banner列表
     * @param BannerDTO $nomineeDto
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList(Special_manageDTO $specialDto)
    {
        $builder = Special_manage::query();
        $specialDto->getSystemVersion() && $builder->where('system_version', $specialDto->getSystemVersion());
        return $builder->paginate(15);
    }

    /**
     *  专题管理
     * @param int $id
     * @return
     */
    public function getDetail(int $id)
    {
        return Special_manage::query()->find($id);
    }

    /**
     * 新增 修改 专题管理
     * @param Special_manageDTO $specialDto
     * @return json
     */
    public function saveSpecial(Special_manageDTO $specialDto)
    {
        $special = Special_manage::query()->find($specialDto->getId());
        if (empty( $specialDto->getBanner())){
            return ['code' => '-1', 'msg' => '请选择一个Banner图片'];
        }
//        if (empty( $specialDto->getTitleImg())){
//            return ['code' => '-1', 'msg' => '请选择一个专题头像'];
//        }
        $special->title = $specialDto->getTitle();
        $special->mark = $specialDto->getMark();
        $special->banner = $specialDto->getBanner();
        $special->title_img = $specialDto->getTitleImg();
        $special->spirit = $specialDto->getSpirit();
        $special->sponsor_unit = $specialDto->getSponsorUnit();
        $special->record_numbe = $specialDto->getRecordNumbe();
        $special->address = $specialDto->getAddress();
        $special->zip_code = $specialDto->getZipCode();
        $special->copyright_information = $specialDto->getCopyrightInformation();
        $special->copyright_information = $specialDto->getCopyrightInformation();
        $special->system_version = $specialDto->getSystemVersion();
        $result = $special->save();
        if ($result)
            return ['code' => '1000', 'msg' => '操作成功'];
        else
            return ['code' => '-1', 'msg' => '操作失败'];
    }
}