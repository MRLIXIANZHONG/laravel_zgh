<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/20
 * Time: 1:14
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Requests\Admin\OrganizationRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class ByOrganizationController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $role = $this->admininfo['role_id'];
        $this->requestHelper = $requestHelper;
    }

    public function index(OrganizationRequest $request)
    {
        if (!in_array($this->admininfo['roles'][0]['id'], [1,2,4,6])) {
            throw new InvalidArgumentException('无权限');
        }
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        if ($this->admininfo['units_id'] !== null) {
            $dto->setUnitId($this->admininfo['units_id']);
        }

        $dto->setCheckStates([2]);
        $organizations = ServiceHelper::make('Admin\OrganizationService')->getList($dto);

        if ($organizations instanceof LengthAwarePaginator) {

//            $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
//                'ids'  =>  $organizations->getCollection()->pluck('unit_id')->toArray(),
//                'location' => true,
//            ]));
//
            $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([]));

            $organizationIds = $organizations->getCollection()->pluck('id')->toArray();
            $statistics = DB::table('zgh_statistics')->whereIn('type_id',$organizationIds)->where('type',1)->get();

            $collects = $organizations->getCollection()->each(function ($item) use ($units,$statistics) {
                $unit = $units->where('id', $item->unit_id)->first();
                $statistic = $statistics->where('type_id',$item->id)->first();
                data_set($item, 'unit_id_name', data_get($unit, 'name',''));
                data_set($item, 'gj_tb', data_get($statistic, 'gj_tb', 0));
                data_set($item, 'gj_fs', data_get($statistic, 'gj_fs', 0));
                data_set($item, 'gj_hj', data_get($statistic, 'gj_hj', 0));
                data_set($item,'by_browse',data_get($statistic,'by_browse',0) + data_get($item,'virtual_browse',0));
                data_set($item,'by_star',data_get($statistic,'by_star',0) + data_get($item,'virtual_star',0));
            });

            $organizations->setCollection($collects);
        }
        $role = $this->admininfo['roles'][0]['id'];
        return view('by_organization.index', ['organizations' => $organizations, 'role' => $role, 'units'=> $units ,'dto'=>$dto]);
    }

    public function export(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        if ($this->admininfo['role_id'] == 2) {
            isset($this->admininfo['units_id'])  &&  $dto->setUnitId($this->admininfo['units_id']);
        }
        $byStatistics = ServiceHelper::make('Admin\OrganizationService')->export($dto);

        $header = [
            ['序号','id'],
            ['企业名称','organization_id_name'],
            ['单位类型','new_type_name'],
            ['重点竞赛','competition_name'],
            ['所属工会','unit_id_name'],
            ['联系人', 'username'],
            ['联系电话', 'mobile'],
            ['提报工匠','gj_tb'],
            ['复审工匠','gj_fs'],
            ['巴渝工匠','gj_hj'],
            ['浏览量','by_browse'],
            ['点赞量','by_star'],
        ];

        $excel = [$header,json_decode(json_encode($byStatistics),true),'巴渝工匠企业统计'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }
}