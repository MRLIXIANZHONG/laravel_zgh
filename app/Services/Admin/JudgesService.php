<?php


namespace App\Services\Admin;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\AdminUsersDTO;
use App\DTO\JudgesDTO;
use App\Models\AdminRoles;
use App\Models\AdminUsers;
use App\Models\Judges;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class JudgesService  extends Service
{
    public function getList(JudgesDTO $JudgesDTO)
    {
        $builder = Judges::query();
        $JudgesDTO->getId() && $builder->where('id',  $JudgesDTO->getId());
        $JudgesDTO->getIsrecommend() && $builder->where('isrecommend',  $JudgesDTO->getIsrecommend());
        $JudgesDTO->getIndustry() && $builder->where('industry',  $JudgesDTO->getIndustry());
        $JudgesDTO->getName() && $builder->where('name', 'like', '%' . $JudgesDTO->getName() . '%');
        $JudgesDTO->getKind() && $builder->where('kind', '=',   $JudgesDTO->getKind());
        if($JudgesDTO->getPageSize()==-1)
            return  $builder->get();
        return $builder->paginate(15);
    }

    public function checkJudgesAssign($judgesAssignID)
    {
        $Judges=DB::select("
            select * from judges where id not in (select judge_id from judge_judgesAssign where judgesAssign_id =".$judgesAssignID.")
        ");
        return $Judges;
    }

    public function show($judgesId){
        $Judges =Judges::find($judgesId);
        return $Judges;
    }

    public function store(JudgesDTO $dto){
        $checkbuilder1=  Judges::query();
        $checkbuilder1->where('phone',$dto->getPhone());
        $checkJudges1=$checkbuilder1->get()->first();
        if(!empty($checkJudges1))
            return '{"code":1001,"msg":"账户已存在"}';

        $checkbuilder2=  AdminUsers::query();
        $checkbuilder2->where('username',$dto->getPhone());
        $checkJudges2=$checkbuilder2->first();
        if(!empty($checkJudges2))
            return '{"code":1001,"msg":"账户已存在"}';

        $Judges = new Judges;
        $Judges->name = $dto->getName();
        $Judges->department = $dto->getDepartment();
        $Judges->phone = $dto->getPhone();
        $Judges->kind = $dto->getKind();
        $Judges->industry = $dto->getIndustry();
        $Judges->skill = $dto->getSkill();
        $Judges->photo = $dto->getPhoto();
        $Judges->password = $dto->getPassword();
        $Judges->share_img_url = $dto->getShareImgUrl();
        $Judges->share_content = $dto->getShareContent();
        $Judges->share_title = $dto->getShareTitle();
        $dto->getLastSendTime() && $Judges->lastSend_time = $dto->getLastSendTime();
        $Judges->speciality =$dto->getSpeciality();
        $Judges->system_version = 'cqzgh';
        $Judges->isrecommend = 0;
        $Judges->check_state = 0;
        $Judges->save();

        try{
            $user =new AdminUsersDTO([]);
            $user->setName($Judges->name);
            $user->setUsername($Judges->phone);
            $user->setPassword($Judges->password);
            $user->setJunId($Judges->id);
//            $AdminRoles = ServiceHelper::make('Admin\AdminRolesService')->checkRolesSlug('jundges');
            //添加用户
            $builder = AdminRoles::query();
            $role = $builder->where('slug','jundges')->first();
            $user->setRoleId($role->id);
            $user->setSystemVersion('cqzgh');
            $state = ServiceHelper::make('Admin\AdminUserService')->saveAdminUsersInfo($user);
            if(!$state)    {
                $Judges->delete();
                return '{"code":1001,"msg":"插入失败"}';
            }
             else{
                 return '{"code":1000,"msg":"成功"}';
             }
        }
        catch (\Exception $e) {
            $Judges->delete();
            return '{"code":1001,"msg":"插入失败"}';
        }
    }

    public function update(JudgesDTO $dto)
    {
        $state= $dto->getCheckState();
        $Judges = Judges::find($dto->getId());
        $dto->getName() &&  $Judges->name = $dto->getName();
        $dto->getDepartment() &&   $Judges->department = $dto->getDepartment();
        $dto->getPhone() &&   $Judges->phone = $dto->getPhone();
        $dto->getKind() &&   $Judges->kind = $dto->getKind();
        $dto->getIndustry() &&   $Judges->industry = $dto->getIndustry();
        $dto->getSkill() &&   $Judges->skill = $dto->getSkill();
        $dto->getPhoto() &&   $Judges->photo = $dto->getPhoto();
        $dto->getVideoUrl() &&   $Judges->video_url = $dto->getVideoUrl();
        $dto->getPassword() &&    $Judges->password = $dto->getPassword();
        $dto->getLastSendTime() && $Judges->lastSend_time = $dto->getLastSendTime();
        $dto->getSpeciality() && $Judges->speciality =$dto->getSpeciality();
        $dto->getShareImgUrl() && $Judges->share_img_url = $dto->getShareImgUrl();
        $dto->getShareContent() && $Judges->share_content = $dto->getShareContent();
        $dto->getShareTitle() && $Judges->share_title = $dto->getShareTitle();
        $dto->getNopassinfo() && $Judges->nopassinfo =$dto->getNopassinfo();
        if(isset($state)) {
            $Judges->check_state = $dto->getCheckState();
        }

        if(!empty($dto->getPassword())||!empty($dto->getphone())){
            try{
            DB::transaction(function () use ($Judges) {
                $adminUsers =  AdminUsers::query() ;
                $AdminUsers=$adminUsers->where('jun_id','=',$Judges->id)->first();
                 if(empty($AdminUsers)){
                     $user =new AdminUsersDTO([]);
                     $user->setName($Judges->name);
                     $user->setUsername($Judges->phone);
                     $user->setPassword($Judges->password);
                     $user->setJunId($Judges->id);
//                     $AdminRoles = ServiceHelper::make('Admin\AdminRolesService')->checkRolesSlug('jundges');
                     //添加用户
                     $builder = AdminRoles::query();
                     $role = $builder->where('slug','jundges')->first();
                     $user->setRoleId($role->id);
                     $user->setSystemVersion('cqzgh');
                     $state = ServiceHelper::make('Admin\AdminUserService')->saveAdminUsersInfo($user);
                     $Judges->save();
                     if($state)
                         return '{"code":1000,"msg":"成功"}';
                     else
                         return '{"code":1001,"msg":"存入失败,系统出错"}';
                 }
                 else{
                     $user =new AdminUsersDTO([]);
                     $Judges->password && $AdminUsers->password =md5($Judges->password.env('JWT_KEY'));
                     $Judges->save();
                     $AdminUsers->save();
                 }
            });
                return '{"code":1000,"msg":"成功"}';
            }
            catch(\Exception $e) {
                return '{"code":1001,"msg":"存入失败,系统出错"}';
            }
        }
        else{
            $Judges->save();
            if($state==2)
                return '{"code":2000,"msg":"成功"}';
            return '{"code":1000,"msg":"成功"}';
        }
    }

    public function  updateList($array){
        DB::update(" update judges set check_state=".$array[0]['check_state']."  where id in (".$array[0]['id'].")");
        return '{"code":1000,"msg":"成功"}';
    }

    public function destroy($request)
    {
        $Judges = Judges::find($request->id);

        $Judges->delete();

        return '{"code":1000,"msg":"成功"}';
    }

    public function updateRecommend($request){
        if(!empty($request->isrecommend)){
            $listisrecommend= explode(",",$request->isrecommend);
            $idStr='';
            for ($i=0; $i<=count($listisrecommend)-1; $i++)
            {
                if(count($listisrecommend)-1===$i)
                    $idStr=$idStr.'?';
                else
                    $idStr=$idStr.'?'.',';
            }
            $affected = DB::update('update judges set isrecommend = 1 where id in ('.$idStr.')',$listisrecommend);
        }
        if(!empty($request->notrecommend)){
            $listisrecommend= explode(",",$request->notrecommend);
            $idStr='';
            for ($i=0; $i<=count($listisrecommend)-1; $i++)
            {
                if(count($listisrecommend)-1===$i)
                    $idStr=$idStr.'?';
                else
                    $idStr=$idStr.'?'.',';
            }
            $affected = DB::update('update judges set isrecommend = 0 where id in ('.$idStr.')', $listisrecommend);
        }
        return '{"code":1000,"msg":"成功"}';
    }

    public function checkJudgesScore($judgesId){
        $judgesScore=DB::select("
             SELECT count(c.type) as count,c.type  from judge_judgesAssign a
                JOIN JudgesAssign b
                on a.judgesAssign_id =b.id
                JOIN case_schemes c
                on c.id=b.case_schemes_id
                where a.judge_id=".$judgesId."
                GROUP BY c.type
        ");
        return $judgesScore;
    }

    public function getScoreList($array){
        switch ($array[0])
        {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $scores=DB:: select("SELECT d.id as userid,d.staff_name as username,c.title as title,c.id as caseSchemesid ,e.score as score from judge_judgesAssign a
                    JOIN JudgesAssign b
                    on a.judgesAssign_id =b.id
                    JOIN case_schemes c
                    on c.id=b.case_schemes_id
                    JOIN nominees d
                    on d.case_scheme_id=c.id
                    left join judges_score e
					on e.score_type_id=d.id
                    where a.judge_id=".$array[1]." and c.type=".$array[0]);
                return  $scores;
            default:
                $scores=DB:: select("SELECT d.id as userid,d.plan_name as username,c.title as title,c.id as caseSchemesid ,e.score as score from judge_judgesAssign a
                    JOIN JudgesAssign b
                    on a.judgesAssign_id =b.id
                    JOIN case_schemes c
                    on c.id=b.case_schemes_id
                    JOIN organizations_plan d
                    on d.case_scheme_id=c.id
                    left join judges_score e
					on e.score_type_id=d.id
                    where a.judge_id=".$array[1]." and c.type=".$array[0]);
                return   $scores;
        }
    }
}