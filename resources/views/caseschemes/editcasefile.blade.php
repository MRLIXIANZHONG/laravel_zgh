@section('title', !empty($caseFile['id']) ? '修改赛事文件' : '添加赛事文件')
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">
@section("content")
    <body>
    <style>
        .myForm {margin: 20px;}
    </style>
    <form class="layui-form myForm" method="post">
        <input hidden name="_token" value="{{csrf_token()}}">
        <input hidden name="id" value="{{$caseFile['id']?:0}}">
        <div class="main" id="app">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($caseFile['name']) ? $caseFile['name'] : ''}}"
                           maxlength="255"
                           name="name" lay-verify="required" placeholder="名称" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图标：</label>
                <div class="layui-input-block">
                    <div class="img-box iconBox clearfix">
                        <img id='icon_Box' style="width: 150px"/>
                        <div id="adBtn_icon" class="adBtn l" style="display: block;"></div>
                    </div>
                    <input type="hidden" id="icon" name="icon" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸100像素*100像素，最多1张 </p>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态：</label>
                <div class="layui-input-block">
                    <input type="checkbox" id="status" name="status"
                           lay-skin="switch" @if($caseFile['status']) checked @endif lay-text="开启|关闭">
                    {{--<input type="hidden" name="status" value="{{$caseFile['status']}}">--}}
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>活动类型：</label>
                <div class="layui-input-block">
                    <input type="radio" name="active_type" title="网络竞技" value="1" @if($caseFile['active_type']==1)checked @endif/>
                    <input type="radio" name="active_type" title="巴渝工匠" value="4" @if($caseFile['active_type']==4)checked @endif/>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">文件类型：</label>
                <div class="layui-input-block">

                    <div class="layui-inline">
                        <select name="type">

                            <option value="1"
                                    @if($caseFile['type']===1) selected @endif >活动文件</option>
                            <option value="2"
                                    @if($caseFile['type']===2) selected @endif >活动规则</option>
                            <option value="3"  @if($caseFile['type']===3) selected @endif >活动奖项</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否推送到前台：</label>
                <div class="layui-input-block">
                    <input type="checkbox" id="is_push" name="is_push"
                           lay-skin="switch" @if($caseFile['is_push']) checked @endif lay-text="开启|关闭">
                    {{--<input type="hidden" name="is_push" value="{{$caseFile['is_push']}}">--}}
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图片：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="img" name="img" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多10张 </p>
                    <div class="progress1" style="display:none">
                        <span class="text1">0%</span>
                        <span class="percentage1" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">文件：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <ul class="fileBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn_file" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="file" name="file" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注： 请上传word、PDF、excel文件，最大100M</p>
                    <div class="progress2" style="display:none">
                        <span class="text2">0%</span>
                        <span class="percentage2" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>内容：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="内容" lay-verify="required"
                              maxlength="500"
                              name="context">{{!empty($caseFile['context']) ? $caseFile['context'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </div>
    </form>
    </body>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>

    <script type="text/javascript" src="{{ env('APP_URL') }}/static/upload/upload.js"></script>
    <script>
        //加载图标
        var icon = new xUploader({
            btn: '#adBtn_icon',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#icon',
            imgElement: '#icon_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=caseScheme"
        });
        //加载图标
        if ('{{!empty($caseFile['icon'])}}' != '') {
            icon.successDo('{{$caseFile['icon']}}',true)
        }

        //加载图片
        var img = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#img',
            imgWrap: '.imgBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 10,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=caseScheme"
        });

        var imglsit = '{{$caseFile['img']}}';
        if (imglsit) {
            var list = imglsit.split(',');
            for (var i in list) {
                img.successDo(list[i],true);
            }
        }

        //加载文件
        var file = new xUploader({
            btn: '#adBtn_file',
            progressElement: '.progress2',
            progressElement1: '.progress2 .text2',
            progressElement2: '.progress2 .percentage2',
            valueElement: '#file',
            imgWrap: '.fileBox',
            upType: 'type5',
            imgLenth: '.imgBox .loading',
            suportType: 'doc,docx,pdf,xlsx,xls',
            mimeTypes: '.doc,.docx,.pdf,.xlsx,.xls',
            maxLen: 10,
            singleSizeLimit: '100mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=caseScheme"
        });

        var filelsit = '{{$caseFile['file']}}';
        if (filelsit) {
            var list = filelsit.split(',');
            for (var i in list) {
                file.successDo(list[i],true);
            }
        }
        $(document).on('click', '.del-file', function () {
            var url = $(this).attr('data-url')
            file.delFile(this, url);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url, '_token':{{csrf_token()}}},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
        })

        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            img.delFile(this, url);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url, '_token':{{csrf_token()}}},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        })
        layui.use(['form'], () => {
            let form = layui.form();

            form.render();

            //监听提交
            form.on('submit(formDemo)', () => {
                $('input[type=checkbox]:checked').each(function () {
                    $('input[name=' + $(this).attr('id') + ']').val(1)
                });

                if($('#icon').val()==''){
                    layer.msg('请上传图标', {shift: 6, icon: 5});
                    return false;
                }
                if($('#img').val()==''){
                    layer.msg('请上传图片', {shift: 6, icon: 5});
                    return false;
                }
                if($('#file').val()==''){
                    layer.msg('请上传文件', {shift: 6, icon: 5});
                    return false;
                }
                $.ajax({
                    url: "{{url('/admin/casefile/update')}}",
                    data: $('form').serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                parent.layer.closeAll();
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
    </script>
@endsection
@extends('common.editTwo')
