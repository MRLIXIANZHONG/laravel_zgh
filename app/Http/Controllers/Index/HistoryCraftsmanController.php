<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 11:20
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryCraftsmanController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsmans = ServiceHelper::make('Index\HistoryCraftsmanService')->getList($dto);
        if ($craftsmans instanceof LengthAwarePaginator) {
            $organizations = Organization::query()->whereIn('id', $craftsmans->getCollection()
                ->pluck('organization_id'))->get();
            $units = Unit::query()->whereIn('id', $craftsmans->getCollection()->pluck('unit_id'))->get();
            $collect = $craftsmans->getCollection()->each(function ($item) use ($organizations, $units) {
                $org = $organizations->where('id', $item->organization_id)->first();
                $unt = $units->where('id', $item->unit_id)->first();
                data_set($item, 'unit_id_name', data_get($unt, 'name', ''));
                data_set($item, 'organization_id_name', data_get($org, 'name', ''));
            });
            $craftsmans->setCollection($collect);
        } else {
            $organizations = Organization::query()->whereIn('id', $craftsmans->pluck('organization_id'))->get();
            $units = Unit::query()->whereIn('id', $craftsmans->pluck('unit_id'))->get();
            $craftsmans = $craftsmans->each(function ($item) use ($organizations, $units) {
                $org = $organizations->where('id', $item->organization_id)->first();
                $unt = $units->where('id', $item->unit_id)->first();
                data_set($item, 'unit_id_name', data_get($unt, 'name', ''));
                data_set($item, 'organization_id_name', data_get($org, 'name', ''));
            });
        }

        return response()->json(['craftsmans' => $craftsmans, 'code' => 200]);
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('history_craftsman'));
        $craftsman = ServiceHelper::make('Index\HistoryCraftsmanService')->getDetail($dto);

        $organization = Organization::query()->where('id', $craftsman->organization_id)->first();
        $unit = Unit::query()->where('id', $craftsman->unit_id)->first();
        data_set($craftsman, 'unit_id_name', data_get($organization, 'name'));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name'));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name'));

        return response()->json(['data' => $craftsman, 'code' => 200]);
    }
}