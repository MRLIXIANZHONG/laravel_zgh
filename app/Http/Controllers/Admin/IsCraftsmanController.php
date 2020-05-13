<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/5/8
 * Time: 15:02
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\CraftsmanExtend;
use App\Models\Industry;
use App\Models\Organization;
use App\Models\OrganizationIndustryMap;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;

class IsCraftsmanController extends BaseController
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
        $search = [
            'unit_id'  =>   $dto->getUnitId(),
            'username'  =>  $dto->getUsername(),
            'mobile'    =>  $dto->getMobile(),
        ];
        $dto->setIsCraftsman(2);
        $craftsmans = ServiceHelper::make('Admin\IsCraftsmanService')->getList($dto);

        if ($craftsmans instanceof LengthAwarePaginator) {
            $units = Unit::query()->whereIn('id', $craftsmans->getCollection()->pluck('unit_id'))->get();
            $allUnit = Unit::query()->where('check_status', 1)->get(['id','name']);
            $organizations = Organization::query()
                ->whereIn('id', $craftsmans->getCollection()->pluck('organization_id'))->get();

            $collect = $craftsmans->each(function ($item) use ($units, $organizations) {
                $unit = $units->where('id',$item->unit_id)->first();
                $organization = $organizations->where('id',$item->organization_id)->first();

                data_set($item, 'unit_id_name', data_get($unit,'name', ''));
                data_set($item, 'organization_id_name', data_get($organization,'name', ''));
                data_set($item, 'unit_check', data_get($unit, 'username', '') );
                data_set($item, 'organization_check', data_get($organization, 'username', '') );
                data_set($item, 'check_status_name', $this->checkStatus[$item->check_status]);
                data_set($item, 'super_star', $item->star + $item->virtual_star);
                data_set($item, 'super_browse', $item->browse_amount + $item->virtual_browse);
            });
        }
        $craftsmans->setCollection($collect);
        $role = $this->admininfo['roles'][0]['id'];

        return view('is_craftsman.index', compact(['craftsmans', 'role', 'search', 'allUnit']));
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('is_craftsman'));
        $craftsman = ServiceHelper::make('Admin\IsCraftsmanService')->getDetail($dto);

        $unit = ServiceHelper::make('Admin\UnitService')->getDetail(new UnitDTO([
            'id' => $craftsman->unit_id,
        ]));

        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail(new OrganizationDTO([
            'id' => $craftsman->organization_id,
        ]));

        $industryIds = OrganizationIndustryMap::query()->where('organization_id', $craftsman->organization_id)
            ->pluck('industry_id');
        $industryTags = Industry::query()->whereIn('id', $industryIds)->get();

        $craftsmanHonor = CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
            ->where('type', 2)->get();

        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);

        if($craftsman->image !== null) {
            $imgArr = explode(',', $craftsman->image);
            data_set($craftsman, 'imgArr', collect($imgArr));
        }
        if($craftsman->video !== null) {
            $videoArr = explode(',', $craftsman->video);
            data_set($craftsman, 'videoArr', collect($videoArr));
        }

        data_set($craftsman, 'industries', $industryTags);
        data_set($craftsman, 'unit_id_name', data_get($unit, 'name', ''));
        data_set($craftsman, 'unit_id_username', data_get($unit, 'username', ''));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name', ''));
        data_set($craftsman, 'organization_id_username', data_get($organization, 'username', ''));
        data_set($craftsman, 'super_star', $craftsman->star + $craftsman->virtual_star);
        data_set($craftsman, 'super_browse', $craftsman->browse_amount + $craftsman->virtual_browse);

        $check_status = $this->checkStatus;
        $role = $this->admininfo['roles'][0]['id'];
        return view('is_craftsman.show', compact(['craftsman', 'check_status','role']));
    }

    public function create(CraftsmanRequest $request)
    {
        $units = Organization::query()->where('check_state', 2)->get();
        return view('is_craftsman.create');
    }

    public function isCraftsmanStore(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);

        $craftsman = ServiceHelper::make('Admin\IsCraftsmanService')->store($dto);

        return response()->json(['message' => '新增成功', 'code' => 1000]);

    }

    public function edit(CraftsmanRequest $request)
    {
        $dto = new CraftsmanDTO([ 'id' => $request->route('is_craftsman')]);
        $craftsman = ServiceHelper::make('Admin\IsCraftsmanService')->getDetail($dto);

//        $industryIds = OrganizationIndustryMap::query()->where('organization_id', $craftsman->organization_id)
//            ->pluck('industry_id');
//        $industryTags = Industry::query()->whereIn('id', $industryIds)->get();

//        if($craftsman->image !== null) {
//            $imgArr = explode(',', $craftsman->image);
//            data_set($craftsman, 'image', collect($imgArr));
//        }
//        if($craftsman->video !== null) {
//            $videoArr = explode(',', $craftsman->video);
//            data_set($craftsman, 'video', collect($videoArr));
//        }
        $craftsmanHonor = CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
            ->where('type', 2)->get();

        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);
        $role = $this->admininfo['roles'][0]['id'];

        return view('is_craftsman.edit', compact(['craftsman', 'role']));
    }

    public function isCraftsmanUpdate(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('is_craftsman'));
        $craftsman = ServiceHelper::make('Admin\IsCraftsmanService')->update($dto);

        return response()->json(['message' => '修改成功', 'code' => 1000]);
    }

    public function destroy(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('is_craftsman'));
        $result = ServiceHelper::make('Admin\IsCraftsmanService')->delete($dto);

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

    public function export(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setIsCraftsman(2);
        $craftsmans = ServiceHelper::make('Admin\IsCraftsmanService')->export($dto);

        $header = [
            ['序号', 'id'],
            ['姓名', 'username'],
            ['企业', 'organization_id_name'],
            ['企业类型', 'new_type_name'],
            ['行业', 'industries_name'],
            ['工会', 'unit_id_name'],
            ['企业联系人', 'organization_id_username'],
            ['企业联系电话', 'organization_id_mobile'],
            ['审核状态', 'check_status_name'],
            ['获奖状态', 'hj_status'],
            ['浏览量', 'browse_amount'],
            ['点赞量', 'star'],
            ['专家投票', 'score'],
        ];

        $excel = [$header, json_decode(json_encode($craftsmans), true), '巴渝工匠列表'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }

}