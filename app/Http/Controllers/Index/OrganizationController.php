<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 15:05
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\NomineeDTO;
use App\DTO\OrganizationDTO;
use App\DTO\OrganizationsWuxiaoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationRequest;
use App\Models\Organization;
use App\Models\OrganizationsPlan;
use DB;

class OrganizationController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $organizations = ServiceHelper::make('Index\OrganizationService')->getList($dto);

        return response()->json(['organizations' => $organizations, 'code' => 200]);
    }

    public function show(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $organization = ServiceHelper::make('Index\OrganizationService')->getDetail($dto);

        return response()->json(['data' => $organization, 'code' => 200]);
    }

    //获取参赛企业
    public function getOrg(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $organization = ServiceHelper::make('Index\OrganizationService')->getJoinOrgPag($dto->getUnitId(), $dto->getPage(), $dto->getPageSize());

        return response()->json(['data' => $organization, 'code' => 200]);
    }

    public function getSportList()
    {
        $organizations = Organization::query()->where('is_competition', 1)
            ->where('check_state', 2)->get(['id', 'name']);
        $organizationIds = $organizations->pluck('id')->toArray();

        $nominee = ServiceHelper::make('Index\NomineeService')->getList(new NomineeDTO([
            'organization_ids' => $organizationIds,
            'page_size' => 10,
        ]))->getCollection();
        $nominee = $nominee->each(function ($item) {
            if (strpos('http', data_get($item, 'staff_img')) === false) {
                data_set($item, 'staff_img', env('APP_URL') . $item->staff_img);
            }
        });

        $wuXiao = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList(new OrganizationsWuxiaoDTO([
            'organization_ids' => $organizationIds,
            'page_size' => 6,
        ]))->getCollection();

        $wuXiao = $wuXiao->each(function ($item) use ($organizations) {
            $organization = $organizations->where('id', $item->organization_id)->first();
            data_set($item, 'organization_id_name', data_get($organization, 'name', ''));
            if (strpos('http', data_get($item, 'cover')) === false) {
                data_set($item, 'cover', env('APP_URL') . $item->cover);
            }
        });

        $organizationPlans = OrganizationsPlan::query()->where('check_state', 1)
            ->whereIn('organization_id', $organizations)->get();
        $organizationPlans = $organizationPlans->each(function ($item) use ($organizations) {
            $organization = $organizations->where('id', $item->organization_id)->first();
            data_set($item, 'organization_id_name', data_get($organization, 'name', ''));
            if (strpos('http', data_get($item, 'share_img_url')) === false) {
                data_set($item, 'share_img_url', env('APP_URL') . $item->share_img_url);
            }
        });

        return response()->json(['nominee' => $nominee, 'wuXiao' => $wuXiao, 'organizationPlans' => $organizationPlans]);
    }

    /**
     * 获取企业详情
     * @param OrganizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailById($orgid)
    {
        $organization = ServiceHelper::make('Index\OrganizationService')->getOrgDetailById($orgid);

        return response()->json(['data' => $organization, 'code' => 200]);

    }

}