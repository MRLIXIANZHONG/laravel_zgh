@section('title', '微信粉丝列表')
<style>
    .editbtnblue{
        color:#01AAED;
    }
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn" fresh-url="{{url('/admin/wechat/wxuserplylist')}}"><i class="layui-icon">&#x1002;</i></button>
    </div>

    <div class="layui-inline">
        <input type="text" value="{{ old('nickname') }}" name="nickname" placeholder="搜索昵称" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">

        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th>头像</th>
            <th>Openid</th>
            <th>昵称</th>
            <th>性别</th>
            <th>是否关注</th>
            <th class="hidden-xs">添加时间</th>
{{--            <th>操作</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td><img style="border-radius: 50%;width: 50px;height: 50px;" src="{{$item['headimgurl']}}" alt=""></td>
                <td>{{$item['openid']}}</td>
                <td>{{$item['nickname']}} </td>
                <td>{{$item['sex']==1?'男':'女'}}</td>
                <td>{{$item['isdel']==1?'已关注':'未关注'}}</td>
                <td class="hidden-xs">{{$item['created_at']}}</td>
{{--                <td>--}}
{{--                    <div class="layui-inline">--}}
{{--                        <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$item['id']}}" data-desc="查看详情" data-url="{{url('/admin/wechat/edit/'. $item['id'])}}"><i class="layui-icon">&#xe642;</i></button>--}}

{{--                    </div>--}}
{{--                </td>--}}
            </tr>
        @endforeach
        @if(empty($list))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$list->links()}}
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
                    form.on('submit(formDemoxx)', function(data) {
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