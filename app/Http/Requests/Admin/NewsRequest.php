<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 19:49
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class NewsRequest extends Request
{

    private $rule = [
        'source' => 'required|integer|between:1,3',
        'title' => 'required|max:500',
        'abstract' => 'required|max:2000',
        'virtual_traffic'=>'max:99999999'
    ];

    public function ruleIndex()
    {
        return [];
        // return $this->check(['source', 'organization_id'], $this->rule);

    }

    public function ruleStore()
    {
        return $this->check(['title','source','abstract','virtual_traffic'], $this->rule);

    }

    public function ruleUpdate()
    {
        return $this->check(['title','source','abstract','virtual_traffic'], $this->rule);
    }

    public function ruleDestroy()
    {
        return [];
    }

    public function messages()
    {
        return [
            'title.required' => '新闻标题必填',
            'title.max' => '新闻标题最大长度500',
            'abstract.required' => '新闻摘要必填',
            'abstract.max' => '新闻摘要最大长度2000',
            'source.required' => '新闻来源必填',
            'source.between' => '新闻来源类型错误',
            'virtual_traffic.max' => '虚拟浏览量最大值为99999999'
        ];
    }
}