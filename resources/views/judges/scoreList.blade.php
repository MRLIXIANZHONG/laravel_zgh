@extends('common.list')
@section('title', '专家打分')
@section("title")
@endsection
@section('header')
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
            <a href="/admin/judges/score" class="layui-btn layui-btn-normal">返回</a>
        </div>
@endsection

@section('table')
<table class="layui-table" lay-even lay-skin="nob" id="app">
    <colgroup>
        <col width="100">
        <col width="150">
        <col width="300">
        <col width="300">
    </colgroup>
    <thead>
    <tr>
        <th>名称</th>
        <th>活动名</th>
        <th>分数</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @if($type!=7&&!empty($scores))
        @foreach($scores as $item)
        <tr>
            <td>{{$item->username}}</td>
            <td>{{$item->title}}</td>
            <td><input type="number" value="{{$item->score}}" id="score{{$item->userid}}"></td>
            <td><a href="#" target="_self" class="layui-btn layui-btn-normal senddata" scoreTypeId="{{$item->userid}}" caseSchemesid="{{$item->caseSchemesid}}" >提交</a></td>
        </tr>
        @endforeach
    @else
        @foreach($scores as $item)
        <tr>
            <td>{{$item->username}}</td>
            <td>{{$item->title}}</td>
            <td><input type="number" value="{{$item->score}}" id="score{{$item->userid}}"></td>
            <td><a href="#" target="_self" class="layui-btn layui-btn-normal senddata" scoreTypeId="{{$item->userid}}" caseSchemesid="{{$item->caseSchemesid}}" >提交</a></td>
        </tr>
        @endforeach
    @endif

    @if(empty($scores))
        <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
    @endif
    </tbody>
</table>
@endsection
@section("js")
    <script>
        $(".senddata").click(function(){
            var scoreTypeId=this.attributes['scoreTypeId'].value;
            var score=$("#score"+scoreTypeId).val();
            var caseSchemesid=this.attributes['caseSchemesid'].value;
            $.ajax({
                url: "{{url('/admin/judges/score')}}",
                data: {
                    scoreTypeId:scoreTypeId,
                    caseSchemesid:caseSchemesid,
                    scoreType:{{$type}},
                    score :score,
                    _token:"{{csrf_token()}}"
                },
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000)
                        layer.msg('打分成功',function () {
                            location.reload();
                        });
                    else
                        layer.msg(res.msg);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        });
    </script>

@endsection
