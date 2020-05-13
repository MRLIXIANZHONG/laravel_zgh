<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/20
 * Time: 18:52
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use DB;

class ZghStatistic extends Command
{
    protected $signature = 'zgh:statistics';

    protected $description = '基于总工会的维度统计各项数据';

    protected $zghStatistics = [];

    protected $unitStatistics = [];

    protected $monthStatistics = [];

    public function handle()
    {
        //审核通过的企业
        $organizations = $this->getOrganization();
        //提报个人
        $organizationYxs = $this->getOrganizationYxs();
        //月度之星
        $organizationYxyus = $this->getOrganizationYxyus();
        //季度之星
        $organizationYxjds = $this->getOrganizationYxjds();
        //年度之星
        $organizationYxnds = $this->getOrganizationYxnds();
        //提报方案
        $organizationFas = $this->getOrganizationFas();
        //方案初审
        $organizationFacss = $this->getOrganizationFacss();
        //方案复审
        $organizationFafss = $this->getOrganizationFafss();
        //节能减排方案数
        $organizationFajnjp = $this->getOrganizationFajnjp();
        //灾害防治方案数
        $organizationFazhfz = $this->getOrganizationFazhfz();
        //安全生产方案数
        $organizationFaaqsc = $this->getOrganizationFaaqsc();
        //脱贫攻坚方案数
        $organizationFatpgj = $this->getOrganizationFatpgj();
        //其他方案数
        $organizationFaqt = $this->getOrganizationFaqt();
        //优秀集体
        $organizationFajts = $this->getOrganizationFajts();
        //提报五小
        $organizationWxs = $this->getOrganizationWxs();
        //月度五小
        $organizationWxyds = $this->getOrganizationWxyds();
        //季度五小
        $organizationWxjds = $this->getOrganizationWxjds();
        //年度五小
        $organizationWxnds = $this->getOrganizationWxnds();
        //提报新闻
        $organizationXws = $this->getOrganizationXws();
        //发布新闻
        $organizationXwfbs = $this->getOrganizationXwfbs();
        //优秀个人浏览量
        $organizationYxBrowse = $this->getOrganizationYxBrowse();
        //优秀个人点赞量
        $organizationYxStar = $this->getOrganizationYxStar();
        //方案浏览量
        $organizationFaBrowse = $this->getOrganizationFaBrowse();
        //方案点赞量
        $organizationFaStar = $this->getOrganizationFaStar();
        //五小浏览量
        $organizationWxBrowse = $this->getOrganizationWxBrowse();
        //五小点赞量
        $organizationWxStar = $this->getOrganizationWxStar();
        //新闻浏览量
        $organizationXwBrowse = $this->getOrganizationXwBrowse();
        //新闻点赞量
        $organizationXwStar = $this->getOrganizationXwStar();
        //巴渝工匠提报数
        $organizationGjtb = $this->getOrganizationGjtb();
        //巴渝工匠通过（复审）数
        $organizationGjfs = $this->getOrganizationGjfs();
        //巴渝工匠获奖数
        $organizationGjhj = $this->getOrganizationGjhj();
        //巴渝工匠浏览量
        $organizationByBrowse = $this->getOrganizationByBrowse();
        //巴渝工匠点赞量
        $organizationByStar = $this->getOrganizationByStar();

        $time = date('Y-m-d H:i:s', time());
        $month = substr($time,5,2);
        collect($organizations)->each(function ($item) use ($organizationYxs, $organizationYxyus, $organizationYxjds, $organizationYxnds,
            $organizationFas, $organizationFacss, $organizationFafss, $organizationFajnjp,$organizationFazhfz,$organizationFaaqsc,
            $organizationFatpgj, $organizationFaqt,$organizationFajts, $organizationWxs, $organizationWxyds,
            $organizationWxjds, $organizationWxnds, $organizationXws, $organizationXwfbs, $organizationYxBrowse, $organizationYxStar,
            $organizationFaBrowse, $organizationFaStar, $organizationWxBrowse, $organizationWxStar, $organizationXwBrowse,
            $organizationXwStar, $organizationGjtb, $organizationGjfs, $organizationGjhj, $organizationByBrowse, $organizationByStar, $time, $month) {
            $data['type'] = 1;
            $data['type_id'] = $item->id;
            $data['yxgr_tb'] = isset($organizationYxs[$item->id]->amount) ? $organizationYxs[$item->id]->amount : 0;
            $data['yxgr_yd'] = isset($organizationYxyus[$item->id]->amount) ? $organizationYxyus[$item->id]->amount : 0;
            $data['yxgr_jd'] = isset($organizationYxjds[$item->id]->amount) ? $organizationYxjds[$item->id]->amount : 0;
            $data['yxgr_nd'] = isset($organizationYxnds[$item->id]->amount) ? $organizationYxnds[$item->id]->amount : 0;
            $data['fa_tb'] = isset($organizationFas[$item->id]->amount) ? $organizationFas[$item->id]->amount : 0;
            $data['fa_cs'] = isset($organizationFacss[$item->id]->amount) ? $organizationFacss[$item->id]->amount : 0;
            $data['fa_fs'] = isset($organizationFafss[$item->id]->amount) ? $organizationFafss[$item->id]->amount : 0;
            $data['fa_jnjp'] = isset($organizationFajnjp[$item->id]->amount) ? $organizationFajnjp[$item->id]->amount : 0;
            $data['fa_zhfz'] = isset($organizationFazhfz[$item->id]->amount) ? $organizationFazhfz[$item->id]->amount : 0;
            $data['fa_aqsc'] = isset($organizationFaaqsc[$item->id]->amount) ? $organizationFaaqsc[$item->id]->amount : 0;
            $data['fa_tpgj'] = isset($organizationFatpgj[$item->id]->amount) ? $organizationFatpgj[$item->id]->amount : 0;
            $data['fa_qt'] = isset($organizationFaqt[$item->id]->amount) ? $organizationFaqt[$item->id]->amount : 0;
            $data['fa_jt'] = isset($organizationFajts[$item->id]->amount) ? $organizationFajts[$item->id]->amount : 0;
            $data['wx_tb'] = isset($organizationWxs[$item->id]->amount) ? $organizationWxs[$item->id]->amount : 0;
            $data['wx_yd'] = isset($organizationWxyds[$item->id]->amount) ? $organizationWxyds[$item->id]->amount : 0;
            $data['wx_jd'] = isset($organizationWxjds[$item->id]->amount) ? $organizationWxjds[$item->id]->amount : 0;
            $data['wx_nd'] = isset($organizationWxnds[$item->id]->amount) ? $organizationWxnds[$item->id]->amount : 0;
            $data['xw_tb'] = isset($organizationXws[$item->id]->amount) ? $organizationXws[$item->id]->amount : 0;
            $data['xw_fb'] = isset($organizationXwfbs[$item->id]->amount) ? $organizationXwfbs[$item->id]->amount : 0;
            $yxBrowse = isset($organizationYxBrowse[$item->id]->amount) ? $organizationYxBrowse[$item->id]->amount : 0;
            $faBrowse = isset($organizationFaBrowse[$item->id]->amount) ? $organizationFaBrowse[$item->id]->amount : 0;
            $wxBrowse = isset($organizationWxBrowse[$item->id]->amount) ? $organizationWxBrowse[$item->id]->amount : 0;
            $xwBrowse = isset($organizationXwBrowse[$item->id]->amount) ? $organizationXwBrowse[$item->id]->amount : 0;
            $data['browse_amount'] = $yxBrowse + $faBrowse + $wxBrowse + $xwBrowse;
            $yxStar = isset($organizationYxStar[$item->id]->amount) ? $organizationYxStar[$item->id]->amount : 0;
            $faStar = isset($organizationFaStar[$item->id]->amount) ? $organizationFaStar[$item->id]->amount : 0;
            $wxStar = isset($organizationWxStar[$item->id]->amount) ? $organizationWxStar[$item->id]->amount : 0;
            $xwStar = isset($organizationXwStar[$item->id]->amount) ? $organizationXwStar[$item->id]->amount : 0;
            $data['star_amount'] = $yxStar + $faStar + $wxStar + $xwStar;
            $data['gj_tb'] = isset($organizationGjtb[$item->id]->amount) ? $organizationGjtb[$item->id]->amount : 0;
            $data['gj_fs'] = isset($organizationGjfs[$item->id]->amount) ? $organizationGjfs[$item->id]->amount : 0;
            $data['gj_hj'] = isset($organizationXwfbs[$item->id]->amount) ? $organizationXwfbs[$item->id]->amount : 0;
            $data['by_browse'] = isset($organizationByBrowse[$item->id]->amount) ? $organizationByBrowse[$item->id]->amount : 0;
            $data['by_star'] = isset($organizationByStar[$item->id]->amount) ? $organizationByStar[$item->id]->amount : 0;
            $data['organization_count'] = 1;
            $data['staff_count'] = $item->staff_count;
            $data['date'] = $time;
            $data['month'] = $month;
            $this->zghStatistics[] = $data;
            unset($data);

        });
        //$this->zghStatistics

        //审核通过的工会
        $units = DB::select("select `id` from `units` where `deleted_at` is null and `check_status` = 1");
        collect($units)->each(function ($item) use ($organizations, $time, $month) {
            $orgIds = collect($organizations)->where('unit_id', $item->id)->pluck('id')->toArray();
            $arr = collect($this->zghStatistics)->whereIn('type_id', $orgIds)->toArray();
            $data['type'] = 2;
            $data['type_id'] = $item->id;
            $data['yxgr_tb'] = array_sum(array_column($arr, 'yxgr_tb'));
            $data['yxgr_yd'] = array_sum(array_column($arr, 'yxgr_yd'));
            $data['yxgr_jd'] = array_sum(array_column($arr, 'yxgr_jd'));
            $data['yxgr_nd'] = array_sum(array_column($arr, 'yxgr_nd'));
            $data['fa_tb'] = array_sum(array_column($arr, 'fa_tb'));
            $data['fa_cs'] = array_sum(array_column($arr, 'fa_cs'));
            $data['fa_fs'] = array_sum(array_column($arr, 'fa_fs'));
            $data['fa_jnjp'] = array_sum(array_column($arr, 'fa_jnjp'));
            $data['fa_zhfz'] = array_sum(array_column($arr, 'fa_zhfz'));
            $data['fa_aqsc'] = array_sum(array_column($arr, 'fa_aqsc'));
            $data['fa_tpgj'] = array_sum(array_column($arr, 'fa_tpgj'));
            $data['fa_qt'] = array_sum(array_column($arr, 'fa_qt'));
            $data['fa_jt'] = array_sum(array_column($arr, 'fa_jt'));
            $data['wx_tb'] = array_sum(array_column($arr, 'wx_tb'));
            $data['wx_yd'] = array_sum(array_column($arr, 'wx_yd'));
            $data['wx_jd'] = array_sum(array_column($arr, 'wx_jd'));
            $data['wx_nd'] = array_sum(array_column($arr, 'wx_nd'));
            $data['xw_tb'] = array_sum(array_column($arr, 'xw_tb'));
            $data['xw_fb'] = array_sum(array_column($arr, 'xw_fb'));
            $data['browse_amount'] = array_sum(array_column($arr, 'browse_amount'));
            $data['star_amount'] = array_sum(array_column($arr, 'star_amount'));
            $data['gj_tb'] = array_sum(array_column($arr, 'gj_tb'));
            $data['gj_fs'] = array_sum(array_column($arr, 'gj_fs'));
            $data['gj_hj'] = array_sum(array_column($arr, 'gj_hj'));
            $data['by_browse'] = array_sum(array_column($arr, 'by_browse'));
            $data['by_star'] = array_sum(array_column($arr, 'by_star'));
            $data['organization_count'] = count($orgIds);
            $data['staff_count'] = array_sum(array_column($arr, 'staff_count'));
            $data['date'] = $time;
            $data['month'] = $month;
            $this->unitStatistics[] = $data;
            unset($data);
        });

        $data['type'] = 3;
        $data['type_id'] = 0;
        $data['yxgr_tb'] = array_sum(array_column($this->unitStatistics,'yxgr_tb'));
        $data['yxgr_yd'] = array_sum(array_column($this->unitStatistics,'yxgr_yd'));
        $data['yxgr_jd'] = array_sum(array_column($this->unitStatistics,'yxgr_jd'));
        $data['yxgr_nd'] = array_sum(array_column($this->unitStatistics,'yxgr_nd'));
        $data['fa_tb'] = array_sum(array_column($this->unitStatistics,'fa_tb'));
        $data['fa_cs'] = array_sum(array_column($this->unitStatistics,'fa_cs'));
        $data['fa_fs'] = array_sum(array_column($this->unitStatistics,'fa_fs'));
        $data['fa_jnjp'] = array_sum(array_column($this->unitStatistics,'fa_jnjp'));
        $data['fa_zhfz'] = array_sum(array_column($this->unitStatistics,'fa_zhfz'));
        $data['fa_aqsc'] = array_sum(array_column($this->unitStatistics,'fa_aqsc'));
        $data['fa_tpgj'] = array_sum(array_column($this->unitStatistics,'fa_tpgj'));
        $data['fa_qt'] = array_sum(array_column($this->unitStatistics,'fa_qt'));
        $data['fa_jt'] = array_sum(array_column($this->unitStatistics,'fa_jt'));
        $data['wx_tb'] = array_sum(array_column($this->unitStatistics,'wx_tb'));
        $data['wx_yd'] = array_sum(array_column($this->unitStatistics,'wx_yd'));
        $data['wx_jd'] = array_sum(array_column($this->unitStatistics,'wx_jd'));
        $data['wx_nd'] = array_sum(array_column($this->unitStatistics,'wx_nd'));
        $data['xw_tb'] = array_sum(array_column($this->unitStatistics,'xw_tb'));
        $data['xw_fb'] = array_sum(array_column($this->unitStatistics,'xw_fb'));
        $data['browse_amount'] = array_sum(array_column($this->unitStatistics,'browse_amount'));
        $data['star_amount'] = array_sum(array_column($this->unitStatistics,'star_amount'));
        $data['gj_tb'] = array_sum(array_column($this->unitStatistics, 'gj_tb'));
        $data['gj_fs'] = array_sum(array_column($this->unitStatistics, 'gj_fs'));
        $data['gj_hj'] = array_sum(array_column($this->unitStatistics, 'gj_hj'));
        $data['by_browse'] = array_sum(array_column($this->unitStatistics, 'by_browse'));
        $data['by_star'] = array_sum(array_column($this->unitStatistics, 'by_star'));
        $data['staff_count'] = array_sum(array_column($this->unitStatistics, 'staff_count'));
        $data['date'] = $time;
        $data['month'] = $month;

        collect($this->zghStatistics)->each(function ($item) use ($time) {
            $res = DB::table('zgh_statistics')->where('type',$item['type'])
                ->where('type_id',$item['type_id'])->where('date',$time)->first();
            if($res != null) {
                DB::table('zgh_statistics')->where('type',$item['type'])->where('type_id',$item['type_id'])
                    ->where('date',$time)->update([
                        'yxgr_tb' => $item['yxgr_tb'],
                        'yxgr_yd' => $item['yxgr_yd'],
                        'yxgr_jd' => $item['yxgr_jd'],
                        'yxgr_nd' => $item['yxgr_nd'],
                        'fa_tb'   => $item['fa_tb'],
                        'fa_cs'   => $item['fa_cs'],
                        'fa_fs'   => $item['fa_fs'],
                        'fa_jt'   => $item['fa_jt'],
                        'wx_tb'   => $item['wx_tb'],
                        'wx_yd'   => $item['wx_yd'],
                        'wx_jd'   => $item['wx_jd'],
                        'wx_nd'   => $item['wx_nd'],
                        'xw_tb'   => $item['xw_tb'],
                        'xw_fb'   => $item['xw_fb'],
                        'browse_amount'  => $item['browse_amount'],
                        'star_amount'    => $item['star_amount'],
                        'gj_tb'   => $item['gj_tb'],
                        'gj_fs'   => $item['gj_fs'],
                        'gj_hj'   => $item['gj_hj'],
                        'by_browse'  => $item['by_browse'],
                        'by_star' => $item['by_star'],
                        'staff_count' => $item['staff_count'],
                        'organization_count' => 1,
                    ]);
                $this->info(date('Y-m-d H:i:s', time()).': update organization success '.$item['type_id']);
            } else {
                DB::table('zgh_statistics')->insert($item);
                $this->info(date('Y-m-d H:i:s', time()).': insert organization finished '.$item['type_id']);
            }
        });

        collect($this->unitStatistics)->each(function ($item) use ($time) {
            $res = DB::table('zgh_statistics')->where('type',$item['type'])
                ->where('type_id',$item['type_id'])->where('date',$time)->first();
            if ($res != null) {
                DB::table('zgh_statistics')->where('type',$item['type_id'])->where('type_id',$item['type_id'])
                    ->where('date',$time)->update([
                        'yxgr_tb' => $item['yxgr_tb'],
                        'yxgr_yd' => $item['yxgr_yd'],
                        'yxgr_jd' => $item['yxgr_jd'],
                        'yxgr_nd' => $item['yxgr_nd'],
                        'fa_tb'   => $item['fa_tb'],
                        'fa_cs'   => $item['fa_cs'],
                        'fa_fs'   => $item['fa_fs'],
                        'fa_jt'   => $item['fa_jt'],
                        'wx_tb'   => $item['wx_tb'],
                        'wx_yd'   => $item['wx_yd'],
                        'wx_jd'   => $item['wx_jd'],
                        'wx_nd'   => $item['wx_nd'],
                        'xw_tb'   => $item['xw_tb'],
                        'xw_fb'   => $item['xw_fb'],
                        'browse_amount'  => $item['browse_amount'],
                        'star_amount'    => $item['star_amount'],
                        'gj_tb'   => $item['gj_tb'],
                        'gj_fs'   => $item['gj_fs'],
                        'gj_hj'   => $item['gj_hj'],
                        'by_browse'  => $item['by_browse'],
                        'by_star' => $item['by_star'],
                        'staff_count' => $item['staff_count'],
                        'organization_count' => $item['organization_count'],
                    ]);
                $this->info(date('Y-m-d H:i:s', time()).': update unit finished '.$item['type_id']);
            } else {
                DB::table('zgh_statistics')->insert($item);
                $this->info(date('Y-m-d H:i:s', time()).': insert unit finished '.$item['type_id']);
            }

        });

        $res = DB::table('zgh_statistics')->where('type',$data['type'])
            ->where('type_id',$data['type_id'])->where('date',$time)->first();
        if ($res != null) {
            DB::table('zgh_statistics')->where('type',$data['type'])->where('type_id',$data['type_id'])
                ->where('date',$time)->update([
                    'yxgr_tb' => $data['yxgr_tb'],
                    'yxgr_yd' => $data['yxgr_yd'],
                    'yxgr_jd' => $data['yxgr_jd'],
                    'yxgr_nd' => $data['yxgr_nd'],
                    'fa_tb'   => $data['fa_tb'],
                    'fa_cs'   => $data['fa_cs'],
                    'fa_fs'   => $data['fa_fs'],
                    'fa_jt'   => $data['fa_jt'],
                    'wx_tb'   => $data['wx_tb'],
                    'wx_yd'   => $data['wx_yd'],
                    'wx_jd'   => $data['wx_jd'],
                    'wx_nd'   => $data['wx_nd'],
                    'xw_tb'   => $data['xw_tb'],
                    'xw_fb'   => $data['xw_fb'],
                    'browse_amount'  => $data['browse_amount'],
                    'star_amount'    => $data['star_amount'],
                    'gj_tb'   => $data['gj_tb'],
                    'gj_fs'   => $data['gj_fs'],
                    'gj_hj'   => $data['gj_hj'],
                    'by_browse'  => $data['by_browse'],
                    'by_star' => $data['by_star'],
                    'staff_count' => $data['staff_count'],
                ]);
        } else {
            DB::table('zgh_statistics')->insert($data);
        }

        $res = DB::table('zgh_statistics')->where('type',4)->where('date',$month)->first();
        if ($res != null) {
            DB::table('zgh_statistics')->where('type',4)->where('date',$month)->update([
                'yxgr_tb' => $data['yxgr_tb'],
                'yxgr_yd' => $data['yxgr_yd'],
                'yxgr_jd' => $data['yxgr_jd'],
                'yxgr_nd' => $data['yxgr_nd'],
                'fa_tb'   => $data['fa_tb'],
                'fa_cs'   => $data['fa_cs'],
                'fa_fs'   => $data['fa_fs'],
                'fa_jt'   => $data['fa_jt'],
                'wx_tb'   => $data['wx_tb'],
                'wx_yd'   => $data['wx_yd'],
                'wx_jd'   => $data['wx_jd'],
                'wx_nd'   => $data['wx_nd'],
                'xw_tb'   => $data['xw_tb'],
                'xw_fb'   => $data['xw_fb'],
                'browse_amount'  => $data['browse_amount'],
                'star_amount'    => $data['star_amount'],
                'gj_tb'   => $data['gj_tb'],
                'gj_fs'   => $data['gj_fs'],
                'gj_hj'   => $data['gj_hj'],
                'by_browse'  => $data['by_browse'],
                'by_star' => $data['by_star'],
                'staff_count' => $data['staff_count'],
            ]);
        } else {
            $data['type'] = 4;
            DB::table('zgh_statistics')->insert($data);
        }

        $this->info('all success');

    }
    //审核通过的企业
    public function getOrganization()
    {
        $organizations = DB::select("select `id`,`unit_id`,`staff_count` from `organizations` where `deleted_at` is null and `check_state` = 2");
        return $organizations;
    }

