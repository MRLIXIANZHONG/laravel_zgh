<?php


namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;

use App\DTO\HonorJudgesDTO;
use App\DTO\JudgesDTO;
use App\Services\Index\JudgesService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JudgesRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class JudgesController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }
    
    public function getDetail($id){

        JudgesService:$JudgesService=ServiceHelper::make('Index\JudgesService');
        $judges = $JudgesService->show($id);
        $honorjudges =  $JudgesService->getHonorList($id);
        $array=(['judge'=>$judges,'honorjudge'=>$honorjudges]);
        return new JsonResponse($array);
    }

    public function index(JudgesRequest $request){
        $dto = $this->requestHelper->makeDTO(JudgesDTO::class, $request);
        $response = ServiceHelper::make('Index\JudgesService')->getList($dto);
        return new JsonResponse($response);
    }
}