<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-11 下午 4:41
 */

namespace App\Services\Admin;


use App\DTO\OrganizationsWuxiaoDTO;
use App\Jobs\SendMsg;
use App\Models\AdminUsers;
use App\Models\CaseSchemes;
use App\Models\OrganizationsWuxiao;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class OrganizationsWuxiaoService extends Service
{

    public function getList(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        $builder = OrganizationsWuxiao::query();
        $organizationsWuxiaoDTO->getPlanName() && $builder->where('plan_name', 'like', '%' . $organizationsWuxiaoDTO->getPlanName() . '%');
        $organizationsWuxiaoDTO->getOrganizationName() && $builder->whereHas('organizations', function ($builder) use ($organizationsWuxiaoDTO) {
            $builder->where('name', 'like', '%' . $organizationsWuxiaoDTO->getOrganizationName() . '%');
        });
        $organizationsWuxiaoDTO->getorgType() && $builder->whereHas('organizations', function ($builder) use ($organizationsWuxiaoDTO) {
            $builder->where('new_type', '=', $organizationsWuxiaoDTO->getorgType());
        });
        $organizationsWuxiaoDTO->getOrganizationId() && $builder->where('organization_id', $organizationsWuxiaoDTO->getOrganizationId());
        $organizationsWuxiaoDTO->getUnitId() && $builder->where('unit_id', $organizationsWuxiaoDTO->getUnitId());
        $organizationsWuxiaoDTO->getType() && $builder->where('type', $organizationsWuxiaoDTO->getType());


        if ($organizationsWuxiaoDTO->getCheckState() !== -1 && $organizationsWuxiaoDTO->getCheckState() !=null)
            $builder->where('check_state', $organizationsWuxiaoDTO->getCheckState());
        if ($organizationsWuxiaoDTO->getCaseSchemeId()) {
            $caseScheme = CaseSchemes::find($organizationsWuxiaoDTO->getCaseSchemeId());
            switch ($caseScheme->type) {
                case 4:
                    $builder->where('case_scheme_id', $organizationsWuxiaoDTO->getCaseSchemeId());
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('month_win');
                    break;
                case 5:
                    $builder->where('quart', $organizationsWuxiaoDTO->getCaseSchemeId());
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('quarter_win');
                    break;
                case 6:
                    $builder->whereNotNull('quarter_win');
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('year_win');
                    break;
            }
        }
        if ($organizationsWuxiaoDTO->getDeclarationState() === 0 || $organizationsWuxiaoDTO->getDeclarationState() === 1)
            $builder->where('declaration_state', $organizationsWuxiaoDTO->getDeclarationState());
        if ($organizationsWuxiaoDTO->getRecommend() === 0 || $organizationsWuxiaoDTO->getRecommend() === 1)
            $builder->where('recommend', $organizationsWuxiaoDTO->getRecommend());
        $builder->leftJoin('industry_tag', 'industry_tag.id', '=', 'organizations_wuxiao.industry_id');
        $builder->select('organizations_wuxiao.*', 'industry_tag.industry_name as  industry_name');
        return $builder->paginate($organizationsWuxiaoDTO->getPageSize());
    }

    public function getDetail($id)
    {
        return OrganizationsWuxiao::query()->find($id);
    }

    /**
     * 添加更新
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return string[]
     */
    public function store(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        if ($organizationsWuxiaoDTO->getId())
            $organizationsWuxiao = OrganizationsWuxiao::find($organizationsWuxiaoDTO->getId());
        else {
            $organizationsWuxiao = new OrganizationsWuxiao();
            $organizationsWuxiao->created_at = date('Y-m-d h:i:s', time());
        }
        $organizationsWuxiaoDTO->getPlanName() && $organizationsWuxiao->plan_name = $organizationsWuxiaoDTO->getPlanName();
        $organizationsWuxiaoDTO->getOrganizationId() && $organizationsWuxiao->organization_id = $organizationsWuxiaoDTO->getOrganizationId();
        $organizationsWuxiaoDTO->getUnitId() && $organizationsWuxiao->unit_id = $organizationsWuxiaoDTO->getUnitId();
        $organizationsWuxiaoDTO->getCover() && $organizationsWuxiao->cover = $organizationsWuxiaoDTO->getCover();
        $organizationsWuxiaoDTO->getType() && $organizationsWuxiao->type = $organizationsWuxiaoDTO->getType();
        $organizationsWuxiaoDTO->getContent() && $organizationsWuxiao->content = $organizationsWuxiaoDTO->getContent();
        $organizationsWuxiaoDTO->getSummary() && $organizationsWuxiao->summary = $organizationsWuxiaoDTO->getSummary();
        $organizationsWuxiaoDTO->getReward() && $organizationsWuxiao->rewards = $organizationsWuxiaoDTO->getReward();
        //虚拟浏量
        $organizationsWuxiaoDTO->getVStarCount() && $organizationsWuxiao->V_star_count = $organizationsWuxiaoDTO->getVStarCount();
        $organizationsWuxiaoDTO->getVBrowseCount() && $organizationsWuxiao->v_browse_count = $organizationsWuxiaoDTO->getVBrowseCount();
        $organizationsWuxiaoDTO->getImgUrl() && $organizationsWuxiao->img_url = $organizationsWuxiaoDTO->getImgUrl();
        $organizationsWuxiaoDTO->getVideoUrl() && $organizationsWuxiao->video_url = $organizationsWuxiaoDTO->getVideoUrl();
        $organizationsWuxiaoDTO->getIndustryId() && $organizationsWuxiao->industry_id = $organizationsWuxiaoDTO->getIndustryId();
        $organizationsWuxiaoDTO->getCaseSchemeId() && $organizationsWuxiao->case_scheme_id = $organizationsWuxiaoDTO->getCaseSchemeId();

        $result = $organizationsWuxiao->save();
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

//    /**
//     * 更新
//     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
//     * @return string[]
//     */
//    public function update(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
//    {
//
//        $organizationsWuxiao = OrganizationsWuxiao::find($organizationsWuxiaoDTO->getId());
//        if ($organizationsWuxiaoDTO != null) {
//            $organizationsWuxiaoDTO->getPlanName() && $organizationsWuxiao->plan_name = $organizationsWuxiaoDTO->getPlanName();
//            $organizationsWuxiaoDTO->getCover() && $organizationsWuxiao->cover = $organizationsWuxiaoDTO->getCover();
//            $organizationsWuxiaoDTO->getType() && $organizationsWuxiao->type = $organizationsWuxiaoDTO->getType();
//            $organizationsWuxiaoDTO->getOrganizationId() && $organizationsWuxiao->organization_id = $organizationsWuxiaoDTO->getOrganizationId();
//            $organizationsWuxiaoDTO->getUnitId() && $organizationsWuxiao->unit_id = $organizationsWuxiaoDTO->getUnitId();
//            $organizationsWuxiaoDTO->getContent() && $organizationsWuxiao->content = $organizationsWuxiaoDTO->getContent();
//            //虚拟浏量
//            $organizationsWuxiaoDTO->getVStarCount() && $organizationsWuxiao->V_star_count = $organizationsWuxiaoDTO->getVStarCount();
//            $organizationsWuxiaoDTO->getVBrowseCount() && $organizationsWuxiao->v_browse_count = $organizationsWuxiaoDTO->getVBrowseCount();
//            $organizationsWuxiaoDTO->getSummary() && $organizationsWuxiao->summary = $organizationsWuxiaoDTO->getSummary();
//            $organizationsWuxiaoDTO->getReward() && $organizationsWuxiao->rewards = $organizationsWuxiaoDTO->getReward();
//            $organizationsWuxiaoDTO->getImgUrl() && $organizationsWuxiao->img_url = $organizationsWuxiaoDTO->getImgUrl();
//            $organizationsWuxiaoDTO->getVideoUrl() && $organizationsWuxiao->video_url = $organizationsWuxiaoDTO->getVideoUrl();
//            $organizationsWuxiaoDTO->getIndustryId() && $organizationsWuxiao->industry_id = $organizationsWuxiaoDTO->getIndustryId();
//            $organizationsWuxiaoDTO->getCaseSchemeId() && $organizationsWuxiao->case_scheme_id = $organizationsWuxiaoDTO->getCaseSchemeId();
////            $organizationsWuxiao->created_at = date('Y-m-d h:i:s', time());
//        }
//
//
//        $result = $organizationsWuxiao->save();
//
//        if ($result)
//            return ['code' => '1000', 'message' => '修改成功'];
//        else
//            return ['code' => '-1', 'message' => '操作失败'];
//    }

    /**
     * 申报五小
     * @param $id
     * @return string[]
     */
    public function declaration($arr)
    {
//        dd($arr);
        $organizationsWuxiao = OrganizationsWuxiao::query()->find($arr[0]);
        $organizationsWuxiao->declaration_state = 1;
        $organizationsWuxiao->check_state = 0;
        $organizationsWuxiao->declaration_time = date('Y-m-d h:i:s', time());
        $result = $organizationsWuxiao->save();
        if (!$organizationsWuxiao->caseSchemes->is_open)
            return ['code' => '-1', 'message' => '赛事还未开启'];
        if (strtotime($organizationsWuxiao->caseSchemes->qy_stime) > time())
            return ['code' => '-1', 'message' => '还未到企业推选时间'];
        if (strtotime($organizationsWuxiao->caseSchemes->qy_etime) < time())
            return ['code' => '-1', 'message' => '企业推选时间已过'];
        //获取工会信息
        $user = AdminUsers::query()->where('units_id', $organizationsWuxiao->unit_id)->first();
        $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $arr[1], 'content' => '你有新的五小申报信息，' . $organizationsWuxiao->plan_name . '请及时处理！'], 1));
        if ($result)
            return ['code' => '1000', 'message' => '申报成功！'];
        else
            return ['code' => '-1', 'message' => '申报失败，请稍后再试！'];
    }

    public function destroy($id)
    {
        $result = OrganizationsWuxiao::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '删除成功！'];
        else
            return ['code' => '-1', 'message' => '删除失败，请稍后再试！'];
    }

    /**
     * 审核
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return string[]
     */
    public function check(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        $organizationsWuxiao = OrganizationsWuxiao::query()->find($organizationsWuxiaoDTO->getId());
        $organizationsWuxiao->check_state = $organizationsWuxiaoDTO->getCheckState();
        $user = AdminUsers::query()->where('units_id', $organizationsWuxiao->organization_id)->first();

        //被驳回申报状态改为未申报 可以重新申报
        if ($organizationsWuxiaoDTO->getCheckState() == 2) {
            $organizationsWuxiao->declaration_state = 0;
            $organizationsWuxiao->declaration_time = null;
            //发送消息
            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $organizationsWuxiaoDTO->getAdminid(), 'content' => '你申报的五小' . $organizationsWuxiao->plan_name . '已经被驳回'], 1));

        }
        $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $organizationsWuxiaoDTO->getAdminid(), 'content' => '你申报的五小' . $organizationsWuxiao->plan_name . '已经通过了审核'], 1));

        $organizationsWuxiao->check_time = date('Y-m-d h:i:s', time());
        //驳回意见追加
        $organizationsWuxiao->check_opinion = $organizationsWuxiao->check_opinion . $organizationsWuxiaoDTO->getCheckOpinion();
        $result = $organizationsWuxiao->save();
        if ($result)
            return ['code' => '1000', 'message' => '审核成功！'];
        else
            return ['code' => '-1', 'message' => '审核失败，请稍后再试！'];
    }

    /**
     * 设置为优秀月度五小
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return string[]
     */
    public function excellent(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        $organizationsWuxiao = OrganizationsWuxiao::query()->find($organizationsWuxiaoDTO->getId());//->first($id);
        //设置为月度优秀五小

        if (!$organizationsWuxiao->caseSchemes['is_open'])
            return ['code' => '-1', 'message' => '赛事还未开启'];

        if (strtotime($organizationsWuxiao->caseSchemes['gh_stime']) > time() || strtotime($organizationsWuxiao->caseSchemes['gh_etime']) < time())
            return ['code' => '-1', 'message' => '还未到工会推选时间'];
        //设置为月度优秀
        //并添加季度赛事关联

        $user = AdminUsers::query()->where('units_id', $organizationsWuxiao->organization_id)->first();

        $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $organizationsWuxiaoDTO->getAdminid(), 'content' => '你申报的五小' . $organizationsWuxiao->plan_name . '已经被评选为月度优秀五小'], 1));

        $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['type' => 5])->first();
        $organizationsWuxiao->quart = $caseScheme->id;
        $organizationsWuxiao->month_win = date('Y-m-d h:i:s', time());
        $result = $organizationsWuxiao->save();
        if ($result)
            return ['code' => '1000', 'message' => '设置成功'];
        else
            return ['code' => '-1', 'message' => '设置失败'];
    }

    /**
     * 设置为季度优秀五小（管理员和总工会）
     * @param $id
     * @return string[]
     */
    public function quarter($arr)
    {
        $organizationsWuxiao = OrganizationsWuxiao::find($arr[0]);
        //获取季度赛事
        $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['is_open' => 1, 'id' => $organizationsWuxiao->quart])->first();
        if ($caseScheme) {
            $caseSchemeYear = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['is_open' => 1, 'type' => 3])->first();
            $organizationsWuxiao->year = $caseSchemeYear->id;
            $organizationsWuxiao->quarter_win = date('Y-m-d h:i:s', time());
            $user = AdminUsers::query()->where('units_id', $organizationsWuxiao->organization_id)->first();

            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $arr[1], 'content' => '你申报的五小' . $organizationsWuxiao->plan_name . '已经被评选为季度优秀五小'], 1));

        } else
            return ['code' => '-1', 'message' => '当前没有季度优秀五小相关赛事'];
        if ($organizationsWuxiao->save())
            return ['code' => '1000', 'message' => '设置成功'];
        return ['code' => '-1', 'message' => '操作失败请稍后再试'];
    }

    /**
     * 设置年度优秀五小
     * （管理员和总工会可操作）
     * @param $id
     *
     * @return string[]
     */
    public function year($arr)
    {
        $organizationsWuxiao = OrganizationsWuxiao::find($arr[0]);
        //获取年度赛事
        $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['type' => 6, 'is_open' => 1])->first();
        if ($caseScheme) {
            $organizationsWuxiao->year_win = date('Y-m-d h:i:s', time());
            $user = AdminUsers::query()->where('org_id', $organizationsWuxiao->organization_id)->first();

            $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '五小申报', 'admin_id' => $arr[1], 'content' => '你申报的五小' . $organizationsWuxiao->plan_name . '已经被评选为年度优秀五小'], 1));

        } else
            return ['code' => '-1', 'message' => '当前没有年度优秀五小相关赛事'];
        if ($organizationsWuxiao->save())
            return ['code' => '1000', 'message' => '设置成功'];
        return ['code' => '-1', 'message' => '操作失败请稍后再试'];
    }

    /**
     * 获取五小列表Excel
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListToExcel(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        $builder = OrganizationsWuxiao::query();
        //查询条件
        $organizationsWuxiaoDTO->getPlanName() && $builder->where('plan_name', 'like', '%' . $organizationsWuxiaoDTO->getPlanName() . '%');
        $organizationsWuxiaoDTO->getOrganizationName() && $builder->whereHas('organizations', function ($builder) use ($organizationsWuxiaoDTO) {
            $builder->where('name', 'like', '%' . $organizationsWuxiaoDTO->getOrganizationName() . '%');
        });
        $organizationsWuxiaoDTO->getorgType() && $builder->whereHas('organizations', function ($builder) use ($organizationsWuxiaoDTO) {
            $builder->where('new_type', '=', $organizationsWuxiaoDTO->getorgType());
        });
        if ($organizationsWuxiaoDTO->getCheckState() !== -1 && $organizationsWuxiaoDTO->getCheckState())
            $builder->where('check_state', $organizationsWuxiaoDTO->getCheckState());
        $organizationsWuxiaoDTO->getOrganizationId() && $builder->where('organization_id', $organizationsWuxiaoDTO->getOrganizationId());

        $organizationsWuxiaoDTO->getType() && $builder->where('type', $organizationsWuxiaoDTO->getType());
        if ($organizationsWuxiaoDTO->getCaseSchemeId()) {
            $caseScheme = CaseSchemes::find($organizationsWuxiaoDTO->getCaseSchemeId());
            switch ($caseScheme->type) {
                case 4:
                    $builder->where('case_scheme_id', $organizationsWuxiaoDTO->getCaseSchemeId());
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('month_win');
                    break;
                case 5:
                    $builder->where('quart', $organizationsWuxiaoDTO->getCaseSchemeId());
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('quarter_win');
                    break;
                case 6:
                    $builder->whereNotNull('quarter_win');
                    if ($organizationsWuxiaoDTO->getIsWin())
                        $builder->whereNotNull('year_win');
                    break;
            }
        }
        if ($organizationsWuxiaoDTO->getDeclarationState() === 0 || $organizationsWuxiaoDTO->getDeclarationState() === 1)
           $builder->where('declaration_state', $organizationsWuxiaoDTO->getDeclarationState());
        $builder->leftJoin("industry_tag",
            'organizations_wuxiao.industry_id',
            '=',
            'industry_tag.id')->leftJoin("units",
            'organizations_wuxiao.unit_id',
            '=',
            'units.id')->leftJoin("organizations",
            'organizations_wuxiao.organization_id',
            '=',
            'organizations.id')->select(["organizations_wuxiao.*",
            "industry_tag.industry_name as wuxiao_industry_name",
            'units.name as unit_name',
            'organizations.type as organizations_type',
            'organizations.name as organizations_name',
            'organizations.username as organizations_username',
            'organizations.mobile as organizations_mobile',
            DB::raw('CASE organizations.new_type WHEN 1 THEN \'国营控股企业\' WHEN 2 THEN \'行政机关\' WHEN 3 THEN \'港澳台、外商投资企业\' WHEN 4 THEN \'民营控股企业\' WHEN 5 THEN \'事业单位\' ELSE \'其他\' END org_type_name ')]);

        return $builder->get();

    }

    /**
     * 设置虚拟数据
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return string[]
     */
    public function setvirtual(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        if ($organizationsWuxiaoDTO->getId()) {
            $nominee = OrganizationsWuxiao::find($organizationsWuxiaoDTO->getId());
            $organizationsWuxiaoDTO->getVStarCount() && $nominee->V_star_count = $organizationsWuxiaoDTO->getVStarCount();
            $organizationsWuxiaoDTO->getVBrowseCount() && $nominee->v_browse_count = $organizationsWuxiaoDTO->getVBrowseCount();
            if ($nominee->save())
                return ['code' => '1000', 'message' => '设置成功'];
            else
                return ['code' => '-1', 'message' => '设置失败，请稍后再试！'];
        } else
            return ['code' => '-1', 'message' => '操作失败，请稍后再试！'];
        //虚拟浏量

    }

    /**
     * 推荐到首页
     * @param OrganizationsWuxiaoDTO $organizationsWuxiaoDTO
     * @return string[]
     */
    public function recommend(OrganizationsWuxiaoDTO $organizationsWuxiaoDTO)
    {
        $nominee = OrganizationsWuxiao::find( $organizationsWuxiaoDTO->getId());
        $nominee->recommend=$organizationsWuxiaoDTO->getRecommend();
        if ($nominee->save())
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败，请稍后再试！'];
    }
}