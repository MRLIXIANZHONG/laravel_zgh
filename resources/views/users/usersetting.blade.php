@section('title', '用户配置')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">自定义域名：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$user['domain']}}" name="domain" placeholder="请输入自定域名" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">转转商品:</label>
        <div class="layui-input-block">
            <input type="radio" name="is_zhuanzhuan" value="1" title="是"
                @if($user->is_zhuanzhuan == 1)
                checked
                @endif
            >
            <input type="radio" name="is_zhuanzhuan" value="0" title="否"
               @if($user->is_zhuanzhuan == 0)
               checked
               @endif
            >
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">游戏商品:</label>
        <div class="layui-input-block">
            <input type="radio" name="is_game" value="1" title="是"
                   @if($user->is_game == 1)
                   checked
                    @endif>
            <input type="radio" name="is_game" value="0" title="否"
                   @if($user->is_game == 0)
                   checked
                    @endif>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">闲鱼商品:</label>
        <div class="layui-input-block">
            <input type="radio" name="is_xianyu" value="1" title="是"
                   @if($user->is_xianyu == 1)
                   checked
                    @endif>
            <input type="radio" name="is_xianyu" value="0" title="否"
                   @if($user->is_xianyu == 0)
                   checked
                    @endif>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">淘宝商品:</label>
        <div class="layui-input-block">
            <input type="radio" name="is_taobao" value="1" title="是"
                   @if($user->is_taobao == 1)
                   checked
                    @endif>
            <input type="radio" name="is_taobao" value="0" title="否"
                   @if($user->is_taobao == 0)
                   checked
                    @endif>
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">转转价格上限：</label>
        <div class="layui-input-block">
            <input type="number" value="{{$user->zhuanzhuan_price}}" name="zhuanzhuan_price" required lay-verify="required" placeholder="请输入转转价格上限" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">游戏价格上限：</label>
        <div class="layui-input-block">
            <input type="number" value="{{$user->game_price}}" name="game_price" required lay-verify="required" placeholder="请输入游戏价格上限" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">闲鱼价格上限：</label>
        <div class="layui-input-block">
            <input type="number" value="{{$user->xianyu_price}}" name="xianyu_price" required lay-verify="required" placeholder="请输入闲鱼价格上限" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">淘宝价格上限：</label>
        <div class="layui-input-block">
            <input type="number" value="{{$user->taobao_price}}" name="taobao_price" required lay-verify="required" placeholder="请输入淘宝价格上限" autocomplete="off" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">过期时间：</label>
        <div class="layui-input-block">
            <input type="text" id="outtime" value="" readonly name="outtime" required lay-verify="required" class="layui-input">
        </div>
    </div>

@endsection
@section('id',$id)
@section('js')
    <script>
        layui.use(['form','jquery','laypage', 'layer','laydate'], function() {
            var form = layui.form(),
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;

            var laydate = layui.laydate
            laydate.render({
                elem:"#outtime",
                type:"datetime",
                value:'{{$user->outtime}}'
            })

            form.on('submit(formDemo)', function(data) {
                $.ajax({
                    url:"{{url('/admin/saveUserSetting')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.status == 1){
                            layer.msg(res.msg,{icon:6});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout('parent.layer.close('+index+')',2000);
                        }else{
                            layer.msg(res.msg,{shift: 6,icon:5});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            })
        });
    </script>
@endsection
@extends('common.edit')