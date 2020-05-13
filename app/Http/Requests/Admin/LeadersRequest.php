<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class LeadersRequest extends Request
{

    protected $rule = [
        'source'    =>  'required|integer|between:1,3',
        'organization_id'   =>  'required|integer',
        'unit_id'   =>  'required|integer',
    ];

    public function ruleIndex()
    {
        //return $this->check(['source', 'organization_id'], $this->rule);
        return [];
    }

    public function ruleStore()
    {
        return [];
    }

    public function ruleUpdate()
    {
        return [];
    }

    public function ruleDestroy()
    {
        return [];
    }

    public function messages()
    {
        return [
            'source.required'   =>  '请填写新闻来源',
            'source.integer'    =>  '新闻来源必须是个数字',
            'source.between' =>  '新闻来源类型错误',
        ];
    }
}