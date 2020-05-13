<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/10
 * Time: 15:39
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Handlers\UploadHandler;
use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\UnitDTO;
use App\DTO\UnitHomePageDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Requests\Admin\UnitRequest;
use App\Http\Requests\Admin\UnitHomePageRequest;

class UnitController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        if ($this->admininfo['roles'][0]['id'] == 2) {
            $dto->setId($this->admininfo['units_id']);
        }
        $units = ServiceHelper::make('Admin\UnitService')->getList($dto);
        $role = $this->admininfo['roles'][0]['id'];
        $search = [
            'name' => $dto->getName(),
            'type' => $dto->getType(),
            'honor_unit' => $dto->getHonorUnit(),
            'check_status' => $dto->getCheckStatus(),
            'mobile' => $dto->getMobile(),
        ];

        return view('unit.index', compact(['units', 'role', 'search']));
    }

    public function show(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $unit = ServiceHelper::make('Admin\UnitService')->getDetail($dto);

        return view('unit.show', compact('unit'));
    }

    public function create()
    {
        return view('unit.create');
    }

    public function store(UnitRequest $request)
    {
        if ($request->get('password') !== $request->get('repeat_password')) {
            throw new InvalidArgumentException('前后密码不一致，请重新输入');
        }
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $unit = ServiceHelper::make('Admin\UnitService')->store($dto);

        return response()->json(['message' => '添加成功', 'code' => 1000]);
    }

    public function edit(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $unit = ServiceHelper::make('Admin\UnitService')->getDetail($dto);
        $user = $this->admininfo;

        return view('unit.edit', compact(['unit', 'user']));
    }

    public function update(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        if ($dto->getHonorUnit() === null) {
            $dto->setHonorUnit(0);
        }
        $unit = ServiceHelper::make('Admin\UnitService')->update($dto);

        return response(['message' => '更新成功', 'code' => 1000]);
    }

    public function destroy(UnitRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] != 1) {
            throw new InvalidArgumentException('无权限');
        }
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $result = ServiceHelper::make('Admin\UnitService')->delete($dto);

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

    public function check(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $dto->setCheckStatus(1);

        $unit = ServiceHelper::make('Admin\UnitService')->update($dto);

        return response()->json(['message' => '审核成功', 'code' => 1000]);
    }

    public function reject(UnitRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] != 1) {
            throw new InvalidArgumentException('无权限');
        }
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $dto->setCheckStatus(-1);

        $unit = ServiceHelper::make('Admin\UnitService')->update($dto);

        return response()->json(['message' => '驳回成功', 'code' => 1000]);
    }

    public function getHomePage()
    {
        $dto = new UnitHomePageDTO([]);
        $dto->setUnitId($this->admininfo['units_id']);
        $unitHomePage = ServiceHelper::make('Admin\UnitService')->getHomePage($dto);
        return view('unit.homepage', ['unitHomePage' => $unitHomePage]);
    }

    public function updateHomePage(UnitHomePageRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitHomePageDTO::class, $request);
        return ServiceHelper::make('Admin\UnitService')->updateHomePage($dto);
    }

    public function setPassword(UnitRequest $request)
    {
        if ($this->admininfo['roles'][0]['id'] == 2 && $request->route('unit') != $this->admininfo['units_id']) {
            throw new InvalidArgumentException('无权限');
        }
        if ($request->get('repeat_password') !== $request->get('password')) {
            throw new InvalidArgumentException('两次输入密码不一致');
        }
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $model = ServiceHelper::make('Admin\UnitService')->setPassword($dto);

        return response()->json(['message' => '修改成功', 'code' => 1000]);
    }

    public function setVirtual(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $model = ServiceHelper::make('Admin\UnitService')->setVirtual($dto);

        return response()->json(['message' => '设置成功', 'code' => 1000]);
    }
}