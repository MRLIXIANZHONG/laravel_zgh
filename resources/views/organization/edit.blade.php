@if (isset($organization))
    @section('title', '添加企业方案')
@else
    @section('title', '添加企业方案')
@endif
@extends('common.editTwo')

<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<style>
    .layui-form-label {
        width: 150px;
    }
</style>
@section("content")
    <body>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="organization">
        {{--<!-- @if(isset($organization->id))--}}
        {{--<form action="{{ url('admin/organizations/'.$organization->id) }}" method="POST" accept-charset="UTF-8"--}}
              {{--class="layui-form" id="nomineeForm" enctype="multipart/form-data">--}}
            {{--<input type="hidden" name="_method" value="PUT">--}}
        {{--@else--}}
        {{--<form action="{{ url('admin/organization') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data"--}}
              {{--class="layui-form" id="nomineeForm">--}}
        {{--@endif--}}
            {{--{{ csrf_field() }} -->--}}
        <form class="layui-form tc-container mT0">
            <input hidden name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>单位名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($organization->id)){{$organization->name}}@endif"
                           maxlength="100"
                           name="name" lay-verify="required" required placeholder="单位名称(最多100个字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">单位logo：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img src="@if($organization->id) {{$organization->photo}} @endif" style="width:150px;height: 150px;" class="imgBox">
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="photo" name="photo" class="hide-val" data-sum="0" @if($organization->id) value="{{$organization->photo}}" @endif/>

                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">重点竞赛：</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_competition" value="1"  @if($organization->id && $organization->is_competition == 1) checked @endif lay-skin="switch" lay-text="开启|关闭">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>上级工会：</label>
                <div class="layui-input-block">

                    <select name="unit_id" lay-verify="required" required autocomplete="off" @if(in_array($organization->check_state,[1,2]))disabled @endif>
                        @foreach($units as $unit)
                            <option value="{{$unit->id}}" @if($unit->id == $organization->unit_id) selected @endif>{{$unit->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>单位类型：</label>
                <div class="layui-input-block">
                    <select name="new_type" lay-filter="aihao" lay-verify="required" required autocomplete="off">
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
                <label class="layui-form-label">行业：</label>
                <div class="layui-input-block">
                    @foreach($industries as $industry)
                        <input type="checkbox" name="industry_tag[]" value="{{$industry->id}}" title="{{$industry->industry_name}}" @if(in_array($industry->id,$organization->industry_tag)) checked @endif>
                    @endforeach
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>姓名：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($organization->id)){{$organization->username}}@endif"
                           maxlength="100"
                           name="username" lay-verify="required" required placeholder="姓名" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>手机号：</label>
                <div class="layui-input-block">
                    <input type="phone"
                           value="@if(isset($organization->id)){{$organization->mobile}}@endif"
                           name="mobile" lay-verify="required" required placeholder="手机号" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>员工总数：</label>
                <div class="layui-input-block">
                    <input type="number"
                           value="@if(isset($organization->id)){{$organization->staff_count}}@endif"
                           name="staff_count" lay-verify="required" required placeholder="员工总数(11位长度)" autocomplete="off"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           class="layui-input" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">农民工数：</label>
                <div class="layui-input-block">
                    <input type="number"
                           value="@if(isset($organization->id)){{$organization->farmer_count}}@endif"
                           name="farmer_count" lay-verify="required" required placeholder="农民工数(11位长度)" autocomplete="off"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">账户：</label>
                <div class="layui-input-block">
                    <input type="number"
                           value="@if(isset($organization->id)){{$organization->account}}@endif"
                           name="account" lay-verify="required" required placeholder="账户(11位长度)" autocomplete="off"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开户行：</label>
                <div class="layui-input-block">
                    <input type="number"
                           value="@if(isset($organization->id)){{$organization->bank_name}}@endif"
                           name="bank_name" lay-verify="required" required placeholder="开户行(11位长度)" autocomplete="off"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">企业官网：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($organization->id)) {{$organization->website}}  @endif"
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
                           name="summary" lay-verify="required" placeholder="方案概述(最多500个字符)" autocomplete="off"
                              maxlength="500"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->summary}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案内容：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="content" lay-verify="required" placeholder="方案内容(最多500个字符)" autocomplete="off"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->content}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案目标：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="target_task" lay-verify="required" placeholder="方案目标(最多500个字符)" autocomplete="off"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->target_task}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">绩效目标：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              name="achievement_target" lay-verify="required" placeholder="绩效目标(最多500个字符)" autocomplete="off"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->achievement_target}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>实施目标：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="measures" lay-verify="required" placeholder="实施目标(最多500个字符)" autocomplete="off"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->measures}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">表彰奖励：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="500"
                              name="commend" placeholder="表彰奖励(最多500个字符)"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->commend}}@endif</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">项目等级：</label>
                <div class="layui-input-block">
                    <select name="grade" lay-filter="aihao">
                        <option value="0" @if(isset($organization->id) && $organization->grade == 0) selected @endif>非重点</option>
                        <option value="1" @if(isset($organization->id) && $organization->grade == 1) selected @endif>市重点</option>
                        <option value="2" @if(isset($organization->id) && $organization->grade == 2) selected @endif>国家重点</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>分享标题：</label>
                <div class="layui-input-block">
                    <input type="text" value="@if(isset($organization->id)){{$organization->share_title}}@endif"
                           maxlength="11"
                           name="share_title" lay-verify="required" required placeholder="分享标题(最多11个字符)" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              maxlength="100"
                              name="share_description" lay-verify="required" placeholder="分享描述(最多100个字符)" autocomplete="off"
                              style = "width:100%;height: 130px;">@if(isset($organization->id)){{$organization->share_description}}@endif</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" type="submit" lay-submit lay-filter="formDemo">立即提交</button>

                    @if($user['role_id'] == 1)
                        <button type="button" onclick="setPassword()" class="layui-btn layui-btn-normal">设置密码</button>
                    @elseif($user['role_id'] == 3 && $organization->id == $user['org_id'])
                        <button type="button" onclick="setPassword()" class="layui-btn layui-btn-normal">设置密码</button>
                    @endif
                    @if ($user['roles'][0]['id'] == 1)
                        <button type="button" onclick="setOrganizationVirtual()" class="layui-btn layui-btn-normal">设置浏览点赞</button>
                    @endif
                    @if($user['role_id'] == 3)
                        <button type="button" onclick="organizationPull()" class="layui-btn layui-btn-normal">立即推送</button>
                    @endif
                </div>
            </div>
        </form>

        <div id="setPassword" hidden>
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">密码：</label>
                    <input type="password" name="password" id="password" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请输入密码" style="display: inline-block;width: 50%;" value="">
                </div>
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">确认密码：</label>
                    <input type="password" name="repeat_password" id="repeat_password" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请确认密码" style="display: inline-block;width: 50%;" value="">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formPassword" style="margin-left: 18%;margin-top: 8px;">设置密码</button>
            </form>
        </div>

        <div id="setOrganizationVirtual" hidden>
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>虚拟浏览量：</label>
                    <input type="text" name="virtual_browse" id="virtual_browse" class="layui-input"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           lay-verify="required" required autocomplete="off" placeholder="请输入虚拟游览量" style="display: inline-block;width: 50%;" value="{{$unit->virtual_browse}}">
                </div>
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>虚拟点赞量：</label>
                    <input type="text" name="virtual_star" id="virtual_star" class="layui-input" lay-verify="required"
                           onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))"
                           oninput="if(value.length>11)value=value.slice(0,11)"
                           required autocomplete="off" placeholder="虚拟点赞量" style="display: inline-block;width: 50%;" value="{{$unit->virtual_star}}">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formOrganizationVirtual" style="margin-left: 18%;margin-top: 8px;">立即设置</button>
            </form>
        </div>
    </div>
    </body>
