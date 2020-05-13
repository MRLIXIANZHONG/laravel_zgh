<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 7:42
 */

namespace App\Services\Index;


use App\DTO\OrganizationsWuxiaoDTO;
use App\Models\OrganizationsWuxiao;
use App\Services\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrganizationWuxiaoService extends Service
{
    //获取五小列表
    public function getList(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {

        $builder = OrganizationsWuxiao::query();
//        $organizationsWuxiaoDTO->getPlanName() && $builder->where('organizations_wuxiao.plan_name', 'like', '%' . $organizationsWuxiaoDTO->getPlanName() . '%');
//        $organizationsWuxiaoDTO->getOrganizationName() && $builder->whereHas('organizations', function ($builder) use ($organizationsWuxiaoDTO) {
//            $builder->where('name', 'like', '%' . $organizationsWuxiaoDTO->getOrganizationName() . '%');
//        });
        if ($organizationsWuxiaoDTO->getIsWinType()) {
            switch ($organizationsWuxiaoDTO->getIsWinType()) {
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
        $organizationsWuxiaoDTO->getOrganizationId() && $builder->where('organization_id', $organizationsWuxiaoDTO->getOrganizationId());
        $organizationsWuxiaoDTO->getUnitId() && $builder->where('organizations_wuxiao.unit_id', $organizationsWuxiaoDTO->getUnitId());
        $builder->where('organizations_wuxiao.check_state', 1);
        $organizationsWuxiaoDTO->getIndustryId() && $builder->where('organizations_wuxiao.industry_id', $organizationsWuxiaoDTO->getIndustryId());
        $builder->leftJoin('organizations', 'organizations_wuxiao.organization_id', '=', 'organizations.id');
        if ($organizationsWuxiaoDTO->getKeyword()) {
            //员工名查询
            $builder->Where(function ($builder) use ($organizationsWuxiaoDTO) {
                $builder->orwhere('organizations_wuxiao.plan_name', 'like', '%' . $organizationsWuxiaoDTO->getKeyword() . '%');
                $builder->orwhere('organizations.name', 'like', '%' . $organizationsWuxiaoDTO->getKeyword() . '%');

            });
        }
        $organizationsWuxiaoDTO->getType() && $builder->where('organizations_wuxiao.type', $organizationsWuxiaoDTO->getType());
        $organizationsWuxiaoDTO->getRecommend() && $builder->where('organizations_wuxiao.recommend', $organizationsWuxiaoDTO->getRecommend());
        !empty($organizationsWuxiaoDTO->getOrganizationIds()) && $builder->whereIn('organizations_wuxiao.organization_id', $organizationsWuxiaoDTO->getOrganizationIds());
        $builder->select(['organizations_wuxiao.*', 'organizations.name as organization_name']);

        return $builder->paginate($organizationsWuxiaoDTO->getPageSize());
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Builder[]|mixed|null
     */
    public
    function getDetail($id)
    {
        //前台只展示审核通过的五小信息
        $wuxiao = OrganizationsWuxiao::query()->where('organizations_wuxiao.check_state', 1)->leftJoin('organizations', 'organizations_wuxiao.organization_id', '=', 'organizations.id')->select(['organizations_wuxiao.*', 'organizations.name as organization_name'])->find($id);
        //增加浏览量
        $wuxiao->browse_count = $wuxiao->browse_count + 1;
        $wuxiao->save();
        return $wuxiao;
    }

    //点赞
    public
    function setLike($id)
    {
        $wuxiao = OrganizationsWuxiao::query()->find($id);

        $wuxiao->star_count = $wuxiao->star_count + 1;
        $wuxiao->save();
        return $wuxiao;
    }
}