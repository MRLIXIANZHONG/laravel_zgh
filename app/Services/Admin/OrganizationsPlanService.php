<?php


namespace App\Services\Admin;

use App\DTO\OrganizationsPlanDTO;
use App\Jobs\SendMsg;
use App\Models\AdminUsers;
use App\Models\Organization;
use App\Models\OrganizationsPlan;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class OrganizationsPlanService extends Service
{
    public function getList(OrganizationsPlanDTO $dto)
    {
        $builder = OrganizationsPlan::query();
        $dto->getOrganizationId() && $builder->where('organization_id', $dto->getOrganizationId());
        $dto->getIsrecommend() && $builder->where('isrecommend', $dto->getIsrecommend());
        $dto->getIsexcellent() && $builder->where('isexcellent', $dto->getIsexcellent());
        $dto->getCheckState() && $builder->where('check_state', $dto->getCheckState());
        $dto->getPlanName() && $builder->where('plan_name', 'like', '%' . $dto->getPlanName() . '%');

        if (!$dto->getPagelimite()){
            return $builder->get();
        }

        return $builder->paginate($dto->getPagelimite());
    }

    public function getList1($array)
    {
        if ($array[3]== 1) {
            //改了方案状态,查询基层工会得用0
            $array[0]->getCheckState() == 0;
            $List = Organization::query()->where('unit_id', $array[1])->select('id')->get();
            //查找工会下的企业
            $idArr = [];
            foreach ($List as $id)
                array_push($idArr, $id['id']);
            $builder = OrganizationsPlan::query();
            $builder->whereIn('organization_id', $idArr);
//            $builder->whereIn('check_state', [1,0,-1,-6]);
            if (!is_null($array[0]->getCheckState()))
                $builder->where('check_state', $array[0]->getCheckState());
            $array[0]->getPlanName() && $builder->where('plan_name', 'like', '%' . $array[0]->getPlanName() . '%');
            if ($array[2] == 2)
                $dataarray = $builder->orderByDesc('id')->paginate($array[0]->getPagelimite());
            else
                $dataarray = $builder->paginate($array[0]->getPagelimite());

            //获取所属行业
            $getOrganizationidArr = "";
            foreach ($dataarray as $item)
                $getOrganizationidArr = $getOrganizationidArr . $item->organization_id . ",";
            $getOrganizationidArr = rtrim($getOrganizationidArr, ',');
            $industryList = [];
            if (!empty($getOrganizationidArr)) {
                $data = DB::select("select organization_industry_maps.organization_id as id,industry_tag.industry_name as name  from organization_industry_maps
                JOIN industry_tag
                on
                organization_industry_maps.industry_id=industry_tag.id
                where organization_industry_maps.organization_id in(" . $getOrganizationidArr . ")");


                foreach ($data as $item) {
                    if (empty($industryList[$item->id])) {
                        $industryList[$item->id] = $item->name . ",";
                    } else {
                        $industryList[$item->id] = $industryList[$item->id] . $item->name . ",";
                    }
                }
            }
            return [$dataarray, $industryList];
        } else {
            $builder = OrganizationsPlan::query();
//            if ($array[3]== 5)
//                $builder->whereIn('check_state', [4,-5]);
            if (!is_null($array[0]->getCheckState()))
                $builder->where('check_state', $array[0]->getCheckState());
            $array[0]->getOrganizationId() && $builder->where('organization_id', $array[0]->getOrganizationId());
            $array[0]->getPlanName() && $builder->where('plan_name', 'like', '%' . $array[0]->getPlanName() . '%');
            $array[0]->getIsexcellent() && $builder->where('isexcellent', $array[0]->getIsexcellent());
            $dataarray = null;
            if ($array[0]->getPagelimite() === 0) {
                if ($array[2] == 2)
                    $dataarray = $builder->orderByDesc('id')->get();
                else
                    $dataarray = $builder->get();
            } else {
                if ($array[2] == 2)
                    $dataarray = $builder->orderByDesc('id')->paginate($array[0]->getPagelimite());
                else
                    $dataarray = $builder->paginate($array[0]->getPagelimite());
            }
            //获取所属行业
            $getOrganizationidArr = "";
            foreach ($dataarray as $item)
                $getOrganizationidArr = $getOrganizationidArr . $item->organization_id . ",";
            $getOrganizationidArr = rtrim($getOrganizationidArr, ',');
            $industryList = [];
            if (!empty($getOrganizationidArr)) {
                $data = DB::select("select organization_industry_maps.organization_id as id,industry_tag.industry_name as name  from organization_industry_maps
            JOIN industry_tag
            on
            organization_industry_maps.industry_id=industry_tag.id
            where organization_industry_maps.organization_id in(" . $getOrganizationidArr . ")");


                foreach ($data as $item) {
                    if (empty($industryList[$item->id])) {
                        $industryList[$item->id] = $item->name . ",";
                    } else {
                        $industryList[$item->id] = $industryList[$item->id] . $item->name . ",";
                    }
                }
            }
            return [$dataarray, $industryList];
        }
    }

    public function show($OrganizationsPlanid)
    {
        //$organizationsplan = DB::select('select * from users where organization_id = ?', $organizationId);
        $OrganizationsPlan = OrganizationsPlan::find($OrganizationsPlanid);
        return $OrganizationsPlan;
    }

    public function store1(OrganizationsPlanDTO $dto)
    {
        DB::table('organizations_plan')->insert([
            'organization_id' => $dto->getOrganizationId(),
            'plan_name' => $dto->getPlanName(),
            'summary' => $dto->getSummary(),
            'content' => $dto->getContent(),
            'target_task' => $dto->getTargetTask(),
            'achievement_target' => $dto->getAchievementTarget(),
            'measures' => $dto->getMeasures(),
            'commend' => $dto->getCommend(),
            'img_url' => $dto->getImgUrl(),
            'staffs_info' => $dto->getStaffsInfo(),
            'check_state' => $dto->getCheckState(),
            'created_at' => $dto->getCreatedAt(),
            'updated_at' => $dto->getUpdatedAt(),
            'grade' => $dto->getGrade(),
            'star_count' => $dto->getStarCount(),
            'browse_count' => $dto->getBrowseCount(),
        ]);
        return '{"code":1000,"msg":"成功"}';
    }

    public function store(OrganizationsPlanDTO $dto)
    {
        $OrganizationsPlan = new OrganizationsPlan;
        $dto->getOrganizationId() && $OrganizationsPlan->organization_id = $dto->getOrganizationId();
        $dto->getUnitId() && $OrganizationsPlan->unit_id = $dto->getUnitId();
        $dto->getPlanName() && $OrganizationsPlan->plan_name = $dto->getPlanName();
        $dto->getSummary() && $OrganizationsPlan->summary = $dto->getSummary();
        $dto->getContent() && $OrganizationsPlan->content = $dto->getContent();
        $dto->getTargetTask() && $OrganizationsPlan->target_task = $dto->getTargetTask();
        $dto->getAchievementTarget() && $OrganizationsPlan->achievement_target = $dto->getAchievementTarget();
        $dto->getMeasures() && $OrganizationsPlan->measures = $dto->getMeasures();
        $dto->getCommend() && $OrganizationsPlan->commend = $dto->getCommend();
        $dto->getImgUrl() && $OrganizationsPlan->img_url = $dto->getImgUrl();
        $dto->getStaffsInfo() && $OrganizationsPlan->staffs_info = $dto->getStaffsInfo();
        $dto->getShareTitle() && $OrganizationsPlan->share_title = $dto->getShareTitle();
        $dto->getContent() && $OrganizationsPlan->share_content = $dto->getContent();
        $dto->getShareImgUrl() && $OrganizationsPlan->share_img_url = $dto->getShareImgUrl();
        $dto->getFarmerCount() && $OrganizationsPlan->farmer_count = $dto->getFarmerCount();
        $dto->getPlanTheme() && $OrganizationsPlan->plan_theme = $dto->getPlanTheme();
        $OrganizationsPlan->check_state = -6;
        $OrganizationsPlan->grade = $dto->getGrade();
        $OrganizationsPlan->star_count = 0;
        $OrganizationsPlan->browse_count = 0;
        $OrganizationsPlan->system_version = 'cqzgh';
        $OrganizationsPlan->isrecommend = 0;
        $OrganizationsPlan->isexcellent = 0;
        $OrganizationsPlan->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function update(OrganizationsPlanDTO $dto)
    {

        $OrganizationsPlan = OrganizationsPlan::find($dto->getId());
        $dto->getOrganizationId() && $OrganizationsPlan->organization_id = $dto->getOrganizationId();
        $dto->getUnitId() && $OrganizationsPlan->unit_id = $dto->getUnitId();
        $dto->getPlanName() && $OrganizationsPlan->plan_name = $dto->getPlanName();
        $dto->getSummary() && $OrganizationsPlan->summary = $dto->getSummary();
        $dto->getContent() && $OrganizationsPlan->content = $dto->getContent();
        $dto->getTargetTask() && $OrganizationsPlan->target_task = $dto->getTargetTask();
        $dto->getAchievementTarget() && $OrganizationsPlan->achievement_target = $dto->getAchievementTarget();
        $dto->getMeasures() && $OrganizationsPlan->measures = $dto->getMeasures();
        $dto->getCommend() && $OrganizationsPlan->commend = $dto->getCommend();
        $dto->getImgUrl() && $OrganizationsPlan->img_url = $dto->getImgUrl();
        $dto->getStaffsInfo() && $OrganizationsPlan->staffs_info = $dto->getStaffsInfo();
        $dto->getGrade() && $OrganizationsPlan->grade = $dto->getGrade();
        $dto->getStarCount() && $OrganizationsPlan->star_count = $dto->getStarCount();
        $dto->getBrowseCount() && $OrganizationsPlan->browse_count = $dto->getBrowseCount();
        $dto->getFictitiousBrowseCount() && $OrganizationsPlan->fictitious_browse_count = $dto->getFictitiousBrowseCount();
        $dto->getFictitiousStarCount() && $OrganizationsPlan->fictitious_star_count = $dto->getFictitiousStarCount();
        $dto->getFarmerCount() && $OrganizationsPlan->farmer_count = $dto->getFarmerCount();
        $dto->getShareTitle() && $OrganizationsPlan->share_title = $dto->getShareTitle();
        $dto->getShareContent() && $OrganizationsPlan->share_content = $dto->getShareContent();
        $dto->getShareImgUrl() && $OrganizationsPlan->share_img_url = $dto->getShareImgUrl();
        $dto->getPlanTheme() && $OrganizationsPlan->plan_theme = $dto->getPlanTheme();
        $dto->getThemeInfo() && $OrganizationsPlan->theme_info = $dto->getThemeInfo();
        $dto->getAchievements() && $OrganizationsPlan->achievements = $dto->getAchievements();
        $dto->getAchievementsInfo() && $OrganizationsPlan->achievements_info = $dto->getAchievementsInfo();
        $OrganizationsPlan->nopassinfo = $dto->getNopassinfo();
        if (!is_null($dto->getCheckState()))
            $OrganizationsPlan->check_state = $dto->getCheckState();
        $OrganizationsPlan->save();
        if ($dto->getCheckState() == -1 || $dto->getCheckState() == -5) 
            return '{"code":2000,"msg":"成功"}';
        return '{"code":1000,"msg":"成功"}';
    }

    //array[$id,$creat_userid]
    public function changeCheckState($array)
    {
        if (!is_null($array[0]->getCheckState())) {
            $OrganizationsPlan = OrganizationsPlan::find($array[0]->getId());
            $oldstate = $OrganizationsPlan->check_state;

            if ($array[0]->getCheckState() == 0 && $oldstate != $array[0]->getCheckState()) {
                $budild = AdminUsers::query();
                $budild->join('admin_role_users', 'admin_role_users.user_id', 'admin_users.id');
                $budild->join('admin_roles', 'admin_roles.id', 'admin_role_users.role_id');
                $budild->where('admin_roles.slug', 'union');
                $budild->where('admin_users.units_id', $OrganizationsPlan->unit_id);
                $budild->select('admin_users.id as id');
                $admin = $budild->first();
                $this->dispatch(new SendMsg(['id' => $admin->id], ['admin_id' => $array[1], 'title' => '方案消息', 'content' => "【" . $OrganizationsPlan->plan_name . "】有一条企业消息，请查阅"], 1));
                $OrganizationsPlan->check_state = $array[0]->getCheckState();
                $OrganizationsPlan->save();
            }

            if($array[0]->getCheckState() == 1 ||$array[0]->getCheckState() ==5){
                $OrganizationsPlan->check_state = $array[0]->getCheckState();
                $OrganizationsPlan->save();
            }

            if ($array[0]->getCheckState() == 4 && $oldstate != $array[0]->getCheckState()) {
                $budild = AdminUsers::query();
                $budild->join('admin_role_users', 'admin_role_users.user_id', 'admin_users.id');
                $budild->join('admin_roles', 'admin_roles.id', 'admin_role_users.role_id');
                $budild->where('admin_roles.slug', 'adminunion');
                $budild->select('admin_users.id as id');
                $admin = $budild->first();
                $this->dispatch(new SendMsg(['id' => $admin->id], ['admin_id' => $array[1], 'title' => '方案消息', 'content' => "【" . $OrganizationsPlan->plan_name . "】有一条企业消息，请查阅"], 1));
                $OrganizationsPlan->check_state = $array[0]->getCheckState();
                $OrganizationsPlan->save();
            }

            if($array[0]->getCheckState() == -1||$array[0]->getCheckState() == -5){
                $budild = AdminUsers::query();
                $budild->where('org_id',$array[0]->getOrganizationId());
                $admin = $budild->first();
                if(!empty($admin))
                    $this->dispatch(new SendMsg(['id' => $admin->id], ['admin_id' => $array[1], 'title' => '方案消息', 'content' => "【" . $OrganizationsPlan->plan_name . "】有一条企业消息，请查阅"], 1));
            }
        }

        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy($request)
    {
        DB::delete('delete from leaders_organizations_plan where organizations_plan_id=' . $request->id);

        DB::delete('delete from nominees_organizations_plan where organizations_plan_id=' . $request->id);

        $OrganizationsPlan = OrganizationsPlan::find($request->id);
        if ($OrganizationsPlan->check_state == -6) {
            OrganizationsPlan::destroy($request->id);
            return '{"code":1000,"msg":"成功"}';
        } else
            return '{"code":1001,"msg":"只能删除未提交的数据"}';
    }

    public function updateExcellentSelection($request)
    {
        if (!empty($request->isrecommend)) {
            $listisrecommend = explode(",", $request->isrecommend);
            $idStr = '';
            for ($i = 0; $i <= count($listisrecommend) - 1; $i++) {
                if (count($listisrecommend) - 1 === $i)
                    $idStr = $idStr . '?';
                else
                    $idStr = $idStr . '?' . ',';
            }
            $affected = DB::update('update organizations_plan set isexcellent = 1 where id in (' . $idStr . ')', $listisrecommend);
        }
        if (!empty($request->notrecommend)) {
            $listisrecommend = explode(",", $request->notrecommend);
            $idStr = '';
            for ($i = 0; $i <= count($listisrecommend) - 1; $i++) {
                if (count($listisrecommend) - 1 === $i)
                    $idStr = $idStr . '?';
                else
                    $idStr = $idStr . '?' . ',';
            }
            $affected = DB::update('update organizations_plan set case_scheme_id=0,isexcellent = 0 where id in (' . $idStr . ')', $listisrecommend);
        }
        return '{"code":1000,"msg":"成功"}';
    }

    public function updateRecommend($request)
    {
        if (!empty($request->isrecommend)) {
            $listisrecommend = explode(",", $request->isrecommend);
            $idStr = '';
            for ($i = 0; $i <= count($listisrecommend) - 1; $i++) {
                if (count($listisrecommend) - 1 === $i)
                    $idStr = $idStr . '?';
                else
                    $idStr = $idStr . '?' . ',';
            }
            $affected = DB::update('update organizations_plan set isrecommend = 1 where id in (' . $idStr . ')', $listisrecommend);
        }
        if (!empty($request->notrecommend)) {
            $listisrecommend = explode(",", $request->notrecommend);
            $idStr = '';
            for ($i = 0; $i <= count($listisrecommend) - 1; $i++) {
                if (count($listisrecommend) - 1 === $i)
                    $idStr = $idStr . '?';
                else
                    $idStr = $idStr . '?' . ',';
            }
            $affected = DB::update('update organizations_plan set isrecommend = 0 where id in (' . $idStr . ')', $listisrecommend);
        }
        return '{"code":1000,"msg":"成功"}';
    }

    public function excellentRelation($array)
    {
        $OrganizationsPlan = OrganizationsPlan::find($array[0]);
        $OrganizationsPlan->case_scheme_id = $array[1];
        $OrganizationsPlan->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function export()
    {
        $data2 = DB::select("select
                            a.id as id,
                            a.plan_name as planname,
                            CASE a.grade
                            WHEN 0 THEN
                                    '非重点'
                            WHEN 1 THEN
                                    '市重点'
                            WHEN 2 THEN
                                    '国家重点'
                            END as grade,
                            b.name as organizationsname,
                            CASE b.new_type
                            WHEN 1 THEN
                                    '国营控股企业'
                            WHEN 2 THEN
                                    '行政机关'
                            WHEN 3 THEN
                                    '港澳台、外商投资企业'
                            WHEN 4 THEN
                                    '民营控股企业'
                            WHEN 5 THEN
                                    '事业单位'
                            else  
                                    '其他'
                            END as new_type,
                            c.name as unitsname,
                            a.star_count as star_count,
                            a.browse_count as browse_count,
                            b.username as username,
                            b.mobile as mobile ,
                            b.id as organization_id ,
                            '' as industry 
                            from organizations_plan a
                            JOIN organizations b
                            on a.organization_id=b.id
                            JOIN units c
                            on b.unit_id=c.id");
        //获取所属行业
        $getOrganizationidArr = "";
        foreach ($data2 as $item)
            $getOrganizationidArr = $getOrganizationidArr . $item->organization_id . ",";
        $getOrganizationidArr = rtrim($getOrganizationidArr, ',');
        $industryList = [];
        if (!empty($getOrganizationidArr)) {
            $data = DB::select("select organization_industry_maps.organization_id as id,industry_tag.industry_name as name  from organization_industry_maps
                JOIN industry_tag
                on
                organization_industry_maps.industry_id=industry_tag.id
                where organization_industry_maps.organization_id in(" . $getOrganizationidArr . ")");


            foreach ($data as $item) {
                if (empty($industryList[$item->id])) {
                    $industryList[$item->id] = $item->name . ",";
                } else {
                    $industryList[$item->id] = $industryList[$item->id] . $item->name . ",";
                }
            }
        }


        for ($x = 0; $x < count($data2); $x++) {
            if (!empty($industryList[$data2[$x]->organization_id]))
                $data2[$x]->industry = rtrim($industryList[$data2[$x]->organization_id], ',');
        }

        return $data2;
    }

}