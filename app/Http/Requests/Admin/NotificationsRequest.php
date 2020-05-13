<?php


namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class NotificationsRequest extends Request
{
    protected $rule = [
        'title' => 'required',
        'content' => 'required',
        'toarray' => 'required',
    ];

    public function ruleSave()
    {
        return $this->check(['title','content'], $this->rule);
    }

    public function messages()
    {
        return [
            'title.required'   =>  '请传入标题',
            'content.required'    =>  '请输入内容',
        ];
    }
}