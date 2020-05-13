{{--@section('title', '添加优秀个人')--}}
@section('id',!empty($caseScheme['id']) ? $caseScheme['id'] : 0 )

@section("content")
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<body>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px; ">
        <button class="layui-btn layui-btn-normal" type="button" onclick="javascript:history.back();">返回</button>
    </div>
    <form class="layui-form tc-container mT0">
        <div class="layui-form-item">
            <label class="layui-form-label">标题：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($caseScheme['title']) ? $caseScheme['title'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">唯一代码：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{!empty($caseScheme['code']) ? $caseScheme['code'] : ''}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['is_open'] ? '开启' : '关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">赛事类型：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme->caseSchemeType['name']}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">赛事周期：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['activity_stime']))
                    {{$caseScheme['activity_stime']}}
                    至{{$caseScheme['activity_etime']}}
                @endif</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">赛事描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['activity_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">展示时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['show_stime']))
                    {{$caseScheme['show_stime']}}
                    至{{$caseScheme['show_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['show_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">展示状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['show_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">展示描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['show_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">企业推选时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['qy_stime']))
                    {{$caseScheme['qy_stime']}}
                    至{{$caseScheme['qy_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否企业推选：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['qy_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">企业推选状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['qy_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">企业推选描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['qy_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">工会推选时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['gh_stime']))
                    {{$caseScheme['gh_stime']}}
                    至{{$caseScheme['gh_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否工会推选：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['gh_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">工会推选状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['gh_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">工会推选描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['activity_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总工会筛选时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['zgh_stime']))
                    {{$caseScheme['zgh_stime']}}
                    至{{$caseScheme['zgh_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否总工会筛选：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['zgh_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总工会筛选状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['zgh_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总工会筛选描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['zgh_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">大众评选时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['public_stime']))
                    {{$caseScheme['public_stime']}}
                    至{{$caseScheme['public_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否大众评选：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['public_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">大众评选状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['public_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">大众评选描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['public_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">专家投票时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['zj_stime']))
                    {{$caseScheme['zj_stime']}}
                    至{{$caseScheme['zj_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否专家投票：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['zj_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">专家投票状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['zj_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">专家投票描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['zj_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">年度投票时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">
                @if(!empty($caseScheme['year_stime']))
                    {{$caseScheme['year_stime']}}
                    至{{$caseScheme['year_etime']}}
                @endif
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否年度投票：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['year_is_join']?'是':'否'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">年度投票状态：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['year_is_open']?'开启':'关闭'}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">年度投票描述：</label>
            <div class="layui-input-block">
                <textarea type="text" name="summary" lay-verify="required" placeholder="方案名称" autocomplete="off" style="width:100%;height: 130px;">{{$caseScheme['year_explain'] }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">颁奖时间：</label>
            <div class="layui-input-block">
                <span type="text" class="layui-input">{{$caseScheme['prize_at'] }}</span>
            </div>
        </div>
    </form>
</body>
@endsection
@section('js')

@endsection
@extends('common.editTwo')
