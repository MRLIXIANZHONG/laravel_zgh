@section("content")
<body>
    <style>
        .myForm {margin: 20px;}
    </style>
    <form class="myForm">
        <div class="layui-form-item">
            <label class="layui-form-label">标题：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($caseFile['name']) ? $caseFile['name'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标：</label>
            <div class="layui-input-block">
                @if(!empty($caseFile['icon']))
                    <img style="height: 200px;width: 150px;" src="{{$caseFile['icon'] }}" alt="">
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文件类型：</label>
            <div class="layui-input-block">
                @if($caseFile['type']==1)
                    活动文件
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseFile['status'] ? '开启' : '关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否推送到前台：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseFile['is_push'] ? '推送到前台' : '不推送到前台'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片：</label>
            <div class="layui-input-block">
                @foreach(explode(',',$caseFile['img']) as $imgUrl)
                    <img src="{{$imgUrl}}" style="width: 200px;height: 200px;" alt="">
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">文件：</label>
            <div class="layui-input-block">
                @foreach(explode(',',$caseFile['file']) as $fileUrl)
                    <a href="{{$fileUrl}}"> {{pathinfo($fileUrl)['basename']}}</a> <br>
                @endforeach
            </div>
        </div>
    </form>
</body>
@endsection
@section('js')

@endsection
@extends('common.editTwo')
