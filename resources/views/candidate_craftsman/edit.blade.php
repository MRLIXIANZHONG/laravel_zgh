@if (isset($organization))
    @section('title', '修改工匠')
@else
    @section('title', '添加工匠')
@endif
@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/layui2/css/layui.css">
@section("content")
<body>
    <style>
        .product_img {
            width: 380px;
            height: 380px;
        }

        .seller_icon {
            width: 100px;
            height: 100px;
        }

        .deleted_icon {
            display: inline-block;
            height: 20px;
            width: 20px;
            font-size: 18px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            background: #CCCCCC;
            filter: alpha(opacity:30);
            opacity: 0.8;
            position: absolute;
            bottom: 0;
            left: 360px;
            cursor: pointer;
        }
    </style>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="app">
        <form class="layui-form tc-container mT0">
            <input hidden name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layui-form-label">姓名：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($craftsman->id)){{$craftsman->username}}@endif"
                           name="username" lay-verify="required" placeholder="姓名" autocomplete="off"
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
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($craftsman->id)){{$craftsman->mobile}}@endif"
                           name="mobile" lay-verify="required" placeholder="联系电话" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职业：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($craftsman->id)){{$craftsman->unit_name}}@endif"
                           name="unit_name" lay-verify="required" placeholder="职业" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否是党员：</label>
                <div class="layui-input-block">
                    <select name="is_party_member" lay-verify="required" required autocomplete="off">
                        <option value="0" @if($craftsman->is_party_member === 0) selected @endif>否</option>
                        <option value="1" @if($craftsman->is_party_member === 1) selected @endif>是</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">银行卡号：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($craftsman->id)){{$craftsman->bank_card}}@endif"
                           name="bank_card" lay-verify="required" placeholder="银行卡号" autocomplete="off"
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
                           value="@if(isset($craftsman->id)){{$craftsman->bank_username}}@endif"
                           name="bank_username" lay-verify="required" placeholder="户名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户行：</label>
                <div class="layui-input-block">
                    <input type="text"
                           value="@if(isset($craftsman->id)){{$craftsman->bank_name}}@endif"
                           name="bank_name" lay-verify="required" placeholder="开户行" autocomplete="off"
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
                        <div id="adBtn_video" class="adBtn l" style="display: block;"></div>
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
                              name="honor" placeholder="个人履历" autocomplete="off"
                              style="width:100%;height: 130px;">@if(isset($craftsman->id)){{trim($craftsman->honor)}}@else @endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">推荐理由：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              name="describe" lay-verify="required" placeholder="推荐理由" autocomplete="off"
                              style="width:100%;height: 130px;">{{$craftsman->describe}}</textarea>
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
                <div class="layui-input-block">
                    <input type="text" value="{{$craftsman->share_titale}}"
                           name="share_titale" placeholder="分享标题" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              name="share_description" placeholder="分享描述" autocomplete="off"
                              style="width:100%;height: 130px;">{{$craftsman->share_description}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    @if($role === 1)
                        <button type="button" onclick="setCraftsmanVirtual()" class="layui-btn" style="margin-left: 36px;">设置浏览点赞</button>
                    @endif
                    @if($role === 5)
                        <button type="button" onclick="expert_score()" class="layui-btn" style="margin-left: 36px;">投票</button>
                    @endif
                    @if($role === 1)
                        <button type="button" onclick="storeHonor()" class="layui-btn" style="margin-left: 36px;">新增荣誉</button>
                    @endif
                    <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="formCraftsman">立即提交</button>
                </div>
            </div>
        </form>

        <div style="width: 49%; padding-left: 16%;">
            @if(!$craftsman->craftsman_honor->isEmpty())
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>工匠荣誉</legend>
                </fieldset>
            @endif
            <ul class="layui-timeline" style="padding-left:105px;">
                @foreach($craftsman->craftsman_honor as $item)
                    <li class="layui-timeline-item" style="margin-top: 26px;">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div  class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">{{$item->honor_time}}</h3>
                            <h3>{{$item->honor_name}}</h3>
                            <p>
                                <br>{{$item->honor_description}}
                                <br>
                            </p>
                            @foreach(explode(',',$item->honor_image) as $va)
                                @if($va !== '')
                                    <img src="{{$va}}" style="width: 120px; height: 150px;">
                                @endif
                            @endforeach
                        </div>
                        @if($role === 1)
                        <button type="button" style="float: right;" class="layui-btn layui-btn-small layui-btn-danger del-btn"
                        ><i class="layui-icon">&#xe640;</i>删除</button>
                        @endif
                    </li>
                @endforeach
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis"></i>
                    <div class="layui-timeline-content layui-text">
                        <div class="layui-timeline-title"></div>
                    </div>
                </li>
            </ul>
        </div>

        <div id="setCraftsmanVirtual" hidden>
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">虚拟浏览量：</label>
                    <input type="text" name="virtual_browse" id="virtual_browse" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请输入虚拟游览量" style="display: inline-block;width: 50%;" value="{{$craftsman->virtual_browse}}">
                </div>
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">虚拟点赞量：</label>
                    <input type="text" name="virtual_star" id="virtual_star" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="虚拟点赞量" style="display: inline-block;width: 50%;" value="{{$craftsman->virtual_star}}">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formCraftsmanVirtual" style="margin-left: 18%;margin-top: 8px;">立即设置</button>
            </form>
        </div>

        <div id="expertScore" hidden>
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">投票数：</label>
                    <input type="text" name="score" id="score" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请输入投票数" style="display: inline-block;width: 50%;" value="{{$craftsman->virtual_browse}}">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formExpertScore" style="margin-left: 18%;margin-top: 8px;">立即投票</button>
            </form>
        </div>

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
        var photoImg = '{{$craftsman->photo}}';
        if (photoImg) {
            var list = photoImg.split(',');
            for (var i in list) {
                photo.successDo(list[i],true);
            }
        }

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
        var coverImg = '{{$craftsman->video_cover}}';
        if (coverImg) {
            var list = coverImg.split(',');
            for (var i in list) {
                video_cover.successDo(list[i],true);
            }
        }

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
        var sharePhotoImg = '{{$craftsman->share_photo}}';
        if (sharePhotoImg) {
            var list = sharePhotoImg.split(',');
            for (var i in list) {
                share_photo.successDo(list[i],true);
            }
        }
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
        var bankPhotoImg = '{{$craftsman->bank_photo}}';
        if (bankPhotoImg) {
            var list = bankPhotoImg.split(',');
            for (var i in list) {
                bank_photo.successDo(list[i],true);
            }
        }
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

                @if (isset($craftsman))
        var imageImg = '{{$craftsman->image}}';

        if (imageImg) {
            var list = imageImg.split(',');
            for (var i in list) {
                image.successDo(list[i],true);
            }
        }
        @endif


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

                @if (isset($craftsman))
        var videoUl = '{{$craftsman->video}}';
        if (videoUl) {
            var list = videoUl.split(',');
            for (var i in list) {
                image.successDo(list[i],true);
            }
        }
        @endif

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
            form.on('submit(formCraftsman)', () => {
                $.ajax({
                    url: "{{url('/admin/candidate_craftsmans/'.$craftsman->id)}}",
                    data: $('form').serialize(),
                    type: 'PUT',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                history.go(-1);
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
            form.on('submit(formCraftsmanVirtual)', () => {
                $.ajax({
                    url: "{{url('/admin/candidate_craftsmans/'.$craftsman->id.'/set_virtual')}}",
                    data: $('form').serialize(),
                    type: 'PATCH',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6});
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
            form.on('submit(formExpertScore)', function (data) {
                $.ajax({
                    url: "{{url('/admin/candidate_craftsmans/'.$craftsman->id.'/expert_score')}}",
                    data: {'score': data.field.score,'_token': data.field._token},
                    type: 'PATCH',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6});
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

        layui.use('upload', function () {
            var $ = layui.jquery
                , upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                , url: 'http://localhost/admin/upload/craftsman' //改成您自己的上传接口
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                , done: function (res) {
                    //如果上传失败
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    }
                    //上传成功
                }
                , error: function () {
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function () {
                        uploadInst.upload();
                    });
                }
            });
            //多图片上传
            upload.render({
                elem: '#test2'
                , url: 'https://httpbin.org/post' //改成您自己的上传接口
                , multiple: true
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#demo2').append('<img src="' + result + '" alt="' + file.name + '" class="layui-upload-img">')
                    });
                }
                , done: function (res) {
                    //上传完毕
                }
            });
        });

        function setCraftsmanVirtual() {
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:1,
                title:"设置虚拟浏览点赞量",
                area: ['36%','40%'],
                content:$("#setCraftsmanVirtual").html()
            });
        }
        function expert_score() {
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:1,
                title:"专家投票",
                area: ['36%','30%'],
                content:$("#expertScore").html()
            });
        }

        function storeHonor() {
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:2,
                title:"添加工匠荣誉",
                area: ['75%','86%'],
                content:"{{url('admin/craftsmans/'.$craftsman->id.'/create_honor')}}",
            });
        }
        @if ($item->id)
        $('.del-btn').on('click',function () {
            var  id={{$item->id}}
            layer.msg('您确认要删除吗？', {
                time: 0 //不自动关闭
                , btn: ['确认', '取消'] //按钮
                , yes: function (index) {
                    layer.close(index);
                    layer.load(2);
                    setTimeout(function () {
                        layer.closeAll('loading');
                    }, 2000);
                    $.ajax({
                        url: "{{url('/admin/craftsmans/'.$craftsman->id.'/honors')}}" + '/' + id,
                        data: {
                            _token: '{{csrf_token()}}'
                        },
                        type: 'delete',
                        dataType: 'json',
                        success: (res) => {
                            if (res.code == 1000) {
                                layer.msg(res.message, {icon: 6}, function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(res.message, {shift: 6, icon: 5});
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.msg('网络请求失败', {time: 1000});
                        }
                    })
                }
            });
        });
        @endif
    </script>
@endsection