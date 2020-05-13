<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 上午 11:58
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\BannerDTO;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;

class BannerController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**获取banner列表
     * @param BannerRequest $request
     * @return mixed
     */
    public function index(BannerRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(BannerDTO::class, $request);
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $data = ServiceHelper::make('Admin\BannerService')->getList($dto);
        return view('banner.list', ['bannerList' => $data]);
    }

    /**
     * 编辑banner
     * @param BannerRequest $request
     * @return mixed
     */
    public function show($id)
    {
        if ($id == '0') {
            $request = new Banner();
        } else {
            $request = ServiceHelper::make('Admin\BannerService')->getDetail($id);
        }
        return view('banner.edit', ['banner' => $request]);
    }

    /**
     * 更新
     * @param BannerRequest $request
     * @return mixed
     */
    public function store(BannerRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(BannerDTO::class, $request);
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        return ServiceHelper::make('Admin\BannerService')->saveBanner($dto);
    }

    //删除
    public function destroy(BannerRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(BannerDTO::class, $request);
        return $request = ServiceHelper::make('Admin\BannerService')->destroy($dto);
    }

    //修改
    public function update(BannerRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(BannerDTO::class, $request);
        return $request = ServiceHelper::make('Admin\BannerService')->update($dto);
    }
}