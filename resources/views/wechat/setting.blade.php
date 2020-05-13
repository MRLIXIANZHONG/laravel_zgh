@section('title', '系统设置')

<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section('content')
    <style>
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
        <form class="layui-form tc-container" action="">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">app_id</label>
                <div class="layui-input-block">
                    <input type="text" name="app_id" placeholder="请输入扩展项目地址"  value="{{$system['app_id']}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">secret</label>
                <div class="layui-input-block">
                    <input type="text" name="secret" placeholder="请输入后台域名限制地址"  value="{{$system['secret']}}" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">token</label>
                <div class="layui-input-block">
                    <textarea name="token"  placeholder="请输入系统公告"   class="layui-textarea">{{$system['token']}}</textarea>
                </div>
            </div>
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
                    url:"{{url('/admin/wechat/save')}}",
                    data:data.field,
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.code==1000) {
                            layer.msg(res.message, {shift: 6, icon: 6});
                        }else{
                            layer.msg(res.message, {time: 1000,shift: 6,icon:5});
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