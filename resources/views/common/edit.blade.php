<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>@yield('title') | {{ Config::get('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}static/admin/layui/css/layui.css?v={{rand(0,9999)}}" />
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}static/admin/css/admin.css?v={{rand(0,9999)}}" />
    <script src="{{ env('APP_URL') }}static/admin/js/jquery.min.js?v={{rand(0,9999)}}"></script>
    <script src="{{ env('APP_URL') }}static/admin/layui/layui.js?v={{rand(0,9999)}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ env('APP_URL') }}static/admin/js/common.js?v={{rand(0,9999)}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ env('APP_URL') }}static/admin/laydate/laydate.js?v={{rand(0,9999)}}"></script>

</head>
<body>
<div class="wrap-container">
    <form class="layui-form" style="width: 90%;padding-top: 20px;">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        @yield('content')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
        <input name="id" id="id" type="hidden" value="@yield('id')">
    </form>
</div>
@yield('js')
</body>
</html>