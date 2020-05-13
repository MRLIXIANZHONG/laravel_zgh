
@section('title', '添加工匠荣誉')

@extends('common.editTwo')
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<style>
    .layui-form-label {
        width: 150px;
    }
</style>
@section("content")
    <body>
    <style>
        .main {
            width: 97%;
            padding-top: 46px;
        }

        .product_img {
            width: 380px;
            height: 380px;
        }

        .seller_icon {
            width: 100px;
            height: 100px;
        }

        .deleted_icon {
            display: inline-block;
            height: 20px;
            width: 20px;
            font-size: 18px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            background: #CCCCCC;
            filter: alpha(opacity:30);
            opacity: 0.8;
            position: absolute;
            bottom: 0;
            left: 360px;
            cursor: pointer;
        }
    </style>
    <div class="main" id="app">
        <div id="storeCraftsmanHonor">
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;width: 460px;">
                    <label class="layui-form-label">荣誉标题：</label>
                    <input type="text" name="honor_name" id="honor_name" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请输入荣誉标题" style="display: inline-block;width: 50%;" value="">
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">获得荣誉时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="honor_time" id="date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">荣誉描述：</label>
                    <textarea type="text" name="honor_description" lay-verify="required" placeholder="荣誉描述" autocomplete="off" style="width:990px;height: 130px;"></textarea>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">图集：</label>
                    <div class="layui-input-block">
                        <div class="img-box clearfix">
                            <ul class="imgBox" id="imageBox" data-prompt-position="bottomLeft:130,-80"></ul>
                            <div id="adBtn1" class="adBtn l"></div>
                        </div>
                        <input type="hidden" id="honor_image" name="honor_image" class="hide-val" data-sum="0"/>

                        <div style="height:50px"></div>
                        <div class="progress" style="display:none">
                            <span class="text">0%</span>
                            <span class="percentage" style="width:0%;"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formStoreHonor" style="margin-left: 10%;margin-top: 8px;">立即提交</button>
            </form>
        </div>

    </div>
    </body>
@endsection
@section('js')

    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit
                ,laydate = layui.laydate;

            //日期
            laydate.render({
                elem: '#date'
            });
            laydate.render({
                elem: '#date1'
            });
        });

        //加载图集
        var honor_image = new xUploader({
            btn: '#adBtn1',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#honor_image',
            imgWrap: '#imageBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 10,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');console.log(url);
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                honor_image.delFile(this, url);
            if (!!urlVideo)
                video.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {url: url || urlVideo, _token: '{{csrf_token()}}'},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        });

        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            //监听提交
            form.on('submit(formStoreHonor)', () => {
                $.ajax({
                    url: "{{url('/admin/craftsmans/'.$craftsman->id.'/honor')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                history.go(-1);
                            });
                        } else {
                            layer.msg(res.message, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络请求失败', {time: 1000});
                    }
                });
                // 请求接口喽
                return false;
            });
        });


        {{--function craftsmanPull() {--}}
            {{--$.ajax({--}}
                {{--url: "{{url('/admin/craftsmans/'.$craftsman->id.'/pull')}}",--}}
                {{--data: {'_token': '{{csrf_token()}}'},--}}
                {{--type: 'PATCH',--}}
                {{--dataType: 'json',--}}
                {{--success: function (res) {--}}
                    {{--if (res.code == 1000) {--}}
                        {{--layer.msg(res.message, {icon: 6});--}}
                    {{--} else {--}}
                        {{--layer.msg(res.message, {shift: 6, icon: 5});--}}
                    {{--}--}}
                {{--},--}}
                {{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
                    {{--layer.msg('网络请求失败', {time: 1000});--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

    </script>
@endsection