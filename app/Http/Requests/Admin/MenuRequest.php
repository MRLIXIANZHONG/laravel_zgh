<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class MenuRequest extends Request
{
    protected $rule = [
        'id'    =>  'required|integer',
        'order'   =>  'integer|min:0',
        'title'   =>  'required',
        'parent_id'   =>  'required|integer|min:0',
        'roles'   =>  'required'
    ];

    public function ruleChangeSort()
    {
        return $this->check(['id', 'order'], $this->rule);
    }

    public function saveSort()
    {
        return $this->check(['id', 'order','title','parent_id','roles'], $this->rule);
    }

    public function messages()
    {
        return [
            'id.required'   =>  '必要参数未传递',
            'id.integer'    =>  '必要参数传递类型错误',
            'order.integer' =>  '请传递整数排序',
            'order.min' =>  '排序不能小于0',
            'title.required' =>  '请上传菜单名',
            'parent_id.required' =>  '请上传上级所属菜单',
            'parent_id.integer' =>  '上级所属菜单格式不对',
            'parent_id.min' =>  '上级所属菜单格式不对！',
            'roles'=> '请选择对应授权角色'
        ];
    }
}