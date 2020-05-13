<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section('title', '新闻详情')
<style>
    .layui-input-block {
        line-height: 36px;
    }
</style>
@section('content')
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="goBack()">返回</button>
    </div>
    <form class="layui-form tc-container mT0">
        <input name="id" type="hidden" value="{{!empty($rloudLive['id']) ? $rloudLive['id'] : '0'}}">
    <div class="layui-form-item">
        <label class="layui-form-label">内容类型：</label>
        <div class="layui-input-block">
            @if( $rloudLive['type']=='1')
                直播竞技
            @elseif ( $rloudLive['type']=='2')
                录播竞技
            @else
                直播竞技回放
            @endif
        </div>
    </div>
{{--    <div class="layui-form-item">--}}
{{--        <label class="layui-form-label">所属公会：</label>--}}
{{--        <div class="layui-input-block">--}}
{{--            {{$rloudLive['units_name']}}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="layui-form-item">--}}
{{--        <label class="layui-form-label">所属企业：</label>--}}
{{--        <div class="layui-input-block">--}}
{{--            {{$rloudLive['organizations_name']}}--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="layui-form-item">
        <label class="layui-form-label">所属行业：</label>
        <div class="layui-input-block">
            {{$rloudLive['industry_name']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">竞技标题：</label>
        <div class="layui-input-block">
            {{$rloudLive['title']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">竞技内容：</label>
        <div class="layui-input-block">
            <div style="max-height: 500px;overflow: auto;">
                {!! $rloudLive['content']!!}
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">链接地址：</label>
        <div class="layui-input-block">
            {{$rloudLive['weburl']}}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">封面：</label>
        <div class="layui-input-block">
            <ul class="imgBox" data-prompt-position="bottomLeft:130,-80">

            </ul>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">竞技视频：</label>
        <div class="layui-input-block">
            <ul class="videoBox" style="max-width: 300px" data-prompt-position="bottomLeft:130,-80">

            </ul>
        </div>
    </div>
    </form>

@endsection
@section('js')
    <script>
        function goBack() {
            history.go(-1);
        }
        var img = '{{$rloudLive['img_url']}}';
        if (img) {
            var list = img.split(',');
            var html = "";
            for (var i in list) {
                html += "<li style='height: 150px;'><img style='width: auto;height: 100%;' src='" + list[i] + "'/> </li>";
            }
            $(".imgBox").append(html);
        }


        //加载视频
        var video = '{{$rloudLive['video_url']}}';
        if (video) {
            var html = "";
            var list = video.split(',');
            for (var i in list) {
                html += "<li><video style='width:100%;' controls src='" + list[i] + "' ></video> </li>";
            }
            $(".videoBox").append(html);
        }
        layui.use(['form'], function () {
            var form = layui.form();
            form.render();

        });
    </script>
@endsection
@extends('common.editTwo')
