@section('title', '商品列表')
<style>
    .editbtnblue{
        color:#01AAED;
    }
</style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/system/cardView')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="" name="num" placeholder="多少个卡密" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <input type="text" value="" name="daynum" placeholder="多少天" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">添加</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="80">
            <col width="100">
            <col width="80">
            <col width="80">
            <col width="100">
            <col class="hidden-xs" width="200">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">用户ID</th>
            <th>卡密</th>
            <th>天数</th>
            <th>是否使用</th>
            <th>使用时间</th>
            <th class="hidden-xs">添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td class="hidden-xs">{{$item['user_id']}}</td>
                <td>{{$item['token']}}</td>
                <td>{{$item['daynum']}}</td>
                <td>{{$statusFormat[$item['status']]}}</td>
                <td>{{$item['usetime']}}</td>
                <td class="hidden-xs">{{$item['created_at']}}</td>
                <td><a href="#">删除</a></td>
            </tr>
        @endforeach
        @if(empty($list))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$listObj->render()}}
    </div>
@endsection
@section('js')
    <script>
        let app = new Vue({
            el:"#app",
            data(){
                return {

                }
            },
            methods:{

            },
            created(){
                layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {
                    var form = layui.form(),
                        $ = layui.jquery;
                    form.render();
                    var layer = layui.layer;

                    var laydate = layui.laydate
                    form.on('submit(formDemo)', function(data) {
                        $.ajax({
                            url:"{{url('/admin/setting/saveCard')}}",
                            data:$('form').serialize(),
                            type:'post',
                            dataType:'json',
                            success:function(res){
                                if(res.status == 1){
                                   window.location.reload()
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

                    $('.fresh').click(function() {
                        window.location.reload()
                    });
                });



            }
        })

    </script>
@endsection
@extends('common.list')