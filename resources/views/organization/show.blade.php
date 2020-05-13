@if ($organization)
    @section('title', '添加企业方案')
@else
    @section('title', '添加企业方案')
@endif
@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<style>
    .layui-form-label {
        width: 150px;
    }
</style>
@section("content")
    <body>
    <style>
        .main {
            width: 97%;
            padding-top: 30px;
        }

        .product_img {
            width: 380px;
            height: 380px;
        }

        .seller_icon {
            width: 100px;
            height: 100px;
        }

        .deleted_icon {
            display: inline-block;
            height: 20px;
            width: 20px;
            font-size: 18px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            background: #CCCCCC;
            filter: alpha(opacity:30);
            opacity: 0.8;
            position: absolute;
            bottom: 0;
            left: 360px;
            cursor: pointer;
        }
        .column-content-detail {padding-top: 15px!important;}
    </style>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="app">
            <form class="layui-form tc-container mT0" id="nomineeForm">
                        <div class="layui-form-item">
                            <label class="layui-form-label">单位名称：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->name}}
                                </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">单位logo：</label>
                            <div class="layui-input-block">
                                <img src="{{$organization->photo}}"  style="width: 146px; height: 170px;"/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">上级工会：</label>
                            <div class="layui-input-block">
                                        <span type="text" class="layui-input">
                                            @if (isset($organization->unit_id_name)) {{$organization->unit_id_name}} @endif
                                        </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">单位类型：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    @if ($organization->new_type == 1)
                                        国营控股企业
                                    @elseif ($organization->new_type == 2)
                                        行政机关
                                    @elseif ($organization->new_type == 3)
                                        港澳台、外商投资企业
                                    @elseif ($organization->new_type == 4)
                                        民营控股企业
                                    @elseif ($organization->new_type == 5)
                                        事业单位
                                    @elseif ($organization->new_type == 6)
                                        其他
                                    @else
                                        未设置
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">员工总数：</label>
                            <div class="layui-input-block">
                                        <span type="text" class="layui-input">
                                            {{$organization->staff_count}}
                                        </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">农民工总数：</label>
                            <div class="layui-input-block">
                                        <span type="text" class="layui-input">
                                            {{$organization->farmer_count}}
                                        </span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">姓名：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->username}}
                                </span>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">手机号：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->mobile}}
                                </span>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">企业官网：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->website}}
                                </span>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">方案名称：</label>
                            <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->plan_name}}
                                </span>
                            </div>
                        </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">方案概述：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off"
                              style = "width:100%;height: 130px;">
                        @if($organization) {{$organization->summary}} @else  @endif
                    </textarea>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">方案内容：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="content" lay-verify="required" placeholder="方案内容" autocomplete="off"
                              style = "width:100%;height: 130px;">
                                {{ $organization->content }}
                    </textarea>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">方案目标：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="target_task" lay-verify="required" placeholder="方案目标" autocomplete="off"
                              style = "width:100%;height: 130px;">
                        @if($organization) {{$organization->target_task}} @else  @endif
                    </textarea>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">绩效目标：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="achievement_target" lay-verify="required" placeholder="绩效目标" autocomplete="off"
                              style = "width:100%;height: 130px;">
                        @if($organization) {{$organization->achievement_target}} @else  @endif
                    </textarea>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">实施目标：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="measures" lay-verify="required" placeholder="方案目标" autocomplete="off"
                              style = "width:100%;height: 130px;">
                        @if($organization) {{$organization->measures}} @else  @endif
                    </textarea>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">表彰奖励：</label>
                                <div class="layui-input-block">
                    <textarea type="text"
                              name="commend" placeholder="表彰奖励"
                              style = "width:100%;height: 130px;">
                        @if($organization) {{$organization->commend}} @else  @endif
                    </textarea>
                                </div>
                            </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">方案图片：</label>
                            <div class="layui-input-block">
                                    <img src="{{$organization->img_url}}" />
                            </div>
                        </div>

                        {{--<div class="layui-form-item">--}}
                            {{--<label class="layui-form-label">方案图片：</label>--}}
                            {{--<div class="layui-input-block">--}}
                                    {{--<img src="{{$organization->img_url}}" />--}}
                            {{--</div>--}}
                        {{--</div>--}}

                            <div class="layui-form-item">
                                <label class="layui-form-label">注册时间：</label>
                                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->created_at}}
                                </span>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">点赞量：</label>
                                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->star_count}}
                                </span>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">浏览量：</label>
                                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$organization->browse_count}}
                                </span>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">审核人：</label>
                                <div class="layui-input-block">
                                            <span type="text" class="layui-input">
                                                {{$organization->check_staff}}
                                            </span>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">审核时间：</label>
                                <div class="layui-input-block">
                                            <span type="text" class="layui-input">
                                                {{$organization->check_time}}
                                            </span>
                                </div>
                            </div>

                        {{--<div class="layui-form-item">--}}
                        {{--<label class="layui-form-label">请选择推荐类型：</label>--}}
                        {{--<div class="layui-input-block">--}}

                        {{--<select name="kind">--}}
                        {{--<option value="{{$nominee['kind']}}">请选择推荐类型</option>--}}
                        {{--<option value="1" @if($nominee['kind']!=null&&$nominee['kind']=='劳动之星') selected @endif >劳动之星--}}
                        {{--</option>--}}
                        {{--<option value="2" @if($nominee['kind']!=null&&$nominee['kind']=='技能之星') selected @endif>技能之星--}}
                        {{--</option>--}}
                        {{--<option value="3" @if($nominee['kind']!=null&&$nominee['kind']=='创新之星') selected @endif>创新之星--}}
                        {{--</option>--}}
                        {{--<option value="4" @if($nominee['kind']!=null&&$nominee['kind']=='服务之星') selected @endif>服务之星--}}
                        {{--</option>--}}
                        {{--</select>--}}

                        {{--</div>--}}
                        {{--</div>--}}
                    </form>
    </div>
    </body>
@endsection
@section('js')
    <script>
        let app = new Vue({
            el: "#app",
            data() {
                return {}
            },
            methods: {},
            watch: {}

        });


    </script>
@endsection