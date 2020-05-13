@section('title', 'banner管理')
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/banner')}}"><i
                    class="layui-icon">&#x1002;</i></div>
    </div>

    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal" data-width="800px" href="{{url('/admin/banner/0')}}" target="_self"
                data-desc="banner添加"><i
                    class="layui-icon">&#xe654;</i></a>

    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden">
            <col width="80">
            <col width="120">
            <col width="120">
        </colgroup>
        <thead>
        <tr>
            <th style="display: none">ID</th>
            <th width="80">是否使用</th>
            <th width="120">图片</th>

            <th id="table_th" width="180">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bannerList as $list)
            <tr>
                <td style="display: none;">{{$list['id']}}</td>
                <td class="hidden-xs">
                    @if($list['is_use']=='1')
                        <i style="cursor:pointer;" onclick="showHome('{{$list['id']}}','{{$list['check_state']}}')"
                           class="layui-icon">&#xe643;</i>
                    @else
                        <i style="cursor:pointer;" onclick="showHome('{{$list['id']}}','{{$list['check_state']}}')"
                           class="layui-icon">&#xe63f;</i>
                    @endif
                </td>
                <td class="hidden-xs">
                    <img src="{{$list['img_url']}}" style="height: 200px">
                </td>

                <td class="hidden-xs">
                    <a class="layui-btn layui-btn-small layui-btn-normal "
                            href="{{url('/admin/banner/')}}/{{$list['id']}}" target="_self"><i
                                class="layui-icon">&#xe642;</i> 编辑
                    </a>
                    <button data-info="删除" class="layui-btn layui-btn-small layui-btn-normal delBtn tips-info"
                            onclick="delBanner('{{$list['id']}}','{{$list['is_use']}}')"><i
                                class="layui-icon">&#xe640;</i> 删除
                    </button>

            </tr>
        @endforeach
        @if(empty($bannerList))
            <tr>
                <td colspan="11" style="text-align: center;color: #ff4500;">暂无数据</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$bannerList->links()}}
    </div>
@endsection
@section('js')
    <script>
        //删除
        function delBanner(id, isuse) {
            if (isuse == 1) {
                layer.open({
                    icon: 5,
                    content: '使用中的不允许删除',
                    yes: function (index, layero) {
                        layer.close(index); //如果设定了yes回调，需进行手工关闭
                    }
                });
                return false;

            }
            layer.confirm('确定删除吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/banner/destroy')}}",
                    data: {id: id},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });
        }

        //推送首页
        function showHome(id, state) {
            if (state == 1) {
                layer.open({
                    icon: 5,
                    content: '该banner 已经在使用中了',
                    yes: function (index, layero) {
                        layer.close(index); //如果设定了yes回调，需进行手工关闭
                    }
                });
                return false;
            }
            layer.confirm('确认操作吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/banner/update')}}",
                    data: {id: id},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });
        }


        layui.use(['form', 'jquery', 'laydate', 'layer', 'dialog'], function () {
            var form = layui.form(),
                $ = layui.jquery,
                dialog = layui.dialog,
                layer = layui.layer
            ;
            form.render();
            var laydate = layui.laydate
            var dateOptions = {elem: '#begin', festival: true, istoday: true};
            laydate.render(dateOptions)
            // laydate({istoday: true});
            $('.fresh').mouseenter(function () {
                dialog.tips('刷新页面', '.fresh');
            })
            form.verify({
                title: function (value) {

                },
                status: function (value) {

                },
            });
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