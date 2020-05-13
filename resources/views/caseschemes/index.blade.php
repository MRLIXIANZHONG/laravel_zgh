@extends('common.list')
@section('title', '赛事列表')

@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <style>
        #table-list td {
            padding: 9px 10px;
        }
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')

    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/caseschemes/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$caseSchemesdto->getTitle()}}" name="title"
               placeholder="请输入赛事关键字" autocomplete="off"
               class="layui-input">

    </div>
    <div class="layui-inline">
        <select name="type">
            <option value="0">请选择赛事类型</option>
            @foreach($caseSchemesTypeList as $caseSchemesType)
                <option value="{{$caseSchemesType['id']}}" @if($caseSchemesType['id']==$caseSchemesdto->getType()) selected @endif >{{$caseSchemesType['name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline add-div" style="position: relative">
        <a class="layui-btn layui-btn-normal" data-desc="添加赛事信息"
           href="{{url('/admin/caseschemes/edit')}}">添加赛事信息
        </a>
    </div>

    <table class="layui-table" lay-skin="nob" id="table-list">
        <colgroup>
            <col class="hidden-xs" width="80">
            <col class="hidden-xs" width="100">
            <col width="150">
            <col width="100">
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col width="170">
        </colgroup>
        <thead>
        <tr>
            <th>标题</th>
            <th>唯一代码</th>
            <th>类型</th>
            <th>排序</th>
            <th style="min-width: 40px">状态</th>
            <th>赛事周期</th>
            <th>展示时间</th>
            <th>企业推选时间</th>
            <th>工会推选时间</th>
            <th>大众评选时间</th>
            <th>专家投票时间</th>
            <th>年度投票时间</th>
            <th style="min-width: 80px">颁奖时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <thbody>
            @if(!$caseSchemesList->count())
                <tr>
                    <td colspan="17" style="text-align: center;color: #ff4500;">暂无数据</td>
                </tr>
            @else
            @foreach($caseSchemesList as $info)
                <tr>
                    <td class="hidden-xs">{{$info['title']}}</td>
                    <td class="hidden-xs">{{$info['code']}}</td>
                    <td class="hidden-xs">{{$info->caseSchemeType['name']}}</td>
                    <td>{{$info['sort']}}</td>
                    <td>{{$info['is_open']?'开启':'关闭'}}</td>
                    <td class="hidden-xs">{{$info['activity_stime']?date("Y-m-d",strtotime($info['activity_stime'])):''}}
                        --{{$info['activity_etime']?date("Y-m-d",strtotime($info['activity_etime'])):''}}</td>
                    <td class="hidden-xs">{{$info['show_stime']?date("Y-m-d",strtotime($info['show_stime'])):''}}
                        --{{$info['show_etime']?date("Y-m-d",strtotime($info['show_etime'])):''}}</td>
                    <td class="hidden-xs">{{$info['qy_stime']?date("Y-m-d",strtotime($info['qy_stime'])):''}}
                        --{{$info['qy_etime']?date("Y-m-d",strtotime($info['qy_etime'])):''}}</td>

                    <td class="hidden-xs">{{$info['gh_stime']?date("Y-m-d",strtotime($info['gh_stime'])):''}}
                        --{{$info['gh_etime']?date("Y-m-d",strtotime($info['gh_etime'])):''}}</td>

                    <td class="hidden-xs">{{$info['public_stime']?date("Y-m-d",strtotime($info['public_stime'])):''}}
                            --{{$info['public_etime']?date("Y-m-d",strtotime($info['public_etime'])):''}}</td>
                    <td class="hidden-xs">{{$info['zj_stime']?date("Y-m-d",strtotime($info['zj_stime'])):''}}
                        --{{$info['zj_etime']?date("Y-m-d",strtotime($info['zj_etime'])):''}}</td>
                    <td class="hidden-xs">{{$info['year_stime']?date("Y-m-d",strtotime($info['year_stime'])):''}}
                        --{{$info['year_etime']?date("Y-m-d",strtotime($info['year_etime'])):''}}</td>
                    <td>{{$info['prize_at']?date("Y-m-d",strtotime($info['prize_at'])):''}}</td>
                    <td>
                        <div class="layui-inline add-div">
                            <a class="layui-btn layui-btn-small layui-btn-blue" target="_self" href="{{url('/admin/caseschemes/detail/'.$info['id'])}}">
                                <i class="layui-icon">&#xe615;</i>详情</a>
                            <a class="layui-btn layui-btn-small layui-btn-blue" href={{url('/admin/caseschemes/edit').'?id='.$info['id']}} target="_self">
                                <i class="layui-icon">&#xe642;</i>编辑</a>
                            <button type="button" class="layui-btn layui-btn-small layui-btn-danger" @click="deleteCaseSchemes('{{$info['id']}}')"
                            >
                                <i class="layui-icon">&#xe640;</i>删除</button>
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
        var app = new Vue({
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
