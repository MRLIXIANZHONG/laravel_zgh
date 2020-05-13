@extends('common.list')
@section('title', '工会列表')

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
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
                ><a href="{{ url('/admin/units') }}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>

    <form action = "{{url('admin/units')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="@if($search['name'] !== null){{$search['name']}}@endif" name="name"
                   placeholder="请输入工会名关键字" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <div class="layui-input-block" style = "margin-left: 10px;">
                <select name="type" lay-filter="aihao">
                    <option value=""></option>
                    <option value="1" @if($search['type'] === 1) selected @endif>市直机关工会联合会</option>
                    <option value="2" @if($search['type'] === 2) selected @endif>产业工会</option>
                    <option value="3" @if($search['type'] === 3) selected @endif>区县工会</option>
                </select>
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-block" style = "margin-left: 10px;">
                <select name="honor_unit" lay-filter="aihao">
                    <option value=""></option>
                    <option value="0" @if($search['honor_unit'] === 0) selected @endif>非荣誉工会</option>
                    <option value="1" @if($search['honor_unit'] === 1) selected @endif>荣誉工会</option>
                </select>
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-block" style = "margin-left: 10px;">
                <select name="check_status" lay-filter="aihao">
                    <option value=""></option>
                    <option value="-1" @if($search['check_status'] === -1) selected @endif>驳回</option>
                    <option value="0" @if($search['check_status'] === 0) selected @endif>未审核</option>
                    <option value="1" @if($search['check_status'] === 1) selected @endif>已审核</option>
                </select>
            </div>
        </div>

        <div class="layui-inline">
            <input type="text" value="@if($search['mobile'] !== null){{$search['mobile']}}@endif" name="mobile"
                   placeholder="请输入工会联系电话" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
    </form>
    @if($role == 1)
        <div class="layui-inline">
            <a href="{{url('/admin/units/create')}}"><button type="button" class="layui-btn layui-btn-normal">添加</button></a>
        </div>
    @endif

    <div class="layui-inline addproduct-div" style="position: relative">
        <ul class="addproduct-ul">
            <li class="addproduct-li" type="zz" url="{{url('/admin/product/edit')}}?type=zz">转转</li>
            <li class="addproduct-li" type="xianyu" url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼</li>
        </ul>
    </div>

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
            <th>工会名称</th>
            <th>工会类型</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>劳动之星推荐数</th>
            <th>技能之星推荐数</th>
            <th>创新之星推荐数</th>
            <th>服务之星推荐数</th>
            <th>创建时间</th>
            <th>审核状态</th>
            <th>是否荣誉工会</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <thbody>
            @foreach($units as $unit)
                <tr>
                    <td class="hidden-xs">{{$unit['id']}}</td>
                    <td class="hidden-xs">{{$unit['name']}}</td>
                    <td class="hidden-xs">
                        @if ($unit['type'] === 1)
                            市直机关工会联合会
                        @elseif ($unit['type'] === 2)
                            产业工会
                        @elseif ($unit['type'] === 3)
                            区县工会
                        @endif
                    </td>
                    <td class="hidden-xs">{{$unit['username']}}</td>
                    {{--<td>{{$organization['bank_name']}}</td>--}}
                    <td class="hidden-xs">{{$unit['mobile']}}</td>
                    <td class="hidden-xs">{{$unit['labour_star_amount']}}</td>
                    <td class="hidden-xs">{{$unit['skill_star_amount']}}</td>
                    <td class="hidden-xs">{{$unit['innovate_star_amount']}}</td>
                    <td class="hidden-xs">{{$unit['service_star_amount']}}</td>
                    <td class="hidden-xs">{{$unit['created_at']}}</td>
                    <td class="hidden-xs">
                        @if ($unit->check_status === 0)
                            未审核
                        @elseif($unit->check_status === -1)
                            驳回
                        @else
                            已审核
                        @endif
                    </td>
                    <td class="hidden-xs">
                        @if ($unit->honor_unit === 1)
                            是
                        @else
                            否
                        @endif
                    </td>
                    <td>
                        <div class="layui-inline">
                            <a href="{{ url('/admin/units/'. $unit['id'] ) }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>详情</a>
                            @if(in_array($role, [1,2]))
                                <a href="{{ url('/admin/units/'. $unit['id'] .'/edit') }}" class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                    <i class="layui-icon">&#xe642;</i>编辑</a>
                            @endif
                            @if ($role == 1)
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn" @click="deleteNominee( {{$unit['id']}} )"><i class="layui-icon">&#xe640;</i>删除</button>
                            @endif
                            @if($role == 4)
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                        @click="check( {{$unit['id']}} )"
                                ><i class="layui-icon">&#xe642;</i>审核</button>
                                <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                        @click="reject( {{$unit['id']}} )"
                                ><i class="layui-icon">&#x1006;</i>驳回</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </thbody>
    </table>
    {!! $units->render() !!}
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
                                url: "{{url('/admin/units')}}/" + id,
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
                                url: "{{url('/admin/units')}}/" + id + '/check',
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'patch',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message,{icon: 6});
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
                                url: "{{url('/admin/units')}}/" + id + '/reject',
                                data: {
                                    _token: '{{csrf_token()}}'
                                },
                                type: 'patch',
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
