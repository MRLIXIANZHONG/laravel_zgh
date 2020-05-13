<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 15:07
 */

namespace App\Services\Index;


use App\DTO\OrganizationDTO;
use App\Exceptions\NotFoundException;
use App\Models\News;
use App\Models\Nominee;
use App\Models\Organization;
use App\Models\OrganizationsPlan;
use App\Models\OrganizationsWuxiao;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class OrganizationService extends Service
{
    public function getList(OrganizationDTO $dto)
    {
        $builder = Organization::query();
        !empty($dto->getIds()) && $builder->whereIn('id', $dto->getIds());
        $dto->getNewType() && $builder->where('new_type', $dto->getNewType());
        $dto->getUnitId() && $builder->where('unit_id', $dto->getUnitId());
        $dto->getIsCompetition() && $builder->where('is_competition', $dto->getIsCompetition());

        $organizations = $builder->paginate($dto->getPageSize());
        /*  if ($dto->getPageSize() && $dto->getPage()) {
              $organizations = $builder->paginate($dto->getPageSize(), ['*'], $dto->getPage());
          } else {
              $organizations = $builder->get();
          }*/

        return $organizations;
    }

    public function getDetail(OrganizationDTO $dto)
    {
        $model = Organization::query()->where('id', $dto->getId())->first();

        if (!$model) {
            throw new NotFoundException('资源未找到');
        }

        return $model;
    }

    /**
     * 获取参赛企业
     * @param $Units_id
     * @return
     */
    public function getJoinOrg($Units_id)
    {
        $orgSql = "SELECT org.*,org_n.industry_names FROM organizations as org INNER  JOIN (SELECT
	organizations.id,
	group_concat( industry_tag.industry_name separator ';') industry_names 
FROM
	organizations
	LEFT JOIN organization_industry_maps oim ON organizations.id = oim.organization_id
	LEFT JOIN industry_tag ON industry_tag.id = oim.industry_id
	
WHERE
	EXISTS ( SELECT plan.organization_id  FROM organizations_plan plan WHERE organizations.id = plan.organization_id AND plan.check_state > 0 ) 
	AND organizations.unit_id = " . $Units_id . " 
GROUP BY
	organizations.id  ) as org_n ON org.id=org_n.id AND  org.unit_id =  " . $Units_id . "  LIMIT 0,8";

        return DB::select($orgSql);
    }

    /**
     * 获取参赛企业分页
     * @param $Units_id
     * @return
     */
    public function getJoinOrgPag($Units_id, $page = 1, $pageSize = 16)
    {

        $countSql = "SELECT count(*) as number FROM organizations as org INNER  JOIN (SELECT
	organizations.id,
	group_concat( industry_tag.industry_name separator ';') industry_names 
FROM
	organizations
	LEFT JOIN organization_industry_maps oim ON organizations.id = oim.organization_id
	LEFT JOIN industry_tag ON industry_tag.id = oim.industry_id
	
WHERE
	EXISTS ( SELECT plan.organization_id  FROM organizations_plan plan WHERE organizations.id = plan.organization_id AND plan.check_state > 0 ) 
	AND organizations.unit_id = " . $Units_id . " 
GROUP BY
	organizations.id  ) as org_n ON org.id=org_n.id AND  org.unit_id =  " . $Units_id;

        $count = DB::select($countSql);
        $total = ceil($count[0]->number / $pageSize);//总页数

        $page_one = ($page - 1) * $pageSize;
        $page_all = $page_one + $pageSize;

        $orgSql = "SELECT org.*,org_n.industry_names FROM organizations as org INNER  JOIN (SELECT
	organizations.id,
	group_concat( industry_tag.industry_name separator ';') industry_names 
FROM
	organizations
	LEFT JOIN organization_industry_maps oim ON organizations.id = oim.organization_id
	LEFT JOIN industry_tag ON industry_tag.id = oim.industry_id
	
WHERE
	EXISTS ( SELECT plan.organization_id  FROM organizations_plan plan WHERE organizations.id = plan.organization_id AND plan.check_state > 0 ) 
	AND organizations.unit_id = " . $Units_id . " 
GROUP BY
	organizations.id  ) as org_n ON org.id=org_n.id AND  org.unit_id =  " . $Units_id . "  LIMIT " . $page_one . "," . $page_all;


        $data = DB::select($orgSql);

        return array('page' => $page, 'total' => $total, 'data' => $data,'count'=>$count,'per_page'=>$pageSize);
    }

    //基层工会获取企业详情
    public function getOrgDetailById($orgid)
    {
        //企业信息
        $orgSql = "select a.*,b.industry_names from organizations a LEFT JOIN   (
SELECT      
	organizations.id, group_concat(
		industry_tag.industry_name SEPARATOR ';'
	) industry_names
FROM
	organizations
LEFT JOIN organization_industry_maps oim ON organizations.id = oim.organization_id
LEFT JOIN industry_tag ON industry_tag.id = oim.industry_id

GROUP BY 	organizations.id
) b on a.id = b.id
WHERE
	a.id = " . $orgid;
        $orgmodel = DB::select($orgSql);

        //企业数据
        $orgDataSql = "SELECT
	yxgr_yd,
	fa_cs,
	wx_yd,
	xw_tb,
	browse_amount+b.virtual_browse browse,
	star_amount+b.virtual_star star
FROM
zgh_statistics AS a
INNER JOIN organizations b on a.type_id=b.id
WHERE
a.type_id = " . $orgid . " LIMIT 0, 1";
        $orgData = DB::select($orgDataSql);
        //获取参赛方案
        $orgPlan = OrganizationsPlan::query()->where('organization_id', $orgid)->where('check_state', '=',5)->get();
        //五小
        $orgWx = OrganizationsWuxiao::query()->where('organization_id', $orgid)->where('check_state', 1)->get();
        //优秀个人
        $orgPersion = Nominee::query()->where('organization_id' ,$orgid)->where( 'declare_status', 1)->get();
        //新闻
        $news = News::query()->where('check_state' , 2)->where( 'organization_id' ,$orgid)->orderByDesc('created_at')->paginate(6);

        return array('org' => $orgmodel, 'orgData' => $orgData, 'orgPlan' => $orgPlan, 'orgwx' => $orgWx, 'orgPersion' => $orgPersion, 'news' => $news);
    }
}