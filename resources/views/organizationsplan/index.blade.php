@extends('common.list')
@section('title', '方案列表')
<script src="/static/admin/js/clipboard.min.js" type="text/javascript" charset="utf-8"></script>
<style>
    .editbtnblue{
        color:#01AAED;
    }
    .addproduct-ul{
        width: 100%;
        height: 50px;
        text-align: center;
        position: absolute;
        display: none;
    }
    .addproduct-li{
        /*border: 1px solid #cccccc;*/
        height:30px;
        line-height: 30px;
        background-color:#1E9FFF;
        color:white;
        white-space: nowrap;
        text-align: center;
        font-size: 14px;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        opacity: .9;
        border-top:1px solid white;
    }
    .skill{
        width: 200px;
        height:100px;
        overflow: hidden;
        display: block;
    }
    .column-content-detail {padding-top: 15px!important;}
</style>
@section('header')
    <div class="layui-inline">
        <a class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" href="{{url('/admin/organizationsplan')}}"><i class="layui-icon">&#x1002;</i></a>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$checkOrganizationsPlan->getPlanName()}}" name="plan_name" placeholder="请输方案名" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="check_state"  lay-filter="check_state">
            <option  value="">选择状态</option>
            <option @if($checkOrganizationsPlan->getCheckState()==-6) selected @endif value="-6">企业未推送</option>
            <option @if(!is_null($checkOrganizationsPlan->getCheckState())&&$checkOrganizationsPlan->getCheckState()==0) selected @endif value="0">基层工会未审核</option>
            <option @if($checkOrganizationsPlan->getCheckState()==1) selected @endif value="1">基层工会审核通过</option>
            <option @if($checkOrganizationsPlan->getCheckState()==-1) selected @endif value="-1">基层工会审核驳回</option>
            <option @if($checkOrganizationsPlan->getCheckState()==4) selected @endif value="4">总工会未审核</option>
            <option @if($checkOrganizationsPlan->getCheckState()==5) selected @endif value="5">总工会审核</option>
            <option @if($checkOrganizationsPlan->getCheckState()==-5) selected @endif value="-5">总工会驳回</option>
            <option  value="">选择状态</option>
        </select>
    </div>
    <div class="layui-inline">
        <select name="order" id="order" lay-filter="order">
            <option value="1">序号升序</option>
            <option value="2" @if($order==2) selected @endif>序号降序</option>
        </select>
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>

    <div class="layui-inline addproduct-div" style="position: relative">
        @if($userrole==0)
        <a href="/admin/organizationsplan/store" target="_self" class="layui-btn layui-btn-normal" >添加方案</a>
        <a href="/admin/organizationsplan/excellentrelation" target="_self" class="layui-btn layui-btn-normal" >方案关联活动</a>
        <a href="/admin/leaders" target="_self" class="layui-btn layui-btn-normal" >方案领导列表</a>
        @endif
        
        @if($userrole==6)
        <a href="/admin/organizationsplan/excellentselection" target="_self" class="layui-btn layui-btn-normal" >优秀方案</a>

        <a href="/admin/organizationsplan/storerecommend" target="_self" class="layui-btn layui-btn-normal" >推荐方案</a>
        <a href="/admin/organizationsplan/expore" target="_self" class="layui-btn layui-btn-normal" >导出</a>
        @endif

    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
        <thead>
        <tr>
            <th style="min-width: 30px">序号</th>
            <th style="min-width: 60px">方案名称</th>
            <th style="min-width: 60px">方案类型</th>
            <th style="min-width: 60px">所属企业</th>
            <th style="min-width: 60px">企业类型</th>
            <th style="min-width: 100px">所属行业</th>
            <th style="min-width: 60px">所属工会</th>
            <th style="min-width: 45px">浏览量</th>
            <th style="min-width: 45px">点赞量</th>
            <th style="min-width: 80px">企业联系人</th>
            <th style="min-width: 80px">联系人电话</th>
            <th style="min-width: 100px">状态</th>
            <th style="min-width: 140px">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($OrganizationsPlans as $item)
            <tr>
                <td>{{$item['id']}}</td>
                <td class="showtips">{{$item['plan_name']}}</td>
                <td>
                    @if($item['grade']==1)
                        市重点
                    @elseif($item['grade']==2)
                        国家重点
                    @else
                        非重点
                    @endif

                </td>
                <td class="showtips">{{$item->Organization->name}}</td>
                <td>
                    @if($item->Organization->new_type==1)
                        国营控股企业
                    @elseif($item->Organization->new_type==2)
                        行政机关
                    @elseif($item->Organization->new_type==3)
                       港澳台、外商投资企业
                    @elseif($item->Organization->new_type==4)
                        民营控股企业
                    @elseif($item->Organization->new_type==5)
                        事业单位
                    @else
                        其他
                    @endif
                </td>
                <td class="skill">
                    @if(!empty($industry[$item->organization_id]))
                        {{rtrim($industry[$item->organization_id],',')}}
                    @endif
                </td>
                <td>{{$item->Organization->unit->name}}</td>
                <td>{{$item['star_count']}}</td>
                <td>{{$item['browse_count']}}</td>
                <td>{{$item->Organization->username}}</td>
                <td class="showtips">{{$item->Organization->mobile}}</td>
                <td>
                    @if($item['check_state']==-6) 未推送基层工会  @endif
                    @if($item['check_state']==0) 基层工会未审核  @endif
                    @if($item['check_state']==1) 基层工会已审核通过  @endif
                    @if($item['check_state']==-1) 基层工会审核驳回  @endif
                    @if($item['check_state']==2) 活动方通未审核  @endif
                    @if($item['check_state']==3) 活动方通过  @endif
                    @if($item['check_state']==-3) 活动房驳回  @endif
                    @if($item['check_state']==4) 总工会未审核  @endif
                    @if($item['check_state']==5) 总工会已审核通过  @endif
                    @if($item['check_state']==-5) 总工会审核驳回  @endif
                </td>
                <td>
                    <a href="/admin/organizationsplan/show?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe615;</i>详情</a>
                    @if($userrole==1)
                        @if($item['check_state']==0)
                            <a href="#" class="layui-btn layui-btn-small layui-btn-blue pass" value="{{$item->id}}"><i class="layui-icon">&#xe605;</i>通过</a>
                            <a href="#" class="layui-btn layui-btn-small layui-btn-blue notpass" value="{{$item->id}}"><i class="layui-icon">&#x1006;</i>不通过</a>
                            <a href="/admin/organizationsplan/update?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe642;</i>编辑</a>
                         @elseif($item['check_state']==1)
                            <a href="#" class="layui-btn layui-btn-small layui-btn-blue tomaster" value="{{$item->id}}" check_state="4"><i class="layui-icon">&#xe609;</i>推送</a>
                        @endif
                    @elseif($userrole==5)
                        @if($item['check_state']==4)
                            <a href="#" class="layui-btn layui-btn-small layui-btn-blue pass" value="{{$item['id']}}"><i class="layui-icon">&#xe605;</i>通过</a>
                            <a href="#" class="layui-btn layui-btn-small layui-btn-blue notpass" value="{{$item['id']}}"><i class="layui-icon">&#x1006;</i>不通过</a>
                        @endif
                    @elseif($userrole==6)
                        <a href="/admin/organizationsplan/update?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe642;</i>编辑</a>
                        <a href="#" class="layui-btn layui-btn-small layui-btn-danger" onclick="deleteProduct('{{$item['id']}}')"><i class="layui-icon">&#xe640;</i>删除</a>
                    @else
                        @if($item['check_state']==-6||$item['check_state']==-5||$item['check_state']==-1)
                        <a href="/admin/organizationsplan/storeleaders?id={{$item['id']}}&organizationid={{$item['organization_id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe624;</i>添加方案领导</a>
                        <a href="/admin/segments?organizationplanid={{$item['id']}}&organizationid={{$item['organization_id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe624;</i>添加方案活动</a>
                        <a href="/admin/organizationsplan/update?id={{$item['id']}}" target="_self" class="layui-btn layui-btn-small layui-btn-blue"><i class="layui-icon">&#xe642;</i>编辑</a>
                        <a href="#" class="layui-btn layui-btn-small layui-btn-danger" onclick="deleteProduct('{{$item['id']}}')"><i class="layui-icon">&#xe640;</i>删除</a>
                            @if($item['check_state']==-6)
                                <a href="#" class="layui-btn layui-btn-small layui-btn-blue tomaster" value="{{$item['id']}}" check_state="0"><i class="layui-icon">&#xe609;</i>推送基层工会</a>
                            @elseif($item['check_state']==-1)
                                <a href="#" class="layui-btn layui-btn-small layui-btn-blue tomaster" value="{{$item['id']}}" check_state="0"><i class="layui-icon">&#xe609;</i>推送基层工会</a>
                            @elseif($item['check_state']==-5)
                                <a href="#" class="layui-btn layui-btn-small layui-btn-blue tomaster" value="{{$item['id']}}" check_state="4"><i class="layui-icon">&#xe609;</i>推送总工会</a>
                            @endif
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        @if(empty($OrganizationsPlans))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$OrganizationsPlans->appends([
             'plan_name'=>$checkOrganizationsPlan->getPlanName(),
             'check_state'=>$checkOrganizationsPlan->getCheckState()
            ])->render()}}
    </div>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function(){

            function updatestate(id,check_state){
                $.ajax({
                    url: "{{url('/admin/organizationsplan/changecheckstate')}}" ,
                    data: {
                        id :id,
                        check_state_:check_state,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: (res) => {
                        if (res.code == 1000) {
                            window.location.reload();
                        } else {
                            layer.msg(res.message);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络请求失败', {time: 1000});
                    }
                })
            }

            layui.use('form', function() {
                var form = layui.form();
                form.on('select(order)', function (data) {
                  var data =  data.value;
                    window.location.href="/admin/organizationsplan?order="+data;
                });
            });
                
            $(".pass").click(function () {
                var id = this.attributes["value"].value ;
                updatestate(id,{{$userrole}});
            });

            $(".notpass").click(function () {
                var id = this.attributes["value"].value ;
                var state={{'-'.$userrole}};
                layer.open({
                    type: 2,
                    title: '',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['893px', '600px'],
                    content: "/admin/organizationsplan/update?id="+id+"&editType=2&check_state="+ state,
                    cancel: function(){
                        window.location.reload();
                    }

                });

               // updatestate(id,{{'-'.$userrole}})
            });

            $(".tomaster").click(function () {
                if(confirm("确定推送吗")){
                    var id = this.attributes["value"].value ;
                    var check_state = this.attributes["check_state"].value ;
                    updatestate(id,check_state)
                }
            })
            var tips;
            $(".showtips").on({
                mouseenter:function(){
                    var that = this;
                    tips =layer.tips(this.innerText,that,{area: 'auto',maxWidth: '700'});
                    //tips = layer.tips("智能组卷：每个用户考试时抽到的试题及顺序随机组成", that, {tips: 1});
                },
                mouseleave:function(){
                    layer.close(tips);
                }
            });
            function deleteProduct(id)
            {
                layui.use('jquery', () => {
                    var $ = layui.jquery;
                    if (confirm("确定删除吗")) {
                        $.ajax({
                            url: "/admin/organizationsplan/destroy",
                            data: {
                                id: id,
                                _token: '{{csrf_token()}}'
                            },
                            type: 'post',
                            dataType: 'json',
                            success: (res) => {
                                if (res.code == 1000)
                                    window.location.reload()
                                else
                                    layer.msg(res.msg);
                            }
                        })
                    }
                });
            }
        });
        function deleteProduct(id)
        {
            layui.use('jquery', () => {
                var $ = layui.jquery;
                if (confirm("确定删除吗")) {
                    $.ajax({
                        url: "/admin/organizationsplan/destroy",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        type: 'post',
                        dataType: 'json',
                        success: (res) => {
                            if (res.code == 1000)
                                window.location.reload()
                            else
                                layer.msg(res.msg);
                        }
                    })
                }
            });
        }
    </script>
@endsection





