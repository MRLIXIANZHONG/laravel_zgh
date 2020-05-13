@if (isset($organization))
    @section('title', '修改工匠')
@else
    @section('title', '添加工匠')
@endif
@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section("content")
    <body>
    <div class="main" id="app">
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
            <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
        </div>
        <form class="layui-form tc-container">
            <input hidden name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>姓名：</label>
                <div class="layui-input-block">
                    <input type="text" value=""
                           maxlength="100"
                           name="username" lay-verify="required" placeholder="姓名(最多100字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">头像：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img style="width:200px;height: 150px;" class="imgBox">
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="photo" name="photo" class="hide-val" data-sum="0"/>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>联系电话：</label>
                <div class="layui-input-block">
                    <input type="phone" value=""
                           maxlength="12"
                           name="mobile" lay-verify="required" placeholder="联系电话" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>职业：</label>
                <div class="layui-input-block">
                    <input type="text" value=""
                           maxlength="100"
                           name="unit_name" lay-verify="required" placeholder="职业(最多100字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>是否是党员：</label>
                <div class="layui-input-block">
                    <select name="is_party_member" lay-verify="required" required autocomplete="off">
                        <option value=""></option>
                        <option value="0">否</option>
                        <option value="1">是</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>银行卡号：</label>
                <div class="layui-input-block">
                    <input type="number" value=""
                           name="bank_card" lay-verify="required" placeholder="银行卡号" autocomplete="off"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" oninput="if(value.length>20)value=value.slice(0,20)"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">银行卡号照片：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img style="width:200px;height: 150px;" class="imgBox3">
                        <div id="adBtnBank" class="adBtn l" style="display: block;"></div>
                    </div>
                    <input type="hidden" id="bank_photo" name="bank_photo" class="hide-val" data-sum="0"/>
                    <div class="progress3" style="display:none">
                        <span class="text3">0%</span>
                        <span class="percentage3" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">户名：</label>
                <div class="layui-input-block">
                    <input type="text"
                           value=""
                           maxlength="100"
                           name="bank_username" lay-verify="required" placeholder="户名(最多100字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户行：</label>
                <div class="layui-input-block">
                    <input type="text"
                           value=""
                           maxlength="191"
                           name="bank_name" lay-verify="required" placeholder="开户行(最多191字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">图集：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <ul class="imgBox l" id="imageBox" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn1" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="image" name="image" class="hide-val" data-sum="0"/>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">视频封面：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img   style="width:200px;height: 150px;" class="imgBox2">
                        <div id="adBtnCover" class="adBtn l" style="display: block;"></div>
                    </div>
                    <input type="hidden" id="video_cover" name="video_cover" class="hide-val" data-sum="0"/>
                    <div class="progress2" style="display:none">
                        <span class="text2">0%</span>
                        <span class="percentage2" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">视频：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">

                        <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>
                        <div id="adBtn_video" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="video" name="video" class="hide-val" data-sum="0"/>
                    <div class="progress1" style="display:none">
                        <span class="text1">0%</span>
                        <span class="percentage1" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">个人履历：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="800"
                              name="honor" placeholder="个人履历(最多800字符)" autocomplete="off"
                              style="width:100%;height: 130px;"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">推荐理由：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="2000"
                              name="describe" lay-verify="required" placeholder="推荐理由(最多2000字符)" autocomplete="off"
                              style="width:100%;height: 130px;"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享头像：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img   style="width:200px;height: 150px;" class="imgBox1">
                        <div id="adBtnShare" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="share_photo" name="share_photo" class="hide-val" data-sum="0"/>

                    <div class="progress1" style="display:none">
                        <span class="text1">0%</span>
                        <span class="percentage1" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享标题：</label>
                <div class="layui-input-block" style="width: 369px;">
                    <input type="text" value=""
                           maxlength="15"
                           name="share_titale" placeholder="分享标题(最多15字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="15"
                              name="share_description" placeholder="分享描述(最多15字符)" autocomplete="off"
                              style="width:100%;height: 130px;"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="storeCraftsman">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</body>
@endsection
@section('js')

    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>

        //加载图片
        var photo = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#photo',
            imgElement: '.imgBox',
            imgWrap: '.imgBox',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        //加载图片
        var video_cover = new xUploader({
            btn: '#adBtnShare',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#share_photo',
            imgElement: '.imgBox1',
            imgWrap: '.imgBox1',
            upType: 'type1',
            imgLenth: '.imgBox1 .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        //加载图片
        var share_photo = new xUploader({
            btn: '#adBtnCover',
            progressElement: '.progress2',
            progressElement1: '.progress2 .text2',
            progressElement2: '.progress2 .percentage2',
            valueElement: '#video_cover',
            imgElement: '.imgBox2',
            imgWrap: '.imgBox2',
            upType: 'type1',
            imgLenth: '.imgBox2 .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        //加载图片
        var bank_photo = new xUploader({
            btn: '#adBtnBank',
            progressElement: '.progress3',
            progressElement1: '.progress3 .text3',
            progressElement2: '.progress3 .percentage3',
            valueElement: '#bank_photo',
            imgElement: '.imgBox3',
            imgWrap: '.imgBox3',
            upType: 'type1',
            imgLenth: '.imgBox3 .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        //加载图片
        var image = new xUploader({
            btn: '#adBtn1',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#image',
            imgWrap: '#imageBox',
            upType: 'type2',
            imgLenth: '.imgBox .loading',
            maxLen: 10,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanImg"
        });

        /*添加视频*/
        var video = new xUploader({
            btn: '#adBtn_video',
            suportType: 'mp4',
            mimeTypes: '.mp4',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#video',
            imgWrap: '.imgBox1',
            upType: 'type4',
            imgLenth: '.imgBox1 .loading',
            maxLen: 4,
            singleSizeLimit: '1024mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=craftsmanVideo"
        });

        //图片 视频删除
        $(document).on('click', '.del-pics', function () {
            var url = $(this).closest('.loading').find('img').attr('src');console.log(url);
            var urlVideo = $(this).closest('.loading').find('video').attr('src');
            if (!!url)
                image.delFile(this, url);
            if (!!urlVideo)
                video.delFile(this, urlVideo);
            $.ajax({
                url: "{{url('/admin/news/delFile')}}",
                data: {url: url || urlVideo, _token: '{{csrf_token()}}'},
                type: 'POST',
                dataType: 'json',
                success: function (res) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });

        });
        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            //监听提交
            form.on('submit(storeCraftsman)', () => {
                $.ajax({
                    url: "{{url('/admin/craftsman')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                location.href="{{url('/admin/craftsmans')}}";
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