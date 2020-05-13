@extends('common.list')
@section('title', '专家荣耀列表')
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
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/honorjudgesjudges/List?id=').$JudgesId}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="hidden" name="judges_id" value="{{$checkhonorjudges->getJudgesid()}}">
        <input type="text" value="{{$checkhonorjudges->getName()}}" name="name" placeholder="请输荣耀名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        <a href="/admin/honorjudges/store?JudgesId={{$JudgesId}}" target="_self" class="layui-btn layui-btn-normal" >添加专家荣耀</a>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/judges" class="layui-btn layui-btn-normal">返回</a>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <thead>
        <tr>
            <th style="min-width: 150px">荣耀名</th>
            <th style="min-width: 150px">获得时间</th>
            <th>荣耀介绍</th>
            <th style="min-width: 150px">创建时间</th>
            <th style="min-width: 220px">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($honorjudges as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>{{$item['honor_time']}}</td>
                <td class="showtips">{{$item['content']}}</td>
                <td>{{$item['created_at']}}</td>
                <td>
                    <a href="/admin/honorjudges/show?id={{$item['id']}}&JudgesId={{$JudgesId}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe615;</i>查看
                    </a>
                    <a href="/admin/honorjudges/edit?id={{$item['id']}}&JudgesId={{$JudgesId}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe642;</i>修改
                    </a>
                    <button class="layui-btn layui-btn-small layui-btn-danger" @click="deleteProduct('{{$item['id']}}')">
                        <i class="layui-icon">&#xe640;</i>删除
                    </button>
                </td>
            </tr>
        @endforeach
        @if(empty($honorjudges))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$honorjudges->appends([
                'name'=>$checkhonorjudges->getName(),
                'judges_id'=>$checkhonorjudges->getJudgesid()
                ])->render()}}
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
                    tips =layer.tips(this.innerText,that,{area: 'auto',maxWidth: '500'});
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
                                url:"/admin/honorjudges/destroy",
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
                        }
                    })
                },

            },
        })
    </script>
@endsection





