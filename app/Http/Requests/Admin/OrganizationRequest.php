<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 17:09
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;
use App\Models\Organization;

class OrganizationRequest extends Request
{
    protected $rule = [
        'name'  =>  'required|max:50',
        'photo' => 'required',
        'industry_tag' => 'required|array',
        'new_type'  =>  'required|integer',
        'username' => 'required|max:20',
        'mobile' => 'required|regex:/^[1][0-9]{10}$/',
        'unit_id' => 'integer|required',
        'password' => 'required|max:20',
        'repeat_password' => 'required|max:20',
        'staff_count' => 'required|integer',
        'farmer_count' => 'required|integer',
        //'industry' => 'integer|required',
        'account' => 'string|required|regex:/^[0-9]{15,20}$/',
        'bank_name' => 'string|required',
        'virtual_star'  => 'required|regex:/^[0-9]{1,10}$/',
        'virtual_browse'  => 'required|regex:/^[0-9]{1,10}$/',
    ];

//    public function ruleStore()
//    {
//        return $this->check(['name', 'new_type', 'username', 'mobile', 'photo', 'unit_id',
//             'account', 'bank_name', 'password'],
//            $this->rule);
//    }

    public function ruleUpdate()
    {
        return $this->check(['name', 'new_type', 'username', 'mobile', 'photo',
             'account', 'bank_name', 'staff_count', 'farmer_count'],
            $this->rule);
    }

    public function ruleSetPassword()
    {
        return $this->check(['password', 'repeat_password'],$this->rule);
    }

    public function ruleSetVirtual()
    {
        return $this->check(['virtual_star', 'virtual_browse'],$this->rule);
    }

    public function messages()
    {
        return [
            'new_type.integer' => '单位类型格式错误',
            'username.max'  =>  '姓名不能超过20个字符',
            'mobile.max'    =>  '手机号格式必须是11位的数字',
            'mobile.min'    =>  '手机号格式必须是11位的数字',
            'mobile.integer'    =>  '手机号格式必须是11位的数字',
            'unit_id.integer'   =>  '上级工会填写格式有误',
            'staff_count.integer'   =>  '员工总数必须为数字',
            'farmer_count.integer'  =>  '农民工数必须是数字',
            'password.required'  =>  '密码必须填写',
            'password.max'  =>  '密码不能超过20个字符',
            'repeat_password.required'  =>  '确认密码必须填写',
            'repeat_password.max'  =>  '确认密码不能超过20个字符',
            'virtual_star.required' => '请填写虚拟点赞量',
            'virtual_star.regex' => '虚拟点赞量必须是1-10位的数字',
            'virtual_browse.required' => '请填写虚拟浏览量',
            'virtual_browse.regex'  => '虚拟浏览量必须是1-10位的数字',
            'unit_id.required'  =>  '请填写上级工会',
            'account.required'  =>  '请填写银行卡账号',
            'account.regex'  =>  '银行卡号只能是15-20位的数字',
        ];
    }

}