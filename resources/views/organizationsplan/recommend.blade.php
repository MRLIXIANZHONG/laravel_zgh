@extends('common.list')
@section('title', '推荐方案')
<script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/jquery.min.js?v={{rand(0,9999)}}"></script>
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
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('admin/organizationsplan/storerecommend')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{!empty($inputs['plan_name']) ? $inputs['plan_name'] : ''}}" name="plan_name" placeholder="请输方案名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal" id="senddate">提交</a>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
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
            <th class="hidden-xs">参赛企业</th>
            <th>方案名称</th>
            <th>是否推荐</th>
        </tr>
        </thead>
        <tbody>
        @foreach($OrganizationsPlans as $item)
            <tr>
                <td class="hidden-xs">{{$item->Organization->name}}</td>
                <td>{{$item['plan_name']}}</td>
                <td>
                    <input type="checkbox" @if($item['isrecommend']===1)checked @endif value="{{$item['id']}}" lay-skin="switch">
                </td>
            </tr>
        @endforeach
        @if(empty($OrganizationsPlans))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        @if(!empty($pagelimite))
            {{$OrganizationsPlans->links()}}
        @endif
    </div>
@endsection
@section('js')
    <script>
        var recommendpage={
            arr_box_old:[],
            arr_box_0:[],
            arr_box_1:[],
            load_arr_box_old:function(){
                recommendpage.arr_box_old.length=0;
                $('input[type=checkbox]').each(function() {
                    var flag=this.checked;
                    if(flag)
                    recommendpage.arr_box_old.push($(this).val()+'-'+1);
                    else
                    recommendpage.arr_box_old.push($(this).val()+'-'+0);
                });
                //console.log(recommendpage.arr_box_old);
            }
        }

        $("#senddate").click(function () {
            recommendpage.arr_box_0.length=0;
            recommendpage.arr_box_1.length=0;
            var arr_box = [];
            var i=0;
            var obj=null;
            var flag=false;
            $('input[type=checkbox]').each(function() {
                flag=this.checked;
                if(flag){
                    obj=$(this).val() + '-' + 1;
                    if(obj!=recommendpage.arr_box_old[i])
                        recommendpage.arr_box_1.push($(this).val());
                }
                else {
                    obj = $(this).val() + '-' + 0;
                    if (obj != recommendpage.arr_box_old[i])
                        recommendpage.arr_box_0.push($(this).val());
                }
                i++;
            });

            var strarr_box_1="";
            var strarr_box_0="";
            //拼接字符串
            for(var j=0;j<recommendpage.arr_box_1.length;j++){
                strarr_box_1=strarr_box_1+recommendpage.arr_box_1[j]+",";
            }

            //拼接字符串
            for(var j=0;j<recommendpage.arr_box_0.length;j++){
                strarr_box_0=strarr_box_0+recommendpage.arr_box_0[j]+",";
            }
            strarr_box_1=strarr_box_1.substring(0,strarr_box_1.length-1);
            strarr_box_0=strarr_box_0.substring(0,strarr_box_0.length-1);
            $.ajax({
                type: "POST",
                url: "/admin/organizationsplan/storerecommend",
                data: {isrecommend:strarr_box_1,notrecommend : strarr_box_0,_token:"{{csrf_token()}}"},
                dataType: 'json',
                success: function (data) {
                    if(data.code==1000)
                        layer.msg('修改成功');
                    else
                        layer.msg(data.msg);
                },
            });

            //console.log(strarr_box_0);
            //console.log(strarr_box_1);
            recommendpage.load_arr_box_old();
        });

        document.ready=recommendpage.load_arr_box_old();
    </script>
@endsection