@section('title', '订单列表')
<script src="/static/admin/js/jquery.min.js"></script>
<style>
    .chaochu{
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
    }
    .font-display{
        width:140px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
        text-align: center;
    }
</style>
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col width="50">
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="80">
            <col width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th>操作</th>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">订单号</th>
            <th>买家名称</th>
            <th class="hidden-xs">商品名称</th>
            <th class="hidden-xs">商品类型</th>
            <th class="hidden-xs">联系方式</th>
            <th class="hidden-xs">收货地址</th>
            <th class="hidden-xs">邮编</th>
            <th class="hidden-xs">操作</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
{{--        @foreach($logs as $log)--}}
            <tr v-for="item,index in list">
                <td><div class="layui-btn" @click="copyText(item.buyer_name + ' ' + item.buyer_phone + ' ' + item.address + ' ' + item.zip_code)">复制</div></td>
                <td class="hidden-xs">@{{ item.id }}</td>
                <td class="hidden-xs">@{{ item.order_number }}</td>
                <td><div class="font-display">@{{ item.buyer_name }}</div></td>
                <td class="hidden-xs">@{{ item.product ? item.product.product_name : '' }}</td>
                <td class="hidden-xs">@{{ item.product ? productType[item.product.type] : '' }}</td>
                <td class="hidden-xs"><div class="font-display">@{{ item.buyer_phone }}</div></td>
                <td class="hidden-xs"><div class="font-display">@{{ item.address }}</div></td>
                <td class="hidden-xs">@{{ item.zip_code }}</td>
                <td class="hidden-xs"><a href="#" style="color:#0070b8;" @click="deleteOrder(item.id)">删除</a><span  v-if="item.product">|</span><a
                            v-if="item.product" href="#" style="color:#0070b8;" @click="updateProduct(item.product.id)">改</a></td>
                <td>@{{ item.created_at }}</td>
            </tr>
{{--        @endforeach--}}
{{--        @if(empty($logs))--}}
{{--            <tr><td colspan="6" style="text-align: center;color: orangered;">暂无数据</td></tr>--}}
{{--        @endif--}}
        </tbody>
    </table>
    <div id="page"></div>

@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {

        });


        var app = new Vue({
            el:"#app",
            data(){
                return {
                    pageNumber:1,
                    pageCount:0,
                    list:[],
                    total:0,
                    productType:{'xianyu':"闲鱼","zz":"转转","pdd":"拼多多","game":"转转游戏","taobao":"淘宝"},
                    interval:null,
                    initpageTotal:0
                }
            },
            methods:{
                getData(first){
                    axios.post('{{url("/admin/order/list")}}' + '?page=' + this.pageNumber,{
                        _token:'{{csrf_token()}}'
                    })
                    .then((response)=>{

                        this.list = response.data.data
                        this.total = response.data.total
                        this.pageCount =  Math.ceil(this.total / response.data.per_page);

                        if(this.initpageTotal === 0){
                            this.initpageTotal = this.total
                        }

                        if(first){
                            this.sumPage()
                        }else if(this.initpageTotal !== this.total){


                            this.initpageTotal = this.total;
                            this.sumPage(this.pageNumber)
                        }
                    })
                    .catch((error) => {

                    })
                },
                sumPage(curr){
                    layui.use(['laypage', 'layer'], ()=>{
                        var laypage = layui.laypage
                            ,layer = layui.layer;


                        let option = {
                            cont: 'page'
                            ,pages: this.pageCount //总页数
                            ,groups: 5 //连续显示分页数
                            ,jump:(res,first)=>{
                                if(!first){
                                    this.pageNumber = res.curr
                                    this.getData()
                                }
                            }
                        }
                        if(curr){
                            option.curr = curr;
                        }

                        laypage(option);
                    })
                },
                deleteOrder(id){
                    layui.use('layer', () => {
                        layer.confirm('确认要删除吗？', {
                            btn : [ '确定', '取消' ]//按钮
                        }, (index) => {
                            layer.close(index);

                            axios.post('{{url('/admin/order/delete/')}}' + '/' + id)
                                .then((res) => {
                                    this.getData()
                                    if(res.data.status){
                                        layer.msg(res.data.msg,{shift: 6,icon:6});
                                    }else{
                                        layer.msg(res.data.msg,{shift: 6,icon:5});
                                    }
                                });
                        });

                    });
                },
                updateProduct(productId){
                    let url = "{{url('/admin/product/edit')}}?id=" + productId;
                    let desc = "修改商品"
                    layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog',   'element'], ()=> {
                        var $ = layui.jquery;
                        var iframeObj = $(window.frameElement).attr('name');
                        //将iframeObj传递给父级窗口
                        parent.page(desc, url, iframeObj, w = "700px", h = "620px");
                    });
                },
                copyText(text){
                    $('body').append('<textarea id="copy" style="height: 100px;width: 100px;border: 0;opacity:0;">'+text+'</textarea>');
                    $('#copy').select();
                    document.execCommand("Copy");
                    $('#copy').remove();
                }
            },
            created(){
                this.getData(true)
                this.interval = setInterval(()=>{
                    this.getData()
                },5000)

            }
        });
    </script>
@endsection
@extends('common.list')