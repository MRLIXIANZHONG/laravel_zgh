<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Index;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\BrowseCountDTO;
use App\DTO\CraftsmanDTO;
use App\DTO\HomeDTO;
use App\DTO\HomeIndexDTO;
use App\DTO\JudgesDTO;
use App\DTO\NewsDTO;
use App\DTO\NomineeDTO;
use App\DTO\OrganizationsPlanDTO;
use App\DTO\OrganizationsWuxiaoDTO;
use App\DTO\UnitDTO;
use App\Models\BrowseCount;
use App\Models\CaseSchemes;
use App\Models\Organization;
use App\Models\Special_manage;
use App\Models\Unit;
use App\Models\UnitHomePage;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class ByHomeService extends Service
{
    //获取移动端巴渝首页
    public function getByMobieHomeIndex($array)
    {
        /**获取首页赛事精神*/
        $special = Special_manage::query()->where('system_version', 'by')->select(['spirit', 'title_img'])->first();
        /**获取首页赛事精神*/
        $schemes = CaseSchemes::query()->where('type', 8)->where('is_open', '1')->first();
        /**获取首页新闻*/
        $news = ServiceHelper::make('Index\NewsService')->getNewsList(new NewsDTO(['system_version' => 'by', 'pageSize' => '3', 'isShowHome' => 1]));
        /**获取候选工匠*/
        $Craftsman = ServiceHelper::make('Index\CraftsmanService')->getList(new CraftsmanDTO([
            'page' => 1,
            'page_size' => 16,
            'is_craftsmans' => $array['is_craftsman'] != null ? [$array['is_craftsman']] : [1],
        ]));
        $Craftsman = $Craftsman->getCollection();

        $units = Unit::query()->get();
        $orgs = Organization::query()->whereIn('id', $Craftsman->pluck('organization_id'))->get();

        $craftsman = $Craftsman->each(function ($item) use ($units, $orgs) {
            $unit = $units->where('id', $item->unit_id)->first();
            $org = $orgs->where('id', $item->organization_id)->first();

            data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
            data_set($item, 'org_id_name', data_get($org, 'name', ''));
        });


        /**获取历届巴渝工匠*/
        $HistoryCraftsman = ServiceHelper::make('Index\HistoryCraftsmanService')->getList(new CraftsmanDTO([]));

        $hisTorgs = Organization::query()->whereIn('id', $HistoryCraftsman->pluck('organization_id'))->get();

        $historyCraftsman = $HistoryCraftsman->each(function ($item) use ($units, $hisTorgs) {
            $unit = $units->where('id', $item->unit_id)->first();
            $org = $hisTorgs->where('id', $item->organization_id)->first();

            data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
            data_set($item, 'org_id_name', data_get($org, 'name', ''));
        });


        /**获取推荐首页专家*/
        $Judges = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO([
            'isrecommend' => 1,
            'page_size' => 16,
        ]));

        $special_manage = Special_manage::query()->where('id', 2)->first();


        return ['special' => $special, 'schemes' => $schemes, 'Craftsman' => $craftsman, 'HistoryCraftsman' => $historyCraftsman, 'Judges' => $Judges, 'news' => $news, 'special_manage' => $special_manage];
    }

    public function getByPCHomeIndex()
    {
        /**获取首页赛事精神*/
        $special = Special_manage::query()->where('system_version', 'by')->select(['spirit', 'title_img'])->first();
        /**获取首页赛事*/
        $schemes = CaseSchemes::query()->where('type', 8)->where('is_open', '1')->first();
        /**获取首页新闻*/
        $news = ServiceHelper::make('Index\NewsService')->getNewsList(new NewsDTO(['system_version' => 'by', 'pageSize' => '3', 'isShowHome' => 1]));

        /**获取候选工匠*/
//        if ($DTO->getCraftsmanType())
//            //获取当选工匠
        $CraftsmanPage = ServiceHelper::make('Index\CraftsmanService')->getList(new CraftsmanDTO(['is_crafts' => 1, 'pagesize' => 10, 'page' => 1]));
//        else
//            $Craftsman = ServiceHelper::make('Index\CraftsmanService')->getList(new CraftsmanDTO(['is_crafts' => 1, 'pagesize' => 10]));

        $units = Unit::query()->get();
        $orgs = Organization::query()->whereIn('id', $CraftsmanPage->pluck('organization_id'))->get();

        $craftsman = $CraftsmanPage->each(function ($item) use ($units, $orgs) {
            $unit = $units->where('id', $item->unit_id)->first();
            $org = $orgs->where('id', $item->organization_id)->first();

            data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
            data_set($item, 'org_id_name', data_get($org, 'name', ''));
        });

        $CraftsmanPage->setCollection($craftsman);

        /**获取历届巴渝工匠*/
        $HistoryCraftsman = ServiceHelper::make('Index\HistoryCraftsmanService')->getList(new CraftsmanDTO([]));

        $hisTorgs = Organization::query()->whereIn('id', $HistoryCraftsman->pluck('organization_id'))->get();

        $historyCraftsman = $HistoryCraftsman->each(function ($item) use ($units, $hisTorgs) {
            $unit = $units->where('id', $item->unit_id)->first();
            $org = $hisTorgs->where('id', $item->organization_id)->first();

            data_set($item, 'unit_id_name', data_get($unit, 'name', ''));
            data_set($item, 'org_id_name', data_get($org, 'name', ''));
        });


        /**获取推荐首页专家*/
        $Judges = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO(['isrecommend' => 1]));

        $special_manage = Special_manage::query()->where('id', 2)->first();

        return ['special' => $special, 'schemes' => $schemes, 'Craftsman' => $CraftsmanPage, 'HistoryCraftsman' => $historyCraftsman, 'Judges' => $Judges, 'news' => $news, 'special_manage' => $special_manage];
    }

    /**
     * 设置活动 公会 浏览量
     */
    public function setBrowseCount(BrowseCountDTO $dto)
    {
        if ($dto->getId()) {//有ID的说明是巴渝或者是网络评选活动的
            $browse = BrowseCount::query()->where('id', $dto->getId())->first();
        } else if ($dto->getUnitId()) {//公会ID 查询是否存在 存在 浏览量+1  不存在添加一个工会浏览量数据并+1
            $browse = BrowseCount::query()->where('unit_id', $dto->getUnitId())->first();
            if ($browse == null) {
                $browse = new BrowseCount();
                $browse->unit_id = $dto->getUnitId();
                $browse->type = 'gh';//添加公会的
                $browse->browse_count = 0;
                $browse->org_id = 0;
                $browse->save();
            }
        } else if ($dto->getOrgId()) {//企业ID 查询是否存在 存在 浏览量+1  不存在添加一个企业浏览量数据并+1
            $browse = BrowseCount::query()->where('org_id', $dto->getOrgId())->first();
            if ($browse == null) {
                $browse = new BrowseCount();
                $browse->unit_id = 0;
                $browse->type = 'qy';//添加企业
                $browse->browse_count = 0;
                $browse->org_id = $dto->getOrgId();
                $browse->save();
            }
        }
        //活动浏览量+1
        $builder = $browse->increment("browse_count");
        return $builder;
    }

    /**首页统计数据
     * @param HomeIndexDTO $dto
     * @return array
     */
    public function getHomeStatistics($Units_id)
    {
//        $Units_id = $dto->getUnitsId();//公会ID
        /**获取参赛企业，企业已提报方案的才算*/
        $orgSql = "SELECT count(1) num FROM organizations org
WHERE EXISTS (SELECT 1 FROM organizations_plan plan	WHERE org.id = plan.organization_id and plan.check_state>0) 
and org.unit_id =" . $Units_id;
        $org = DB::select($orgSql);

        /**优秀个人*/
        $nomineesSql = "select count(1) num from nominees where  check_status =1 and deleted_at is null and unit_id =" . $Units_id;
        $nominees = DB::select($nomineesSql);

        /**优秀方案*/
        $planSql = "select count(1) num from organizations_plan plan where  check_state >=1 and deleted_at is null and  EXISTS(select 1 from organizations org where plan.organization_id=org.id and org.unit_id=" . $Units_id . ")";
        $plan = DB::select($planSql);

        /**优秀五小*/
        $wuxiaoSql = "select count(1) num from organizations_wuxiao  where  check_state =1 and deleted_at is null and unit_id =" . $Units_id;
        $wuxiao = DB::select($wuxiaoSql);


        /** 活动浏览量*/
        $browseSql = "select ifnull(sum(num),0) num from (
select sum(virtual_traffic+browse_count) num  from news where send_state = 1  and system_version='cqzgh'   and unit_id=" . $Units_id . "
union
select sum(fictitious_browse_count+browse_count) num from  organizations_plan plan where check_state =5  and plan.deleted_at is null and   EXISTS(select 1 from organizations org where plan.organization_id=org.id and org.unit_id=" . $Units_id . ") 
UNION
select sum(v_browse_count+browse_count) num from  organizations_wuxiao where check_state = 1 and deleted_at is null  and unit_id=" . $Units_id . "
UNION
select sum(v_browse_count+browse_count) num from  nominees where check_status = 1 and deleted_at is null and unit_id=" . $Units_id . "
) browse";

        $browse = DB::select($browseSql);
        $starSql = "select ifnull(sum(num),0) num from ( 
