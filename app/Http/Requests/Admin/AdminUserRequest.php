<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class AdminUserRequest extends Request
{
    protected $rule = [
        'id'    =>  'required|integer',
        'name' => 'required',
        'username'=>'required',
        'role_id'=> 'required|integer',
    ];

    public function ruleSave()
    {
        return $this->check(['id','name','username','role_id'], $this->rule);
    }

    public function messages()
    {
        return [
            'id.required'   =>  '必要参数未传递',
            'id.integer'    =>  '必要参数传递类型错误',
            'name.required'    =>  '昵称未填写',
            'username.required'    =>  '用户名未填写',
            'role_id.required'   =>  '请选择角色',
            'role_id.integer'    =>  '请选择角色',
        ];
    }
}