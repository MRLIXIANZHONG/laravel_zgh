<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\DTO\SegmentsDTO;
use App\Http\Requests\Admin\SegmentsRequest;
use App\Http\Requests\Admin\Segments;

class SegmentsController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(SegmentsRequest $request)
    {

        $dto = $this->requestHelper->makeDTO(SegmentsDTO::class, $request);
        if(is_null($dto->getOrganizationId()))
            $dto->setOrganizationPlanId($request->organizationplanid);
        if(is_null($dto->getOrganizationPlanId()))
            $dto->setOrganizationId($request->organizationid);
        $response = ServiceHelper::make('Admin\SegmentsService')->getList($dto);
        return view('segments.index', ['segments' => $response,'organizationplanid'=>$request->organizationplanid,'organizationid'=>$request->organizationid,'checkSegment'=>$dto]);
    }

    public function show(SegmentsRequest $request)
    {
        $Segmentss = ServiceHelper::make('Admin\SegmentsService')->show($request->id);
        return view('segments.show', ['segments' => $Segmentss]);
    }

    public  function getStore(SegmentsRequest $request){
        $organizationplanid=$request->organizationplanid;
        $organizationid=$request->organizationid;
        return view('segments.store',['organizationplanid' => $organizationplanid,'organizationid'=>$organizationid]);
    }

    public function store(SegmentsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(SegmentsDTO::class, $request);
        $response = ServiceHelper::make('Admin\SegmentsService')->store($dto);
        return $response;
    }

    public function getUpdate(SegmentsRequest $request){
        $response = ServiceHelper::make('Admin\SegmentsService')->show($request->id);
        return view('segments.edit', ['segments' => $response]);
    }

    public function update(SegmentsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(SegmentsDTO::class, $request);
        $response = ServiceHelper::make('Admin\SegmentsService')->update($dto);
        return $response;
    }

    public function destroy(SegmentsRequest $request)
    {
        $response = ServiceHelper::make('Admin\SegmentsService')->destroy($request);
        return $response;
    }
}