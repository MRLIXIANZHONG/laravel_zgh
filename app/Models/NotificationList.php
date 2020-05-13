<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationList extends Model
{
    protected $table = 'notification_list';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function notifications()
    {
        return $this->hasMany(Notifications::class,'not_id','id');
    }

    public function read_notifications(){
        return $this->hasMany(Notifications::class,'not_id','id');
    }

    public function users()
    {
        return $this->belongsTo(AdminUsers::class,'admin_id');
    }
}