<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/12
 * Time: 23:04
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;

class HistoryCraftsmanController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsmans = ServiceHelper::make('Admin\HistoryCraftsmanService')->getList($dto);

        $search = [
            'username'  =>  $dto->getUsername(),
            'years' =>  $dto->getYears(),
        ];
        $user = $this->admininfo;

        return view('history_craftsman.index', compact(['craftsmans', 'search', 'user']));
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('history_craftsman'));
        $craftsman = ServiceHelper::make('Admin\HistoryCraftsmanService')->getDetail($dto);

        return view('history_craftsman.show', compact('craftsman'));
    }

    public function create()
    {
        return view('history_craftsman.create');
    }

    public function store(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsman = ServiceHelper::make('Admin\HistoryCraftsmanService')->store($dto);

        return response()->json(['message' => '添加成功', 'code' => 1000]);
    }

    public function edit(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('history_craftsman'));
        $craftsman = ServiceHelper::make('Admin\HistoryCraftsmanService')->getDetail($dto);

        return view('history_craftsman.edit', compact('craftsman'));
    }

    public function update(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('history_craftsman'));
        $craftsman = ServiceHelper::make('Admin\HistoryCraftsmanService')->update($dto);

        return response()->json(['message' => '修改成功', 'code' => 1000]);
    }

    public function destroy(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('history_craftsman'));
        $result = ServiceHelper::make('Admin\HistoryCraftsmanService')->delete($dto);

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

}