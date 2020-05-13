<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseSchemesDTO;
use App\DTO\JudgesAssignDTO;
use App\DTO\JudgesDTO;
use App\Http\Requests\Admin\JudgesAssignRequest;

class JudgesAssignController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

      public function index(JudgesAssignRequest $request) {
            $userrole=0;
         if($this->admininfo['role_slug']=="adminunion")
            $userrole=5;
          elseif($this->admininfo['role_slug']=="administrator")
            $userrole=6;
          $JudgesAssignDTO = $this->requestHelper->makeDTO(JudgesAssignDTO::class, $request);
          $response = ServiceHelper::make('Admin\JudgesAssignService')->getList($JudgesAssignDTO);
          return view('judgesassign.index', ['judgesassign' => $response,'userrole'=>$userrole,'checkJudgesAssign'=>$JudgesAssignDTO]);
      }

        public  function store(JudgesAssignRequest $request){
            $JudgesAssignDTO = $this->requestHelper->makeDTO(JudgesAssignDTO::class, $request);
            $response = ServiceHelper::make('Admin\JudgesAssignService')->store($JudgesAssignDTO);
            return $response;
        }

        public function randomJudges(JudgesAssignRequest $request){
            $array=[$request->confirmIndexStr,$request->notconfirmIndexStr];
            $response = ServiceHelper::make('Admin\JudgesAssignService')->updateState($array);
            return   $response;
        }

        public function getRandomJudges(JudgesAssignRequest $request){
            $judges = ServiceHelper::make('Admin\JudgesAssignService')->checkJudges($request->id);
            $bakjudges = ServiceHelper::make('Admin\JudgesAssignService')->checkBakJudges($request->id);
            $judgesAssign=ServiceHelper::make('Admin\JudgesAssignService')->getDetail($request->id);
            return view('judgesassign.randomJudges', ['judges' => $judges,'judgesassign'=>$judgesAssign,'bakjudges'=>$bakjudges]);
        }

        public function getAddJudgesassign(JudgesAssignRequest $request){
            $Judges=ServiceHelper::make('Admin\JudgesService')->checkJudgesAssign($request->id);
            return view('judgesassign.addjudgesassign', ['Judges' => $Judges,'judgesassignid'=>$request->id]);
        }

        public function  addJudgesassign (JudgesAssignRequest $request){
            $array=['judesId'=>$request->judesId,'judesType'=>$request->judesType,'id'=>$request->id];
            $response=ServiceHelper::make('Admin\JudgesAssignService')->addJudgesassign($array);
            return $response ;
        }

        public function doRandom(JudgesAssignRequest $request){
            $response=ServiceHelper::make('Admin\JudgesAssignService')->doRandom(["id"=>$request->id,"judesCount"=>$request->judesCount,"bakjudesCount"=>$request->bakjudesCount]);
            return  $response;
        }

        public function getStore(){
          $caseSchemesDTO =new  CaseSchemesDTO([]);
          $caseSchemes= $response = ServiceHelper::make('Admin\CaseSchemesService')->getList($caseSchemesDTO);
          return view('judgesassign.store',['caseSchemes'=>$caseSchemes]);
       }

       public function destroyJudgeJudgesAssign(JudgesAssignRequest $request){
           $response=ServiceHelper::make('Admin\JudgeJudgesAssignService')->destroy($request->deleteid);
           return  $response;
       }

    public function destroyJudgesAssign(JudgesAssignRequest $request){
        $response=ServiceHelper::make('Admin\JudgesAssignService')->destroy($request->id);
        return  $response;
    }

    public function update(JudgesAssignRequest $request){
        $JudgesAssignDTO = $this->requestHelper->makeDTO(JudgesAssignDTO::class, $request);
        $response = ServiceHelper::make('Admin\JudgesAssignService')->update($JudgesAssignDTO);
        return   $response;
    }

    public function getUpdate(JudgesAssignRequest $request){
        $userrole= 0;
        if($this->admininfo['role_slug']=="adminunion")
            $userrole=5;
        elseif($this->admininfo['role_slug']=="administrator")
            $userrole=6;
        $caseSchemesDTO =new  CaseSchemesDTO([]);
        $caseSchemes = ServiceHelper::make('Admin\CaseSchemesService')->getList($caseSchemesDTO);
        $JudgesAssign=ServiceHelper::make('Admin\JudgesAssignService')->getDetail($request->id);
        $State=ServiceHelper::make('Admin\JudgesAssignService')->checkUpdate($request->id);
        return view('judgesassign.update', ['judgesassign' => $JudgesAssign,'caseSchemes'=>$caseSchemes,'userrole'=>$userrole,'State'=>$State,'editType'=>$request->editType]);
    }

    public function destroy(JudgesAssignRequest $request){
        $response=ServiceHelper::make('Admin\JudgesAssignService')->destroy($request->id);
        return $response;
    }

    public function expore(JudgesAssignRequest $request){
        $JudgesAssignDTO = $this->requestHelper->makeDTO(JudgesAssignDTO::class, $request);
        $JudgesAssignDTO->setPageSize(-1);
        //$data = ServiceHelper::make('Admin\JudgesAssignService')->getList($JudgesAssignDTO);
        $data = ServiceHelper::make('Admin\JudgesAssignService')->exporeJudgesAssign($JudgesAssignDTO);
        $enddata=json_decode(json_encode($data),true);
        $header=[["id","id"],
            ["评审专家名称","name"],
            ["专家团队数量","judesCount"],
            ["备选专家数量","bakjudesCount"],
            ["名单确认截止时间","endtime"],
            ["专家指派状态","state"],
            ["关联活动","case_schemes_id"],
            ["创建时间","created_at"],
            ["更新时间","updated_at"],
            ["系统版本","system_version"],
            ["备选专家","bakjudgesname"],
            ["专家","judgesname"],
        ];
        $dataExcel = [$header, $enddata,'专家指派导出'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);
    }
}