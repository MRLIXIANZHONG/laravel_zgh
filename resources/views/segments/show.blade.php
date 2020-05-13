@section('title', '方案活动创建')
<link rel="stylesheet" href="/static/upload/xUploader.css">
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 999999999 ">
        <a style="" href="{{"/admin/segments?organizationplanid=".$segments['organization_plan_id']."&organizationId=".$segments['organization_id']}}" class="layui-btn layui-btn-normal">返回</a>
    </div>
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">参赛企业ID：</label>
            <div class="layui-input-block">
                <input readonly type="number" value="{{$segments['organization_id']}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案ID：</label>
            <div class="layui-input-block">
                <input readonly type="number" value="{{$segments['organization_plan_id']}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">阶段数：</label>
            <div class="layui-input-block">
                <input readonly type="number" value="{{$segments['stage_number']}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">阶段名：</label>
            <div class="layui-input-block">
                <input readonly type="text" value="{{$segments['name']}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">介绍，描述：</label>
            <div class="layui-input-block">
                <input readonly type="text" value="{{$segments['describe']}}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">开始时间：</label>
            <div class="layui-input-block">
                <input readonly type="text" value="{{$segments['start_time']}}" id="start_time" lay-verify="start_time" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">结束时间：</label>
            <div class="layui-input-block">
                <input readonly type="text" value="{{$segments['end_time']}}" id="end_time" lay-verify="end_time" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图片：</label>
            <div class="layui-input-block" id="imgs">

            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">视频：</label>
            <div class="layui-input-block" id="videos">

            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        var vedio_url='{{$segments['video_url']}}'
        var img_url='{{$segments['img_url']}}'
        window.onload = function(){
            var video_list = vedio_url.split(',');
            var img_list = img_url.split(',');
            for(var i =0;i<video_list.length;i++){
                var video = document.createElement("VIDEO");
                video.setAttribute("width", "320");
                video.setAttribute("height", "240");
                video.setAttribute("controls", "controls");
                video.setAttribute("src", video_list[i]);
                document.getElementById("videos").appendChild(video);
            }

            for(var i =0;i<img_list.length;i++){
                var img=document.createElement("img");
                img.src=img_list[i];
                document.getElementById("imgs").appendChild(img);
            }
    }
    </script>
@endsection



