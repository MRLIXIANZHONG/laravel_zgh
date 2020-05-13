@if (isset($organization))
    @section('title', '修改工匠申请')
@else
    @section('title', '添加工匠申请')
@endif
@extends('common.editTwo')

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
    </style>
    <div class="main" id="app">
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
            <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
        </div>
        @if(isset($craftsman))
            <form action="{{ url('admin/apply_craftsmans/'.$craftsman->id) }}" method="POST" accept-charset="UTF-8"
                  class="layui-form"  enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ url('admin/apply_craftsmans') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data"
                          class="layui-form"  enctype="multipart/form-data">
                        @endif
                        {{ csrf_field() }}

                        <div class="layui-form-item">
                            <label class="layui-form-label">头像：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->photo}} @else  @endif"
                                       name="photo" lay-verify="required" placeholder="头像" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">姓名：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->username}} @endif"
                                       name="username" lay-verify="required" placeholder="姓名" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系电话：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->mobile}} @endif"
                                       name="mobile" lay-verify="required" placeholder="联系电话" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">职业：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->unit_name}} @endif"
                                       name="unit_name" lay-verify="required" placeholder="职业" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">银行卡号：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->bank_card}} @endif"
                                       name="bank_card" lay-verify="required" placeholder="银行卡号" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">户名：</label>
                            <div class="layui-input-block">
                                <input type="text"
                                       value="@if(isset($craftsman->id)) {{$craftsman->bank_username}} @endif"
                                       name="bank_username" lay-verify="required" placeholder="户名" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">开户行：</label>
                            <div class="layui-input-block">
                                <input type="text"
                                       value="@if(isset($craftsman->id)) {{$craftsman->bank_name}}  @endif"
                                       name="bank_name" lay-verify="required" placeholder="开户行" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        {{--<div class="layui-form-item">--}}
                            {{--<label class="layui-form-label">推选来源：</label>--}}
                            {{--<div class="layui-input-block">--}}
                                {{--<input type="text" value="@if(isset($craftsman->id)) {{$craftsman->from}}  @endif"--}}
                                       {{--name="from" placeholder="推选来源"--}}
                                       {{--class="layui-input">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="layui-form-item">
                            <label class="layui-form-label">视屏文件：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->video}}  @endif"
                                       name="video" lay-verify="required" placeholder="视屏文件" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">图片：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($craftsman->id)) {{$craftsman->image}}  @endif"
                                       name="image" lay-verify="required" placeholder="图片" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">荣誉贡献：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              name="honor" lay-verify="required" placeholder="荣誉贡献" autocomplete="off"
                              style = "width:990px;height: 130px;">
                        @if(isset($craftsman->id)) {{$craftsman->honor}} @else  @endif
                    </textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">推荐理由：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              name="describe" lay-verify="required" placeholder="推荐理由" autocomplete="off"
                              style = "width:990px;height: 130px;">
                        @if(isset($craftsman->id)){{$craftsman->describe}} @else  @endif
                    </textarea>
                            </div>
                        </div>

                        <button type="submit" class="layui-btn layui-btn-normal" style = "margin-left: 8%;" >立即提交</button>

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