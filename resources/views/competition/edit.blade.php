<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section('title', '新闻编辑')

@section('content')
    <form class="layui-form tc-container" method="post">
        <input name="id" type="hidden" value="{{!empty($competition['id']) ? $competition['id'] : '0'}}">
        <input name="system_version" type="hidden">
        <input name="_token" type="hidden" value="{{csrf_token()}}">

        <div class="layui-form-item">
            <label class="layui-form-label">首页描述：</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea" maxlength="2000" lay-verify="required"
                          placeholder="请输入首页描述"
                          name="home_mark">{{!empty($competition['home_mark']) ? $competition['home_mark'] : ''}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">首页图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" id="home_imgBox" class="imgBox">
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" id="home_img" name="home_img" class="hide-val" data-sum="0"/>

                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">主题标题：</label>
            <div class="layui-input-block">
                <input type="text" lay-verify="required" maxlength="500"
                       value="{{!empty($competition['theme_title']) ? $competition['theme_title'] : ''}}"
                       name="theme_title" placeholder="请输入主题标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">主题描述：</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea" lay-verify="required"
                          placeholder="请输入主题描述"
                          name="theme_mark">{{!empty($competition['theme_mark']) ? $competition['theme_mark'] : ''}}</textarea>

            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">主题图标：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" id="theme_imgBox" class="imgBox">
                    <div id="adBtn1" class="adBtn l"></div>
                </div>
                <input type="hidden" id="theme_img" name="theme_img" class="hide-val" data-sum="0"/>

                <div class="progress1" style="display:none">
                    <span class="text1">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专题描述：</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea" maxlength="2000" lay-verify="required"
                          placeholder="请输入专题描述"   name="special_mark">{{!empty($competition['special_mark']) ? $competition['special_mark'] : ''}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专题图片：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img src="" id="special_imgBox" class="imgBox imgBo2">
                    <div id="adBtn2" class="adBtn l"></div>
                </div>
                <input type="hidden" id="special_img" name="special_img" class="hide-val" data-sum="0"/>

                <div class="progress2" style="display:none">
                    <span class="text2">0%</span>
                    <span class="percentage2" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">参与企业：</label>
            <div class="layui-input-block">
                <input type="radio" name="org_show" value="0"
                       title="关闭" {{ $competition['org_show'] ==0? 'checked' : '' }}>
                <input type="radio" name="org_show" value="1"
                       title="开启" {{ $competition['org_show'] ==1? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">竞赛新闻：</label>
            <div class="layui-input-block">
                <input type="radio" name="news_show" value="0"
                       title="关闭" {{ $competition['news_show'] ==0? 'checked' : '' }}>
                <input type="radio" name="news_show" value="1"
                       title="开启" {{ $competition['news_show'] ==1? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">竞赛视频：</label>
            <div class="layui-input-block">
                <input type="radio" name="video_show" value="0"
                       title="关闭" {{ $competition['video_show'] ==0? 'checked' : '' }}>
                <input type="radio" name="video_show" value="1"
                       title="开启" {{ $competition['video_show'] ==1? 'checked' : '' }}>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                {{--            <button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
   <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>

    <script>

        //加载首页图片
        var home_img = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#home_img',
            imgElement: '#home_imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=competitionImg"
        });
        home_img.successDo('{{$competition['home_img']}}',true);

        //加载主题图片
        var theme_img = new xUploader({
            btn: '#adBtn1',
            valueElement: '#theme_img',
            imgElement: '#theme_imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=competitionImg"
        });
        theme_img.successDo('{{$competition['theme_img']}}',true);

        //加载主题图片
        var special_img = new xUploader({
            btn: '#adBtn2',
            valueElement: '#special_img',
            imgElement: '#special_imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=competitionImg"
        });
        special_img.successDo('{{$competition['special_img']}}',true);

        //图片删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');

            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {url: url, _token: '{{csrf_token()}}'},
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
                //弹出层
                var index = layer.load();
                $.ajax({
                    url: "{{url('/admin/competition')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            //var index = parent.layer.getFrameIndex(window.name);
                            //setTimeout('parent.layer.close(' + index + ')', 500);
                            //  history.back();
                            //parent.layer.close(index);
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.close(index);
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
    </script>
@endsection
@extends('common.editTwo')
