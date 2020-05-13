
@section('title', '历史工匠详情')

@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section("content")
<body>
    <style>
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
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="app">
        <form class="layui-form tc-container mT0">
            <div class="layui-form-item">
                <label class="layui-form-label">头像：</label>

                    @if(!empty($craftsman->photo))
                        <img style="width:200px;height: 150px;"
                             src="{{$craftsman->photo }}"
                             alt="">
                    @endif

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
                <label class="layui-form-label">获奖年份：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->years}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职业：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->unit_name}}
                                </span>
                </div>
            </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">任务描述：</label>
                    <div class="layui-input-block">
                                <textarea  class="layui-input" style="width: 100%; height: 23%;">{{$craftsman->describe}}</textarea>
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