@section('title', '关键字编辑')
@section('content')
    <style>
        #organization_content{
            display: none;
        }

        #unit_content{
            display: none;
        }

        #changeKind video{
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 15px;
        }

        #changeKind audio{
            width: 100%;
            margin-bottom: 15px;
        }

    </style>
    <input type="hidden" value="{{!empty($info['id']) ? $info['id'] : ''}}" name="id" >
    <div class="layui-form-item">
        <label class="layui-form-label">标题：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($info['title']) ? $info['title'] : ''}}" name="title" required lay-verify="title" placeholder="请输入关键词" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否使用：</label>
        <div class="layui-input-block">
            <select name="msghide" lay-verify="required">
                <option value="0"   {{ $info['msghide'] ==0? 'selected' : '' }} >使用中 </option>
                <option value="1"   {{ $info['msghide'] ==1? 'selected' : '' }} >已禁用</option>

            </select>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">回复类型：</label>
        <div class="layui-input-block">
            <select name="msgkind" lay-verify="required" id="msgkind" lay-filter="msgkind">
                <option value="0"   {{ $info['msgkind'] ==0? 'selected' : '' }} >文本</option>
                <option value="1"   {{ $info['msgkind'] ==1? 'selected' : '' }} >图片</option>
                <option value="2"   {{ $info['msgkind'] ==2? 'selected' : '' }} >视频</option>
                <option value="3"   {{ $info['msgkind'] ==3? 'selected' : '' }} >声音</option>
                <option value="4"   {{ $info['msgkind'] ==4? 'selected' : '' }} >图文</option>
                <option value="5"   {{ $info['msgkind'] ==5? 'selected' : '' }} >文章</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">回复内容：</label>

        <div class="layui-input-block" id="changeKind">
            @if($info['msgkind'] ==0)
                <textarea class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8">{{$info['content']}}
            </textarea>
            @elseif($info['msgkind'] ==1)
                <img src="{{env('APP_URL')}}{{$info['content']}}" alt="" id="reimg">
                <button type="button" class="layui-btn layui-btn-normal" id="uploadImg">
                    上传图片
                </button>
                <input type="hidden" value="{{$info['content']}}" name="content" id="recontent">
            @elseif($info['msgkind'] ==2)
                <video src="{{$info['content_video']}}" controls="controls" id="reimg"></video>
                <button type="button" class="layui-btn layui-btn-normal" id="uploadImg" >
                    上传视频
                </button>
                <input type="hidden" value="{{$info['content']}}" name="content" id="recontent">

            @elseif($info['msgkind'] ==3)
                <audio  src="{{env('APP_URL')}}{{$info['content']}}" controls="controls" id="reimg"></audio >
                <button type="button" class="layui-btn layui-btn-normal" id="uploadImg">
                    上传音频
                </button>
                <input type="hidden" value="{{$info['content']}}" name="content" id="recontent">
            @elseif($info['msgkind'] ==4)
                <img src="{{env('APP_URL')}}{{$info['content_img']}}" alt="" id="reimg">
                <button type="button" class="layui-btn layui-btn-normal" id="uploadImg">
                    上传图片
                </button>
                <input type="hidden" value="{{$info['content_img']}}" name="content_img" id="recontent">
                <input type="text" value="{{$info['content_url']}}" name="content_url" class="layui-input" style="margin-top: 10px" placeholder="跳转链接">
                <textarea style="margin-top:15px; " class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8">{{$info['content']}}
                </textarea>
            @elseif($info['msgkind'] ==5)
                <textarea class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8">{{$info['content']}}
                </textarea>
            @else
                <textarea class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8">
                </textarea>
            @endif
        </div>
    </div>

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
                {{$info['updated_at']?$info['updated_at']:'--'}}
            </div>
        </div>
    @endif
    <div style="height: 50px; clear: both"></div>

