<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 17:04
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationRequest;
use App\Models\Industry;
use App\Models\OrganizationIndustryMap;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class OrganizationController extends BaseController
{
    protected $requestHelper;

    protected $role;

    protected $unit;

    protected $roles = [1 ,4];

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->checkAuth();
        $role = $this->admininfo['role_id'];
        $this->requestHelper = $requestHelper;
    }

    public function index(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        if ($this->admininfo['units_id'] != null) {
            $dto->setUnitId($this->admininfo['units_id']);
        }
        if($this->admininfo['org_id'] !== null) {
            $dto->setId($this->admininfo['org_id']);
        }
        if ($this->admininfo['roles'][0]['id'] == 1 || in_array($this->admininfo['roles'][0]['id'], [4,6])) {
            $dto->setCheckStates([2]);
        } elseif ($this->admininfo['roles'][0]['id'] == 2) {
            $dto->setCheckStates([-1,1,2]);
        }
        $organizations = ServiceHelper::make('Admin\OrganizationService')->getList($dto);

        if ($organizations instanceof LengthAwarePaginator) {

            $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
                'ids'  =>  $organizations->getCollection()->pluck('unit_id')->toArray(),
                'location' => true,
            ]));

            $collects = $organizations->getCollection()->each(function ($item) use ($units) {
                $unit = $units->where('id', $item->unit_id)->first();
                data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
                data_set($item, 'check_staff', data_get($unit, 'username', ''));
            });

            $organizations->setCollection($collects);
        }
        $role = $this->admininfo['roles'][0]['id'];
        $search = [
            'name'  =>  $dto->getName(),
            'new_type' => $dto->getNewType(),
            'check_state' => $dto->getCheckState(),
            'is_competition' => $dto->getIsCompetition(),
        ];
        return view('organization.index', ['organizations' => $organizations, 'role' => $role, 'search' => $search]);
    }

    public function show(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail($dto);

        $unit = ServiceHelper::make('Admin\UnitService')->getDetail(new UnitDTO([
            'id' => $organization->unit_id,
        ]));
        data_set($organization, 'super_star', data_get($organization, 'star_count', 0) + data_get($organization, 'virtual_star', 0));
        data_set($organization, 'super_browse', data_get($organization, 'browse_count', 0) + data_get($organization, 'virtual_browse', 0));
        data_set($organization, 'unit_id_name', data_get($unit, 'name', ''));
        data_set($organization, 'check_staff', data_get($unit, 'username', ''));

        return view('organization.show', compact('organization'));
    }

    public function create()
    {
        $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
            'location' => true,
        ]));
        $industries = Industry::query()->get();
        return view('organization.edit', compact(['units', 'industries']));
    }

    public function store(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setCheckState(0);
        $organization = ServiceHelper::make('Admin\OrganizationService')->store($dto);

        return redirect('admin/organizations')->with('success', '更新成功！');
    }

    public function edit(OrganizationRequest $request)
    {
        $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
            'location' => true,
        ]));

        $industries = Industry::query()->get();
        $dto = new OrganizationDTO([ 'id' => $request->route('organization')]);
        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail($dto);
        $industryTag = OrganizationIndustryMap::query()
            ->where('organization_id', $request->route('organization'))->pluck('industry_id')->toArray();
        data_set($organization, 'industry_tag', $industryTag);
        $user = $this->admininfo;

        return view('organization.edit', compact(['organization', 'units', 'industries', 'user']));
    }

    public function update(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $info = ServiceHelper::make('Admin\OrganizationService')->getDetail($dto);
        if (in_array($info->check_state, [1])) {
            throw new InvalidArgumentException('正在等待审核');
        }
        $organization = ServiceHelper::make('Admin\OrganizationService')->update($dto);

        return response()->json(['organization' => $organization, 'message' => '修改成功','code' => 1000]);
    }

    public function destroy(OrganizationRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] != 1) {
            throw new InvalidArgumentException('无权限');
        }
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $result = ServiceHelper::make('Admin\OrganizationService')->delete($dto);

        return $result;
    }

    public function check(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $dto->setCheckState(2);
        $dto->setCheckTime(date('Y-m-d H:i:s', time()));
        $organization = ServiceHelper::make('Admin\OrganizationService')->update($dto);

        return response()->json(['message' => '审核成功', 'code' => 1000]);
    }

    public function reject(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $dto->setCheckState(-1);

        $organization = ServiceHelper::make('Admin\OrganizationService')->update($dto);

        return response()->json(['message' => '驳回成功', 'code' => 1000]);
    }

    public function pull(OrganizationRequest $request)
    {
        if($request->route('organization') !== $this->admininfo['org_id']) {
            throw new InvalidArgumentException('您无权推送');
        }
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $info = ServiceHelper::make('Admin\OrganizationService')->getDetail($dto);
        if ($info->check_state == 1) {
            throw new InvalidArgumentException('正在审核中，请不要重复推送');
        }
        if ($info->check_state == 2) {
            throw new InvalidArgumentException('您已通过审核，请不要重复推送');
        }
        $dto->setCheckState(1);
        $organization = ServiceHelper::make('Admin\OrganizationService')->update($dto);

        return response()->json(['message' => '推送成功', 'code' => 1000]);
    }

    public function setPassword(OrganizationRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] == 3 && $request->route('organization') != $this->admininfo['org_id']) {
            throw new InvalidArgumentException('无权限');
        }

        if ($request->get('repeat_password') !== $request->get('password')) {
            throw new InvalidArgumentException('两次输入密码不一致');
        }

        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $organization = ServiceHelper::make('Admin\OrganizationService')->setPassword($dto);

        return response()->json(['message' => '设置成功', 'code' => 1000]);
    }

    public function setVirtual(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($request->route('organization'));
        $organization = ServiceHelper::make('Admin\OrganizationService')->setVirtual($dto);

        return response()->json(['message' => '设置成功', 'code' => 1000]);
    }
}