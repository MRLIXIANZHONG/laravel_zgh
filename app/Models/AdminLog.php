<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = 'admin_log';

    protected $fillable = [];

    protected $primaryKey = 'id';

    /**
     * 添加后台操作日志
     * @param $admin_id 后台用户
     * @param $ip 登陆ip
     * @param $info 操作内容信息
     * @return mixed
     */
    public static function addAdminLog($admin_id,$ip,$info,$type){

       $addid= static::insert([
            'admin_id'=>$admin_id,
            'log_ip'=>$ip,
            'log_info'=>$info,
            'log_time'=>time(),
            'type'=>$type
        ]);

       return $addid;

    }
}