@section('title', '方案活动添加')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
    </div>
    <form class="layui-form">
        @if(!empty($segments))
            @foreach($segments as $item)
                @if(empty($item['organization_plan_id']))
                <div>
                活动名：{{$item['name']}}
                阶段数: {{$item['stage_number']}}
                <input type="checkbox" value="{{$item['id']}}" lay-filter="demo2">
                </div>
                <br/>
                @endif
                @if(($item['organization_plan_id'])==$organizationsplanid)
                    <div>
                        活动名：{{$item['name']}}
                        阶段数: {{$item['stage_number']}}
                        <input type="checkbox" checked value="{{$item['id']}}" lay-filter="demo2">
                    </div>
                    <br/>
                @endif
            @endforeach
        @endif
    </form>
@endsection
@section("js")
    <script>
        var organizationsPlanID="{{$organizationsplanid}}";
        layui.use(['form'], function () {
            var form = layui.form();
            form.on('checkbox(demo2)', function (data) {
                var doit = data.elem.checked?1:0;
                $.ajax({
                    url: "{{url('/admin/organizationsplan/storesegments')}}",
                    data: {organizationsPlanID:organizationsPlanID,segmentsId:data.value,doIt:doit,_token:"{{csrf_token()}}"},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)
                            layer.msg('修改成功');
                        else
                            layer.msg(res.message,function () {
                                window.location.reload();
                            });
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            });
        });
    </script>
@endsection