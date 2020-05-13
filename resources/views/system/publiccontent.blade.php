@section('title', '公告栏')


@section('content')
    <style>
        .edit_box{
            padding:20px;
        }
        .edit_btn{
            margin-top: 20px;
        }
    </style>
    <body>
        <div class="edit_box">
            <form class="layui-form" action="">
                {{ csrf_field() }}
                <textarea id="demo" style="display: none;">{{$content}}</textarea>
                <div class="layui-form-item edit_btn">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formEdit">修改公告</button>
                </div>
            </form>

        </div>
    </body>
@endsection

@section('js')
    <script>
        layui.use('layedit', function(){
            var form = layui.form();
            $ = layui.jquery;
            form.render();
            var layedit = layui.layedit;
            var edits = layedit.build('demo',{
                height:400
            }); //建立编辑器



            //监听提交
            form.on('submit(formEdit)', function(data){

                $.ajax({
                    url:"{{url('/admin/system/publiccontent/edit')}}",
                    data:{
                        editword: layedit.getContent(edits),
                        _token:data.field['_token']
                    },
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.status){
                            layer.msg(res.msg,{shift: 6,icon:6});
                        }else{
                            layer.msg(res.msg,{shift: 6,icon:5});
                        }
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