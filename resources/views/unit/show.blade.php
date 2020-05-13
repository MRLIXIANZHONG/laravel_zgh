<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section('title', '工会详细')

@extends('common.editTwo')

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
    <div class="layui-inline add-div">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="app">
        <form class="layui-form tc-container mT0" id="nomineeForm">
            <div class="layui-form-item">
                <label class="layui-form-label">工会类型：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    @if ($unit['type'] === 1)
                                        市直机关工会联合会
                                    @elseif ($unit['type'] === 2)
                                        产业工会
                                    @elseif ($unit['type'] === 3)
                                        区县工会
                                    @endif
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上级工会名称：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->name}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系人：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->username}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->mobile}}
                                </span>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">劳动之星推荐数：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->labour_star_amount}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">技能之星推荐数：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->skill_star_amount}}
                                </span>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">创新之星推荐数：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->innovate_star_amount}}
                                </span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">服务之星推荐数：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$unit->service_star_amount}}
                                </span>
                    </div>
                </div>
            </div>
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