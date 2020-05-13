<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section('title', '专家荣耀添加')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/honorjudges/list?JudgesId={{$JudgesId}}" class="layui-btn layui-btn-normal">返回</a>
    </div>
    <form class="layui-form tc-container" action="/admin/honorjudges/store" method="post">
        <div class="layui-form-item">
            <input type="hidden" value="{{$JudgesId}}" name="judges_id" autocomplete="off" class="layui-input">
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">荣耀名：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="100" name="name" value="" class="layui-input" placeholder="请输入荣耀名(最多100个字符)">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">获得时间：</label>
            <div class="layui-input-block">
                <input type="text" value="" name="honor_time" id="honor_time" lay-verify="honor_time" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">荣耀介绍：</label>
            <div class="layui-input-block">
                <textarea name="content" maxlength="500" placeholder="请输入荣耀介绍(最多500个字符)" class="layui-textarea" ></textarea>
            </div>

        </div>

        <!--图片上传-->
        <div class="layui-form-item">
            <label class="layui-form-label">图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" name="imgUrl" id="titval1" class="hide-val"  data-sum="0" />
                <p style="color:#999"></p>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>

@endsection
@section("js")
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        layui.use('laydate', function(){
            var honor_time = layui.laydate;
            //常规用法
            honor_time.render({
                elem: '#honor_time'
            });
        });
        var abc = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#titval1',
            imgWrap: '.imgBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 4,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=honorjudges"
        });

        var img = '';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                abc.successDo(list[i],true);
            }
        }

        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            abc.delFile(this, url);
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
            $(".layui-btn layui-btn-normal")
            var form = layui.form();
            form.render();
            form.on('submit(formDemo)', function (data) {
                this.disabled=true;
                $.ajax({
                    url: "{{url('/admin/honorjudges/store')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        this.disabled=false;
                        layer.msg('添加成功',function () {
                            var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                        });
                        window.location.href="/admin/honorjudges/list?JudgesId={{$JudgesId}}";
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        this.disabled=false;
                    }
                });
                return false;
            });
        });
    </script>
@endsection("js")


