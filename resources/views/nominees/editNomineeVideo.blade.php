<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">

@section('title', '个人荣誉视频')

@section('content')
    <form class="layui-form" method="post">
        {{csrf_field()}}
        <input name="id" type="hidden" value="{{!empty($nominee['id']) ? $nominee['id'] : '0'}}">
        <input name="mainId" type="hidden" value="{{!empty($mainId) ? $mainId : '0'}}">
        <div class="layui-form-item">
            <label class="layui-form-label"> <span style="color:red;position: relative;top: 3px;">* </span>标题：</label>
            <div class="layui-input-block">
                <input type="text" lay-verify="required" maxlength="200"
                       value="{{!empty($nominee['title']) ? $nominee['title'] : ''}}"
                       name="title" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label"> <span style="color:red;position: relative;top: 3px;">* </span>视频封面：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" id="img_url" name="img_url" class="hide-val" data-sum="0"/>

                <div style="height:50px"></div>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>视频：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn_video" class="adBtn l"></div>
                </div>
                <input type="hidden" id="video_url" name="video_url" class="hide-val" data-sum="0"/>

                <div style="height:50px"></div>
                <div class="progress1" style="display:none">
                    <span class="text1">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序码：</label>
            <div class="layui-input-block">
                <input type="number" lay-verify="required|number" maxlength="5"
                       value="{{!empty($nominee['sort']) ? $nominee['sort'] : '1'}}"
                       name="sort" placeholder="" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                {{--            <button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>

    <script>

        //加载图片
        var img_url = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#img_url',
            imgWrap: '.imgBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=nominee"
        });

        var img = '{{$nominee['img_url']}}';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                img_url.successDo(list[i],true);
            }
        }


        var video_url = new xUploader({
            btn: '#adBtn_video',
            suportType: 'mp4',
            mimeTypes: '.mp4',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#video_url',
            imgWrap: '.imgBox1',
            upType: 'type4',
            imgLenth: '.imgBox1 .loading',
            maxLen: 1,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=nominee"
        });


        //加载视频
        var video = '{{$nominee['video_url']}}';
        if (video) {

            var list = video.split(',');
            for (var i in list) {
                video_url.successDo(list[i],true);
            }
        }
        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                img_url.delFile(this, url);
            if (!!urlVideo)
                video_url.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url || urlVideo, '_token':"{{csrf_token()}}"},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        })
        layui.use(['form'], function () {
            var form = layui.form();
            form.render();
            form.on('submit(formDemo)', function (data) {
                $.ajax({
                    url: "{{url('/admin/nominees/savevideo')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout('parent.layer.close(' + index + ')', 2000);
                            //parent.layer.close(index);
                        } else {
                            layer.msg(res.message, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
        layui.use('laydate', function () {
            var laydate = layui.laydate;

            $('.dateInfo').each(function () {
                laydate.render({
                    elem: this //指定元素
                    , type: 'date'
                    , trigger: 'click'
                });
            });
        });
    </script>
@endsection
@extends('common.editTwo')
