<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 19:49
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class RloudLiveRequest extends Request
{

    public function ruleIndex()
    {
        return [];
        return [
            'source' => 'required|integer|between:1,3',
            'organization_id' => 'required|integer',
            'unit_id' => 'required|integer',
        ];
       // return $this->check(['source', 'organization_id'], $this->rule);

    }

    public function ruleStore()
    {
        return [];
    }

    public function ruleUpdate()
    {
        return [];
        return $this->check(['id'], $this->rule);
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
            'source.in_array:1,2,3' =>  '新闻来源类型错误',
        ];
    }
}