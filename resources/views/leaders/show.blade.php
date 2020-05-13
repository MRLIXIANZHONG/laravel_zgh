@section('title', '方案领导查看')
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/leaders" >返回</a>
    </div>
    <form class="layui-form">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" value="{{!empty($leaders['id']) ? $leaders['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">企业名：</label>
            <div class="layui-input-block">
                <input type="text" value="{{isset($leaders->organization->name)?$leaders->organization->name:''}}" name=""   autocomplete="off" class="layui-input">
            </div>

        </div>

        <input type="hidden" value="{{!empty($leaders['organizationId']) ? $leaders['organizationId'] : 0}}" name="organizationId" required lay-verify="organizationId" autocomplete="off" class="layui-input">

        <div class="layui-form-item">
            <label class="layui-form-label">姓名：</label>
            <div class="layui-input-block">
                <input type="text" value="{{!empty($leaders['name']) ? $leaders['name'] : ''}}" name="name"  autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">头像：</label>
            <div class="layui-input-block">
                <img height="50" width="50" src="{{$leaders['img_url']}}" alt="">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">电话：</label>
            <div class="layui-input-block">
                <input type="text" value="{{!empty($leaders['phone']) ? $leaders['phone'] : ''}}" name="phone" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">岗位：</label>
            <div class="layui-input-block">
                <input type="text" value="{{!empty($leaders['position']) ? $leaders['position'] : ''}}" name="position" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">职责：</label>
            <div class="layui-input-block">
                <input type="text" value="{{!empty($leaders['duty']) ? $leaders['duty'] : ''}}" name="duty" required lay-verify="duty" autocomplete="off" class="layui-input">
            </div>

        </div>
    </form>
@endsection



