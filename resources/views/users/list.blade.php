@section('title', '用户列表')
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
        <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加用户" data-url="{{url('/admin/adminuser/edit/0')}}"><i class="layui-icon">&#xe654;</i></button>
    </div>
@endsection
@section('table')
<style type="text/css">
    .layui-inline.tool-btn {width: 100%}
        .column-content-detail {padding-top: 15px!important;}
</style>
    <table class="layui-table layui-form layui-border-box layui-table-view" lay-skin="nob">
        <colgroup>
            <col class="">
            <col class="hidden-xs">
            <col class="">
            <col class="hidden-xs">
            <col class="hidden-xs">
            <col class="">
        </colgroup>
        <thead>
        <tr>
            <th class="">ID</th>
            <th class="">用户名</th>
            <th class="hidden-xs">名称</th>
            <th class="hidden-xs">用户角色</th>
            <th class="hidden-xs">企业名称</th>
            <th class="hidden-xs">所属工会</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="">{{$info['id']}}</td>
                <td class="">{{$info['username']}}</td>
                <td class="hidden-xs">{{!empty($info['name']) ? $info['name'] : ''}}</td>
                <td class="hidden-xs">{{!empty($info['roles'][0]['name']) ? $info['roles'][0]['name'] : '已删除'}}</td>
                <td class="hidden-xs">{{!empty($info['organization']['name']) ? $info['organization']['name'] : '--'}}</td>
                <td class="hidden-xs">{{!empty($info['unit']['name']) ? $info['unit']['name'] : '--'}}</td>
                <td>
                    <div class="layui-inline">

                            <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="修改用户" data-url="{{url('/admin/adminuser/edit/'. $info['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>

                        @if($info['id'] != $user['id'])
                            <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$info['id']}}" data-url="{{url('/admin/adminuser/delete/'.$info['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>
                        @endif

{{--                            <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$info['id']}}" data-desc="配置用户" data-url="{{url('/admin/usersetting/' .  $info['id'])}}">配置用户</button>--}}

                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $pageObj->links() }}

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