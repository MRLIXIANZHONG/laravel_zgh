<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section('title', '专家修改')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/judges" class="layui-btn layui-btn-normal">返回</a>
    </div>
    <form class="layui-form tc-container">
        <div class="layui-form-item" style="display: none;">
            <div class="layui-input-block">
                <input type="hidden" value="{{!empty($Judgeses['id']) ? $Judgeses['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专家姓名：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$Judgeses['name']}}" name="name" readonly autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属单位：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$Judgeses['department']}}" name="department" readonly autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专家电话：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$Judgeses['phone']}}" name="phone" readonly autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">评委类别：</label>
            <div class="layui-input-block">
                <input type="radio" name="kind" title="专家" value="1" @if($Judgeses['kind']===1)checked @endif/>
                <input type="radio" name="kind" title="劳模" value="2" @if($Judgeses['kind']===2)checked @endif/>
                <input type="radio" name="kind" title="媒体" value="3" @if($Judgeses['kind']===3)checked @endif/>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">行业类型：</label>
            <div class="layui-input-block">
                @foreach($industry as $item)
                    @if($item['id']==$Judgeses['industry'])
                        <input type="text" value="{{$item->industry_name}}" name="industry" readonly  autocomplete="off" class="layui-input">
                    @endif
                @endforeach
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">擅长领域：</label>
            <div class="layui-input-block">
                <textarea  name="skill" readonly required lay-verify="skill" class="layui-textarea">{{$Judgeses['skill']}}</textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">专家特长介绍：</label>
            <div class="layui-input-block">
                <textarea readonly name="speciality" class="layui-textarea">{{$Judgeses['speciality']}}</textarea>
            </div>
        </div>

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">照片：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                @if(!empty($Judgeses['photo']))--}}
{{--                @foreach (explode(',',$Judgeses['photo']) as $item)--}}
{{--                    <img height="100" width="100" src="{{$item}}" alt="">--}}
{{--                @endforeach--}}
{{--                @endif--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">视屏：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                @if(!empty($Judgeses['video_url']))--}}
{{--                @foreach (explode(',',$Judgeses['video_url']) as $item)--}}
{{--                    <video height="200" width="400"  controls="controls" src="{{$item}}" alt="">--}}
{{--                @endforeach--}}
{{--                @endif--}}
{{--            </div>--}}

{{--        </div>--}}

        <div class="layui-form-item">
            <label class="layui-form-label">短信密码：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$Judgeses['password']}}" name="password" readonly placeholder="请输入短信密码" autocomplete="off" class="layui-input">
            </div>

        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">不通过原因:</label>
            <div class="layui-input-block">
                <textarea readonly placeholder="请输入不通过原因" name="nopassinfo" class="layui-textarea">{{$Judgeses['nopassinfo']}}</textarea>
            </div>
        </div>
    </form>
@endsection