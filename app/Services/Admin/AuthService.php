<?php


namespace App\Services\Admin;


use App\DTO\AdminUsersDTO;
use App\Models\AdminLog;
use App\Models\AdminRoles;
use App\Models\AdminUsers as AdminUserModle;
use App\Models\Organization;
use App\Services\Service;

class AuthService extends Service
{
   public function authLogin(AdminUsersDTO $adminUsersDTO)
   {
       $adminUsersModle = new AdminUserModle();
       $adminUsersInfo = $adminUsersModle->with('roles')->where('username', '=', $adminUsersDTO->getUsername())->first();
       if (empty($adminUsersInfo)) {
           return [
               "code" => -1,
               "msg" => '用户名和密码错误'
           ];
       }

       //$md5password= md5(env('PASSWORD_SALE').$adminUsersDTO->getPassword());

       // if(!empty($adminUsersInfo->units_id)||!empty($adminUsersInfo->jun_id)){
       $md5password = md5($adminUsersDTO->getPassword() . env('JWT_KEY'));
       // }
       if (env('ISCREAT_PASSWORD') == 1 && empty($adminUsersInfo->password)) {

           $adminUsersModle->where('username', '=', $adminUsersDTO->getUsername())->update([
               'password' => $md5password
           ]);
       } else {
           if ($adminUsersInfo->password != $md5password) {
               return [
                   "code" => -1,
                   "msg" => '用户名和密码错误'
               ];
           }

       }
       try {
           $adminUser = new AdminUserModle();
           $adminUser->id = $adminUsersInfo['id'];
           $adminUsersData = $adminUser->roles()->get()->toArray();
           $adminUsersInfo['role_id'] = $adminUsersData[0]['id'];
           $adminUsersInfo['role_name'] = $adminUsersData[0]['name'];
           $adminUsersInfo['role_slug'] = $adminUsersData[0]['slug'];
           $adminUsersInfo['system_version'] = $adminUsersData[0]['system_version'];
           $adminUsersInfo['login_ip'] = request()->ip();
           AdminLog::addAdminLog($adminUser->id, $adminUsersInfo['login_ip'], $adminUsersInfo['name'] . '(' . $adminUsersInfo['role_name'] . ')登陆成功', 'login');

        return [
            "code" => 1000,
            "data" => $adminUsersInfo,
            "msg" => "登录成功"
        ];
        }catch(\Exception $exception){
           return [
               "code" => -1,
               "msg" => '未知错误！请联系后台总控管理员'
           ];
        }

   }

    /**
     * 缓存权限
     * @param $id
     */
   public function authRedisPermissions($id){
       $adminRoles=new AdminRoles();
       $adminUser=new AdminUserModle();
       $adminUser->id=$id;
       $adminRoles->id=$adminUser->roles()->get()->toArray()[0]['id'];
       $adminRoles->cachedPermissions();
   }


   public function getOTO(){
     return Organization::query()->get()->toArray();
   }



}