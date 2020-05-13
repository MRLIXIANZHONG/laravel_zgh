<link rel="stylesheet" href="{{ env('APP_URL') }}/static/ueditor/themes/default/css/ueditor.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section('title', '专题编辑')

@section('content')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
    </div>
    <form class="layui-form tc-container mT0" method="post">
        <input name="id" type="hidden" value="{{$special['id']}}">
        <input name="system_version" value="{{$special['system_version']}}" type="hidden">
        <input name="_token" type="hidden" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专题标题：</label>
            <div class="layui-input-block">
                <input type="text" lay-verify="required" maxlength="200"
                       value="{{!empty($special['title']) ? $special['title'] : ''}}"
                       name="title" required placeholder="请输入专题标题" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专题描述：</label>
            <div class="layui-input-block">
                      <textarea type="text" lay-verify="required" maxlength="200"
                                name="mark" required placeholder="请输入专题描述" autocomplete="off" class="layui-textarea">{{!empty($special['mark']) ? $special['mark'] : ''}}</textarea>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Banner：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" dataType="banner" style="width:110px;height: 110px;" class="imgBox">
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" id="banner" name="banner" class="hide-val" data-sum="0"/>

                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">专题头像：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" dataType="title_img" style="width:200px;height: 150px;margin-left: 0" class="imgBox1">
                    <div id="adBtn_img" class="adBtn l"></div>
                </div>
                <input type="hidden" id="title_img" name="title_img" class="hide-val" data-sum="0"/>

                <div class="progress1" style="display:none">
                    <span class="text1">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">活动精神：</label>
            <div class="layui-input-block">
                <script id="container" style="height: 300px;" name="spirit"
                        type="text/plain"></script>
                <code id="spirit"
                      style="display:none">{{!empty($special['spirit']) ? $special['spirit'] : ''}}</code>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">主办单位：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="255"
                       value="{{!empty($special['sponsor_unit']) ? $special['sponsor_unit'] : ''}}"
                       name="sponsor_unit" placeholder="请输入主办单位" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">备案号：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="255"
                       value="{{!empty($special['record_numbe']) ? $special['record_numbe'] : ''}}"
                       name="record_numbe" placeholder="请输入主办单位" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">地址：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="255"
                       value="{{!empty($special['address']) ? $special['address'] : ''}}"
                       name="address" placeholder="请输入地址" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮编：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="255"
                       value="{{!empty($special['zip_code']) ? $special['zip_code'] : ''}}"
                       name="zip_code" placeholder="请输入邮编" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">版权信息：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="255"
                       value="{{!empty($special['copyright_information']) ? $special['copyright_information'] : ''}}"
                       name="copyright_information" placeholder="请输入版权信息" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
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

            var proinfo = $("#spirit").text();

            ue.ready(function () {//编辑器初始化完成再赋值
                ue.execCommand('insertHtml', proinfo);  //赋值给UEditor
            });

        });

        //加载图片
        var banner = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#banner',
            imgElement: '.imgBox',
            imgWrap: '.imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=specialImg"
        });


        banner.successDo('{{$special['banner']}}',true);


        //加载图片
        var title_img = new xUploader({
            btn: '#adBtn_img',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#title_img',
            imgElement: '.imgBox1',
            imgWrap: '.imgBox1',
            upType: 'type1',
            imgLenth: '.imgBox1 .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=specialImg"
        });
        title_img.successDo('{{$special['title_img']}}',true);


        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            var dataType = $(this).closest('.loading').find('img').attr('dataType');
            if (dataType == 'banner')
                banner.delFile(this, url);
            else
                title_img.delFile(this, url);

            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {url: url || img_url, _token: '{{csrf_token()}}'},
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
                this.disabled = true;
                $.ajax({
                    url: "{{url('/admin/specialmanage')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            //var index = parent.layer.getFrameIndex(window.name);
                            //setTimeout('parent.layer.close(' + index + ')', 500);
                            window.location.href = "/admin/specialmanage";
                            //parent.layer.close(index);
                        } else {
                            this.disabled = false;
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        this.disabled = false;
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
