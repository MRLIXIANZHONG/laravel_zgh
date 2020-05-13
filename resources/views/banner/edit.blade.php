<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/ueditor/themes/default/css/ueditor.css">
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">

@section('title', 'banner编辑')

@section('content')
    <form class="layui-form" method="post">
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
            <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>

        </div>
        <input name="id" type="hidden" value="{{!empty($banner['id']) ? $banner['id'] : '0'}}">
        <input name="_token" type="hidden" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">是否使用：</label>
            <div class="layui-input-block">
                <input type="radio" name="is_use" value="1" title="是" {{empty($banner['id'])?'checked':$banner['is_use']==   1?'checked':''}}>
                <input type="radio" name="is_use" value="0" title="否" {{empty($banner['id'])?'':$banner['is_use']==0?'checked':''}}>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" style="width:110px;height: 110px;" class="imgBox">
{{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
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
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                {{--            <button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{ env('APP_URL') }}/static/ueditor/ueditor.config.js"></script>
    <script src="{{ env('APP_URL') }}/static/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>

    <script>
        function goBack() {
            history.go(-1);
        }

        //加载图片
        var img_url = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#img_url',
            imgElement:'.imgBox',
            imgWrap: '.imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}"
        });

        var img = '{{$banner['img_url']}}';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                img_url.successDo(list[i],true);
            }
        }


        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            img_url.delFile(this, url);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {url: url, _token: '{{csrf_token()}}'},
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
                //弹出层
                var index = layer.load();
                $.ajax({
                    url: "{{url('/admin/banner')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                           // var index = parent.layer.getFrameIndex(window.name);
                            //setTimeout('parent.layer.close(' + index + ')', 500);
                            //parent.layer.close(index);
                            history.back(-1);
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection
@extends('common.editTwo')
