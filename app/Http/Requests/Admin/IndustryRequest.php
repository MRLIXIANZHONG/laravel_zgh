<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/8
 * Time: 15:24
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class IndustryRequest extends Request
{
    protected $rule = [
        'industry_name'  =>  'required|max:30',
        'description'    =>  'nullable|max:500',
    ];

    public function ruleStore()
    {
        return $this->check(['industry_name', 'description'], $this->rule);
    }

    public function ruleUpdate()
    {
        return $this->check(['industry_name', 'description'], $this->rule);
    }
}