<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 18:15
 */

namespace App\Http\Controllers\Admin;


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

    public function index(Request $request)
    {
        $dto = $this->requestHelper->makeDTO(StatisticDTO::class, $request);
        $dto->setType($request->get('type'));
        $statistics = ServiceHelper::make('Admin\StatisticService')->getList($dto);
        return $statistics;
    }
}