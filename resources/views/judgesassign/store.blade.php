@section('title', '专家指派添加')
<link rel="stylesheet" href="/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/judgesassign/index" >返回</a>
    </div>
    <form class="layui-form tc-container" action="/admin/judgesassign/store" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>评审专家名称：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="50" value="" name="name" lay-verify="required" placeholder="请输入评审专家名称(最多50个字符)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专家团队数量	：</label>
            <div class="layui-input-block">
                <input type="number" value="" oninput="if(value.length>3)value=value.slice(0,3)" name="judesCount" lay-verify="required" placeholder="请输入专家团队数量(最多3位数)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>备选专家数量：</label>
            <div class="layui-input-block">
                <input type="number" value="" oninput="if(value.length>3)value=value.slice(0,3)" name="bakjudesCount" lay-verify="required" placeholder="请输入备选专家数量(最多3位数)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>名单确认截止时间：</label>
            <div class="layui-input-block">
                <input type="text" name="endtime" id="endtime" lay-verify="required" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">专家指派状态</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="radio" name="state" value="0" title="待审核">--}}
{{--                <input type="radio" name="state" value="1" title="已审核">--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="layui-form-item">
            <label class="layui-form-label">选择评选活动：</label>
            <div class="layui-input-block">
                <select name="case_schemes_id" lay-filter="case_schemes_id">
                    @foreach($caseSchemes as $item)
                        <option value="{{$item['id']}}">{{$item['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        layui.use('laydate', function(){
            var endtime = layui.laydate;
            //常规用法
            endtime.render({
                elem: '#endtime'
            });
        });
        
        layui.use(['form'], function () {
            var form = layui.form();
            form.render();
            this.disabled=true;
            form.on('submit(formDemo)', function (data) {
                $.ajax({
                    url: "/admin/judgesassign/store",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)    {
                            layer.msg('添加成功', {icon: 6},function () {
                                var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            });
                            window.location.href="/admin/judgesassign/index";
                        }
                        else
                            layer.msg('修改失败');
                        this.disabled=false;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                        this.disabled=false;
                    }
                });
                return false;
            });
        });
    </script>
@endsection


