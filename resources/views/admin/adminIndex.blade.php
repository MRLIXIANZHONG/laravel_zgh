@section('title', '后台首页')


@section('content')
    <style>
        .content{
            padding:20px;
        }
        .head_title{
            height:42px;
            line-height: 42px;
            color: #FFFFFF;
            font-size:14px;
            padding:0 15px;
            background-color: #1E9FFF;
            border-radius: 5px 5px 0 0;
        }
        .line_box{
            height: 42px;
            line-height: 42px;
            padding-left: 15px;
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
        .line_box p{
            color: #555555;
            font-size: 14px;
            padding-right: 15px;
        }
        .head_content{
            margin-top: 30px;
            height:42px;
            line-height: 42px;
            color: #FFFFFF;
            font-size:14px;
            padding:0 15px;
            background-color: #1E9FFF;
            border-radius: 5px 5px 0 0;
        }
        .publicContent{
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            min-height: 25px;
            overflow: hidden;
        }
        .models{
            margin-top: 30px;
            height:42px;
            line-height: 42px;
            color: #666666;
            font-size:14px;
            padding:0 15px;
            background-color: #1E9FFF;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .botton_box{
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            text-align: center;
            color: #999999;
            font-size: 14px;
            height: 42px;
            line-height: 42px;
        }
        .botton_end{
            color: #337ab7;
            font-size: 18px;
            height: 42px;
            line-height: 42px;
            text-align: center;
            font-weight: bold;
        }
        .botton_end span{
            color:#337FE5;
        }
    </style>
    <body>
        <div class="content">
            <div class="head_title">尊敬的管理员：</div>
            <div class="line_box">
                <p>你上次登录的ip为：{{$_SERVER["REMOTE_ADDR"]}}</p>
            </div>
{{--            <div class="line_box">--}}
{{--                <p>全站统计数据：</p>--}}
{{--            </div>--}}
            <div class="line_box">
                <p>全站用户共</p>
                <p>{{$userCount}}</p>
            </div>
            <div class="line_box">
                <p>全站订单共</p>
                <p>{{$orderCount}}</p>
            </div>
            <div class="line_box">
                <p>全站商品共</p>
                <p>{{$productCount}}</p>
            </div>
            <div class="line_box">
                <p>全站留言共</p>
                <p>{{$messageCount}}</p>
            </div>

            <div class="head_content">公告栏</div>
            <div class="publicContent">
                {!! htmlspecialchars_decode($publicContent) !!}
            </div>


            <div class="models">众成商城模板</div>
            <div class="botton_box">版本：4.0内测版</div>
            <div class="botton_box">点击与我取得最新联系</div>
            <div class="botton_end">安全 稳定 效率<span>点击联系</span></div>
        </div>

    </body>
@endsection

@section('js')
    <script>
        layui.use('form', function(){
            var form = layui.form();
            $ = layui.jquery;
            $('#publiccontent').click(function(){
                var url = $(this).attr('href');
                if(window.plus){
                    plus.runtime.openURL(url);
                }else if(typeof require != 'undefined'){
                    var shell = require('electron').shell;
                    shell.openExternal(url);
                }else{
                    top.location.href = url;
                }
                return false;
            });

        });
    </script>
@endsection
@extends('common.common')