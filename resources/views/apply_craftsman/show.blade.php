
@section('title', '工匠申请详情')

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
        <form class="layui-form" id="nomineeForm">
            <div class="layui-form-item">
                <label class="layui-form-label">头像：</label>
                <div class="layui-input-block">
                                <img src="{{$craftsman->photo}}" />
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">姓名：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->username}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->mobile}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所在单位：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->unit_name}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">银行卡号：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->bank_card}}
                                </span>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">户名：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->bank_username}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户行：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->bank_name}}
                                </span>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">视屏：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->video}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">图片：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->image}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">荣誉贡献：</label>
                    <div class="layui-input-block">
                    <textarea type="text"
                              name="honor"
                              style = "width:990px;height: 130px;">{{$craftsman->honor}}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">推荐理由：</label>
                    <div class="layui-input-block">
                    <textarea type="text"
                              name="content"
                              style = "width:990px;height: 130px;">{{ $craftsman->describe }}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">状态：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->check_status_name}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">申报时间：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->created_at}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">点赞数：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->star}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">浏览量：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->browse_amount}}
                                </span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">得分数：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->score}}
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