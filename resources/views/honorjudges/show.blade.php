<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<style type="text/css">
    #imgs img {width: 700px;}
</style>

@section('title', '专家荣耀添加')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/honorjudges/list?JudgesId={{$JudgesId}}" class="layui-btn layui-btn-normal">返回</a>
    </div>
    <form class="layui-form tc-container" method="post">

        <div class="layui-form-item">
            <label class="layui-form-label">荣耀名：</label>
            <div class="layui-input-block">
                <input type="text" readonly name="name" value="{{$honorjudges['name']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">获得时间：</label>
            <div class="layui-input-block">
                <input type="text" readonly value="{{$honorjudges['honor_time']}}" name="honor_time" id="honor_time" lay-verify="honor_time" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">荣耀介绍：</label>
            <div class="layui-input-block">
                <textarea name="content" readonly maxlength="500" class="layui-textarea" >{{$honorjudges['content']}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图片：</label>
            <div class="layui-input-block" id="imgs">
            </div>
        </div>
    </form>

@endsection
@section('js')
    <script>
        var img_url='{{$honorjudges['img_url']}}'
        window.onload = function(){
            var img_list = img_url.split(',');
            for(var i =0;i<img_list.length;i++){
                var img=document.createElement("img");
                img.src=img_list[i];
                document.getElementById("imgs").appendChild(img);
            }
        }
    </script>
@endsection


