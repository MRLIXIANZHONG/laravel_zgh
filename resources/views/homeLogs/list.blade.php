@section('title', '日志管理')
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
        <div class="layui-btn layui-btn-danger deletelog" style="width:100px;height:35px;"><i class="layui-icon">全部删除</i></div>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="80">
            <col>
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">商品id</th>
            <th>商品标题</th>
            <th class="hidden-xs">URL</th>
            <th class="hidden-xs">动作</th>
            <th class="hidden-xs">IP</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td class="hidden-xs">{{$log['id']}}</td>
                <td class="hidden-xs">{{$log['product_id']}}</td>
                <td>{{$log['title']}}</td>
                <td class="hidden-xs">{{$log['url']}}</td>
                <td class="hidden-xs">{{$log['action']}}</td>
                <td class="hidden-xs">{{$log['ip']}}</td>
                <td>{{$log['created_at']}}</td>
            </tr>
        @endforeach
        @if(empty($logs))
            <tr><td colspan="6" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$logsPage->links()}}
    </div>
@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                dialog = layui.dialog
            ;
            form.render();
            form.on('submit(formDemo)', function(data) {
                console.log(data);
            });


            $('.deletelog').click(()=>{
                $.ajax({
                    url:"{{url('/admin/homelog/delete')}}",
                    method:'post',
                    data:{
                        _token:'{{csrf_token()}}'
                    },
                    success:(res)=>{
                        alert('删除成功');
                        window.location.reload()
                    }
                });
            });
        });


        setInterval(()=>{
            window.location.reload()
        },5000);
    </script>
@endsection
@extends('common.list')