    //提报个人
    public function getOrganizationYxs()
    {
        $arr = [];
        $organizationYxs = DB::select("select `organization_id`,count(*) as `amount` from `nominees` where `deleted_at` is null and 
        `declare_status` = 1 group by `organization_id`");
        foreach ($organizationYxs as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //月度之星
    public function getOrganizationYxyus()
    {
        $arr = [];
        $organizationYxyus = DB::select("select `organization_id`,count(*) as `amount` from `nominees` where `deleted_at` is null and 
        `month_win` is not null group by `organization_id`");
        foreach ($organizationYxyus as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //季度之星
    public function getOrganizationYxjds()
    {
        $arr = [];
        $organizationYxjds = DB::select("select `organization_id`,count(*) as `amount` from `nominees` where `deleted_at` is null and 
        `quarter_win` is not null group by `organization_id`");
        foreach ($organizationYxjds as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //年度之星
    public function getOrganizationYxnds()
    {
        $arr = [];
        $organizationYxnds = DB::select("select `organization_id`,count(*) as `amount` from `nominees` where `deleted_at` is null and 
        `year_win` is not null group by `organization_id`;");
        foreach ($organizationYxnds as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //提报方案
    public function getOrganizationFas()
    {
        $organizationFas = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` != 1 group by `organization_id`");
        foreach ($organizationFas as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //方案初审
    public function getOrganizationFacss()
    {
        $arr = [];
        $organizationFacss = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (1,2,3,-3,4,5,-5) group by `organization_id`");
        foreach ($organizationFacss as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //方案复审
    public function getOrganizationFafss()
    {
        $arr = [];
        $organizationFafss = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) group by `organization_id`");
        foreach ($organizationFafss as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //节能减排方案数
    public function getOrganizationFajnjp()
    {
        $arr = [];
        $organizationFajnjp = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) and `plan_theme` = 1 group by `organization_id`");
        foreach ($organizationFajnjp as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //灾害防治方案数
    public function getOrganizationFazhfz()
    {
        $arr = [];
        $organizationFazhfz = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) and `plan_theme` = 2 group by `organization_id`");
        foreach ($organizationFazhfz as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //安全生产方案数
    public function getOrganizationFaaqsc()
    {
        $arr = [];
        $organizationFaaqsc = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) and `plan_theme` = 3 group by `organization_id`");
        foreach ($organizationFaaqsc as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //脱贫攻坚方案数
    public function getOrganizationFatpgj()
    {
        $arr = [];
        $organizationFatpgj = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) and `plan_theme` = 4 group by `organization_id`");
        foreach ($organizationFatpgj as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //其他方案数
    public function getOrganizationFaqt()
    {
        $arr = [];
        $organizationFaqt = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `check_state` in (5) and `plan_theme` = 5 group by `organization_id`");
        foreach ($organizationFaqt as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //优秀集体
    public function getOrganizationFajts()
    {
        $arr = [];
        $organizationFajts = DB::select("select `organization_id`,count(*) as `amount` from `organizations_plan` where `deleted_at` is null 
        and `isexcellent` = 1 group by `organization_id`");
        foreach ($organizationFajts as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //提报五小
    public function getOrganizationWxs()
    {
        $arr = [];
        $organizationWxs = DB::select("select `organization_id`,count(*) as `amount` from `organizations_wuxiao` where `deleted_at` is null 
        and `declaration_state` = 1 group by `organization_id`");
        foreach ($organizationWxs as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //月度五小
    public function getOrganizationWxyds()
    {
        $arr = [];
        $organizationWxyds = DB::select("select `organization_id`,count(*) as `amount` from `organizations_wuxiao` where `deleted_at` is null 
        and `month_win` is not null group by `organization_id`");
        foreach ($organizationWxyds as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //季度五小
    public function getOrganizationWxjds()
    {
        $arr = [];
        $organizationWxjds = DB::select("select `organization_id`,count(*) as `amount` from `organizations_wuxiao` where `deleted_at` is null 
        and `quarter_win` is not null group by `organization_id`");
        foreach ($organizationWxjds as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //年度五小
    public function getOrganizationWxnds()
    {
        $arr = [];
        $organizationWxnds = DB::select("select `organization_id`,count(*) as `amount` from `organizations_wuxiao` where `deleted_at` is null 
        and `year_win` is not null group by `organization_id`");
        foreach ($organizationWxnds as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //提报新闻
    public function getOrganizationXws()
    {
        $arr = [];
        $organizationXws = DB::select("select `organization_id`,count(*) as `amount` from `news` where `deleted_at` is null and `news_type` = 2 
        and `check_state` != 0 group by `organization_id`");
        foreach ($organizationXws as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //发布新闻
    public function getOrganizationXwfbs()
    {
        $arr = [];
        $organizationXwfbs = DB::select("select `organization_id`,count(*) as `amount` from `news` where `deleted_at` is null and `news_type` = 2 
        and `send_state` = 1 group by `organization_id`");
        foreach ($organizationXwfbs as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //优秀个人浏览量
    public function getOrganizationYxBrowse()
    {
        $arr = [];
        $organizationYxBrowse = DB::select("select `organization_id`,sum(`browse_count`) as `amount` from `nominees` group by `organization_id`");
        foreach ($organizationYxBrowse as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //优秀个人点赞量
    public function getOrganizationYxStar()
    {
        $arr = [];
        $organizationYxStar = DB::select("select `organization_id`,sum(`star_count`) as `amount` from `nominees` group by `organization_id`");
        foreach ($organizationYxStar as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //方案浏览量
    public function getOrganizationFaBrowse()
    {
        $arr = [];
        $organizationFaBrowse = DB::select("select `organization_id`,sum(`browse_count`) as `amount` from `organizations_plan` group by `organization_id`");
        foreach ($organizationFaBrowse as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //方案点赞量
    public function getOrganizationFaStar()
    {
        $arr = [];
        $organizationFaStar = DB::select("select `organization_id`,sum(`star_count`) as `amount` from `organizations_plan` group by `organization_id`");
        foreach ($organizationFaStar as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //五小浏览量
    public function getOrganizationWxBrowse()
    {
        $arr = [];
        $organizationWxBrowse = DB::select("select `organization_id`,sum(`browse_count`) as `amount` from `organizations_wuxiao` group by `organization_id`");
        foreach ($organizationWxBrowse as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //五小点赞量
    public function getOrganizationWxStar()
    {
        $arr = [];
        $organizationWxStar = DB::select("select `organization_id`,sum(`star_count`) as `amount` from `organizations_wuxiao` group by `organization_id`");
        foreach ($organizationWxStar as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //新闻浏览量
    public function getOrganizationXwBrowse()
    {
        $arr = [];
        $organizationXwBrowse = DB::select("select `organization_id`,sum(`browse_count`) as `amount` from `news` group by `organization_id`");
        foreach ($organizationXwBrowse as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //新闻点赞量
    public function getOrganizationXwStar()
    {
        $arr = [];
        $organizationXwStar = DB::select("select `organization_id`,sum(`star_count`) as `amount` from `news` group by `organization_id`");
        foreach ($organizationXwStar as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //巴渝工匠提报数
    public function getOrganizationGjtb()
    {
        $arr = [];
        $organizationGjtb = DB::select("select `organization_id`,count(*) as `amount` from `craftsmans` where `deleted_at` is null 
        and `check_status` != 0 group by `organization_id`");
        foreach ($organizationGjtb as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //巴渝工匠通过（复审）数
    public function getOrganizationGjfs()
    {
        $arr = [];
        $organizationGjfs = DB::select("select `organization_id`,count(*) as `amount` from `craftsmans` where `deleted_at` is null 
        and `is_craftsman` = 1 group by `organization_id`");
        foreach ($organizationGjfs as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //巴渝工匠获奖数
    public function getOrganizationGjhj()
    {
        $arr = [];
        $organizationGjhj = DB::select("select `organization_id`,count(*) as `amount` from `craftsmans` where `deleted_at` is null 
        and `is_craftsman` = 2 group by `organization_id`");
        foreach ($organizationGjhj as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //巴渝工匠浏览量
    public function getOrganizationByBrowse()
    {
        $arr = [];
        $organizationByBrowse = DB::select("select `organization_id`,sum(`browse_amount`) as `amount` from `craftsmans` where `deleted_at` is null 
        group by `organization_id`");
        foreach ($organizationByBrowse as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }
    //巴渝工匠点赞量
    public function getOrganizationByStar()
    {
        $arr = [];
        $organizationByStar = DB::select("select `organization_id`,count(`star`) as `amount` from `craftsmans` where `deleted_at` is null 
        group by `organization_id`");
        foreach ($organizationByStar as $item) {
            $arr[$item->organization_id] = $item;
        }
        return $arr;
    }

}