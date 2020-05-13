@section('title', '关键字回复编辑')
<style>
    .editbtnblue{
        color:#01AAED;
    }
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
        <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加关键字回复" data-url="{{url('/admin/wechat/replyedit/0')}}"><i class="layui-icon">&#xe654;</i></button>
    </div>

    <div class="layui-inline">
        <input type="text" value="{{ old('title') }}" name="title" placeholder="搜索关键字" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        {{--0:文本、1:图片、2:视频、3:声音、4:图文、5:文章--}}
        <select name="msgkind" lay-filter="type" lay-verify="type">
            <option value="0" {{ old('msgkind') ==0? 'selected' : '' }}>请选择状态</option>
            <option value="1" {{ old('msgkind') ==1? 'selected' : '' }}>文本</option>
            <option value="2" {{ old('msgkind') ==2? 'selected' : '' }}>图片</option>
            <option value="3" {{ old('msgkind') ==3? 'selected' : '' }}>视频</option>
            <option value="4" {{ old('msgkind') ==4? 'selected' : '' }}>声音</option>
            <option value="5" {{ old('msgkind') ==5? 'selected' : '' }}>图文</option>
            <option value="6" {{ old('msgkind') ==6? 'selected' : '' }}>文章</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
{{--        <colgroup>--}}
{{--            <col class="hidden-xs" width="50">--}}
{{--            <col class="hidden-xs" width="80">--}}
{{--            <col width="100">--}}
{{--            <col width="80">--}}
{{--            <col width="80">--}}
{{--            <col width="100">--}}
{{--            <col class="hidden-xs" width="200">--}}
{{--            <col width="100">--}}
{{--        </colgroup>--}}
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th>回复标题</th>
            <th>回复内容类型</th>
            <th>点击数</th>
            <th>是否隐藏</th>
            <th>回复内容</th>
            <th>排序</th>
            <th>添加时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td>{{$item['title']}}</td>
                <td>
                    @if($item['msgkind']=='0')
                        文本
                    @elseif($item['msgkind']=='1')
                        图片
                    @elseif($item['msgkind']=='2')
                        视频
                    @elseif($item['msgkind']=='3')
                        声音
                    @elseif($item['msgkind']=='4')
                        图文
                    @elseif($item['msgkind']=='5')
                        文章
                    @else
                        --
                    @endif

                </td>
                <td>{{$item['msghit']?$item['msghit']:'0'}}</td>
                <td>{{$item['msghide']==0?'显示':'隐藏'}}</td>
                <td>
                    @if($item['msgkind']=='0')
                        {{$item['content']?$item['content']:'--'}}
                    @elseif($item['msgkind']=='1')
                        <img src="{{$item['content']?$item['content']:'--'}}" alt="">
                    @elseif($item['msgkind']=='2')
                        <vide src="{{env('APP_URL')}}{{$item['content']?$item['content']:'--'}}"  controls="controls"></vide>
                    @elseif($item['msgkind']=='3')
                        <audio  src="{{env('APP_URL')}}{{$item['content']}}" controls="controls" ></audio >
                    @elseif($item['msgkind']=='4')
                        {{$item['content']?$item['content']:'--'}}
                    @elseif($item['msgkind']=='5')
                        {{$item['content']?$item['content']:'--'}}
                    @else
                        --
                    @endif
                </td>
                <td>{{$item['view_lev']}}</td>
                <td >{{$item['created_at']}}</td>
                <td >{{$item['updated_at']}}</td>
                <td>
                    <div class="layui-inline">
                     <button  class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$item['id']}}" data-url="{{url('/admin/wechat/replyedit/'. $item['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>
                    </div>
                {{--<button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$item['id']}}" data-url="{{url('/admin/wechat/delete/'.$item['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>--}}
                {{--</td>--}}
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