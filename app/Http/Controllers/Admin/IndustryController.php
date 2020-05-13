<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/8
 * Time: 15:22
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\IndustryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndustryRequest;

class IndustryController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $industries = ServiceHelper::make('Admin\IndustryService')->getList($dto);

        return view('industries.index', compact('industries'));
    }

    public function create()
    {
        return view('industries.edit');
    }

    public function show(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $dto->setId($request->route('industry'));
        $response = ServiceHelper::make('Admin\IndustryService')->getDetail($dto);

        return $response;
    }

    public function store(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $industry = ServiceHelper::make('Admin\IndustryService')->store($dto);

        return redirect('admin/industries')->with('success', '更新成功！');
    }

    public function edit(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $dto->setId($request->route('industry'));
        $industry = ServiceHelper::make('Admin\IndustryService')->getDetail($dto);

        return view('industries.edit', compact('industry'));
    }

    public function update(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $dto->setId($request->route('industry'));
        $industry = ServiceHelper::make('Admin\IndustryService')->update($dto);

        return redirect('admin/industries')->with('success', '更新成功！');
    }

    public function destroy(IndustryRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(IndustryDTO::class, $request);
        $dto->setId($request->route('industry'));
        $result = ServiceHelper::make('Admin\IndustryService')->delete($dto);

        return $result;
    }
}