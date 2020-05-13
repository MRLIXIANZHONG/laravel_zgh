@section('title', '关键字编辑')
<style>
    .editbtnblue{
        color:#01AAED;
    }
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn" fresh-url="{{url('/admin/wechat/getkeylist')}}"><i class="layui-icon">&#x1002;</i></button>
    </div>

    <div class="layui-inline">
        <input type="text" value="{{ old('akey') }}" name="akey" placeholder="搜索关键字" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="is_exe" lay-filter="type" lay-verify="type">
            <option value="-1" {{ old('is_exe') ==-1? 'selected' : '' }}>请选择状态</option>
            <option value="1" {{ old('is_exe') ==1? 'selected' : '' }}>使用中</option>
            <option value="2" {{ old('is_exe') ==2? 'selected' : '' }}>已禁用</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal addBtn" data-url="{{url('/admin/wechat/edit/0')}}">添加关键字</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th>关键字</th>
            <th>回复内容类型</th>
            <th>回复标题</th>
            <th>是否使用</th>
            <th>查询类型</th>
            <th class="hidden-xs">添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td>{{$item['akey']}}</td>

                <td>

                    @if($item['reply']['msgkind']=='0')
                     文本
                     @elseif($item['reply']['msgkind']=='1')
                        图片
                    @elseif($item['reply']['msgkind']=='2')
                        视频
                    @elseif($item['reply']['msgkind']=='3')
                        声音
                    @elseif($item['reply']['msgkind']=='4')
                        图文
                    @elseif($item['reply']['msgkind']=='5')
                        文章
                    @else
                    --
                    @endif

                </td>
                <td>{{$item['reply']['title']?$item['reply']['title']:'--'}}</td>
{{--                <td>{{$item['reply']['content']?$item['reply']['content']:'--'}}</td>--}}
                <td>{{$item['is_exe']==1?'使用中':'已禁用'}}</td>
                <td>{{$item['Pptype']==1?'模糊查询':'全等查询'}}</td>
                <td class="hidden-xs">{{$item['created_at']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$item['id']}}" data-desc="修改关键词" data-url="{{url('/admin/wechat/edit/'. $item['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$item['id']}}" data-url="{{url('/admin/wechat/delete/'.$item['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>
                    </div>
                </td>
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