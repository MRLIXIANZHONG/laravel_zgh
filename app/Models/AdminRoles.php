<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class AdminRoles extends Model
{
    protected $table = 'admin_roles';

    protected $fillable = [];

    protected $primaryKey = 'id';

    public function cachedPermissions()
    {
        $rolePrimaryKey = $this->primaryKey;

        $cacheKey = 'admin_permissions_for_role_'.$this->$rolePrimaryKey;

        Redis::set($cacheKey, $this->perms()->get()->toJson());

    }



    public function hasPermissions($permissions)
    {

        $rolePrimaryKey = $this->primaryKey;

        $cacheKey = 'admin_permissions_for_role_'.$this->$rolePrimaryKey;
        $hasPermissions= Redis::get($cacheKey);
        $hasPermissionsArry= json_decode($hasPermissions,true);
        
        if(!$hasPermissionsArry) {
            return redirect('admin/login');
        }

        foreach ($hasPermissionsArry as $key=>$value){
            if($value['http_path']=='*'){
                return true;
            }
            if($permissions==$value['http_path']){
                return true;
            }
        }
        return false;

    }


    /**
     * 与用户的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(AdminUsers::class, 'admin_role_user',
            'role_id','user_id');
    }


    /**
     * 与权限的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms()
    {
        return $this->belongsToMany(AdminPermission::class,'admin_role_permissions','role_id','permission_id');
    }

    /**
     * 与菜单的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(AdminMenu::class, 'admin_role_menu',
            'role_id', 'menu_id')->orderBy("order") ;

    }


    /**
     * 保存权限
     *
     * @param mixed $inputPermissions
     *
     * @return void
     */
    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions)) {
            $this->perms()->sync($inputPermissions);
        } else {
            $this->perms()->detach();
        }
    }

}