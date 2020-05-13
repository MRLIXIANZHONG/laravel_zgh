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
    </style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh">
            <a href="{{url('/admin/craftsmans')}}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>
    <form action = "{{url('admin/craftsmans')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="{{$search['username']}}" name="username"
                   placeholder="请输入候选工匠关键字" autocomplete="off"
                   class="layui-input">
        </div>

        <div class="layui-inline">
            <select name="is_craftsman" lay-filter="aihao">
                <option value=""></option>
                <option value="0" @if($search['is_craftsman'] === 0) selected @endif>未推选</option>
                <option value="1" @if($search['is_craftsman'] === 1) selected @endif>候选工匠</option>
                <option value="2" @if($search['is_craftsman'] === 2) selected @endif>巴渝工匠</option>
            </select>
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

    <div class="layui-inline addproduct-div" style="position: relative">
        <a href="{{ url('admin/craftsmans/create') }}"><div class="layui-btn layui-btn-normal">添加</div></a>
        <ul class="addproduct-ul">
            <li class="addproduct-li" type="zz" url="{{url('/admin/product/edit')}}?type=zz">转转</li>
            <li class="addproduct-li" type="xianyu" url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼</li>
        </ul>
    </div>

    <table class="layui-table" lay-even lay-skin="nob" id="app">

        <thead>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            {{--<th>头像</th>--}}
            <th>联系电话</th>
            <th style="min-width: 40px">工会</th>
            <th style="min-width: 40px">单位</th>
            <th style="min-width: 80px">单位审核人</th>
            <th style="min-width: 80px">工会审核人</th>
            <th style="min-width: 40px">状态</th>
            <th style="min-width: 60px">申报时间</th>
            <th style="min-width: 45px">点赞数</th>
            <th style="min-width: 45px">浏览量</th>
            <th style="min-width: 45px">投票数</th>
            <th style="min-width: 60px">获奖状态</th>
            <th style="min-width: 150px">操作</th>
        </tr>
        </thead>
        <thbody>
            @foreach($craftsmans as $craftsman)
                <tr>
                    <td class="hidden-xs">{{$craftsman->id}}</td>
                    <td class="hidden-xs">{{$craftsman->username}}</td>
                    {{--<td class="hidden-xs"><img src="{{$craftsman->photo}}" /></td>--}}
                    <td class="hidden-xs">{{$craftsman->mobile}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_check}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_check}}</td>
                    <td class="hidden-xs">{{$craftsman->check_status_name}}</td>
                    <td class="hidden-xs">{{$craftsman->created_at}}</td>
                    <td class="hidden-xs">{{$craftsman->super_star}}</td>
                    <td class="hidden-xs">{{$craftsman->super_browse}}</td>
                    <td class="hidden-xs">@if($craftsman->score === 0)未投票@else{{$craftsman->score}}@endif</td>
                    <td class="hidden-xs">@if($craftsman->is_craftsman == 2)获奖 @else 未获奖 @endif</td>
                    <td>
                        <div class="layui-inline">

                            <a href="{{ url('/admin/craftsmans/'. $craftsman->id ) }}"
                               class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>详情
                            </a>

                            <a href="{{ url('/admin/craftsmans/'. $craftsman->id .'/edit') }}"
                               class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe642;</i>修改
                            </a>

                            <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                    @click="deleteCraftsman( {{$craftsman['id']}} )"
                            >
                                <i class="layui-icon">&#xe640;</i>删除
                            </button>

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
                                url: "{{url('/admin/craftsmans')}}/" + id,
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
            },
        })

    </script>
@endsection
