{{--@section('title', '添加优秀个人')--}}
@section('id',!empty($nominee['id']) ? $nominee['id'] : 0 )
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/layui2/css/layui.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section("content")
<body>
<div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
    <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
</div>
    <form class="layui-form tc-container mT0">
{{--        <div class="layui-form-item" style="width: auto;">--}}
{{--            <label class="layui-form-label">员工ID：</label>--}}
{{--            <blockquote style="float: right;width: 90%;"--}}
{{--                        class="layui-elem-quote layui-quote-nm">{{!empty($nominee['staff_id']) ? $nominee['staff_id'] : ''}}</blockquote>--}}
{{--        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">员工姓名：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['staff_name']) ? $nominee['staff_name'] : ''}}</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">员工图片：</label>
            <div class="layui-input-block">
                @if(!empty($nominee['staff_img']))
                    <img style="height: 150px;width: 200px;"
                         src="{{$nominee['staff_img'] }}"
                         alt="">
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">推荐类型：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['kind']) ? $nominee['kind'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">赛事类型：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$nominee->caseSchemes->title}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">参与企业方案：</label>
            <div class="layui-input-block">
                @foreach($nomineePlanList as $nomineePlan)
                    {{$nomineePlan->plan_name   }}  &nbsp;&nbsp;&nbsp;
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡号：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['bank_card']) ? $nominee['bank_card'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开户行：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['bank_name']) ? $nominee['bank_name'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开户姓名：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['bank_staff_name']) ? $nominee['bank_staff_name'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡照片：</label>
            <div class="layui-input-block">
                @if(!empty($nominee['bank_card_img']))
                    <img style="height: 150px;width: 200px;" src="{{$nominee['staff_img'] }}" alt="">
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">企业名称：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee['organization_name']) ? $nominee['organization_name'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级工会：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($nominee->units->name) ? $nominee->units->name : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">推荐理由：</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea" type="text/plain" placeholder="推荐理由" name="caption"
                              lay-verify="required">{{!empty($nominee['caption']) ? $nominee['caption'] : ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">个人荣誉：</label>
            <div class="layui-input-block">
                <ul class="layui-timeline">
                    @foreach($experiencelist as $experience)
                        <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                            <div class="layui-timeline-content layui-text">
                                <h2 class="layui-timeline-title">{{$experience['name']}}</h2>

                                <br>
                                <h3>{{$experience['startTime']}}-{{$experience['endTime']}}</h3>
                                <br>
                                @foreach(explode(",",$experience['img_url']) as $imgUrl)
                                    <img src="{{$imgUrl}}">
                                @endforeach
                                <br><h4>{{$experience['mark']}}</h4>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">个人图集：</label>
            <div class="layui-input-block">
                <ul class="layui-timeline">
                    @foreach($imglist as $img)
                        <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                            <div class="layui-timeline-content layui-text">
                                <h2 class="layui-timeline-title">{{$img['title']}}</h2>
                                <br>
                                <img style="width: 200px;height: 200px;" src={{$img['img_url']}} >

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">个人视频：</label>
            <div class="layui-input-block">
                <ul class="layui-timeline">
                    @foreach($videolist as $video)
                        <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                            <div class="layui-timeline-content layui-text">
                                <h2 class="layui-timeline-title">{{$video['title']}}</h2>
                                <br> <img src="{{$video['img_url']}}">
                                <br>
                                <video src="{{$video['video_url']}}" width="320" height="240" controls autoplay></video>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </form>
</body>
@endsection
@section('js')

@endsection
@extends('common.editTwo')
