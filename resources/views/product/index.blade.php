@section('title', '商品列表')
<script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
<style>
    .editbtnblue{
        color:#01AAED;
    }
    .addproduct-ul{
        width: 100%;
        height: 50px;
        text-align: center;
        position: absolute;
        display: none;
    }
    .addproduct-li{
        /*border: 1px solid #cccccc;*/
        height:30px;
        line-height: 30px;
        background-color:#1E9FFF;
        color:white;
        white-space: nowrap;
        text-align: center;
        font-size: 14px;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        opacity: .9;
        border-top:1px solid white;
    }
</style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/product/list')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{!empty($inputs['product_name']) ? $inputs['product_name'] : ''}}" name="product_name" placeholder="请输入商品名" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="username">
            <option value="">请选择用户</option>
            <option value="">请选择用户</option>
            @foreach($users as $item)
                <option value="{{$item['id']}}" {{!empty($inputs['username']) && $inputs['username'] == $item['id'] ? 'selected' : ''}}>{{$item['username']}}</option>
            @endforeach
        </select>
    </div>



    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        <div class="layui-btn layui-btn-normal">快速添加商品</div>
        <ul class="addproduct-ul">
            <li class="addproduct-li" type="zz" url="{{url('/admin/product/edit')}}?type=zz">转转</li>
            <li class="addproduct-li" type="xianyu" url="{{url('/admin/product/edit')}}?type=xianyu">闲鱼</li>
        </ul>
    </div>

@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="80">
            <col width="250">
            <col width="100">
            <col width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="100">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">用户</th>
            <th>商品名称</th>
            <th>商品页</th>
            <th >类型</th>
            <th class="hidden-xs">上架</th>
            <th class="hidden-xs">隐藏</th>
            <th class="hidden-xs">验机</th>
            <th class="hidden-xs">浏览量</th>
            <th>操作</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td class="hidden-xs">{{$item['admin']['username']}}</td>
                <td>{{$item['product_name']}}</td>

                <td><a style="color:#0070b8;" class='copy' data-clipboard-action="copy" data-clipboard-text='{{$item['product_url']}}' href="#" @click="openurl('{{$item['product_url']}}')">商品页</a></td>
                <td>{{$types[$item['type']]}}</td>
                <td class="hidden-xs">
                    @if($item['is_sale'] == 1)
                        <span>是</span>|<a href="#" class="editbtnblue" @click="editStatus({{$item['id']}},'is_sale',0)">否</a>
                    @else
                        <a href="#" class="editbtnblue" @click="editStatus({{$item['id']}},'is_sale',1)">是</a>|<span href="">否</span>
                    @endif
                </td>
                <td class="hidden-xs">
                    @if($item['is_hidden'] == 1)
                        <span>是</span>|<a href="#" @click="editStatus({{$item['id']}},'is_hidden',0)" class="editbtnblue">否</a>
                    @else
                        <a href="#" class="editbtnblue" @click="editStatus({{$item['id']}},'is_hidden',1)">是</a>|<span>否</span>
                    @endif
                </td>
                <td class="hidden-xs">
                    @if($item['test_match'] == 1)
                        <span>是</span>|<a href="#" class="editbtnblue" @click="editStatus({{$item['id']}},'test_match',0)">否</a>
                    @else
                        <a href="#" class="editbtnblue" @click="editStatus({{$item['id']}},'test_match',1)">是</a>|<span href="">否</span>
                    @endif
                </td>
                <td class="hidden-xs">
                    {{$item['click_num']}}
                </td>
                <td>
                    <a href="#" class="editbtnblue editbtn" data-desc="修改商品" data-url="{{url('/admin/product/edit')}}?id={{$item['id']}}">改</a>
                    |
                    <a href="#" class="editbtnblue" @click="deleteProduct('{{$item['id']}}')">删</a>
                </td>
                <td>{{$item['created_at']}}</td>
            </tr>
        @endforeach
        @if(empty($list))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$listObj->render()}}
    </div>
@endsection
@section('js')
    <script>



        let app = new Vue({
            el:"#app",
            data(){
                return {

                }
            },
            methods:{
                editStatus(id,field,val){
                    layui.use('jquery',()=>{
                        var $ = layui.jquery;
                        $.ajax({
                            url:"{{url('/admin/product/statusEdit')}}",
                            data:{
                                field:field,
                                id:id,
                                val:val,
                                _token:'{{csrf_token()}}'
                            },
                            type:'post',
                            dataType:'json',
                            success:(res) => {
                                window.location.reload()
                            }

                        })
                    })
                },
                deleteProduct(id){
                    layui.use('jquery',()=>{
                        var $ = layui.jquery;
                        $.ajax({
                            url:"{{url('/admin/product/delete')}}",
                            data:{
                                id:id,
                                _token:'{{csrf_token()}}'
                            },
                            type:'post',
                            dataType:'json',
                            success:(res) => {
                                window.location.reload()
                            }

                        })
                    })
                },
                openurl(url){
                    if(url === '' || (typeof url == 'undefined')){
                        alert('请设置域名！');


                        window.parent.changeUserInfo()

                        return;
                    }
                    if(window.plus){
                        plus.runtime.openURL(url);
                    }else if(typeof require != 'undefined'){
                        var shell = require('electron').shell;
                        shell.openExternal(url);
                    }else{
                       // top.location.href = url;
                       window.open(url)
                    }
                }
            },
            created(){
                layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {
                    var form = layui.form(),
                        $ = layui.jquery,
                        dialog = layui.dialog,
                        layer = layui.layer
                    ;
                    form.render();
                    $('.fresh').mouseenter(function() {
                        dialog.tips('刷新页面', '.fresh');
                    })
                    $('.fresh').click(function() {
                        window.location.reload()
                    });
                });


                layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog',   'element'], function() {
                    var $ = layui.jquery;
                    var iframeObj = $(window.frameElement).attr('name');
                    $('#app').on('click', '.editbtn', function() {
                        var That = $(this);
                        var url=That.attr('data-url');
                        var desc=That.attr('data-desc');

                        //将iframeObj传递给父级窗口
                        parent.page(desc, url, iframeObj, w = "700px", h = "620px");
                        return false;
                    })





                    $(".addproduct-div").hover(
                        function () {
                            $('.addproduct-ul').show();
                        },
                        function () {
                            $('.addproduct-ul').hide();
                        }
                    );

                    $('.addproduct-li').click(function(){
                        var type = $(this).attr('type');
                        var url = $(this).attr('url');
                        @if($user['role'] != 'Super')
                            var currentTime = '{{$user['current_time']}}';
                            var overOuttime = '{{$user['over_outtime']}}';
                            if(currentTime >= overOuttime){
                                layer.msg('账号已过期', {time: 1000});
                                return false;
                            }

                            var is_zhuanzhuan = {{$user['is_zhuanzhuan']}}
                            var is_xianyu = {{$user['is_xianyu']}}
                                switch(type){
                                case 'zz':
                                    if(is_zhuanzhuan !== 1){
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

                            }


                        @endif





                        //将iframeObj传递给父级窗口
                        parent.page("添加商品", url, iframeObj, w = "700px", h = "620px");
                    });
                });



                var clipboard = new ClipboardJS('.copy');
                clipboard.on('success', function(e) {
                    alert('网址已复制，如若浏览器打不开请手动在浏览器粘贴链接。');
                    console.log(e);
                });

                clipboard.on('error', function(e) {
                    console.log(e);
                });
            }
        })

    </script>
@endsection
@extends('common.list')