<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 下午 1:23
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class NomineesRequest extends Request
{
    protected $rule = [
        'staff_name' => 'required',
        'staff_phone' => 'required',
        'bank_card' => 'required',
        'bank_name' => 'required',
        'bank_staff_name' => 'required',
        'unit_id' => 'required|integer',
        'organization_id' => 'required',
        'kind' => 'required|integer',
        'caption' => 'required'
    ];

    public function ruleStore()
    {
        return $this->check(['staff_name', 'staff_phone', 'bank_card', 'bank_name', 'bank_staff_name', 'unit_id', 'organization_id', 'kind', 'caption'],
            $this->rule);
    }
    public function ruleUpdate()
    {
        return $this->check(['staff_name', 'staff_phone', 'bank_card', 'bank_name', 'bank_staff_name', 'unit_id', 'organization_id', 'kind', 'caption'],
            $this->rule);
    }
    public function messages()
    {
        return [
            'staff_name.required'   =>  '请填写参赛员工姓名',
            'staff_phone.required'    =>  '请填写参赛员工电话',
            'bank_card.required' =>  '请填写银行卡号',
            'bank_name.required' =>  '请填写开户行姓名',
            'bank_staff_name.required' =>  '请填写开户行人姓名',
            'unit_id.required' =>  '请填写选择工会',
            'organization_id.required' =>  '请填写选择企业',
            'kind.required' =>  '请填写选择推荐类型',
            'caption.required' =>  '请填写选择推荐理由',
        ];
    }
}