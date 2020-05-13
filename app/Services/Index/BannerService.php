<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Index;


use App\DTO\BannerDTO;
use App\Models\Banner;
use App\Services\Service;

class BannerService extends Service
{

    /**
    获取banner 图片
     */
    public function getBanner(BannerDTO $dto)
    {
        $builder = Banner::query();
        $builder->where('system_version', $dto->getSystemVersion());//获取当前版本的数据
        $builder->where('is_use', 1);//获取使用中的banner 图片
        return $builder->select(["img_url"])->get();
    }
}