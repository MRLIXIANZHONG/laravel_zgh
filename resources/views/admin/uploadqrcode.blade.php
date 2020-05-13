@extends('common.common')
@section('title', '上传二维码')
@section("content")
<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/static/admin/layui/css/layui.css" />
<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/static/admin/css/admin.css?v={{rand(0,9999)}}" />
<link rel="stylesheet" href="/static/upload/xUploader.css">
<form class="layui-form" method="post">
<div class="layui-form-item">
    <label class="layui-form-label">添加在线客服二维码：</label>
    <div class="layui-input-block">
        <div class="img-box clearfix">
            <img class="imgBox l imgBox2" width="100px" height="100px" data-prompt-position="bottomLeft:130,-80">
            <div id="adBtn" class="adBtn l"></div>
        </div>
        <input type="hidden" name="imgUrl" id="titval1" class="hide-val"  data-sum="0" />
        <p style="color:#999"> </p>
        <div style="height:50px"></div>
        <div class="progress" style="display:none">
            <span class="text">0%</span>
            <span class="percentage" style="width:0%;"></span>
        </div>
    </div>
</div>
</form>
<script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
<script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
<script>
    var abc = new xUploader({
        btn: '#adBtn',
        progressElement: '.progress',
        progressElement1: '.progress .text',
        progressElement2: '.progress .percentage',
        valueElement: '#titval1',
        imgElement: '.imgBox2',
        upType: 'type1',
        imgLenth: '.imgBox .loading',
        maxLen: 1,
        singleSizeLimit: '5mb',
        server: "/admin/uploadqrcode?_token={{csrf_token()}}&folder=adminqrcode"
    });

    abc.successDo('/static/UploadFile/adminqrcode/adminqrcode.jpg?v={{rand(0,9999)}}',true);

    $(document).on('click', '.del-pics', function () {
        var url = $(this).closest('.loading').find('img').attr('src');
        abc.delFile(this, url);
    })

</script>
@endsection