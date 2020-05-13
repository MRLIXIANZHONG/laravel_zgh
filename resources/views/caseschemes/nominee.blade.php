@extends('common.list')
@section('title', '五小评审管理')

@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <style>
        #table-list td{
            padding: 9px 10px;
        }
        .layui-inline.tool-btn {width: 100%}
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')

    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/caseschemes/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <select name="type">
            <option value="1" @if($caseSchemesdto->getType()==1) selected @endif>月度之星</option>
            <option value="2" @if($caseSchemesdto->getType()==2) selected @endif>季度之星</option>
            <option value="3" @if($caseSchemesdto->getType()==3) selected @endif>年度之星</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <table class="layui-table" lay-skin="nob" id="table-list">

        <thead>
        <tr>
            <th>标题</th>
            <th>唯一代码</th>
            <th>类型</th>
            <th>申报时间</th>
            <th>评选时间</th>
            <th>申报人数</th>
            <th>获奖人数</th>
            <th style="width: 140px">操作</th>
        </tr>
        </thead>
        <thbody>
            @if(!empty($nominesslist))
            <tr>
                <td colspan="17" style="text-align: center;color: #ff4500;">暂无数据</td>
            </tr>
        @else
            @foreach($caseSchemesList as $info)
                <tr>
                    <td class="hidden-xs">{{$info['title']}}</td>
                    <td class="hidden-xs">{{$info['code']}}</td>
                    <td class="hidden-xs">
                        {{$info->caseSchemeType['name']}}
                    </td>
                    <td class="hidden-xs">{{$info['qy_stime']?date("Y-m-d",strtotime($info['qy_stime'])):''}}
                        --{{$info['qy_etime']?date("Y-m-d",strtotime($info['qy_etime'])):''}}</td>
                    <td class="hidden-xs">{{$info['gh_stime']?date("Y-m-d",strtotime($info['gh_stime'])):''}}
                        --{{$info['gh_etime']?date("Y-m-d",strtotime($info['gh_etime'])):''}}</td>

                    @switch($caseSchemesdto->getType())
                        @case(1)
                        <td class="hidden-xs">{{$info['nominees_count']}}</td>
                        <td class="hidden-xs">{{$info['nomineeswin_count']}}</td>
                        @break
                        @case(2)
                        <td class="hidden-xs">{{$info['nomineesquart_count']}}</td>
                        <td class="hidden-xs">{{$info['nomineesquartwin_count']}}</td>
                        @break
                        @case(3)
                        <td class="hidden-xs">{{$info['nomineesyear_count']}}</td>
                        <td class="hidden-xs">{{$info['nomineesyeartwin_count']}}</td>
                        @break
                    @endswitch
                    <td>
                        <div class="layui-inline add-div">
                            <a class="layui-btn layui-btn-small layui-btn-blue" target="_self" href="{{url('/admin/caseschemes/detail/'.$info['id'])}}"><i class="layui-icon">&#xe615;</i>详情</a>
                            <a class="layui-btn layui-btn-small layui-btn-blue" target="_self" href="{{url('/admin/nominees/index/?case_scheme_id='.$info['id'])}}&&class_list=6">
                                <i class="layui-icon">&#xe615;</i>申报详情</a>
                            <a class="layui-btn layui-btn-small layui-btn-blue" target="_self" href="{{url('/admin/nominees/index/?case_scheme_id='.$info['id'])}}&&is_win=1">
                                <i class="layui-icon">&#xe615;</i>获奖详情</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </thbody>
    </table>
@endsection
@section('js')
    <script>

        let app = new Vue({
            el: "#table-list",
            data() {
                return {}
            },
            methods: {
                deleteCaseSchemes(id) {
                    layer.msg('您确认要删除吗？', {
                            time: 0,//不自动关闭
                            btn: ['确认', '取消'], //按钮
                            yes: function (index) {
                                layer.close(index);
                                layer.load(2);
                                setTimeout(function () {
                                    layer.closeAll('loading');
                                }, 2000);
                                $.ajax({
                                    url: "{{url('/admin/caseschemes/destroy')}}/" + id,
                                    data: {
                                        _token: '{{csrf_token()}}'
                                    },
                                    type: 'post',
                                    dataType: 'json',
                                    success: (res) => {
                                        if (res.code == 1000) {
                                            layer.msg(res.message);
                                            let index = parent.layer.getFrameIndex(window.name);
                                            setTimeout('parent.layer.close(' + index + ')', 2000);
                                            window.location.reload()
                                        } else {
                                            layer.msg(res.message);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.msg('网络请求失败', {time: 1000});
                                    }
                                })

                            },
                            no: function () {
                                layer.msg('取消了')
                            }
                        }
                    );
                },

            },
            created() {
                layui.use(['form', 'jquery', 'laydate', 'layer', 'dialog'], function () {
                    var form = layui.form(),
                        $ = layui.jquery,
                        dialog = layui.dialog,
                        layer = layui.layer
                    ;
                    form.render();
                    $('.fresh').mouseenter(function () {
                        dialog.tips('刷新页面', this);
                    })
                    $('.fresh').click(function () {
                        window.location.reload()
                    });
                    $('.tips-info').mouseenter(function () {
                        var msg = $(this).attr('data-info');
                        dialog.tips(msg, this);
                    })
                });
            }
        })

    </script>
@endsection
