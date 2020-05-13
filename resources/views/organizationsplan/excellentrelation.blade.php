@extends('common.list')
@section('title', '方案活动关联')
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
</style>
@section('header')
    <div class="layui-inline">
        <a class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" href="javascript:location.reload()"><i class="layui-icon">&#x1002;</i></a>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$checkOrganizationsPlan->getPlanName()}}" name="plan_name" placeholder="请输方案名" autocomplete="off" class="layui-input">
    </div>

    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a href="/admin/organizationsplan" class="layui-btn layui-btn-normal">返回</a>
    </div>
@endsection
@section('table')

    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <thead>
        <tr>
            <th>方案名</th>
            <th>活动选择</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($OrganizationsPlans as $item)
            <tr>
                <td class="showtips">{{$item['plan_name']}}</td>
                <td>
                    <select name="" id="OrganizationsPlans{{$item['id']}}">
                            <option value="">请选择活动</option>
                        @foreach($caseSchemes as $item1)
                            <option value="{{$item1['id']}}" test="{{$item['case_scheme_id']}}" @if($item['case_scheme_id']==$item1['id']) selected="" @endif>{{$item1['title']}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    @if(!empty($item['case_scheme_id']))
                        <a href="#" target="_self" class="layui-btn layui-btn-normal updaterelation"  value="{{$item['id']}}">修改关联</a>
                    @else
                        <a href="#" target="_self" class="layui-btn layui-btn-normal addrelation" value="{{$item['id']}}">添加关联</a>
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
             'plan_name'=>$checkOrganizationsPlan->getPlanName()
            ])->render()}}
    </div>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(".updaterelation").click(function () {
          var id = this.attributes["value"].value ;
            var case_scheme_id = $('#OrganizationsPlans'+id).val();
            $.ajax({
                url: "{{url('/admin/organizationsplan/excellentrelation')}}",
                data: {
                    id :id,
                    caseSchemeId: case_scheme_id,
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                dataType: 'json',
                success: (res) => {
                    if (res.code == 1000) {
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络请求失败', {time: 1000});
                }
            })
        })
        $(".addrelation").click(function () {
            var id = this.attributes["value"].value ;
            var case_scheme_id = $('#OrganizationsPlans'+id).val();
            $.ajax({
                url: "{{url('/admin/organizationsplan/excellentrelation')}}" ,
                data: {
                    id :id,
                    caseSchemeId: case_scheme_id,
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                dataType: 'json',
                success: (res) => {
                    if (res.code == 1000) {
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络请求失败', {time: 1000});
                }
            })
        })
    </script>
@endsection





