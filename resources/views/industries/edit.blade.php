
@section('title', '修改行业标签')

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
        @if(isset($industry))
            <form action="{{ url('admin/industries/'.$industry->id) }}" method="POST" accept-charset="UTF-8"
                  class="layui-form" id="nomineeForm" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ url('admin/industry') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data"
                          class="layui-form" id="nomineeForm" enctype="multipart/form-data">
                        @endif
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">行业标签名：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if (isset($industry->industry_name)){{$industry->industry_name}}@else@endif"
                           name="industry_name" lay-verify="required" placeholder="行业标签名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">行业标签名描述：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if (isset($industry->description)){{$industry->description}}@else@endif"
                           name="description"  placeholder="行业标签名描述"
                           class="layui-input">
                </div>
            </div>

            <button class="layui-btn layui-btn-normal" style = "margin-left: 8%;" >立即提交</button>

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