@section('title', '消息详情')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">消息标题：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['title']) ? $info['title'] : ''}}" name="title" required  autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">内容：</label>
        <div class="layui-input-block">
            <textarea name="content"  class="layui-textarea" id="" cols="30" rows="10">{{!empty($info['content']) ? $info['content'] : ''}}</textarea>
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
{{--    <div class="layui-form-item">--}}
{{--        <label class="layui-form-label">发送对象：</label>--}}
{{--        <div class="layui-input-block">--}}
{{--            <input type="checkbox" name="" lay-skin="primary" lay-filter="pAllChoose" title="全选">--}}
{{--        </div>--}}
{{--        <div class="layui-input-block permission">--}}
{{--            <div id="test12" class="demo-tree-more"></div>--}}
{{--        </div>--}}


{{--    </div>--}}
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
            form.on('submit(formDemo)', function(data) {

                $.ajax({
                    url:"{{url('/admin/notificatinlist/save')}}",
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
@extends('common.edits')
