@section('title', '专题详情')
<style>
    .layui-input-block {
        line-height: 36px;
    }
</style>
@section('content')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">专题标题：</label>
        <div class="layui-input-block">
            {{$special['title']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">专题描述：</label>
        <div class="layui-input-block">
            {{$special['mark']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">banner：</label>
        <div class="layui-input-block">
            <ul class="imgBox" data-prompt-position="bottomLeft:130,-80">
                <li style='height: 300px;'><img style='width: auto;height: 100%;' src='{{$newsModel['banner']}}'/></li>
            </ul>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">专题头像：</label>
        <div class="layui-input-block">
            <ul class="imgBox" data-prompt-position="bottomLeft:130,-80">
                <li style='height: 150px;'><img style='width: auto;height: 100%;' src='{{$newsModel['title_img']}}'/>
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">活动精神：</label>
        <div class="layui-input-block">
            {!!  $newsModel['spirit']!!}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">主办单位：</label>
        <div class="layui-input-block">
            {{$special['sponsor_unit']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">备案号：</label>
        <div class="layui-input-block">
            {{$special['record_numbe']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">地址：</label>
        <div class="layui-input-block">
            {{$special['address']}}
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">邮编：</label>
        <div class="layui-input-block">
            {{$special['zip_code']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版权信息：</label>
        <div class="layui-input-block">
            {{$special['copyright_information']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">活动类型：</label>
        <div class="layui-input-block">
            @if($special['system_version']=='by')
                巴渝工匠
            @else
                网络竞技
            @endif
        </div>
    </div>

@endsection
@section('js')
    <script>
        function goBack() {
            history.go(-1);
        }　
        layui.use(['form'], function () {
            var form = layui.form();
            form.render();

        });
    </script>
@endsection
@extends('common.editTwo')
