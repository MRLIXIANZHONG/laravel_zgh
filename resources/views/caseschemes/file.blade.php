@extends('common.list')
@section('title', '活动文件')

@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <style>
        #table-list td {
            padding: 9px 10px;
        }
        .layui-inline.tool-btn {width: 100%}
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')

    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/casefile/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$caseFiledto->getName()}}" name="name"
               placeholder="请输入关键字" autocomplete="off"
               class="layui-input">

    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline add-div" style="position: relative">
        <button class="layui-btn layui-btn-normal addBtn" data-desc="添加赛事信息"
                data-url="{{url('/admin/casefile/edit')}}">添加赛事文件
        </button>
    </div>

    <table class="layui-table" lay-skin="nob" id="table-list">
        <colgroup>

        </colgroup>
        <thead>
        <tr>
            <th>编号</th>
            <th>名称</th>
            <th>图标</th>
            {{--            <th>图片地址</th>--}}
            <th>文件名称</th>
            <th>状态</th>
            <th>是否推送前台</th>
            <th style="width: 220px">操作</th>
        </tr>
        </thead>
        <thbody>
            @if(!$casefileList->count())
                <tr>
                    <td colspan="17" style="text-align: center;color: #ff4500;">暂无数据</td>
                </tr>
            @else
                @foreach($casefileList as $info)
                    <tr>
                        <td class="hidden-xs">{{$info['id']}}</td>
                        <td class="hidden-xs">{{$info['name']}}</td>
                        <td class="hidden-xs">
                            @if (!empty($info['icon']))
                                <img src="{{$info['icon']}}" style="width: 100px;height: 100px;" alt="">
                            @endif
                        </td>
                        {{--                    <td class="hidden-xs">{{$info['img']}}</td>--}}
                        <td>

                            @foreach(explode(",",$info['file']) as $fileUrl)
                                {{pathinfo($fileUrl)['basename']}} <br>
                            @endforeach


                        </td>
                        <td>{{$info['status']?'开启':'关闭'}}</td>
                        <td>{{$info['is_push']?'推送到前台':'不推送到前台'}}</td>
                        <td>
                            <div class="layui-inline add-div">
                                <button type="button" class="layui-btn layui-btn-small layui-btn-blue" data-url="{{url('/admin/casefile/detail/'.$info['id'])}}">
                                    <i class="layui-icon">&#xe615;</i>详情</button>
                                <button type="button" class="layui-btn layui-btn-small layui-btn-blue" data-url={{url('/admin/casefile/edit').'?id='.$info['id']}}>
                                    <i class="layui-icon">&#xe642;</i>修改</button>
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
    <div class="page-wrap">
        {{--        <label class="text-center no-padding no-margin">{{$nominesslist->total()}}条</label>--}}
        {{ $casefileList->appends(['name'=>$caseFiledto->getName()

                                   ])->render() }}
    </div>
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
                                    url: "{{url('/admin/casefile/destroy')}}/" + id,
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
                // layui.use(['form', 'jquery', 'laydate', 'layer', 'dialog'], function () {
                //     var form = layui.form(),
                //         $ = layui.jquery,
                //         dialog = layui.dialog,
                //         layer = layui.layer
                //     ;
                //     form.render();
                //     $('.fresh').mouseenter(function () {
                //         dialog.tips('刷新页面', this);
                //     })
                //     $('.fresh').click(function () {
                //         window.location.reload()
                //     });
                //     $('.tips-info').mouseenter(function () {
                //         var msg = $(this).attr('data-info');
                //         dialog.tips(msg, this);
                //     })
                // });
            }
        })

    </script>
@endsection
