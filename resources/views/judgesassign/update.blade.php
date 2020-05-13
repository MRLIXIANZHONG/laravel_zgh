@section('title', '专家指派修改')
<link rel="stylesheet" href="/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
@extends('common.common')
@section("content")
    @if(empty($editType))
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/judgesassign/index" >返回</a>
    </div>
    <form class="layui-form tc-container" action="/admin/judgesassign/update" method="post">
        <div class="layui-form-item" style="display: none;">
            <div class="layui-input-block">
                <input type="hidden" value="{{$judgesassign['id']}}" name="id"  required lay-verify="id"  autocomplete="off">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专家指派名称：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="50" value="{{$judgesassign['name']}}" name="name" lay-verify="required" placeholder="请输入专家姓名" autocomplete="off" class="layui-input">
            </div>

        </div>

        @if(!$State)
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>专家团队数量：</label>
            <div class="layui-input-block">
                <input type="number" value="{{$judgesassign['judesCount']}}"  oninput="if(value.length>3)value=value.slice(0,3)" name="judesCount" lay-verify="required" placeholder="请输入专家团队数量(最多3位数)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>备选专家数量：</label>
            <div class="layui-input-block">
                <input type="number" value="{{$judgesassign['bakjudesCount']}}" oninput="if(value.length>3)value=value.slice(0,3)" name="bakjudesCount" lay-verify="required" placeholder="请输入备选专家数量(最多3位数)" autocomplete="off" class="layui-input">
            </div>

        </div>
        @endif
        @if($userrole==5)
        <div class="layui-form-item">
            <label class="layui-form-label">专家指派状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="state" title="待审核" value="0" @if($judgesassign['state']===0)checked @endif/>
                <input type="radio" name="state" title="已审核" value="1" @if($judgesassign['state']===1)checked @endif/>
            </div>
        </div>
        @else
            @if($judgesassign['state']==-1)
                <input type="hidden" name="state" value="0"/>
            @else
                <input type="hidden" name="state" value="{{$judgesassign['state']}}"/>
             @endif
        @endif

        <div class="layui-form-item">
            <label class="layui-form-label">选择评选活动</label>
            <div class="layui-input-block">
                <select name="case_schemes_id" lay-filter="case_schemes_id">
                    @foreach($caseSchemes as $item)
                        @if($item['id']==$judgesassign['case_schemes_id'])
                            <option selected value="{{$item['id']}}">{{$item['title']}}</option>
                        @else
                            <option value="{{$item['id']}}">{{$item['title']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>名单确认截止时间：</label>
            <div class="layui-input-block">
                <input type="text" name="endtime" id="endtime" lay-verify="required" value="{{$judgesassign['endtime']}}" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="nopassinfo" value=""/>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                <a href="/admin/judgesassign/index" class="layui-btn layui-btn-normal">返回</a>
            </div>
        </div>

    </form>
    @else
        <form class="layui-form" action="/admin/judgesassign/update" method="post">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="hidden" value="{{$judgesassign['id']}}" name="id"  required lay-verify="id"  autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">不通过原因:</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入不通过原因" name="nopassinfo" class="layui-textarea"></textarea>
                </div>
            </div>
            <input type="hidden" name="state" value="-1"/>
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
    <script>
        layui.use('laydate', function(){
            var endtime = layui.laydate;
            //常规用法
            endtime.render({
                elem: '#endtime'
            });
        });

        layui.use(['form'], function () {
            var form = layui.form();
            form.render();
            form.on('submit(formDemo)', function (data) {
                this.disabled=true;
                $.ajax({
                    url: "/admin/judgesassign/update",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        layer.msg('修改成功', {icon: 6},function () {
                            layer.msg('修改成功', {icon: 6},function () {
                                var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            });
                            window.location.href="/admin/judgesassign/index";
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

