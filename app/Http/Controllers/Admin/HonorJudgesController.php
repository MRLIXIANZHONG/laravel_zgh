<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\HonorJudgesDTO;
use App\Http\Requests\Admin\HonorJudgesRequest;

class HonorJudgesController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function List(HonorJudgesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(HonorJudgesDTO::class, $request);
        $response = ServiceHelper::make('Admin\HonorJudgesService')->getList($dto);
        return view('honorjudges.list', ['honorjudges' => $response,'JudgesId'=>$request->JudgesId,'checkhonorjudges'=>$dto]);
    }

    public function show(HonorJudgesRequest $request)
    {
        $HonorJudgess = ServiceHelper::make('Admin\HonorJudgesService')->show($request->id);
        return view('honorjudges.show', ['honorjudges' => $HonorJudgess,'JudgesId'=>$request->JudgesId]);
    }

    public  function getStore(HonorJudgesRequest $request){
        return view('honorjudges.store',['JudgesId' => $request->JudgesId]);
    }

    public function store(HonorJudgesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(HonorJudgesDTO::class, $request);
        $response = ServiceHelper::make('Admin\HonorJudgesService')->store($dto);
        return $response;
    }

    public function getUpdate(HonorJudgesRequest $request){
        $response = ServiceHelper::make('Admin\HonorJudgesService')->show($request->id);
        return view('honorjudges.edit', ['honorjudges' => $response,'JudgesId' => $request->JudgesId]);
    }

    public function update(HonorJudgesRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(HonorJudgesDTO::class, $request);
        $response = ServiceHelper::make('Admin\HonorJudgesService')->update($dto);
        return $response;
    }

    public function destroy(HonorJudgesRequest $request)
    {
        $response = ServiceHelper::make('Admin\HonorJudgesService')->destroy($request);
        return $response;
    }
}