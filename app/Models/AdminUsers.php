<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AdminUsers extends Model
{
    protected $table = 'admin_users';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function roles()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_role_users',
            'user_id','role_id');
    }

    public function organization(){

        return $this->belongsTo(Organization::class,'org_id','id');
    }

    public function unit(){

        return $this->belongsTo(Unit::class,'units_id','id');
    }

    /**
     * 保存角色
     *
     * @param mixed $roles
     */
    public function saveRoles($roles)
    {
        if (!empty($roles)) {
            $this->roles()->sync($roles);
        } else {
            $this->roles()->detach();
        }
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($user) {
            if (!method_exists(self::class, 'bootSoftDeletes')) {
                $user->roles()->sync([]);
            }

            return true;
        });
    }

}