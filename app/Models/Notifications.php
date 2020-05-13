<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
//    use SoftDeletes;

    protected $table = 'notifications';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function notificationList()
    {
        return $this->belongsTo(NotificationList::class,'not_id');
    }

    public function users()
    {
        return $this->belongsTo(AdminUsers::class,'admin_id');
    }

    public function busers()
    {
        return $this->belongsTo(AdminUsers::class,'notifiable_id');
    }


    public function organizations()
    {
        return $this->belongsTo(Organization::class,'notifiable_id');
    }

}