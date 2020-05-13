@section('title', '发布商品')
@section("content")
    <style>
        .main{
            padding:20px 10px;
        }
        .header_title{
            background-color: #1E9FFF;
            color: #FFFFFF;
            text-align: center;
            height:42px;
            line-height: 42px;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
        }
        .layui-form-radio i:hover, .layui-form-radioed i{
            color: #1E9FFF;
        }
        .ony-badge{
            border-radius:50%;
            background:#1E9FFF;
            width:20px;
            height:20px;
            line-height: 20px;
            text-align: center;
            color:white;
            float:right;
        }
    </style>
    <body>
        <div class="main">
            <div class="header_title">新增商品</div>
            <table class="layui-table" id="mytable" style="margin:0;">
                <colgroup>
                    <col>
                </colgroup>
                <thead>
                </thead>
                <tbody>
                <tr>
                    <td data-id="zz" class="edit-btn" data-desc="添加商品" data-type="zz" data-url="{{url('/admin/product/edit')}}?type=zz">转转商品<span class="layui-badge ony-badge">{{$counts['zz']}}</span></td>
                </tr>
                <tr>
                    <td data-id="zz" class="edit-btn" data-desc="添加商品" data-type="game" data-url="{{url('/admin/product/edit')}}?type=game">转转游戏<span class="layui-badge ony-badge">{{$counts['game']}}</span></td>
                </tr>
                <tr>
                    <td data-id="zz" class="edit-btn" data-desc="添加商品" data-type="xianyu" data-url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼商品<span class="layui-badge ony-badge">{{$counts['xianyu']}}</span></td>
                </tr>
                <tr>
                    <td data-id="zz" class="edit-btn" data-desc="添加商品" data-type="pdd" data-url="{{url('/admin/product/edit')}}?type=pdd">拼多多商品<span class="layui-badge ony-badge">{{$counts['pdd']}}</span></td>
                </tr>
                <tr>
                    <td data-id="zz" class="edit-btn" data-desc="添加商品" data-type="taobao" data-url="{{url('/admin/product/edit')}}?type=taobao">淘宝商品<span class="layui-badge ony-badge">{{$counts['taobao']}}</span></td>
                </tr>
                <tr>
                    <td class="edit-btn" data-type="jd">京东商品<span class="layui-badge ony-badge">0</span></td>
                </tr>
                <tr>
                    <td class="edit-btn" data-type="liequ">猎趣商品<span class="layui-badge ony-badge">0</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
@endsection
@section('js')
<script>
   var vue = 1;

   function jump(type){
        {{--window.location.href = "{{url('/admin/product/edit')}}?type=" + type;--}}

   }
   layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog',   'element'], function() {
       var form = layui.form(),
           layer = layui.layer,
           $ = layui.jquery,
           dialog = layui.dialog;






           //获取当前iframe的name值
       var iframeObj = $(window.frameElement).attr('name');
       $('#mytable').on('click', '.edit-btn', function() {






           var That = $(this);
           var url=That.attr('data-url');
           var desc=That.attr('data-desc');
           var type = That.attr('data-type');
           if(type === 'jd' || type === 'liequ' || type === 'game' || type === 'taobao' || type === 'pdd'){
               layer.msg('别着急,技术员正在努力研发中....', {time: 1000});
               return false;
           }

           @if($user['role'] != 'Super')
               var currentTime = '{{$user['current_time']}}';
               var overOuttime = '{{$user['over_outtime']}}';
               if(currentTime >= overOuttime){
                   layer.msg('账号已过期', {time: 1000});
                   return false;
               }

               var is_zhuanzhuan = {{$user['is_zhuanzhuan']}}
               var is_game = {{$user['is_game']}}
               var is_xianyu = {{$user['is_xianyu']}}
               var is_taobao = {{$user['is_taobao']}}
               switch(type){
               case 'zz':
                   if(is_zhuanzhuan !== 1){
                       layer.msg('您无权使用该功能', {time: 1000});
                       return false;
                   }
                   break;
               case 'game':
                   if(is_game !== 1){
                       layer.msg('您无权使用该功能', {time: 1000});
                       return false;
                   }
                   break;
               case 'xianyu':
                   if(is_xianyu !== 1){
                       layer.msg('您无权使用该功能', {time: 1000});
                       return false;
                   }
                   break;
               case 'taobao':
                   if(is_taobao !== 1){
                       layer.msg('您无权使用该功能', {time: 1000});
                       return false;
                   }
                   break;
               }



           @endif





           //将iframeObj传递给父级窗口
           parent.page(desc, url, iframeObj, w = "700px", h = "620px");
           return false;
       })
   });

</script>
@endsection
@extends('common.common')