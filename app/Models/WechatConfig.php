<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WechatConfig extends Model
{
    protected $table = 'wechat_config';
    public function getUpdatedAtColumn() {
        return null;
    }
}