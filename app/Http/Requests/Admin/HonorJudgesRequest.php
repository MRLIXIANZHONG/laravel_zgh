<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class HonorJudgesRequest extends Request
{
    protected $rule = [
        'source'    =>  'required|integer|between:1,3',
        'organization_id'   =>  'required|integer',
        'unit_id'   =>  'required|integer',
    ];

}