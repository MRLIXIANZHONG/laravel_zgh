<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Admin;


use App\DTO\HomeIndexDTO;
use App\Models\News;
use App\Models\Nominee;
use App\Models\Organization;
use App\Models\OrganizationsPlan;
use App\Models\OrganizationsWuxiao;
use App\Models\Unit;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class HomeIndexService extends Service
{
    /**获取首页统计
     * @return json
     */
    public function getHomeStatistics(HomeIndexDTO $dto)
    {
        $Org_Id = $dto->getOrgId();//企业ID
        $Units_id = $dto->getUnitsId();//公会ID
        $systemVersion = $dto->getSystemVersion();//版本号
        $role_slug = $dto->getRoleSlug();//获取角色类型 administrator  平台管理员 union 工会     enterprise 企业  adminunion 总工会

        $unit = Unit::select(DB::raw('count(1) count')); //公会总数
        $org = Organization::select(DB::raw('count(1) count'));//企业总数
        $nominees = Nominee::select(DB::raw('count(1) count'));//优秀个人总数
        $organizations_plan = OrganizationsPlan::select(DB::raw('count(1) count'));//优秀方案总数
        $organizations_wuxiao = OrganizationsWuxiao::select(DB::raw('count(1) count'))->where('check_state', 1);//申报五小 审核通过的
        $news = News::select(DB::raw('count(1) count'))->where('check_state', 2)->where('system_version', $systemVersion);
//查询总浏览量的条件
        $sql_where = "";


        //企业查看自己的
        if ($role_slug == "enterprise") {
            $unit->where('id', $Units_id);
            $org->where('id', $Org_Id);
            $nominees->where('organization_id', $Org_Id);
            $organizations_plan->where('organization_id', $Org_Id);
            $organizations_wuxiao->where('organization_id', $Org_Id);
            $news->where('organization_id', $Org_Id);

            $sql_where = " and organization_id = " . $Org_Id;
        } else if ($role_slug == "union") {//公会查看自己和自己下面所有企业的

            $unit->where('id', $Units_id);
            $org->where('unit_id', $Units_id);
            $nominees->where('unit_id', $Units_id);
            $organizations_plan->join('organizations', 'organizations.id', 'organizations_plan.organization_id')->where('organizations.unit_id', $Units_id);
            $organizations_wuxiao->where('unit_id', $Units_id);
            $news->where('unit_id', $Units_id);

            $sql_where = " and unit_id = " . $Units_id;
        }

        $sql = "select ifnull(sum(virtual_traffic+browse_count),0) count from news where check_state = 1 and  system_version=:systemVersion " . $sql_where;
        $browseCount = DB::select($sql, ["systemVersion" => $systemVersion]);

        //优秀方案 审核通过的
        $organizations_plan->where('organizations_plan.check_state', 5);

        $count = ["unit" => $unit->first(), 'org' => $org->first(), 'nominees' => $nominees->first(),
            'organizations_plan' => $organizations_plan->first(), 'organizations_wuxiao' => $organizations_wuxiao->first(), 'news' => $news->first()];

        return ["respon" => $count, "browseCount" => $browseCount];
    }

    /**获取企业首页数据*/
    public function getEnterpriseHome(HomeIndexDTO $dto)
    {
        /**企业优秀个人 type 1 申报 2 通过 3 获奖*/
        $Org_Id = $dto->getOrgId();//企业ID
        $nomineesSql = "select count(1) num,1 type from nominees where declare_status = 1 and deleted_at is null and organization_id=" . $Org_Id . "
union 
select count(1) num,2 type from nominees where check_status = 1 and deleted_at is null  and organization_id=" . $Org_Id . "
union
select sum(num) num,3 type  from (
select count(1) num from nominees  where  month_win is not null   and deleted_at is null  and organization_id=" . $Org_Id . "
UNION
select count(1) num from nominees  where  quarter_win is not null   and deleted_at is null  and organization_id=" . $Org_Id . "
union
select count(1) num from nominees  where  year_win is not null   and deleted_at is null  and organization_id=" . $Org_Id . ") nominees";
        $nominees = DB::select($nomineesSql);
        /** 企业优秀五小  type 1 申报 2 通过 3 获奖*/
        $wuxaioSql = "select count(1) num,1 type from organizations_wuxiao where declaration_state = 1 and deleted_at is null and organization_id=" . $Org_Id . "
union 
select count(1) num,2 type from organizations_wuxiao where check_state = 1 and deleted_at is null   and organization_id=" . $Org_Id . "
union
select sum(num) num,3 type  from (
select count(1) num from organizations_wuxiao  where check_state = 1 and month_win is not null   and deleted_at is null and organization_id=" . $Org_Id . "
UNION
select count(1) num from organizations_wuxiao  where check_state = 1 and quarter_win is not null   and deleted_at is null and organization_id=" . $Org_Id . "
union
select count(1) num from organizations_wuxiao  where check_state = 1 and year_win is not null   and deleted_at is null and organization_id=" . $Org_Id . " ) wuxiao";
        $wuxiao = DB::select($wuxaioSql);

        /**企业优秀方案  type 1 申报 2 通过 */
        $planSql = "select count(1) num,1 type from organizations_plan where check_state = 0 and deleted_at is null  and organization_id=" . $Org_Id . "
union 
select count(1) num,2 type from organizations_plan where check_state = 5 and deleted_at is null  and organization_id=" . $Org_Id;
        $plan = DB::select($planSql);

        /**新闻  type 1 提报 2 发布 */
        $newsSql = "select count(1) num,1 type from news where check_state>0 and system_version='cqzgh'  and organization_id=" . $Org_Id . "
union
select count(1)num ,2 type from news where send_state=1  and system_version='cqzgh'  and organization_id=" . $Org_Id;
        $news = DB::select($newsSql);

        /** 活动浏览量*/
        $browseSql = "select ifnull(sum(num),0) num from (
select sum(browse_count) num  from browse_count where org_id=" . $Org_Id . "
UNION
select sum(virtual_traffic+browse_count) num  from news where send_state = 1  and system_version='cqzgh'   and organization_id=" . $Org_Id . "
UNION
select sum(fictitious_browse_count+browse_count) num from  organizations_plan where check_state =5 and organization_id=" . $Org_Id . "
UNION
select sum(v_browse_count+browse_count) num from  organizations_wuxiao where check_state = 1   and organization_id=" . $Org_Id . "
UNION
select sum(v_browse_count+browse_count) num from  nominees where check_status = 1   and organization_id=" . $Org_Id . "
) browse";
        $browse = DB::select($browseSql);

        $starSql = "select ifnull(sum(num),0) num from ( 
select sum(fictitious_star_count+star_count) num from  organizations_plan where  check_state =5 and organization_id=" . $Org_Id . "
UNION
select sum(v_star_count+star_count) num from  organizations_wuxiao where check_state = 1   and organization_id=" . $Org_Id . "
UNION
select sum(v_star_count+star_count) num from  nominees  where check_status = 1   and organization_id=" . $Org_Id . "
) star";
        $star = DB::select($starSql);
        return $coutn = ["nominees" => $nominees, "wuxiao" => $wuxiao, "plan" => $plan, "news" => $news, "browse" => $browse, "star" => $star];

    }

    /**获取公会首页数据*/
    public function getUnionHome(HomeIndexDTO $dto)
    {
        $Units_id = $dto->getUnitsId();//公会ID
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

        /**新闻   */
        $newsSql = "select count(1) num from news where check_state>0 and check_stage>=1 and system_version='cqzgh' and deleted_at is null  and unit_id=" . $Units_id;
        $news = DB::select($newsSql);

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
        $coutn = ["org" => $org, "nominees" => $nominees, "wuxiao" => $wuxiao, "plan" => $plan, "news" => $news, "browse" => $browse, "star" => $star];
        return $coutn;
    }

    /**获取活动方 总工会 首页数据*/
    public function getAdminUnionHome(HomeIndexDTO $dto)
    {
        /**获取公会总数，企业已提报方案的才算*/
        $unitSql = "select count(1) num from units u where deleted_at is null and  EXISTS(select 1 from organizations o inner join organizations_plan p on o.id =p.organization_id where u.id = o.unit_id and p.check_state>0) ";
        $unit = DB::select($unitSql);

        /**获取企业总数，审核通过的*/
        $orgSql = "select count(1) num,sum(staff_count) staff_count from organizations where check_state =2";
        $org = DB::select($orgSql);

        /**优秀个人*/
        $nomineesSql = "select count(1) num from nominees where  check_status =1 and deleted_at is null ";
        $nominees = DB::select($nomineesSql);

        /**优秀方案 农民工数量*/
        $planSql = "select count(1) num,sum(farmer_count) farmer_count from organizations_plan plan where  check_state >=1 ";
        $plan = DB::select($planSql);

        /**优秀五小*/
        $wuxiaoSql = "select count(1) num from organizations_wuxiao  where  check_state =1 and deleted_at is null";
        $wuxiao = DB::select($wuxiaoSql);

        /**获取新闻总数*/
        $newsSql = "select count(1) num from news  where  send_state =1 and deleted_at is null";
        $news = DB::select($newsSql);

        /**获取专家数量*/
        $judgesSql = "select count(1) num from judges  where  check_state =1 ";
        $judges = DB::select($judgesSql);

        /** 活动浏览量*/
        $browseSql = "select ifnull(sum(num),0) num from (
select sum(browse_count) num  from browse_count where type in('by','cqzgh') 
union
select sum(virtual_traffic+browse_count) num  from news where send_state = 1 
union
select sum(fictitious_browse_count+browse_count) num from  organizations_plan plan where check_state =5  and plan.deleted_at is null 
UNION
select sum(v_browse_count+browse_count) num from  organizations_wuxiao where check_state = 1 and deleted_at is null 
UNION
select sum(v_browse_count+browse_count) num from  nominees where check_status = 1 and deleted_at is null) browse";

        $browse = DB::select($browseSql);
        $starSql = "select ifnull(sum(num),0) num from ( 
