@if (isset($organization))
    @section('title', '修改历史工匠')
@else
    @section('title', '添加历史工匠')
@endif
@extends('common.editTwo')

<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section("content")
    <body>
    <style>
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
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main">
        <form class="layui-form tc-container mT0">
            <input hidden name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layui-form-label">照片：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img src="" style="width:200px;height: 150px;" class="imgBox">
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="photo" name="photo" class="hide-val" data-sum="0" value=""/>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">姓名：</label>
                <div class="layui-input-block">
                    <input type="text" value=""
                           name="username" lay-verify="required" placeholder="姓名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                    <input type="text" value=""
                           name="mobile" lay-verify="required" placeholder="联系电话" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">获奖年份：</label>
                <div class="layui-input-block">
                    <select name="years" lay-filter="aihao">
                        <option value=""></option>
                        <option value="2016">2016年</option>
                        <option value="2017">2017年</option>
                        <option value="2018">2018年</option>
                        <option value="2019">2019年</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" >职业：</label>
                <div class="layui-input-block">
                    <input type="text" value=""
                           name="unit_name" lay-verify="required" placeholder="职业" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">推荐理由：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              name="describe" lay-verify="required" placeholder="推荐理由" autocomplete="off"
                              style = "width:100%;height: 180px;"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formHistoryCraftsman">立即提交</button>
                </div>
            </div>
        </form>
    </div>
    </body>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/upload.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        //加载图片
        var photo = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#photo',
            imgElement: '.imgBox',
            imgWrap: '.imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=unitImg"
        });

        {{--var img = '{{}}';--}}
        {{--if (img) {--}}
            {{--var list = img.split(',');--}}
            {{--for (var i in list) {--}}
                {{--photo.successDo(list[i],true);--}}
            {{--}--}}
        {{--}--}}

        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            //监听提交
            form.on('submit(formHistoryCraftsman)', () => {
                $.ajax({
                    url: "{{url('/admin/history_craftsman')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
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

    </script>
@endsection