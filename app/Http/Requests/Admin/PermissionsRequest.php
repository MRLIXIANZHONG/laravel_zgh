<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class PermissionsRequest extends Request
{
    protected $rule = [
        'id'    =>  'required|integer',
        'slug' => 'required',
        'name' => 'required',
        'http_path'=> 'required',
    ];

    public function ruleSave()
    {
        return $this->check(['id','slug','name','http_path'], $this->rule);
    }


    public function messages()
    {
        return [
            'id.required'   =>  '必要参数未传递',
            'id.integer'    =>  '必要参数传递类型错误',
            'slug.required'    =>  '标识未填写',
            'name.required'    =>  '权限名称未填写',
            'http_path.required' =>  '权限控制未填写',
        ];
    }
}