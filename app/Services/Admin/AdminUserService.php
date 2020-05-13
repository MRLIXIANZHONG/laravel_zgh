<?php


namespace App\Services\Admin;


use App\DTO\AdminUsersDTO;
use App\Exceptions\FailException;
use App\Models\AdminRoles;
use App\Models\AdminUsers;
use App\Models\Organization;
use App\Models\Unit;
use App\Services\Service;

class AdminUserService extends Service
{
    public function getAdminUsers(){
        return AdminUsers::with('roles')->with('organization')->with('unit')->paginate(15);
    }

    public function getAdminUsersAll(){
        return AdminUsers::with('roles')->with('organization')->with('unit')->get()->toArray();
    }

    public function getAdminUsersInfo($id){
        $info = $id ? AdminUsers::with('roles')->with('organization')->with('unit')->find($id) : [];
        return $info;

    }

    /**
     * 添加/修改后台用户
     * @author by wcj
     * @param AdminUsersDTO $dto
     * @return bool
     * @throws FailException
     */
    public function saveAdminUsersInfo(AdminUsersDTO $dto){
        $adminUsersmodel=new AdminUsers();
        $adminUsersmodel->username = $dto->getUsername();


        $adminUsersmodel->name = $dto->getName();
        $adminUsersmodel->system_version=$dto->getSystemVersion();
        $mobile = !empty($dto->getMobile()) ? $dto->getMobile() :'';

        $adminRolesmodel=new AdminRoles();
        $adminRolesData=$adminRolesmodel->find($dto->getRoleId());

        $organizationmodel=new Organization();
        $unitmodel=new Unit();
        $is_org_slug=0;
        if($adminRolesData->slug=='administrator'||$adminRolesData->slug=='adminunion'){

            //if($dto->getPassword())$adminUsersmodel->password = md5(env('PASSWORD_SALE').$dto->getPassword());
        }else{
            $is_org_slug=1;

        }

        if($dto->getPassword())$adminUsersmodel->password = md5($dto->getPassword().env('JWT_KEY'));

        if($dto->getId()){   //修改
            $adminUsersmodel->exists = true;
            $adminUsersmodel->id = $dto->getId();
            $is_userbyid=$adminUsersmodel->where('id','=',$adminUsersmodel->id)->get();
            $is_userbyid=json_decode($is_userbyid,true);

            if(!$is_userbyid){
                throw new FailException([
                    'message'=>'用户已不存在'
                ]);
            }
            if($adminRolesData->slug!='administrator'&&$is_org_slug==0) {

                if ($adminRolesData->slug == 'enterprise')   //企业
                {
                    $is_org = $organizationmodel::query()->where("id", '<>', $is_userbyid[0]['org_id'])->where('username', '=', $dto->getUsername())->first();

                    if ($is_org) {
                        throw new FailException([
                            'message' => '企业账户已存在'
                        ]);
                    }

                    $is_org_mobile=$organizationmodel::query()->where("id", '<>', $is_userbyid[0]['org_id'])->where('mobile','=',$mobile)->first();
                    if($is_org_mobile){
                        throw new FailException([
                            'message'=>'手机号已存在'
                        ]);
                    }
                    $organizationmodel::query()->where("id", '=', $is_userbyid[0]['org_id'])->update([
                        'username'=>$dto->getUsername(),
                        'mobile'=>$mobile,
                        'name'=>$dto->getName()
                    ]);

                }

                if($adminRolesData->slug=='union')   //工会
                {
                    $is_unit=$unitmodel::query()->where("id", '!=', $is_userbyid[0]['units_id'])->where('username','=',$dto->getUsername())->first();
                    if($is_unit){
                        throw new FailException([
                            'message'=>'工会账户已不存在'
                        ]);
                    }

                    $is_unit_mobile=$unitmodel::query()->where("id", '!=', $is_userbyid[0]['units_id'])->where('mobile','=',$mobile)->first();
                    if($is_unit_mobile){
                        throw new FailException([
                            'message'=>'手机号已存在'
                        ]);
                    }

                    $unitmodel::query()->where("id", '=', $is_userbyid[0]['units_id'])->update([
                        'username'=>$dto->getUsername(),
                        'mobile'=>$mobile,
                        'name'=>$dto->getName()
                    ]);
                }
            }

        }else{  //新增

           if(!$dto->getPassword()){
               throw new FailException([
                   'message'=>'请输入密码'
               ]);
           }
            $is_user=$adminUsersmodel::query()->where('username','=',$adminUsersmodel->username)->first();
            if($is_user){
                throw new FailException([
                    'message'=>'用户已存在'
                ]);
            }


            if($adminRolesData->slug!='administrator' && $is_org_slug==0){

                if($adminRolesData->slug=='enterprise')   //企业
                {

                    $is_org=$organizationmodel::query()->where('username','=',$dto->getUsername())->first();
                    if($is_org){
                        throw new FailException([
                            'message'=>'企业账户已存在'
                        ]);
                    }
                    $is_org_mobile=$organizationmodel::query()->where('mobile','=',$mobile)->first();
                    if($is_org_mobile){
                        throw new FailException([
                            'message'=>'手机号已存在'
                        ]);
                    }

                   $orid= $organizationmodel::query()->insertGetId([
                        'username'=>$dto->getUsername(),
                        'mobile'=>$mobile,
                        'name'=>$dto->getName(),
                       'system_version'=>$dto->getSystemVersion()
                    ]);

                    $adminUsersmodel->org_id=$orid;


                }

                if($adminRolesData->slug=='union')   //工会
                {

                    $is_unit=$unitmodel::query()->where('username','=',$dto->getUsername())->first();
                    if($is_unit){
                        throw new FailException([
                            'message'=>'工会账户已不存在'
                        ]);
                    }

                    $is_unit_mobile=$unitmodel::query()->where('mobile','=',$mobile)->first();
                    if($is_unit_mobile){
                        throw new FailException([
                            'message'=>'手机号已存在'
                        ]);
                    }

                    $unid= $unitmodel::query()->insertGetId([
                        'username'=>$dto->getUsername(),
                        'mobile'=>$mobile,
                        'name'=>$dto->getName(),
                        'system_version'=>$dto->getSystemVersion()
                    ]);

                    $adminUsersmodel->units_id=$unid;

                }

            }else{
                $adminUsersmodel->units_id=$dto->getUnitsId();
                $adminUsersmodel->org_id=$dto->getOrgId();
                $adminUsersmodel->jun_id=$dto->getJunId();
            }


        }
        try{
            if (!$adminUsersmodel->save()) {
                throw new FailException([
                    'message'=>'保存失败'
                ]);
            }
            $adminUsersmodel->saveRoles($dto->getRoleId());
        }catch (\Exception $e){
            throw new FailException([
                'message'=>'保存失败'
            ]);
        }



      return true;
    }




    public function AdminUserDel($id){
        $adminUsersmodel=new AdminUsers();
        $adminUsersmodel->id = $id;
        $adminUsersmodel->exists = true;
        if($adminUsersmodel->delete())return true;
    }
}