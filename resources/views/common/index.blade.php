<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>@yield('title') | {{ Config::get('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/static/admin/layui/css/layui.css"/>
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/static/admin/css/admin.css?v={{rand(0,9999)}}"/>
</head>
<style type="text/css">
    .tc-main-top {
        width: 100%;
        height: 80px;
        background-image: url({{ env('APP_URL') }}/static/UploadFile/index/page_top_bg.png);
        background-size: cover;
        position: relative;
    }

    .tc-logo {
        width: 40px;
        height: 40px;
        position: absolute;
        top: 20px;
        left: 30px;
        object-fit: cover;
    }

    .tc-system-name {
        height: 40px;
        line-height: 40px;
        font-size: 20px;
        color: #FFF;
        position: absolute;
        top: 20px;
        left: 90px;
    }

    .tc-userinfo {
        height: 30px;
        position: absolute;
        top: 25px;
        right: 68px;
        line-height: 30px;
    }

    .tc-user-head {
        width: 30px;
        height: 30px;
        right: 10px;
        object-fit: cover;
    }

    .tc-username {
        font-size: 16px;
        color: #FFF;
    }

    .tc-exit {
        width: 18px;
        height: 14px;
        position: absolute;
        top: 33px;
        right: 20px;
        object-fit: cover;
    }

    .main-layout-side, .main-layout-container {
        top: 80px;
        overflow-y: scroll;
        height: auto;
    }

    .main-layout-side .layui-nav {
        background: #333;
    }

    .main-layout-side .layui-nav-itemed > a {
        background: #333 !important;
    }

    .main-layout-side .layui-nav-tree .layui-nav-child .layui-this > a {
        background-color: #BC0000;
        color: #FFF;
    }

    .main-layout-body {
        top: 0;
    }

    .layui-nav-tree .layui-nav-item a {
        height: 60px;
        line-height: 60px;
        font-size: 16px;
        color: #FFF;
        font-weight: bold;
    }

    .main-layout-side .layui-nav-tree .layui-nav-child a {
        height: 60px;
        line-height: 60px;
        font-size: 16px;
        color: rgba(255, 255, 255, .4);
    }

    .layui-nav-tree .layui-nav-more {
        top: 27px;
    }

    .main-layout-side .layui-nav-tree .layui-nav-bar {
        background-color: #BC0000;
    }

    .main-layout-side::-webkit-scrollbar {
        display: none; /* Chrome Safari */
    }

    .main-layout-side {
        scrollbar-width: none; /* firefox */
        -ms-overflow-style: none; /* IE 10+ */
        overflow-x: hidden;
        overflow-y: scroll;
    }

    #not_count {
        background: red;
        border: 1px #ffffff solid;
        width: 15px;
        height: 15px;
        text-align: center;
        line-height: 15px;
        border-radius: 50%;
        display: none;
        position: absolute;
        right: -5px;
        top: -6px;
    }
</style>
<body>
<div class="main-layout" id='main-layout'>
    <div class="tc-main-top">
        <img src="{{ env('APP_IMG_URL') }}/index/logo.png" alt="logo" class="tc-logo">
        <span class="tc-system-name">重庆总工会后台管理系统</span>
        <div class="tc-userinfo" id="rightNav">
            <a style="color:#ffffff;margin-right: 15px; 10px; cursor: pointer;position: relative;"
               data-url="{{url("/admin/notificatinlist/mynot")}}" data-id="xx" data-text="我的消息">
                <img src="{{ env('APP_IMG_URL') }}/index/msg.png" alt="">
                <span id="not_count"></span>
            </a>
            <img src="{{ env('APP_IMG_URL') }}/index/user_head.png" alt="头像" class="tc-user-head">
            <span class="tc-username">{{$user['name']}}</span>
        </div>

        <a href="{{url('/admin/logout')}}">
            <img src="{{ env('APP_IMG_URL') }}/index/exit.png" alt="退出" class="tc-exit">
        </a>
    </div>
    <!--侧边栏-->
    <div class="main-layout-side">
        @include("admin.menu")
    </div>
    <!--右侧内容-->
    <div class="main-layout-container">
        <!--头部-->
    <!-- @include("admin.header") -->
        <!--主体内容-->
        <div class="main-layout-body">
            <!--tab 切换-->
            <div class="layui-tab layui-tab-brief main-layout-tab" lay-filter="tab" lay-allowClose="true">
                <ul class="layui-tab-title">
                    <li class="layui-this welcome" lay-id="index">网络评选</li>
                    @if($user['role_slug']!="enterprise")
                        <li class="welcome" lay-id="">巴渝工匠</li>
                    @endif
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src="/admin/welcome" width="100%" height="100%" id="iframe" name="iframe"
                                scrolling="auto" class="iframe" framborder="0"></iframe>
                    </div>
                    @if($user['role_slug']!="enterprise")
                        <div class="layui-tab-item layui-show">
                            <iframe src="/admin/welcomeby" width="100%" height="100%" id="iframe" name="iframe"
                                    scrolling="auto" class="iframe" framborder="0"></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--遮罩-->
    <div class="main-mask">

    </div>
</div>
<script type="text/javascript">
    {{--var scope={--}}
    {{--    link:"{{url('/admin/welcome')}}"--}}
    {{--}--}}
</script>
<script src="{{ env('APP_URL') }}/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/common.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/main.js" type="text/javascript" charset="utf-8"></script>
<script>
    function changeUserInfo() {
        layui.use(['element', 'jquery'], function () {
            var element = layui.element();
            var $ = layui.jquery;
            var mainLayout = $('#main-layout');
            var id = 13;
            var url = "{{url('/admin/userinfo')}}";
            var isActive = $('.main-layout-tab .layui-tab-title').find("li[lay-id=" + id + "]");
            console.dir(isActive)

            if (isActive.length > 0) {
                //切换到选项卡
                element.tabChange('tab', id);
            } else {
                element.tabAdd('tab', {
                    title: '个人中心',
                    content: '<iframe src="' + url + '" name="iframe' + id + '" class="iframe" framborder="0" data-id="' + id + '" scrolling="auto" width="100%"  height="100%"></iframe>',
                    id: id
                });
                element.tabChange('tab', id);

            }
            mainLayout.removeClass('hide-side');
        });
    }

    // 点击logo跳转到首页
    layui.use(['element', 'jquery', 'layer'], function () {
        var element = layui.element();
        var $ = layui.jquery;
        var layer = layui.layer;
        $('#m-logo').click(function () {
            element.tabChange('tab', 'index');
        });
        getmynnot();
        setInterval(function () {
            getmynnot();
        }, 5000);


        function getmynnot() {
            $.ajax({
                url: "{{url('/admin/notificatinlist/getmynnot')}}",
                data: {
                    '_token': '{{csrf_token()}}'
                },
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 1000) {
                        if (res.count <= 0) {
                            $("#not_count").css("display", "none");
                        } else {
                            $("#not_count").html(res.count);
                            $("#not_count").css("display", "inline-block");
                            $("#not_count").css("border", "1px #ffffff solid");

                        }

                        if (res.data.id != undefined) {
                            var index = layer.open({
                                type: 1
                                , offset: 'rb' //具体配置参考
                                , id: 'layerDemorb' //防止重复弹出
                                , content: '<div style="padding: 20px 100px;">' + res.data.title + '</div>'
                                , btn: ['查看']
                                , btnAlign: 'c' //按钮居中
                                , shade: 0 //不显示遮罩
                                , yes: function () {
                                    var iframeObj = $(window.frameElement).attr('name');
                                    var desc = "消息详情";
                                    var url = "{{url('/admin/notificatinlist/notinfo')}}/" + res.data.id;
                                    parent.page(desc, url, iframeObj, w = "700px", h = "620px");
                                    layer.close(index);
                                    return false;
                                }
                            });
                        }

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
        }

    });

</script>
</body>
</html>
