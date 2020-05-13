<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/11
 * Time: 18:18
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class CraftsmanRequest extends Request
{
    protected $rule = [
        'username'  =>  'required|max:20',
        'mobile'    =>  'required|regex:/^[1][0-9]{10}$/',
        'unit_name' =>  'required|string|max:20',
        'bank_card' =>  'required|regex:/[0-9]{15,20}/',
        'bank_username' =>  'required|string|max:20',
        'bank_name' =>  'required|string|max:20',
        'from'      =>  'required|integer|max:50',
        'years'     =>  'required|integer|max:2019|min:2016',
        'photo'     =>  'required|string',
        'bank_photo' => 'required|string',
        'is_party_member' => 'required|integer',
        'virtual_star'  => 'required|regex:/^[0-9]{1,10}$/',
        'virtual_browse'  => 'required|regex:/^[0-9]{1,10}$/',
        'score'  =>  'required|regex:/^[0-9]{1,9}$/',
        'honor_name' => 'required|max:20',
        'honor_description' => 'required|max:460',
        'honor_time'  => 'required',
        'honor_image'  =>   'required|max:500',
    ];

    public function ruleStore()
    {
        return $this->check(['username', 'mobile', 'unit_name', 'years', 'photo'], $this->rule);
    }

    public function ruleUpdate()
    {
        return $this->check(['username', 'mobile', 'unit_name', 'years', 'photo'], $this->rule);
    }

    public function ruleStoreCraftsman()
    {
        return $this->check(['username', 'mobile', 'unit_name', 'photo', 'bank_photo', 'is_party_member',
            'bank_card', 'bank_username', 'bank_name'], $this->rule);
    }

    public function ruleUpdateCraftsman()
    {
        return $this->check(['username', 'mobile', 'unit_name', 'photo', 'bank_photo', 'is_party_member',
            'bank_card', 'bank_username', 'bank_name'], $this->rule);
    }

    public function ruleIsCraftsmanUpdate()
    {
        return $this->check(['username', 'mobile', 'unit_name', 'photo', 'bank_photo', 'is_party_member',
            'bank_card', 'bank_username', 'bank_name'], $this->rule);
    }

    public function ruleSetVirtual()
    {
        return $this->check(['virtual_star', 'virtual_browse'], $this->rule);
    }

    public function ruleExpertScore()
    {
        return $this->check(['score'], $this->rule);
    }

    public function ruleStoreCraftsmanHonor()
    {
        return $this->check(['honor_name','honor_description','honor_time','honor_image'], $this->rule);
    }

    public function messages()
    {
        return [
            'username.required'  =>  '请填写姓名',
            'username.max'  =>  '姓名不能超过20个字符',
            'mobile.required'  =>  '请填写手机号',
            'mobile.regex'  =>  '手机号格式错误',
            'unit_name.required' =>  '请填写职业',
            'unit_name.max' =>  '职业最大不能超过20个字符',
            'years.required'  =>  '请填写获奖年份',
            'years.integer'  =>  '获奖年份格式错误',
            'years.max'  =>  '获奖年份格式错误',
            'years.min'  =>  '获奖年份格式错误',
            'photo.required' => '请上传照片',
            'photo.string'  => '图片格式有误',
            'bank_card.required' => '请填写银行卡号',
            'bank_card.regex'  => '银行卡号只能是15-20位',
            'bank_username.required' => '请填写开户名',
            'bank_username.max'  => '开户名最大不能超过20个字符',
            'bank_name.required' => '请填写开户行',
            'bank_name.max' => '开户行最大不能超过20个字符',
            'bank_photo.required' => '请上传银行卡照片',
            'bank_photo.string' => '银行卡照片格式有误',
            'is_party_member.required' => '请选择是否是党员',
            'virtual_star.required' => '请填写虚拟点赞量',
            'virtual_star.regex' => '虚拟点赞量格式有误',
            'virtual_browse.required' => '请填写虚拟游览量',
            'virtual_browse.regex' => '虚拟浏览量格式有误',
            'score.required'    =>  '投票数不能为空',
            'score.regex'   =>  '投票数格式错误',
            'honor_name.required' => '请填写荣誉标题',
            'honor_name.max' => '荣誉标题不能超过20个字符',
            'honor_description.required' => '请填写荣誉描述',
            'honor_description.max' => '荣誉描述最大不能超过460个字符',
            'honor_time.required' => '请填写获得荣誉的时间',
            'honor_image.required' => '请上传荣誉图集',
            'honor_image.max' => '上传图片超过最大限制',
        ];
    }
}