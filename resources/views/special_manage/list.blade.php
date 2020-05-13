@section('title', '专题管理')
@section('header')
<style type="text/css">
    .column-content-detail {padding-top: 15px!important;}
</style>
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/specialmanage')}}"><i
                    class="layui-icon">&#x1002;</i></div>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob">
        <thead>
        <tr>
            <th>ID</th>
            <th style="min-width: 80px">专题标题</th>
            <th style="min-width: 80px">专题描述</th>
            <th>顶部Banner</th>
            <th style="min-width: 80px">专题头像</th>
{{--            <th width="80">活动精神</th>--}}
            <th style="min-width: 80px">主办单位</th>
            <th>备案号</th>
            <th style="min-width: 80px">地址</th>
            <th>邮编</th>
            <th style="min-width: 80px">版权信息</th>
            <th style="min-width: 80px">活动类型</th>
            <th id="table_th" width="140">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($specialList as  $list)
            <tr>
                <td>{{$list['id']}}</td>
                <td>{{$list['title']}}</td>
                <td>{{$list['mark']}}</td>
                <td>
                    <div style="height: 150px;"><img style="width: 100%;height: 100%" src=" {{$list['banner']}}"/>
                    </div>
                </td>
                <td> <div style="height: 150px;"><img style="width: 100%;height: 100%" src=" {{$list['title_img']}}"/>
                    </div>
                 </td>
{{--                <td>{{$list['spirit']}}</td>--}}
                <td>{{$list['sponsor_unit']}}</td>
                <td>{{$list['record_numbe']}}</td>
                <td>{{$list['address']}}</td>
                <td>{{$list['zip_code']}}</td>
                <td>{{$list['copyright_information']}}</td>
                <td>
                    @if($list['system_version']=='cqzgh')
                        网络竞技
                    @else
                        巴渝工匠
                    @endif
                </td>
                <td>
                    <a class="layui-btn layui-btn-small layui-btn-blue" target="_self"
                       onclick="openNewsEdit('{{$list["id"]}}')"
                       data-desc="编辑"><i class="layui-icon">&#xe642;</i>编辑</a>

                </td>
            </tr>
        @endforeach
        @if(empty($specialList))
            <tr>
                <td colspan="11" style="text-align: center;color: #ff4500;">暂无数据</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$specialList->links()}}
    </div>
@endsection
@section('js')
    <script>
        function openNewsEdit(id) {
            window.location.href = '/admin/specialmanage/' + id ;
        }


        layui.use(['form', 'layer'], function () {
            var form = layui.form();
            form.render();


            $('.fresh').mouseenter(function () {
                dialog.tips('刷新页面', '.fresh');
            })
            $('.fresh').click(function () {
                $('form').submit();
            });
            $('.tips-info').mouseenter(function () {
                var msg = $(this).attr('data-info');
                dialog.tips(msg, this);
            })
        });
    </script>
@endsection
@extends('common.list')