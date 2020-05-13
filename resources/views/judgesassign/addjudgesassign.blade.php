@extends('common.list')
@section('title', '手动添加专家')
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
@section('title')

@endsection

@section('header')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/judgesassign/randomjudges?id={{$judgesassignid}}" class="layui-btn layui-btn-normal">返回</a>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
        <colgroup>
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">序号</th>
            <th class="hidden-xs">专家姓名</th>
            <th>专家头像</th>
            <th>是否添加</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Judges as $k=> $item)
            <tr>
                <td>{{$k+1}}</td>
                <td class="hidden-xs">{{$item->name}}</td>
                <td><img height="100" width="100" src="{{$item->photo}}" alt=""> </td>
                <td>
                    <a target="_self" class="layui-btn layui-btn-blue addjudges" value="{{$item->id}}"><i class="layui-icon">&#xe654;</i>添加为专家</a>
                    <a target="_self" class="layui-btn layui-btn-blue addbakjudges" value="{{$item->id}}"><i class="layui-icon">&#xe654;</i>添加为备选专家</a>
                </td>
            </tr>
        @endforeach
        @if(empty($Judges))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
@endsection
@section('js')
    <script>
        $(".addjudges").click(function () {
            var judesId=this.attributes['value'].value;
            $.ajax({
                url:"/admin/judgesassign/addjudgesassign",
                data:{
                    judesId:judesId,
                    judesType:1,
                    id:{{$judgesassignid}},
                    _token:'{{csrf_token()}}'
                },
                type:'post',
                dataType:'json',
                success:(res) => {
                    if(res.code==1000){
                        layer.msg('修改成功',function () {
                            window.location.reload();
                        });
                    }
                      else{
                        layer.msg(res.msg);
                    }
                }
            });
        })
        $(".addbakjudges").click(function () {
            var judesId=this.attributes['value'].value;
            $.ajax({
                url:"/admin/judgesassign/addjudgesassign",
                data:{
                    judesId:judesId,
                    judesType:2,
                    id:{{$judgesassignid}},
                    _token:'{{csrf_token()}}'
                },
                type:'post',
                dataType:'json',
                success:(res) => {
                    if(res.code==1000){
                        layer.msg('修改成功',function () {
                            window.location.reload();
                        });
                    }
                    else{
                        layer.msg(res.msg);
                    }
                }
            });
        })
    </script>
@endsection
