{{--@section('title', '添加优秀个人')--}}
@section('id',!empty($nominee['id']) ? $nominee['id'] : 0 )
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/admin/css/formSelects-v4.css">
<link rel="stylesheet"
      href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@section("content")
    <body>

    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <form class="layui-form tc-container mT0" >
        <input hidden name="_token" value="{{csrf_token()}}">
        <div class="main" style="padding-top: 0px;" id="app">

            <input type="hidden" name="unit_id" value="{{$nominee['unit_id']}}">
            <input type="hidden" name="organization_id" value="{{$nominee['organization_id']}}">
            <input type="hidden" name="organization_name" value="{{$nominee['organization_name']}}">
            <input name="id" id="id" type="hidden" value="{{!empty($nominee['id']) ? $nominee['id'] : 0}}">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>员工姓名：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($nominee['staff_name']) ? $nominee['staff_name'] : ''}}"
                           name="staff_name" lay-verify="required" placeholder="参赛员工姓名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>员工电话：</label>
                <div class="layui-input-block">
                    <input type="text" maxlength="11" value="{{!empty($nominee['staff_phone']) ? $nominee['staff_phone'] : ''}}"
                           name="staff_phone" lay-verify="required|phone" placeholder="参赛员工电话" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>员工图片：</label>
                <div class="layui-input-block">
                    <div class="img-box imgBox clearfix">
                        <img id='staff_img_Box' style="width: 150px"/>

                        <div id="adBtn_img" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="staff_img" name="staff_img" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多1张 </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>推荐类型：</label>
                <div class="layui-input-block">

                    <select name="kind" lay-verify="required">
                        <option value="">推荐类型</option>
                        <option value="1" @if($nominee['kind']!=null&&$nominee['kind']=='劳动之星') selected @endif >劳动之星
                        </option>
                        <option value="2" @if($nominee['kind']!=null&&$nominee['kind']=='技能之星') selected @endif>技能之星
                        </option>
                        <option value="3" @if($nominee['kind']!=null&&$nominee['kind']=='创新之星') selected @endif>创新之星
                        </option>
                        <option value="4" @if($nominee['kind']!=null&&$nominee['kind']=='服务之星') selected @endif>服务之星
                        </option>
                    </select>

                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>所属行业：</label>
                <div class="layui-input-block">

                    <select name="industry_id" lay-verify="required">
                        <option value="">所属行业</option>
                        @foreach($industries as $industry)
                            <option value="{{$industry['id']}}"
                                    @if($nominee['industry_id']!=null&&$nominee['industry_id']==$industry['id']) selected @endif >{{$industry['industry_name']}}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>所属企业：</label>
                <div class="layui-input-block">
                    <input disabled type="text"
                           value="{{!empty($nominee['organization_name']) ? $nominee['organization_name'] : ''}}"
                           name="organization_name" lay-verify="required" placeholder="参赛企业名称" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>参与赛事：</label>
                <div class="layui-input-block">

                    <select name="case_scheme_id" lay-verify="required">
                        <option value="">参与赛事</option>
                        @foreach($caseSchemesList as $caseSchemes)
                            <option value="{{$caseSchemes['id']}}"
                                    @if($nominee['case_scheme_id']!=null&&$nominee['case_scheme_id']==$caseSchemes['id']) selected @endif >{{$caseSchemes['title']}}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">参与方案：</label>
                <div class="layui-input-block">
                    <select name="plan_id" xm-select="select10_2" xm-select-direction="down">
                        <option value="">参赛方案</option>
                        @foreach($orgPlanList as $plan)
                            <option value="{{$plan->id}}"
                                    @if(in_array($plan->id,$nomineePlanArr)) selected @endif>{{$plan->plan_name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>银行卡号：</label>
                <div class="layui-input-block">
                    <input type="text" maxlength="20" value="{{!empty($nominee['bank_card']) ? $nominee['bank_card'] : ''}}"
                           name="bank_card" lay-verify="required|number|maxlength" placeholder="银行卡号" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>开户行：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($nominee['bank_name']) ? $nominee['bank_name'] : ''}}"
                           name="bank_name" lay-verify="required" placeholder="开户行" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>开户姓名：</label>
                <div class="layui-input-block">
                    <input type="text"
                           value="{{!empty($nominee['bank_staff_name']) ? $nominee['bank_staff_name'] : ''}}"
                           name="bank_staff_name" lay-verify="required" placeholder="开户姓名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>银行卡照片：</label>
                <div class="layui-input-block">
                    <div class="img-box imgBox clearfix">
                        <img id='bankCard_img_Box' style="width: 150px"/>

                        <div id="adBtn_card" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="bank_card_img" name="bank_card_img" class="hide-val" data-sum="0"/>
                    <p style="color:#999">注：建议尺寸400像素*700像素，最多1张 </p>
                    <div style="height:50px"></div>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>推荐理由：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="推荐理由" name="caption"
                              lay-verify="required">{{!empty($nominee['caption']) ? $nominee['caption'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" type="button" lay-submit lay-filter="formDemo">立即提交
                    </button>
                </div>
            </div>
        </div>
    </form>
    </body>
@endsection
@section('js')
    <script src="{{ env('APP_URL') }}/static/admin/js/formSelects-v4.js"></script>
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
    <script>
        //加载图片
        var cover = new xUploader({
            btn: '#adBtn_img',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#staff_img',
            imgElement: '#staff_img_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=nominee"
        });
        //加载图片
        if ('{{!empty($nominee['staff_img'])}}' != '') {
            cover.successDo('{{$nominee['staff_img']}}', true)
        }
        //加载银行卡图片
        var bank_card_img = new xUploader({
            btn: '#adBtn_card',
            progressElement: '.progress',
            progressElement1: '.progress .text',
            progressElement2: '.progress .percentage',
            valueElement: '#bank_card_img',
            imgElement: '#bankCard_img_Box',
            upType: 'type1',
            imgLenth: '.img-box .loading',
            maxLen: 1,
            singleSizeLimit: '5mb',
            server: "/admin/news/upload?_token={{csrf_token()}}&folder=nominee"
        });
        //加载银行卡图片
        if ('{{!empty($nominee['bank_card_img'])}}' != '') {
            bank_card_img.successDo('{{$nominee['bank_card_img']}}', true)
        }


        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            form.verify({
                //用户名-函数
                maxlength: function (value, item) {
                    //value：表单的值、item：表单的DOM对象
                    if (!new RegExp("^(.+){16,20}$").test(value)) {
                        return '银行卡号长度必须为16-20位'
                    }
                },
            });
            //监听提交
            form.on('submit(formDemo)', () => {
                if ($('#staff_img').val() == '') {
                    layer.msg('请上传员工图片', {icon: 5});
                    return false;
                }
                if ($('#bank_card_img').val() == '') {
                    layer.msg('请上传银行卡照片', {icon: 5});
                    return false;
                }

                $.ajax({
                    url: "{{url('/admin/nominees/update')}}",
                    data: $('form').serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
                                window.location.href = "/admin/nominees/index";
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
