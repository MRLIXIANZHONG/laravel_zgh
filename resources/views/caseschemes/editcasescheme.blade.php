@section('title', !empty($caseScheme['id']) ? '修改赛事信息' : '添加赛事信息')

@section("content")

<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<body>
    <style>
        
    </style>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <form class="layui-form tc-container mT0" method="post">
        <input hidden name="_token" value="{{csrf_token()}}">
        <div class="main" id="app">
            <input name="id" hidden value="{{!empty($caseScheme['id']) ? $caseScheme['id'] : 0 }}">
            <div class="layui-form-item">
                <label class="layui-form-label">标题：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($caseScheme['title']) ? $caseScheme['title'] : ''}}"
                           name="title" lay-verify="required" placeholder="赛事标题" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">唯一代码：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($caseScheme['code']) ? $caseScheme['code'] : ''}}"
                           name="code" lay-verify="required" placeholder="唯一代码" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">赛事类型：</label>
                <div class="layui-input-block">
                    <div class="layui-inline" style="width: 100%">
                        <select name="type">
                            <option value="0">请选择赛事类型</option>
                            @foreach($caseSchemesTypeList as $caseSchemesType)
                                <option value="{{$caseSchemesType['id']}}"
                                        @if($caseSchemesType['id']==$caseScheme['type']) selected @endif >{{$caseSchemesType['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($caseScheme['sort']) ? $caseScheme['sort'] : ''}}"
                           name="sort" lay-verify="required|number" placeholder="排序" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态：</label>
                <div class="layui-input-block">
                    <input type="checkbox" id="is_open"
                           lay-skin="switch" @if($caseScheme['is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="is_open" value="{{$caseScheme['is_open']}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">活动周期：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text"
                           value="{{!empty($caseScheme['activity_stime']) ? $caseScheme['activity_stime'] : ''}}"
                           name="activity_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['activity_etime']) ? $caseScheme['activity_etime'] : ''}}"
                           name="activity_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">赛事活动描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="赛事活动描述"
                              name="activity_explain">{{!empty($caseScheme['activity_explain']) ? $caseScheme['activity_explain'] : ''}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">展示时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['show_stime']) ? $caseScheme['show_stime'] : ''}}"
                           name="show_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['show_etime']) ? $caseScheme['show_etime'] : ''}}"
                           name="show_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label">是否展示：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="show_is_join"
                               lay-skin="switch" @if($caseScheme['show_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="show_is_join" value="{{$caseScheme['show_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启展示：</label>
                    <input type="checkbox" id="show_is_open"
                           lay-skin="switch" @if($caseScheme['show_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="show_is_open" value="{{$caseScheme['show_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">展示描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="展示描述"
                              name="show_explain">{{!empty($caseScheme['show_explain']) ? $caseScheme['show_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">企业推选时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['qy_stime']) ? $caseScheme['qy_stime'] : ''}}"
                           name="qy_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['qy_etime']) ? $caseScheme['qy_etime'] : ''}}"
                           name="qy_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label">是否企业推选：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="qy_is_join"
                               lay-skin="switch" @if($caseScheme['qy_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="qy_is_join" value="{{$caseScheme['qy_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启企业推选：</label>
                    <input type="checkbox" id="qy_is_open"
                           lay-skin="switch" @if($caseScheme['qy_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="qy_is_open" value="{{$caseScheme['qy_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">企业推选描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="工会推选描述"
                              name="qy_explain">{{!empty($caseScheme['qy_explain']) ? $caseScheme['qy_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">工会推选时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['gh_stime']) ? $caseScheme['gh_stime'] : ''}}"
                           name="gh_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['gh_etime']) ? $caseScheme['gh_etime'] : ''}}"
                           name="gh_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label" style="width:auto;">是否工会推选：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="gh_is_join"
                               lay-skin="switch" @if($caseScheme['gh_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="gh_is_join" value="{{$caseScheme['gh_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启工会推选：</label>
                    <input type="checkbox" id="gh_is_open"
                           lay-skin="switch" @if($caseScheme['gh_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="gh_is_open" value="{{$caseScheme['gh_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">工会推选描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="工会推选描述"
                              name="gh_explain">{{!empty($caseScheme['gh_explain']) ? $caseScheme['gh_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">总工会筛选时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['zgh_stime']) ? $caseScheme['zgh_stime'] : ''}}"
                           name="zgh_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['zgh_etime']) ? $caseScheme['zgh_etime'] : ''}}"
                           name="zgh_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label" style="width:auto;">是否总工会筛选：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="zgh_is_join"
                               lay-skin="switch" @if($caseScheme['zgh_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="zgh_is_join" value="{{$caseScheme['zgh_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启总工会筛选：</label>
                    <input type="checkbox" id="zgh_is_open"
                           lay-skin="switch" @if($caseScheme['gh_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="zgh_is_open" value="{{$caseScheme['gh_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">总工会筛选描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="赛事活动描述"
                              name="zgh_explain">{{!empty($caseScheme['zgh_explain']) ? $caseScheme['zgh_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">网络大众评选时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text"
                           value="{{!empty($caseScheme['public_stime']) ? $caseScheme['public_stime'] : ''}}"
                           name="public_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['public_etime']) ? $caseScheme['public_etime'] : ''}}"
                           name="public_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label" style="width:auto;">是否大众评选：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="public_is_join"
                               lay-skin="switch" @if($caseScheme['public_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="public_is_join" value="{{$caseScheme['public_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启大众评选：</label>
                    <input type="checkbox" id="public_is_open"
                           lay-skin="switch" @if($caseScheme['public_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="public_is_open" value="{{$caseScheme['public_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">网络大众评选描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="网络大众评选描述"
                              name="public_explain">{{!empty($caseScheme['public_explain']) ? $caseScheme['public_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">专家投票时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['zj_stime']) ? $caseScheme['zj_stime'] : ''}}"
                           name="zj_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['zj_etime']) ? $caseScheme['zj_etime'] : ''}}"
                           name="zj_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label" style="width:auto;">是否专家投票：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="zj_is_join"
                               lay-skin="switch" @if($caseScheme['zj_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="zj_is_join" value="{{$caseScheme['zj_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启专家投票：</label>
                    <input type="checkbox" id="zj_is_open"
                           lay-skin="switch" @if($caseScheme['zj_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="zj_is_open" value="{{$caseScheme['zj_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">专家投票投票描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="专家投票投票描述"
                              name="zj_explain">{{!empty($caseScheme['zj_explain']) ? $caseScheme['zj_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">年度投票时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['year_stime']) ? $caseScheme['year_stime'] : ''}}"
                           name="year_stime" placeholder="开始时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
                <span class="zhi">至</span>
                <div class="layui-input-inline" style="margin-left:10px;">
                    <input type="text"
                           value="{{!empty($caseScheme['year_etime']) ? $caseScheme['year_etime'] : ''}}"
                           name="year_etime" placeholder="结束时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div style="float: left;">
                    <label class="layui-form-label">是否年度投票：</label>
                    <div class="layui-input-block" style="width: 100px">
                        <input type="checkbox" id="year_is_join"
                               lay-skin="switch" @if($caseScheme['year_is_join']) checked @endif lay-text="开启|关闭">
                        <input type="hidden" name="year_is_join" value="{{$caseScheme['year_is_join']?:0}}">
                    </div>
                </div>
                <div>
                    <label class="layui-form-label">是否开启年度投票：</label>
                    <input type="checkbox" id="year_is_open"
                           lay-skin="switch" @if($caseScheme['year_is_open']) checked @endif lay-text="开启|关闭">
                    <input type="hidden" name="year_is_open" value="{{$caseScheme['year_is_open']?:0}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">年度投票描述：</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" type="text/plain" placeholder="年度投票描述"
                              name="year_explain">{{!empty($caseScheme['year_explain']) ? $caseScheme['year_explain'] : ''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:auto;">颁奖时间：</label>
                <div class="layui-input-inline" style="margin-left:0px;">
                    <input type="text" value="{{!empty($caseScheme['prize_at']) ? $caseScheme['prize_at'] : ''}}"
                           name="prize_at" placeholder="颁奖时间" autocomplete="off"
                           class="layui-input dateInfo">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </div>
    </form>
    </body>
@endsection
@section('js')
    <script>
        layui.use(['form'], () => {
            let form = layui.form();

            form.render();

            //监听提交
            form.on('submit(formDemo)', () => {
                // let url = '';
                // if ($('[name=\'id\']').val() != '0')
                //     url = "{{url('/admin/caseschemes/update')}}";
                // else
                //     url = "{{url('/admin/caseschemes/store')}}";
                $('input[type=checkbox]:checked').each(function () {
                    $('input[name=' + $(this).attr('id') + ']').val(1)
                });
                $.ajax({
                    url: "{{url('/admin/caseschemes/update')}}",
                    data: $('form').serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
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

        });
        layui.use('laydate', function () {
            var laydate = layui.laydate;

            $('.dateInfo').each(function () {
                laydate.render({
                    elem: this //指定元素
                    , type: 'datetime'
                    , trigger: 'click'
                });
            });
        });
    </script>
@endsection
@extends('common.editTwo')
