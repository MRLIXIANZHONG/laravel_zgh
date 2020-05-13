<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\LeadersDTO;
use App\DTO\OrganizationDTO;
use App\Http\Requests\Admin\LeadersRequest;

class LeadersController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(LeadersRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(LeadersDTO::class, $request);
        $testid=$this->admininfo['org_id'] ;
        if($this->admininfo['role_slug']=='enterprise')
            $dto->setOrganizationId($testid);
        $response = ServiceHelper::make('Admin\LeadersServices')->getList($dto);
        return view('leaders.index', ['leaders' => $response,'checkLeader'=>$dto]);
    }

    public function show(LeadersRequest $request)
    {
        $Leaderss = ServiceHelper::make('Admin\LeadersServices')->show($request->id);
        return view('leaders.show', ['leaders' => $Leaderss]);
    }

    public  function getStore(){

        $testid=$this->admininfo['org_id'] ;
        $organizationdto =new OrganizationDTO([]) ;
        if($this->admininfo['role_slug']=="enterprise")
            $organizationdto->setId($testid);
        $organization = ServiceHelper::make('Admin\OrganizationService')->getList($organizationdto);
        return view('leaders.store',['organization' => $organization]);
    }

    public function store(LeadersRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(LeadersDTO::class, $request);
        $response = ServiceHelper::make('Admin\LeadersServices')->store($dto);
        return $response;
    }

    public function getUpdate(LeadersRequest $request){
        $response = ServiceHelper::make('Admin\LeadersServices')->show($request->id);
        return view('leaders.edit', ['leaders' => $response]);
    }

    public function update(LeadersRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(LeadersDTO::class, $request);
        $response = ServiceHelper::make('Admin\LeadersServices')->update($dto);
        return $response;
    }

    public function destroy(LeadersRequest $request)
    {
        $response = ServiceHelper::make('Admin\LeadersServices')->destroy($request);
        return $response;
    }
}