<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 下午 3:39
 */

namespace App\Services\Admin;


use App\DTO\CaseSchemesDTO;
use App\Exceptions\FailException;
use App\Models\CaseSchemes;
use App\Models\CaseSchemeType;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class CaseSchemesService extends Service
{
    /**
     *获取评审节点
     * @param CaseSchemesDTO $schemesDTO
     * @return Builder[]|Collection
     */
    public function getList(?CaseSchemesDTO $schemesDTO)
    {

        $builder = CaseSchemes::query()->orderBy('sort');
        $schemesDTO->getTitle() && $builder->where('title', 'like', '%' . $schemesDTO->getTitle() . '%');
        if ($schemesDTO != null) {
            $schemesDTO->getType() && $builder->where('type', $schemesDTO->getType());
        }
        if ($schemesDTO->getIsWhere()) {
            //获取个人赛事
            if ($schemesDTO->getIsWhere() == 1) {
                $builder->whereIn('type', [1, 2, 3]);
            } elseif ($schemesDTO->getIsWhere() == 2)
                //获取五小赛事
                $builder->whereIn('type', [4, 5, 6]);
            else
                $builder->where('type', 7);
        }
        return $builder->get();
    }
//
//    /**
//     * 添加活动节点
//     * @param CaseSchemesDTO $schemesDTO
//     * @return string
//     * @throws FailException 唯一编码已经存在
//     */
//    public function insert(CaseSchemesDTO $schemesDTO)
//    {
//        $builder = CaseSchemes::query()->where('code', $schemesDTO->getCode())->first();
//        if ($builder != null) {
//            throw new FailException([
//                'message' => '唯一编码已经存在，请重新输入！'
//            ]);
//        }
//        $schemes = new CaseSchemes();
//
//        $schemesDTO->getTitle() && $schemes->title = $schemesDTO->getTitle();
//        $schemesDTO->getCode() && $schemes->code = $schemesDTO->getCode();
//        $schemesDTO->getType() && $schemes->type = $schemesDTO->getType();
//        $schemesDTO->getSort() && $schemes->sort = $schemesDTO->getSort();
//        $schemesDTO->getShowStime() && $schemes->show_stime = $schemesDTO->getShowStime();
//        $schemesDTO->getShowEtime() && $schemes->show_etime = $schemesDTO->getShowEtime();
//        if ($schemesDTO->getShowStime() && $schemesDTO->getShowEtime() && strcmp($schemesDTO->getShowStime(), $schemesDTO->getShowEtime()) === 1)
//            return ['code' => '-1', 'message' => '展示开始时间大于结束时间，请重新选择'];
//        $schemesDTO->getQyStime() && $schemes->qy_stime = $schemesDTO->getQyStime();
//        $schemesDTO->getQyEtime() && $schemes->qy_etime = $schemesDTO->getQyEtime();
//        if ($schemesDTO->getQyStime() && $schemesDTO->getQyEtime() && strcmp($schemesDTO->getQyStime(), $schemesDTO->getQyEtime()) === 1)
//            return ['code' => '-1', 'message' => '企业推选开始时间大于结束时间，请重新选择'];
//
//        $schemesDTO->getGhStime() && $schemes->gh_stime = $schemesDTO->getGhStime();
//        $schemesDTO->getGhEtime() && $schemes->gh_etime = $schemesDTO->getGhEtime();
//
//        if ($schemesDTO->getGhStime() && $schemesDTO->getGhEtime() && strcmp($schemesDTO->getGhStime(), $schemesDTO->getGhEtime()) === 1)
//            return ['code' => '-1', 'message' => '工会推选开始时间大于结束时间，请重新选择'];
//
//        $schemesDTO->getZjStime() && $schemes->zj_stime = $schemesDTO->getZjStime();
//        $schemesDTO->getZjEtime() && $schemes->zj_etime = $schemesDTO->getZjEtime();
//
//        if ($schemesDTO->getZjStime() && $schemesDTO->getZjEtime() && strcmp($schemesDTO->getZjStime(), $schemesDTO->getZjEtime()) === 1)
//            return ['code' => '-1', 'message' => '专家投票开始时间大于结束时间，请重新选择'];
//
//        $schemesDTO->getYearStime() && $schemes->year_stime = $schemesDTO->getYearStime();
//        $schemesDTO->getYearEtime() && $schemes->year_etime = $schemesDTO->getYearEtime();
//        if ($schemesDTO->getYearStime() && $schemesDTO->getYearEtime() && strcmp($schemesDTO->getYearStime(), $schemesDTO->getYearEtime()) === 1)
//            return ['code' => '-1', 'message' => '专家投票开始时间大于结束时间，请重新选择'];
//
//        $schemesDTO->getIsOpen() && $schemes->is_open = $schemesDTO->getIsOpen();
//        $schemesDTO->getPrizeAt() && $schemes->prize_at = $schemesDTO->getPrizeAt();
//        $schemes->created_at = date('Y-m-d h:i:s', time());
//        $schemes->system_version = $schemesDTO->getSystemVersion();
//
//        $result = $schemes->save();
//        if ($result)
//            return ['code' => '1000', 'message' => '成功'];
//        else
//            return ['code' => '-1', 'message' => '操作失败'];
//    }

    /**
     * 获取赛事详情
     * @param CaseSchemesDTO $schemesDTO
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getDetail(CaseSchemesDTO $schemesDTO)
    {
        return CaseSchemes::query()->where('id', $schemesDTO->getId())->first();
    }

    /**
     * 更新赛事节点
     * @param CaseSchemesDTO $schemesDTO
     * @return string
     * @throws FailException
     */
    public function update(CaseSchemesDTO $schemesDTO)
    {
        //检查code，
        if ($schemesDTO->getId()) {
            $builder = CaseSchemes::query()->where('code', $schemesDTO->getCode())->where('id', '!=', $schemesDTO->getId())->get();
            $schemes = CaseSchemes::find($schemesDTO->getId());
        } else {
            $schemes = new CaseSchemes();
            $builder = CaseSchemes::query()->where('code', $schemesDTO->getCode())->get();
        }

        if ($builder->count() > 0) {
            return ['code' => '-1', 'message' => '唯一代码已经存在，请重新输入！'];
        }

        $schemesDTO->getTitle() && $schemes->title = $schemesDTO->getTitle();
        $schemesDTO->getCode() && $schemes->code = $schemesDTO->getCode();
        $schemesDTO->getType() && $schemes->type = $schemesDTO->getType();
        $schemesDTO->getSort() && $schemes->sort = $schemesDTO->getSort();

        if ($schemesDTO->getType() != 1 && $schemesDTO->getType() != 4 && $schemesDTO->getIsOpen() == 1) {
            CaseSchemes::query()->where('type',$schemesDTO->getType())->where('id','<>',$schemesDTO->getId())->update(['is_open'=>0]);
        }

        //  活动时间
        if ($schemesDTO->getActivityStime() && $schemesDTO->getActivityEtime() && strcmp($schemesDTO->getActivityStime(), $schemesDTO->getActivityEtime()) === 1)
            return ['code' => '-1', 'message' => '活动开始时间大于结束时间，请重新选择'];
        $schemes->activity_stime = $schemesDTO->getActivityStime();
        $schemes->activity_etime = $schemesDTO->getActivityEtime();
        $schemes->activity_explain = $schemesDTO->getActivityExplain();

        //  展示时间
        if ($schemesDTO->getShowStime() && $schemesDTO->getShowEtime() && strcmp($schemesDTO->getShowStime(), $schemesDTO->getShowEtime()) === 1)
            return ['code' => '-1', 'message' => '展示开始时间大于结束时间，请重新选择'];
        $schemes->show_stime = $schemesDTO->getShowStime();
        $schemes->show_etime = $schemesDTO->getShowEtime();
        $schemes->show_is_join = $schemesDTO->getShowIsJoin();
        $schemes->show_is_open = $schemesDTO->getShowIsOpen();
        $schemes->show_explain = $schemesDTO->getShowExplain();


        //企业推选时间
        if ($schemesDTO->getQyStime() && $schemesDTO->getQyEtime() && strcmp($schemesDTO->getQyStime(), $schemesDTO->getQyEtime()) === 1)
            return ['code' => '-1', 'message' => '企业推选开始时间大于结束时间，请重新选择'];
        $schemes->qy_stime = $schemesDTO->getQyStime();
        $schemes->qy_etime = $schemesDTO->getQyEtime();
        $schemes->qy_is_join = $schemesDTO->getQyIsJoin();
        $schemes->qy_is_open = $schemesDTO->getQyIsOpen();
        $schemes->qy_explain = $schemesDTO->getQyExplain();

        //工会推选时间
        if ($schemesDTO->getGhStime() && $schemesDTO->getGhEtime() && strcmp($schemesDTO->getGhStime(), $schemesDTO->getGhEtime()) === 1)
            return ['code' => '-1', 'message' => '工会推选开始时间大于结束时间，请重新选择'];
        $schemes->gh_stime = $schemesDTO->getGhStime();
        $schemes->gh_etime = $schemesDTO->getGhEtime();
        $schemes->gh_is_join = $schemesDTO->getGhIsJoin();
        $schemes->gh_is_open = $schemesDTO->getGhIsOpen();
        $schemes->gh_explain = $schemesDTO->getGhExplain();

        //  总工会工会筛选时间
        if ($schemesDTO->getZghStime() && $schemesDTO->getZghEtime() && strcmp($schemesDTO->getZghStime(), $schemesDTO->getZghEtime()) === 1)
            return ['code' => '-1', 'message' => '总工会工会筛选开始时间大于结束时间，请重新选择'];
        $schemes->zgh_stime = $schemesDTO->getZghStime();
        $schemes->zgh_etime = $schemesDTO->getZghEtime();
        $schemes->zgh_is_join = $schemesDTO->getZghIsJoin();
        $schemes->zgh_is_open = $schemesDTO->getZghIsOpen();
        $schemes->zgh_explain = $schemesDTO->getZghExplain();
        //专家评选时间
        if ($schemesDTO->getZjStime() && $schemesDTO->getZjEtime() && strcmp($schemesDTO->getZjStime(), $schemesDTO->getZjEtime()) === 1)
            return ['code' => '-1', 'message' => '专家投票开始时间大于结束时间，请重新选择'];
        $schemes->zj_stime = $schemesDTO->getZjStime();
        $schemes->zj_etime = $schemesDTO->getZjEtime();
        $schemes->zj_is_join = $schemesDTO->getZjIsJoin();
        $schemes->zj_is_open = $schemesDTO->getZjIsOpen();
        $schemes->zj_explain = $schemesDTO->getZjExplain();

        //大众评选时间
        if ($schemesDTO->getPublicStime() && $schemesDTO->getPublicEtime() && strcmp($schemesDTO->getPublicStime(), $schemesDTO->getPublicEtime()) === 1)
            return ['code' => '-1', 'message' => '大众评选开始时间大于结束时间，请重新选择'];
        $schemes->public_stime = $schemesDTO->getPublicStime();
        $schemes->public_etime = $schemesDTO->getPublicEtime();
        $schemes->public_is_join = $schemesDTO->getPublicIsJoin();
        $schemes->public_is_open = $schemesDTO->getPublicIsOpen();
        $schemes->public_explain = $schemesDTO->getPublicExplain();

        if ($schemesDTO->getYearStime() && $schemesDTO->getYearEtime() && strcmp($schemesDTO->getYearStime(), $schemesDTO->getYearEtime()) === 1)
            return ['code' => '-1', 'message' => '专家投票开始时间大于结束时间，请重新选择'];
        $schemes->year_stime = $schemesDTO->getYearStime();
        $schemes->year_etime = $schemesDTO->getYearEtime();
        $schemes->year_is_join = $schemesDTO->getYearIsJoin();
        $schemes->year_is_open = $schemesDTO->getYearIsOpen();
        $schemes->year_explain = $schemesDTO->getYearExplain();

        $schemesDTO->getIsOpen() && $schemes->is_open = $schemesDTO->getIsOpen();

        $schemesDTO->getPrizeAt() && $schemes->prize_at = $schemesDTO->getPrizeAt();//颁奖时间
        $result = $schemes->save();
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     * 删除评审节点
     * @param int $id
     * @return string[]
     */
    public function destroy(int $id)
    {
        $result = CaseSchemes::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '删除成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     * 获取详情
     * @param $id
     * @return mixed
     */
    public function detail($id)
    {
        return CaseSchemes::find($id);
    }

    /**
     * 获取赛事类型lsit
     *
     * @return mixed
     */
    public function getCaseSchemeTypeList()
    {
        return CaseSchemeType::get();
    }

    /**
     * 获取五小评审信息
     * @param CaseSchemesDTO $schemesDTO
     * @return Builder[]|Collection
     */
    public function wuxiao(CaseSchemesDTO $schemesDTO)
    {

        $builder = CaseSchemes::query()->orderBy('sort');
        //获取月度赛的五小信息
        if (!$schemesDTO->getType() || $schemesDTO->getType() == 4) {
            $builder->withCount(["wuxiao" => function ($query) use ($schemesDTO) {
                $query->where('declaration_state',1);
                $query->whereNull('organizations_wuxiao.deleted_at');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["wuxiaowin" => function ($query) use ($schemesDTO) {
                $query->whereNull('organizations_wuxiao.deleted_at');
                $query->whereNotNull('month_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);

        }
        if ($schemesDTO->getType() == 5) {//获取季度优秀五小数据
            $builder->withCount(["wuxiaoquart" => function ($query) use ($schemesDTO) {
                $query->where('declaration_state',1);
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["wuxiaoquartwin" => function ($query) use ($schemesDTO) {
                $query->whereNotNull('quarter_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
        }
        //年度优秀五小
        if ($schemesDTO->getType() == 6) {
            $builder->withCount(["wuxiaoyaer" => function ($query) use ($schemesDTO) {
                $query->where('declaration_state',1);
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["wuxiaoyaerwin" => function ($query) use ($schemesDTO) {
                $query->whereNotNull('year_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
        }
        $builder->where('type', $schemesDTO->getType());

        return $builder->get();
    }

    /**
     * 获取优秀个人
     * @param CaseSchemesDTO $schemesDTO
     * @return Builder[]|Collection
     */
    public function nominee(CaseSchemesDTO $schemesDTO)
    {
        $builder = CaseSchemes::query()->orderBy('sort');
        //获取月度之星
        if (!$schemesDTO->getType() || $schemesDTO->getType() == 1) {
            $builder->withCount(["nominees" => function ($query) use ($schemesDTO) {
                $query->where('declare_status', 1);
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["nomineeswin" => function ($query) use ($schemesDTO) {
                $query->whereNotNull('month_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);

        }
        if ($schemesDTO->getType() == 2) {//获取季度之星
            $builder->withCount(["nomineesquart" => function ($query) use ($schemesDTO) {
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["nomineesquartwin" => function ($query) use ($schemesDTO) {
                $query->whereNotNull('quarter_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
        }
        //年度之星
        if ($schemesDTO->getType() == 3) {
            $builder->withCount(["nomineesyear" => function ($query) use ($schemesDTO) {
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
            $builder->withCount(["nomineesyeartwin" => function ($query) use ($schemesDTO) {
                $query->whereNotNull('year_win');
                if ($schemesDTO->getUnitId())
                    $query->where('unit_id', $schemesDTO->getUnitId());
            }]);
        }
        $builder->where('type', $schemesDTO->getType());
        return $builder->get();
    }
}