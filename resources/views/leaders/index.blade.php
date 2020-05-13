@extends('common.list')
@section('title', '方案领导列表')
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
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/leaders')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$checkLeader->getName()}}" name="name" placeholder="请输专家姓名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        <a href="/admin/leaders/store" target="_self" class="layui-btn layui-btn-normal" >添加方案领导</a>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/organizationsplan" class="layui-btn layui-btn-normal">返回</a>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="300">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th>企业ID</th>
            <th>姓名</th>
            <th>电话</th>
            <th >岗位</th>
            <th>职责</th>
            <th>图片</th>
            <th>操作</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leaders as $item)
            <tr>
                <td class="showtips">{{$item['organization_id']}}</td>
                <td class="showtips">{{$item['name']}}</td>
                <td class="showtips">{{$item['phone']}}</td>
                <td class="showtips">{{$item['position']}}</td>
                <td class="showtips">{{$item['duty']}}</td>
                <td><img height="50" width="50" src="{{$item['img_url']}}" alt=""> </td>
                <td>
                    <a href="/admin/leaders/show?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small" >查看</a>
                    <a href="/admin/leaders/update?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small" >修改</a>
                    <a href="#" class="layui-btn layui-btn-small" @click="deleteProduct('{{$item['id']}}')">删除</a>
                </td>
                <td>{{$item['created_at']}}</td>
            </tr>
        @endforeach
        @if(empty($leaders))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$leaders->appends(['name'=>$checkLeader->getName()])}}
    </div>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function(){
            var tips;
            $(".showtips").on({
                mouseenter:function(){
                    var that = this;
                    tips =layer.tips(this.innerText,that,{area: 'auto',maxWidth: '700'});
                    //tips = layer.tips("智能组卷：每个用户考试时抽到的试题及顺序随机组成", that, {tips: 1});
                },
                mouseleave:function(){
                    layer.close(tips);
                }
            });
        });
        let app = new Vue({
            el:"#app",
            data(){
                return {

                }
            },
            methods:{
                deleteProduct(id){
                    layui.use('jquery',()=>{
                        var $ = layui.jquery;
                        if(confirm("确定删除吗")){
                            $.ajax({
                                url:"/admin/leaders/destroy",
                                data:{
                                    id:id,
                                    _token:'{{csrf_token()}}'
                                },
                                type:'post',
                                dataType:'json',
                                success:(res) => {
                                    if(res.code==1000)
                                        layer.msg('修改成功',function () {
                                            window.location.reload()
                                        });
                                    else
                                        layer.msg(res.msg);
                                }
                            })
                        }
                    })
                },

            },
        })
    </script>
@endsection





