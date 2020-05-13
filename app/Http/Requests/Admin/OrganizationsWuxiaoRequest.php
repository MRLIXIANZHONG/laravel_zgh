<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-11 下午 1:51
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class OrganizationsWuxiaoRequest extends Request
{
    protected $rule = [
        'organization_id' => 'required|integer',
        'type' => 'required|integer',
        'plan_name' => 'required|max:45',
        'summary' => 'required|max:500',
        'content' => 'required|max:2000',
        'img_url' => 'required',
        'video_url' => 'required',

    ];

    public function ruleStore()
    {
        return $this->check([
            'type',
            'plan_name',
            'summary',
            'content',
            'img_url',
            'video_url',
           ],
            $this->rule);
    }
    public function ruleUpdate()
    {
        return $this->check([
            'type',
            'plan_name',
            'summary',
            'content',
            'img_url',
            'video_url'],
            $this->rule);
    }
    public function messages()
    {
        return [
            'organization_id.required'   =>  '请填写参赛企业ID',
            'type.required'    =>  '请选择五小类型',
            'plan_name.required' =>  '请填写五小名称',
            'plan_name.max' =>  '五小名称最大长度为45',
            'summary.required' =>  '请填写五小概述',
            'summary.max' =>  '五小概述最大长度为500',
            'content.required' =>  '请填写五小内容',
            'content.max' =>  '五小内容最大长度为2000',
            'img_url.required' =>  '请填上传图片',
            'video_url.required' =>  '请填上传视频'
        ];
    }
}