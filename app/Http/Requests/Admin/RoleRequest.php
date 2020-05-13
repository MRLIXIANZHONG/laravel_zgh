<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class RoleRequest extends Request
{
    protected $rule = [
        'id'    =>  'required|integer',
        'slug' => 'required',
        'name' => 'required',
        'permissions_list'  => 'required'
    ];

    public function ruleGetPermission()
    {
        return $this->check(['id'], $this->rule);
    }

    public function ruleSave()
    {
        return $this->check(['id'], $this->rule);
    }

    public function messages()
    {
        return [
            'id.required'   =>  '必要参数未传递',
            'id.integer'    =>  '必要参数传递类型错误',
            'slug.required'    =>  '标识未填写',
            'name.required'    =>  '角色名称未填写',
            'permissions_list.required' =>  '请选择权限',
        ];
    }
}