<?php


namespace App\Services\Admin;


use App\DTO\PermissionsDTO;
use App\Exceptions\FailException;
use App\Models\AdminPermission;
use App\Services\Service;
use Mockery\Exception;

class PermissionsService extends Service
{
    public function savePermissionsData(PermissionsDTO $dto){
        $model=new AdminPermission();
        $model->name =$dto->getName();
        $model->slug = $dto->getSlug();
        $model->http_path =  $dto->getHttpPath();
        $model->parent_id = $dto->getParentId();
        $model->system_version = $dto->getSystemVersion();
        if($dto->getId()){
            $model->id = $dto->getId();
            $model->where('id','=',$model->id)->update([
                'name'=> $model->name,
                'slug'=> $model->slug,
                'http_path'=> $model->http_path,
                'parent_id'=> $model->parent_id,
                'system_version'=>$model->system_version
            ]);
        }else{
            $model->save();
        }


            $roles =$dto->getPermissionRoles();
            if (!empty($roles)) {
                foreach ($roles as $k => $role) {
                    if (empty($role)) unset($roles[$k]);
                }
            }
            $model->saveRoles($roles);

        return true;
    }


    public function PermissionsDel($id){
        $model=new AdminPermission();
        $model->id = $id;
        $model->exists = true;
        if($model->delete())return true;
        else return false;
    }
}