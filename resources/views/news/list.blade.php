@section('title', '新闻管理')
@section('header')
<style type="text/css">
    html, body {width: 100%;height: 100%;}
    .column-content-detail {padding-top: 15px!important;}
</style>
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/admin/news')}}"><i
                    class="layui-icon">&#x1002;</i></div>
    </div>
    <input type="hidden" value="{{$dto->getSystemVersion()}}" name="system_version">
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{$dto->getTitle() }}" name="title"
               placeholder="请输入关键字" autocomplete="off" class="layui-input">

    </div>
    <div class="layui-inline">
        <select name="source" lay-filter="source" lay-verify="source">
            <option value="0">请选择新闻来源</option>
            <option value="1" {{ $dto->getSource() =='1'? 'selected' : '' }}>企业新闻</option>
            <option value="2" {{ $dto->getSource() =='2' ? 'selected' : '' }}>媒体新闻</option>
        </select>
    </div>
    <div class="layui-inline">
        <select name="check_state" lay-filter="type" lay-verify="type">
            <option value="0">请选择审核状态</option>
            <option value="3" {{ $dto->getCheckState() ==3? 'selected' : '' }}>未提交</option>
            <option value="1" {{ $dto->getCheckState() ==1? 'selected' : '' }}>待审核</option>
            <option value="2" {{$dto->getCheckState() ==2? 'selected' : '' }}>审核通过</option>
            <option value="-1" {{ $dto->getCheckState() ==-1 ? 'selected' : '' }}>审核驳回</option>
        </select>
    </div>
    <div class="layui-inline">
        <select name="send_state" lay-filter="type" lay-verify="type">
            <option value="0">请选择发布状态</option>
            <option value="2" {{ $dto->getSendState() ==2? 'selected' : '' }}>未发布</option>
            <option value="1" {{  $dto->getSendState()  ==1? 'selected' : '' }}>已发布</option>
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
        <a class="layui-btn layui-btn-normal addNewsBtn" data-width="800px" onclick="openNewsAdd()"
           target="_self"
           data-desc="新闻添加"><i
                    class="layui-icon">&#xe654;</i></a>
        <button class="layui-btn layui-btn-normal exportExcel" onclick="exportExcel()" type="button">导出</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob">

        <thead>
        <tr>
            <th>ID</th>
            <th style="min-width: 60px">新闻标题</th>
            <th width="150">封面</th>
            <th style="min-width: 60px">所属工会</th>
            <th style="min-width: 60px">所属企业</th>
            <th style="min-width: 60px">新闻来源</th>
            <th style="min-width: 60px">总浏览量</th>
            <th class="hideTD" style="min-width: 60px">新闻流量</th>
            <th class="hideTD" style="min-width: 60px">虚拟流量</th>
            <th style="min-width: 60px">审核状态</th>
            <th style="min-width: 60px">审核阶段</th>
            <th style="min-width: 60px">审核理由</th>
            {{--            <th>新闻摘要</th>--}}
            <th style="min-width: 60px">发布状态</th>
            <th width="120">发布/撤销时间</th>
            <th style="min-width: 80px">发布/撤销人</th>
            <th class="isShowIndex" width="80">首页显示</th>
            <th id="table_th" width="220">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($listNews as $key=> $list)
            <tr>
                <td>{{$list['id']}}</td>
                <td class="hidden-xs">{{$list['title']}}</td>
                <td class="hidden-xs">
                    <div style="height: 100px;"><img style="width: 100%;height: 100%" src=" {{$list['img_url']}}"/>
                    </div>
                </td>
                <td class="hidden-xs">{{$list['units_name']}}</td>
                <td class="hidden-xs">{{$list['organizations_name']}}</td>

                <td class="hidden-xs">{{$list['source']}}</td>
                <td class="hidden-xs">{{$list['virtual_traffic']+$list['browse_count']}}</td>
                <td class="hideTD">{{$list['browse_count']}}</td>
                <td class="hideTD">{{$list['virtual_traffic']}}</td>
                <td style="display: none" id="virtual_traffic">{{$list['virtual_traffic']}}</td>
                <td class="hidden-xs">
                    {{--                    //企业阶段 未审核--}}

                    @if(($list['check_state']=='0' ))
                        未提交
                        {{--                        基层阶段 未审核--}}
                    @elseif ($list['check_state']=='1' )
                        待审核
                    @elseif($list['check_state']=='2')
                        审核通过
                    @elseif($list['check_state']=='-1')
                        总工会驳回
                    @elseif($list['check_state']=='-2')
                        技术部驳回
                    @elseif($list['check_state']=='-3')
                        活动方驳回
                    @elseif($list['check_state']=='-4')
                        基层工会驳回
                    @endif
                </td>
                <td class="hidden-xs">
                    @if($list['check_stage']=='0')
                        企业阶段
                    @elseif($list['check_stage']=='1')
                        基础工会阶段
                    @elseif($list['check_stage']=='2')
                        活动方阶段
                    @elseif($list['check_stage']=='3')
                        市总经济技术部
                    @elseif($list['check_stage']=='4')
                        总工会阶段
                    @endif
                </td>
                <td class="hidden-xs">{{$list['reason_rejection']}}</td>
                <td class="hidden-xs">
                    @if($list['send_state']=='0')
                        未发布
                    @elseif($list['send_state']=='1')
                        已发布
                    @endif
                </td>
                <td class="hidden-xs">{{$list['send_time']}}</td>
                <td class="hidden-xs">{{$list['send_user']}}</td>
                <td class="isShowIndex">
                    @if($list['isShowHome']=='1')
                        <i style="cursor:pointer;"
                           onclick="showHome('{{$list['id']}}','{{$list['check_state']}}','{{$list['isShowHome']}}')"
                           class="layui-icon">&#xe643;</i>
                    @else
                        <i style="cursor:pointer;"
                           onclick="showHome('{{$list['id']}}','{{$list['check_state']}}','{{$list['isShowHome']}}')"
                           class="layui-icon">&#xe63f;</i>
                    @endif
                </td>
                <td class="hidden-xs">
                    <!-- 普通按钮统一用蓝色 -->
                    <button class="layui-btn layui-btn-small layui-btn-blue editNewsBtn"
                        onclick="openNewsEdit('{{$list["id"]}}','{{$list['send_state']}}','{{$list['check_state']}}')">
                        <i class="layui-icon">&#xe642;</i>编辑
                    </button>
                    <button class="layui-btn layui-btn-small layui-btn-blue sendBtn "
                        onclick="sendNews('{{$list['id']}}','{{$list['check_state']}}')">
                        <i class="layui-icon">&#xe609;</i>报送
                    </button>
                    <button class="layui-btn layui-btn-small layui-btn-blue checkBtn"
                        onclick="checkNews('{{$list['id']}}','{{$list['check_state']}}','{{$list['check_stage']}}','{{$list['send_state']}}')">
                        <i class="layui-icon">&#xe616;</i>审核
                    </button>
                    <button  class="layui-btn layui-btn-small layui-btn-blue releaseBtn"
                            onclick="sendFun('{{$list['id']}}','{{$list['check_state']}}',1,'{{$list['send_state']}}')"
                            data-desc=""><i
                                class="layui-icon">&#xe62f;</i>发布
                    </button>
                    <button class="layui-btn layui-btn-small layui-btn-blue revokeBtn"
                            onclick="sendFun('{{$list['id']}}','{{$list['check_state']}}',0,'{{$list['send_state']}}')"
                            data-desc=""><i
                                class="layui-icon">&#xe603;</i>撤销
                    </button>

                    <button class="layui-btn layui-btn-small layui-btn-blue" 
                        onclick="openDetail('{{$list['id']}}')">
                        <i class="layui-icon">&#xe60a;</i>详情
                    </button>
                    <button class="layui-btn layui-btn-small layui-btn-blue virtualBtn"
                        onclick="setVirtual('{{$list['id']}}','{{$list['virtual_traffic']}}')">
                        <i class="layui-icon">&#xe642;</i>编辑虚拟流量
                    </button>
                    <!-- 删除按钮统一用红色 -->
                    <button class="layui-btn layui-btn-small layui-btn-danger delBtn"
                        onclick="delNews('{{$list['id']}}','{{$list['check_state']}}')">
                        <i class="layui-icon">&#xe640;</i>删除
                    </button>

                    {{--                    <button class="layui-btn layui-btn-small  layui-btn-normal delBtn"--}}
                    {{--                            onclick="showHome('{{$list['id']}}','{{$list['check_state']}}')"--}}
                    {{--                            data-desc=""><i--}}
                    {{--                                class="layui-icon">&#xe604;</i> 推送首页--}}
                    {{--                    </button>--}}
                </td>
            </tr>
        @endforeach
        @if(empty($listNews))
            <tr>
                <td colspan="11" style="text-align: center;color: #ff4500;">暂无数据</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{ $listNews->appends(['system_version'=>$dto->getSystemVersion(),
                                   'title'=>$dto->getTitle() ,
                                   'source'=>$dto->getSource(),
                                   'check_state'=>$dto->getCheckState(),
                                   'send_state'=>$dto->getSendState()
                                   ])->render() }}
    </div>
@endsection
@section('js')
    <script>
        //获取当前操作版本 cqzgh 网络竞技的新闻 by 巴渝新闻 js 重点竞赛新闻
        // let system_version = location.search.split('?')[1].split('=')[1];
        let system_version = '{{$dto->getSystemVersion()}}';
        // window.onpageshow = function (event) {
        //     if (event.persisted || window.performance && window.performance.navigation.type == 2) {
        //         $('.fresh').click();
        //     }
        // }
        //导出
        function exportExcel() {
            var title = $('input[name="title"]').val();
            var source = $('select[name="source"]').val();
            var check_state = $('select[name="check_state"]').val();
            var send_state = $('select[name="send_state"]').val();
            window.location.href = '/admin/news?exportExcel=1&title=' + title + '&source=' + source + '&check_state=' + check_state + '&send_state=' + send_state + '&system_version=' + system_version;
        }

        //角色类型
        var role = '{{$admininfo['role_slug']}}';

        //添加虚拟流量
        function setVirtual(id, virtual) {

            layer.prompt({title: '请输入虚拟流量', value: virtual || 0}, function (value, index, elem) {
                let reg = /^[0-9]{1,10}$/;
                if (!reg.test(value)) {
                    layer.msg('请录入最大长度为10的数字。');
                    return false;
                }
                $.ajax({
                    url: "{{url('/admin/news/setvirtual')}}",
                    data: {id: id, virtual_traffic: value, _token: '{{csrf_token()}}'},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                        layer.close(index);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });

            });
        }

        //打开新增窗口
        function openNewsAdd() {
            window.location.href = '/admin/news/0?system_version=' + system_version;
        }

        function openNewsEdit(id, send_state, check_state) {
            if (send_state == 1) {
                layer.msg('已发布的新闻不允许编辑。');
                return false;
            } else if (check_state > 0) {
                layer.msg('只能修改未提交的新闻。');
                return false;
            }
            window.location.href = '/admin/news/' + id + '?system_version=' + system_version;
        }

        //根据不同角色 设置可操作btn
        function setBtnCss() {
            var hideBtn = [];
            if (role == 'union' || role == 'technology') {//公会
                hideBtn = ['.virtualBtn', '.sendBtn', '.releaseBtn', '.revokeBtn', '.isShowIndex', '.addNewsBtn', '.editNewsBtn', '.delBtn'];
            } else if (role == 'enterprise') {//企业
                hideBtn = ['.virtualBtn', '.releaseBtn', '.revokeBtn', '.checkBtn', '.isShowIndex'];
            } else if (role == 'adminunion') {//总工会会员
                hideBtn = ['.virtualBtn', '.sendBtn', '.addNewsBtn', '.editNewsBtn', '.delBtn'];
            } else if (role == 'administrator') {
                hideBtn = ['.releaseBtn', '.revokeBtn', '.isShowIndex'];
            }
            for (var i in hideBtn) {

                $(hideBtn[i]).css('display', 'none');
            }
        }

        if (role != 'administrator') {
            $(".hideTD").css('display', 'none')
        }

        setBtnCss();

        //打开详情页
        function openDetail(id) {
            window.location.href = "/admin/news/detail/" + id;
        }

        //发布 撤销 state 数据状态 type 0 撤销 1 发布  sendState 当前数据发布状态
        function sendFun(id, state, type, sendState) {
            if (state != 2) {
                layer.msg('请选择审核通过的数据操作');
                return;
            }
            var title = type == 0 ? '撤销' : '发布';
            if (sendState == type) {
                layer.msg('该数据已经是' + (type == 0 ? '未发布' : '已发布') + '状态');
                return;
            }

            layer.confirm('确定要' + title + '吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/news/releasenews')}}",
                    data: {id: id, type: type, _token: '{{csrf_token()}}'},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });

        }

        //删除
        function delNews(id, state) {
            if (state > 0) {
                layer.msg('只能操作未提交的数据');
                return false;
            }
            layer.confirm('确定删除吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/news/destroy')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });
        }

        //推送首页
        function showHome(id, state, showHome) {
            let title = "推送首页显示"
            if (showHome == 1) {
                title = "撤销首页显示";
            }
            if (state != 2) {
                layer.msg('请选择审核通过的数据操作');
                return false;
            }
            layer.confirm('确认' + title + '吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/news/showHome')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });
        }

        //报送
        function sendNews(id, state) {
            if (state > 0) {
                layer.msg('只能操作未提交的数据');
                return false;
            }

            let newStage = 1;
            //巴渝新闻直接推送到总工会
            if (system_version == 'by' || system_version == 'js')
                newStage = 4;
            //活动方添加的网络新闻直接报送给技术部审核
            if (role == 'administrator' && system_version == 'cqzgh') {
                newStage = 3;
            }
            layer.confirm('确定报送吗?', {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    url: "{{url('/admin/news/sendnews')}}",
                    data: {id: id, check_stage: newStage, _token: '{{csrf_token()}}'},
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 1000) {
                            layer.msg(res.msg, {icon: 6});
                            $('.fresh').click();
                        } else {
                            layer.msg(res.msg, {shift: 6, icon: 5});
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                layer.close(index);
            });
        }

        //报送 id 状态 审核阶段 2 网络评选 send_state 发布状态
        function checkNews(id, state, stage, send_state) {
            if (send_state == 1) {
                layer.msg('该新闻已发布，无需审核。');
                return false;
            }

            if (role == "administrator" && state == 0) {
                layer.msg('请报送新闻');
                return false;

            }
            //总工会操作
            if (role == 'adminunion') {
                if (stage != 4) {
                    layer.msg('请选择总工会阶段的数据操作');
                    return false;
                }
            } else if (role == 'technology') {
                if (stage != 3) {
                    layer.msg('请选择市总经济技术部阶段的数据操作');
                    return false;
                }
            } else if (role == 'administrator') {
                if (stage != 2) {
                    layer.msg('请选择活动方阶段的数据操作');
                    return false;
                }
            } else if (role == 'union') {
                if (stage != 1) {
                    layer.msg('请选择基层工会阶段的数据操作');
                    return false;
                }
            }

            //let btn = ['驳回', '通过', '推送总工会'];
            // let btn = ['驳回', '通过', '推送总工会'];

            let btn = ['通过', '驳回'];

            //总工会审核
            if (stage == 4)
                btn = ['通过', '驳回', '通过并发布'];
            lay_open('审核', btn, function (v, index) {

                v = getCheckMsg(v);

                //巴渝工匠 竞赛新闻 只要活动方 和 市总审核
                if (system_version == 'by' || system_version == 'js') {
                    check(id, 1, v, stage);
                } else {
                    check(id, 1, v, stage);
                }
            }, function (v) {
                if (!v) {
                    layer.msg('请录入驳回理由');
                    return false;
                }
                v = getCheckMsg(v);

                check(id, 2, v, stage);
                layer.closeAll();
            }, function (v) {
                v = getCheckMsg(v);
                //通过并发布
                check(id, 1, v, 4, 1);
            })
        }

        //拼接审核理由
        function getCheckMsg(v) {
            if (!v) return v;
            if (role == 'administrator') {
                return '活动方：' + v;
            } else if (role == 'union') {
                return '基层工会：' + v;
            } else if (role == 'adminunion') {
                return '总工会：' + v;
            } else if (role == 'technology') {
                return '技术部：' + v;
            }
        }

        //type 审核状态 1 同意 2 驳回  val 驳回说明 stage 审核阶段 是否发布
        //parmer 审核通过的时候 1 代表审核通过并发布
        function check(id, type, val, stage, parmer) {
            var checkState = 1;
            var checkStage = 0;
            var sendState = 0;
            if (type == 1) {
                //基层公会阶段
                if (stage == 1) {
                    checkStage = 2;
                } else if (stage == 2) {
                    checkStage = 3;
                } else if (stage == 3) {
                    checkStage = 4;
                } else if (stage == 4) {
                    checkState = 2;
                    if (parmer == 1) {//审核通过并发布
                        sendState = 1;
                    }
                    checkStage = 4;
                }
            } else {//驳回
                if (system_version == 'cqzgh') {

                    if (stage == 4) {
                        checkState = -1;
                        checkStage = 3;
                    } else if (stage == 3) {
                        checkState = -2;
                        checkStage = 2;
                    } else if (stage == 2) {
                        checkState = -3;
                        checkStage = 1;
                    } else if (stage == 1) {
                        checkState = -4;
                        checkStage = 0;
                    }
                } else {
                    //由于审核流程没有 技术部 所以 总工会驳回直接返回到活动方阶段 巴渝新闻 和 竞赛新闻
                    if (stage == 4) {
                        checkState = -1;
                        checkStage = 2;
                    }
                }
            }

            $.ajax({
                url: "{{url('/admin/news/checknews')}}",
                data: {
                    id: id,
                    check_state: checkState,
                    check_stage: checkStage,
                    checkType: type,
                    PassVal: val,
                    sendState: sendState, _token: '{{csrf_token()}}'
                },
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 1000) {
                        layer.msg(res.msg, {icon: 6});
                        $('.fresh').click();
                    } else {
                        layer.msg(res.msg, {shift: 6, icon: 5});
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络失败', {time: 1000});
                }
            });
        }


        layui.use(['form', 'jquery', 'laydate', 'layer', 'dialog'], function () {
            var form = layui.form(),
                $ = layui.jquery,
                dialog = layui.dialog,
                layer = layui.layer
            ;
            form.render();
            var laydate = layui.laydate
            var dateOptions = {elem: '#begin', festival: true, istoday: true};
            laydate.render(dateOptions)
            // laydate({istoday: true});
            $('.fresh').mouseenter(function () {
                dialog.tips('刷新页面', '.fresh');
            })
            form.verify({
                title: function (value) {

                },
                status: function (value) {

                },
            });
            $('.fresh').click(function () {

                $('form').submit();
            });
            $('.tips-info').mouseenter(function () {
                var msg = $(this).attr('data-info');
                dialog.tips(msg, this);
            })
        });
    </script>
@endsection
@extends('common.list')