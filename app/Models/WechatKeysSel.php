<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WechatKeysSel extends Model
{
    protected $table = 'wx_keys_sel';

    protected $primaryKey = 'id';

    public function reply(){

        return $this->belongsTo(WechatReply::class,'kid','id');

    }

}