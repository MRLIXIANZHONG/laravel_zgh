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
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
        ><a href="{{ url('/admin/wl_units') }}"><i class="layui-icon">&#x1002;</i></a></div>
    </div>
    {{--<div class="layui-inline">--}}
    {{--<input type="text" value="{{$nomineedto->getStaffName()}}" name="staff_name" placeholder="请输入参赛员工关键字"--}}
    {{--autocomplete="off" class="layui-input">--}}

    {{--</div>--}}
    <form action = "{{url('admin/wl_units')}}" method="get">
        <div class="layui-inline">
            <input type="text" value="{{$search['name']}}" name="name"
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
            <input type="text" value="{{$search['mobile']}}" name="mobile"
                   placeholder="请输入工会联系电话" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        </div>

        <div class="layui-inline">
            <a href="{{url('admin/wl_units_export')}}" style="display: inline-block;width: 64px; height: 38px;line-height: 38px;background-color: #BC0000;text-align: center; color: #ffffff;">导出</a>
        </div>
    </form>

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
            <th style="min-width: 30px">名称</th>
            <th style="min-width: 30px">类型</th>
            <th style="min-width: 30px">参赛企业</th>
            <th style="min-width: 30px">联系人</th>
            <th style="min-width: 30px">联系电话</th>
            <th style="min-width: 30px">提报个人</th>
            <th style="">月度之星</th>
            <th style="">季度之星</th>
            <th style="">年度之星</th>
            <th style="min-width: 30px">提报方案</th>
            <th style="min-width: 30px">初审方案</th>
            <th style="min-width: 30px">复审方案</th>
            <th style="min-width: 30px">节能方案</th>
            <th style="min-width: 30px">防治方案</th>
            <th style="min-width: 30px">生产方案</th>
            <th style="min-width: 30px">脱贫方案</th>
            <th style="min-width: 30px">其他方案</th>
            <th style="min-width: 30px">优秀集体</th>
            <th style="">提报五小</th>
            <th style="">月度五小</th>
            <th style="">季度五小</th>
            <th style="">年度五小</th>
            <th style="min-width: 30px">新闻提报</th>
            <th style="min-width: 30px">新闻发布</th>
            <th style="min-width: 30px">浏览总量</th>
            <th style="min-width: 30px">点赞总量</th>
            <th style="min-width: 30px">审核状态</th>
            <th style="min-width: 30px">荣誉工会</th>
{{--            <th style="min-width: 140px">操作</th>--}}
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
                    <td class="hidden-xs">{{$unit->organization_count}}</td>
                    <td class="hidden-xs">{{$unit['username']}}</td>
                    {{--<td>{{$organization['bank_name']}}</td>--}}
                    <td class="hidden-xs">{{$unit['mobile']}}</td>
                    <td class="hidden-xs">{{$unit->yxgr_tb}}</td>
                    <td class="hidden-xs">{{$unit->yxgr_yd}}</td>
                    <td class="hidden-xs">{{$unit->yxgr_jd}}</td>
                    <td class="hidden-xs">{{$unit->yxgr_nd}}</td>
                    <td class="hidden-xs">{{$unit->fa_tb}}</td>
                    <td class="hidden-xs">{{$unit->fa_cs}}</td>
                    <td class="hidden-xs">{{$unit->fa_fs}}</td>
                    <td class="hidden-xs">{{$unit->fa_jnjp}}</td>
                    <td class="hidden-xs">{{$unit->fa_zhfz}}</td>
                    <td class="hidden-xs">{{$unit->fa_aqsc}}</td>
                    <td class="hidden-xs">{{$unit->fa_tpgj}}</td>
                    <td class="hidden-xs">{{$unit->fa_qt}}</td>
                    <td class="hidden-xs">{{$unit->fa_jt}}</td>
                    <td class="hidden-xs">{{$unit->wx_tb}}</td>
                    <td class="hidden-xs">{{$unit->wx_yd}}</td>
                    <td class="hidden-xs">{{$unit->wx_jd}}</td>
                    <td class="hidden-xs">{{$unit->wx_nd}}</td>
                    <td class="hidden-xs">{{$unit->xw_tb}}</td>
                    <td class="hidden-xs">{{$unit->xw_fb}}</td>
                    <td class="hidden-xs">{{$unit->browse_amount}}</td>
                    <td class="hidden-xs">{{$unit->star_amount}}</td>
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
{{--                    <td>--}}
{{--                        <div class="layui-inline">--}}

{{--                            <a href="{{ url('/admin/units/'. $unit['id'] ) }}"--}}
{{--                               class="layui-btn layui-btn-small layui-btn-normal edit-btn" role="button" class="layui-icon">--}}
{{--                                <i class="layui-icon">&#xe615;</i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </td>--}}
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
