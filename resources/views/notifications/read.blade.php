@section('title', '已读列表')
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
@endsection
@section('table')

    <table class="layui-table layui-form layui-border-box layui-table-view" lay-even lay-skin="nob">
        <thead>
        <tr>
            <th class="">ID</th>
            <th class="">已读人员</th>
            <th >阅读时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="">{{$info['id']}}</td>
                <td class="">{{$info['busers']['name']}}
                    @if(isset($info['organizations']))
                        {{'('.isset($info['organizations']['name'])?$info['organizations']['name']:''.')'}}
                    @endif
                </td>
                <td >{{$info['read_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $list->links()}}

@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                laydate = layui.laydate,
                layer = layui.layer
            ;
            form.render();
            form.on('submit(formDemo)', function(data) {
                console.log(data);
            });
        });
    </script>
@endsection
@extends('common.list')