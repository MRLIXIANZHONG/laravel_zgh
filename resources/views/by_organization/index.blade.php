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
            <a href="{{url('/admin/by_organizations')}}"><i class="layui-icon" style="color: #FFF">&#x1002;</i></a></div>
    </div>
    {{--<div class="layui-inline">--}}
    {{--<input type="text" value="{{$nomineedto->getStaffName()}}" name="staff_name" placeholder="请输入参赛员工关键字"--}}
    {{--autocomplete="off" class="layui-input">--}}

    {{--</div>--}}
    <form action="{{url('admin/by_organizations')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="{{ $dto->getName() }}" name="name"
                   placeholder="请输入参赛企业关键字" autocomplete="off"
                   class="layui-input">
        </div>

        <div class="layui-inline">
            {{--<select name="kind">--}}
            {{--<option value="{{$nomineedto->getKind()}}">请选择推荐类型</option>--}}
            {{--<option value="1" @if($nomineedto->getKind()=='1') selected @endif >劳动之星</option>--}}
            {{--<option value="2" @if($nomineedto->getKind()=='2') selected @endif>技能之星</option>--}}
            {{--<option value="3" @if($nomineedto->getKind()=='3') selected @endif>创新之星</option>--}}
            {{--<option value="4" @if($nomineedto->getKind()=='4') selected @endif>服务之星</option>--}}
            {{--</select>--}}
        </div>
        <div class="layui-inline">
            <select name="new_type" lay-filter="aihao">
                <option value=""></option>
                <option value="1" @if($dto->getNewType()=='1') selected @endif >国营控股企业</option>
                <option value="2" @if($dto->getNewType()=='2') selected @endif >行政机关</option>
                <option value="3" @if($dto->getNewType()=='3') selected @endif >港澳台、外商投资企业</option>
                <option value="4" @if($dto->getNewType()=='4') selected @endif >民营控股企业</option>
                <option value="5" @if($dto->getNewType()=='5') selected @endif >事业单位</option>
                <option value="6" @if($dto->getNewType()=='6') selected @endif >其他</option>
            </select>
        </div>
        <div class="layui-inline">
            <select name="unit_id" lay-filter="aihao">
                <option value=""></option>
                @foreach($units as $unit)
                    <option value="{{$unit->id}}" @if($dto->getUnitId()==$unit->id) selected @endif>{{$unit->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
        @if(in_array($role, [1,4]))
            <div class="layui-inline">
                <a class="layui-btn layui-btn-normal" href="{{url('/admin/by_organization_export')}}" style="display: inline-block;width: 64px; height: 38px;line-height: 38px;background-color: #BC0000;text-align: center; color: #ffffff;">导出</a>
            </div>
        @endif
    </form>

    {{--<div class="layui-inline addproduct-div" style="position: relative">--}}
    {{--<a href="{{ url('admin/organizations/create')  }}"><div class="layui-btn layui-btn-normal">添加企业方案</div></a>--}}
    {{--<ul class="addproduct-ul">--}}
    {{--<li class="addproduct-li" type="zz" url="{{url('/admin/product/edit')}}?type=zz">转转</li>--}}
    {{--<li class="addproduct-li" type="xianyu" url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼</li>--}}
    {{--</ul>--}}
    {{--</div>--}}

    <table class="layui-table" lay-skin="nob" id="app">
        {{--        <colgroup>--}}
        {{--            <col class="hidden-xs" width="80">--}}
        {{--            <col class="hidden-xs" width="80">--}}
        {{--            <col width="150">--}}
        {{--            <col width="100">--}}
        {{--            <col width="150">--}}
        {{--            <col class="hidden-xs" width="150">--}}
        {{--            <col class="hidden-xs" width="150">--}}
        {{--            <col class="hidden-xs" width="150">--}}
        {{--            <col class="hidden-xs" width="150">--}}
        {{--            <col width="100">--}}
        {{--            <col width="200">--}}
        {{--        </colgroup>--}}
        <thead>
        <tr>
            <th>ID</th>
            <th>单位</th>
            <th>单位类型</th>
            <th>企业联系人</th>
            <th>联系电话</th>
            <th>所属工会</th>
            <th>工匠报送数</th>
            <th>工匠通过数</th>
            <th>工匠获奖数</th>
            {{--<th>行业标签</th>--}}
            <th>浏览总量</th>
            <th>点赞总量</th>
            {{--            <th>操作</th>--}}
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
                    <td class="hidden-xs">{{$organization->username}}</td>
                    <td class="hidden-xs">{{$organization->mobile}}</td>
                    <td class="hidden-xs">{{$organization->unit_id_name}}</td>
                    <td class="hidden-xs">{{$organization->gj_tb}}</td>
                    <td class="hidden-xs">{{$organization->gj_fs}}</td>
                    {{--<td class="hidden-xs">{{$organization['industry']}}</td>--}}
                    <td class="hidden-xs">{{$organization->gj_hj}}</td>
                    <td class="hidden-xs">{{$organization->by_browse}}</td>
                    <td class="hidden-xs">{{$organization->by_star}}</td>

                    {{--                    <td>--}}
                    {{--                        <div class="layui-inline">--}}
                    {{--                            @if ($role == 1)--}}
                    {{--                                <button class="layui-btn layui-btn-small layui-btn-normal tips-info"--}}
                    {{--                                        data-info=""--}}
                    {{--                                        @click="setValue('{{$organization['id']}}')" type="button"><i--}}
                    {{--                                            class="layui-icon">设置</i>--}}
                    {{--                                </button>--}}
                    {{--                            @endif--}}
                    {{--                        </div>--}}
                    {{--                    </td>--}}
                </tr>
            @endforeach
        </thbody>
    </table>
    {{ $organizations->appends(['name'=>$dto->getName(),'new_type'=>$dto->getNewType(),'unit_id'=>$dto->getUnitId()])->render()}}
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
            // created(){
            //     layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {
            //         var form = layui.form(),
            //             $ = layui.jquery,
            //             dialog = layui.dialog,
            //             layer = layui.layer
            //         ;
            //         form.render();
            //         $('.fresh').mouseenter(function() {
            //             dialog.tips('刷新页面', '.fresh');
            //         })
            //         $('.fresh').click(function() {
            //             window.location.reload()
            //         });
            //     });
            //
            //
            //     layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog',   'element'], function() {
            //         var $ = layui.jquery;
            //         var iframeObj = $(window.frameElement).attr('name');
            //         $('#app').on('click', '.editbtn', function() {
            //             var That = $(this);
            //             var url=That.attr('data-url');
            //             var desc=That.attr('data-desc');
            //
            //             //将iframeObj传递给父级窗口
            //             parent.page(desc, url, iframeObj, w = "700px", h = "620px");
            //             return false;
            //         })
            //
            //
            //
            //
            //
            //         $(".addproduct-div").hover(
            //             function () {
            //                 $('.addproduct-ul').show();
            //             },
            //             function () {
            //                 $('.addproduct-ul').hide();
            //             }
            //         );
            //
            //
            //     });
            //
            //
            //
            //     var clipboard = new ClipboardJS('.copy');
            //     clipboard.on('success', function(e) {
            //         alert('网址已复制，如若浏览器打不开请手动在浏览器粘贴链接。');
            //         console.log(e);
            //     });
            //
            //     clipboard.on('error', function(e) {
            //         console.log(e);
            //     });
            // }
        })

    </script>
@endsection
