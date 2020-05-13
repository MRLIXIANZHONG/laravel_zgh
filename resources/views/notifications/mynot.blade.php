@section('title', '消息列表')
@section('header')
    <div class="layui-inline">
    <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{ old('title') }}" name="title"
               placeholder="请输入消息标题" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="status" lay-filter="type" lay-verify="type">
            <option value="0" {{ old('status') ==''? 'selected' : '' }}>请选择状态</option>
            <option value="1" {{ old('status') ==1? 'selected' : '' }}>已读</option>
            <option value="2" {{ old('status') ==2? 'selected' : '' }}>未读</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>

    </div>
@endsection
@section('table')

    <table class="layui-table layui-form layui-border-box layui-table-view" lay-even lay-skin="nob">
        <thead>
        <tr>
            <th class="">ID</th>
            <th class="">消息标题</th>
            <th class="hidden-xs">发布人</th>
            <th class="hidden-xs">状态</th>
            <th class="hidden-xs">发布时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($list))
        @foreach($list as $info)
            <tr>
                <td class="">{{$info['id']}}</td>
                <td class="">{{$info['title']}}</td>
                <td class="hidden-xs">{{$info['users']['username']}}</td>
                @if($info['read_at'])
                    <td class="hidden-xs">已读</td>
                @else
                    <td class="hidden-xs">未读</td>
                 @endif
                <td class="hidden-xs">{{$info['created_at'] ? $info['created_at'] : '--'}}</td>
                <td>
                    <div class="layui-inline">
{{--                            <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$info['id']}}" data-desc="查看消息" data-url="{{url('/admin/notificatinlist/notinfo/'.$info['id'])}}">查看消息</button>--}}
                        <button class="layui-btn layui-btn-small layui-btn-normal" data-id="{{$info['id']}}" data-desc="查看消息" data-url="{{url('/admin/notificatinlist/notinfo/'.$info['id'])}}">查看消息</button>
                    </div>
                </td>

            </tr>
        @endforeach
        @else

            <tr>
                <td colspan="6" style="text-align: center; color: rgb(255, 69, 0);">暂无数据</td>
            </tr>
         @endif
        </tbody>
    </table>

    {{ $list->links() }}

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

        $(".layui-btn").click(function () {
            var url=this.attributes['data-url'].value;
                layer.open({
                    type: 2,
                    title: '查看消息',
                    shadeClose: false,
                    shade: false,
                    maxmin: false, //开启最大化最小化按钮
                    area: ['893px', '600px'],
                    content: url,
                    end :function () {
                            window.location.reload();
                    }
                });
            })
        });
    </script>
@endsection
@extends('common.list')