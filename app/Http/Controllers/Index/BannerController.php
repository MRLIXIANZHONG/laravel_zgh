<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 10:41
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\BannerDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;

class BannerController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     获取banner 图片
     */
    public function getBanner(BannerRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(BannerDTO::class, $request);
        $response = ServiceHelper::make('Index\BannerService')->getBanner($dto);
        try {
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }
}