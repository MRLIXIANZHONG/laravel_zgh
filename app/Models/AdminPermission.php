<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $table = 'admin_permissions';

    protected $fillable = [];

    protected $primaryKey = 'id';

    /**
     * 与角色的多对多关系.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_role_permissions',
           'permission_id', 'role_id');
    }

    public static function toTree($info=[]){
        $permission = AdminPermission::get()->toArray();
        $permarr=[];
        foreach ($permission as $pkey=>$pitem){
            $permission[$pkey]['checked']=false;
            if($info){
                foreach($info->perms as $perm)
                    if($perm->id==$pitem['id']){
                        $permission[$pkey]['checked']=true;
                    }
            }
            array_push($permarr,[
                'title'=>$permission[$pkey]['name'],
                'id'=>$permission[$pkey]['id'],
                'checked'=>$permission[$pkey]['checked'],
                'parent_id'=>$permission[$pkey]['parent_id'],
                'http_path'=>$permission[$pkey]['http_path'],
                'slug'=>$permission[$pkey]['slug']
            ]);
        }

        foreach ($permarr as $pekey =>$peitem){
            $permarr[$pekey]['children']=[];
            $permarr[$pekey]['spread']=true;
            foreach ($permarr as $pekey2 =>$peitem2){
                if($peitem2['parent_id']==$peitem['id']){
                    $permarr[$pekey]['children'][]=$peitem2;

                }
            }
        }

        $newpermarr=[];
        foreach ($permarr as $pekey2 =>$peitem2){
            if(empty($peitem2['parent_id'])){
                array_push($newpermarr,$peitem2);
            }

        }

        return $newpermarr;
    }


    public function roleToIds()
    {
        $roles =$this->roles;
        $ids = [];
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                if (is_object($role)) {
                    $ids[] = $role->id;
                } else if (is_array($role) && isset ($role['id'])) {
                    $ids[] = $role['id'];
                }
            }
        }
        return $ids;
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function($permission) {
            if (!method_exists(self::class, 'bootSoftDeletes')) {
                $permission->roles()->sync([]);
            }
            return true;
        });
    }


    /**
     * 保存角色
     * @param $roles
     * @return mixed
     */
    public function saveRoles($roles)
    {
        if (!empty($roles)) {
            $this->roles()->sync($roles);
        } else {
            $this->roles()->detach();
        }
    }

}