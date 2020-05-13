@section('title', '方案活动创建')
<link rel="stylesheet" href="/static/upload/xUploader.css">
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <a href="{{"/admin/segments?organizationplanid=".$organizationplanid."&organizationId=".$organizationid}}" class="layui-btn layui-btn-normal">返回</a>
    </div>
    <form class="layui-form" action="/admin/segments/store" method="post">

{{--    <div class="layui-form-item">--}}
{{--        <label class="layui-form-label">企业名:</label>--}}
{{--        <div class="layui-input-block">--}}
{{--            <select name="organization_Id" lay-filter="aihao">--}}
{{--                @foreach($organization as $item)--}}
{{--                    <option value="{{$item['id']}}">{{$item['name']}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}
        <input type="hidden" value="{{$organizationid}}" name="organizationId" required lay-verify="organizationId" autocomplete="off" class="layui-input">

        <input type="hidden" value="{{$organizationplanid}}" name="organizationPlanId" required lay-verify="organizationPlanId" autocomplete="off" class="layui-input">

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>阶段数：</label>
        <div class="layui-input-block">
            <input type="number" oninput="if(value.length>11)value=value.slice(0,11)" value="" name="stageNumber" lay-verify="required" placeholder="请输入方案活动阶段数(最多11位数)" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>阶段名：</label>
        <div class="layui-input-block">
            <input type="text"  maxlength="11" value="" name="name" lay-verify="required" placeholder="请输入方案活动阶段名(最多11个字符)" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">阶段描述：</label>
        <div class="layui-input-block">
            <input type="text" maxlength="500" value="" name="describe"  placeholder="请输入阶段描述(最多500个字符)：" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>开始时间：</label>
        <div class="layui-input-block">
            <input type="text" name="start_time" id="start_time" lay-verify="required" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>结束时间：</label>
        <div class="layui-input-block">
            <input type="text" name="end_time" id="end_time" lay-verify="required" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
        </div>
    </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" id="img_url" name="img_url" class="hide-val" data-sum="0"/>
                <p style="color:#999">注：建议尺寸400像素*700像素，最多4张 </p>
                <div style="height:50px"></div>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案视频：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>
                    <div id="adBtn_video" class="adBtn l"></div>
                </div>
                <input type="hidden" id="video_url" name="video_url" class="hide-val" data-sum="0"/>

                <div style="height:50px"></div>
                <div class="progress1" style="display:none">
                    <span class="text1">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
            <a href="{{"/admin/segments?organizationplanid=".$organizationplanid."&organizationId=".$organizationid}}" class="layui-btn layui-btn-normal">返回</a>
        </div>
    </div>
    </form>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        layui.use('laydate', function(){
            var start_time = layui.laydate;
            //常规用法
            start_time.render({
                elem: '#start_time',
                format: 'yyyy-MM-dd',
                done: function (value, date, endDate) {
                    var startDate = new Date(value).getTime();
                    var endTime = new Date($('#end_time').val()).getTime();
                    if (endTime < startDate) {
                        layer.msg('结束时间不能小于开始时间');
                        $('#start_time').val($('#end_time').val());
                    }
                }
            });

            var end_time = layui.laydate;
            //常规用法
            end_time.render({
                elem: '#end_time',
                format: 'yyyy-MM-dd',
                done: function (value, date, endDate) {
                    var startDate = new Date($('#start_time').val()).getTime();
                    var endTime = new Date(value).getTime();
                    if (endTime < startDate) {
                        layer.msg('结束时间不能小于开始时间');
                        $('#end_time').val($('#start_time').val());
                    }
                }
            });
        });
        //加载图片
        var abc = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#img_url',
            imgWrap: '.imgBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 4,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=segmentsImg"
        });

        var img = '';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                abc.successDo(list[i],true);
            }
        }

        var abc1 = new xUploader({
            btn: '#adBtn_video',
            suportType: 'mp4',
            mimeTypes: '.mp4',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#video_url',
            imgWrap: '.imgBox1',
            upType: 'type4',
            imgLenth: '.imgBox1 .loading',
            maxLen: 4,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=segmentsvideo"
        });


        //加载视频
        var video = '';
        if (video) {
            var list = video.split(',');
            for (var i in list) {
                abc1.successDo(list[i],true);
            }
        }
        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                abc.delFile(this, url);
            if (!!urlVideo)
                abc1.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url || urlVideo,_token:"{{csrf_token()}}"},
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    layer.msg('删除成功');
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
                var  organizationplanid=data.form.elements[1].value;
                var  organizationid=data.form.elements[0].value;
                $.ajax({
                    url: "/admin/segments/store",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        this.disabled=false;
                        layer.msg('修改成功', {icon: 6},function () {
                            if(confirm("是否已填写完竞赛全阶段")){
                                layer.open({
                                    type: 2,
                                    title: '',
                                    shadeClose: true,
                                    shade: false,
                                    maxmin: true, //开启最大化最小化按钮
                                    area: ['893px', '600px'],
                                    content: '{{url("/admin/organizationsplan/update?id=".$organizationplanid."&editType=1")}}',
                                    cancel: function(){
                                        window.location.href='/admin/segments?organizationplanid='+organizationplanid+'&organizationid='+organizationid;
                                    }
                                });
                            }
                            else{
                                window.location.href='/admin/segments?organizationplanid='+organizationplanid+'&organizationid='+organizationid;
                            }
                        });
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        this.disabled=false;
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection


