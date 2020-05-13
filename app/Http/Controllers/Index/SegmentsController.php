<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/14
 * Time: 22:36
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\segmentsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SegmentsRequest;

class SegmentsController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(SegmentsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(segmentsDTO::class, $request);
        $segments = ServiceHelper::make('Index\SegmentsService')->getList($dto);

        return response()->json(['segments' => $segments, 'code' => 200]);
    }

    public function show(SegmentsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(segmentsDTO::class, $request);
        $dto->setId($request->route('segment'));
        $segment = ServiceHelper::make('Index\SegmentsService')->getDetail($dto);

        return response()->json(['data' => $segment, 'code' => 200]);
    }
}