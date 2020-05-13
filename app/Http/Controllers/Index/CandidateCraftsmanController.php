<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 18:28
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\DTO\OrganizationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class CandidateCraftsmanController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsmans = ServiceHelper::make('Index\CandidateCraftsmanService')->getList($dto);

        if ($craftsmans instanceof LengthAwarePaginator) {
            $collection = $craftsmans->getCollection();
            //$unitIds = ServiceHelper::make('Index\OrganizationService')->getList(new OrganizationDTO([]));
            //dd($collection->pluck('unit_id'));
            $collection->each(function ($item) {

            });
        }

        return response()->json(['craftsmans' => $craftsmans, 'code' => 200]);
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        $craftsman = ServiceHelper::make('Index\CandidateCraftsmanService')->getDetail($dto);

        return response()->json(['data' => $craftsman, 'code' => 200]);
    }

    public function star(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        ServiceHelper::make('Index\CandidateCraftsmanService')->star($dto);

        return  response([ 'message' => '点赞成功', 'code' => 200]);
    }

}