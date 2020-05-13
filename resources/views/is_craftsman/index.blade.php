@extends('common.list')
@section('title', '工匠列表')

@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <style>
        .editbtnblue {
            color: #01AAED;
        }

        .addproduct-ul {
            width: 100%;
            height: 50px;
            text-align: center;
            position: absolute;
            display: none;
        }

        .addproduct-li {
            /*border: 1px solid #cccccc;*/
            height: 30px;
            line-height: 30px;
            background-color: #1E9FFF;
            color: white;
            white-space: nowrap;
            text-align: center;
            font-size: 14px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            opacity: .9;
            border-top: 1px solid white;
        }
        .layui-inline.tool-btn {width: 100%}
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh">
            <a href="{{url('/admin/is_craftsmans')}}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>
    {{--<div class="layui-inline">--}}
    {{--<input type="text" value="{{$nomineedto->getStaffName()}}" name="staff_name" placeholder="请输入参赛员工关键字"--}}
    {{--autocomplete="off" class="layui-input">--}}

    {{--</div>--}}
    <form action = "{{url('admin/is_craftsmans')}}" method="get">
        <div class="layui-inline">
            <select name="unit_id" lay-filter="aihao">
                <option value="">请选择基层工会</option>
                @foreach($allUnit as $unit)
                    <option value="{{$unit->id}}" @if($unit->id === $search['unit_id']) selected @endif>{{$unit->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="layui-inline">
            <input type="text" value="{{$search['username']}}" name="username"
                   placeholder="请输入候选工匠关键字" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <input type="text" value="{{$search['mobile']}}" name="mobile"
                   placeholder="请输入联系电话" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
    </form>

    @if(in_array($role, [1,4]))
        <div class="layui-inline">
            <a href="{{url('admin/is_craftsmans/export')}}" style="display: inline-block;width: 64px; height: 38px;line-height: 38px;background-color: #BC0000;text-align: center; color: #ffffff;">导出</a>
        </div>
    @endif

    <table class="layui-table" lay-skin="nob" id="app">
        <thead>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>联系电话</th>
            <th>工会</th>
            <th>单位</th>
            <th style="min-width: 75px">单位审核人</th>
            <th style="min-width: 75px">工会审核人</th>
            <th>职位</th>
            <th>状态</th>
            <th style="min-width: 60px">申报时间</th>
            <th style="min-width: 45px">点赞数</th>
            <th style="min-width: 45px">浏览量</th>
            <th style="min-width: 45px">投票数</th>
            <th style="min-width: 60px">获奖状态</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <thbody>
            @foreach($craftsmans as $craftsman)
                <tr>
                    <td class="hidden-xs">{{$craftsman->id}}</td>
                    <td class="hidden-xs">{{$craftsman->username}}</td>
                    <td class="hidden-xs">{{$craftsman->mobile}}</td>
                    <td class="hidden-xs" style="width: 100px;">{{$craftsman->unit_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_check}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_check}}</td>
                    <td class="hidden-xs" style="width: 150px;">{{$craftsman->unit_name}}</td>
                    <td class="hidden-xs">{{$craftsman->check_status_name}}</td>
                    <td class="hidden-xs">{{$craftsman->created_at}}</td>
                    <td class="hidden-xs">{{$craftsman->super_star}}</td>
                    <td class="hidden-xs">{{$craftsman->super_browse}}</td>
                    <td class="hidden-xs">@if($craftsman->score === 0)未投票@else{{$craftsman->score}}@endif</td>
                    <td class="hidden-xs">@if($craftsman->is_craftsman == 2)获奖 @else 未获奖 @endif</td>
                    <td>
                        <div class="layui-inline">
                            <a href="{{ url('/admin/is_craftsmans/'. $craftsman->id ) }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>详情</a>
                            @if($role === 1)
                                <a href="{{ url('/admin/is_craftsmans/'. $craftsman->id .'/edit') }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                    <i class="layui-icon">&#xe642;</i>编辑</a>
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn" @click="deleteCraftsman({{$craftsman['id']}})">
                                    <i class="layui-icon">&#xe640;</i>删除</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </thbody>
    </table>
    {!! $craftsmans->render() !!}
    {{--<div class="page-wrap">--}}
    {{--        <label class="text-center no-padding no-margin">{{$nominesslist->total()}}条</label>--}}
    {{--{{ $nominesslist->appends(['staff_name'=>$nomineedto->getStaffName(),--}}
    {{--'organization_name'=>$nomineedto->getOrganizationName(),--}}
    {{--'kind'=>$nomineedto->getKind(),--}}

    {{--])->render() }}--}}
    {{--</div>--}}
@endsection
@section('js')
    <script>

        let app = new Vue({
            el: "#app",
            data() {
                return {}
            },
            methods: {
                editStatus(id,field,val){
                    layui.use('jquery',()=>{
                        var $ = layui.jquery;
                        $.ajax({
                            url:"{{url('/admin/product/statusEdit')}}",
                            data:{
                                field:field,
                                id:id,
                                val:val,
                                _token:'{{csrf_token()}}'
                            },
                            type:'post',
                            dataType:'json',
                            success:(res) => {
                                window.location.reload()
                            }

                        })
                    })
                },
                deleteCraftsman(id) {
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
                                url: "{{url('/admin/is_craftsmans')}}/" + id,
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'delete',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message, {icon: 6}, function () {
                                            window.location.reload();
                                        });
                                    } else {
                                        layer.msg(res.message, {shift: 6, icon: 5});
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });

                },
                check(id) {
                    layer.msg('您确认要审核吗？', {
                        time: 0 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/candidate_craftsmans')}}/" + id + "/check",
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: function (res) {
                                    if (res.code == 1000) {
                                        layer.msg(res.message, {icon: 6}, function () {
                                            window.location.reload();
                                        });
                                    } else {
                                        layer.msg(res.message, {shift: 6, icon: 5});
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
                    layer.msg('您确认要驳回吗？', {
                        time: 0 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/candidate_craftsmans')}}/" + id + "/reject",
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: function (res) {
                                    if (res.code == 1000) {
                                        layer.msg(res.message, {icon: 6}, function () {
                                            window.location.reload();
                                        });
                                    } else {
                                        layer.msg(res.message, {shift: 6, icon: 5});
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }
                            })
                        }
                    });
                },
                set_craftsman(id) {
                    layer.msg('您确认要评选为工匠吗？', {
                        time: 0 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/candidate_craftsmans')}}/" + id + "/set_craftsman",
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: function (res) {
                                    if (res.code == 1000) {
                                        layer.msg(res.message, {icon: 6}, function () {
                                            window.location.reload();
                                        });
                                    } else {
                                        layer.msg(res.message, {shift: 6, icon: 5});
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
