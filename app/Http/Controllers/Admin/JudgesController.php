<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\AdminUsersDTO;
use App\DTO\HonorJudgesDTO;
use App\DTO\IndustryDTO;
use App\DTO\JudgesScoreDTO;
use App\Http\Requests\Admin\JudgesRequest;
use App\DTO\JudgesDTO;
use App\Models\AdminRoles;

class JudgesController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();

        $this->requestHelper = $requestHelper;
    }

    public function index(JudgesRequest $request)
    {
        $userrole= 0;
        if($this->admininfo['role_slug']=="adminunion")
            $userrole=5;
        elseif($this->admininfo['role_slug']=="administrator")
            $userrole=6;
        $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
        $response = ServiceHelper::make('Admin\JudgesService')->getList($dto);
        $Industrydto=new IndustryDTO([]);
        $Industry = ServiceHelper::make('Admin\IndustryService')->getList($Industrydto);
        return view('judges.index', ['Judgeses' => $response,'userrole'=>$userrole,'checkJudges'=>$dto,'industry'=>$Industry]);
    }

    public function getRecommend(JudgesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
        $response = ServiceHelper::make('Admin\JudgesService')->getList($dto);
        return view('judges.recommend', ['Judgeses' => $response]);
    }

    public function recommend(JudgesRequest $request)
    {
        $response = ServiceHelper::make('Admin\JudgesService')->updateRecommend($request);
        return $response;
    }

    public  function getStore(){
        $dto=new IndustryDTO([]);
        $Industry = ServiceHelper::make('Admin\IndustryService')->getList($dto);
        return view('judges.store', ['Industry'=>$Industry]);
    }

    public function store(JudgesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
        $state = ServiceHelper::make('Admin\JudgesService')->store($dto);
        return  $state ;
    }

    public function show(JudgesRequest $request)
    {
        $response = ServiceHelper::make('Admin\JudgesService')->show($request->id);
        $Industrydto=new IndustryDTO([]);
        $Industry = ServiceHelper::make('Admin\IndustryService')->getList($Industrydto);
        return view('judges.show', ['Judgeses' => $response,'industry'=>$Industry]);
    }

    public function detail()
    {
        $testid=$this->admininfo['jun_id'] ;
        $judgescount = ServiceHelper::make('Admin\JudgeJudgesAssignService')->check($testid);
        if($judgescount)  {
            $judges=  ServiceHelper::make('Admin\JudgesService')->show($testid);
            $industry = ServiceHelper::make('Admin\IndustryService')->getList(new IndustryDTO([]));
            $honorjudges=  ServiceHelper::make('Admin\HonorJudgesService')->getList(new HonorJudgesDTO(['Judges_id'=>$judges->id]));
            return view('judges.detail', ['judges' => $judges,'honorjudges'=>$honorjudges,'industry'=>$industry]);
        }

          return '不是评委';
    }

    public function getUpdate(JudgesRequest $request){
        $Judgeses = ServiceHelper::make('Admin\JudgesService')->show($request->id);
        $dto=new IndustryDTO([]);
        $Industry = ServiceHelper::make('Admin\IndustryService')->getList($dto);
        return view('judges.edit', ['Judgeses' => $Judgeses,'Industry'=>$Industry,'editType'=>$request->editType]);
    }

    public function update(JudgesRequest $request)
    {
        if(!empty($request->sendtype)){
            $arraylist=['id'=>$request->id,'check_state'=>$request->check_state];
            $response = ServiceHelper::make('Admin\JudgesService')->updateList([$arraylist]);
            return $response;
        }
        else{
            $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
            $response = ServiceHelper::make('Admin\JudgesService')->update($dto);
            return $response;
        }
    }

    public function destroy(JudgesRequest $request)
    {
        $response = ServiceHelper::make('Admin\JudgesService')->destroy($request);
        return $response;
    }


    public function getHonor(JudgesRequest $request){
        $response = ServiceHelper::make('Admin\JudgesService')->show($request->id);
        return view('judges.show', ['Honor' => $response->getHonor()]);
    }

    public function expore(JudgesRequest $request){
        $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
        $dto->setPageSize(-1);
        $data = ServiceHelper::make('Admin\JudgesService')->getList($dto);
        $header=[["id","id"],
            ["专家姓名","name"],
            ["所属单位","department"],
            ["专家电话","phone"],
            ["评委类别","kind"],
            ["行业类型","industry"],
            ["擅长领域","skill"],
            ["照片","photo"],
            ["短信密码","password"],
            ["最后发送短信时间","last_send_time"],
            ["创建时间","created_at"],
            ["更新时间","updated_at"],
            ["是否为推荐","isrecommend"],
            ["视频地址","video_url"],
        ];
        $dataExcel = [$header, $data,'专家导出'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);
    }

    public function getScore(JudgesRequest $request){
        if(!empty($this->admininfo['jun_id'])){
            $judgesScore = ServiceHelper::make('Admin\JudgesService')->checkJudgesScore($this->admininfo['jun_id']);
            return view('judges.score', ['judgesScore' =>$judgesScore]);
        }
        else
            return "无权打分";
    }

    public function getScoreList(JudgesRequest $request){
        $array=[$request->type,$this->admininfo['jun_id']];
        $scores= ServiceHelper::make('Admin\JudgesService')->getScoreList($array);
        return  view('judges.scorelist', ['scores' =>$scores,'type'=>$request->type]);
    }

    public function score(JudgesRequest $request){
        $dto = $this->requestHelper->makeDTO(JudgesScoreDTO::class, $request);
        $dto->setJudgesId($this->admininfo['jun_id']);
        $response= ServiceHelper::make('Admin\JudgesScoreService')->store($dto);
        return $response;
    }
    
}