@extends('common.list')
@section('title', '企业列表')

@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .layui-inline.tool-btn {width: 100%}
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh">
            <a href="{{url('/admin/organizations')}}"><i class="layui-icon" style="color: #FFF">&#x1002;</i></a></div>
    </div>
    <form action="{{url('organizations')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="@if($search['name'] != null) {{$search['name']}} @endif" name="name"
                   placeholder="请输入参赛企业关键字" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <select name="new_type" lay-filter="aihao">
                <option value=""></option>
                <option value="1" @if($search['new_type'] == 1) selected @endif>国营控股企业</option>
                <option value="2" @if($search['new_type'] == 2) selected @endif>行政机关</option>
                <option value="3" @if($search['new_type'] == 3) selected @endif>港澳台、外商投资企业</option>
                <option value="4" @if($search['new_type'] == 4) selected @endif>民营控股企业</option>
                <option value="5" @if($search['new_type'] == 5) selected @endif>事业单位</option>
                <option value="6" @if($search['new_type'] == 6) selected @endif>其他</option>
            </select>
        </div>

        @if ($role == 2)
            <div class="layui-inline">
                <select name="check_state" lay-filter="aihao">
                    <option value=""></option>
                    <option value="-1" @if($search['check_state'] == -1) selected @endif>审核驳回</option>
                    <option value="1" @if($search['check_state'] == 1) selected @endif>未审核</option>
                    <option value="2" @if($search['check_state'] == 2) selected @endif>审核通过</option>
                </select>
            </div>
        @endif

        <div class="layui-inline">
            <select name="is_competition" lay-filter="aihao">
                <option value=""></option>
                <option value="0" @if($search['is_competition'] === 0) selected @endif>非重点竞赛</option>
                <option value="1" @if($search['is_competition'] === 1) selected @endif>重点竞赛</option>
            </select>
        </div>

        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
    </form>
    <table class="layui-table" lay-skin="nob" id="app">
        <thead>
        <tr>
            <th>ID</th>
            <th>单位</th>
            <th>单位类型</th>
            <th>姓名</th>
            <th>手机</th>
            <th>上级工会名称</th>
            {{--<th>行业标签</th>--}}
            <th>审核状态</th>
            <th>审核人</th>
            <th>审核时间</th>
            <th>重点竞赛</th>
            <th style="min-width: 220px">操作</th>
        </tr>
        </thead>
        <thbody>
            @foreach($organizations as $organization)
                <tr>
                    <td class="hidden-xs">{{$organization->id}}</td>
                    <td class="hidden-xs">{{$organization->name}}</td>
                    <td class="hidden-xs">
                        @if ($organization->new_type == 1)
                            国营控股企业
                        @elseif ($organization->new_type == 2)
                            行政机关
                        @elseif ($organization->new_type == 3)
                            港澳台、外商投资企业
                        @elseif ($organization->new_type == 4)
                            民营控股企业
                        @elseif($organization->new_type == 5)
                            事业单位
                        @elseif($organization->new_type == 6)
                            其他
                        @else
                            未设置
                        @endif
                    </td>
                    <td class="hidden-xs">{{$organization['username']}}</td>
                    <td class="hidden-xs">{{$organization['mobile']}}</td>
                    <td class="hidden-xs">{{$organization->unit_id_name}}</td>
                    {{--<td class="hidden-xs">{{$organization['industry']}}</td>--}}
                    <td class="hidden-xs">
                        @if($organization->check_state === -1)
                            驳回
                        @elseif($organization->check_state === 1)
                            未审核
                        @elseif($organization->check_state === 2)
                            已审核
                        @else
                            未推送
                        @endif
                    </td>
                    <td class="hidden-xs">{{$organization->check_staff}}</td>
                    <td class="hidden-xs">{{$organization->check_time}}</td>
                    <td class="hidden-xs">
                        @if ($organization->is_competition == 1)已参与
                        @else 未参与 @endif
                    </td>
                    <td>
                        <div class="layui-inline">
                            <a href="{{ url('/admin/organizations/'. $organization['id'] ) }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>查看
                            </a>

                            @if ($role == 1 || $role == 3)
                                <a href="{{ url('/admin/organizations/'. $organization['id'] .'/edit') }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                    <i class="layui-icon">&#xe642;</i>编辑
                                </a>
                            @endif
                            @if (in_array($role, [1]))
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                    @click="deleteNominee( {{$organization['id']}} )">
                                    <i class="layui-icon">&#xe640;</i>删除
                                </button>
                            @endif

                            @if ($role == 2)
                                <button class="layui-btn layui-btn-small layui-btn-blue tips-info"
                                    @click="check('{{$organization['id']}}')" type="button">
                                    <i class="layui-icon">&#xe616;</i>通过
                                </button>
                            @endif
                            @if ($role == 2)
                                <button class="layui-btn layui-btn-small layui-btn-blue tips-info"
                                    @click="reject('{{$organization['id']}}')" type="button">
                                    <i class="layui-icon">&#x1006;</i>驳回
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </thbody>
    </table>
    <div class="page-wrap">
        {!! $organizations->render() !!}
    </div>
@endsection
@section('js')
    <script>

        let app = new Vue({
            el: "#app",
            data() {
                return {}
            },
            methods: {
                editStatus(id, field, val) {
                    layui.use('jquery', () => {
                        var $ = layui.jquery;
                        $.ajax({
                            url: "{{url('/admin/product/statusEdit')}}",
                            data: {
                                field: field,
                                id: id,
                                val: val,
                                _token: '{{csrf_token()}}'
                            },
                            type: 'post',
                            dataType: 'json',
                            success: (res) => {
                                window.location.reload()
                            }

                        })
                    })
                },
                deleteNominee(id) {
                    layer.msg('您确认要删除吗？', {
                        time: 0 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/organizations')}}/" + id,
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'delete',
                                dataType: 'json',
                                success: (res) => {
                                    layer.msg('删除成功');
                                    window.location.reload();
                                }

                            })
                        }
                    });

                },

                check(id) {
                    layer.msg('确定要审核通过吗？', {
                        //time: 3000 //不自动关闭
                        btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            //加载
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/organizations')}}/" + id + "/check",
                                data: {
                                    _token: '{{csrf_token()}}',
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload();
                                        setTimeout(function () {
                                            layer.closeAll('审核成功');
                                        }, 2000);
                                    } else {
                                        layer.msg(res.msg);
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },
                reject(id) {
                    layer.msg('确定要驳回吗？', {
                        //time: 3000 //不自动关闭
                        btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            //加载
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/organizations')}}/" + id + "/reject",
                                data: {
                                    _token: '{{csrf_token()}}',
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload();
                                        setTimeout(function () {
                                            layer.closeAll('驳回成功');
                                        }, 2000);
                                    } else {
                                        layer.msg(res.msg);
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },

            },
        })

    </script>
@endsection
