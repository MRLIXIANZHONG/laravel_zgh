<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 6:47
 */

namespace App\Services\Index;


use App\DTO\NomineeDTO;
use App\Models\Nominee;
use App\Models\Nominees_experience;
use App\Models\NomineesPlan;
use App\Models\Nominess_img;
use App\Models\Nominess_video;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class NomineeService extends Service
{
    public function getList(NomineeDTO $nomineeDto)
    {
        $builder = Nominee::query()->orderBy('kind')->orderByDesc('check_at');
        if ($nomineeDto->getIsWinType()) {
            switch ($nomineeDto->getIsWinType()) {
                case 1:
                    $builder->whereNotNull('month_win');
                    break;
                case 2:
                    $builder->whereNotNull('quarter_win');
                    break;
                case 3:
                    $builder->whereNotNull('year_win');
                    break;
                default:
                    break;
            }
        }

        //员工名查询
        $nomineeDto->getStaffName() && $builder->where('staff_name', 'like', '%' . $nomineeDto->getStaffName() . '%');
        //企业名查询
        $nomineeDto->getOrganizationName() && $builder->where('organization_name', 'like', '%' . $nomineeDto->getOrganizationName() . '%');
        //类型

        if ($nomineeDto->getKeyword()) {
            //员工名查询
            $builder->where(function ($builder) use ($nomineeDto) {
                $builder->orwhere('staff_name', 'like', '%'.$nomineeDto->getKeyword().'%');
                $builder->orWhere('organization_name', 'like', '%'.$nomineeDto->getKeyword().'%');
            });
        }
        if ($nomineeDto->getKind()) {
            $builder->where('kind', $nomineeDto->getKind());
        }
        $nomineeDto->getIndustryId() && $builder->where('industry_id', $nomineeDto->getIndustryId());//行业
        $builder->where('declare_status', 1);//已经报送
        $nomineeDto->getUnitId() && $builder->where('unit_id', $nomineeDto->getUnitId());//工会
        $nomineeDto->getOrganizationId() && $builder->where('organization_id', $nomineeDto->getOrganizationId());//工会
        $nomineeDto->getRecommend() && $builder->where('recommend', $nomineeDto->getRecommend());//推荐
        //获取行业名称
        $builder->leftJoin('industry_tag', 'industry_tag.id', '=', 'nominees.industry_id');//
        $builder->select('nominees.id', 'nominees.staff_img', 'nominees.kind', 'nominees.staff_name', 'nominees.organization_name', 'nominees.caption', 'industry_tag.industry_name as industry_name');

        return $builder->paginate($nomineeDto->getPageSize());
    }

    public function getExperienceList($nomineeId)
    {
        $builder = Nominees_experience::query();
        $builder->where('mainId', $nomineeId);
        return $builder->orderBy('sort')->get();
    }

    /**
     * 获取个人荣誉图集
     * @param $nomineeId
     * @return LengthAwarePaginator
     */
    public function getNominessImg($nomineeId)
    {
        $builder = Nominess_img::query();
        $builder->where('mainId', $nomineeId);
        return $builder->orderBy('sort')->get();
    }

    public function getNominessVideo($nomineeId)
    {
        $builder = Nominess_video::query();
        $builder->where('mainId', $nomineeId);
        return $builder->orderBy('sort')->get();
    }


    /**
     * 获取优秀个人
     * @param int $id
     * @return 优秀个人详情
     */
    public function getDetail(int $id)
    {

        //获取已经推送的
        $nominee = Nominee::query()->with('industry')->with('units')->where('declare_status', 1)->find($id);
        $nominee->browse_count = $nominee->browse_count + 1;
        $nominee->save();
        return $nominee;

    }

    //获取优秀个人参与的方案信息
    public function getNomineePlan(int $id)
    {
        $sql = 'SELECT
	op.id,
	u.name union_name,
	o.name AS org_name,
	op.plan_name,
	op.img_url,
	op.summary,
	oi.industry_names 
FROM
	nominees_organizations_plan nop
	LEFT JOIN organizations_plan op ON nop.organizations_plan_id = op.id
	LEFT JOIN organizations o ON op.organization_id = o.id
	LEFT JOIN units u ON o.unit_id = u.id
	LEFT JOIN (
	SELECT
		organizations.id,
		group_concat( industry_tag.industry_name SEPARATOR \';\' ) industry_names 
	FROM
		organizations
		LEFT JOIN organization_industry_maps oim ON organizations.id = oim.organization_id
		LEFT JOIN industry_tag ON industry_tag.id = oim.industry_id 
	GROUP BY
		organizations.id 
	) oi ON o.id = oi.id 
WHERE
    nop.deleted_at is null and
	nop.nominee_id = ' . $id;
        return DB::select($sql);
    }

    //优秀个人点赞
    public function setLike($id)
    {
        $nominee = Nominee::query()->find($id);
        $nominee->star_count = $nominee->star_count + 1;
        $nominee->save();
        return $nominee;
    }

//    public  function
}