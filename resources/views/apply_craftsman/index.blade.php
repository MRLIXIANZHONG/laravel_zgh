@extends('common.list')
@section('title', '工匠申请列表')

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
    </style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh">
            <a href="{{url('/admin/apply_craftsmans')}}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>
    {{--<div class="layui-inline">--}}
    {{--<input type="text" value="{{$nomineedto->getStaffName()}}" name="staff_name" placeholder="请输入参赛员工关键字"--}}
    {{--autocomplete="off" class="layui-input">--}}

    {{--</div>--}}
    <form action = "{{url('admin/apply_craftsmans')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="" name="username"
                   placeholder="请输入申请工匠姓名关键字" autocomplete="off"
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
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>
    </form>

    <div class="layui-inline addproduct-div" style="position: relative">
        {{--<a href="{{ url('admin/candidate_craftsmans/create') }}"><div class="layui-btn layui-btn-normal">添加</div></a>--}}
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
            <th>姓名</th>
            <th>联系电话</th>
            <th style="min-width: 40px">工会</th>
            <th style="min-width: 40px">单位</th>
            <th style="min-width: 40px">职位</th>
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
                    <td class="hidden-xs">{{$craftsman->mobile}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_id_name}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_name}}</td>
                    <td class="hidden-xs">{{$craftsman->organization_check}}</td>
                    <td class="hidden-xs">{{$craftsman->unit_check}}</td>
                    <td class="hidden-xs">{{$craftsman->check_status}}</td>
                    <td class="hidden-xs">{{$craftsman->created_at}}</td>
                    <td class="hidden-xs">{{$craftsman->star}}</td>
                    <td class="hidden-xs">{{$craftsman->browse_amount}}</td>
                    <td class="hidden-xs">{{$craftsman->browse_score}}</td>
                    <td class="hidden-xs">@if($craftsman->is_craftsman == 2)获奖 @else 未获奖 @endif</td>
                    <td>
                        <div class="layui-inline">

                            <a href="{{ url('/admin/apply_craftsmans/'. $craftsman->id ) }}"
                               class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe615;</i>
                            </a>

                            <a href="{{ url('/admin/apply_craftsmans/'. $craftsman->id .'/edit') }}"
                               class="layui-btn layui-btn-small layui-btn-blue edit-btn" role="button" class="layui-icon">
                                <i class="layui-icon">&#xe642;</i>
                            </a>

                            <button type="button" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                                    @click="deleteNominee( {{$craftsman['id']}} )"
                            ><i class="layui-icon">&#xe640;</i></button>
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
                                url: "{{url('/admin/apply_craftsmans')}}/" + id,
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
