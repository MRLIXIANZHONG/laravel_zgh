<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 上午 11:58
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseSchemesDTO;
use App\DTO\IndustryDTO;
use App\DTO\NomineeDTO;
use App\DTO\Nominees_experienceDTO;
use App\DTO\Nominess_imgDTO;
use App\DTO\Nominess_videoDTO;
use App\DTO\OrganizationDTO;
use App\DTO\OrganizationsPlanDTO;
use App\Http\Requests\Admin\NomineesRequest;
use App\Http\Requests\Admin\CaseSchemesRequest;
use App\Models\Nominee;
use App\Models\Nominees_experience;
use App\Models\Nominess_img;
use App\Models\Nominess_video;
use App\Models\Organization;

class NomineesContoller extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**获取优秀个人列表
     * @param NomineesRequest $request
     * @return mixed
     */
    public function index(NomineesRequest $request)
    {
//        dd($this->admininfo);
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);

        //非企业只查看申报数据
        if ($this->admininfo['role_slug'] != 'enterprise') {
            $dto->setDeclareStatus(1);
        }
        //获取企业和工会信息
        $dto->setOrganizationId($this->admininfo['org_id']);
        $dto->setUnitId($this->admininfo['units_id']);
        $data = ServiceHelper::make('Admin\NomineesService')->getList($dto);
        $caseSchemesList = ServiceHelper::make('Admin\CaseSchemesService')->getList(new CaseSchemesDTO(['iswhere' => 1]));
        //获取所有行业
        $industries = ServiceHelper::make('Admin\IndustryService')->getList(new IndustryDTO(['location' => true]));
