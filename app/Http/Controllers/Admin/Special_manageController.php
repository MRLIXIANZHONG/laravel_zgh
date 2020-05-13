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
use App\DTO\Special_manageDTO;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\Special_manageRequest;
use App\Models\Banner;

class Special_manageController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**获取专题信息
     * @param Special_manageRequest $request
     * @return Special_managelist
     */
    public function index(Special_manageRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Special_manageDTO::class, $request);
        $data = ServiceHelper::make('Admin\Special_manageService')->getList($dto);
        return view('special_manage.list', ['specialList' => $data]);
    }

    /**
     * 专题详情页
     **/
    public function showDetail($id)
    {
        $request = ServiceHelper::make('Admin\Special_manageService')->getDetail(request(id));
        return view('special_manage.detail', ['special' => $request]);
    }

    /**
     * 编辑专题信息
     * @param id
     * @return mixed
     */
    public function show($id)
    {
        $request = ServiceHelper::make('Admin\Special_manageService')->getDetail($id);
        return view('special_manage.edit', ['special' => $request]);
    }

    /**
     * 更新专题信息
     * @param Special_manageRequest $request
     * @return mixed
     */
    public function store(Special_manageRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Special_manageDTO::class, $request);
        return ServiceHelper::make('Admin\Special_manageService')->saveSpecial($dto);
    }

}