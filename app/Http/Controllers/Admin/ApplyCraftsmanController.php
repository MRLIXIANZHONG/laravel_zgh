<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/12
 * Time: 17:26
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplyCraftsmanController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setIsCraftsman(2);
        $craftsmans = ServiceHelper::make('Admin\CraftsmanService')->getList($dto);

        if ($craftsmans instanceof LengthAwarePaginator) {
            $units = Unit::query()->whereIn('id', $craftsmans->getCollection()->pluck('unit_id'))->get();
            $organizations = Organization::query()
                ->whereIn('id', $craftsmans->getCollection()->pluck('organization_id'))->get();

            $collect = $craftsmans->each(function ($item) use ($units, $organizations) {
                $unit = $units->where('id',$item->unit_id)->first();
                $organization = $organizations->where('id',$item->organization_id)->first();
                data_set($craftsmans, 'unit_id_name', data_get($units,'name', ''));
                data_set($craftsmans, 'organization_id_name', data_get($units,'name', ''));
                data_set($item, 'unit_check', data_get($unit, 'username', '') );
                data_set($item, 'organization_check', data_get($organization, 'username', '') );
                data_set($item, 'check_status_name', $this->checkStatus[$item->check_status]);
            });
        }

        return view('apply_craftsman.index', compact('craftsmans'));
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('apply_craftsman'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);
        data_set($craftsman, 'check_status_name', $this->checkStatus[$craftsman->check_status]);

        return view('apply_craftsman.show', compact('craftsman'));
    }

    public function create()
    {
        return view('apply_craftsman.edit');
    }

    public function store(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->store($dto);

        return redirect('admin/apply_craftsmans')->with('success', '更新成功！');
    }

    public function edit(CraftsmanRequest $request)
    {
        $dto = new CraftsmanDTO([ 'id' => $request->route('apply_craftsman')]);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

        return view('apply_craftsman.edit', compact('craftsman'));
    }

    public function update(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('apply_craftsman'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->update($dto);

        return redirect('admin/apply_craftsmans')->with('success', '修改成功');
    }

    public function destroy(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('apply_craftsman'));
        $result = ServiceHelper::make('Admin\CraftsmanService')->delete($dto);

        return $result;
    }
}