{{--@section('title', '添加优秀个人')--}}
@section('id',!empty($wuxiao['id']) ? $wuxiao['id'] : 0 )
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/ueditor/themes/default/css/ueditor.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">

@section("content")
    <body>

    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <form class="layui-form tc-container mT0">
        <input name="id" id="id" type="hidden" value="{{!empty($wuxiao['id']) ? $wuxiao['id'] : 0}}">
        <input hidden name="_token" value="{{csrf_token()}}">
        <div class="main" id="app">
            {{--            <input type="hidden" name="organization_id"--}}
            {{--                   value="{{$organization->id}}">--}}
            {{--            <input type="hidden" name="unit_id" value="{{!empty($wuxiao['unit_id']) ? $wuxiao['unit_id'] : '10'}}">--}}
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($wuxiao['plan_name']) ? $wuxiao['plan_name'] : ''}}"
                           name="plan_name" lay-verify="required" placeholder="请填写五小名称" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小类型：</label>
                <div class="layui-input-block">
                    <select name="type">
                        <option value="{{$wuxiao['type']}}">请选择五小类型</option>
                        <option value="1" @if($wuxiao['type']!=null&&$wuxiao['type']=='小发明') selected @endif >小发明
                        </option>
                        <option value="2" @if($wuxiao['type']!=null&&$wuxiao['type']=='小创造') selected @endif>小创造
                        </option>
                        <option value="3" @if($wuxiao['type']!=null&&$wuxiao['type']=='小革新') selected @endif>小革新
                        </option>
                        <option value="4" @if($wuxiao['type']!=null&&$wuxiao['type']=='小建议') selected @endif>小建议
                        </option>
                        <option value="5" @if($wuxiao['type']!=null&&$wuxiao['type']=='小设计') selected @endif>小设计
                        </option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>参与赛事：</label>
                <div class="layui-input-block">
                    <select name="case_scheme_id">
                        <option value="">参与赛事</option>
                        @foreach($caseSchemesList as $caseSchemes)
                            <option value="{{$caseSchemes['id']}}"
                                    @if($wuxiao['case_scheme_id']!=null&&$wuxiao['case_scheme_id']==$caseSchemes['id']) selected @endif >{{$caseSchemes['title']}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属企业：</label>
                <div class="layui-input-block">
                    <input type="text" disabled value="{{$organization->name}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>所属行业：</label>
                <div class="layui-input-block">
                    <select name="industry_id">
                        <option value="">所属行业</option>
                        @foreach($industries as $industry)
                            <option value="{{$industry['id']}}"
                                    @if($wuxiao['industry_id']!=null&&$wuxiao['industry_id']==$industry['id']) selected @endif >{{$industry['industry_name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小概述：</label>
                <div class="">
                <textarea style="width:81%;height:250px" type="text/plain"
                          maxlength="500"
                          name="summary" lay-verify="required" placeholder="五小概述(最大500)" autocomplete="off"
                          class="layui-textarea">{{!empty($wuxiao['summary']) ? $wuxiao['summary'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小内容：</label>
                <div class="">
                <textarea style="width:81%;height:250px" type="text"
                          maxlength="2000"
                          name="content" lay-verify="required" placeholder="五小内容" autocomplete="off"
                          class="layui-textarea">{{!empty($wuxiao['content']) ? $wuxiao['content'] : ''}}</textarea>
                </div>
            </div>

            {{--            <div class="layui-form-item">--}}
            {{--                <div style="float: left;width: 45%;">--}}
            {{--                    <label class="layui-form-label">虚拟浏览量：</label>--}}
            {{--                    <div class="layui-input-block">--}}
            {{--                        <input type="text" name="v_browse_count" lay-verify="number"--}}
            {{--                               value="{{!empty($wuxiao['v_browse_count']) ? $wuxiao['v_browse_count'] : 0}}"--}}
            {{--                               class="layui-input">--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div style="float: right;width: 45%;">--}}
            {{--                    <label class="layui-form-label">虚拟点击量：</label>--}}
            {{--                    <div class="layui-input-block">--}}
            {{--                        <input type="text" lay-verify="number"--}}
            {{--                               value="{{!empty($wuxiao['v_star_count']) ? $wuxiao['v_star_count'] : 0}}" name="v_star_count"--}}
            {{--                               class="layui-input">--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="layui-form-item">
                <label class="layui-form-label">所获奖项：</label>
                <div class="layui-input-block">
                    <input type="text" name="reward" value="{{$wuxiao['rewards']}}"
                           class="layui-input">
                </div>
            </div>
            {{--       封面--}}
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小封面：</label>
                <div class="layui-input-block">
                    <div class="img-box imgBox clearfix">
                        <img id='cove_Box' style="width: 150px"/>

                        <div id="adBtn_cover" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="cover" name="cover" lay-verify="coverUrl" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多1张 </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            {{--        图片--}}
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小图片：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <ul class="imgBox l" id="img_Box" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="img_url" name="img_url" lay-verify="imgUrl" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多4张 </p>
                    <div style="height:50px"></div>
                    <div class="progress1" style="display:none">
                        <span class="text1">0%</span>
                        <span class="percentage1" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span
                            style="color:red;position: relative;top: 3px;">* </span>五小视频：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn_video" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="video_url" name="video_url" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：请上传相关视频最大1024m，最多4个 </p>
                    <div style="height:50px"></div>
                    <div class="progress2" style="display:none">
                        <span class="text2">0%</span>
                        <span class="percentage2" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </div>
    </form>
    </body>
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        //加载封面图片
        var cover = new xUploader({
            btn: '#adBtn_cover',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#cover',
            imgElement: '#cove_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=wuxiao"
        });
        //加载封面
        if ('{{!empty($wuxiao['cover'])}}' != '') {
            cover.successDo('{{$wuxiao['cover']}}', true)
        }

        //加载五小图片
        var wuxiao_img = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#img_url',
            imgWrap: '#img_Box',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 4,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=wuxiao"
        });

        var img_url = '{{$wuxiao['img_url']}}';
        if (img_url) {
            var list = img_url.split(',');
            for (var i in list) {
                wuxiao_img.successDo(list[i], true);
            }
        }


        var wuxiao_video = new xUploader({
            btn: '#adBtn_video',
            suportType: 'mp4',
            mimeTypes: '.mp4',
            progressElement: '.progress2',
            progressElement1: '.progress2 .text2',
            progressElement2: '.progress2 .percentage2',
            valueElement: '#video_url',
            imgWrap: '.imgBox1',
            upType: 'type4',
            imgLenth: '.imgBox1 .loading',
            maxLen: 4,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=wuxiao"
        });


        //加载视频
        var video_url = '{{$wuxiao['video_url']}}';
        if (video_url) {
            var list = video_url.split(',');
            for (var i in list) {
                wuxiao_video.successDo(list[i], true);
            }
        }
        //图片 视频删除
        $(document).on('click', '.del-pics', function () {

            var url = $(this).closest('.loading').find('img').attr('src');
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                wuxiao_img.delFile(this, url);
            if (!!urlVideo)
                wuxiao_video.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {'url': url || urlVideo, _token: '{{csrf_token()}}'},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        })

        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            {{--$("textarea[name='content']").val('{{!empty($wuxiao['content']) ? $wuxiao['content'] : ''}}');--}}
            {{--$("textarea[name='summary']").val('{{!empty($wuxiao['summary']) ? $wuxiao['summary'] : ''}}');--}}
            //监听提交
            form.on('submit(formDemo)', () => {
                if ($('#cover').val() == '') {
                    layer.msg('请上传五小封面', {icon: 5});
                    return false;
                }
                if ($('#img_url').val() == '') {
                    layer.msg('请上传五小图片', {icon: 5});
                    return false;
                }
                if ($('#video_url').val() == '') {
                    layer.msg('请上传五小视频', {icon: 5});
                    return false;
                }
                $.ajax({
                    url: "{{url('/admin/wuxiao/update')}}",
                    data: $('form').serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                window.location.href = "/admin/wuxiao/index";
                            });
                        } else {
                            layer.msg(res.message, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络请求失败', {time: 1000});
                    }
                });
                // 请求接口喽
                return false;
            });
        });

    </script>
@endsection
@extends('common.editTwo')
