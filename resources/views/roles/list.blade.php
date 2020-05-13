@section('title', '角色列表')
<style type="text/css">
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
        <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加权限" data-url="{{url('/admin/roles/edit/0')}}"><i class="layui-icon">&#xe654;</i></button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob">
        <colgroup>
            <col class="hidden-xs">
            <col class="hidden-xs">
            <col class="hidden-xs">
            <col>
            <col class="hidden-xs">
            <col class="hidden-xs">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">角色标识</th>
            <th class="hidden-xs">角色名称</th>
            <th class="hidden-xs">创建时间</th>
            <th class="hidden-xs">修改时间</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="hidden-xs">{{$info['id']}}</td>
                <td class="hidden-xs">{{$info['slug']}}</td>
                <td class="hidden-xs">{{$info['name']}}</td>
                <td class="hidden-xs">{{$info['created_at']}}</td>
                <td class="hidden-xs">{{$info['updated_at']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="修改角色" data-url="{{url('/admin/roles/edit/'. $info['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$info['id']}}" data-url="{{url('/admin/roles/delete/'.$info['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                laydate = layui.laydate,
                layer = layui.layer
            ;
            // laydate({istoday: true});
            form.render();
            form.on('submit(formDemo)', function(data) {
            });
        });
    </script>
@endsection
@extends('common.list')
