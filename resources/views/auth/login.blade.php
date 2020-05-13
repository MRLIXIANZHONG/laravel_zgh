<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>后台登录</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/login.css" />
</head>
<body>
<div class="m-login-bg">
    <div class="m-login">
        <div class="logo"></div>
        <div class="m-login-warp tc-login">
            <p class="login_text">登录</p>
            <form class="layui-form" method="post" action="{{url('/admin/login')}}">
                {{ csrf_field() }}
                <div class="layui-form-item">
                    <input type="text" value="{{ old('username') }}" name="username" required lay-verify="username" placeholder="请输入账号/手机号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-item" style="position: relative;">
                    <input type="password" value="" name="password" required lay-verify="password" placeholder="请输入密码（6-20位之间）" readonly onfocus="this.removeAttribute('readonly')" autocomplete="off" class="layui-input" id="password">
                    <img id="eye_img" onclick="hideShowPsw()" src="/static/admin/images/login/eye_icon1.png" alt="" style="position: absolute;top: 9px;right: 10px;">
                </div>
                <div class="layui-form-item" style="display: flex;">
                    <input style="width: 310px;margin-right: 20px" type="text" value="" name="loginCode" lay-verify="loginCode"  placeholder="请输入验证码" autocomplete="off" class="layui-input">
                   {{-- <img src="/static/admin/images/login/img_code.png" alt="" class="img_code">--}}
                    <img src="{{route('getCaptcha')}}" alt="" class="img_code" id="img_code" style="cursor: pointer;">
                </div>
                <div class="layui-form-item">

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="layui-form-mid layui-word-aux" style="color: red;">{{ $error }}</div>
                        @endforeach
                    @endif

                </div>
                <div class="layui-form-item m-login-btn">
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="login">登录</button>
                    </div>
                    <p class="register" onclick="reg()">没有账号？立即注册</p>
                </div>
            </form>
        </div>
        <!-- <p class="copyright">Copyright 2017-{{date("Y",time())}} by WCJ</p> -->
    </div>
    <div class="customer_service">
        <div class="btn" onclick="show()">
            <img src="/static/admin/images/login/kefu.png" alt="" class="kefu">
            <span>联系客服</span>
        </div>
        <img src="{{env('APP_IMG_URL')}}/adminqrcode/adminqrcode.jpg" alt="" class="qrcode" style="display: none;" id="wudi">
    </div>
</div>
<script src="/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>

<script>
function hideShowPsw() {
    var demoImg = document.getElementById("eye_img");
    var PWD = document.getElementById("password");
    if (PWD.type == "password") {
        PWD.type = "text";
        demoImg.src = "/static/admin/images/login/eye_icon2.png"; //图片路径（闭眼图片）
    } else {
        PWD.type = "password";
        demoImg.src = "/static/admin/images/login/eye_icon1.png"; // 图片路径（睁眼图片）
    }
}

    layui.use(['form','jquery'], function() {
    var form = layui.form(),
        layer = layui.layer,
        $ = layui.jquery;
        form.render();
    //监听提交按钮
    form.on('submit(login)', function(data) {

        if(!data.field.username){
            layer.msg("请填写用户名",{shift: 6,icon:5});
            return false;
        }
        if(!data.field.password){
            layer.msg("请输入密码",{shift: 6,icon:5});
            return false;
        }
        if(!data.field.loginCode){
            layer.msg("请填写验证码",{shift: 6,icon:5});
            return false;
        }


    });
});

    //获取验证码
    var img=document.getElementById('img_code');
    img.addEventListener('click',function () {
        this.setAttribute('src','/admin/getCaptcha?s='+Math.random());
    },false);
    

    function reg() {
        location.href="{{url('/admin/register')}}";
    }

    function show() {
        if (document.getElementById('wudi').style.display === 'block') {
            document.getElementById('wudi').style.display='none';
        } else {
            document.getElementById('wudi').style.display='block';
        }
    }

</script>
</body>

</html>