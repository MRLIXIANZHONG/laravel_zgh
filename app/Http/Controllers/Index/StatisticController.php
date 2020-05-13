<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 18:15
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\StatisticDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;

class StatisticController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function adminunionModel(Request $request) {
        $dto = $this->requestHelper->makeDTO(StatisticDTO::class, $request);
        $dto->setType($request->get('type'));
        $array=[$dto,$request->checkCount,$request->timeType,$request->beginTime,$request->endTime];
        $response = ServiceHelper::make('Index\StatisticService')->adminunionModel($array);
        return $response;
    }

    public function unionModel(Request $request) {
        $dto = $this->requestHelper->makeDTO(StatisticDTO::class, $request);
        $dto->setType($request->get('type'));

        $array=[$request->type_id,$request->timeType,$request->beginTime,$request->endTime];
        $response = ServiceHelper::make('Index\StatisticService')->unionModel($array);
        return $response;
    }
}