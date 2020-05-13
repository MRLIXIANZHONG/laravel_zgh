@section('title', '新闻详情')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<style>
   
</style>
@section('content')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
    </div>
    <form class="layui-form tc-container mT0">
    {{--    <div class="layui-form-item">--}}
    {{--        <label class="layui-form-label">新闻类型：</label>--}}
    {{--        <div class="layui-input-block">--}}
    {{--            @if($newsModel['news_type']==1)--}}
    {{--                巴渝工匠--}}
    {{--            @else--}}
    {{--                网络评选--}}
    {{--            @endif--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="layui-form-item">
        <label class="layui-form-label">新闻标题：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['title']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新闻封面：</label>
        <div class="layui-input-block">
            <ul class="imgBox" data-prompt-position="bottomLeft:130,-80">
                <li style='height: 150px;'><img style='width: auto;height: 100%;' src='{{$newsModel['img_url']}}'/> </li>
            </ul>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属公会：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['units_name']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属企业：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['organizations_name']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属行业：</label>
        <div class="layui-input-block" id="industry">
            <span type="text" class="layui-input">
            @foreach($industyLits as  $list)
                {{$list['industry_name']}} |
            @endforeach
            </span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新闻来源：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['source']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">总浏览量：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['virtual_traffic']+$newsModel['browse_count']}}</span>
        </div>
    </div>
    <div class="layui-form-item hideDiv">
        <label class="layui-form-label">新闻流量：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['browse_count']}}</span>
        </div>
    </div>
    <div class="layui-form-item hideDiv">
        <label class="layui-form-label">虚拟流量：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['virtual_traffic']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新闻摘要：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['abstract']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新闻内容：</label>
        <div class="layui-input-block">
            {!! $newsModel['content']!!}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">外部地址：</label>
        <div class="layui-input-block">
            <span type="text" class="layui-input">{{$newsModel['weburl']}}</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新闻视频：</label>
        <div class="layui-input-block">
            <ul class="videoBox" data-prompt-position="bottomLeft:130,-80">

            </ul>
        </div>
    </div>
    </form>

@endsection
@section('js')
    <script>
        function goBack() {
            history.go(-1);
        }

        //角色类型
        var role = '{{$admininfo['role_slug']}}';
        if (role != 'administrator') {
            $(".hideDiv").css('display', 'none')
        }

        //加载视频
        var video = '{{$newsModel['video_url']}}';
        if (video) {
            var html = "";
            var list = video.split(',');
            for (var i in list) {
                html += "<li><video style='max-width: 300px;' controls src='" + list[i] + "' ></video> </li>";
            }
            $(".videoBox").append(html);
        }

        layui.use(['form'], function () {
            var form = layui.form();
            form.render();

        });
    </script>
@endsection
@extends('common.editTwo')
