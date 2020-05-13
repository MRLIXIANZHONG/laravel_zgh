<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/20
 * Time: 12:05
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Http\Requests\Admin\UnitRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class WlUnitController extends BaseController
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
        }
        $units->setCollection($collects);

        $role = $this->admininfo['roles'][0]['id'];
        return view('wl_unit.index', compact(['units', 'role', 'search']));
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

        $excel = [$header,json_decode(json_encode($wlUnits),true),'网络技能评选工会统计'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }
}