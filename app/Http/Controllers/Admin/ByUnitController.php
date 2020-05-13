<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/20
 * Time: 12:06
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Requests\Admin\UnitRequest;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ByUnitController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        if (!in_array($this->admininfo['roles'][0]['id'], [1,4,6])) {
            throw new InvalidArgumentException('无权限');
        }
        $this->requestHelper = $requestHelper;
    }

    public function index(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $search = [
            'name' => $dto->getName(),
            'type' => $dto->getType(),
            'honor_unit' => $dto->getHonorUnit(),
            'mobile' => $dto->getMobile(),
        ];
        $dto->setCheckStatus(1);
        $units = ServiceHelper::make('Admin\UnitService')->getList($dto);

        if ($units instanceof LengthAwarePaginator) {
            $unitIds = $units->getCollection()->pluck('id')->toArray();
            $statistics = DB::table('zgh_statistics')->whereIn('type_id',$unitIds)->where('type',2)->get();

            $collects = $units->getCollection()->each(function ($item) use ($statistics) {
                $statistic = $statistics->where('type_id',$item->id)->first();

                data_set($item, 'organization_count', data_get($statistic, 'organization_count', 0));
                data_set($item, 'gj_tb', data_get($statistic, 'gj_tb', 0));
                data_set($item, 'gj_fs', data_get($statistic, 'gj_fs', 0));
                data_set($item, 'gj_hj', data_get($statistic, 'gj_hj', 0));
                data_set($item,'by_browse',data_get($statistic,'by_browse',0) + data_get($item,'virtual_browse',0));
                data_set($item,'by_star',data_get($statistic,'by_star',0) + data_get($item,'virtual_star',0));
            });
        }
        $units->setCollection($collects);

        $role = $this->admininfo['roles'][0]['id'];
        return view('by_unit.index', compact(['units', 'role', 'search']));
    }

    public function export(UnitRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(UnitDTO::class, $request);
        $wlUnits = ServiceHelper::make('Admin\UnitService')->export($dto);

        $header = [
            ['序号','id'],
            ['工会名称','unit_id_name'],
            ['工会类型','type_name'],
            ['联系人','username'],
            ['联系电话','mobile'],
            ['参赛企业', 'organization_count'],
            ['提报工匠','gj_tb'],
            ['复审工匠','gj_fs'],
            ['工匠获奖','gj_hj'],
            ['浏览量','by_browse'],
            ['点赞量','by_star'],
        ];

        $excel = [$header,json_decode(json_encode($wlUnits),true),'巴渝工匠工会统计'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }
}