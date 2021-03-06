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
    <script src="{{ env('APP_URL') }}static/admin/js/vue.js"></script>
</head>
@yield("content")
@yield('js')
