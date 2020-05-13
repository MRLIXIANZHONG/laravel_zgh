@section('title', '修改企业方案')

@extends('common.editTwo')
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
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
    <div class="layui-inline add-div">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <div class="main" id="unit">
        {{--<form action="{{ url('admin/units/'.$unit->id) }}" method="POST" accept-charset="UTF-8"--}}
              {{--class="layui-form" id="nomineeForm" enctype="multipart/form-data">--}}
            {{--<input type="hidden" name="_method" value="PUT">--}}
            {{--{{ csrf_field() }}--}}
        <form class="layui-form tc-container mT0">
            <input hidden name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layui-form-label">工会类型：</label>
                <div class="layui-input-block">
                    <select name="type" lay-filter="aihao">
                        <option value="1" @if($unit->type == 1) selected="" @endif>市直机关工会联合会</option>
                        <option value="2" @if($unit->type == 2) selected="" @endif>产业工会</option>
                        <option value="3" @if($unit->type == 3) selected="" @endif>区县工会</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">工会名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unit->name}}"
                           name="name" lay-verify="required" placeholder="工会名称" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">工会logo：</label>
                <div class="layui-input-block">
                    <div class="img-box clearfix">
                        {{--                    <ul class="imgBox l" data-prompt-position="bottomLeft:130,-80"></ul>--}}
                        <img src="{{$unit->photo}}" class="imgBox">
                        <div id="adBtn" class="adBtn l"></div>
                    </div>
                    <input type="hidden" id="photo" name="photo" class="hide-val" data-sum="0" value="{{$unit->photo}}"/>
                    <div class="progress" style="display:none">
                        <span class="text">0%</span>
                        <span class="percentage" style="width:0%;"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否开启荣誉工会：</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="honor_unit" value="1"  @if($unit->honor_unit == 1) checked @endif lay-skin="switch" lay-text="OFF|ON">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系人：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unit->username}}"
                           name="username" lay-verify="required" placeholder="联系人" autocomplete="off"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">联系电话：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unit->mobile}}"
                           name="mobile" lay-verify="required" placeholder="联系电话" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分享标题：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$unit->title}}"
                           name="share_title" lay-verify="required" placeholder="分享标题" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分享描述：</label>
                <div class="layui-input-block">
                    <textarea type="text"
                              name="share_description" placeholder="分享描述"
                              style = "width:100%;height: 130px;">{{$unit->share_description}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" type="submit" lay-submit lay-filter="formDemo">立即提交</button>
                    @if ($user['roles'][0]['id'] == 1)
                        <button type="button" onclick="setPassword()" class="layui-btn layui-btn-normal">设置密码</button>
                    @elseif ($unit->id === $user['units_id'])
                        <button type="button" onclick="setPassword()" class="layui-btn layui-btn-normal">设置密码</button>
                    @endif
                    @if ($user['roles'][0]['id'] == 1)
                        <button type="button" onclick="setVirtual()" class="layui-btn layui-btn-normal">设置浏览点赞</button>
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

        <div id="setVirtual" hidden>
            <form class="layui-form">
                <input hidden name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">虚拟浏览量：</label>
                    <input type="text" name="virtual_browse" id="virtual_browse" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="请输入虚拟游览量" style="display: inline-block;width: 50%;" value="{{$unit->virtual_browse}}">
                </div>
                <div class="layui-form-item" style="margin-top: 28px;">
                    <label class="layui-form-label">虚拟点赞量：</label>
                    <input type="text" name="virtual_star" id="virtual_star" class="layui-input" lay-verify="required" required autocomplete="off" placeholder="虚拟点赞量" style="display: inline-block;width: 50%;" value="{{$unit->virtual_star}}">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formVirtual" style="margin-left: 18%;margin-top: 8px;">立即设置</button>
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
                //console.log(666);
                $.ajax({
                    url: "{{url('/admin/units/'.$unit->id)}}",
                    data: $('form').serialize(),
                    type: 'PUT',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 1000) {
                            layer.msg(res.message, {icon: 6}, function () {
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
                    url: "{{url('/admin/units/'.$unit->id.'/set_password')}}",
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
            form.on('submit(formVirtual)', function(data) {

                $.ajax({
                    url: "{{url('/admin/units/'.$unit->id.'/set_virtual')}}",
                    data: {'virtual_browse': data.field.virtual_browse, 'virtual_star': data.field.virtual_star, '_token': data.field._token},
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
        });
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

        function setVirtual() {
            layer.open({
                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                type:1,
                title:"设置浏览点赞",
                area: ['36%','40%'],
                content:$("#setVirtual").html()
            });
        }

    </script>
@endsection