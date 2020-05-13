@section('title', '云竞技管理')
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/rloudlive')}}"><i
                    class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{ $search->getTitle() }}" name="title"
               placeholder="请输入关键字" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="type" lay-filter="type" lay-verify="type">
            <option value="0">请选择竞技类型</option>
            <option value="1" {{ $search->getType()  ==1? 'selected' : '' }}>直播</option>
            <option value="2" {{ $search->getType() ==2 ? 'selected' : '' }}>录播</option>
            <option value="3" {{ $search->getType() ==3 ? 'selected' : '' }}>回放</option>
            <option value="4" {{ $search->getType() ==4 ? 'selected' : '' }}>竞赛视频</option>
        </select>
    </div>
    <div class="layui-inline">
        <select name="check_state" lay-filter="type" lay-verify="type">
            <option value="0">请选择审核类型</option>
            <option value="2" {{ $search->getCheckState()  ==2? 'selected' : '' }}>未审核</option>
            <option value="1" {{ $search->getCheckState() ==1 ? 'selected' : '' }}>已审核</option>
        </select>
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        <a class="layui-btn layui-btn-normal" href="{{url('/admin/rloudlive/0')}}" target="_self"
           data-desc="云竞技添加"><i
                    class="layui-icon">&#xe654;</i></a>
        <button class="layui-btn layui-btn-normal" onclick="exportExcel()" type="button">导出</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob">

        <thead>
        <tr>
            <th width="80">ID</th>
            <th width="80">竞技类型</th>
            <th>标题</th>
            {{--            <th>所属工会</th>--}}
            {{--            <th>所属企业</th>--}}
            <th width="200">所属行业</th>
            <th width="200">封面</th>
            <th width="80">审核状态</th>
            <th id="table_th" width="240">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rloudLive as $list)
            <tr>
                <td>{{$list['id']}}</td>
                <td class="hidden-xs">
                    @if($list['type']=='1')
                        直播
                    @elseif($list['type']=='2')
                        录播
                    @elseif($list['type']=='3')
                        回放
                    @elseif($list['type']=='4')
                        竞赛视频
                    @endif
                </td>
                <td class="hidden-xs">{{$list['title']}}</td>
                {{--                <td class="hidden-xs">{{$list['units_name']}}</td>--}}
                {{--                <td class="hidden-xs">{{$list['organizations_name']}}</td>--}}
                <td class="hidden-xs">{{$list['industry_name']}}</td>
                <td class="hidden-xs">
                    <div style="height: 100px;"><img style="width: 100%;height: 100%" src=" {{$list['img_url']}}"/>
                    </div>
                </td>
                <td class="hidden-xs">
                    @if($list['check_state']==1)
                        审核通过
                    @elseif($list['check_state']==0)
                        未审核
                    @endif
                </td>
                <td class="hidden-xs">
                    {{--                    <a class="layui-btn layui-btn-small layui-btn-blue "--}}
                    {{--                       href="{{url('/admin/rloudlive/')}}/{{$list['id']}}" target="_self"><i--}}
                    {{--                                class="layui-icon">&#xe642;</i> 编辑--}}
                    {{--                    </a>--}}
                    <button data-info="竞技详情" class="layui-btn layui-btn-small  layui-btn-blue revokeBtn tips-info"
                            onclick="openDetail('{{$list['id']}}',{{$list['check_state']}})"
                            data-desc=""><i
                                class="layui-icon">&#xe642;</i>编辑
                    </button>
                    @if ($admininfo['role_slug']=='adminunion')
                        <button class="layui-btn layui-btn-small layui-btn-normal delBtn"
                                onclick="checkRolud('{{$list['id']}}','{{$list['check_state']}}')"><i
                                    class="layui-icon">&#xe618;</i> 审核/撤销
                        </button>
                    @endif
                    <button class="layui-btn layui-btn-small layui-btn-normal delBtn"
                            onclick="delRolud('{{$list['id']}}')"><i
                                class="layui-icon">&#xe640;</i> 删除
                    </button>
                    <button data-info="竞技详情" class="layui-btn layui-btn-small  layui-btn-blue revokeBtn tips-info"
                            onclick="openDetail('{{$list['id']}}')"
                            data-desc=""><i
                                class="layui-icon">&#xe60a;</i>详情
                    </button>
                </td>
            </tr>
        @endforeach
        @if(empty($rloudLive))
            <tr>
                <td colspan="6" style="text-align: center;color: #ff4500;">暂无数据</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{ $rloudLive->appends(['title'=>$search->getTitle(),
                                  'type'=>$search->getType()
                                  ])->render() }}
    </div>
@endsection
@section('js')
    <script>
        // window.onpageshow = function (event) {
        //     if (event.persisted || window.performance && window.performance.navigation.type == 2) {
        //         $('.fresh').click();
        //         return;
        //     }
        // }

        //导出
        function exportExcel() {
            var title = $('input[name="title"]').val();
            var type = $('select[name="type"]').val();
            window.location.href = '/admin/rloudlive?exportExcel=1&title=' + title + '&type=' + type;
        }

        //打开详情页
        function openDetail(id, state) {
            if (state != undefined) {
                if (state==1){
                    layer.msg('已审核的云竞技不允许编辑。');
                    return false;
                }
                window.location.href = "/admin/rloudlive/" + id;
            } else {
                window.location.href = "/admin/rloudlive/detail/" + id;
            }
        }

        //删除
        function delRolud(id, state) {

            layer.confirm('确定删除吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/rloudlive/destroy')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
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


        //审核
        function checkRolud(id, state) {
            let title = state == 0 ? '审核' : '撤销审核';
            layer.confirm('确定' + title + '吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/rloudlive/check')}}",
                    data: {id: id, check_state: (state == 0 ? 1 : 0), _token: '{{csrf_token()}}'},
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

            $('.fresh').click(function () {

                $('form').submit();
            });
        });

    </script>
@endsection
@extends('common.list')