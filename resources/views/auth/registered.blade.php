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
        <div class="m-login-warp tc-register">
            <p class="login_text">注册</p>
            <form class="layui-form" method="post" >
                {{ csrf_field() }}

                <div class="layui-form-item">
                    <input type="text" name="username"
                       id="username";
                       required lay-verify="username" placeholder="请输入账号（由字母、数字组成）" autocomplete="off"
                       class="layui-input">
                </div>

{{--                <div class="layui-form-item">--}}
{{--                    <input type="password" value="" name="password" required lay-verify="password" placeholder="请输入密码（6-20位之间）" autocomplete="off" class="layui-input">--}}
{{--                </div>--}}

                <div class="layui-form-item" style="position: relative;">
                    <input type="password" value="" name="password"  maxlength="20"  minlength="6" required lay-verify="password" placeholder="请输入密码（6-20位之间）" readonly onfocus="this.removeAttribute('readonly')" autocomplete="off" class="layui-input" id="password">
                    <img id="eye_img" onclick="hideShowPsw()" src="/static/admin/images/login/eye_icon1.png" alt="" style="position: absolute;top: 9px;right: 10px;">
                </div>

                <div class="layui-form-item" style="position: relative;">
                    <input type="password" value="" name="accpassword"  maxlength="20"  minlength="6" required lay-verify="password" placeholder="请再次输入密码（6-20位之间）" readonly onfocus="this.removeAttribute('readonly')" autocomplete="off" class="layui-input" id="accpassword">
                    <img id="eye_img1" onclick="hideShowPsw1()" src="/static/admin/images/login/eye_icon1.png" alt="" style="position: absolute;top: 9px;right: 10px;">
                </div>
{{--                <div class="layui-form-item">--}}
{{--                    <input type="password" value="" name="accpassword" required lay-verify="accpassword" placeholder="请再次输入密码（6-20位之间）" autocomplete="off" class="layui-input">--}}
{{--                </div>--}}

                <div class="layui-form-item">
                    <input type="text" value="" name="name" required lay-verify="name" placeholder="输入姓名" autocomplete="off" class="layui-input">
                </div>

                <div class="layui-form-item" style="display: flex;">
                    <input type="text" value="" id="tel" name="tel" required lay-verify="tel" placeholder="请输入手机号" autocomplete="off" class="layui-input" style="width: 60%" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="11" size="14"
                    >
                    <div class="layui-btn layui-btn-primary get-code" id="yzm">获取验证码</div>
                </div>

                <div class="layui-form-item">
                    <input type="text" value="" name="code" required lay-verify="code" placeholder="请填写验证码" autocomplete="off" class="layui-input">
                </div>

                <div class="layui-form-item">
                    <input type="text" value="" name="title" required lay-verify="title" placeholder="请输入企业名称" autocomplete="off" class="layui-input">
                </div>

                <div class="layui-form-item">
                    <select name="units_id" id="units_id" lay-verify="units_id">
                        <option value="0">请选择所属工会</option>
                        @foreach($units as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                    <!-- <div class="tc-select">
                        <div class="tc-top">
                            <span>请选择所属工会</span>
                            <img src="" alt="">
                        </div>
                        <div class="tc-bot hide">
                            <div class="tc-left">
                                <div class="tc-option-dft">
                                    <span>按首字母排序</span>
                                    <img src="" alt="">
                                </div>
                                <div class="tc-option">基层工会</div>
                            </div>
                            <div class="tc-right">
                                <div>A</div>
                                <div class="active">B</div>
                                <div>C</div>
                                <div>D</div>
                                <div>E</div>
                                <div>F</div>
                                <div>G</div>
                                <div>H</div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="layui-form-item m-login-btn" style="text-align: center">
                    <!-- {{--<div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="registered">注册</button>
                    </div>--}} -->
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="registered">注册</button>
                    </div>

                    <!-- <div class="layui-inline" style="width: 40%;margin-left: 60px">
                        <a class="layui-btn layui-btn-primary" onclick="login()" style="width: 100%">登录</a>
                    </div> -->
                    <p class="register" onclick="login()">已有账号？前去登录</p>
                </div>
            </form>
        </div>
        <!-- <p class="copyright">Copyright 2017-{{date("Y",time())}} by FZS</p> -->
    </div>
    <div class="customer_service">
        <div class="btn" onclick="show()">
            <img src="/static/admin/images/login/kefu.png" alt="" class="kefu">
            <span>联系客服</span>
        </div>
        <img src="{{env('APP_IMG_URL')}}/adminqrcode/adminqrcode.jpg" alt="" class="qrcode" style="display: none;" id="wudi">
    </div>
</div>
<script src="/static/admin/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
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

    function hideShowPsw1() {
        var demoImg = document.getElementById("eye_img1");
        var PWD = document.getElementById("accpassword");
        if (PWD.type == "password") {
            PWD.type = "text";
            demoImg.src = "/static/admin/images/login/eye_icon2.png"; //图片路径（闭眼图片）
        } else {
            PWD.type = "password";
            demoImg.src = "/static/admin/images/login/eye_icon1.png"; // 图片路径（睁眼图片）
        }
    }

    //账号正则验证（由字母、数字组成）
    $("#username").keyup(function(evt) {
        this.value = this.value.replace(/[^\w]/g, '');
    });

    layui.use(['form','jquery'], function() {
        var form = layui.form(),
            layer = layui.layer,
            $ = layui.jquery;
        form.render();
        //监听提交按钮
        form.on('submit(registered)', function(data) {

            if(!data.field.username){
                layer.msg("用户名不能为空",{shift: 6,icon:5});
                return false;
            }
            if(!data.field.password){
                layer.msg("密码不能为空",{shift: 6,icon:5});
                return false;
            }
            if(!data.field.accpassword){
                layer.msg("重复密码不能为空",{shift: 6,icon:5});
                return false;
            }

            if(!data.field.name){
                layer.msg("联系人不能为空",{shift: 6,icon:5});
                return false;
            }
            if(!data.field.tel){
                layer.msg("联系人电话不能为空",{shift: 6,icon:5});
                return false;
            }else {
                //手机号验证
                var pattern = /^1[345789]\d{9}$/;
                if (pattern.test(data.field.tel) == false) {
                    layer.msg("请输入合法手机号",{shift: 6,icon:5});
                    return false;
                }
            }
            if(!data.field.title){
                layer.msg("企业名称不能为空",{shift: 6,icon:5});
                return false;
            }
            if(data.field.units_id ==0){
                layer.msg("请选择工会",{shift: 6,icon:5});
                return false;
            }

            if(data.field.accpassword !== data.field.password){
                layer.msg("两次输入的密码不一致",{shift: 6,icon:5});
                return false;
            }


            //验证字符长度不超过20
            $("#password").blur(function () {
                if ($(this).val().length >20 || $(this).val().length<6 ) {
                    layer.msg("请输入6-20位密码",{shift: 6,icon:5});
                    $(this).val('');
                    return false;
                }
            })


            $.ajax({
                url:"{{route('register')}}",
                data:data.field,
                type:'post',
                dataType:'json',
                success:function (res) {
                    console.log(res);
                    if(res.code == 200){
                       // layer.msg(res.msg,{shift: 6,icon:6});
                        window.location.href = "{{url('/admin/login')}}"
                    }else{
                        layer.msg(res.msg,{shift: 6,icon:5});
                        return false;
                    }

                }
            })

            //阻止表单提交
            return false;

        });
    });

    function login() {
        location.href="{{url('/admin/login')}}";
    }
</script>
<script>
   $(function () {

    $('.tc-top').on('click', function(event) {
        event.stopPropagation();
        if ($('.tc-bot').hasClass('hide')) {
            $('.tc-bot').removeClass('hide');
        } else {
            $('.tc-bot').addClass('hide');
        }
    });




       var countdown=60;
       var ddclick=true;

        $("#yzm").click(function (event) {

            var tel=$("#tel").val();
            if (tel){
                //手机号验证
                var pattern = /^1[345789]\d{9}$/;
                if (pattern.test(tel) == false) {
                    layer.msg("请输入合法手机号",{shift: 6,icon:5});
                    return false;
                }else {

                    //发送验证码
                    if (ddclick){
                        console.log(11);
                        var obj=$("#yzm");
                        settime(obj,tel);
                        //发送短信
                        $.post("{{url('/admin/setsms')}}",{tel:tel,_token:"{{csrf_token()}}"},function (data) {
                            console.log(data);
                        })


                    }
                }

            }else {
                layer.msg("请输入手机号",{shift: 6,icon:5});
                return false;
            }
        })

       function settime(obj,tel) { //发送验证码倒计时

           if (countdown == 0) {

               ddclick=true;
               obj.attr('disabled',false);
               //obj.removeattr("disabled");
               obj.html("获取验证码");
               countdown = 60;
               return;
           } else {
                ddclick=false;
               obj.attr('disabled',true);
               obj.html("重新发送(" + countdown + ")");
               countdown--;
           }
           setTimeout(function() {
                   settime(obj) }
               ,1000)
       }
   });

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