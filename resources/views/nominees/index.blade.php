@extends('common.list')
@section('title', '优秀个人列表')
<link rel="stylesheet" href="/static/admin/css/dropdown.css">
@section('table')
    <style>
        #table-list td {
            padding: 9px 10px;
        }

        .column-content-detail {
            padding-top: 15px !important;
        }
    </style>
@section('header')
    <input type="hidden" name="is_win" value="{{$nomineedto->getIsWin()}}">
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/nominees/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$nomineedto->getStaffName()}}" name="staff_name" placeholder="参赛员工关键字"
               autocomplete="off" class="layui-input" style="width: 120px;">
    </div>

    @if($userinfo['role_slug']!=='enterprise')
        <div class="layui-inline">
            <input type="text" value="{{$nomineedto->getOrganizationName()}}" name="organization_name"
                   placeholder="参赛企业关键字" autocomplete="off"
                   class="layui-input" style="width: 120px;">
        </div>
        @if($userinfo['role_slug']!=='union')
            <div class="layui-inline">
                <input type="text" value="{{$nomineedto->getUnitName()}}" name="unit_name"
                       placeholder="工会关键字" autocomplete="off"
                       class="layui-input" style="width: 120px;">
            </div>
        @endif
    @endif
    <div class="layui-inline" style="width: 145px;">
        <select name="kind">
            <option value="0">请选择推荐类型</option>
            <option value="1" @if($nomineedto->getKind()=='1') selected @endif>劳动之星</option>
            <option value="2" @if($nomineedto->getKind()=='2') selected @endif>技能之星</option>
            <option value="3" @if($nomineedto->getKind()=='3') selected @endif>创新之星</option>
            <option value="4" @if($nomineedto->getKind()=='4') selected @endif>服务之星</option>
        </select>
    </div>
    <div class="layui-inline" style="width: 145px;">
        <select name="yearpart">
            <option value="0">请选择年份</option>
            <option value="2020" @if($nomineedto->getYearpart()=='2020') selected @endif>2020</option>
        </select>
    </div>

    @if($userinfo['role_slug']!=='enterprise')
        <div class="layui-inline" style="width: 145px;">

            <select name="org_type">
                <option value="0">请选择企业类型</option>
                <option value="1"
                        @if($nomineedto->getOrgType() == 1) selected @endif >国营控股企业
                </option>
                <option value="2"
                        @if( $nomineedto->getOrgType() == 2) selected @endif >行政机关
                </option>
                <option value="3"
                        @if($nomineedto->getOrgType() == 3) selected @endif >港澳台、外商投资企业
                </option>
                <option value="4"
                        @if( $nomineedto->getOrgType() == 4) selected @endif >民营控股企业
                </option>
                <option value="5"
                        @if( $nomineedto->getOrgType() == 5) selected @endif >事业单位
                </option>
                <option value="6"
                        @if( $nomineedto->getOrgType() == 6) selected @endif >其他
                </option>
            </select>

        </div>
    @endif
    <div class="layui-inline" style="width: 145px;">
        <select name="case_scheme_id">
            <option value="0">请选择参与赛事</option>
            @foreach($caseSchemesList as $caseSchemes)
                <option value="{{$caseSchemes['id']}}"
                        @if($nomineedto->getCaseSchemeId()&&$nomineedto->getCaseSchemeId()==$caseSchemes['id']) selected @endif >{{$caseSchemes['title']}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="layui-inline" style="width: 145px;">
        <select name="industry_id">
            <option value="0">请选择所属行业</option>
            @foreach($industries as $industry)
                <option value="{{$industry['id']}}"
                        @if($nomineedto->getIndustryId()&&$nomineedto->getIndustryId()==$industry['id']) selected @endif >{{$industry['industry_name']}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="layui-inline" style="width: 145px;">
        <select name="recommend">
            <option value="-1">推荐状态</option>
            <option value="0" @if($nomineedto->getRecommend()===0) selected @endif>未推荐</option>

            <option value="1"
                    @if($nomineedto->getRecommend()==1) selected @endif >已推荐
            </option>

        </select>
    </div>
    <div class="layui-inline" style="width: 145px;">
        <select name="class_list">
            <option value="0">全部状态</option>
            @if($userinfo['role_slug']=='enterprise')
                <option value="1"
                        @if($nomineedto->getClassList() == 1) selected @endif >待申报
                </option>
            @endif
            <option value="2"
                    @if($nomineedto->getClassList() == 2) selected @endif >已申报/待审核
            </option>
            <option value="3"
                    @if($nomineedto->getClassList() == 3) selected @endif >已审核
            </option>
            <option value="4"
                    @if($nomineedto->getClassList() == 4) selected @endif >已驳回
            </option>
            <option value="5"
                    @if($nomineedto->getClassList() == 5) selected @endif >已获奖
            </option>

        </select>
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    @if($userinfo['role_slug']=='enterprise')
        <div class="layui-inline add-div" style="position: relative">
            <a class="layui-btn layui-btn-normal "
               href="{{url('/admin/nominees/edit')}}">添加优秀个人
            </a>
        </div>

    @endif

    @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal"
               href="{{url('/admin/nominees/exportexcel')}}?kind={{$nomineedto->getKind()}}&&organization_name={{$nomineedto->getOrganizationName()}}&&staff_name={{$nomineedto->getStaffName()}}&&case_scheme_id={{$nomineedto->getCaseSchemeId()}}&&org_type={{$nomineedto->getOrgType()}}&&industry_id={{$nomineedto->getIndustryId()}}">导出Excel</a>
        </div>
    @endif
    <table class="layui-table" lay-skin="nob" id="table-list">
        <thead>
        <tr>
            <th>编号</th>
            <th style="min-width: 60px">用户名</th>
            <th>照片</th>
            <th>电话</th>
            {{--            <th>卡号</th>--}}
            {{--            <th>开户行</th>--}}
            @if($userinfo['role_slug']!='enterprise')
                <th style="min-width: 60px">企业名称</th>
            @endif
            <th style="min-width: 40px">行业</th>
            @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                <th style="min-width: 60px">上级工会</th>
            @endif
            <th style="min-width: 60px">申报类型</th>
            <th style="min-width: 60px">申报活动</th>
            <th style="min-width: 60px">所获荣誉</th>
            <th style="min-width: 60px">申报状态</th>
            <th style="min-width: 60px">申报时间</th>
            <th style="min-width: 60px">审核状态</th>
            <th style="min-width: 60px">推荐首页</th>
            {{--            <th>季度票数</th>--}}
            {{--            <th>年度票数</th>--}}
            @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                <th style="min-width: 60px">浏览量</th>
                <th style="min-width: 60px">点赞量</th>
            @endif

            <th style="width: 140px">操作</th>
        </tr>
        </thead>
        <thbody>
            @if($nominesslist->count()==0)
                <tr>
                    <td colspan="17" style="text-align: center;color: #ff4500;">暂无数据</td>
                </tr>
            @else
                @foreach($nominesslist as $info)
                    <tr>

                        <td class="hidden-xs">W{{$info['id']}}</td>
                        <td class="hidden-xs">{{$info['staff_name']}}</td>
                        <td class="hidden-xs">
                            @if($info['staff_img'])
                                <img style="width: 100px;height: 100px;" src="{{$info['staff_img']}}" alt="">
                            @endif
                        </td>
                        <td class="hidden-xs">{{$info['staff_phone']}}</td>
                        {{--                        <td style="width: 150px;">{{$info['bank_card']}}</td>--}}
                        {{--                        <td>{{$info['bank_name']}}</td>--}}
                        @if($userinfo['role_slug']!=='enterprise')
                            <td class="hidden-xs">{{$info['organization_name']}}</td>
                        @endif
                        <td class="hidden-xs">
                            @if($info->industry)
                                {{$info->industry['industry_name']}}
                            @endif
                        </td>
                        @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                            <td class="hidden-xs">{{!empty($info->units->name) ? $info->units->name : ''}}</td>
                        @endif
                        <td class="hidden-xs">{{$info['kind']}}</td>

                        <td class="hidden-xs">{{!empty($info->caseSchemes->title) ? $info->caseSchemes->title : ''}}</td>
                        {{--获得的荣誉--}}

                        <td class="hidden-xs">@if(!empty($info['month_win']))
                                月度之星@endif @if(!empty($info['quarter_win']))
                                |季度之星@endif @if(!empty($info['year_win']))|年度之星 @endif  </td>

                        <td class="hidden-xs">{{$info['declare_status']?'已申报':'未申报'}}</td>
                        <td class="hidden-xs">{{$info['declare_at']}}</td>
                        <td class="hidden-xs">
                            @switch($info['check_status'])
                                @case (0)
                                未审核
                                @break
                                @case (1)
                                通过
                                @break
                                @case (2)
                                驳回
                                @break
                                @default
                            @endswitch
                        </td>

                        <td class="hidden-xs">
                            @switch($info['recommend'])
                                @case (0)
                                未推荐
                                @break
                                @case (1)
                                已推荐
                                @break
                            @endswitch
                        </td>
                        @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                            <td class="hidden-xs">{{$info['browse_count']}}</td>
                            <td class="hidden-xs">{{$info['star_count']}}</td>
                        @endif

                        {{--                    <td class="hidden-xs">{{$info['created_at']}}</td>--}}


                        <td class="hidden-xs">

                            <div class="layui-inline">
                                <a class="layui-btn layui-btn-small layui-btn-blue"
                                   href={{url('/admin/nominees/detail').'/'.$info['id']}} target="_self">
                                    <i class="layui-icon">&#xe615;</i>详情</a>
                                @if($info['check_status']!==1&&$userinfo['role_slug']==='enterprise')
                                    <a class="layui-btn layui-btn-small layui-btn-blue"
                                       href={{url('/admin/nominees/edit').'?id='.$info['id']}} target="_self">
                                        <i class="layui-icon">&#xe642;</i>修改</a>
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-danger"
                                            @click="deleteNominee('{{$info['id']}}')"
                                    >
                                        <i class="layui-icon">&#xe640;</i>删除
                                    </button>
                                @endif

                                @if($userinfo['role_slug']==='enterprise')
                                    {{--企业账户可以操作--}}
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                            @click="openExperience('{{$info['id']}}')"><i
                                                class="layui-icon">&#xe61f;</i>添加荣誉
                                    </button>
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                            @click="openImg('{{$info['id']}}')"><i class="layui-icon">&#xe61f;</i>添加荣誉图集
                                    </button>
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                            @click="openVideo('{{$info['id']}}')"><i class="layui-icon">&#xe61f;</i>添加荣誉视频
                                    </button>
                                    {{--申报--}}

                                    @if(!$info['declare_status'])
                                        <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                                @click="declare('{{$info['id']}}')"><i class="layui-icon">&#xe61f;</i>申报
                                        </button>
                                    @endif

                                @endif
                                @if($userinfo['role_slug']==='adminunion'||$userinfo['role_slug']==='administrator')
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                            @click="setvirtual('{{$info['id']}}','{{$info['v_browse_count']}}','{{$info['v_star_count']}}')"
                                    ><i class="layui-icon">&#xe61f;</i>添加数据
                                    </button>
                                @endif
                                @if(($userinfo['role_slug']==='union'||$userinfo['role_slug']==='administrator') &&$info['declare_status']===1&&$info['check_status']===0)
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                            @click="audit('{{$info['id']}}','1')"><i class="layui-icon">&#xe615;</i>审核
                                    </button>
                                @endif
                                @if($userinfo['role_slug']==='adminunion'||$userinfo['role_slug']==='administrator')
                                    @if(empty($info['quarter_win'])&&!empty($info['month_win'])&&$info['kind']!='服务之星')
                                        <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                                @click="setquarter('{{$info['id']}}')"><i
                                                    class="layui-icon">&#xe600;</i>设为季度之星
                                        </button>
                                    @elseif(empty($info['year_win'])&&!empty($info['quarter_win'])&&!empty($info['month_win'])&&$info['kind']!='服务之星')
                                        <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                                @click="setyear('{{$info['id']}}')"><i class="layui-icon">&#xe600;</i>设为年度之星
                                        </button>
                                    @endif
                                @endif

                                {{--推荐--}}
                                @if($userinfo['role_slug']==='administrator')
                                    @if($info['recommend'])
                                        <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                                @click="recommend('{{$info['id']}}',0)"><i
                                                    class="layui-icon">&#xe600;</i>取消推荐
                                        </button>
                                    @elseif($info['check_status']==1)
                                        <button type="button" class="layui-btn layui-btn-small layui-btn-blue"
                                                @click="recommend('{{$info['id']}}',1)"><i
                                                    class="layui-icon">&#xe600;</i>推荐
                                        </button>
                                @endif
                            @endif

                            {{--@if(!empty($info['month_win'])&&empty($info['year_win'])&&empty($info['quarter_win']))--}}
                            {{--<button type="button"--}}
                            {{--class="layui-btn layui-btn-small layui-btn-danger tips-info"--}}
                            {{--data-info="取消月度之星"--}}
                            {{--@click="cancelExcellent('{{$info['id']}}','1')"><i--}}
                            {{--class="layui-icon">&#xe640;</i>--}}
                            {{--</button>--}}

                            {{--@elseif(!empty($info['quarter_win'])&&empty($info['year_win']))--}}
                            {{--<button type="button"--}}
                            {{--class="layui-btn layui-btn-small layui-btn-danger tips-info"--}}
                            {{--data-info="取消季度之星"--}}
                            {{--@click="cancelExcellent('{{$info['id']}}','2')"><i--}}
                            {{--class="layui-icon">&#xe640;</i>--}}
                            {{--</button>--}}

                            {{--@elseif(!empty($info['year_win']))--}}
                            {{--<button type="button"--}}
                            {{--class="layui-btn layui-btn-small layui-btn-danger tips-info"--}}
                            {{--data-info="取消年度之星"--}}
                            {{--@click="cancelExcellent('{{$info['id']}}','3')"><i--}}
                            {{--class="layui-icon">&#xe640;</i>--}}
                            {{--</button>--}}
                            {{--@endif--}}

                            <!-- <div class="layui-dropdown" name="dropdown" id="dropdown{{$info['id']}}">
                                    <button class="layui-btn  layui-btn-small layui-dropdown-toggle" type="button"
                                            style="margin-right: 0">
                                        更多操作
                                        <i class="layui-icon layui-icon-down"></i>
                                    </button>
                                    <div class="layui-dropdown-menu">
                                        <div style="width: 140px; height: 35px;margin-top: 5px;margin-left: 5px;">


                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </thbody>
    </table>
    <div class="page-wrap">
        {{--        <label class="text-center no-padding no-margin">{{$nominesslist->total()}}条</label>--}}
        {{ $nominesslist->appends(['staff_name'=>$nomineedto->getStaffName(),
                                   'organization_name'=>$nomineedto->getOrganizationName(),
                                   'kind'=>$nomineedto->getKind(),
                                   'org_type'=>$nomineedto->getOrgType(),
                                   'industry_id'=>$nomineedto->getIndustryId(),
                                   'class_list'=>$nomineedto->getClassList(),
                                   'is_win'=>$nomineedto->getIsWin(),
                                   'yearpart'=>$nomineedto->getYearpart(),
                                   'recommend'=>$nomineedto->getRecommend(),
                                   'case_scheme_id'=> $nomineedto->getCaseSchemeId()
                                   ])->render() }}
    </div>
@endsection
@section('js')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        layui.use(['jquery', 'dropdown', 'laypage'], function () {
            //只要use就行，组件会自动渲染，如果是后期append到DOM结构中的元素需要再次渲染
            var dropdown = layui.dropdown;
            $("[name=\'dropdown\']").each(function () {
                dropdown.render('#' + $(this).attr('id'));
            });
        });
        let app = new Vue({
            el: "#table-list",
            data() {
                return {}
            },
            methods: {
                deleteNominee(id) {
                    layer.msg('您确认要删除吗？', {
                            time: 0,//不自动关闭
                            btn: ['确认', '取消'], //按钮
                            yes: function (index) {
                                layer.close(index);
                                layer.load(2);
                                setTimeout(function () {
                                    layer.closeAll('loading');
                                }, 2000);
                                $.ajax({
                                    url: "{{url('/admin/nominees/destroy')}}/" + id,
                                    data: {
                                        _token: '{{csrf_token()}}'
                                    },
                                    type: 'post',
                                    dataType: 'json',
                                    success: (res) => {
                                        if (res.code == 1000) {
                                            layer.msg(res.message);
                                            let index = parent.layer.getFrameIndex(window.name);
                                            setTimeout('parent.layer.close(' + index + ')', 2000);
                                            window.location.reload()
                                        } else {
                                            layer.msg(res.message);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.msg('网络请求失败', {time: 1000});
                                    }
                                })

                            },
                            no: function () {
                                layer.msg('取消了')
                            }
                        }
                    );
                },
                setquarter(id) {
                    layer.msg('您确认要设置为季度之星吗', {
                        time: 3000 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            //加载
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/nominees/quarter')}}/" + id,
                                data: {
                                    _token: '{{csrf_token()}}',
                                },
                                type: 'post',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload()
                                    } else {
                                        layer.msg(res.message);
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },
                setyear(id) {
                    layer.msg('您确认要设置为年度之星吗', {
                        time: 3000 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            //加载
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/nominees/year')}}/" + id,
                                data: {
                                    _token: '{{csrf_token()}}',
                                },
                                type: 'post',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload()
                                    } else {
                                        layer.msg(res.message);
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },
                cancelExcellent(id, type) {
                    let msg = '';
                    switch (type) {
                        case '1':
                            msg = '您确认要取消月度之星吗？';
                            break;
                        case '2':
                            msg = '您确认要取消季度之星吗？';
                            break;
                        case '3':
                            msg = '您确认要取消年度之星吗？';
                            break;
                    }
                    layer.msg(msg, {
                        time: 3000 //不自动关闭
                        , btn: ['确认', '取消'] //按钮
                        , yes: function (index) {
                            //加载
                            layer.close(index);
                            layer.load(2);
                            setTimeout(function () {
                                layer.closeAll('loading');
                            }, 2000);
                            $.ajax({
                                url: "{{url('/admin/nominees/cancelexcellent')}}",
                                data: {
                                    _token: '{{csrf_token()}}',
                                    id: id,
                                    type: type
                                },
                                type: 'post',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload()
                                    } else {
                                        layer.msg(res.message);
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },
                openExperience(id) {
                    location.href = "/admin/nominees/indexexperience/?mainId=" + id;
                },
                openImg(id) {
                    location.href = "/admin/nominees/indeximg/?mainId=" + id;
                },
                openVideo(id) {
                    location.href = "/admin/nominees/indexvideo/?mainId=" + id;
                },
                Number(val) {
                    if (parseFloat(val).toString() == "NaN") {
                        return false;
                    } else {
                        return true;
                    }
                },
                validation(val) {

                    var regu = /^(\+)?\d+(\.\d+)?$/;
                    if (val != "") {
                        if (!regu.test(val)) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                setvirtual(id, v_browse_count, v_star_count) {
                    $('#v_browse_count').val(v_browse_count);
                    $('#v_star_count').val(v_star_count);
                    layer.open({
                        content: '<div  id="type-content">\n' +
                            '        <div class="layui-form" style="margin-top: 15px;margin-right: 10px;">\n' +
                            '            <div class="layui-form-item" style="margin-right: 15px;">\n' +
                            '\n' +
                            '                <label class="layui-form-label">虚拟浏览量：</label>\n' +
                            '                <div class="layui-input-block">\n' +
                            '                    <input type="text" id="v_browse_count" lay-verify="number"\n' +
                            '                         value=\"' + v_browse_count + '\"  class="layui-input">\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <div class="layui-form-item" style="margin-right: 15px;">\n' +
                            '\n' +
                            '                <label class="layui-form-label">虚拟点击量：</label>\n' +
                            '                <div class="layui-input-block">\n' +
                            '                    <input type="text" lay-verify="number"\n' +
                            '                           id="v_star_count"\n' +
                            '                           value=\"' + v_star_count + '\"  style="margin-right: 10px;"\n' +
                            '                           class="layui-input">\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '    </div>',
                        title: '添加虚拟数据',
                        type: 1,
                        shadeClose: true,
                        skin: 'yourclass'
                        , btn: ['确定', '取消']
                        , yes: function () {
                            var vBrowseCount = $('#v_browse_count').val();
                            var vStarCount = $('#v_star_count').val();


                            if (!app.validation(vBrowseCount) || !app.validation(vStarCount)) {
                                layer.msg('请输入正确的虚拟数据');
                                return false;
                            }

                            $.ajax({
                                url: "{{url('/admin/nominees/setvirtual')}}",
                                data: {
                                    _token: '{{csrf_token()}}',
                                    id: id,
                                    v_browse_count: $('#v_browse_count').val(),
                                    v_star_count: $('#v_star_count').val()
                                },
                                type: 'post',
                                dataType: 'json',
                                success: (res) => {
                                    if (res.code == 1000) {
                                        layer.msg(res.message);
                                        let index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close(' + index + ')', 2000);
                                        window.location.reload()
                                    } else {
                                        layer.closeAll();
                                        layer.msg(res.message);

                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络请求失败', {time: 1000});
                                }

                            })
                        }
                    });
                },
                //审核
                audit(id) {
                    layer.open({
                        content: '<div style="margin-top: 15px;margin-left: 10px;"><p>审核意见:</p><textarea name="txt_remark" id="remark"  style="width:80%;height:80%;margin-left: 35px;margin-top: 5px;"></textarea></div>'
                        , btn: ['通过', '驳回', '取消']
                        , area: ['400px', '300px']
                        , type: 1
                        , yes: function (index, layero) {
                            var value1 = $('#remark').val();
                            app.check(id, 1, value1)

                        }, btn2: function (index, layero) {
                            var value1 = $('#remark').val();
                            if (value1 == '') {
                                layer.msg('请填写驳回意见');
                                return false;
                            } else {
                                app.check(id, 2, value1)
                            }
                        }, btn3: function (index, layero) {
                        }
                    });
                },
                check(id, status, opinion) {

                    $.ajax({
                        url: "{{url('/admin/nominees/check')}}",
                        data: {
                            _token: '{{csrf_token()}}',
                            id: id,
                            check_status: status,
                            check_opinion: opinion
                        },
                        type: 'post',
                        dataType: 'json',
                        success: (res) => {
                            if (res.code == 1000) {
                                layer.msg(res.message);
                                let index = parent.layer.getFrameIndex(window.name);
                                setTimeout('parent.layer.close(' + index + ')', 2000);
                                window.location.reload()
                            } else {
                                layer.closeAll();
                                layer.msg(res.message);

                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.msg('网络请求失败', {time: 1000});
                        }

                    })
                },
                declare(id) {
                    layer.msg('您确认要申报吗？', {
                            time: 0,//不自动关闭
                            btn: ['确认', '取消'], //按钮
                            yes: function (index) {
                                layer.close(index);
                                layer.load(2);
                                setTimeout(function () {
                                    layer.closeAll('loading');
                                }, 2000);
                                $.ajax({
                                    url: "{{url('/admin/nominees/declare')}}/" + id,
                                    data: {
                                        _token: '{{csrf_token()}}'
                                    },
                                    type: 'post',
                                    dataType: 'json',
                                    success: (res) => {
                                        if (res.code == 1000) {
                                            layer.msg(res.message);
                                            let index = parent.layer.getFrameIndex(window.name);
                                            setTimeout('parent.layer.close(' + index + ')', 2000);
                                            window.location.reload()
                                        } else {
                                            layer.msg(res.message);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.msg('网络请求失败', {time: 1000});
                                    }
                                })

                            },
                            no: function () {
                                layer.msg('取消了')
                            }
                        }
                    );
                },
                //推荐
                recommend(id, recommend) {
                    var msg = '您确认要推荐到首页吗？';
                    if (recommend == 0)
                        msg = '您确认要取消推荐吗？'
                    layer.msg(msg, {
                            time: 0,//不自动关闭
                            btn: ['确认', '取消'], //按钮
                            yes: function (index) {
                                layer.close(index);
                                layer.load(2);
                                setTimeout(function () {
                                    layer.closeAll('loading');
                                }, 2000);
                                $.ajax({
                                    url: "{{url('/admin/nominees/recommend')}}",
                                    data: {
                                        id: id,
                                        recommend: recommend,
                                        _token: '{{csrf_token()}}'
                                    },
                                    type: 'post',
                                    dataType: 'json',
                                    success: (res) => {
                                        if (res.code == 1000) {
                                            layer.msg(res.message);
                                            let index = parent.layer.getFrameIndex(window.name);
                                            setTimeout('parent.layer.close(' + index + ')', 2000);
                                            window.location.reload()
                                        } else {
                                            layer.msg(res.message);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.msg('网络请求失败', {time: 1000});
                                    }
                                })

                            },
                            no: function () {
                                layer.msg('取消了')
                            }
                        }
                    );
                }

            },
            created() {
                $("#toExcel").click(function () {
                    $.ajax({
                        url: "{{url('/admin/nominees/exportexcel')}}",
                        data: {
                            _token: '{{csrf_token()}}',
                            kind:{{$nomineedto->getKind()?:0}},
                            @if($nomineedto->getOrganizationName())
                            organization_name: '{{$nomineedto->getOrganizationName()}}',
                            @endif
                                    @if($nomineedto->getStaffName())
                            staff_name: '{{$nomineedto->getStaffName()}}',
                            @endif
                            case_scheme_id:{{$nomineedto->getCaseSchemeId()?:0}}
                        },
                        type: 'post',
                        dataType: 'json',
                        success: (res) => {
                            var $a = $("<a>");
                            $a.attr("href", res);
                            $a.attr("download", res);
                            $("body").append($a);
                            $a[0].click();
                            $a.remove();
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.msg('网络请求失败', {time: 1000});
                        }

                    })
                });


                $("[name='dropdown']").each(function (index) {
                    if ($(this).find('button').length == 1) {
                        $(this).hide();
                    }
                })
                layui.use(['form', 'jquery', 'laydate', 'layer', 'dialog'], function () {
                    var form = layui.form(),
                        $ = layui.jquery,
                        dialog = layui.dialog,
                        layer = layui.layer
                    ;
                    form.render();
                    $('.fresh').mouseenter(function () {
                        dialog.tips('刷新页面', this);
                    })
                    $('.fresh').click(function () {
                        window.location.reload()
                    });
                    $('.tips-info').mouseenter(function () {
                        var msg = $(this).attr('data-info');
                        dialog.tips(msg, this);
                    })
                });
            }
        })

    </script>
@endsection