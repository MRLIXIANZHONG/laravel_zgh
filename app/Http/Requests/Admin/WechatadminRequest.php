<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class WechatadminRequest extends Request
{
    protected $rule = [
        'app_id'    =>  'required',
        'secret'   =>  'required',
        'token'   =>  'required',
        'kid' => 'required|integer',
        'akey' => 'required',
        'Pptype'=> 'required|integer',
        'title'=>'required',
        'msgkind' => 'required|integer',
        'msghide' => 'required|integer',
        'content' => 'required'
    ];

    public function ruleSave()
    {
        return $this->check(['app_id', 'secret','token'], $this->rule);
    }

    public function ruleKeysave()
    {
        return $this->check(['kid', 'akey','Pptype'], $this->rule);
    }

    public function ruleReplysave()
    {
        return $this->check(['title', 'msgkind','msghide','content'], $this->rule);
    }

    public function messages()
    {
        return [
            'app_id.required'   =>  'app_id不能为空',
            'secret.required' =>  'secret不能为空',
            'token.required' =>  'token不能为空',
            'kid.required'=> '请选择回复内容',
            'kid.integer'=> '请选择回复内容',
            'akey.required'=> '请填写关键字',
            'Pptype.required'=> '请选择查询类型',
            'Pptype.integer'=> '请选择查询类型',
            'title.required'=>'请填写回复标题',
            'msgkind.required' => '请选择回复内容类型',
            'msgkind.integer' => '请选择回复内容类型',
            'msghide.required' => '请选择回复内容状态',
            'msghide.integer' => '请选择回复内容状态',
            'content.required' => '请填写回复内容，或上传回复图片/视频/音频'
        ];
    }
}