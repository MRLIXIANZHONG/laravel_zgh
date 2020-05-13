@section('title', '方案领导添加')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
    </div>
<form class="layui-form">
@if(!empty($inleaders))
    @foreach($inleaders as $item)
            <div style="width: 20%;margin: 10px;float: left;">
                <div style="width: 150px;height: 200px;"><img height="200" width="150" src="{{$item['img_url']}}" alt=""></div>
                <div style="width: 150px;height: 200px;text-align: center;">
                    <input type="checkbox" title="{{$item['name']}}" value="{{$item['id']}}" lay-filter="demo2">
                </div>
            </div>
    @endforeach
@endif

@if(!empty($notinleaders))
    @foreach($notinleaders as $item)
            <div style="width: 20%;margin: 10px;float: left;">
                <div style="width: 150px;height: 200px;"><img height="200" width="150" src="{{$item['img_url']}}" alt=""></div>
                <div style="width: 150px;height: 200px;text-align: center;">
                    <input type="checkbox" title="{{$item['name']}}" value="{{$item['id']}}" lay-filter="demo2">
                </div>
            </div>
    @endforeach
@endif
@if(empty($inleaders)&&empty($notinleaders))
    <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
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
                    url: "{{url('/admin/organizationsplan/storeordestroyleaders')}}",
                    data: {organizationsPlanID:organizationsPlanID,leadersID:data.value,doIt:doit,_token:"{{csrf_token()}}"},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)
                            layer.msg('修改成功');
                        else
                            layer.msg(res.msg);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            });
        });
    </script>
@endsection