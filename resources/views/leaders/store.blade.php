@section('title', '方案领导添加')
@extends('common.common')
@section("content")
    <link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/leaders" >返回</a>
    </div>
    <form class="layui-form" action="/admin/leaders/store" method="post">
{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">企业名：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="text" value="{{$organization['name']}}" Readonly='true' class="layui-input">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <input type="hidden" value="{{$organization['id']}}" name="organizationId"  placeholder="请输入数字" autocomplete="off" class="layui-input">--}}
{{--        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">企业名:</label>
            <div class="layui-input-block">
                <select name="organization_Id" lay-filter="aihao">
                    @foreach($organization as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>领导姓名：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="191" value="" name="name" lay-verify="required" placeholder="请输入领导姓名(最多191字符)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>电话：</label>
            <div class="layui-input-block">
                <input type="phone" value="" maxlength="11" name="phone" lay-verify="required" placeholder="请输入电话" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>岗位：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="191" value="" name="position" lay-verify="required" placeholder="请输入岗位(最多191字符)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>职责：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="191" value="" name="duty" lay-verify="required" placeholder="请输入职责(最多191字符)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <!--图片上传-->
        <div class="layui-form-item">
            <label class="layui-form-label">添加领导图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" name="imgUrl" id="titval1" class="hide-val"  data-sum="0" />
                <p style="color:#999"></p>
                <div style="height:50px"></div>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
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
@section("js")
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        var abc = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#titval1',
            imgWrap: '.imgBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 4,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=leadersImg"
        });

        var img = '';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                abc.successDo(list[i],true);
            }
        }

        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            abc.delFile(this, url);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url, '_token':"{{csrf_token()}}"},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
        })

        layui.use(['form'], function () {
            var form = layui.form();
            form.render();
            form.on('submit(formDemo)', function (data) {
                this.disabled=true;
                $.ajax({
                    url: "{{url('/admin/leaders/store')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)    {
                            layer.msg('添加成功', {icon: 6},function () {
                                var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            });

                            window.location.href="/admin/leaders";
                        }
                        else
                            layer.msg('修改失败');
                        this.disabled=false;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        return false;
                    }
                });
                return false;
            });
        });
    </script>
@endsection("js")


