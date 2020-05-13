@extends('common.list')
@section('title', '历史工匠列表')

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
            <a href="{{url('/admin/history_craftsmans')}}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>
    <form action = "{{url('admin/history_craftsmans')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="{{$search['username']}}" name="username"
                   placeholder="请输入历史工匠关键字" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <select name="years" lay-filter="aihao">
                <option value=""></option>
                <option value="2016" @if($search['years'] == 2016) selected @endif>2016年度</option>
                <option value="2017" @if($search['years'] == 2017) selected @endif>2017年度</option>
                <option value="2018" @if($search['years'] == 2018) selected @endif>2018年度</option>
                <option value="2019" @if($search['years'] == 2019) selected @endif>2019年度</option>
            </select>
        </div>
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
    </form>

    @if($user['roles'][0]['id'] == 1)
        <div class="layui-inline addproduct-div" style="position: relative">
            <a href="{{ url('admin/history_craftsmans/create') }}"><div class="layui-btn layui-btn-normal">添加</div></a>
            <ul class="addproduct-ul">
                <li class="addproduct-li" type="zz" url="{{url('/admin/product/edit')}}?type=zz">转转</li>
                <li class="addproduct-li" type="xianyu" url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼</li>
            </ul>
        </div>
    @endif

    <table class="layui-table" lay-skin="nob" id="app">
        <thead>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>联系电话</th>
            <th>职业</th>
            <th>所在年份</th>
            <th>申请时间</th>
            <th>获奖状态</th>
            <th style="min-width: 150px">操作</th>
        </tr>
        </thead>
        <thbody style = "width:100%;">
            @foreach($craftsmans as $craftsman)
                <tr>
                    <td class="hidden-xs">{{$craftsman->id}}</td>
                    <td class="hidden-xs">{{$craftsman->username}}</td>
                    <td class="hidden-xs">{{$craftsman->mobile}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_name}}</td>
                    <td class="hidden-xs">{{$craftsman->years}}</td>
                    <td class="hidden-xs">{{$craftsman->created_at}}</td>
                    <td class="hidden-xs">已获奖</td>
                    <td>
                        <div class="layui-inline">
                            <a href="{{ url('/admin/history_craftsmans/'. $craftsman->id ) }}"
                               class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>详情
                            </a>
                            @if($user['roles'][0]['id'] == 1)
                                <a href="{{ url('/admin/history_craftsmans/'.$craftsman->id.'/edit') }}"
                                   class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button"
                                   class="layui-icon">
                                    <i class="layui-icon">&#xe642;</i>编辑
                                </a>
                            @endif
                            @if($user['roles'][0]['id'] == 1)
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                        @click="deleteHistoryCraftsman({{$craftsman['id']}})"
                                ><i class="layui-icon">&#xe640;</i>删除</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </thbody>
    </table>
    {!! $craftsmans->render() !!}

@endsection
@section('js')
    <script>

        let app = new Vue({
            el: "#app",
            data() {
                return {}
            },
            methods: {
                deleteHistoryCraftsman(id) {
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
                                url: "{{url('/admin/history_craftsmans')}}/" + id,
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'delete',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message, {icon: 6});
                                        window.location.reload();
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
                }
            },
        })

    </script>
@endsection
