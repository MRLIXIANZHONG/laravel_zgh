@section('title', '专家修改')
@extends('common.common')
@section("content")
    <div style="width: 100%; text-align: center;margin-top: 10px; height: 20px;">
         <strong>个人信息</strong>
    </div>
    <form class="layui-form" action="/admin/judges/update" method="post">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" value="{{!empty($judges['id']) ? $judges['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专家姓名：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$judges['name']}}" readonly class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专家图片：</label>
            <div class="layui-input-block">
                <img src="{{$judges['photo']}}" height="100px" width="100px" alt="">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属行业：</label>
            <div class="layui-input-block">
               @foreach($industry as $item)
                @if($item->id==$judges->industry)
                    <input type="text" value=" {{$item->industry_name}}" readonly class="layui-input">
                @endif
               @endforeach
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专家类型：</label>
            <div class="layui-input-block">
                @if($judges['kind']===1)<input type="text" value=" 专家" class="layui-input" readonly> @endif
                @if($judges['kind']===2)<input type="text" value=" 劳模" class="layui-input" readonly> @endif
                @if($judges['kind']===3)<input type="text" value=" 媒体" class="layui-input" readonly> @endif
                @if($judges['kind']===4)<input type="text" value=" 巴渝工匠" class="layui-input" readonly> @endif
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">专业特长：</label>
            <div class="layui-input-block">
                <input type="text" value=" {{$item->speciality}}" readonly class="layui-input">
            </div>

        </div>
        
        <div style="width: 100%; text-align: center;margin-top: 10px;height: 20px;">
            <strong>荣耀贡献</strong>
        </div>

    @foreach($honorjudges as $item)
            <div style="height: 20px;"></div>
            <div class="layui-form-item">
                <label class="layui-form-label">标题：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$item['name']}}" readonly class="layui-input">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">时间：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$item['honor_time']}}" readonly class="layui-input">
                </div>

            </div>
        

            <div class="layui-form-item">
                <label class="layui-form-label">文字介绍：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$item['content']}}" readonly class="layui-input">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">图片：</label>
                <div class="layui-input-block">
                    @if(!empty($item['img_url']))
                        @foreach (explode(',',$item['img_url']) as $item1)
                            <img height="100" width="100" src="{{$item1}}" alt="">
                        @endforeach
                    @endif
                </div>

            </div>
            <div style="width: 99%; border: 1px #000000 dashed"></div>
    @endforeach
        <div style="width: 100%; text-align: center;margin-top: 10px; height: 20px;">
            <strong>账号信息</strong>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">登录账户：</label>
            <div class="layui-input-block">
                <input type="text" value="{{$judges['phone']}}" readonly class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">登录密码：</label>
            <div class="layui-input-block">
                <input type="password" value="{{$judges['password']}}" name="password" oninput="if(value.length>60)value=value.slice(0,60)" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">绑定手机号：</label>
            <div class="layui-input-block">
                <input type="phone" readonly value="{{$judges['phone']}}" name="phone" class="layui-input">
            </div>

        </div>

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">获取验证码：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="text" value="" class="layui-input">--}}
{{--            </div>--}}

{{--        </div>--}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">保存</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
<script>
    layui.use(['form'], function () {
        var form = layui.form();
        form.render();
        form.on('submit(formDemo)', function (data) {
            $.ajax({
                url: "/admin/judges/update",
                data: $('form').serialize(),
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000)
                        layer.msg('修改成功');
                    else
                        layer.msg(res.msg);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
            return false;
        });
    });
</script>
@endsection


