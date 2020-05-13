<style>
    .scrollBox{
        height:30px;
        width: 100%;
        /*padding-bottom: 20px;*/
        line-height: 30px;
    }
    .xx_icon{
        width: 18px;height: 18px; border-radius: 50%; line-height: 18px; text-align: center; background: red;color:#fff;display: inline-block;font-size: 10px
    }
</style>
<div class="scrollBox">
    <marquee behavior="scroll" onMouseOut="this.start()" onMouseOver="this.stop()" scrollamount="10" width="100%" loop="-1">公告：新系统上线了！</marquee>
</div>
<div class="main-layout-header">

    <div class="menu-btn" id="hideBtn">
        <a href="javascript:;">
            <span class="iconfont">&#xe60e;</span>
        </a>

    </div>
    <ul class="layui-nav" lay-filter="rightNav">
        <li class="layui-nav-item">
            <div class="hidden-xs" data-desc="消息" style="padding: 0 10px; cursor: pointer"><a style="color:#c2c2c2" data-url="{{url("/admin/notificatinlist/mynot")}}" data-id="xx" data-text="我的消息"><i class="layui-icon ">&#xe645;</i> 消息

                </a></div>
        </li>
        <li class="layui-nav-item">
            <div class="hidden-xs" data-desc="管理员信息" style="padding: 0 10px;">&nbsp;欢迎登陆！{{$user['login_ip']}} <i class="layui-icon">&#xe612;</i>&nbsp;{{$user['name']}}&nbsp;({{$user['role_name']}})</div>
        </li>
        <li class="layui-nav-item"><a href="{{url('/admin/logout')}}">退出</a></li>
    </ul>
</div>