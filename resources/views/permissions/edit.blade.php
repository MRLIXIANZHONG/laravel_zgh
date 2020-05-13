@section('title', '权限编辑')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">权限标识：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['slug']) ? $info['slug'] : ''}}" name="slug" required lay-verify="slug" placeholder="请输入2-12位字母" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">权限名称：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['name']) ? $info['name'] : ''}}" name="name" required lay-verify="name" placeholder="请输入2-12位汉字" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">上级所属：</label>
        <div class="layui-input-block">
            <select name="parent_id" lay-verify="required">
                <option value=""></option>
                <option value="0" {{empty($info)||(isset($info['parent_id'])&&$info['parent_id']==0||!$info['parent_id'])?'selected':''}}>顶级分类</option>
                @if(is_array($infos)&&$infos)
                    @foreach($infos as $info_child)
                        <option value="{{$info_child['id']}}" {{(isset($info['parent_id'])&&$info['parent_id'] == $info_child['id']) ? 'selected' : ''}}>{{$info_child==0?'':'├─'}}{{$info_child['title']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">权限控制：</label>
        <div class="layui-input-block">
            <textarea name="http_path" placeholder="请输入权限控制" class="layui-textarea" required lay-verify="http_path">{{!empty($info['http_path']) ? $info['http_path'] : ''}}</textarea>
            <div class="layui-form-mid layui-word-aux">格式是Controller@method<br>
                Controller为App\Http\Controllers目录下；
                method，可以是get/post，也可以是controller类的方法。</div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属角色：</label>
        <div class="layui-input-block">
            @foreach($roles as $role)
                <input type="checkbox" value="{{$role['id']}}" required {{in_array($role['id'],$rolelist)?'checked':''}} lay-filter="roles_check" name="permission_roles[]" title="{{$role['name']}}">
            @endforeach
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
            form.verify({
                permission_remark: [/[a-zA-Z]{2,12}$/, '权限标识必须2到12位字母'],
                permission_name: [/[\u4e00-\u9fa5]{2,12}$/, '权限名称必须2到12位汉字'],
                permission_desc: [/[\u4e00-\u9fa5]{2,30}$/, '权限介绍必须2到30位汉字'],
                permission_control: [/[a-zA-Z][@][a-zA-Z]{3,50}$/, '权限控制格式错误'],
            });
            form.on('submit(formDemo)', function(data) {
                var chk_value =[];
                var is_have_admin = 1;
                $('input[name="permission_roles[]"]:checked').each(function(){
                    chk_value.push($(this).val());
                    if($(this).val()==1)is_have_admin--;
                });
                if(chk_value.length==0){
                    layer.msg('至少选择一个所属角色',{shift: 6,icon:5});
                    return false;
                }
                if(is_have_admin){
                    layer.msg('必选选择超级管理员角色',{shift: 6,icon:5});
                    return false;
                }
                $.ajax({
                    url:"{{url('/admin/permission/save')}}",
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
