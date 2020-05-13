<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/ueditor/themes/default/css/ueditor.css">
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">

@section('title', '新闻编辑')

@section('content')
    <form class="layui-form" method="post">
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
            <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
        </div>
        <input name="id" type="hidden" value="{{!empty($newsModel['id']) ? $newsModel['id'] : '0'}}">
        <input name="system_version" type="hidden">
        <input name="_token" type="hidden" value="{{csrf_token()}}">
{{--        <div  class="layui-form-item">--}}
{{--            <label class="layui-form-label">新闻类型：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <select name="news_type" id="news_type" lay-verify="required" lay-filter="news_type">--}}
{{--                    @if($admininfo['role_slug']=='enterprise')--}}
{{--                        <option value="2" {{ $newsModel['news_type'] =='2'? 'selected' : '' }}>网络评选</option>--}}
{{--                    @endif--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">新闻来源：</label>
            <div class="layui-input-block">
                <select id="source" name="source" lay-verify="required">
                    @if($admininfo['role_slug']=='enterprise')
                        <option value="1" {{ $newsModel['source'] =='企业新闻'? 'selected' : '' }}>企业新闻</option>
                    @endif
                    @if($admininfo['role_slug']=='administrator')
                        <option value="2" {{ $newsModel['source'] =='媒体新闻'? 'selected' : '' }}>媒体新闻</option>
                    @endif
                </select>
            </div>
        </div>

        {{--        @if($admininfo['role_slug']=='administrator')--}}
        {{--            <div class="layui-form-item">--}}
        {{--                <label class="layui-form-label">虚拟流量：</label>--}}
        {{--                <div class="layui-input-block">--}}
        {{--                    <input type="number" lay-verify="required"--}}
        {{--                           value="{{!empty($newsModel['virtual_traffic']) ? $newsModel['virtual_traffic'] : 0}}"--}}
        {{--                           name="virtual_traffic" required placeholder="请输入虚拟浏览量" autocomplete="off"--}}
        {{--                           class="layui-input">--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @else--}}
        {{--            <input name="virtual_traffic" type="hidden"--}}
        {{--                   value="{{!empty($newsModel['virtual_traffic']) ? $newsModel['virtual_traffic'] : 0}}">--}}
        {{--        @endif--}}
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>新闻标题：</label>
            <div class="layui-input-block">
                <input type="text" lay-verify="required" maxlength="500"
                       value="{{!empty($newsModel['title']) ? $newsModel['title'] : ''}}"
                       name="title" required placeholder="请输入新闻标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>新闻摘要：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="2000" lay-verify="required"
                       value="{{!empty($newsModel['abstract']) ? $newsModel['abstract'] : ''}}"
                       name="abstract" required lay-verify="order" placeholder="请输入新闻摘要" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新闻内容：</label>
            <div class="layui-input-block">
                <script id="container" style="height: 300px;" name="content"
                        type="text/plain"></script>
                <code id="content"
                      style="display:none">{{!empty($newsModel['content']) ? $newsModel['content'] : ''}}</code>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">外部地址：</label>
            <div class="layui-input-block">
                {{--                lay-verify="url"--}}
                <input type="text" maxlength="180" value="{{!empty($newsModel['weburl']) ? $newsModel['weburl'] : ''}}"
                       name="weburl" placeholder="请输入新闻外部地址" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新闻封面：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                    <img class="imgBox" style="width:110px;height: 110px;" >
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
            <label class="layui-form-label">新闻视频：</label>
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
            <label class="layui-form-label">是否在本系统打开：</label>
            <div class="layui-input-block">

                <input type="radio" name="is_open" value="1"
                       title="是" checked {{ $newsModel['is_open'] ===1 ? 'checked' : '' }}  >
                <input type="radio" name="is_open" value="0"
                       title="否" {{ $newsModel['is_open'] ===0? 'checked' : '' }}>
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
        let system_version = location.search.split('?')[1].split('=')[1];

        $("input[name='system_version']").val(system_version);

        function goBack() {
            history.go(-1);
        }


        $(document).ready(function () {

            // var ue = UE.getEditor('container');
            var ue = UE.getEditor('container', {
                toolbars: [[
                    'source', '|',
                    'undo', 'redo', '|', 'fontsize', '|', 'blockquote', 'horizontal', 'removeformat', 'formatmatch', 'link', 'unlink', 'insertimage'],//, 'insertvideo'上传视频
                    ['bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', 'rowspacingtop',
                        'rowspacingbottom', 'lineheight', 'insertorderedlist', 'insertunorderedlist',
                    ]]
                , autoHeightEnabled: false
                , 'fontsize': [12, 14, 15, 16, 18, 20, 24]
                , uploadImgParamAddr: '/admin/news/uploadueditor?_token={{csrf_token()}}'
                // , uploaVideodParamAddr:'/admin/news/upload' 上传视频
                , insertorderedlist: {
                    'num': '1,2,3...',
                    'lower-alpha': '', // 'a,b,c...'
                    'lower-roman': '', //'i,ii,iii...'
                    'upper-alpha': '', //'A,B,C'
                    'upper-roman': '' //'I,II,III...'
                }
                , insertunorderedlist: {
                    'disc': ''
                }
            });
            ue.addListener('simpleupload_customcomplete', function (types, id, link, title, alt) {
                alert(link)
                document.getElementById('cover-img').src = link;
                document.getElementById('cover').value = link;//赋值表单的一个隐藏input
            });

            var proinfo = $("#content").text();

            ue.ready(function () {//编辑器初始化完成再赋值
                ue.execCommand('insertHtml', proinfo);  //赋值给UEditor
            });

        });

        //加载图片
        var img_url = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#img_url',
            imgElement: '.imgBox',
            imgWrap: '.imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=newsImg"
        });

        var img = '{{$newsModel['img_url']}}';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                img_url.successDo(list[i],true);
            }
        }

        /*添加视频*/
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
            maxLen: 4,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=newsVideo"
        });


        //加载视频
        var video = '{{$newsModel['video_url']}}';
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
                data: {url: url || urlVideo, _token: '{{csrf_token()}}'},
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
                this.disabled=true;
                $.ajax({
                    url: "{{url('/admin/news')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            window.location.href = "/admin/news/?system_version="+system_version;
                        } else {
                            this.disabled=false;
                            layer.msg(res.msg, {shift: 6, icon: 5});

                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        this.disabled=false;
                        layer.close(index);
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection
@extends('common.editTwo')