select sum(fictitious_star_count+star_count) num from  organizations_plan plan where  check_state =5 and plan.deleted_at is null and EXISTS(select 1 from organizations org where plan.organization_id=org.id and org.unit_id=" . $Units_id . ")
UNION
select sum(v_star_count+star_count) num from  organizations_wuxiao where check_state = 1 and deleted_at is null  and unit_id=" . $Units_id . "
UNION
select sum(v_star_count+star_count) num from  nominees  where check_status = 1 and deleted_at is null  and unit_id=" . $Units_id . "
) star";
        $star = DB::select($starSql);
        $coutn = ["org" => $org[0]->num, "nominees" => $nominees[0]->num, "wuxiao" => $wuxiao[0]->num, "plan" => $plan[0]->num, "browse" => $browse[0]->num, "star" => $star[0]->num];
        return $coutn;
    }


    /**
     * @param int $id
     * @return mixed
     * 获取网络筛选主页
     */
    public function getNetWorkIndex($id = 0)
    {

        if ($id) {
            //新闻数据
            $newDto = new NewsDTO(['system_version' => 'cqzgh']);
            $newDto->setUnit_Id($id);
            $newDto->setIsShowHome(1);
            $newDto->setPageSize(4);
            $array['newList'] = ServiceHelper::make('Index\NewsService')->getNewsList($newDto);

            //优秀个人
            $array['nomineeList'] = ServiceHelper::make('Index\NomineeService')->getList(new NomineeDTO(['recommend' => 1]));
            //优秀五小
            $array['wuxiaoList'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList(new OrganizationsWuxiaoDTO(['recommend' => 1]));

            //优秀方案
            $array['planList'] = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['unit_id' => $id, 'pagesize' => 3, 'isexcellent' => 1]));
            //专家
            $array['judges'] = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO(['pageSize' => 4]));

            //基层工会
            $array['units'] = ServiceHelper::make('Index\UnitService')->getList(new UnitDTO(['page' => 1, 'pageSize' => 16]));

            //竞赛精神
            $array['competition'] = (new NewsService())->getCompetition();

            //获取竞赛进程
            $array['process'] = (new CaseSchemeService())->getProcess();
        } else {
            //新闻数据

            $newDto = new NewsDTO(['system_version' => 'cqzgh']);
            $newDto->setIsShowHome(1);
            $newDto->setPageSize(4);
            $array['newList'] = ServiceHelper::make('Index\NewsService')->getNewsList($newDto);

            //优秀个人
            $array['nomineeList'] = ServiceHelper::make('Index\NomineeService')->getList(new NomineeDTO(['pageSize' => 16,'recommend'=>1]));
            //优秀五小
            $array['wuxiaoList'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList(new OrganizationsWuxiaoDTO(['pageSize' => 6,'recommend' => 1]));

            //优秀方案
            $array['planList'] = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['pagesize' => 3, 'isexcellent' => 1]));

            //专家
            $array['judges'] = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO(['pageSize' => 4]));


            //基层工会
            $array['units'] = ServiceHelper::make('Index\UnitService')->getList(new UnitDTO(['page' => 1, 'pageSize' => 16]));

            //竞赛精神
            $array['competition'] = (new NewsService())->getCompetition();

            //获取竞赛进程
            $array['process'] = (new CaseSchemeService())->getProcess();
        }

        return $array;
    }

    /**
     * @param int $id
     * @return mixed
     * 获取网络筛选pc主页
     */
    public function getNetWorkPcIndex($id = 0)
    {

        if ($id) {
            //新闻数据
            $newDto = new NewsDTO(['system_version' => 'cqzgh']);
            $newDto->setUnit_Id($id);
            $newDto->setIsShowHome(1);
            $newDto->setPageSize(3);
            $array['newList'] = ServiceHelper::make('Index\NewsService')->getNewsList($newDto);


            //优秀个人
            $nominDto = new NomineeDTO(['pageSize' => 4, 'recommend' => 1, 'unit_id' => $id]);

            $nominDto->setIsWinType(1);
//            $array['nomineeList']['all'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
            $array['nomineeList']['all'] =  ServiceHelper::make('Index\NomineeService')->getList(new NomineeDTO(['recommend' => 1, 'pageSize' => 16]));
            dd( $array['nomineeList']['all']);
            $array['nomineeList']['month'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
            $nominDto->setIsWinType(2);
            $array['nomineeList']['quarter'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
            $nominDto->setIsWinType(3);
            $array['nomineeList']['year'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
            //优秀五小
            $wuxiDto = new OrganizationsWuxiaoDTO(['unit_id' => $id, 'pageSize' => 6, 'recommend' => 1]);
            $wuxiDto->setIsWinType(1);
            $array['wuxiaoList']['all'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
            $array['wuxiaoList']['month'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
            $wuxiDto->setIsWinType(2);
            $array['wuxiaoList']['quarter'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
            $wuxiDto->setIsWinType(3);
            $array['wuxiaoList']['year'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);

            //优秀方案
            $array['planList'] = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['unit_id' => $id, 'pagesize' => 4, 'isexcellent' => 1]));
            //专家
            $array['judges'] = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO(['pageSize' => 4]));

            //基层工会
            $array['units'] = ServiceHelper::make('Index\UnitService')->getList(new UnitDTO(['page' => 1, 'pageSize' => 60]));

            //竞赛精神
            $array['competition'] = (new NewsService())->getCompetition();

            //获取竞赛进程
            $array['process'] = (new CaseSchemeService())->getProcess();
        } else {
            //新闻数据

            $newDto = new NewsDTO(['system_version' => 'cqzgh']);
            $newDto->setIsShowHome(1);
            $newDto->setPageSize(3);
            $array['newList'] = ServiceHelper::make('Index\NewsService')->getNewsList($newDto);



            //优秀方案
            $array['planList'] = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['pagesize' => 4, 'isexcellent' => 1]));

            //专家
            $array['judges'] = ServiceHelper::make('Index\JudgesService')->getList(new JudgesDTO(['pageSize' => 4]));


            //基层工会
            $array['units'] = ServiceHelper::make('Index\UnitService')->getList(new UnitDTO(['page' => 1, 'pageSize' => 60]));

            //竞赛精神
            $array['competition'] = (new NewsService())->getCompetition();

            //获取竞赛进程
            $array['process'] = (new CaseSchemeService())->getProcess();
        }

        return $array;
    }

    public function getNetWorkPcIndex_person($kind)
    {
        //优秀个人
        $nominDto = new NomineeDTO([ 'recommend' => 1,'kind'=>$kind]);

        $nominDto->setIsWinType(1);
        $array['nomineeList']['all'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
        $array['nomineeList']['month'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
        $nominDto->setIsWinType(2);
        $array['nomineeList']['quarter'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
        $nominDto->setIsWinType(3);
        $array['nomineeList']['year'] = ServiceHelper::make('Index\NomineeService')->getList($nominDto);
        return $array;
    }


    public function getNetWorkPcIndex_wuxiao($type)
    {
        //优秀五小
        $wuxiDto = new OrganizationsWuxiaoDTO([ 'recommend' => 1,'type'=>$type]);
        $array['wuxiaoList']['all'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
        $wuxiDto->setIsWinType(1);
        $array['wuxiaoList']['month'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
        $wuxiDto->setIsWinType(2);
        $array['wuxiaoList']['quarter'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);
        $wuxiDto->setIsWinType(3);
        $array['wuxiaoList']['year'] = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList($wuxiDto);

        return $array;
    }

    /**
     * @param int $unit_id
     * @return string
     * 获取工会名称
     */
    public function getUnitName($unit_id = 0)
    {
        $name = '';
        if ($unit_id) {
            $name = DB::table('units')->where('id', $unit_id)->value('name');
        }
        return $name;

    }

    /**
     * 获取备案信息
     * @param $sys
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getCopyright($sys)
    {
        return Special_manage::query()->where('system_version', $sys)->first();
    }

    /**
     * 获取备案信息
     * @param $sys
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUninInfo($unitId)
    {
        return UnitHomePage::query()->where('unit_id', $unitId)->first();
    }
}