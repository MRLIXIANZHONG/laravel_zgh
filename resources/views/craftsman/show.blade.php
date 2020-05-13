
@section('title', '工匠详情')

@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/layui2/css/layui.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section("content")
    <body>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main">
        <form class="layui-form tc-container" id="nomineeForm">
            <div class="layui-form-item">
                <label class="layui-form-label">姓名：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->username}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">头像：</label>
                <img src="{{$craftsman->photo}}" style="width: 142px; height: 180px;"/>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">所属单位：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->organization_id_name}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">行业：</label>
                <div class="layui-input-block">
                    @if($craftsman->industries)
                        @foreach($craftsman->industries as $industry)
                            <input type="checkbox" title="{{$industry->industry_name}}" checked="" >
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上级工会：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->unit_id_name}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                    <span type="text" class="layui-input">{{$craftsman->mobile}}</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职业：</label>
                <div class="layui-input-block">
                    <span type="text" class="layui-input">{{$craftsman->unit_name}}</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否是党员：</label>
                <div class="layui-input-block">
                    <span type="text" class="layui-input">@if($craftsman->is_party_member === 1)是@else否@endif</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">银行卡号：</label>
                <div class="layui-input-block">
                    <span type="text" class="layui-input">{{$craftsman->bank_card}}</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">户名：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->bank_username}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户行：</label>
                <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->bank_name}}
                                </span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图集：</label>
                <div class="layui-input-block">
                    @foreach($craftsman->imgArr as $item)
                        <img src="{{$item}}"  style="width: 130px;height: 170px;">
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">视频封面：</label>
                <div class="layui-input-block">
                    <img src="{{$craftsman->video_cover}}"  style="width: 200px;height: 150px;">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">视频：</label>
                <div class="layui-input-block">
                    @foreach($craftsman->videoArr as $videoUrl)
                        <video src="{{$videoUrl}}" width="320" height="240" controls autoplay></video>
                    @endforeach
                </div>
            </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">荣誉贡献：</label>
                    <div class="layui-input-block">
                    <textarea type="text"
                              name="honor"
                              style = "width:100%;height: 130px;">{{$craftsman->honor}}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">推荐理由：</label>
                    <div class="layui-input-block">
                    <textarea type="text"
                              name="content"
                              style = "width:100%;height: 130px;">{{ $craftsman->describe }}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">状态：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$check_status[$craftsman->check_status]}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">申报时间：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->created_at}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">点赞数：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->super_star}}
                                </span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">浏览量：</label>
                    <div class="layui-input-block">
                                <span type="text" class="layui-input">
                                    {{$craftsman->super_browse}}
                                </span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">专家得分数：</label>
                    <div class="layui-input-block">
                                    <span type="text" class="layui-input">
                                        {{$craftsman->score}}
                                    </span>
                    </div>
                </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享头像：</label>
                <img src="{{$craftsman->share_photo}}" style="width: 142px; height: 180px;"/>
            </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">分享标题：</label>
                    <div class="layui-input-block">
                                    <span type="text" class="layui-input">
                                        {{$craftsman->share_title}}
                                    </span>
                    </div>
                </div>

            <div class="layui-form-item">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea type="text" name="content" style = "width:100%;height: 130px;">{{$craftsman->share_description}}</textarea>
                </div>
            </div>

            @if(!$craftsman->craftsman_honor->isEmpty())
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>工匠荣誉</legend>
            </fieldset>
        @endif
        <ul class="layui-timeline" style="padding-left:105px;">
            @foreach($craftsman->craftsman_honor as $item)
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis"></i>
                    <div  class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title">{{$item->honor_time}}</h3>
                        <h3>{{$item->honor_name}}</h3>
                        <p>
                            <br>{{$item->honor_description}}
                            <br>
                        </p>
                        @if ($item->honor_image != '')
                            @foreach(explode(',',$item->honor_image) as $va)
                                <img src="{{$va}}" style="width: 120px; height: 150px;">
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis"></i>
                    <div class="layui-timeline-content layui-text">
                        <div class="layui-timeline-title"></div>
                    </div>
                </li>
        </ul>
        </form>
        
    </div>
    </body>
@endsection
@section('js')
    <script src="{{env('APP_URL')}}/static/admin/layui/layui.js" charset="utf-8"></script>
    <script>

    </script>
@endsection