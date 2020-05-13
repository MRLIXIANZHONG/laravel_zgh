<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/10
 * Time: 15:39
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class UnitRequest extends Request
{
    protected $rule = [
        'type'  =>  'required|max:10|integer',
        'name'  =>  'required|max:20',
        'password' => 'required|max:20',
        'mobile' => 'required|regex:/^[1][0-9]{10}$/',
        'username' => 'required|max:20',
        'repeat_password' => 'required|max:20',
        'virtual_browse' => 'required|regex:/^[0-9]{1,10}$/',
        'virtual_star' => 'required|regex:/^[0-9]{1,10}$/',
        'share_title'  => 'nullable|max:20',
    ];

    public function ruleStore()
    {
        return $this->check(['type', 'name', 'password', 'username', 'mobile', 'share_title'],
            $this->rule);
    }

    public function ruleUpdate()
    {
        return $this->check(['type', 'name', 'username', 'mobile'],
            $this->rule);
    }

    public function ruleSetPassword()
    {
        return $this->check(['password', 'repeat_password'],
            $this->rule);
    }

    public function ruleSetVirtual()
    {
        return $this->check(['virtual_browse', 'virtual_star'],
            $this->rule);
    }

    public function messages()
    {
        return [
            'type.required' =>  '工会类型格式错误',
            'type.integer'  =>  '请填写工会类型',
            'name.required' =>  '请填写工会名称',
            'name.max'      =>  '公会名称不能超过20个字符',
            'mobile.required' => '请填写手机号码',
            'mobile.regex'  =>  '手机号码格式错误',
            'username.required'  => '请填写联系人姓名',
            'username.max'  =>  '联系人姓名不能超过20个字符',
            'password.required'      =>  '请填写密码',
            'password.max'      =>  '密码不能超过20个字符',
            'repeat_password.required' => '请确认密码',
            'repeat_password.max' => '确认密码不能超过20个字符',
            'virtual_browse.required'  =>   '请填写虚拟流量',
            'virtual_browse.regex'  =>   '虚拟流量格式错误',
            'virtual_star.required'  =>   '请填写虚拟点赞',
            'virtual_star.regex'  =>   '虚拟点赞格式错误',
            'share_title.max'     =>   '分享标题不能超过20个字符',
        ];
    }
}