@extends('common.list')
@section('title', '优秀个人荣誉列表')
@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>

@section('header')

    <div class="layui-inline add-div" style="position: relative">
        <button class="layui-btn layui-btn-normal addBtn" data-desc="添加个人图集"
                data-url="{{url('/admin/nominees/editimg/?id=0&mainId=')}}{{$mainId}}">添加个人图集
        </button>
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>

    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="table-list">
        <thead>
        <tr>
            <th>编号</th>
            <th>标题</th>
            <th>图片</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <thbody>
            @foreach($nominessImglist as $info)
                <tr>
                    <td class="hidden-xs">{{$info['id']}}</td>
                    <td class="hidden-xs">{{$info['title']}}</td>
                    <td class="hidden-xs">
                        <img src="{{$info['img_url']}}" style="height: 100px">
                    </td>
                    <td class="hidden-xs">{{$info['sort']}}</td>
                    <td style="width: auto">
                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-small layui-btn-normal edit-btn"
                                    data-desc="修改"
                                    data-url="{{url('/admin/nominees/editimg').'?id='.$info['id']}}&mainId={{$mainId}}">
                                <i class="layui-icon">&#xe642;</i>
                            </button>
                            <button type="button" class="layui-btn layui-btn-small layui-btn-danger tips-info"
                                    data-info="删除"
                                    @click="deleteNominee('{{$info['id']}}')"
                            ><i class="layui-icon">&#xe640;</i></button>

                        </div>
                    </td>
                </tr>
            @endforeach
            @if(empty($nominessImglist))
                <tr>
                    <td colspan="5" style="text-align: center;color: #ff4500;">暂无数据</td>
                </tr>
            @endif
        </thbody>
    </table>
    <div class="page-wrap">
        {{$nominessImglist->links()}}
    </div>
@endsection
@section('js')
    <script>
        function goBack() {
            // history.go(-1);
            window.location.href="/admin/nominees/index"
        }

        let app = new Vue({
            el: "#table-list",
            data() {
                return {}
            },
            methods: {
                deleteNominee(id) {
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
                                    url: "{{url('/admin/nominees/destroyimg')}}/" + id,
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

                }
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
