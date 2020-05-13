<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-11 下午 4:42
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseSchemesDTO;
use App\DTO\IndustryDTO;
use App\DTO\OrganizationDTO;
use App\DTO\OrganizationsWuxiaoDTO;
use App\Http\Requests\Admin\OrganizationsWuxiaoRequest;
use App\Models\OrganizationsWuxiao;

class OrganizationsWuxiaoController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**
     * 获取五小列表
     * @param OrganizationsWuxiaoRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        //非企业只查看申报数据
        if ($this->admininfo['role_slug']!='enterprise')
        {
            $dto->setDeclarationState(1);
        }
        $dto->setOrganizationId($this->admininfo['org_id']);//企业ID
        $dto->setUnitId($this->admininfo['units_id']);//公会ID

        $caseSchemesList = ServiceHelper::make('Admin\CaseSchemesService')->getList(new CaseSchemesDTO(['iswhere'=>2]));
        $data = ServiceHelper::make('Admin\OrganizationsWuxiaoService')->getList($dto);

        return view('organizationswuxiao.index', ['wuxiaolist' => $data, 'wuxiaoDto' => $dto,'caseSchemesList' => $caseSchemesList, 'userinfo' => $this->admininfo,

        ]);
    }

    /**
     * 编辑五小
     * @param OrganizationsWuxiaoRequest $request
     * @return mixed
     */
    public function edit(OrganizationsWuxiaoRequest $request)
    {
//        dd($this->admininfo);
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $caseSchemesList = ServiceHelper::make('Admin\CaseSchemesService')->getList(new CaseSchemesDTO(['type' => 4]));
         // $caseSchemesList = ServiceHelper::make('CaseSchemesService')->getList(null);
        if ($dto->getId()) {
            $wuxiao = ServiceHelper::make('Admin\OrganizationsWuxiaoService')->getDetail($dto->getId());
        } else {
            $wuxiao = new OrganizationsWuxiao();
        }
        //获取企业信息
       $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail(new OrganizationDTO(['id' => $this->admininfo['org_id']]));
        $industries = ServiceHelper::make('Admin\IndustryService')->getList(new IndustryDTO([]));
        return view('organizationswuxiao.editWuxiao', ['wuxiao' => $wuxiao,
            'caseSchemesList'=>$caseSchemesList,
            'organization'=>$organization,
            'industries' => $industries]);
    }

    /**
     * 更新
     * @param OrganizationsWuxiaoRequest $request
     * @return mixed
     */
    public function update(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $dto->setUnitId($this->admininfo['units_id']);
        $dto->setOrganizationId($this->admininfo['org_id']);
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->store($dto);
    }
//
//    /**
//     * 添加
//     * @param OrganizationsWuxiaoRequest $request
//     * @return
//     */
//    public function store(OrganizationsWuxiaoRequest $request)
//    {
//        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
//        $dto->setUnitId($this->admininfo['units_id']);
//        $dto->setOrganizationId($this->admininfo['org_id']);
//        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->store($dto);
//    }


    public function detail(int $id)
    {
        if (empty($id)) {
            return ['code' => '-1', 'message' => '获取失败'];
        }
        $wuxiao = ServiceHelper::make('Admin\OrganizationsWuxiaoService')->getDetail($id);
        return view('organizationswuxiao.detailWuxiao', ['wuxiao' => $wuxiao]);
    }

    /**
     * 申报
     * @param int $id
     * @return string[]
     */

    public function declaration(int $id)
    {
        if (empty($id)) {
            return ['code' => '-1', 'message' => '获取失败'];
        }
//        dd($this->admininfo);
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->declaration([$id,$this->admininfo['id']]);
    }

    public function destroy(int $id)
    {
        if (empty($id)) {
            return ['code' => '-1', 'message' => '获取失败'];
        }
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->destroy($id);
    }

    /**
     * 审核
     * @param OrganizationsWuxiaoRequest $request
     * @return
     */
    public function check(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $dto->setAdminid($this->admininfo['id']);
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->check($dto);
    }

    /**
     * 设置优秀
     * @param $id
     * @return
     */
    public function excellent(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $dto->setAdminid($this->admininfo['id']);
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->excellent($dto);
    }

    /**
     * 导出到excel
     * @param OrganizationsWuxiaoRequest $request
     * @return
     */
    public function exportExcel(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        $dto->setOrganizationId($this->admininfo['org_id']);//企业ID
        $dto->setUnitId($this->admininfo['units_id']);//公会ID

        $data = ServiceHelper::make('Admin\OrganizationsWuxiaoService')->getListToExcel($dto);
        $header = [
            ['序号', 'id'],
            ['五小名称', 'plan_name'],
            ['五小类型', 'type'],
            ['所属企业', 'organizations_name'],
            ['企业类型', 'org_type_name'],
            ['所属行业', 'wuxiao_industry_name'],
            ['浏览量', 'browse_count'],
            ['点赞量', 'star_count'],
            ['所获奖项', 'awards'],
            ['获奖时间', 'awards_time'],
            ['企业联系人', 'organizations_username'],
            ['联系电话', 'organizations_mobile'],
            ['更新时间', 'updated_at'],
        ];
        $dataExcel = [$header, $data->toArray(), '五小信息' . time()];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);
    }

    /**
     * 设置为季度优秀五小
     * @param $id
     *
     * @return
     */
    public function  quarter($id)
    {

        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->quarter([$id,$this->admininfo['id']]);
    }
    /**
     * 设置为年度优秀五小
     * @param $id
     *
     * @return
     */
    public function  year($id)
    {
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->year([$id,$this->admininfo['id']]);
    }

    /**
     * 设置虚拟数据
     * @param int $id
     * @return mixed
     */
    public function setvirtual(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->setvirtual($dto);
    }

    /**
     * 优秀个人推荐到前台首页
     * @param $id
     * @return mixed
     */
    public function recommend(OrganizationsWuxiaoRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsWuxiaoDTO::class, $request);
        if ($this->admininfo['role_slug'] != 'administrator')
            return '{"code":1001,"msg":"你没有该权限"}';
        return ServiceHelper::make('Admin\OrganizationsWuxiaoService')->recommend($dto);
    }
}