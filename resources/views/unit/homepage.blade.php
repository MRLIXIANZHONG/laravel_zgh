@section('title', '修改主页设置')
@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/layui2/css/layui.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/layui2/css/global.css">

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
            padding-top: 30px;
        }
    </style>
    <div class="main" id="app">
        <form action="" class="layui-form" >
{{--            {{dd($unitHomePage)}}--}}
            <input type="hidden" name="id" value="{{$unitHomePage->id}}">
            <input hidden name="_token" value="{{csrf_token()}}">

            <div class="layui-form-item">
                <label class="layui-form-label">工会名称：</label>
                <div class="layui-input-block">
                    <input type="text" disabled value="{{$unitHomePage->unit_name}}"
                           name="unit_name" lay-verify="required" placeholder="工会名称" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">页面标题：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unitHomePage->page_title}}"
                           name="page_title" lay-verify="required" placeholder="页面标题" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">工会地址：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unitHomePage->unit_url}}"
                           name="unit_url" lay-verify="required" placeholder="工会地址" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">主题颜色：</label>
                <div class="layui-input-block">
                    <select name="typtheme_color">
                        <option value="1" @if($unitHomePage->theme_color == 1) selected="" @endif>蓝色</option>
                        <option value="2" @if($unitHomePage->theme_color == 2) selected="" @endif>红色</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">工会封面：</label>
                <div class="layui-input-block">
                    <div class="layui-row layui-col-space10">
                        <div class="layui-col-md4">
                            <img src="{{ env('APP_URL') }}/images/homepage_1.jpg" style="height: 200px;width: 30%"
                                 alt="">
                            <input name="S_cover" type="radio" value="{{ env('APP_URL') }}/images/homepage_1.jpg"
                                   @if($unitHomePage->cover==env('APP_URL').'/images/homepage_1.jpg') checked
                                   @endif title=" "/>
                        </div>
                        <div class="layui-col-md4">
                            <img src="{{ env('APP_URL') }}/images/homepage_2.jpg" style="height: 200px;width: 30%"
                                 alt="">
                            <input name="S_cover" type="radio" value="{{ env('APP_URL') }}/images/homepage_2.jpg"
                                   @if($unitHomePage->cover==env('APP_URL').'/images/homepage_2.jpg') checked
                                   @endif  title=" "/>
                        </div>
                        <div class="layui-col-md4">
                            <img src="{{ env('APP_URL') }}/images/homepage_3.png" style="height: 200px;width: 30%"
                                 alt="">
                            <input name="S_cover" type="radio" value="{{ env('APP_URL') }}/images/homepage_3.png"
                                   @if($unitHomePage->cover==env('APP_URL').'/images/homepage_3.png') checked
                                   @endif  title=" "/>
                        </div>
                    </div>
                    <div class="img-box imgBox clearfix">
                        <img id='cover_Box' style="width: 150px"/>

                        <div id="adBtn_cover" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="cover" name="cover" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多1张 </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>

            </div>

            <label class="layui-form-label">页面描述：</label>
            <div class="layui-input-block">
                    <textarea lay-verify="required" name="page_describe" class="layui-textarea"
                              placeholder="页面描述">{{$unitHomePage->page_describe}}</textarea>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">微信分享头像：</label>
                <div class="layui-input-block">
                    <div class="img-box imgBox clearfix">
                        <img id='wechat_photo_Box' style="width: 150px"/>

                        <div id="adBtn_wechat_photo" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="wechat_photo" name="wechat_photo" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多1张 </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <button class="layui-btn layui-btn-normal" id="formBtn" type="button" lay-filter="formDemo"
                    style="margin-left: 8%;">
                立即提交
            </button>
        </form>
    </div>
    </body>
@endsection
@section('js')
    <script src="{{ env('APP_URL') }}/static/admin/layui2/layui.js"></script>
    <script src="{{ env('APP_URL') }}/static/admin/layui2/layui.all.js"></script>
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>

    <script>
        //加载银行卡图片
        var wechat_photo = new xUploader({
            btn: '#adBtn_wechat_photo',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#wechat_photo',
            imgElement: '#wechat_photo_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}"
        });
        //加载银行卡图片
        if ('{{!empty($unitHomePage['wechat_photo'])}}' != '') {
            wechat_photo.successDo('{{$unitHomePage['wechat_photo']}}',true)
        }

        //加载封面图片
        var cover = new xUploader({
            btn: '#adBtn_cover',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#cover',
            imgElement: '#cover_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}"
        });
        //加载封面图片
        if ('{{!empty($unitHomePage['cover'])}}' != '') {
            cover.successDo('{{$unitHomePage['cover']}}',true)
        }

        var form = layui.form;
        form.on('radio', function (data) {
            cover.successDo(data.value,true);
            $('#cover').val(data.value);
        });

        $("#formBtn").on('click', function () {
            $.ajax({
                url: "{{ url('admin/unit/updatehomepage') }}",
                data: $('form').serialize(),
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 1000) {
                        layer.msg(res.message, {icon: 6});
                    } else {
                        layer.msg(res.message, {shift: 6, icon: 5});
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络请求失败', {time: 1000});
                }
            });

        })


    </script>
@endsection