@endsection
@section('js')

    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/upload.js"></script>

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

        layui.use(['form'], () => {
            let form = layui.form();
            form.render();
            //监听提交
            form.on('submit(formDemo)', () => {
                $.ajax({
                    url: "{{url('/admin/organizations/'.$organization->id)}}",
                    data: $('form').serialize(),
                    type: 'PUT',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
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
            form.on('submit(formPassword)', function(data) {

                $.ajax({
                    url: "{{url('/admin/organizations/'.$organization->id.'/set_password')}}",
                    data: {'password': data.field.password, 'repeat_password': data.field.repeat_password, '_token': data.field._token},
                    type: 'PATCH',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
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
            form.on('submit(formOrganizationVirtual)', function(data) {

                $.ajax({
                    url: "{{url('/admin/organizations/'.$organization->id.'/set_virtual')}}",
                    data: {'virtual_browse': data.field.virtual_browse, 'virtual_star': data.field.virtual_star, '_token': data.field._token},
                    type: 'PATCH',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6});
                            //layer.sleep(2);
                            //layer.closeAll();
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
        function organizationPull() {
            $.ajax({
                url: "{{url('/admin/organizations/'.$organization->id.'/pull')}}",
                data: {'_token': '{{csrf_token()}}'},
                type: 'PATCH',
                dataType: 'json',
                success: function (res) {
                    console.log(res);
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
        }
        function setOrganizationVirtual() {
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:1,
                title:"设置虚拟浏览点赞量",
                area: ['36%','40%'],
                content:$("#setOrganizationVirtual").html()
            });
        }

        //选择角色弹层
        function setPassword(){
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:1,
                title:"设置密码",
                area: ['36%','40%'],
                content:$("#setPassword").html()
            });
        }

    </script>
@endsection