<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 19:49
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class CompetitionRequest extends Request
{

    public function ruleIndex()
    {
        return [];

       // return $this->check(['source', 'organization_id'], $this->rule);

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
        return [];
    }
}