@section('title', '专家活动修改')
<link rel="stylesheet" href="/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@extends('common.common')
@section("content")
    @if(empty($editType))
        <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/judges" class="layui-btn layui-btn-normal">返回</a>
    </div>
        <form class="layui-form tc-container" action="/admin/judges/update" method="post">
            <div class="layui-form-item" style="display: none;">
                <div class="layui-input-block">
                    <input type="hidden" value="{{!empty($Judgeses['id']) ? $Judgeses['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专家姓名：</label>
                <div class="layui-input-block">
                    <input type="text" maxlength="191" value="{{$Judgeses['name']}}" name="name" lay-verify="required" placeholder="请输入专家姓名(最多191个字符)" autocomplete="off" class="layui-input">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>所属单位：</label>
                <div class="layui-input-block">
                    <input type="text" maxlength="191" value="{{$Judgeses['department']}}" lay-verify="required"  name="department" placeholder="请输入所属单位(最多191个字符)" autocomplete="off" class="layui-input">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专家电话：</label>
                <div class="layui-input-block">
                    <input type="phone" maxlength="11"  value="{{$Judgeses['phone']}}" name="phone" lay-verify="required" placeholder="请输入专家电话" autocomplete="off" class="layui-input">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>评委类别：</label>
                <div class="layui-input-block">
                    <input type="radio" name="kind" title="专家" value="1" @if($Judgeses['kind']===1)checked @endif/>
                    <input type="radio" name="kind" title="劳模" value="2" @if($Judgeses['kind']===2)checked @endif/>
                    <input type="radio" name="kind" title="媒体" value="3" @if($Judgeses['kind']===3)checked @endif/>
                    <input type="radio" name="kind" title="巴渝工匠" value="4" @if($Judgeses['kind']===3)checked @endif/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>行业类型：</label>
                <div class="layui-input-block">
                    <select name="industry" lay-filter="industry">
                        @foreach($Industry as $item)
                            <option value="{{$item->id}}" @if($item['id']==$Judgeses['industry']) selected="" @endif>{{$item->industry_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">擅长领域：</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入擅长领域(最多191个字符)"  maxlength="191" name="skill"  class="layui-textarea">{{$Judgeses['skill']}}</textarea>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">专家特长介绍：</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入专家特长介绍(最多191个字符)" maxlength="191" name="speciality"  class="layui-textarea">{{$Judgeses['speciality']}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">专家头像：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <img class="imgBox l imgBox2" width="100px" height="100px" data-prompt-position="bottomLeft:130,-80">
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="titval1" name="photo" class="hide-val" data-sum="0"/>
                    <p style="color:#999"> </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            {{--        <div class="layui-form-item">--}}
            {{--            <label class="layui-form-label">方案视频：</label>--}}
            {{--            <div class="layui-input-block">--}}
            {{--                <div class="img-box clearfix">--}}
            {{--                    <ul class="imgBox1 1" data-prompt-position="bottomLeft:130,-80"></ul>--}}
            {{--                    <div id="adBtn_video" class="adBtn l"></div>--}}
            {{--                </div>--}}
            {{--                <input type="hidden" id="video_url" name="video_url" class="hide-val" data-sum="0"/>--}}

            {{--                <div style="height:50px"></div>--}}
            {{--                <div class="progress" style="display:none">--}}
            {{--                    <span class="text">0%</span>--}}
            {{--                    <span class="percentage" style="width:0%;"></span>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--        </div>--}}

            <div class="layui-form-item">
                <label class="layui-form-label">添加分享封面：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        <img class="imgBox l imgBox1" width="100px" height="100px" data-prompt-position="bottomLeft:130,-80">
                        <div id="adBtn1" class="adBtn1 l"></div>
                    </div>
                    <input type="hidden" name="share_img_url" id="titval2" class="hide-val"  data-sum="0" />
                    <p style="color:#999"> </p>
                    <div style="height:50px"></div>
                    <div class="progress1" style="display:none">
                        <span class="text1">0%</span>
                        <span class="percentage1" style="width:0%;"></span>
                    </div>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入分享描述(最多255个字符)" maxlength="255" name="sharecontent"  class="layui-textarea">{{$Judgeses['share_content']}}</textarea>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">分享标题/PC端页面tile：</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入分享标题/PC端页面tile(最多255个字符)" maxlength="255" name="sharetitle" class="layui-textarea">{{$Judgeses['share_title']}}</textarea>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>短信密码：</label>
                <div class="layui-input-block">
                    <input type="password" oninput="if(value.length>60)value=value.slice(0,60)" value="{{$Judgeses['password']}}" name="password" lay-verify="required" placeholder="请输入短信密码(最多60个字符)" autocomplete="off" class="layui-input">
                </div>
            </div>

            <input type="hidden" name="nopassinfo" value="" class="layui-input"></input>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>

        </form>
    @else
        <form class="layui-form" action="/admin/judges/update" method="post">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="hidden" value="{{!empty($Judgeses['id']) ? $Judgeses['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">不通过原因:</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入不通过原因" name="nopassinfo" class="layui-textarea"></textarea>
                </div>
            </div>
            <input type="hidden" name="check_state" value="2"/>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </form>
    @endif
@endsection
@section('js')
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        //加载图片
        var abc = new xUploader({
            btn: '#adBtn',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#titval1',
            imgElement: '.imgBox2',
            upType: 'type1',
            imgLenth: '.imgBox .loading',
            maxLen: 4,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=judgesImg"
        });
        abc.successDo('{{$Judgeses['photo']}}',true);

        var abc1 = new xUploader({
            btn: '#adBtn1',
            progressElement: '.progress1',
            progressElement1: '.progress1 .text1',
            progressElement2: '.progress1 .percentage1',
            valueElement: '#titval2',
            imgElement: '.imgBox1',
            upType: 'type1',
            imgLenth: '.imgBox1 .loading1',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=judgesImg"
        });
        abc1.successDo('{{$Judgeses['share_img_url']}}',true);

        {{--var abc1 = new xUploader({--}}
        {{--    btn: '#adBtn_video',--}}
        {{--    suportType: 'mp4',--}}
        {{--    mimeTypes: '.mp4',--}}
        {{--    progressElement: '.progress',--}}
        {{--    progressElement1: '.progress .text',--}}
        {{--    progressElement2: '.progress .percentage',--}}
        {{--    valueElement: '#video_url',--}}
        {{--    imgWrap: '.imgBox1',--}}
        {{--    upType: 'type4',--}}
        {{--    imgLenth: '.imgBox1 .loading',--}}
        {{--    maxLen: 4,--}}
        {{--    singleSizeLimit: '1024mb',--}}
        {{--    server: "/admin/news/upload?_token={{csrf_token()}}&folder=judgesVideo"--}}
        {{--});--}}


        //加载视频
        {{--var video = '{{$Judgeses['video_url']}}';--}}
        {{--if (video) {--}}
        {{--    var list = video.split(',');--}}
        {{--    for (var i in list) {--}}
        {{--        abc1.successDo(list[i],true);--}}
        {{--    }--}}
        {{--}--}}
        {{--//图片 视频删除--}}
        {{--$(document).on('click', '.del-pics', function () {--}}
        {{--    var url = $(this).closest('.loading').find('img').attr('src');--}}
        {{--    var urlVideo = $(this).closest('.loading').find('video').attr('src');--}}
        {{--    if (!!url)--}}
        {{--        abc.delFile(this, url);--}}
        {{--    if (!!urlVideo)--}}
        {{--        abc1.delFile(this, urlVideo);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{url('/admin/news/delFile')}}",--}}
        {{--        data: {'url': url,_token:"{{csrf_token()}}"},--}}
        {{--        type: 'POST',--}}
        {{--        dataType: 'json',--}}
        {{--        success: function (res) {--}}
        {{--            if(res.code==1000)--}}
        {{--                layer.msg('添加成功');--}}
        {{--            else--}}
        {{--                layer.msg(res.msg);--}}
        {{--        },--}}
        {{--        error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
        {{--            layer.msg('网络失败', {time: 1000});--}}
        {{--        }--}}
        {{--    });--}}

        {{--})--}}

        layui.use(['form'], function () {
            var form = layui.form();
            form.render();
            form.on('submit(formDemo)', function (data) {
                this.disabled=true;
                $.ajax({
                    url: "/admin/judges/update",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)    {
                            layer.msg('修改成功', {icon: 6},function () {
                                var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            });
                            window.location.href="/admin/judges";
                        }
                        else if(res.code==2000){
                            layer.msg('修改成功,请关闭页面');
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


