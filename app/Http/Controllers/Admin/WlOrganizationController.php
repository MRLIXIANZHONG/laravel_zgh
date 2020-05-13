<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/20
 * Time: 0:21
 */

namespace App\Http\Controllers\Admin;

use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Requests\Admin\OrganizationRequest;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class WlOrganizationController extends BaseController
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
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        if ($this->admininfo['units_id'] != null) {
            $dto->setUnitId($this->admininfo['units_id']);
        }
        $search = [
            'name'  =>  $dto->getName(),
            'new_type' => $dto->getNewType(),
            'check_state' => $dto->getCheckState(),
            'is_competition' => $dto->getIsCompetition(),
            'unit_id'  =>   $dto->getUnitId(),
        ];
        $dto->setCheckStates([2]);
        $organizations = ServiceHelper::make('Admin\OrganizationService')->getList($dto);

        if ($organizations instanceof LengthAwarePaginator) {

            $units = ServiceHelper::make('Admin\UnitService')->getList(new UnitDTO([
                'ids'  =>  $organizations->getCollection()->pluck('unit_id')->toArray(),
                'location' => true,
            ]));

            $organizationIds = $organizations->getCollection()->pluck('id')->toArray();
            $maxDateTime = DB::select("select `date` from `zgh_statistics` order by `date` desc limit 1");
            if (!empty($maxDateTime)) {
                $statistics = DB::table('zgh_statistics')->whereIn('type_id',$organizationIds)->where('type',1)
                    ->where('date', $maxDateTime[0]->date)->get();
            } else {
                $statistics = DB::table('zgh_statistics')->whereIn('type_id',$organizationIds)->where('type',1)->get();
            }

            $collects = $organizations->getCollection()->each(function ($item) use ($units,$statistics) {
                $unit = $units->where('id', $item->unit_id)->first();
                $statistic = $statistics->where('type_id',$item->id)->first();
                data_set($item, 'unit_id_name', data_get($unit, 'name',''));
                data_set($item, 'yxgr_tb', data_get($statistic, 'yxgr_tb', 0));
                data_set($item, 'yxgr_yd', data_get($statistic, 'yxgr_yd', 0));
                data_set($item, 'yxgr_jd', data_get($statistic, 'yxgr_jd', 0));
                data_set($item, 'yxgr_nd', data_get($statistic, 'yxgr_nd', 0));
                data_set($item, 'fa_tb', data_get($statistic, 'fa_tb', 0));
                data_set($item, 'fa_cs', data_get($statistic, 'fa_cs', 0));
                data_set($item, 'fa_fs', data_get($statistic, 'fa_fs', 0));
                data_set($item, 'fa_jnjp', data_get($statistic, 'fa_jnjp', 0));
                data_set($item, 'fa_zhfz', data_get($statistic, 'fa_zhfz', 0));
                data_set($item, 'fa_aqsc', data_get($statistic, 'fa_aqsc', 0));
                data_set($item, 'fa_tpgj', data_get($statistic, 'fa_tpgj', 0));
                data_set($item, 'fa_qt', data_get($statistic, 'fa_qt', 0));
                data_set($item, 'fa_jt', data_get($statistic, 'fa_jt', 0));
                data_set($item, 'wx_tb', data_get($statistic, 'wx_tb', 0));
                data_set($item, 'wx_yd', data_get($statistic, 'wx_yd', 0));
                data_set($item, 'wx_jd', data_get($statistic, 'fa_fs', 0));
                data_set($item, 'wx_nd', data_get($statistic, 'fa_jt', 0));
                data_set($item, 'xw_tb', data_get($statistic, 'wx_tb', 0));
                data_set($item, 'xw_fb', data_get($statistic, 'wx_yd', 0));
                data_set($item,'browse_amount',data_get($statistic,'browse_amount',0) + data_get($item,'virtual_browse',0));
                data_set($item,'star_amount',data_get($statistic,'star_amount',0) + data_get($item,'virtual_star',0));

            });

            $organizations->setCollection($collects);
        }
        $role = $this->admininfo['roles'][0]['id'];
        return view('wl_organization.index', ['organizations' => $organizations, 'role' => $role, 'units' => $units, 'search' => $search]);
    }

    public function export(OrganizationRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        if ($this->admininfo['role_id'] == 2) {
            isset($this->admininfo['units_id'])  &&  $dto->setUnitId($this->admininfo['units_id']);
        }
        $wlStatistics = ServiceHelper::make('Admin\OrganizationService')->export($dto);

        $header = [
            ['序号','id'],
            ['企业名称','organization_id_name'],
            ['单位类型','new_type_name'],
            ['重点竞赛','competition_name'],
            ['所属工会','unit_id_name'],
            ['联系人', 'username'],
            ['联系电话', 'mobile'],
            ['提报个人','yxgr_tb'],
            ['月度之星','yxgr_yd'],
            ['季度之星','yxgr_jd'],
            ['年度之星','yxgr_nd'],
            ['提报方案','fa_tb'],
            ['初审方案','fa_cs'],
            ['复审方案','fa_fs'],
            ['节能减排','fa_jnjp'],
            ['灾害防治','fa_zhfz'],
            ['安全生产','fa_aqsc'],
            ['脱贫攻坚','fa_tpgj'],
            ['其他方案','fa_qt'],
            ['优秀集体','fa_jt'],
            ['提报五小','wx_tb'],
            ['月度五小','wx_yd'],
            ['季度五小','wx_jd'],
            ['年度五小','wx_nd'],
            ['提报新闻','xw_tb'],
            ['发布新闻','xw_fb'],
            ['浏览量','browse_amount'],
            ['点赞量','star_amount'],
        ];

        $excel = [$header,json_decode(json_encode($wlStatistics),true),'网络技能评选企业统计'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }
}