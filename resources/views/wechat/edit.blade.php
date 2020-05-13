@section('title', '关键字编辑')
@section('content')
    <style>
        #organization_content{
            display: none;
        }

        #unit_content{
            display: none;
        }
    </style>
    <input type="hidden" value="{{!empty($info['id']) ? $info['id'] : ''}}" name="id" >
    <div class="layui-form-item">
        <label class="layui-form-label">关键词：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['akey']) ? $info['akey'] : ''}}" name="akey" required lay-verify="username" placeholder="请输入关键词" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否使用：</label>
        <div class="layui-input-block">
            <select name="is_exe" lay-verify="required">
                    <option value="1"   {{ $info['is_exe'] ==1? 'selected' : '' }} >使用中 </option>
                    <option value="2"   {{ $info['is_exe'] ==2? 'selected' : '' }} >已禁用</option>

            </select>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">查询类型：</label>
        <div class="layui-input-block">
            <select name="Pptype" lay-verify="required">

                <option value="0"   {{ $info['Pptype'] ==0? 'selected' : '' }} >全等查询</option>
                <option value="1"   {{ $info['Pptype'] ==1? 'selected' : '' }} >模糊查询 </option>

            </select>
        </div>
    </div>
    @if($reply)
    {{--<div class="layui-form-item">--}}
        {{--<label class="layui-form-label">回复类型：</label>--}}
        {{--<div class="layui-input-block" style="line-height: 36px;">--}}
            {{--@if($info['reply']['msgkind']==0)--}}
                {{--文本--}}
            {{--@elseif($info['reply']['msgkind']==1)--}}
                {{--图片--}}
            {{--@elseif($info['reply']['msgkind']==2)--}}
                {{--视频--}}
            {{--@elseif($info['reply']['msgkind']==3)--}}
                {{--声音--}}
            {{--@elseif($info['reply']['msgkind']==4)--}}
                {{--图文--}}
            {{--@elseif($info['reply']['msgkind']==5)--}}
                {{--文章--}}
            {{--@else--}}
                {{------}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}


    <div class="layui-form-item">
        <label class="layui-form-label">回复内容：</label>

        <div class="layui-input-block">
            <select name="kid" lay-verify="required">
                <option value="-1"  >选择回复内容</option>
                @foreach($reply as $replyitem)
                    <option value="{{$replyitem['id']}}"   {{ $replyitem['id'] ==$info['kid']? 'selected' : '' }} >{{$replyitem['title']}}
                        @if($replyitem['msgkind']==0)
                            (文本)
                        @elseif($replyitem['msgkind']==1)
                            (图片)
                        @elseif($replyitem['msgkind']==2)
                            (视频)
                        @elseif($replyitem['msgkind']==3)
                            (声音)
                        @elseif($replyitem['msgkind']==4)
                            (图文)
                        @elseif($replyitem['msgkind']==5)
                            (文章)
                        @else
                            --
                        @endif</option>
                @endforeach

            </select>
        </div>
    </div>
    @else
        <div class="layui-form-item">
            <label class="layui-form-label">回复内容：</label>
            <div class="layui-input-block" style="line-height: 36px;">
                <a class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-desc="添加回复内容"  onclick="openChangeRply({{$info['kid']}})">还没有回复，去添加回复</a>
            </div>
        </div>
    @endif
    @if($info)
        <div class="layui-form-item">
            <label class="layui-form-label">创建时间：</label>
            <div class="layui-input-block" style="line-height: 36px;">
                {{$info['created_at']?$info['created_at']:'--'}}
            </div>
        </div>
    @endif


    @if($info)
        <div class="layui-form-item">
            <label class="layui-form-label">修改时间：</label>
            <div class="layui-input-block" style="line-height: 36px;">
                {{$info['update_time']?$info['update_time']:'--'}}
            </div>
        </div>
    @endif
    <div style="height: 50px; clear: both"></div>

@endsection
@section('id',$id)
@section('js')
    <script>



        layui.use(['form','jquery','laypage', 'layer'], function() {
            var form = layui.form,
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;

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


            form.on('submit(formDemo)', function() {
                $.ajax({
                    url:"{{url('/admin/wechat/keysave')}}",
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