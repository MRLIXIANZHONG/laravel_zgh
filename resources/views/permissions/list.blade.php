@section('title', '权限列表')
<style type="text/css">
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
        <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加菜单" data-url="{{url('/admin/permission/edit/0')}}"><i class="layui-icon">&#xe654;</i></button>
        <div class="layui-btn layui-btn-small layui-btn-normal zkBtn" data-title="展开菜单"><i class="layui-icon">&#xe602;</i></div>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob">
        <colgroup>
            <col width="50">
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="100">
            <col class="hidden-xs" width="100">
            <col>
            <col width="130">
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">名称</th>
            <th class="hidden-xs">标识</th>
            <th>权限控制</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $branch)
            <tr id='node-{{$branch['id']}}' class="parent collapsed">
                <td><input type="checkbox" name="" lay-skin="primary" data-id="{{$branch['id']}}"></td>
                <td class="hidden-xs">{{$branch['id']}}</td>
                <td class="hidden-xs">{{$branch['title']}}</td>
                <td class="hidden-xs">{{$branch['slug']}}</td>
                <td>{{$branch['http_path']}}
                    @if(!empty($branch['children']))
                    <a class="layui-btn layui-btn-mini layui-btn-blue showSubBtn" data-id='{{$branch['id']}}'>+</a>
                    @endif
                </td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$branch['id']}}" data-url="{{url('/admin/permission/edit/'. $branch['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$branch['id']}}" data-url="{{url('/admin/permission/delete/'.$branch['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>
                    </div>
                </td>
            </tr>
            @if(isset($branch['children']))
                @foreach ($branch['children'] as $child_branch)
                    <tr id='node-{{$branch['id']}}' class="child-node-{{$branch['id']}} parent collapsed" style="display:none ;" parentid="{{$branch['id']}}">
                        <td><input type="checkbox" name="" lay-skin="primary" data-id="{{$child_branch['id']}}"></td>
                        <td class="hidden-xs">{{$child_branch['id']}}</td>
                        <td class="hidden-xs">{{$child_branch['title']}}</td>
                        <td class="hidden-xs">{{$child_branch['slug']}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─{{$child_branch['http_path']}}</td>
                        <td>
                            <div class="layui-inline">
                                <button class="layui-btn layui-btn-small layui-btn-blue edit-btn" data-id="{{$child_branch['id']}}"  data-desc="修改菜单" data-url="{{url('/admin/permission/edit/'. $child_branch['id'])}}"><i class="layui-icon">&#xe642;</i>编辑</button>
                                <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$child_branch['id']}}" data-url="{{url('/admin/permission/delete/'.$child_branch['id'])}}"><i class="layui-icon">&#xe640;</i>删除</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
@endsection
@section('js')
    <script>
        layui.use(['jquery'], function() {
            var $=layui.jquery;
            //栏目展示隐藏
            $('.showSubBtn').on('click', function() {
                var _this = $(this);
                var id = _this.attr('data-id');
                var parent = _this.parents('.parent');
                var child = $('.child-node-' + id);
                var childAll = $('tr[parentid=' + id + ']');
                if(parent.hasClass('collapsed')) {
                    _this.html('-');
                    parent.addClass('expanded').removeClass('collapsed');
                    child.css('display', '');
                } else {
                    _this.html('+');
                    parent.addClass('collapsed').removeClass('expanded');
                    child.css('display', 'none');
                    childAll.addClass('collapsed').removeClass('expanded').css('display', 'none');
                    childAll.find('.showSubBtn').html('+');
                }
            });
            $('.zkBtn').click(function() {
                if($(this).attr('data-title')=='展开菜单'){
                    $(this).attr('data-title','收缩菜单');
                    $(this).html('<i class="layui-icon">&#xe61a;</i>');
                    $('.showSubBtn').html('-');
                    $('tr').css('display','');
                }else{
                    $(this).attr('data-title','展开菜单');
                    $(this).html('<i class="layui-icon">&#xe602;</i>');
                    $('.showSubBtn').html('+');
                    $("[parentid]").css('display','none');
                }
            }).mouseenter(function() {
                layer.tips($(this).attr('data-title'), $(this),{tips: [3, '#40455C']});
            })
        });
    </script>
@endsection
@extends('common.list')
