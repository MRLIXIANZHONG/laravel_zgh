<?php


namespace App\Services\Admin;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\NomineeDTO;
use App\Jobs\SendMsg;
use App\Models\AdminUsers;
use App\Models\CaseSchemes;
use App\Models\Nomine;
use App\DTO\Nominees_experienceDTO;
use App\DTO\Nominess_imgDTO;
use App\DTO\Nominess_videoDTO;
use App\Models\Nominee;
use App\Models\Nominees_experience;
use App\Models\NomineesPlan;
use App\Models\Nominess_img;
use App\Models\Nominess_video;
use App\Services\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NomineesService extends Service
{
    /**
     * 获取优秀个人列表
     * @param NomineeDTO $nomineeDto
     * @return Builder[]|Collection
     */
    public function getList(NomineeDTO $nomineeDto)
    {
        $builder = Nominee::query()->with(['units', 'organization', 'caseSchemes'])->orderBy('kind');
        $nomineeDto->getStaffName() && $builder->where('staff_name', 'like', '%' . $nomineeDto->getStaffName() . '%');
        if ($nomineeDto->getOrganizationId()) {
            $builder->where('organization_id', $nomineeDto->getOrganizationId());
        } else if (empty($nomineeDto->getOrganizationId()) && $nomineeDto->getUnitId()) {

            $builder->where('unit_id', $nomineeDto->getUnitId());
            $nomineeDto->getOrganizationName() && $builder->where('organization_name', 'like', '%' . $nomineeDto->getOrganizationName() . '%');
        } else {//工会可以查
            $nomineeDto->getOrganizationName() && $builder->where('organization_name', 'like', '%' . $nomineeDto->getOrganizationName() . '%');
            $nomineeDto->getUnitName() && $builder->whereHas('units', function ($builder) use ($nomineeDto) {
                $builder->where('name', 'like', '%' . $nomineeDto->getUnitName() . '%');
            });
        }
        $nomineeDto->getKind() && $builder->where('kind', $nomineeDto->getKind());
        if ($nomineeDto->getRecommend() ===0 || $nomineeDto->getRecommend() === 1) {
            $builder->where('recommend', $nomineeDto->getRecommend());

        }
        $nomineeDto->getYearpart() && $builder->where('nominees.created_at', 'like', $nomineeDto->getYearpart() . '%');
        $nomineeDto->getIndustryId() && $builder->where('industry_id', $nomineeDto->getIndustryId());
        if ($nomineeDto->getCaseSchemeId()) {
            $caseScheme = CaseSchemes::find($nomineeDto->getCaseSchemeId());
            switch ($caseScheme->type) {
                case 1:
                    $builder->where('case_scheme_id', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('month_win');
                    break;
                case 2:
                    $builder->where('quart', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('quarter_win');
                    break;
                case 3:
                    $builder->whereNotNull('quarter_win');
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('year_win');
                    break;
            }
        }

        if ($nomineeDto->getClassList()) {
            switch ($nomineeDto->getClassList()) {
                case 1:
                    $builder->where('declare_status', 0);
                    break;
                case 2:
                    $builder->where('declare_status', 1);
                    $builder->where('check_status', 0);
                    break;
                case 5:
                case 3:
                    $builder->where('check_status', 1);
                    break;
                case 4:
                    $builder->where('check_status', 2);
                    break;
                case 6:
                    $builder->where('declare_status', 1);
                    break;
            }
        }

        $nomineeDto->getOrgType() && $builder->whereHas('organization', function ($builder) use ($nomineeDto) {
            $builder->where('new_type', '=', $nomineeDto->getOrgType());
        });
        if ($nomineeDto->getCaseSchemeId()) {
            $caseScheme = CaseSchemes::find($nomineeDto->getCaseSchemeId());
            switch ($caseScheme->type) {
                case 1://月度之星
                    $builder->where('case_scheme_id', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('month_win');
                    break;
                case 2:
                    $builder->where('quart', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('quarter_win');
                    break;
                case 3:
                    $builder->whereNotNull('quarter_win');
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('year_win');
                    break;
            }
        }
//        if ($nomineeDto->getClassList()) {
//            switch ($nomineeDto->getClassList()) {
//                case 1://月度之星
//                    $builder->where('declare_status', 0);
//                    break;
//                case 2:
//                    $builder->where('declare_status', 1);
//                    $builder->where('check_status', 0);
//                    break;
//                case 5:
//                case 3:
//                    $builder->where('check_status', 1);
//                    break;
//                case 4:
//                    $builder->where('check_status', 2);
//                    break;
//            }
//        }
        $builder->leftJoin('industry_tag', 'industry_tag.id', '=', 'nominees.industry_id');
        $builder->select('nominees.*', 'industry_tag.industry_name as  industry_name');
        return $builder->paginate(15);
    }

    /**
     * 获取优秀个人
     * @param int $id
     * @return Builder|Builder[]|Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getDetail(int $id)
    {

        $builder = Nominee::query()->whereHas('caseSchemes')
//            ->whereHas()
//            ->leftJoin('case_schemes','case_schemes.id','=','nominees.case_scheme_id')
//            ->select('case_schemes.title as case_schemes_name')
//            ->select('nominees.*')
            ->find($id);

        return $builder;
    }

    public function edit(int $id)
    {

//        dd(Nominee::query()->where('id',$id)->first()->toSql());
        return Nominee::query()->find($id);
    }

    /**
     * 添加优秀个人
     * @param NomineeDTO $nomineeDto
     * @return string
     */
    public function store(NomineeDTO $nomineeDto)
    {
        if ($nomineeDto->getId())
            $nominee = Nominee::find($nomineeDto->getId());
        else {
            $nominee = new Nominee();
        }
        //根据电话判断用户是否存在
        if (Nominee::where('staff_phone', $nomineeDto->getStaffPhone())->where('id', '<>', $nomineeDto->getId())->get()->count() > 0) {
            return ['code' => '-1', 'message' => '优秀个人电话号码已存在'];
        }
        $nominee->staff_id = $nomineeDto->getStaffId() && $nomineeDto->getStaffId();
        $nomineeDto->getStaffName() && $nominee->staff_name = $nomineeDto->getStaffName();
        $nomineeDto->getStaffPhone() && $nominee->staff_phone = $nomineeDto->getStaffPhone();
        $nomineeDto->getStaffImg() && $nominee->staff_img = $nomineeDto->getStaffImg();
        //虚拟浏量
        $nomineeDto->getVStarCount() && $nominee->V_star_count = $nomineeDto->getVStarCount();
        $nomineeDto->getVBrowseCount() && $nominee->v_browse_count = $nomineeDto->getVBrowseCount();
        $nomineeDto->getBankCard() && $nominee->bank_card = $nomineeDto->getBankCard();
        $nomineeDto->getBankName() && $nominee->bank_name = $nomineeDto->getBankName();
        $nomineeDto->getBankCardImg() && $nominee->bank_card_img = $nomineeDto->getBankCardImg();
        $nomineeDto->getBankStaffName() && $nominee->bank_staff_name = $nomineeDto->getBankStaffName();
        $nomineeDto->getOrganizationId() && $nominee->organization_id = $nomineeDto->getOrganizationId();
        $nomineeDto->getOrganizationName() && $nominee->organization_name = $nomineeDto->getOrganizationName();
        $nomineeDto->getUnitId() && $nominee->unit_id = $nomineeDto->getUnitId();
        $nomineeDto->getKind() && $nominee->kind = $nomineeDto->getKind();
        $nomineeDto->getCaption() && $nominee->caption = $nomineeDto->getCaption();
        $nomineeDto->getMonthWin() && $nominee->month_win = $nomineeDto->getMonthWin();
        $nomineeDto->getCaseSchemeId() && $nominee->case_scheme_id = $nomineeDto->getCaseSchemeId();
        $nomineeDto->getStaffImg() && $nominee->staff_img = $nomineeDto->getStaffImg();
        $nomineeDto->getIndustryId() && $nominee->industry_id = $nomineeDto->getIndustryId();

        $result = $nominee->save();
        if ($nomineeDto->getPlanId()) {
            $planIdArr = explode(',', $nomineeDto->getPlanId());
            NomineesPlan::query()->where('nominee_id', $nominee->id)->whereNotIn('organizations_plan_id', $planIdArr)->delete();
            //ServiceHelper::make('Admin\NomineesPlanService')->batchDelete($nominee->id, $planIdArr);
            $planArr = [];
            //添加方案关联
            foreach ($planIdArr as $planid) {

                if (count(ServiceHelper::make('Admin\NomineesPlanService')->getDetail(['pid' => $planid, 'nid' => $nominee->id])) > 0) {
                    continue;
                }
                array_push($planArr, ['nominee_id' => $nominee->id,
                    'organizations_plan_id' => $planid,
                    'organizations_id' => $nominee->organization_id
                ]);
            }
            ServiceHelper::make('Admin\NomineesPlanService')->batchInsert($planArr);
        } else {
            //删除全部
            ServiceHelper::make('Admin\NomineesPlanService')->batchDelete($nominee->id, []);
        }
        if ($result)
            return ['code' => '1000', 'message' => '成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];

    }

    /**
     * 更新优秀个人
     * @param NomineeDTO $nomineeDto
     * @return string
     */
    public function update(NomineeDTO $nomineeDto)
    {
        $nominee = Nominee::find($nomineeDto->getId());
        $nomineeDto->getStaffId() && $nominee->staff_id = $nomineeDto->getStaffId();
        $nomineeDto->getStaffName() && $nominee->staff_name = $nomineeDto->getStaffName();
        $nomineeDto->getStaffPhone() && $nominee->staff_phone = $nomineeDto->getStaffPhone();
        $nomineeDto->getStaffImg() && $nominee->staff_img = $nomineeDto->getStaffImg();
        $nomineeDto->getBankCard() && $nominee->bank_card = $nomineeDto->getBankCard();
        $nomineeDto->getBankName() && $nominee->bank_name = $nomineeDto->getBankName();
        $nomineeDto->getBankCardImg() && $nominee->bank_card_img = $nomineeDto->getBankCardImg();
        $nomineeDto->getBankStaffName() && $nominee->bank_staff_name = $nomineeDto->getBankStaffName();
        $nomineeDto->getOrganizationId() && $nominee->organization_id = $nomineeDto->getOrganizationId();
        $nomineeDto->getOrganizationName() && $nominee->organization_name = $nomineeDto->getOrganizationName();
        $nomineeDto->getUnitId() && $nominee->unit_id = $nomineeDto->getUnitId();
        $nomineeDto->getKind() && $nominee->kind = $nomineeDto->getKind();
        $nomineeDto->getCaption() && $nominee->caption = $nomineeDto->getCaption();
        $nomineeDto->getMonthWin() && $nominee->month_win = $nomineeDto->getMonthWin();
        $nomineeDto->getCaseSchemeId() && $nominee->case_scheme_id = $nomineeDto->getCaseSchemeId();
        $nomineeDto->getIndustryId() && $nominee->industry_id = $nomineeDto->getIndustryId();

        $result = $nominee->save();
        if ($nomineeDto->getPlanId()) {
            $planIdArr = explode(',', $nomineeDto->getPlanId());
            NomineesPlan::query()->where('nominee_id', $nominee->id)->whereNotIn('organizations_plan_id', $planIdArr)->delete();
            //ServiceHelper::make('Admin\NomineesPlanService')->batchDelete($nominee->id, $planIdArr);
            $planArr = [];
            //添加方案关联
            foreach ($planIdArr as $planid) {

                if (count(ServiceHelper::make('Admin\NomineesPlanService')->getDetail(['pid' => $planid, 'nid' => $nominee->id])) > 0) {
                    continue;
                }
                array_push($planArr, ['nominee_id' => $nominee->id,
                    'organizations_plan_id' => $planid,
                    'organizations_id' => $nominee->organization_id
                ]);
            }
            ServiceHelper::make('Admin\NomineesPlanService')->batchInsert($planArr);
        } else {
            //删除全部
            ServiceHelper::make('Admin\NomineesPlanService')->batchDelete($nominee->id, []);
        }
        if ($result)
            return ['code' => '1000', 'message' => '修改成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     *优秀个人审核
     * 通过 自动成为月度之星
     * @param NomineeDTO $nomineeDTO
     * @return string[]
     */
    public function check(NomineeDTO $nomineeDTO)
    {
        $nominee = Nominee::find($nomineeDTO->getId());
        if (!$nominee->caseSchemes->is_open)
            return ['code' => '-1', 'message' => '赛事还未开启'];
        //验证工会推选是否开启
        if (!$nominee->caseSchemes->gh_is_join) {
            return ['code' => '-1', 'message' => '该赛事不需要工会推荐'];

        }
        if (!$nominee->caseSchemes->gh_is_open) {
            return ['code' => '-1', 'message' => '工会推荐还未开启'];
        }
        if (strtotime($nominee->caseSchemes->gh_stime) > time() || strtotime($nominee->caseSchemes->gh_etime) < time())
            return ['code' => '-1', 'message' => '还未到工会推选时间'];

        //设置为月度之星

        $user = AdminUsers::query()->where('org_id', $nominee->organization_id)->first();

        if ($nomineeDTO->getCheckStatus() && $nomineeDTO->getCheckStatus() === 1) {
            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '优秀个人审核', 'admin_id' => $nomineeDTO->getAdminid(), 'content' => '关于' . $nominee->staff_name . '的优秀个人申报已通过！'], 1));
            $nominee->month_win = date('Y-m-d h:i:s', time());//通过审核自动成为月度之星
        } elseif ($nomineeDTO->getCheckStatus() && $nomineeDTO->getCheckStatus() === 2) {
            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '优秀个人审核', 'admin_id' => $nomineeDTO->getAdminid(), 'content' => '关于' . $nominee->staff_name . '的优秀个人申报未通过，请修改后重新申报'], 1));
            //驳回
            $nominee->declare_status = 0;//修改申报状态
            $nominee->check_opinion = $nomineeDTO->getCheckOpinion();//驳回意见
        } else {
            return ['code' => '-1', 'message' => '状态错误'];
        }
        $nominee->check_at = date('Y-m-d h:i:s', time());
        $nominee->check_status = $nomineeDTO->getCheckStatus();//修改审核状态
        $result = $nominee->save();

        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     * 设置季度之星
     * @param $id
     *
     * @return string[]
     */
    public function quarter($arr)
    {
        $nominee = Nominee::find($arr[0]);
        if ($nominee->kind === 4) {
            return ['code' => '-1', 'message' => '服务之星只有月度之星'];
        }
        //获取关联的季度赛事状态未开启
        $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['type' => 2, 'is_open' => 1])->first();
        if ($caseScheme == null) {
            return ['code' => '-1', 'message' => '没有开启的季度之星赛事'];
        }
        $nominee->quart = $caseScheme->id;

        // $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['is_open' => 1, 'id' => $nominee->quart])->first();
        $user = AdminUsers::query()->where('org_id', $nominee->organization_id)->first();


        if ($caseScheme) {
            //获取年度之星赛事
            $caseSchemeYear = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['is_open' => 1, 'type' => 3])->first();
            $caseSchemeYear && $nominee->year = $caseSchemeYear->id;
            $nominee->quarter_win = date('Y-m-d h:i:s', time());
            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '优秀个人', 'admin_id' => $arr[1], 'content' => '恭喜！' . $nominee->staff_name . '已经成为季度之星！'], 1));

        } else
            return ['code' => '-1', 'message' => '当前没有季度之星相关赛事'];
        if ($nominee->save())
            return ['code' => '1000', 'message' => '设置成功'];
        return ['code' => '-1', 'message' => '操作失败请稍后再试'];
    }

    /**
     * 设置年度之星
     * @param $id
     *
     * @return string[]
     */
    public function year($arr)
    {
        $nominee = Nominee::find($arr[0]);
        $user = AdminUsers::query()->where('org_id', $nominee->organization_id)->first();

        $caseScheme = CaseSchemes::query()->orderBy('created_at', 'desc')->where(['type' => 3, 'is_open' => 1])->first();
        if ($caseScheme) {
            // $nominee->quart = $caseScheme->id;
            $nominee->year_win = date('Y-m-d h:i:s', time());
            $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '优秀个人', 'admin_id' => $arr[1], 'content' => '恭喜！' . $nominee->staff_name . '已经成为年度之星！'], 1));
        } else
            return ['code' => '-1', 'message' => '当前没有年度之星相关赛事'];
        if ($nominee->save())
            return ['code' => '1000', 'message' => '设置成功'];
        return ['code' => '-1', 'message' => '操作失败请稍后再试'];
    }

    /**
     * 删除优秀个人
     * @param int $id
     * @return string
     */
    public function destroy(int $id)
    {
        $result = Nominee::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }


    /**
     * 获取个人荣誉列表
     * @param Nominees_experienceDTO $nomineeDto
     * @return Builder[]|Collection
     */
    public function getExperienceList(Nominees_experienceDTO $nomineeDto)
    {
        $builder = Nominees_experience::query();
        $builder->where('mainId', $nomineeDto->getMainId());
        return $builder->orderBy('sort')->paginate(15);
    }

    /**
     * 获取优秀个人荣誉
     * @param int $id
     * @return 优秀个人荣誉详情
     */
    public function getDetailExperience(int $id)
    {
        return Nominees_experience::query()->find($id);
    }

    /**
     * 新增 修改 个人荣誉
     * @param NomineeDTO $nomineeDto
     * @return string
     */
    public function saveExperience(Nominees_experienceDTO $nomineeDto)
    {
        if ($nomineeDto->getId() == 0) {
            $nominee = new Nominees_experience();
        } else {
            $nominee = Nominees_experience::query()->find($nomineeDto->getId());
        }
        if ($nomineeDto->getImgUrl() == null) {
            return ['code' => '1001', 'message' => '请选择一个图片'];
        }
        $nominee->mainId = $nomineeDto->getMainId();
        $nominee->name = $nomineeDto->getName();
        $nominee->startTime = $nomineeDto->getStartTime();
        $nominee->endTime = $nomineeDto->getEndTime();
        $nominee->mark = $nomineeDto->getMark();
        $nominee->img_url = $nomineeDto->getImgUrl();
        $nominee->sort = $nomineeDto->getSort();
        $result = $nominee->save();
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }


    /**
     * 删除个人荣誉
     * @param int $id
     * @return string
     */
    public function destroyExperience(int $id)
    {
        $result = Nominees_experience::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }


    /**
     * 获取个人荣誉图集
     * @param Nominess_imgDTO $imgDto
     * @return Builder[]|Collection
     */
    public function getNominessImg(Nominess_imgDTO $imgDto)
    {
        $builder = Nominess_img::query();
        $builder->where('mainId', $imgDto->getMainId());
        return $builder->orderBy('sort')->paginate(15);
    }

    /**
     * 获取优秀个人荣誉图集
     * @param int $id
     * @return 优秀个人荣誉图片详情
     */
    public function getDetailNominessImg(int $id)
    {
        return Nominess_img::query()->find($id);
    }

    /**
     * 新增 修改 个人图集
     * @param Nominess_imgDTO $imgDto
     * @return string
     */
    public function saveNominessImg(Nominess_imgDTO $imgDto)
    {
        if ($imgDto->getId() == 0) {
            $nominee = new Nominess_img();
        } else {
            $nominee = Nominess_img::query()->find($imgDto->getId());
        }
        if ($imgDto->getImgUrl() == null) {
            return ['code' => '1001', 'message' => '请选择一个图片'];
        }
        $nominee->mainId = $imgDto->getMainId();
        $nominee->title = $imgDto->getTitle();
        $nominee->img_url = $imgDto->getImgUrl();
        $nominee->sort = $imgDto->getSort();
        $result = $nominee->save();
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     * 删除个人荣誉
     * @param int $id
     * @return string
     */
    public function destroyNominessImg(int $id)
    {
        $result = Nominess_img::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }


    /**
     * 获取个人荣誉视频
     * @param Nominees_experienceDTO $nomineeDto
     * @return Builder[]|Collection
     */
    public function getNominessVideo(Nominess_videoDTO $imgDto)
    {
        $builder = Nominess_video::query();
        $builder->where('mainId', $imgDto->getMainId());
        return $builder->orderBy('sort')->paginate(15);
    }

    /**
     * 获取优秀个人荣誉视频
     * @param int $id
     * @return 优秀个人视频详情
     */
    public function getDetailNominessVideo(int $id)
    {
        return Nominess_video::query()->find($id);
    }

    /**
     * 新增 修改 个人视频
     * @param NomineeDTO $videoDTO
     * @return string
     */
    public function saveNominessVideo(Nominess_videoDTO $videoDTO)
    {
        if ($videoDTO->getId() == 0) {
            $nominee = new Nominess_video();
        } else {
            $nominee = Nominess_video::query()->find($videoDTO->getId());
        }
        if ($videoDTO->getImgUrl() == null) {
            return ['code' => '1001', 'message' => '请选择一个图片'];
        }
        if ($videoDTO->getVideoUrl() == null) {
            return ['code' => '1001', 'message' => '请选择一个视频'];
        }
        $nominee->mainId = $videoDTO->getMainId();
        $nominee->title = $videoDTO->getTitle();
        $nominee->img_url = $videoDTO->getImgUrl();
        $nominee->video_url = $videoDTO->getVideoUrl();
        $nominee->sort = $videoDTO->getSort();
        $result = $nominee->save();
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

    /**
     * 删除个人荣誉视频
     * @param int $id
     * @return string
     */
    public function destroyNominessVideo(int $id)
    {
        $result = Nominess_video::destroy($id);
        if ($result)
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];

    }

    /**
     * 获取优秀个人列表Excel
     * @param NomineeDTO $nomineeDto
     * @return Builder[]|Collection
     */
    public function getListToExcel(NomineeDTO $nomineeDto)
    {
        /** @var TYPE_NAME $builder */
        $builder = Nominee::query()->leftJoin("industry_tag", 'nominees.industry_id', '=', 'industry_tag.id')->leftJoin("units", 'nominees.unit_id', '=', 'units.id')->select(["nominees.*", "industry_tag.industry_name as nominee_industry_name", 'units.name as unit_name']);
        $nomineeDto->getStaffName() && $builder->where('staff_name', 'like', '%' . $nomineeDto->getStaffName() . '%');
        if ($nomineeDto->getOrganizationId()) {
            $builder->where('organization_id', $nomineeDto->getOrganizationId());
        } else if (empty($nomineeDto->getOrganizationId()) && $nomineeDto->getUnitId()) {
            $builder->where('unit_id', $nomineeDto->getUnitId());
            $nomineeDto->getOrganizationName() && $builder->where('organization_name', 'like', '%' . $nomineeDto->getOrganizationName() . '%');
        } else {//工会可以查

            $nomineeDto->getOrganizationName() && $builder->where('organization_name', 'like', '%' . $nomineeDto->getOrganizationName() . '%');
            $nomineeDto->getUnitName() && $builder->whereHas('units', function ($builder) use ($nomineeDto) {
                $builder->where('name', 'like', '%' . $nomineeDto->getUnitName() . '%');
            });
        }
        $nomineeDto->getKind() && $builder->where('kind', $nomineeDto->getKind());
        $nomineeDto->getIndustryId() && $builder->where('industry_id', $nomineeDto->getIndustryId());
        $nomineeDto->getOrgType() && $builder->whereHas('organization', function ($builder) use ($nomineeDto) {
            $builder->where('new_type', '=', $nomineeDto->getOrgType());
        });
        if ($nomineeDto->getCaseSchemeId()) {
            $caseScheme = CaseSchemes::find($nomineeDto->getCaseSchemeId());
            switch ($caseScheme->type) {
                case 1://月度之星
                    $builder->where('case_scheme_id', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('month_win');
                    break;
                case 2:
                    $builder->where('quart', $nomineeDto->getCaseSchemeId());
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('quarter_win');
                    break;
                case 3:
                    $builder->whereNotNull('quarter_win');
                    if ($nomineeDto->getIsWin())
                        $builder->whereNotNull('year_win');
                    break;
            }
        }
        if ($nomineeDto->getClassList()) {
            switch ($nomineeDto->getClassList()) {
                case 1://月度之星
                    $builder->where('declare_status', 0);
                    break;
                case 2:
                    $builder->where('declare_status', 1);
                    $builder->where('check_status', 0);
                    break;
                case 5:
                case 3:
                    $builder->where('check_status', 1);
                    break;
                case 4:
                    $builder->where('check_status', 2);
                    break;
            }
        }
        return $builder->get();
    }

    /**
     * 申报月度之星
     * @param $id
     * @return string[]
     */
    public function declareNominee($arr)
    {
        //
        $kindarr = ['劳动之星' => 1, '技能之星' => 2, '创新之星' => 3, '服务之星' => 4];
        $nominee = Nominee::find($arr[0]);
        if (!$nominee->caseSchemes->is_open)
            return ['code' => '-1', 'message' => '赛事还未开启'];
        if (strtotime($nominee->caseSchemes->qy_stime) > time())
            return ['code' => '-1', 'message' => '还未到企业推选时间'];
        if (strtotime($nominee->caseSchemes->qy_etime) < time())
            return ['code' => '-1', 'message' => '企业推选时间已过'];
        //判断当前是否申报过 申报状态
        //查询当前企业申报情况
        $builder = Nominee::query()->where('organization_id', $nominee->organization_id);

        $builder->where('case_scheme_id', $nominee->case_scheme_id);
        $builder->where('declare_status', 1);//已申报
        $builder->where('kind', $kindarr[$nominee->kind]);//申报类型
//        $oldNominee=$builder->get();
        if ($builder->count()) {
            return ['code' => '-1', 'message' => '当前赛事已经申报过' . $nominee->kind];
        }
        $nominee->declare_status = 1;
        $nominee->check_status = 0;
        $nominee->declare_at = date('Y-m-d H:i:s', time());
        $user = AdminUsers::query()->where('units_id', $nominee->unit_id)->first();
        $user && $this->dispatch(new SendMsg(['id' => $user->id], ['title' => '优秀个人申报', 'admin_id' => $arr[1], 'content' => '你有新的优秀个人申报信息，' . $nominee->plan_name . '请及时处理！'], 1));

        if ($nominee->save())
            return ['code' => '1000', 'message' => '申报成功'];
        else
            return ['code' => '-1', 'message' => '申报失败，请稍后再试！'];


    }

    /**
     * 设置虚拟数据
     * @param NomineeDTO $nomineeDto
     * @return string[]
     */
    public function setvirtual(NomineeDTO $nomineeDto)
    {
        if ($nomineeDto->getId()) {
            $nominee = Nominee::find($nomineeDto->getId());
            $nomineeDto->getVStarCount() && $nominee->V_star_count = $nomineeDto->getVStarCount();
            $nomineeDto->getVBrowseCount() && $nominee->v_browse_count = $nomineeDto->getVBrowseCount();
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
     * @param $id
     * @return string[]
     */
    public function recommend(NomineeDTO $nomineeDto)
    {
        $nominee = Nominee::find($nomineeDto->getId());
        $nominee->recommend = $nomineeDto->getRecommend();
        if ($nominee->save())
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败，请稍后再试！'];
    }

}