@if (isset($organization))
    @section('title', '添加企业方案')
@else
    @section('title', '添加企业方案')
@endif
@extends('common.editTwo')

<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<style>
    .layui-form-label {
        width: 150px;
    }
</style>
@section("content")
    <body>
    <style>
        .main {
            width: 97%;
            padding-top: 30px;
        }

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
    <div class="main" id="app">

            <form action="{{ url('admin/organization_user') }}" method="POST" accept-charset="UTF-8"
                  class="layui-form" id="nomineeForm" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>单位名称：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($organization->id)){{$organization->name}}@endif"
                                       maxlength="100"
                                       name="name" lay-verify="required" placeholder="单位名称(最多100个字符)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">单位logo：</label>
                            <div class="layui-input-block">
                                <div class="img-box clearfix">
                                    {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                                    <img src="@if($organization->id){{$organization->photo}}@endif" style="width:150px;height: 150px;" class="imgBox">
                                    <div id="adBtn" class="adBtn l"></div>
                                </div>
                                <input type="hidden" id="photo" name="photo" class="hide-val" data-sum="0"/>

                                <div style="height:50px"></div>
                                <div class="progress" style="display:none">
                                    <span class="text">0%</span>
                                    <span class="percentage" style="width:0%;"></span>
                                </div>
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">是否重点竞赛：</label>
                            <div class="layui-input-block">
                                <select name="unit_id" lay-filter="aihao">
                                    <option value="0" @if(isset($organization->id) && $organization->is_competition == 0) selected @endif>非重点竞赛</option>
                                    <option value="1" @if(isset($organization->id) && $organization->is_competition == 1) selected @endif>重点竞赛</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>上级工会：</label>
                            <div class="layui-input-block">

                                <select name="unit_id" lay-filter="aihao">
                                    @foreach($units as $unit)
                                        <option value="{{$unit->id}}" @if($unit->id == $organization->unit_id) selected @endif>{{$unit->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">单位类型：</label>
                            <div class="layui-input-block">
                                <select name="new_type" lay-filter="aihao">
                                    <option value="1" @if(isset($organization->new_type) && $organization->new_type == 1) selected @endif >国营控股企业</option>
                                    <option value="2" @if(isset($organization->new_type) && $organization->new_type == 2) selected @endif >行政机关</option>
                                    <option value="3" @if(isset($organization->new_type) && $organization->new_type == 3) selected @endif >港澳台、外商投资企业</option>
                                    <option value="4" @if(isset($organization->new_type) && $organization->new_type == 4) selected @endif >民营控股企业</option>
                                    <option value="5" @if(isset($organization->new_type) && $organization->new_type == 5) selected @endif >事业单位</option>
                                    <option value="6" @if(isset($organization->new_type) && $organization->new_type == 6) selected @endif >其他</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">复选框</label>
                            <div class="layui-input-block">
                                @foreach($industries as $item)
                                    <input type="checkbox" name="industry_tag[]" title="{{$item->industry_name}}"
                                    value="{{$item->id}}" @if(in_array($item->id, $organization->industry)) checked @endif>
                                    {{--<input type="checkbox" name="like[read]" title="阅读">--}}
                                    {{--<input type="checkbox" name="like[daze]" title="发呆">--}}
                                @endforeach
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">行业：</label>
                            <div class="layui-input-block">
                                <select name="plan_id" xm-select="select10_2" xm-select-direction="down">
                                    <option value="">请选择行业</option>
                                    @foreach($industries as $industry)
                                        <option value="{{$industry->id}}"
                                        >{{$industry->industry_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>姓名：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($organization->id)){{$organization->username}}@endif"
                                       maxlength="100"
                                       name="username" lay-verify="required" placeholder="姓名" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">密码：</label>
                            <div class="layui-input-block">
                                <input type="password" value=""
                                       maxlength="100"
                                       name="password" placeholder="密码" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>手机号：</label>
                            <div class="layui-input-block">
                                <input type="phone"
                                       value="@if(isset($organization->id)){{$organization->mobile}}@endif"
                                       name="mobile" lay-verify="required" placeholder="手机号" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>员工总数：</label>
                            <div class="layui-input-block">
                                <input type="number"
                                       value="@if(isset($organization->id)){{$organization->staff_count}}@endif"
                                       onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                                       oninput="if(value.length>11)value=value.slice(0,11)"
                                       name="staff_count" lay-verify="required" placeholder="员工总数(11位长度)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">农民工数：</label>
                            <div class="layui-input-block">
                                <input type="number"
                                       value="@if(isset($organization->id)){{$organization->farmer_count}}@endif"
                                       onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                                       oninput="if(value.length>11)value=value.slice(0,11)"
                                       name="farmer_count" lay-verify="required" placeholder="农民工数(11位长度)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">账户：</label>
                            <div class="layui-input-block">
                                <input type="number"
                                       value="@if(isset($organization->id)){{$organization->account}}@endif"
                                       onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                                       oninput="if(value.length>11)value=value.slice(0,11)"
                                       name="account" lay-verify="required" placeholder="农民工数(11位长度)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">开户行：</label>
                            <div class="layui-input-block">
                                <input type="number"
                                       onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                                       oninput="if(value.length>11)value=value.slice(0,11)"
                                       value="@if(isset($organization->id)){{$organization->bank_name}}@endif"
                                       name="bank_name" lay-verify="required" placeholder="农民工数(11位长度)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">企业官网：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($organization->id)){{$organization->website}}@endif"
                                       maxlength="191"
                                       name="website" placeholder="企业网站"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案名称：</label>
                            <div class="layui-input-block">
                                <input type="text" value="@if(isset($organization->id)){{$organization->plan_name}}@endif"
                                       name="plan_name" lay-verify="required" placeholder="方案名称(最多45个字符)" autocomplete="off"
                                       maxlength="45"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案概述：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              name="summary" lay-verify="required" placeholder="方案名称(最多500个字符)" autocomplete="off"
                              maxlength="500"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->summary}}@endif</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案内容：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="content" lay-verify="required" placeholder="方案内容(最多500个字符)" autocomplete="off"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->content}}@endif</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案目标：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="target_task" lay-verify="required" placeholder="方案目标(最多500个字符)" autocomplete="off"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->target_task}}@endif</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">绩效目标：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="achievement_target" lay-verify="required" placeholder="绩效目标(最多500个字符)" autocomplete="off"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->achievement_target}}@endif</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>实施目标：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="measures" lay-verify="required" placeholder="实施目标(最多500个字符)" autocomplete="off"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->measures}}@endif</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">表彰奖励：</label>
                            <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="commend" placeholder="表彰奖励(最多500个字符)"
                              style = "width:990px;height: 130px;">@if(isset($organization->id)){{$organization->commend}}@endif</textarea>
                            </div>
                        </div>

                        {{--<div class="layui-form-item">--}}
                        {{--<label class="layui-form-label">方案图片地址：</label>--}}
                        {{--<div class="layui-input-block">--}}
                        {{--@if(isset($organization->id))--}}
                        {{--<img src="{{$organization->img_url}}" alt = "公司图片" />--}}
                        {{--@else--}}
                        {{--<input type="file" name="img_url" placeholder="公司图片">--}}
                        {{--@endif--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        <div class="layui-form-item">
                            <label class="layui-form-label">项目等级：</label>
                            <div class="layui-input-block">
                                <select name="unit_id" lay-filter="aihao">
                                    <option value="0" @if(isset($organization->id) && $organization->grade == 0) selected @endif>非重点</option>
                                    <option value="1" @if(isset($organization->id) && $organization->grade == 1) selected @endif>市重点</option>
                                    <option value="2" @if(isset($organization->id) && $organization->grade == 2) selected @endif>国家重点</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>分享标题：</label>
                            <div class="layui-input-block">
                                <input type="text"
                                       maxlength="11"
                                       value="@if(isset($organization->id)){{$organization->share_title}}@endif"
                                       name="share_title" lay-verify="required" placeholder="分享标题(最多11个字符)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>分享描述：</label>
                            <div class="layui-input-block">
                                <input type="text"
                                       value="@if(isset($organization->id)){{$organization->share_title}}@endif"
                                       maxlength="100"
                                       name="share_title" lay-verify="required" placeholder="分享描述(最多100个字符)" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>分享图片：</label>
                            <div class="layui-input-block">
                                <input type="text"
                                       value="@if(isset($organization->id)){{$organization->share_img}}@endif"
                                       name="share_img" lay-verify="required" placeholder="分享图片" autocomplete="off"
                                       class="layui-input">
                            </div>
                        </div>

                        <button class="layui-btn layui-btn-normal" style = "margin-left: 8%;" >立即提交</button>

                        {{--<div class="layui-form-item">--}}
                        {{--<label class="layui-form-label">请选择推荐类型：</label>--}}
                        {{--<div class="layui-input-block">--}}

                        {{--<select name="kind">--}}
                        {{--<option value="{{$nominee['kind']}}">请选择推荐类型</option>--}}
                        {{--<option value="1" @if($nominee['kind']!=null&&$nominee['kind']=='劳动之星') selected @endif >劳动之星--}}
                        {{--</option>--}}
                        {{--<option value="2" @if($nominee['kind']!=null&&$nominee['kind']=='技能之星') selected @endif>技能之星--}}
                        {{--</option>--}}
                        {{--<option value="3" @if($nominee['kind']!=null&&$nominee['kind']=='创新之星') selected @endif>创新之星--}}
                        {{--</option>--}}
                        {{--<option value="4" @if($nominee['kind']!=null&&$nominee['kind']=='服务之星') selected @endif>服务之星--}}
                        {{--</option>--}}
                        {{--</select>--}}

                        {{--</div>--}}
                        {{--</div>--}}
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
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=unitImg"
        });

        var img = '{{$unit->photo}}';
        if (img) {
            var list = img.split(',');
            for (var i in list) {
                photo.successDo(list[i],true);
            }
        }


    </script>
@endsection