@endsection
@section('id',$id)
@section('js')
    <script>

        function changemsgkind(obj){
            alert($(obj).val());
        }

        layui.use(['form','jquery','laypage','layer','upload'], function() {
            var form = layui.form,
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;
            var upload = layui.upload;

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

            var uploadInst = upload.render({
                elem: '#uploadImg' //绑定元素
                ,url: '/index.php/admin/wechat/adminwechatupload?_token={{csrf_token()}}' //上传接口
                ,exts: 'jpg|png|gif|mp4|wmv|avi|aac|amr|ape|flac|m4r|mmf|mp2|mp3|ogg|ogv'//只允许上传压缩文件
                ,done: function(res){
                    //上传完毕回调
                    if(res.code==1000){
                        layer.msg(res.message,{shift: 6});
                        $("#reimg").attr('src','{{env('APP_URL')}}'+res.url);
                        $("#recontent").attr('value',res.url);

                    }else{
                        layer.msg(res.message,{shift: 6,icon:5});
                    }

                }
                ,error: function(){
                    //请求异常回调

                    layer.msg('上传失败', {time: 1000});
                }
            });

            form.on('select(msgkind)', function(data){

                if(data.value==0){
                    $("#changeKind").html('<textarea class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8"></textarea>');
                    form.render();
                }else if(data.value==1){
                    $("#changeKind").html('<img src="" alt="" id="reimg">' +
                        '<input type="hidden" value="" name="content" id="recontent">'+
                        '<button type="button" class="layui-btn layui-btn-normal" id="uploadImg">' +
                        '上传图片' +
                        '</button>');
                    form.render();

                }else if(data.value==2){
                    $("#changeKind").html(
                        '<video  src="" alt="" id="reimg" controls="controls"></video>' +
                        '<input type="hidden" value="" name="content" id="recontent">'+
                        '<button type="button" class="layui-btn layui-btn-normal" id="uploadImg">' +
                        '上传视频' +
                        '</button>');
                    form.render();
                }else if(data.value==3){
                    $("#changeKind").html('<audio  src="" id="reimg" controls="controls"></audio >' +
                        '<input type="hidden" value="" name="content" id="recontent">'+
                        '<button type="button" class="layui-btn layui-btn-normal" id="uploadImg">' +
                        '上传音频' +
                        '</button>');
                    form.render();
                }else if(data.value==4){

                    $("#changeKind").html('  <img src="" alt="" id="reimg"><button type="button" class="layui-btn layui-btn-normal" id="uploadImg">'+
                        '上传图片'+
                        '</button>'+
                        '<input type="hidden" value="" name="content_img" id="recontent">'+
                        ' <input type="text" value="" name="content_url" class="layui-input" style="margin-top: 10px" placeholder="跳转链接" >'+
                        '<textarea style="margin-top:15px; " name="content" class="layui-textarea"  id="" cols="30" rows="8" name="content">'+
                        '</textarea>');
                    form.render();
                }else if(data.value==5){

                    $("#changeKind").html(' <textarea class="layui-textarea" name="content" lay-verify="required" cols="30" rows="8"></textarea>');
                    form.render();
                }

                var uploadInst = upload.render({
                    elem: '#uploadImg' //绑定元素
                    ,url: '/index.php/admin/wechat/adminwechatupload?_token={{csrf_token()}}' //上传接口
                    ,exts: 'jpg|png|gif|mp4|wmv|avi|aac|amr|ape|flac|m4r|mmf|mp2|mp3|ogg|ogv'//只允许上传压缩文件
                    ,done: function(res){
                        //上传完毕回调
                        console.log(res);

                        if(res.code==1000){
                            layer.msg(res.message,{shift: 6});
                            $("#reimg").attr('src','{{env('APP_URL')}}'+res.url);
                            $("#recontent").attr('value',res.url);
                        }else{
                            layer.msg(res.message,{shift: 6,icon:5});
                        }

                    }
                    ,error: function(){
                        //请求异常回调

                        layer.msg('上传失败', {time: 1000});
                    }
                });
            });



            form.on('submit(formDemo)', function() {
                $.ajax({
                    url:"{{url('/admin/wechat/replysave')}}",
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