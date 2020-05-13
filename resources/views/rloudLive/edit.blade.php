<link rel="stylesheet" href="{{ env('APP_URL') }}/static/ueditor/themes/default/css/ueditor.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section('title', '云竞技编辑')
@section('content')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
    </div>
    <form class="layui-form tc-container mT0" method="post">
        <input name="id" type="hidden" value="{{!empty($rloudLiveModel['id']) ? $rloudLiveModel['id'] : '0'}}">
        <input name="_token" type="hidden" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">内容类型：</label>
            <div class="layui-input-block">
                <select name="type" lay-verify="required">
                    <option value="1" {{ $rloudLiveModel['type']==1?'selected' : ''}}>直播</option>
                    <option value="2"{{ $rloudLiveModel['type']==2?'selected' : ''}}>录播</option>
                    <option value="3"{{ $rloudLiveModel['type']==3?'selected' : ''}}>回放</option>
                    <option value="4"{{ $rloudLiveModel['type']==4?'selected' : ''}}>竞赛视频</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>所属行业：</label>
            <div class="layui-input-block">
                <select name="industry" lay-verify="required">
                    @foreach($industryList as $list)
                        <option value="{{$list['id']}}" {{ $rloudLiveModel['industry']==$list['id']?'selected' : ''}}>{{$list['industry_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属企业：</label>
            <div class="layui-input-block">
                <select name="org_id" lay-verify="required" lay-search>
                    <option value="-1">无</option>
                    @foreach($orgList as $list)
                        <option value="{{$list['id']}}" {{ $rloudLiveModel['org_id']==$list['id']?'selected' : ''}}>{{$list['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>竞技标题：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="500" lay-verify="required"
                       value="{{!empty($rloudLiveModel['title']) ? $rloudLiveModel['title'] : ''}}"
                       name="title" required placeholder="请输入竞技标题" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">竞技内容：</label>
            <div class="layui-input-block">
{{--                <script id="container" style="height: 300px;" name="content"--}}
{{--                        type="text/plain"></script>--}}
{{--                <code id="content"--}}
{{--                      style="display:none">{{!empty($rloudLiveModel['content']) ? $rloudLiveModel['content'] : ''}}</code>--}}
                <textarea type="text" lay-verify="required" maxlength="200"
                          name="content" required placeholder="请输入专题描述" autocomplete="off" class="layui-textarea">{{!empty($rloudLiveModel['content']) ? $rloudLiveModel['content'] : ''}}</textarea>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">链接地址：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="500"
                       value="{{!empty($rloudLiveModel['weburl']) ? $rloudLiveModel['weburl'] : ''}}"
                       name="weburl" required placeholder="请输入云竞技链接地址" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">竞技封面：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img style="width:110px;height: 110px;" class="imgBox">
                    {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" id="img_url" name="img_url" class="hide-val" data-sum="0"/>
                <p style="color:#999">注：建议尺寸400像素*700像素 </p>
                <div style="height:50px"></div>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">竞技视频：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix" style="display: flex;flex-direction: column;">
                    <video class="video 1" style="width: 200px;height: auto" src="' + url + '">您的浏览器不支持 video 标签。
                    </video>
                    {{--                    <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                    <div id="adBtn_video" class="adBtn l"></div>
                </div>
                <input type="hidden" id="video_url" name="video_url" class="hide-val" data-sum="0"/>

                <div class="progress1" style="display:none">
                    <span class="tex1t">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>竞技时间：</label>
            <div class="layui-input-inline" style="margin-left:0px;">
                <input type="text" lay-verify="required"
                       value="{{!empty($rloudLiveModel['start_time']) ? $rloudLiveModel['start_time'] : ''}}"
                       name="start_time" placeholder="开始时间" autocomplete="off"
                       class="layui-input dateInfo">
            </div>
            <!-- <label class="layui-form-label">至</label> -->
            <span class="zhi">至</span>
            <div class="layui-input-inline" style="margin-left:10px;">
                <input type="text" lay-verify="required"
                       value="{{!empty($rloudLiveModel['end_time']) ? $rloudLiveModel['end_time'] : ''}}"
                       name="end_time" placeholder="结束时间" autocomplete="off"
                       class="layui-input dateInfo">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">虚拟流量：</label>
            <div class="layui-input-block">
                <input type="number" lay-verify="virtual_traffic"
                       value="{{!empty($rloudLiveModel['virtual_traffic']) ? $rloudLiveModel['virtual_traffic'] : 0}}"
                       name="virtual_traffic" required placeholder="请输入虚拟浏览量" autocomplete="off"
                       class="layui-input">
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

    {{--   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>--}}

    <script>
        function goBack() {
            history.go(-1);
        }

        {{--$(document).ready(function () {--}}
        {{--    // var ue = UE.getEditor('container');--}}
        {{--    var ue = UE.getEditor('container', {--}}
        {{--        toolbars: [[--}}
        {{--            'source', '|',--}}
        {{--            'undo', 'redo', '|', 'fontsize', '|', 'blockquote', 'horizontal', 'removeformat', 'formatmatch', 'link', 'unlink', 'insertimage'],//, 'insertvideo'上传视频--}}
        {{--            ['bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', 'rowspacingtop',--}}
        {{--                'rowspacingbottom', 'lineheight', 'insertorderedlist', 'insertunorderedlist',--}}
        {{--            ]]--}}
        {{--        , autoHeightEnabled: false--}}
        {{--        , 'fontsize': [12, 14, 15, 16, 18, 20, 24]--}}
        {{--        , uploadImgParamAddr: '/admin/news/uploadueditor?_token={{csrf_token()}}'--}}
        {{--        // , uploaVideodParamAddr:'/admin/news/upload' 上传视频--}}
        {{--        , insertorderedlist: {--}}
        {{--            'num': '1,2,3...',--}}
        {{--            'lower-alpha': '', // 'a,b,c...'--}}
        {{--            'lower-roman': '', //'i,ii,iii...'--}}
        {{--            'upper-alpha': '', //'A,B,C'--}}
        {{--            'upper-roman': '' //'I,II,III...'--}}
        {{--        }--}}
        {{--        , insertunorderedlist: {--}}
        {{--            'disc': ''--}}
        {{--        }--}}
        {{--    });--}}

        {{--    var proinfo = $("#content").text();--}}

        {{--    ue.ready(function () {//编辑器初始化完成再赋值--}}
        {{--        ue.execCommand('insertHtml', proinfo);  //赋值给UEditor--}}
        {{--    });--}}

        {{--});--}}

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
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=rloudLiveImg"
        });

        var img = '{{$rloudLiveModel['img_url']}}';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                img_url.successDo(list[i], true);
            }
        }

        var abc1 = new xUploader({
            btn: '#adBtn_video',
            suportType: 'mp4',
            mimeTypes: '.mp4',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#video_url',
            imgWrap: '.imgBox1',
            upType: 'type6',
            imgLenth: '.imgBox1 .loading',
            imgElement: '.video',
            maxLen: 1,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=rloudLiveImg"
        });

        //加载视频
        var video = '{{$rloudLiveModel['video_url']}}';
        if (video) {

            var list = video.split(',');
            for (var i in list) {
                abc1.successDo(list[i], true);
            }
        }
        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                abc.delFile(this, url);
            if (!!urlVideo)
                abc1.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url || urlVideo, _token: '{{csrf_token()}}'},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        })

        layui.use(['form', 'layedit', 'laydate'], function () {

            var form = layui.form();
            form.verify({
                virtual_traffic: function (value) {
                    let reg = /^\+?[0-9]{1,10}\d*$/;
                    if (!reg.test(value)) {
                        return "输入正整数，最大长度10";
                    }
                }
            });
            form.render();


            form.on('submit(formDemo)', function (data) {
                var index = layer.load();
                this.disabled = true;
                $.ajax({
                    url: "{{url('/admin/rloudlive')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            // var index = parent.layer.getFrameIndex(window.name);
                            //setTimeout('parent.layer.close(' + index + ')', 500);
                            window.location.href = "/admin/rloudlive";
                            //parent.layer.close(index);
                        } else {
                            this.disabled = false;
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.close(index);
                        this.disabled = false;
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
