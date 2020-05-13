@extends('common.list')
@section('title', '五小列表')
<link rel="stylesheet" href="https://hezulong1.gitee.io/layui-dropdown/dropdown.css">
@section('table')
    <script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>

    <style>
        #table-list td {
            padding: 9px 10px;
        }
        .column-content-detail {padding-top: 15px!important;}
    </style>
@section('header')
    <input type="hidden" name="is_win" value="{{$wuxiaoDto->getIsWin()}}">
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh"
             fresh-url="{{url('/admin/wuxiao/index')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$wuxiaoDto->getPlanName()}}" name="plan_name" placeholder="五小关键字"
               autocomplete="off" class="layui-input">
    </div>
    @if($userinfo['role_slug']!='enterprise')
        <div class="layui-inline">
            <input type="text" value="{{$wuxiaoDto->getOrganizationName()}}" name="organization_name"
                   placeholder="企业关键字" autocomplete="off"
                   class="layui-input">

        </div>
    @endif
    <div class="layui-inline">
        <select id="wuxiaotype" name="type">
            <option value="0">五小类型</option>
            <option value="1" @if($wuxiaoDto->getType()=='1') selected @endif >小发明</option>
            <option value="2" @if($wuxiaoDto->getType()=='2') selected @endif>小创造</option>
            <option value="3" @if($wuxiaoDto->getType()=='3') selected @endif>小革新</option>
            <option value="4" @if($wuxiaoDto->getType()=='4') selected @endif>小建议</option>
            <option value="5" @if($wuxiaoDto->getType()=='5') selected @endif>小设计</option>
        </select>
    </div>
    @if($userinfo['role_slug']==='enterprise')
    <div class="layui-inline">
        <select id="declaration_state" name="declaration_state">

            <option value="-1" @if($wuxiaoDto->getDeclarationState()===-1) selected @endif>申报状态</option>
            <option value="0" @if($wuxiaoDto->getDeclarationState()===0) selected @endif >未申报</option>
            <option value="1" @if($wuxiaoDto->getDeclarationState()===1) selected @endif>已申报</option>
        </select>
    </div>
    @endif
    <div class="layui-inline">
        <select id="declaration_state" name="check_state">
            <option value="">审核状态</option>
            <option value="0" @if($wuxiaoDto->getCheckState()===0) selected @endif >未审核</option>
            <option value="1" @if($wuxiaoDto->getCheckState()===1) selected @endif>已审核</option>
            <option value="-1" @if($wuxiaoDto->getCheckState()===-1) selected @endif >驳回</option>
        </select>
    </div>
    <div class="layui-inline">
        <select name="case_scheme_id">
            <option value="0">参与赛事</option>
            @foreach($caseSchemesList as $caseSchemes)
                <option value="{{$caseSchemes['id']}}"
                        @if($wuxiaoDto->getCaseSchemeId()&&$wuxiaoDto->getCaseSchemeId()==$caseSchemes['id']) selected @endif >{{$caseSchemes['title']}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="layui-inline" style="width: 145px;">
        <select name="recommend">
            <option value="-1">推荐状态</option>
            <option value="0" @if($wuxiaoDto->getRecommend()===0) selected @endif>未推荐</option>

            <option value="1"
                    @if($wuxiaoDto->getRecommend()==1) selected @endif >已推荐
            </option>

        </select>
    </div>

    <div class="layui-inline">

        <select name="org_type">
            <option value="0">企业类型</option>
            <option value="1" @if($wuxiaoDto->getorgType() && $wuxiaoDto->getorgType()== 1) selected @endif >国营控股企业
            </option>
            <option value="2" @if($wuxiaoDto->getorgType() && $wuxiaoDto->getorgType() == 2) selected @endif >行政机关
            </option>
            <option value="3" @if($wuxiaoDto->getorgType()&& $wuxiaoDto->getorgType() == 3) selected @endif >
                港澳台、外商投资企业
            </option>
            <option value="4" @if($wuxiaoDto->getorgType() && $wuxiaoDto->getorgType() == 4) selected @endif >民营控股企业
            </option>
            <option value="5" @if($wuxiaoDto->getorgType() && $wuxiaoDto->getorgType() == 5) selected @endif >事业单位
            </option>
            <option value="6" @if($wuxiaoDto->getorgType() && $wuxiaoDto->getorgType() == 6) selected @endif >其他
            </option>
        </select>

    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    @if($userinfo['role_slug']==='enterprise')
        <div class="layui-inline add-div">
            <a class="layui-btn layui-btn-normal"
               href="{{url('/admin/wuxiao/edit')}}">添加五小
            </a>
        </div>
    @endif
    @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
    <div class="layui-inline add-div">
        <a class="layui-btn layui-btn-normal"
       href="{{url('/admin/wuxiao/exportexcel')}}?type={{$wuxiaoDto->getType()}}&&organization_name={{{$wuxiaoDto->getOrganizationName()}}}&&plan_name={{$wuxiaoDto->getPlanName()}}&&declaration_state={{$wuxiaoDto->getDeclarationState()}}">导出Excel</a>
    </div>
    @endif
    <table class="layui-table" lay-skin="nob" id="table-list">
        <thead>
        <tr>
            <th style="min-width: 40px">序号</th>
            <th style="min-width: 40px">名称</th>
            <th>封面</th>
            <th style="min-width: 40px">类型</th>
            @if($userinfo['role_slug']!='enterprise')
                <th style="min-width: 60px">所属企业</th>
            @endif
            <th style="min-width: 60px">企业类型</th>
            @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                <th style="min-width: 60px">所属工会</th>
            @endif
            <th style="min-width: 60px">申报状态</th>
            <th style="min-width: 60px">申报时间</th>
            <th style="min-width: 60px">审核状态</th>
            <th style="min-width: 60px">所属行业</th>
            <th style="min-width: 60px">获得奖项</th>
            <th style="min-width: 60px">推荐首页</th>
            @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion'||$userinfo['role_slug']==='union')
                <th style="min-width: 60px">浏览量</th>
                <th style="min-width: 60px">点赞量</th>
                <th style="min-width: 80px">企业联系人</th>
                <th style="min-width: 80px">联系人电话</th>
            @endif

            <th style="min-width: 150px">操作</th>
        </tr>
        </thead>
        <thbody>
            @if(!$wuxiaolist->count())
                <tr>
                    <td colspan="17" style="text-align: center;color: #ff4500;">暂无数据</td>
                </tr>
            @else
                @foreach($wuxiaolist as $info)
                    <tr>

                        <td class="hidden-xs">{{$info['id']}}</td>
                        <td class="hidden-xs">{{$info['plan_name']}}</td>
                        <td class="hidden-xs"><img
                                    {{!empty($info['cover']) ? 'src='.url($info['cover']) : ''}} style="width: 40px;height: 50px;">
                        </td>
                        <td class="hidden-xs">{{$info['type']}}</td>
                        @if($userinfo['role_slug']!='enterprise')
                            <td class="hidden-xs">{{!empty($info->organizations->name) ? $info->organizations->name : ''}}</td>
                        @endif
                        @switch($info->organizations['type']?: 0)
                            @case (1)
                            <td class="hidden-xs">国营控股企业</td>
                            @break
                            @case (2)
                            <td class="hidden-xs">行政机关</td>
                            @break
                            @case (3)
                            <td class="hidden-xs">港澳台、外商投资企业</td>
                            @break
                            @case (4)
                            <td class="hidden-xs">民营控股企业</td>
                            @break
                            @case (5)
                            <td class="hidden-xs">事业单位</td>
                            @break
                            @default
                            <td class="hidden-xs">其他</td>
                        @endswitch
                        @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion')
                            <td class="hidden-xs">{{$info->units['name'] ?: ''}}</td>
                        @endif
                        <td class="hidden-xs">{{$info['declaration_state']?'已申报':'未申报'}}</td>
                        <td class="hidden-xs">{{$info['declaration_time']}}</td>
                        <td class="hidden-xs">
                            @switch($info['check_state'])
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
                            @if($info->industry)
                            {{  $info->industry['industry_name'] ?: ''}}
                            @endif
                        </td>
                        {{--<td class="hidden-xs">{{!empty($info['year_win'])?date('Y-m-d',strtotime($info['year_win'])):''}}</td>--}}
                        {{--                    <td class="hidden-xs">{{$info['check_state']}}</td>--}}
                        <td class="hidden-xs">@if(!empty($info['month_win']))
                                月度优秀五小@endif @if(!empty($info['quarter_win']))
                                |季度优秀五小@endif @if(!empty($info['year_win']))|年度优秀五小 @endif  </td>
                        {{--                    <td class="hidden-xs">{{$info['awards_time']}}</td>--}}

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
                        @if($userinfo['role_slug']==='administrator'||$userinfo['role_slug']==='adminunion'||$userinfo['role_slug']==='union')
                            <td class="hidden-xs">{{$info['browse_count']}}</td>
                            <td class="hidden-xs">{{$info['star_count']}}</td>
                            <td class="hidden-xs">{{ $info->organizations['username'] ?: ''}}</td>
                            <td class="hidden-xs">{{ $info->organizations['mobile'] ?: ''}}</td>
                        @endif

                        <td>
                            <div class="layui-inline">
                                <a class="layui-btn layui-btn-small layui-btn-blue" target="_self" href={{url('/admin/wuxiao/detail/'.$info['id'])}}>
                                    <i class="layui-icon">&#xe615;</i>详情</a>
                                @if($userinfo['role_slug']==='enterprise'&&$info['check_state']!==1)
                                    <a class="layui-btn layui-btn-small layui-btn-blue" href={{url('/admin/wuxiao/edit').'?id='.$info['id']}} target="_self">
                                        <i class="layui-icon">&#xe642;</i>修改</a>
                                    <button type="button" class="layui-btn layui-btn-small layui-btn-danger" @click="deleteNominee('{{$info['id']}}')">
                                        <i class="layui-icon">&#xe640;</i>删除</button>
                                @endif
                                            @if($userinfo['role_slug']==='enterprise')
                                                {{--申报--}}
                                                @if(!$info['declaration_state'])
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="declaration('{{$info['id']}}')">
                                                        <i class="layui-icon">&#xe61f;</i>申报</button>
                                                @endif
                                            @endif

                                            @if($userinfo['role_slug']==='union'&$info['declaration_state']&&!$info['check_state'])
                                                <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="audit('{{$info['id']}}')">
                                                    <i class="layui-icon">&#xe615;</i>审核</button>
                                            @endif

                                            @if($userinfo['role_slug']==='adminunion'||$userinfo['role_slug']==='administrator')
                                                <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="setvirtual('{{$info['id']}}','{{$info['v_browse_count']}}','{{$info['v_star_count']}}')"
                                                >
                                                    <i class="layui-icon">&#xe61f;</i>添加数据</button>

                                                {{--  审核通过可以设置为优秀五小--}}
                                                @if($info['check_state']==1&&empty($info['month_win']))
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="setExcellent('{{$info['id']}}')">
                                                        <i class="layui-icon">&#xe600;</i>设为月度优秀五小</button>
                                                @endif
                                                @if(empty($info['quarter_win'])&&!empty($info['month_win']))
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="setquarter('{{$info['id']}}')">
                                                        <i class="layui-icon">&#xe600;</i>设为季度优秀五小
                                                    </button>
                                                @elseif(empty($info['year_win'])&&!empty($info['quarter_win'])&&!empty($info['month_win']))
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="setyear('{{$info['id']}}')">
                                                        <i class="layui-icon">&#xe600;</i>设为年度优秀五小
                                                    </button>
                                                @endif
                                            @endif

                                            {{--推荐--}}
                                            @if($userinfo['role_slug']==='administrator')
                                                @if($info['recommend'])
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="recommend('{{$info['id']}}',0)">
                                                        <i class="layui-icon">&#xe600;</i>取消推荐
                                                    </button>
                                                @elseif($info['check_state']==1)
                                                    <button type="button" class="layui-btn layui-btn-small layui-btn-blue" @click="recommend('{{$info['id']}}',1)">
                                                        <i class="layui-icon">&#xe600;</i>推荐
                                                    </button>
                                                @endif
                                            @endif
                                <!-- <div class="layui-dropdown" name="dropdown" id="dropdown{{$info['id']}}">
                                    <button class="layui-btn  layui-btn-small layui-dropdown-toggle" type="button"
                                            style="margin-right: 20px">
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
        {{ $wuxiaolist->appends([  'plan_name'=>$wuxiaoDto->getPlanName(),
                                   'type'=>$wuxiaoDto->getType(),
                                   'declaration_state'=>$wuxiaoDto->getOrganizationName(),
                                    'org_type'=>$wuxiaoDto->getorgType(),
                                    'org_type'=>$wuxiaoDto->getDeclarationState(),
                                    'is_win'=>$wuxiaoDto->getIsWin(),
                                     'case_scheme_id'=> $wuxiaoDto->getCaseSchemeId(),
                                     'recommend'=> $wuxiaoDto->getRecommend(),
                                     'check_state'=> $wuxiaoDto->getCheckState()
                                   ])->render() }}
    </div>
@endsection
@section('js')
    <script>
        layui.use(['jquery', 'dropdown'], function () {
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
                                    url: "{{url('/admin/wuxiao/destroy')}}/" + id,
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
                declaration(id) {
                    layer.msg('确定要申报吗？', {
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
                                url: "{{url('/admin/wuxiao/declaration')}}/" + id,
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
                setExcellent(id) {

                    layer.msg('确定要设置为优秀吗？', {
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
                                url: "{{url('/admin/wuxiao/excellent')}}",
                                data: {
                                    _token: '{{csrf_token()}}',
                                    id: id,
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
                            return false ;
                        } else {
                            return true;
                        }
                    }
                },
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
                        url: "{{url('/admin/wuxiao/check')}}",
                        data: {
                            _token: '{{csrf_token()}}',
                            id: id,
                            check_state: status,
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
                setquarter(id) {
                    layer.msg('您确认要设置为季度优秀五小吗', {
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
                                url: "{{url('/admin/wuxiao/quarter')}}/" + id,
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
                    layer.msg('您确认要设置为年度优秀五小吗', {
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
                                url: "{{url('/admin/wuxiao/year')}}/" + id,
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
                                url: "{{url('/admin/wuxiao/setvirtual')}}",
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
                //推荐
                recommend(id,recommend) {
                    var msg='您确认要推荐到首页吗？';
                    if (recommend==0)
                        msg='您确认要取消推荐吗？'
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
                                    url: "{{url('/admin/wuxiao/recommend')}}" ,
                                    data: {
                                        id:id,
                                        recommend:recommend,
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
            },
            created() {
                $("[name='dropdown']").each(function (index) {
                    if ($(this).find('button').length==1)
                    {
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
