<?php


namespace App\Services;


use App\DTO\AdminRolesDTO;
use App\Models\AdminRoles;

class RoleService extends Service
{
    public function saveRoleData(AdminRolesDTO $adminRolesDTO){
        $adminRoles=new AdminRoles();
        $permissionsList= json_decode($adminRolesDTO->getPermissionsList(),true);

        if($adminRolesDTO->getId()>0) {
            $adminRoles->id=$adminRolesDTO->getId();
            $adminRoles->where('id', '=', $adminRoles->id)->update([
                'slug' => $adminRolesDTO->getSlug(),
                'name' => $adminRolesDTO->getName(),
                'system_version'=>$adminRolesDTO->getSystemVersion()
            ]);
        }else{
            $adminRoles_id= $adminRoles->insertGetId([
                'slug' => $adminRolesDTO->getSlug(),
                'name' => $adminRolesDTO->getName(),
                'system_version'=>$adminRolesDTO->getSystemVersion()
            ]);

            $adminRoles->id=$adminRoles_id;
        }
        $adminRoles->savePermissions($permissionsList);
        return true;

    }
    public function roleDel($id){

    }
}