//        dd($industries);
        return view('nominees.index', ['nominesslist' => $data, 'nomineedto' => $dto,
            'caseSchemesList' => $caseSchemesList,
            'industries' => $industries,
            'userinfo' => $this->admininfo]);
    }

    /**
     * 获取优秀个人
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        $nomineesService = ServiceHelper::make('Admin\NomineesService');
        $nominees = $nomineesService->getDetail($id);

        $nomineePlanList = ServiceHelper::make('Admin\NomineesPlanService')->getList(new NomineeDTO(['id' => $id]));
        $experiencelist = $nomineesService->getExperienceList(new Nominees_experienceDTO(['mainId' => $id]));
        $imglist = $nomineesService->getNominessImg(new Nominess_imgDTO(['mainId' => $id]));
        $videolist = $nomineesService->getNominessVideo(new Nominess_videoDTO(['mainId' => $id]));
//dd($nominees);
        return view('nominees.detailNominee', ['nominee' => $nominees,
            'nomineePlanList' => $nomineePlanList,
            'experiencelist' => $experiencelist,
            'imglist' => $imglist,
            'videolist' => $videolist

        ]);
    }

    /**
     * 编辑优秀个人
     * @param NomineesRequest $request
     * @return mixed
     */
    public function edit(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        $caseSchemesList = ServiceHelper::make('Admin\CaseSchemesService')->getList(new CaseSchemesDTO(['type' => 1]));
        //获取企业的方案列表

        $orgPlanList = ServiceHelper::make('Admin\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['organization_id' => $this->admininfo['org_id'], 'page_limite' => 0]));
        //获取员工参与的方案 ID

        //获取所有行业
        $industries = ServiceHelper::make('Admin\IndustryService')->getList(new IndustryDTO([]));

        $nomineePlanArr = [];

        if ($dto->getId()) {
            $nominee = ServiceHelper::make('Admin\NomineesService')->getDetail($dto->getId());
//dd($nominee);
            $dto->setOrganizationId($nominee->organization_id);
            $nomineePlanList = ServiceHelper::make('Admin\NomineesPlanService')->getList($dto);
            if ($nomineePlanList) {
                foreach ($nomineePlanList as $plan) {
                    array_push($nomineePlanArr, $plan['organizations_plan_id']);
                }

            }
        } else {
            $nominee = new Nominee();
            $nominee->unit_id = $this->admininfo['units_id'];
            $nominee->organization_id = $this->admininfo['org_id'];
            $org = ServiceHelper::make('Admin\OrganizationService')->getDetail(new OrganizationDTO(['id' => $nominee->organization_id]));
            $nominee->organization_name =$org->name;
        }


        return view('nominees.editNominee', ['nominee' => $nominee,
            'caseSchemesList' => $caseSchemesList,
            'orgPlanList' => $orgPlanList,
            'nomineePlanArr' => $nomineePlanArr,
            'industries' => $industries,
        ]);
    }

    /**
     * 添加优秀个人
     * @param NomineesRequest $request
     * @return
     */
//    public function store(NomineesRequest $request)
//    {
//        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
//
//        return ServiceHelper::make('Admin\NomineesService')->store($dto);
//    }

    /**
     * 删除优秀个人
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return ServiceHelper::make('Admin\NomineesService')->destroy($id);
    }

    /**
     * 设置虚拟数据
     * @param int $id
     * @return mixed
     */
    public function setvirtual(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        return ServiceHelper::make('Admin\NomineesService')->setvirtual($dto);
    }

    /**
     * 更新
     * @param NomineesRequest $request
     * @return mixed
     */
    public function update(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        return ServiceHelper::make('Admin\NomineesService')->store($dto);
    }

    /**
     * 审核并设置为月度之星
     * @param NomineesRequest $request
     * @return
     */
    public function check(NomineesRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        $dto->setAdminid($this->admininfo['id']);
        return ServiceHelper::make('Admin\NomineesService')->check($dto);
    }

    /**
     * 取消月季年度之星
     * @param CaseSchemesRequest $request
     * @return
     */
    public function cancelExcellent(CaseSchemesRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(CaseSchemesDTO::class, $request);
        return ServiceHelper::make('Admin\NomineesService')->cancelExcellent($dto);
    }


    /**获取优秀个人荣誉列表
     * @param NomineesRequest $request
     * @return mixed
     */
    public function indexExperience(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominees_experienceDTO::class, $request);

        $data = ServiceHelper::make('Admin\NomineesService')->getExperienceList($dto);

        return view('nominees.indexExperience', ['nominessExperiencelist' => $data, 'mainId' => request('mainId')]);
    }

    /**
     * 编辑优秀个人荣誉
     * @param NomineesRequest $request
     * @return mixed
     */
    public function editExperience(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominees_experienceDTO::class, $request);
        if ($dto->getId()) {
            $nominee = ServiceHelper::make('Admin\NomineesService')->getDetailExperience($dto->getId());
        } else {
            $nominee = new Nominees_experience();
        }
        return view('nominees.editNomineeExperience', ['nominee' => $nominee, 'mainId' => request('mainId')]);
    }

    /**
     * 更新
     * @param NomineesRequest $request
     * @return mixed
     */
    public function saveExperience(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominees_experienceDTO::class, $request);

        return ServiceHelper::make('Admin\NomineesService')->saveExperience($dto);
    }

    /**
     * 删除优秀个人荣誉
     * @param int $id
     * @return mixed
     */
    public function destroyExperience(int $id)
    {
        return ServiceHelper::make('Admin\NomineesService')->destroyExperience($id);
    }

    /**获取优秀个人荣誉图集列表
     * @param NomineesRequest $request
     * @return mixed
     */
    public function indexImg(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_imgDTO::class, $request);

        $data = ServiceHelper::make('Admin\NomineesService')->getNominessImg($dto);

        return view('nominees.indexImg', ['nominessImglist' => $data, 'mainId' => request('mainId')]);
    }

    /**
     * 编辑优秀个人荣誉
     * @param NomineesRequest $request
     * @return mixed
     */
    public function editImg(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_imgDTO::class, $request);

        if ($dto->getId()) {
            $nominee = ServiceHelper::make('Admin\NomineesService')->getDetailNominessImg($dto->getId());
        } else {
            $nominee = new Nominess_img();
        }
        return view('nominees.editNomineeImg', ['nominee' => $nominee, 'mainId' => request('mainId')]);
    }

    /**
     * 更新
     * @param NomineesRequest $request
     * @return mixed
     */
    public function saveImg(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_imgDTO::class, $request);

        return ServiceHelper::make('Admin\NomineesService')->saveNominessImg($dto);
    }

    /**
     * 删除优秀个人荣誉
     * @param int $id
     * @return mixed
     */
    public function destroyImg(int $id)
    {
        return ServiceHelper::make('Admin\NomineesService')->destroyNominessImg($id);
    }


    /**获取优秀个人荣誉视频列表
     * @param NomineesRequest $request
     * @return mixed
     */
    public function indexVideo(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_videoDTO::class, $request);

        $data = ServiceHelper::make('Admin\NomineesService')->getNominessVideo($dto);

        return view('nominees.indexVideo', ['nominessVideolist' => $data, 'mainId' => request('mainId')]);
    }

    /**
     * 编辑优秀个人荣誉视频
     * @param NomineesRequest $request
     * @return mixed
     */
    public function editVideo(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_videoDTO::class, $request);

        if ($dto->getId()) {
            $nominee = ServiceHelper::make('Admin\NomineesService')->getDetailNominessVideo($dto->getId());
        } else {
            $nominee = new Nominess_video();
        }
        return view('nominees.editNomineeVideo', ['nominee' => $nominee, 'mainId' => request('mainId')]);
    }

    /**
     * 更新
     * @param NomineesRequest $request
     * @return mixed
     */
    public function saveVideo(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(Nominess_videoDTO::class, $request);

        return ServiceHelper::make('Admin\NomineesService')->saveNominessVideo($dto);
    }

    /**
     * 删除优秀个人荣誉
     * @param int $id
     * @return mixed
     */
    public function destroyVideo(int $id)
    {
        return ServiceHelper::make('Admin\NomineesService')->destroyNominessVideo($id);
    }

    /**
     * 导出Excel
     * @param NomineesRequest $request
     * @return excel
     */
    public function exportExcel(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        //获取企业和工会信息
        $dto->setOrganizationId($this->admininfo['org_id']);
        $dto->setUnitId($this->admininfo['units_id']);
        $data = ServiceHelper::make('Admin\NomineesService')->getListToExcel($dto);
        //表头
        $header = [
            ['员工编号', 'staff_id']
            , ['员工姓名', 'staff_name']
            , ['员工头像', 'staff_img']
            , ['员工电话', 'staff_phone']
            , ['银行卡号', 'bank_card']
            , ['开户行', 'bank_name']
            , ['开户姓名', 'bank_staff_name']
            , ['银行卡照片', 'bank_card_img']
            , ['企业名称', 'organization_name']
            , ['审核工会', 'unit_name']
            , ['行业', 'nominee_industry_name']
            , ['推荐类型', 'kind']
            , ['推荐理由', 'caption']
            , ['月度之星获得时间', 'month_win']
            , ['季度之星获得时间', 'quarter_win']
            , ['年度之星获得时间', 'year_win']
            , ['所属参赛时间节点ID', 'case_scheme_id']
            , ['季度投票排名', 'quarter_rank']
            , ['年度投票排名', 'year_rank']
            , ['创建时间', 'created_at']
            , ['更新时间', 'updated_at']
            , ['季度票数', 'quarter_vote_sum']
            , ['年度票数', 'year_vote_sum']
            , ['点赞数量', 'star_count']
        ];

        $dataExcel = [$header, $data->toArray(), '优秀个人信息' . time()];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);

    }

    /**
     * 优秀个人申报
     * @param $id
     *
     * @return
     */
    public function  declare($id)
    {
        return ServiceHelper::make('Admin\NomineesService')->declareNominee([$id, $this->admininfo['id']]);
    }

    /**
     * 设置为季度之星
     * @param $id
     *
     * @return
     */
    public function quarter($id)
    {
        return ServiceHelper::make('Admin\NomineesService')->quarter([$id, $this->admininfo['id']]);
    }

    /**
     * 设置为年度之星
     * @param $id
     *
     * @return
     */
    public function year($id)
    {
        return ServiceHelper::make('Admin\NomineesService')->year([$id, $this->admininfo['id']]);
    }

    /**
     * 优秀个人推荐到前台首页
     * @param NomineesRequest $request
     * @return mixed
     */
    public function recommend(NomineesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NomineeDTO::class, $request);
        if ($this->admininfo['role_slug'] != 'administrator')
            return '{"code":1001,"msg":"你没有该权限"}';
        return ServiceHelper::make('Admin\NomineesService')->recommend($dto);
    }

}