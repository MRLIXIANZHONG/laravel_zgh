<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 下午 3:34
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class CaseSchemesRequest extends Request
{


    protected $rule = [
        'title' => 'required',
        'code' => 'required',
        'type' => 'required',
        'sort' => 'required'
    ];

    public function ruleInsert()
    {
        return $this->check(['title', 'code','type','sort'], $this->rule);
    }
    public function messages()
    {
        return [
            'title.required'   =>  '请填写节点标题',
            'code.required'    =>  '请填写节点代码',
            'type.required' =>  '请填写节点类型',
            'sort.required' =>  '请填写序号',
        ];
    }
}