@section('title', '消息列表')
@section('header')
<style type="text/css">
    .column-content-detail {padding-top: 15px!important;}
</style>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{ old('title') }}" name="title"
               placeholder="请输入消息标题" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="status" lay-filter="type" lay-verify="type">
            <option value="-1" {{ old('status') =='-1'? 'selected' : '' }}>请选择状态</option>
            <option value="1" {{ old('status') ==1? 'selected' : '' }}>未发布</option>
            <option value="2" {{ old('status') ==2? 'selected' : '' }}>已发布</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal addBtn" data-desc="" data-url="{{url('/admin/notificatinlist/edit/0')}}"><i class="layui-icon">&#xe654;</i>添加消息</button>
    </div>
@endsection
@section('table')

    <table class="layui-table layui-form layui-border-box layui-table-view" lay-skin="nob">
        <thead>
        <tr>
            <th class="">ID</th>
            <th class="">消息标题</th>
            <th class="hidden-xs">发布人</th>
            <th class="hidden-xs">状态</th>
            <th class="hidden-xs">创建时间</th>
            <th class="hidden-xs">发布时间</th>
            <th class="hidden-xs">已发布</th>
            <th class="hidden-xs">已读数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="">{{$info['id']}}</td>
                <td class="">{{$info['title']}}</td>
                <td class="hidden-xs">{{$info['users']['username']}}</td>
                @if($info['status']==1)
                    <td class="hidden-xs">未发布</td>
                @elseif($info['status']==2)
                    <td class="hidden-xs">已发布</td>
                @else
                    <td class="hidden-xs">已删除</td>
                 @endif
                <td class="hidden-xs">{{$info['created_at'] ? $info['created_at'] : '--'}}</td>
                <td class="hidden-xs">{{$info['send_at'] ? $info['send_at'] : '--'}}</td>
                <td class="hidden-xs">{{$info['notifications_count']}}</td>
                <td class="hidden-xs">{{$info['read_notifications_count']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="发送消息" data-url="{{url('/admin/notificatinlist/smsedit/'.$info['id'])}}"><i class="layui-icon">&#xe609;</i>发送消息</button>
                        @if($info['status']==1)
                        <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="修改消息" data-url="{{url('/admin/notificatinlist/edit/'.$info['id'])}}"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$info['id']}}" data-url="{{url('/admin/adminuser/delete/'.$info['id'])}}"><i class="layui-icon">&#xe640;</i></button>
                        @elseif($info['status']==2)
                            <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="查看已读" data-url="{{url('/admin/notificatinlist/readlist/'.$info['id'])}}"><i class="layui-icon">&#xe615;</i>查看已读</button>
                        @endif
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $list->links() }}

@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                laydate = layui.laydate,
                layer = layui.layer
            ;
            form.render();
            form.on('submit(formDemo)', function(data) {
                console.log(data);
            });
        });
    </script>
@endsection
@extends('common.list')