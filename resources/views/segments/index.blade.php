@extends('common.list')
@section('title', '方案活动列表')
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
</style>
@section('header')
    <div class="layui-inline">
        <a class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" href="{{url('/admin/segments?organizationplanid='.$organizationplanid.'&organizationid='.$organizationid)}}"><i class="layui-icon">&#x1002;</i></a>
    </div>
    <div class="layui-inline">
        <input type="hidden" value="{{$checkSegment->getOrganizationPlanId()}}" name="organization_plan_id" class="layui-input">
        <input type="hidden" value="{{$checkSegment->getOrganizationId()}}" name="organization_id" class="layui-input">
        <input type="text" value="{{$checkSegment->getName()}}" name="name" placeholder="请输活动名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        <a href="/admin/segments/store?organizationplanid={{$organizationplanid}}&organizationid={{$organizationid}}" target="_self" class="layui-btn layui-btn-normal" >添加活动</a>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;z-index: 999999999 ">
        <a href="/admin/organizationsplan" class="layui-btn layui-btn-normal">返回</a>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col width="100">
            <col width="100">
            <col width="100">
            <col width="100">
            <col width="100">
            <col width="100">
{{--            <col width="100">--}}
            <col width="200">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th>参赛企业ID</th>
            <th>阶段数</th>
            <th>阶段名</th>
            <th >介绍，描述</th>
            <th>开始时间</th>
            <th>结束时间</th>
{{--            <th>审核状态</th>--}}
            <th>操作</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($segments as $item)
            <tr>
                <td>{{$item['organization_id']}}</td>
                <td>{{$item['stage_number']}}</td>
                <td>{{$item['name']}}</td>
                <td class="showtips skill">{{$item['describe']}}</td>
                <td>{{$item['start_time']}}</td>
                <td>{{$item['end_time']}}</td>
{{--                <td class="showtips">--}}
{{--                    @if($item['check_state']==0)--}}
{{--                        未审核--}}
{{--                    @elseif($item['check_state']==1)--}}
{{--                        审核通过--}}
{{--                    @elseif($item['check_state']==-1)--}}
{{--                        审核驳回--}}
{{--                    @endif--}}
{{--                </td>--}}
                <td>
                    <a href="/admin/segments/show?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small" >查看</a>
                    <a href="/admin/segments/update?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small" >修改</a>
                    <a href="#" class="layui-btn layui-btn-small" @click="deleteProduct('{{$item['id']}}')">删除</a>
                </td>
                <td>{{$item['created_at']}}</td>
            </tr>
        @endforeach
        @if(empty($segments))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$segments->appends([
            'name'=>$checkSegment->getName(),
            'organization_plan_id'=>$checkSegment->getOrganizationPlanId(),
             'organization_id'=>$checkSegment->getOrganizationId()
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
                                url:"/admin/segments/destroy",
                                data:{
                                    id:id,
                                    _token:'{{csrf_token()}}'
                                },
                                type:'post',
                                dataType:'json',
                                success:(res) => {
                                    if(res.code==1000)   {
                                        layer.msg('删除成功',function () {
                                            window.location.reload()
                                        });
                                    }

                                    else
                                        layer.msg(res.msg,function () {
                                            window.location.reload()
                                        });
                                }
                            })
                        }
                    })
                },

            },
        })
    </script>
@endsection
