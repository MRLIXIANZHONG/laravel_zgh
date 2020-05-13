<?php


namespace App\Services\Admin;


use App\DTO\BannerDTO;
use App\Models\Banner;
use App\Models\News;
use App\Services\Service;

class BannerService extends Service
{
    /**
     * 获取banner列表
     * @param BannerDTO $nomineeDto
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList(BannerDTO $bannerDto)
    {
        $builder = Banner::query();
        $bannerDto->getSystemVersion() && $builder->where('system_version',$bannerDto->getSystemVersion());

        return $builder->orderByDesc('is_use')->paginate(15);
    }

    /**
     * 获取banner
     * @param int $id
     * @return 优秀个人荣誉详情
     */
    public function getDetail(int $id)
    {
        return Banner::query()->find($id);
    }

    /**
     * 新增 修改 banner
     * @param BannerDTO $nomineeDto
     * @return string
     */
    public function saveBanner(BannerDTO $bannerDto)
    {
        if ($bannerDto->getId() == 0) {
            $banner = new Banner();
        } else {
            $banner = Banner::query()->find($bannerDto->getId());
        }

        if ($bannerDto->getImgUrl() == null) {
            return ['code' => '1001', 'msg' => '请选择一个图片'];
        }
        //如果当前这个使用 其他的都改成不适用 不改变自己
        if ($bannerDto->getIsUse() == 1) {
            Banner::query()->where('system_version',$bannerDto->getSystemVersion())->where('id','<>',$bannerDto->getId())->update(['is_use' => 0]);

        }
        $banner->system_version = $bannerDto->getSystemVersion();
        $banner->img_url = $bannerDto->getImgUrl();
        $banner->is_use = $bannerDto->getIsUse();

        $result = $banner->save();
        if ($result)
            return ['code' => '1000', 'msg' => '操作成功'];
        else
            return ['code' => '-1', 'msg' => '操作失败'];
    }


    /**
     * 删除banner
     * @param int $id
     * @return string
     */
    public function destroy(BannerDTO $bannerDto)
    {
        $banner = Banner::query()->find($bannerDto->getId());
        if ($banner->is_use == 1) {
            return ['code' => '-1', 'msg' => '使用中的banner 不能删除'];
        }
        $result = Banner::destroy($bannerDto->getId());
        if ($result)
            return ['code' => '1000', 'msg' => '操作成功'];
        else
            return ['code' => '-1', 'msg' => '操作失败'];
    }


    /**
     * 修改banner
     * @param int $id
     * @return string
     */
    public function update(BannerDTO $bannerDto)
    {

        //只能一张使用 其他都禁用
        $result = Banner::where('id', $bannerDto->getId())->update(['is_use' => 1]);
        $result = Banner::where('id', '!=', $bannerDto->getId())->update(['is_use' => 0]);
        if ($result)
            return ['code' => '1000', 'msg' => '操作成功'];
        else
            return ['code' => '-1', 'msg' => '操作失败'];
    }


}