<?php
/**
 *评选计划
 * @author ccoo004
 * @date 2020-04-08 下午 3:22
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseSchemesDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaseSchemesRequest;
use App\Models\CaseSchemes;

class CaseSchemesController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**
     * @param CaseSchemesRequest $request
     * @return mixed
     */
    public function index(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);

        $caseSchemesList = ServiceHelper::make('Admin\CaseSchemesService')->getList($dto);
        $caseSchemesTypeList = ServiceHelper::make('Admin\CaseSchemesService')->getCaseSchemeTypeList();

        return view('caseschemes.index', ['caseSchemesList' => $caseSchemesList, 'caseSchemesdto' => $dto,'caseSchemesTypeList'=>$caseSchemesTypeList]);
    }

    /**
     * 添加赛事节点
     * @param CaseSchemesRequest $request
     * @return mixed
     */
    public function store(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        return ServiceHelper::make('Admin\CaseSchemesService')->update($dto);
    }

    /**
     * 编辑赛事节点
     * @param CaseSchemesRequest $request
     * @return mixed
     */
    public function edit(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        if ($dto->getId()) {
            $caseScheme = ServiceHelper::make('Admin\CaseSchemesService')->getDetail($dto);
        } else {
            $caseScheme = new CaseSchemes();
        }
        $caseSchemesTypeList = ServiceHelper::make('Admin\CaseSchemesService')->getCaseSchemeTypeList();
        return view('caseschemes.editcasescheme', ['caseScheme' => $caseScheme,'caseSchemesTypeList'=>$caseSchemesTypeList]);
    }

    /**
     * 更新赛事节点
     * @param CaseSchemesRequest $request
     * @return mixed
     */
    public function update(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        return ServiceHelper::make('Admin\CaseSchemesService')->update($dto);
    }

    /**
     * 删除赛事节点
     * @param CaseSchemesRequest $request
     * @return mixed
     */
    public function destroy(int $id)
    {
        return ServiceHelper::make('Admin\CaseSchemesService')->destroy($id);
    }

    /**获取赛事详情
     * @param int $id
     * @return mixed
     */
    public function detail(int $id)
    {
        $data = ServiceHelper::make('Admin\CaseSchemesService')->detail($id);
        return view('caseschemes.detailcasescheme', ['caseScheme' => $data]);
    }

    /**
     * 五小评审
     * @param CaseSchemesRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function wuxiao(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        if (!$dto->getType())
            $dto->setType(4);
        $dto->setUnitId($this->admininfo['units_id']);
        $data = ServiceHelper::make('Admin\CaseSchemesService')->wuxiao($dto);

        return view('caseschemes.wuxiao', ['caseSchemesList' => $data, 'caseSchemesdto' => $dto]);
    }

    /**
     * 优秀个人评审
     * @param CaseSchemesRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function nominee(CaseSchemesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        if (!$dto->getType())
            $dto->setType(1);
        $dto->setUnitId($this->admininfo['units_id']);
        $data = ServiceHelper::make('Admin\CaseSchemesService')->nominee($dto);

        return view('caseschemes.nominee', ['caseSchemesList' => $data, 'caseSchemesdto' => $dto]);
    }
}