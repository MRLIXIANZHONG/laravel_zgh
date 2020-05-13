{{--@section('title', '添加优秀个人')--}}
@section('id',!empty($wuxiao['id']) ? $wuxiao['id'] : 0 )

@section("content")
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
    <body>

    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <form class="layui-form tc-container mT0">
        <div class="layui-form-item">
            <label class="layui-form-label">所属企业：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao->organizations->name) ? $wuxiao->organizations->name : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小类型：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['type']) ? $wuxiao['type'] : ''}}</span>
            </div>
        </div>
{{--        {{dd($wuxiao)}}--}}
        <div class="layui-form-item">
            <label class="layui-form-label">所属行业：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao->industry) ? $wuxiao->industry->industry_name : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">参与赛事：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao->caseSchemes['title']) ? $wuxiao->caseSchemes['title']: ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小名称：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['plan_name']) ? $wuxiao['plan_name'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小封面：</label>
            <div class="layui-input-block">
                <img {{!empty($wuxiao['plan_name']) ? 'src='.url($wuxiao['cover']) : ''}} style="width: 200px;height: 150px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小概述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="" autocomplete="off" style="width:100%;height: 130px;">{{!empty($wuxiao['summary']) ? $wuxiao['summary'] : ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小内容：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="" autocomplete="off" style="width:100%;height: 130px;">{{!empty($wuxiao['content']) ? $wuxiao['content'] : ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">历史奖项：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="" autocomplete="off" style="width:100%;height: 130px;">{{!empty($wuxiao['rewards']) ? $wuxiao['rewards'] : ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小图片：</label>
            <div class="layui-input-block">
                @if(!empty($wuxiao['content']))
                    @foreach(explode(',',$wuxiao['img_url']) as $imgUrl)
                        <img style="height: 200px;width: 200px;" src="{{$imgUrl}}">
                    @endforeach
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">五小视频：</label>
            <div class="layui-input-block">
                @if(!empty($wuxiao['video_url']))
                    @foreach(explode(',',$wuxiao['video_url']) as $videoUrl)
                        <video src="{{$videoUrl}}" width="320" height="240" controls autoplay></video>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申报状态：</label>
            <div class="layui-input-block">
                @if($wuxiao['declaration_state']==0)
                    <span type="text" class="layui-input">未申报</span>
                @else($wuxiao['declaration_state']==1)
                    <span type="text" class="layui-input">已申报</span>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申报时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['declaration_time']) ? $wuxiao['declaration_time'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">审核状态：</label>
            <div class="layui-input-block">
                @if($wuxiao['check_state']==0)
                    <span type="text" class="layui-input">未审核</span>
                @elseif($wuxiao['check_state']==1)
                    <span type="text" class="layui-input">审核通过</span>
                @else
                    <span type="text" class="layui-input">审核驳回</span>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">审核时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['check_time']) ? $wuxiao['check_time'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">审核意见：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="" autocomplete="off" style="width:100%;height: 130px;">{{!empty($wuxiao['check_opinion']) ? $wuxiao['check_opinion'] : ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所获奖项：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['awards']) ? $wuxiao['awards'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">获奖时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($wuxiao['awards_time']) ? $wuxiao['awards_time'] : ''}}</span>
            </div>
        </div>
    </form>
</body>
@endsection
@section('js')

@endsection
@extends('common.editTwo')
