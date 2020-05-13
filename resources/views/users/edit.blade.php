@section('title', '用户编辑')
@section('content')
    <style>
        #organization_content{
            display: none;
        }

        #unit_content{
            display: none;
        }
    </style>
    <div class="layui-form-item">
        <label class="layui-form-label">用户名：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['username']) ? $info['username'] : ''}}" name="username" required lay-verify="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">昵称/单位名称/工会名称：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['name']) ? $info['name'] : ''}}" name="name" required lay-verify="name" placeholder="请输入昵称/单位名称/工会名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">角色：</label>
        <div class="layui-input-block">
            @if(isset($info)&&$info)
            <select name="role_id" lay-verify="required">
                @foreach($roles as $role)
                    @if($role['id']== $info['roles'][0]['id'])
                    <option value="{{ $role['id'] }}">{{ $role['name'] }} </option>
                    @endif
                @endforeach
            </select>
            @else
            <select name="role_id" lay-verify="required">
                <option value="0"></option>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}
                    </option>
                @endforeach
            </select>
            @endif
        </div>
    </div>

    @if((isset($info['organization'])&&$info['organization'])||(isset($info['unit'])&&$info['unit']))
        <div class="layui-form-item" >
                <label class="layui-form-label">手机号码：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{$info['organization']?$info['organization']['mobile']:$info['unit']['mobile']}}" name="mobile" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
                </div>
        </div>
    @else
        <div class="layui-form-item" >
            <label class="layui-form-label">手机号码：</label>
            <div class="layui-input-block">
                <input type="number" value="" name="mobile" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
            </div>
        </div>
    @endif





    <div class="layui-form-item">
        <label class="layui-form-label">密码：</label>
        <div class="layui-input-block">
            <input type="password" name="password" lay-verify="pwd" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认密码：</label>
        <div class="layui-input-block">
            <input type="password" name="password_confirmation" lay-verify="pwd_confirmation" placeholder="请确认密码" autocomplete="off" class="layui-input">
        </div>
    </div>


@endsection
@section('id',$id)
@section('js')
    <script>
        layui.use(['form','jquery','laypage', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;



            var laydate = layui.laydate

            laydate.render({
                elem:"#outtime",
                type:"datetime",
                value:"{{isset($info['outtime']) && $info['outtime'] ? $info['outtime'] : ''}}"
            })




            form.verify({
                // user_name: [/^[a-zA-Z]{2,12}$/, '用户名必须2到12位字母'],
                // pwd:function(value){
                //     if(value&&!/^(?!([a-zA-Z]+|\d+)$)[a-zA-Z\d]{6,12}$/.test(value)){
                //         return '密码必须6到12位数字加字母';
                //     }
                // },
                pwd_confirmation: function(value) {
                    if($("input[name='password']").val() && $("input[name='password']").val() != value) {
                        return '两次输入密码不一致';
                    }
                },
            });


            form.on('submit(formDemo)', function(data) {
                $.ajax({
                    url:"{{url('/admin/adminuser/save')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 1000){
                            layer.msg(res.message,{icon:6});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout('parent.layer.close('+index+')',2000);
                        }else{
                            layer.msg(res.message,{shift: 6,icon:5});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection
@extends('common.edit')