@section('title', '消息详情')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">消息标题：</label>
        <div class="layui-input-block">
            <input type="text" readonly value="{{!empty($info['title']) ? $info['title'] : ''}}" name="title" id="slug" required lay-verify="role_title" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">内容：</label>
        <div class="layui-input-block">
            <textarea readonly name="content" class="layui-textarea" id="" cols="30" rows="10">{{!empty($info['content']) ? $info['content'] : ''}}</textarea>
        </div>
    </div>
    @if($info)
    <div class="layui-form-item">
        <label class="layui-form-label">发布人：</label>
        <div class="layui-input-block" style="line-height: 36px;">
            {{$info['users']['username']}}
        </div>
    </div>
    @endif
    <div class="layui-form-item">
        <label class="layui-form-label">发送对象：</label>
        <div class="layui-input-block">
            <input type="checkbox" name="" lay-skin="primary" lay-filter="pAllChoose" title="全选">
        </div>
        <div class="layui-input-block permission">
            <div id="test12" class="demo-tree-more"></div>
        </div>


    </div>
@endsection
@section('id',$id)
@section('js')
    <script>
        layui.use(['form','jquery','laypage', 'layer','tree','util'], function() {
            var tree = layui.tree ,
                layer = layui.layer,
                util = layui.util;

            var form = layui.form,
                $ = layui.jquery;

            var id=0;
            @if(isset($info['id']))
                id={{$info['id']}};
            @endif
            $.ajax({
                url:"{{url('/admin/notificatinlist/getadminuserlist/'.$id)}}",
                data: {
                    'id':id,
                    '_token':'{{csrf_token()}}'
                },
                type:'post',
                dataType:'json',
                success:function(res){
                    if(res.code == 1000){
                        var data =res.data;
                        //基本演示
                        tree.render({
                            elem: '#test12'
                            ,data: data
                            ,showCheckbox: true  //是否显示复选框
                            ,id: 'demoId1'
                            ,isJump: true //是否允许点击节点时弹出新窗口跳转
                        });

                    }else{
                        layer.msg(res.message,{shift: 6,icon:5});
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
            form.on('checkbox(pAllChoose)', function(data) {
                var child = $(".permission").find('input[type="checkbox"]');
                child.each(function(index, item) {
                    item.checked = data.elem.checked;
                });
                if(data.elem.checked)$(this).attr('title','全不选');
                else $(this).attr('title','全选');
                form.render('checkbox');
            });

            form.render();
            var layer = layui.layer;
            form.verify({
                role_desc: [/[a-zA-Z]{2,12}$/, '角色描述必须2到12位字母'],
                role_remark: [/[a-zA-Z]{2,12}$/, '角色标识必须2到12位字母'],
                role_name: [/[\u4e00-\u9fa5]{2,12}$/, '角色名称2到12位汉字'],
                role_desc: [/[\u4e00-\u9fa5]{2,30}$/, '角色描述2到30位汉字'],
            });
            form.on('submit(formDemo)', function(data) {
                var chk_value =[];
                $('input[name="permission_list[]"]:checked').each(function(){
                    chk_value.push($(this).val());
                });


                var checkedData = tree.getChecked('demoId1'); //获取选中节点的数据
                var pdata=[];
                for (var i=0;checkedData.length>i;i++){
                    pdata.push(checkedData[i]['id']);
                }

                var pdatas=JSON.stringify(pdata);

                $.ajax({
                    url:"{{url('/admin/notificatinlist/sendmsg')}}",
                    data:{
                        'toarray':pdatas,
                        'id':id,
                        '_token':'{{csrf_token()}}'
                    },
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
@extends('common.smsedits')
