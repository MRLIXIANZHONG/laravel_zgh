@extends('common.list')
@section('title', '推荐专家')
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
</style>
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('admin/judges/recommend')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{!empty($inputs['name']) ? $inputs['name'] : ''}}" name="name" placeholder="请输入专家姓名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal" id="senddate">提交</a>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/judges" class="layui-btn layui-btn-normal">返回</a>
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
            <th class="hidden-xs">专家姓名</th>
            <th>所属单位</th>
{{--            <th>方案概述</th>--}}
{{--            <th >方案内容</th>--}}
{{--            <th class="hidden-xs">方案目标</th>--}}
{{--            <th class="hidden-xs">绩效目标</th>--}}
{{--            <th class="hidden-xs">实施措施</th>--}}
{{--            <th class="hidden-xs">表彰奖励</th>--}}
{{--            <th>方案图片地址</th>--}}
{{--            <th>参赛员工</th>--}}
{{--            <th>方案状态</th>--}}
{{--            <th>级别</th>--}}
{{--            <th>点赞数</th>--}}
{{--            <th>浏览数</th>--}}
            <th>
                <!-- <a class="layui-btn layui-btn-normal" id="senddate">提交</a><br> -->
                是否推荐
            </th>
{{--            <th>创建时间</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($Judgeses as $item)
            <tr>
                <td class="hidden-xs">{{$item['id']}}</td>
                <td class="hidden-xs">{{$item['name']}}</td>
                <td>{{$item['department']}}</td>
{{--                <td>{{$item['summary']}}</td>--}}
{{--                <td>{{$item['content']}}</td>--}}
{{--                <td>{{$item['target_task']}}</td>--}}
{{--                <td>{{$item['achievement_target']}}</td>--}}
{{--                <td>{{$item['measures']}}</td>--}}
{{--                <td>{{$item['commend']}}</td>--}}
{{--                <td>{{$item['img_url']}}</td>--}}
{{--                <td>{{$item['staffs_info']}}</td>--}}
{{--                <td>{{$item['check_state']}}</td>--}}
{{--                <td>{{$item['grade']}}</td>--}}
{{--                <td>{{$item['star_count']}}</td>--}}
{{--                <td>{{$item['browse_count']}}</td>--}}
                <td>
                    <input type="checkbox" @if($item['isrecommend']===1)checked @endif value="{{$item['id']}}" lay-skin="switch">
                </td>
{{--                <td>{{$item['created_at']}}</td>--}}
            </tr>
        @endforeach
        @if(empty($Judgeses))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$Judgeses->links()}}
    </div>
@endsection
@section('js')
    <script>
        var   layer=null;
        layui.use('layer', function(){
            layer = layui.layer;
        });
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
                url: "/admin/judges/recommend",
                data: {isrecommend:strarr_box_1,notrecommend : strarr_box_0,_token:"{{csrf_token()}}"},
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000)
                        layer.msg('修改成功');
                    else
                        layer.msg(res.msg);
                },
            });

            recommendpage.load_arr_box_old();
        });

        document.ready=recommendpage.load_arr_box_old();
    </script>
@endsection