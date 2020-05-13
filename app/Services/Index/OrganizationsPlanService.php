<?php


namespace App\Services\Index;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationsPlanDTO;
use App\Models\Industry;
use App\Models\OrganizationsPlan;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class OrganizationsPlanService extends Service
{
    //获取企业方案
    public function getList(OrganizationsPlanDTO $dto){
        if(!is_null($dto->getIndustry())){
            $industrybuilder = Industry::query();
            $industrybuilder->Join('organization_industry_maps', 'industry_tag.id', 'organization_industry_maps.industry_id');
            $industrybuilder->where('organization_industry_maps.industry_id',$dto->getIndustry()) ;
            $industrybuilder->select('organization_industry_maps.organization_id');
            $industrybuilder->distinct('organization_industry_maps.organization_id') ;
            $dataarray1=$industrybuilder->get();
            $idarray=[];
            foreach ($dataarray1 as $item)
            {
                array_push($idarray,$item->organization_id);
            }

            $builder = OrganizationsPlan::query();
            $builder->Join('organizations', 'organizations_plan.organization_id', 'organizations.id');
            $builder->Join('units', 'units.id', 'organizations.unit_id');
            $dto->getUnitId() && $builder->where('units.id',$dto->getUnitId());
            $dto->getOrganizationId() && $builder->where('organizations.id',$dto->getOrganizationId());
            $dto->getIsexcellent() && $builder->where('organizations_plan.isexcellent',$dto->getIsexcellent());
            $builder->where('organizations_plan.check_state',5);
            $builder->select('organizations_plan.id',
                'organizations_plan.plan_name',
                'organizations_plan.summary',
                'organizations.name',
                'organizations_plan.img_url',
                'organizations.id as oid',
                'organizations.name as oname',
                'units.id as uid',
                'units.name_index as name_index',
                'units.name as uname',
                'organizations_plan.star_count',
                'organizations_plan.browse_count',
                'organizations_plan.fictitious_browse_count',
                'organizations_plan.fictitious_star_count'
                );
            $dto->getUnitId() && $builder->where('units.id',$dto->getUnitId());
            $dto->getNewType() && $builder->where('organizations.new_type', $dto->getNewType());
            $dto->getOrganizationId() && $builder->where('organizations.id',$dto->getOrganizationId());
            $dto->getIsexcellent() && $builder->where('organizations_plan.isexcellent',$dto->getIsexcellent());
            $name=$dto->getPlanName();
            $builder->where(function ($query) use ($name) {
                $query->where('organizations_plan.plan_name', 'like', "%{$name}%")->orWhere('organizations.name', 'like', "%{$name}%");
            });

            $builder->whereIn('organizations.id',$idarray);
            $dataarray = $builder->paginate($dto->getPageSize());

        }
        else {
                $builder = OrganizationsPlan::query();
                $builder->Join('organizations', 'organizations_plan.organization_id', 'organizations.id');
                $builder->Join('units', 'units.id', 'organizations.unit_id');
                $dto->getNewType() && $builder->where('organizations.new_type', $dto->getNewType());
                $dto->getUnitId() && $builder->where('units.id',$dto->getUnitId());
                $dto->getOrganizationId() && $builder->where('organizations.id',$dto->getOrganizationId());
                $dto->getIsexcellent() && $builder->where('organizations_plan.isexcellent',$dto->getIsexcellent());
                $builder->where('organizations_plan.check_state',5);
                $name=$dto->getPlanName();
                $builder->where(function ($query) use ($name) {
                    $query->where('organizations_plan.plan_name', 'like', "%{$name}%")->orWhere('organizations.name', 'like', "%{$name}%");
                });

                $builder->select('organizations_plan.id',
                    'organizations_plan.plan_name',
                    'organizations_plan.summary',
                    'organizations.name',
                    'organizations_plan.img_url',
                    'organizations.id as oid',
                    'organizations.name as oname',
                    'units.id as uid',
                    'units.name as uname',
                    'units.name_index as name_index',
                    'organizations_plan.star_count',
                    'organizations_plan.browse_count',
                    'organizations_plan.fictitious_browse_count',
                    'organizations_plan.fictitious_star_count');
                $dataarray = $builder->paginate($dto->getPageSize());
        }
        
        //获取所属行业
        $getOrganizationidArr = "";
        foreach ($dataarray as $item)
            $getOrganizationidArr = $getOrganizationidArr . $item->oid . ",";
        $getOrganizationidArr = rtrim($getOrganizationidArr, ',');
        $planindustryList = [];
        if (!empty($getOrganizationidArr)) {
            $data = DB::select("select organization_industry_maps.organization_id as id,industry_tag.industry_name as name  from organization_industry_maps
                JOIN industry_tag
                on
                organization_industry_maps.industry_id=industry_tag.id
                where organization_industry_maps.organization_id in(" . $getOrganizationidArr . ")");


            foreach ($data as $item) {
                if (empty($planindustryList[$item->id])) {
                    $planindustryList[$item->id] = $item->name . ",";
                } else {
                    $planindustryList[$item->id] = $planindustryList[$item->id] . $item->name . ",";
                }
            }
        }

        $industry= Industry::query()->get();
        return [$dataarray, $planindustryList,$industry];
    }

    //获取参数方案的各个数据
    public function getOrganizationsPlanStatisticsCount(){
        $data1 = DB::select ("select 
           COUNT(browse_count) as  browseAllCount,
           COUNT(star_count) as starAllCount,
           COUNT(id) organizationsPlanAllCount  
           from  organizations_plan where system_version='cqzgh'");

        $data2 = DB::select ("SELECT  
            count(DISTINCT(organization_id)) 
            as organizationsAllCount  
            from organizations_plan 
            where system_version='cqzgh'");
        
        $data=['browseAllCount'=>$data1[0]->browseAllCount,
            'starAllCount'=>$data1[0]->starAllCount,
            'organizationsPlanAllCount'=>$data1[0]->organizationsPlanAllCount,
            'organizationsAllCount'=>$data2[0]->organizationsAllCount];
        return $data;
    }

//    //$array[industry_tag_id,units_id,organizationstype]
//    //industry_tag_id:行业id,units_id:工会id,organizationstype:组织类型
//    public  function excellentOrganizationsPlanList($array){
//        //行业数据
//        $dto=new IndustryDTO([]);
//        $Industry = ServiceHelper::make('Admin\IndustryService')->getList($dto);
//
//        //优秀方案对应工会数据
//        $organizations=DB::select("select name from units where id in (
//            select DISTINCT(b.unit_id) from organizations_plan a
//            JOIN organizations b
//            on a.organization_id=b.id
//            where isexcellent =1)");
//
//        //优秀方案对应组织数据
//
//        //优秀方案列表数据
//        $qurrystr="";
//        if(!empty($array->industry_tag_id))
//            $qurrystr."and d.id=".$array->industry_tag_id;
//        if(!empty($array->units_id))
//            $qurrystr."and c.id=".$array->units_id ;
//
//        //组织类型id
//        //        if(!empty($array->organizationstype))
//        //            $qurrystr."and c.id=".$array->organizationstype;
//
//        $data2 = DB::select("select
//            a.plan_name as organizations_plan_name,
//            a.content as organizations_plan_content,
//            a.id as organizations_plan_id,
//            b.name as organizations_name,
//            c.name as units_name,
//            d.industry_name as industry_name
//            from organizations_plan a
//            JOIN organizations b
//            on a.organization_id=b.id
//            JOIN units c
//            on b.unit_id=c.id
//            JOIN industry_tag d
//            on b.industry=d.id
//            where a.isexcellent =1 ".$qurrystr);
//
//        return ["Industry"=>$Industry,"organizations"=>$organizations,"organizationPlans"=>$data2];
//    }

    public function getDetail($organizationsPlanId){
        //获取方案信息
        $data1= DB::select("select
            b.name as organizationName,
            b.industry as organizationIndustry,
            c.name as unitsName,
            b.new_type as organizationNewType,
            b.username as organizationUsername,
            b.img_url as organizationImgUrl,
            a.summary as planSummary,
            a.star_count as planStarCount,
            a.browse_count as planBrowseCount,
            a.img_url as planImgUrl,
            a.plan_name as planName,
            a.content as planContent,
            a.grade as planGrade,
            a.staffs_info as planStaffsInfo,
            a.target_task as planTargetTask,
            a.achievement_target as planAchievementTarget,
            a.fictitious_browse_count as fictitious_browse_count,
            a.fictitious_star_count as fictitious_star_count,
            a.browse_count as browse_count,
            a.star_count as star_count,
            a.measures as planMeasures,
            a.id as planId,
            b.id as organizationId,
            c.id as unitsId,
            a.share_title as oshare_title,
            a.share_content as oshare_content,
            a.share_img_url as oshare_img_url
            from organizations_plan a
            JOIN organizations b
            on a.organization_id=b.id
            JOIN units c
            on b.unit_id=c.id
            where a.id=
            ".$organizationsPlanId);

        //获取企业方案对应组织领导
        $data2=DB::select("select
            a.img_url,
            a.name,
            a.position
            from leaders a
            JOIN leaders_organizations_plan b
            on a.id=b.leaders_id
            where b.organizations_plan_id=".$organizationsPlanId);

        //获取企业方案对应方案活动
        $data3=DB::select("select
            `name`,
            stage_number,
            img_url,
            start_time,
            end_time,
            `describe`
            from segments where organization_id=".$organizationsPlanId);

        //获取企业方案对应参与人员
        $data4=DB::select("select * from nominees where id in(
            select nominee_id from nominees_organizations_plan where organizations_plan_id =".$organizationsPlanId."
        )");

        $planindustryList = [];
        $data = DB::select("select organization_industry_maps.organization_id as id,industry_tag.industry_name as name  from organization_industry_maps
            JOIN industry_tag
            on
            organization_industry_maps.industry_id=industry_tag.id
            where organization_industry_maps.organization_id =".$data1[0]->organizationId);

        foreach ($data as $item) {
            if (empty($planindustryList[$item->id])) {
                $planindustryList[$item->id] = $item->name . ",";
            } else {
                $planindustryList[$item->id] = $planindustryList[$item->id] . $item->name . ",";
            }
        }


        return ["organizationAndPlan"=>$data1,"leaders"=>$data2,"segments"=>$data3,"nominees"=>$data4,"planindustryList"=>$planindustryList];
    }

    //点赞+1功能
    public function setStarCount($id)
    {
        $OrganizationsPlan = OrganizationsPlan::find($id);
        $OrganizationsPlan->star_count=$OrganizationsPlan->star_count+1;
        $OrganizationsPlan->save();
        return array('code' => 1000, 'msg' => '成功', 'data' => $OrganizationsPlan);
    }

    //浏览+1
    public function setBrowseCount($id)
    {
        $OrganizationsPlan = OrganizationsPlan::find($id);
        $OrganizationsPlan->browse_count=$OrganizationsPlan->browse_count+1;
        $OrganizationsPlan->save();
        return array('code' => 1000, 'msg' => '成功', 'data' => $OrganizationsPlan);
    }

    public  function  unitStatistics(){
        $data2 = DB::select ("select c.name,COUNT(a.id) as count from organizations_plan a
                    JOIN organizations b
                    on a.organization_id=b.id
                    JOIN units c
                    on b.unit_id=c.id
                    where a.isexcellent=1
                    GROUP BY c.name");
        return  $data2;
    }
}