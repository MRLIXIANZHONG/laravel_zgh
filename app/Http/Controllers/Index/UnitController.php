<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 20:51
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\UnitDTO;
use App\DTO\UnitLeaderDTO;
use App\DTO\UnitSectionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;

class UnitController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $units = ServiceHelper::make('Index\UnitService')->getList($dto);

        return response(['units' => $units, 'code' => 200]);
    }

    public function show(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $dto->setId($request->route('unit'));
        $unit = ServiceHelper::make('Index\UnitService')->getDetail($dto);
        $unitLeaders = ServiceHelper::make('Index\UnitLeaderService')->getList(new UnitLeaderDTO([
            'unit_ids' => [$dto->getId()],
        ]));
        $unitSections = ServiceHelper::make('Index\UnitSectionService')->getList(new UnitSectionDTO([
            'unit_id' => [$dto->getId()],
        ]));

        data_set($unit, 'unit_leaders', $unitLeaders);
        data_set($unit, 'unit_sections', $unitSections);
        return response(['data' => $unit, 'code' => 200]);
    }
}