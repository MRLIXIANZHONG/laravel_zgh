@section('title', '系统设置')


@section('content')
    <style>
        .main{
            padding:20px 10px;
        }
        .header_title{
            background-color: #1E9FFF;
            color: #FFFFFF;
            text-align: center;
            height:42px;
            line-height: 42px;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
        }
        .layui-form-radio i:hover, .layui-form-radioed i{
            color: #1E9FFF;
        }
        .layui-form-label{
            width: 100px;
        }
        .layui-input-block{
            margin-left: 150px;
        }
        .paddingnone{
            width: calc(100% - 5px);
            text-align: left;
            padding:9px 0;
            word-break: break-all; /*英文或数字换行显示*/
        }

    </style>
<body>
    <div class="main">

        <div class="header_title">修改商户信息</div>
        <form class="layui-form" action="">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">当前在线人数</label>
                <div class="layui-input-block">
                    <label class="layui-form-label paddingnone" >{{$onlineCount}}</label>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">当前在线人数</label>
                <div class="layui-input-block">
                    <label class="layui-form-label paddingnone" >{{$onlineUser}}</label>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">到期用户的数量</label>
                <div class="layui-input-block">
                    <label class="layui-form-label paddingnone" >{{$outtimeCount}}</label>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">到期用户的数量</label>
                <div class="layui-input-block">
                    <label class="layui-form-label paddingnone" >
                        {{$outtimeList}}
                    </label>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否开放注册</label>
                <div class="layui-input-block">
                    <input type="radio" name="register" value="1" title="开放" {{$system['is_reg'] == 1 ? "checked" :""}}>
                    <input type="radio" name="register" value="0" title="关闭" {{$system['is_reg'] == 0 ? "checked" :""}}>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开启一键采集</label>
                <div class="layui-input-block">
                    <input type="radio" name="collection" value="1" title="开放" {{$system['is_collec'] == 1 ? "checked" :""}}>
                    <input type="radio" name="collection" value="0" title="关闭" {{$system['is_collec'] == 0 ? "checked" :""}}>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">扩展项目地址</label>
                <div class="layui-input-block">
                    <input type="text" name="productAddress" placeholder="请输入扩展项目地址"  value="{{$system['productAddress']}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">后台域名限制</label>
                <div class="layui-input-block">
                    <input type="text" name="admin_domain" placeholder="请输入后台域名限制地址"  value="{{$system['admin_domain']}}" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">允许浏览器访问</label>
                <div class="layui-input-block">
                    <input type="radio" name="Visit" value="1" title="开放" {{$system['is_visit'] == 1 ? "checked" :""}}>
                    <input type="radio" name="Visit" value="0" title="关闭" {{$system['is_visit'] == 0 ? "checked" :""}}>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">系统公告</label>
                <div class="layui-input-block">
                    <textarea name="SystemBulletin"  placeholder="请输入系统公告"   class="layui-textarea">{{$system['system_bulletin']}}</textarea>
                </div>
            </div>
{{--            <div class="layui-form-item">--}}
{{--                <label class="layui-form-label">ip限制</label>--}}
{{--                <div class="layui-input-block">--}}
{{--                    <input type="radio" name="ip_limit" value="1" title="开启" {{$system['is_ip_limit'] == 1 ? "checked" :""}}>--}}
{{--                    <input type="radio" name="ip_limit" value="0" title="关闭" {{$system['is_ip_limit'] == 0 ? "checked" :""}}>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="layui-form-item layui-form-text">--}}
{{--                <label class="layui-form-label">可访问ip</label>--}}
{{--                <div class="layui-input-block">--}}
{{--                    <textarea name="ipLimitWord" placeholder="请输入可访问ip" class="layui-textarea">{{$system['ipLimit_word']}}</textarea>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</body>
@endsection

@section('js')
    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form();
            $ = layui.jquery;
            form.render();
            //监听提交
            form.on('submit(formDemo)', function(data){
//                layer.msg(JSON.stringify(data.field));
                $.ajax({
                    url:"{{url('/admin/system/edit')}}",
                    data:data.field,
                    type:'post',
                    dataType:'json',
                    success:function(res){
                       layer.msg(res.msg,{shift: 6,icon:6});
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000,shift: 6,icon:5});
                    }
                });




                return false;
            });
        });
    </script>
@endsection
@extends('common.common')