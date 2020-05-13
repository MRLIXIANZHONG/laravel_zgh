<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/11
 * Time: 21:12
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\CaseSchemes;
use App\Models\Craftsman;
use App\Models\CraftsmanExtend;
use App\Models\Industry;
use App\Models\Organization;
use App\Models\OrganizationIndustryMap;
use App\Models\WechatConfig;
use App\Services\Jssdk;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class CraftsmanController extends BaseController
{
    protected $requestHelper;

    protected $permissionStatus;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
        if ($this->admininfo['roles'][0]['id'] == 1) {
            $this->permissionStatus = $this->admin;
        } elseif ($this->admininfo['roles'][0]['id'] == 4) {
            $this->permissionStatus = $this->sz;
        } elseif ($this->admininfo['roles'][0]['id'] == 2) {
            $this->permissionStatus = $this->gh;
        } elseif ($this->admininfo['roles'][0]['id'] == 3) {
            $this->permissionStatus = $this->qy;
            $info = Organization::query()->where('id',$this->admininfo['org_id'])->first();
            if ($info == null || $info->unit_id == 0) {
                throw new InvalidArgumentException('请绑定上级工会');
            }
        } elseif ($this->admininfo['roles'][0]['id'] == 6) {
            $this->permissionStatus = $this->sz;
        } elseif ($this->admininfo['roles'][0]['id'] == 5) {
            $this->permissionStatus = $this->pw;
        } else {
            $this->permissionStatus = [404];
        }
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $search = [
            'username'  => $dto->getUsername(),
            'is_craftsman' => $dto->getIsCraftsman(),
            'mobile'    =>  $dto->getMobile(),
        ];
        //$dto->setCheckStatus($this->permissionStatus);
        if ($this->admininfo['roles'][0]['id'] == 3) {
            $dto->setOrganizationId($this->admininfo['org_id']);
        } elseif ($this->admininfo['roles'][0]['id'] == 2) {
            $dto->setUnitId($this->admininfo['units_id']);
        }

        $craftsmans = ServiceHelper::make('Admin\CraftsmanService')->getList($dto);

        if ($craftsmans instanceof LengthAwarePaginator) {
            $collect = $craftsmans->getCollection();
            $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
                'ids'  =>  $craftsmans->getCollection()->pluck('unit_id')->toArray(),
                'location' => true,
            ]));

            if (!empty($craftsmans->getCollection()->pluck('organization_id')->toArray())) {
                $organizations = ServiceHelper::make('Admin\OrganizationService')->getList(new OrganizationDTO([
                    'ids'  =>  $craftsmans->getCollection()->pluck('organization_id')->toArray(),
                    'location' => true,
                ]));
            } else {
                $organizations = collect();
            }

            $collect = $collect->each(function ($item) use ($units, $organizations) {
                $unit = $units->where('id', $item->unit_id)->first();
                $organization = $organizations->where('id', $item->organization_id)->first();
                data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
                data_set($item, 'organization_id_name', data_get($organization, 'name', ''));
                data_set($item, 'organization_check', data_get($organization, 'username', '') );
                data_set($item, 'unit_check', data_get($unit, 'username', '') );
                data_set($item, 'check_status_name', $this->checkStatus[$item->check_status]);
                data_set($item, 'super_star', $item->star + $item->virtual_star);
                data_set($item, 'super_browse', $item->browse_amount + $item->virtual_browse);
            });
        }
        $craftsmans->setCollection($collect);
        $role = $this->admininfo['roles'][0]['id'];

        return view('craftsman.index', compact(['craftsmans', 'role','search']));
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

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
        return view('craftsman.show', compact(['craftsman', 'check_status','role']));
    }

    public function create()
    {
        return view('craftsman.create');
    }

    public function storeCraftsman(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);

        if ($this->admininfo['org_id'] != null) {
            $dto->setOrganizationId($this->admininfo['org_id']);
        }
        if ($this->admininfo['units_id'] != null) {
            $dto->setUnitId($this->admininfo['units_id']);
        }

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->store($dto);

        return response()->json(['message' => '新增成功', 'code' => 1000]);
    }

    public function edit(CraftsmanRequest $request)
    {
        $dto = new CraftsmanDTO([ 'id' => $request->route('craftsman')]);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

        $unit = ServiceHelper::make('Admin\UnitService')->getDetail(new UnitDTO([
            'id' => $craftsman->unit_id,
        ]));

        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail(new OrganizationDTO([
            'id' => $craftsman->organization_id,
        ]));

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

        //data_set($craftsman, 'industries', $industryTags);
        $craftsmanHonor = CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
            ->where('type', 2)->get();

        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);
        data_set($craftsman, 'unit_id_name', data_get($unit, 'name', ''));
        data_set($craftsman, 'unit_id_username', data_get($unit, 'username', ''));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name', ''));
        data_set($craftsman, 'organization_id_username', data_get($organization, 'username', ''));

        return view('craftsman.edit', compact('craftsman'));
    }

    public function updateCraftsman(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $info = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

        if (!in_array($info->check_status, [0,2,4,7]) ) {
            throw new InvalidArgumentException('已推送，暂不能修改');
        }

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->update($dto);

        return response()->json(['message' => '修改成功', 'code' => 1000]);
    }

    public function destroy(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $result = ServiceHelper::make('Admin\CraftsmanService')->delete($dto);

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

    public function pull(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $info = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

        $time = date('Y-m-d H:i:s', time());
        $caseSchemes = CaseSchemes::query()->where('type',8)
            ->where('is_open', 1)->where('qy_is_open', 1)->first();
        if (!$caseSchemes) {
            throw new NotFoundException('巴渝工匠赛事暂时未开启，敬请期待');
        }
        if ($time < $caseSchemes->qy_stime) {
            throw new InvalidArgumentException('巴渝工匠赛事暂时未开启，敬请期待');
        }
        if ($time > $caseSchemes->qy_etime) {
            throw new InvalidArgumentException('巴渝工匠申请时间已过');
        }
        if (!in_array($info->check_status, [0,2,4,7])) {
            throw new InvalidArgumentException('您已推送,请不要重复推送');
        }

        $dto->setCheckStatus([1]);
        $dto->setIsCraftsman(1);
        $dto->setActiveId($caseSchemes->id);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->pull($dto);

        return response()->json(['message' => '推送成功', 'code' => 1000]);
    }

    public function score(CraftsmanRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] != 5) {
            throw new InvalidArgumentException('无权限');
        }
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $dto->setScore($request->get('score'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->update($dto);

        return response()->json(['data' => '评分成功', 'code' => 1000]);
    }

    public function createCraftsmanHonor(CraftsmanRequest $request)
    {
        $craftsman = Craftsman::query()->where('id', $request->route('craftsman'))->first();
        if (!$craftsman) {
            throw new NotFoundException('未找到该工匠');
        }

        return view('craftsman.create_honor',compact('craftsman'));
    }

    public function storeCraftsmanHonor(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $craftsmanHonor = ServiceHelper::make('Admin\CraftsmanService')->storeCraftsmanHonor($dto);

        return response()->json(['message' => '添加成功', 'code' => 1000]);
    }

    public function deleteCraftsmanHonor(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsmanId = $request->route('craftsman');
        $honorId = $request->route('honor');

        $craftsman = Craftsman::query()->where('id', $craftsmanId)->first();
        if (!$craftsman) {
            throw new InvalidArgumentException('工匠未找到');
        }

        if ($this->admininfo['roles'][0]['id'] === 3) {
            if (in_array($craftsman->check_status,[6,9,10,11,12,13])) {
                throw new InvalidArgumentException('总工会已审核通过，不能删除');
            }
        }

        CraftsmanExtend::query()->where('craftsman_id', $craftsmanId)->where('id', $honorId)->delete();

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

    public function getJsSdk()
    {
        // Redis::setex('http://zghyd.hd3360.com/bygj/craftsman_detail.html?id=2', 8, 8995);
        // dd(Redis::get('http://zghyd.hd3360.com/bygj/craftsman_detail.html?id=2'));
        $url = request()->get('url');
        $weChatConfig = WechatConfig::query()->first();
        $wxInfo = new Jssdk($weChatConfig->app_id, $weChatConfig->secret, $url);
        $result = $wxInfo->getSignaturePackage();

        return response()->json(['wxInfo' => $result, 'code' => 1000]);
    }
}