@extends('common.list')
@section('title', '专家指派列表')
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
    .skill{
        width: 200px;
        height:100px;
        overflow: hidden;
        display: block;
    }
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/judgesassign/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$checkJudgesAssign->getName()}}" name="name" placeholder="请输指派名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        @if($userrole==6)
        <a href="/admin/judgesassign/store" target="_self" class="layui-btn layui-btn-normal" id="addjudgesassign" >添加指派</a>
        <a href="/admin/judgesassign/expore" target="_self" class="layui-btn layui-btn-normal" id="expore" style="margin-left: 10px">导出</a>
        @endif
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
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
            <th>序号</th>
            <th>评审专家名称</th>
            <th>专家团队数量</th>
            <th>备选专家数量</th>
            <th>名单确认截止时间</th>
            <th>专家指派状态</th>
            <th>驳回理由</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($judgesassign as $k=> $item)
            <tr>
                <td>{{$k+1}}</td>
                <td>{{$item['name']}}</td>
                <td>{{$item['judesCount']}}</td>
                <td>{{$item['bakjudesCount']}}</td>
                <td>{{$item['endtime']}}</td>
                <td>
                    @if($item['state']==0)
                            待审核
                    @elseif($item['state']==1)
                            已审核
                    @elseif($item['state']==-1)
                            驳回
                    @endif
                </td>
                <td>{{$item['nopassinfo']}}</td>
                <td>
                    @if($userrole==6)
{{--                    <a href="/admin/judgesassign/randomjudges?id={{$item['id']}}"   target="_self" class="layui-btn layui-btn-small layui-btn-blue" >专家抽取</a>--}}
                    @if($item['state']==1)
                    <button class="layui-btn layui-btn-small layui-btn-blue" @click="checktime('{{$item['id']}}','{{$item['endtime']}}')">
                        <i class="layui-icon">&#xe624;</i>专家抽取
                    </button>
                    @endif
                    <a href="/admin/judgesassign/update?id={{$item['id']}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe642;</i>修改
                    </a>
                    <button class="layui-btn layui-btn-small layui-btn-danger" @click="deleteProduct('{{$item['id']}}')">
                        <i class="layui-icon">&#xe640;</i>删除
                    </button>
                    @endif
                    @if($userrole==5&&$item['state']==0)
                    <button class="layui-btn layui-btn-small layui-btn-blue" @click="updateProduct('{{$item['id']}}',1)">
                        <i class="layui-icon">&#xe605;</i>通过
                    </button>
                    <button class="layui-btn layui-btn-small layui-btn-blue" @click="updateProduct('{{$item['id']}}',-1)">
                        <i class="layui-icon">&#x1006;</i>驳回
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
        @if(empty($judgesassign))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$judgesassign->appends(['name'=>$checkJudgesAssign->getName()])->render()}}
    </div>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
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
                                url:"/admin/judgesassign/destroy",
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
                updateProduct(id,state){
                    $.ajax({
                        url:"/admin/judgesassign/update",
                        data:{
                            id:id,
                            state:state,
                            _token:'{{csrf_token()}}'
                        },
                        type:'post',
                        dataType:'json',
                        success:(res) => {
                            if(res.code==1000)
                                    if(state==-1){
                                            layer.open({
                                                type: 2,
                                                title: '',
                                                shadeClose: true,
                                                shade: false,
                                                maxmin: true, //开启最大化最小化按钮
                                                area: ['893px', '600px'],
                                                content: "/admin/judgesassign/update?id="+id+"&editType=1",
                                                cancel: function(){
                                                    window.location.reload();
                                                }
                                        })
                                    }
                                    else  {
                                        layer.msg('修改成功',function () {
                                            window.location.reload() ;
                                        });
                                    }
                            else
                                layer.msg(res.msg);
                        }
                    })
                },
                checktime(id,endtime) {
                    var  d=new   Date(Date.parse(endtime .replace(/-/g,"/")));
                    var  curDate=new   Date();
                    if(d >curDate){
                        window.location.href="/admin/judgesassign/randomjudges?id="+id;
                    }else{
                        layer.msg('已超过时间');
                    }
                }
            },
        })
    </script>
@endsection