select sum(fictitious_star_count+star_count) num from  organizations_plan plan where  check_state =5 and plan.deleted_at is null
UNION
select sum(v_star_count+star_count) num from  organizations_wuxiao where check_state = 1 and deleted_at is null 
UNION
select sum(v_star_count+star_count) num from  nominees  where check_status = 1 and deleted_at is null 
) star";
        $star = DB::select($starSql);

        $coutn = ["unit" => $unit, "org" => $org, "nominees" => $nominees, "wuxiao" => $wuxiao, "plan" => $plan, "news" => $news, "judges" => $judges, "browse" => $browse, "star" => $star];
        return $coutn;
    }


    /**获取巴渝公会首页数据*/
    public function getByUnionHome(HomeIndexDTO $dto)
    {
        $Units_id = $dto->getUnitsId();//公会ID

        /**获取数据 */
        $dataSql = "
select count(1) num,1 type from organizations where deleted_at is null and unit_id = " . $Units_id . "
union
select count(1) num,2 type from organizations where check_state = 2 and unit_id =" . $Units_id . "
union
select count(1) num,3 type from craftsmans where check_status >1 and unit_id=" . $Units_id . "
union
select count(1) num,4 type from craftsmans where check_status >3 and unit_id =" . $Units_id . "
union
select sum(star+virtual_star) num ,5 type from craftsmans where unit_id =  " . $Units_id . "
union
select sum(num) num,6 type from (
select sum(browse_amount+virtual_browse) num from craftsmans where  unit_id = " . $Units_id . "
union
select sum(browse_count+virtual_traffic) num from news where system_version = 'by' and  send_state = 1 and unit_id = " . $Units_id . "
) a";
        $data = DB::select($dataSql);
        $coutn = ["data" => $data];
        return $coutn;
    }

    /**获取巴渝公会首页数据*/
    public function getByAdminUnionHome(HomeIndexDTO $dto)
    {
        /**获取工匠 */
        $dataSql = "
select count(1) num,1 type from units u where deleted_at is null and  EXISTS(select 1 from organizations o inner join organizations_plan p on o.id =p.organization_id where u.id = o.unit_id and p.check_state>0) 
union
select count(1) num,2 type from organizations where   check_state =2 and deleted_at is null
union
select count(1) num,3 type from craftsmans where  is_craftsman<>0
union
select count(1) num,4 type from news where check_state=2 and system_version = 'by'
union
select sum(star+virtual_star) num ,5 type from craftsmans 
union
select sum(num) num,6 type from (
select sum(browse_amount+virtual_browse) num from craftsmans 
union
select sum(browse_count+virtual_traffic) num from news where system_version = 'by' and  check_state = 2
) a";
        $data = DB::select($dataSql);
        $coutn = ["data" => $data];
        return $coutn;
    }

    /**
     * 获取企业优秀个人数据
     * @param $arr
     */
    public function getPersonData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(yxgr_tb) as tb,
             SUM(yxgr_yd) as tg,
             SUM(yxgr_yd+yxgr_jd+yxgr_nd) as hj,
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(yxgr_tb) as tb,
             SUM(yxgr_yd) as tg,
             SUM(yxgr_yd+yxgr_jd+yxgr_nd) as hj,
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }


    /**
     * 获取企业优秀五小
     * @param $arr
     */
    public function getFiveSmallData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(wx_tb) as tb,
             SUM(wx_yd) as tg,
             SUM(wx_yd+wx_jd+wx_nd) as hj,
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(wx_tb) as tb,
             SUM(wx_yd) as tg,
             SUM(wx_yd+wx_jd+wx_nd) as hj,
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }

    /**
     * 获取企业优秀方案
     * @param $arr
     */
    public function getGoodPlanData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(fa_tb) as tb,
             SUM(fa_cs) as tg, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(fa_tb) as tb,
             SUM(fa_cs) as tg, 
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }


    /**
     * 获取企业新闻
     * @param $arr
     */
    public function getNewsData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(xw_tb) as tb,
             SUM(xw_fb) as tg, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(xw_tb) as tb,
             SUM(xw_fb) as tg,  
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }


    /**
     * 获取活动浏览量
     * @param $arr
     */
    public function getBrowseData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(browse_amount) as tb, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(browse_amount) as tb,  
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }

    /**
     * 获取活动浏览量
     * @param $arr
     */
    public function getStarData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(star_amount) as tb, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(star_amount) as tb,  
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 1 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }


    /**
     * 获取公会数据
     * @param $arr
     */
    public function getUnionData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(organization_count) as qy, 
             SUM(yxgr_yd) as yxgr, 
             SUM(fa_cs) as plan, 
             SUM(wx_yd) as wuxiao, 
             SUM(xw_tb) as news, 
             SUM(browse_amount) as browse, 
             SUM(star_amount) as star, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 2 and
              `date` >=? and
              `date` <= ? and `type_id` = ? group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(organization_count) as qy, 
             SUM(yxgr_yd) as yxgr, 
             SUM(fa_cs) as plan, 
             SUM(wx_yd) as wuxiao, 
             SUM(xw_tb) as news, 
             SUM(browse_amount) as browse, 
             SUM(star_amount) as star, 
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 2 and
              `month` >=? and
              `month` <= ? and `type_id` = ? group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime'], $arr['billId']]);
        return $builder;
    }

    /**
     * 获取公会数据
     * @param $arr
     */
    public function getAdminUnionData($arr)
    {
        $type = $arr['type'];//查询类型

        $sql = "select
             SUM(organization_count) as qy, 
             SUM(yxgr_yd) as yxgr, 
             SUM(fa_cs) as plan, 
             SUM(wx_yd) as wuxiao, 
             SUM(xw_tb) as news, 
             SUM(browse_amount) as browse, 
             SUM(star_amount) as star, 
             `date`  as count_time 
              from `zgh_statistics` where
              `type` = 3 and
              `date` >=? and
              `date` <= ?  group by `date`
        ";
        if ($type == 3)//3 按月查询
        {
            $sql = "select
             SUM(organization_count) as qy, 
             SUM(yxgr_yd) as yxgr, 
             SUM(fa_cs) as plan, 
             SUM(wx_yd) as wuxiao, 
             SUM(xw_tb) as news, 
             SUM(browse_amount) as browse, 
             SUM(star_amount) as star, 
             CONCAT(month,'月')   as count_time 
              from `zgh_statistics` where
              `type` = 3 and
              `month` >=? and
              `month` <= ?  group by `month`";
        }

        $builder = DB::select($sql, [$arr['beginTime'], $arr['endTime']]);
        return $builder;
    }
}