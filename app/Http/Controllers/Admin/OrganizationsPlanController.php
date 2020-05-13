<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseSchemesDTO;
use App\DTO\LeadersOrganizationsPlanDTO;
use App\DTO\OrganizationDTO;
use App\DTO\OrganizationsPlanDTO;
use App\DTO\segmentsDTO;
use App\Http\Requests\Admin\OrganizationsPlanRequest;



class OrganizationsPlanController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(OrganizationsPlanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        $userrole= 0;
        if($this->admininfo['role_slug']=="union")
            $userrole=1;
        elseif($this->admininfo['role_slug']=="adminunion")
            $userrole=5;
        elseif($this->admininfo['role_slug']=="administrator")
            $userrole=6;
        $testid=$this->admininfo['org_id'] ;
        if($this->admininfo['role_slug']=='enterprise')
            $dto->setOrganizationId($testid);
//        $dto->setCheckState($userrole);
        $array=[$dto,$this->admininfo['units_id'],$request->order,$userrole];
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->getList1($array);
        //dd($dto->getCheckState();
//        if($userrole==1)
//            return view('organizationsplan.unionindex', ['OrganizationsPlans' => $response,'userrole'=>$userrole]);
        return view('organizationsplan.index', ['OrganizationsPlans' => $response[0],'userrole'=>$userrole,'industry'=>$response[1],'checkOrganizationsPlan'=>$dto,"order"=>$request->order]);
    }

    public function show(OrganizationsPlanRequest $request)
    {
        $OrganizationsPlans = ServiceHelper::make('Admin\OrganizationsPlanService')->show($request->id);
        return view('organizationsplan.show', compact('OrganizationsPlans'));
    }

    public function getExcellentSelection(OrganizationsPlanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        $dto->setCheckState(5);
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->getList($dto);
        return view('organizationsplan.excellentSelection', ['OrganizationsPlans' => $response,'pagelimite'=>$dto->getPagelimite()]);
    }

    public function getRecommend(OrganizationsPlanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        $dto->setCheckState(5);
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->getList($dto);
        return view('organizationsplan.recommend', ['OrganizationsPlans' => $response,'pagelimite'=>$dto->getPagelimite()]);
    }

    public function excellentSelection(OrganizationsPlanRequest $request)
    {
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->updateExcellentSelection($request);
        return $response;
    }

    public function recommend(OrganizationsPlanRequest $request)
    {
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->updateRecommend($request);
        return $response;
    }

    public  function getStore(){

        //获取企业id
        //$testid=195;
        $testid=$this->admininfo['org_id'] ;
        //获取企业
        $organizationdto =new OrganizationDTO([]) ;
        if($this->admininfo['role_slug']=="enterprise")
            $organizationdto->setId($testid);
        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail($organizationdto);
        return view('organizationsplan.store',['organization' => $organization]);
    }

    public function store(OrganizationsPlanRequest $request)
    {
        //方式1
        //        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        //        $response = ServiceHelper::make('OrganizationsPlanService')->store($dto);
        //        return $response;

        //方式2
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->store($dto);
        return $response;
    }

    public  function getStoreleaders(OrganizationsPlanRequest $request){

        //获取企业id
        //$testid=195;
        $testid=$request->organizationid;
        //$this->admininfo['org_id']

        //获取对应企业活动领导
        $inleaders =ServiceHelper::make('Admin\LeadersServices')->getInOrganizationsPlanLeaders([$request->id,$testid]);
        $notinleaders = ServiceHelper::make('Admin\LeadersServices')->getNotInOrganizationsPlanLeaders([$request->id,$testid]);
        $inleaders=json_decode(json_encode($inleaders),true);
        $notinleaders=json_decode(json_encode($notinleaders),true);
        return view('organizationsplan.storeleaders',['inleaders' => $inleaders,'notinleaders'=>$notinleaders,'organizationsplanid'=>$request->id]);
    }

    public  function storeOrDestroyLeaders(OrganizationsPlanRequest $request){
        if($request->doIt==1){
            $leadersOrganizationsPlanDTO =new LeadersOrganizationsPlanDTO([]);
            $leadersOrganizationsPlanDTO->setOrganizationsPlanId($request->organizationsPlanID) ;
            $leadersOrganizationsPlanDTO->setLeadersId($request->leadersID) ;
            $response = ServiceHelper::make('Admin\LeadersOrganizationsPlanServer')->store($leadersOrganizationsPlanDTO);
        }
        else{
            $leadersOrganizationsPlanDTO =new LeadersOrganizationsPlanDTO([]);
            $leadersOrganizationsPlanDTO->setOrganizationsPlanId($request->organizationsPlanID) ;
            $leadersOrganizationsPlanDTO->setLeadersId($request->leadersID) ;
            $response = ServiceHelper::make('Admin\LeadersOrganizationsPlanServer')->destroy($leadersOrganizationsPlanDTO);
        }
       return $response;
    }

    public function getStoresegments(OrganizationsPlanRequest $request){
        //获取企业id
        //$testid=195;
        $testid=$request->organizationid;
        //获取对应企业活动
        $segmentsDTO =new SegmentsDTO([]) ;
        $segmentsDTO->setOrganizationId($testid);
        $segmentsDTO->setPagelimite(0);
        $segments = ServiceHelper::make('Admin\SegmentsService')->getList($segmentsDTO);
        return view('organizationsplan.storesegments',['segments' => $segments,'organizationsplanid'=>$request->id]);
    }

    public function storesegments(OrganizationsPlanRequest $request){
        $segmentsDTO =new SegmentsDTO([]) ;
        $segmentsDTO->setId($request->segmentsId);
        if($request->doIt==1){
            $segmentsDTO->setOrganizationPlanId($request->organizationsPlanID);
            $segments = ServiceHelper::make('Admin\SegmentsService')->relevanceOrganizationPlan($segmentsDTO);
        }
        else{
            $segments = ServiceHelper::make('Admin\SegmentsService')-> removeRelevanceOrganizationPlan($segmentsDTO);
        }
            return $segments;
    }

    public function getUpdate(OrganizationsPlanRequest $request){
        $userrole= 0;
        if($this->admininfo['role_slug']=="union")
            $userrole=1;
        elseif($this->admininfo['role_slug']=="adminunion")
            $userrole=5;
        elseif($this->admininfo['role_slug']=="administrator")
            $userrole=6;
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->show($request->id);
        // editType==1 活动添加时出现， editType==2不通过时出现
        return view('organizationsplan.edit',['OrganizationsPlans'=>$response,'userrole'=>$userrole,'editType'=>$request->editType,'check_state'=>$request->check_state]);
    }

    public function update(OrganizationsPlanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->update($dto);
        if($dto->getCheckState() == -1){
            $array=[$dto,$this->admininfo['id']];
            ServiceHelper::make('Admin\OrganizationsPlanService')->changeCheckState($array);
        }
        if($dto->getCheckState() == -5){
            $array=[$dto,$this->admininfo['id']];
            ServiceHelper::make('Admin\OrganizationsPlanService')->changeCheckState($array);
        }
        if($request->editType==1)
            return '{"code":2000,"msg":"成功"}';
        return $response;
    }

     public function  changeCheckState (OrganizationsPlanRequest $request)    {
         $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
         $array=[$dto,$this->admininfo['id']];
         $response = ServiceHelper::make('Admin\OrganizationsPlanService')->changeCheckState($array);
         return $response;
     }

    public function destroy(OrganizationsPlanRequest $request)
    {
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->destroy($request);
        return $response;
    }

    public  function  getExcellentRelation(OrganizationsPlanRequest $request){
        $dto = $this->requestHelper->makeDTO(OrganizationsPlanDTO::class, $request);
//        $organizationsPlanDTO =new OrganizationsPlanDTO([]) ;
        if(!empty($this->admininfo['org_id']))
            $dto->setOrganizationId($this->admininfo['org_id']);
        $dto->setIsexcellent(1);

        $array=[$dto,$this->admininfo['units_id'],1,0];
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->getList1($array);
        $caseSchemesDTO =new CaseSchemesDTO([]) ;
        $caseSchemesDTO->setType(7);
        $caseSchemes = ServiceHelper::make('Admin\CaseSchemesService')->getList($caseSchemesDTO);
        return view('organizationsplan.excellentrelation',['checkOrganizationsPlan'=>$dto,'OrganizationsPlans'=>$response[0],'caseSchemes'=>$caseSchemes]);
    }

    public function excellentRelation(OrganizationsPlanRequest $request){
        $array=[$request->id,$request->caseSchemeId];
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->excellentRelation($array);
        return $response;
    }

    public function expore(OrganizationsPlanRequest $request){
        $response = ServiceHelper::make('Admin\OrganizationsPlanService')->export();
//        dd($response);
        $header=[["序号","id"],
            ["方案名称","planname"],
            ["方案类型","grade"],
            ["所属企业","organizationsname"],
            ["企业类型","new_type"],
            ["所属行业","industry"],
            ["所属工会","unitsname"],
            ["浏览量","browse_count"],
            ["点赞量","star_count"],
            ["企业联系人","username"],
            ["联系人电话","mobile"],
            ["企业id","organization_id"]
        ];
        $dataExcel = [$header,json_decode(json_encode($response),true),'方案列表'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);
    }
}