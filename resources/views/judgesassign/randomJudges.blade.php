@extends('common.common')
@section('title', '专家抽取')
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
</style>
<div class="layui-inline" style="line-height: 38px;padding-left: 15px;">专家（最大 <span id="judesmax"></span>）：</div>
<div class="layui-inline">
    <input class="layui-input" type="number" id="judesCountTxt" name="judesCount" lay-verify="title" autocomplete="off" placeholder="请输入专家数" value="0">
</div>
<div class="layui-inline" style="line-height: 38px;">备选专家（最大 <span id="bakjudesmax"></span>）： </div>
<div class="layui-inline">
    <input class="layui-input" type="number" id="bakjudesCountTxt" name="bakjudesCount" lay-verify="title" autocomplete="off" placeholder="请输入备选专家数" value="0">
</div>
<div class="layui-inline addproduct-div">
    <a target="_self" class="layui-btn layui-btn-normal" id="addjudgesassign" >随机添加专家</a>
    <a target="_self" href="/admin/judgesassign/addjudgesassign?id={{$judgesassign["id"]}}" class="layui-btn layui-btn-normal">手动添加专家</a>
    <span id="tipstr" style="color: red;"></span>
    <a target="_self" class="layui-btn layui-btn-normal" id="changejudges">提交</a>
</div>
<div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
    <a href="./index" class="layui-btn layui-btn-normal">返回</a>
</div>
@section('content')
    <div style="width: 100%;font-size:18px; font-weight: bolder;color: #333;padding-left: 15px">随机专家列</div>
    <table class="layui-table layui-form" lay-even lay-skin="nob" id="app1">
        <colgroup>
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="100">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th>序号</th>
            <th>专家名称</th>
            <th>专家类型</th>
            <th>所属行业</th>
            <th>指派确认状态 <br/><input type="checkbox" lay-skin="primary" title="全选/取消" lay-filter="alljudges" id="alljudges"></th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($judges as $k=> $item)
            <tr>
                <td>{{$k+1}}</td>
                <td>{{$item->name}}</td>
                <td>
                    @if($item->kind==1)
                        专家
                    @elseif($item->kind==2)
                        劳模
                    @else
                        媒体
                    @endif
                </td>
                <td>{{$item->industryName}}</td>
                <td>
                    <input class="judges" type="checkbox" @if($item->state===1)checked @endif value="{{$item->id}}" name="state" lay-skin="switch">
                </td>
                <td>
                    <a target="_self" class="layui-btn layui-btn-normal deletejudges" value="{{$item->id}}">
                        <i class="layui-icon">&#xe640;</i>删除
                    </a>
                </td>
            </tr>
        @endforeach
        @if(empty($judges))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>

    <div style="width: 100%; font-size:18px; font-weight: bolder;color: #333;padding-left: 15px">随机备选专家列</div>

    <table class="layui-table layui-form" lay-even lay-skin="nob" id="app2">
        <colgroup>
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="100">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th>序号</th>
            <th>专家名称</th>
            <th>专家类型</th>
            <th>所属行业</th>
            <th>指派确认状态 <br/><input type="checkbox" lay-skin="primary" title="全选/取消" lay-filter="allbakjudges" id="allbakjudges"></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($bakjudges as $k=> $item)
            <tr>
                <td>{{$k+1}}</td>
                <td>{{$item->name}}</td>
                <td>
                    @if($item->kind==1)
                        专家
                    @elseif($item->kind==2)
                        劳模
                    @else
                        媒体
                    @endif
                </td>
                <td>{{$item->industryName}}</td>
                <td>
                    <input class="bakjudges" type="checkbox" @if($item->state===1)checked @endif value="{{$item->id}}" name="state" lay-skin="switch">
                </td>
                <td>
                    <a target="_self" class="layui-btn layui-btn-normal deletejudges"  value="{{$item->id}}">
                        <i class="layui-icon">&#xe640;</i>删除
                    </a>
                </td>
            </tr>
        @endforeach
        @if(empty($judges))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var rondompage={
            onload :function () {
                var bakjudges = $(".bakjudges");
                var judges= $(".judges");
                rondompage.pagejudesCount=judges.length;
                rondompage.pagebakjudesCount=bakjudges.length;
                var flag=true;
                for(var i=0;i<judges.length;i++) {
                    if(!judges[i].checked)
                    {
                        flag=false;
                        break;
                    }
                }

                if(flag)  {
                    var alljudges =$("#alljudges");
                    alljudges[0].checked=true;
                }

                flag=true;
                for(var i=0;i<bakjudges.length;i++) {
                    if(!bakjudges[i].checked)
                    {
                        flag=false;
                        break;
                    }
                }
                if(flag)  {
                    var allbakjudges =$("#allbakjudges");
                    allbakjudges[0].checked=true;
                }
                $("#judesmax").text(rondompage.judesCount-rondompage.pagejudesCount);
                $("#bakjudesmax").text(rondompage.bakjudesCount-rondompage.pagebakjudesCount);
            },
            judesCount:{{$judgesassign["judesCount"]}},
            bakjudesCount:{{$judgesassign["bakjudesCount"]}},
            pagejudesCount:0,
            pagebakjudesCount:0,
            form:null
        };
        $(".deletejudges").click(function(){
            var deleteid = this.attributes["value"].value;
            
            $.ajax({
                url: "{{url('/admin/judgesassign/destroyjudgejudgesassign')}}",
                data: {deleteid:deleteid,_token:"{{csrf_token()}}"},
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000)
                        layer.msg('修改成功',function () {
                            window.location.reload()
                        });
                    else
                        layer.msg(res.msg);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        });
        $("#addjudgesassign").click(function(){

               var judesCount = Number($("#judesCountTxt").val());
               var bakjudesCount= Number($("#bakjudesCountTxt").val());
               if(judesCount+rondompage.pagejudesCount>rondompage.judesCount){
                   $("#tipstr").text("专家数超过");
                   return;
               }
               if(bakjudesCount+rondompage.pagebakjudesCount>rondompage.bakjudesCount) {
                   $("#tipstr").text("备选专家数超过");
                   return;
               }
            $.ajax({
                url: "{{url('/admin/judgesassign/dorandom')}}",
                data: {"id":"{{$judgesassign["id"]}}","judesCount":judesCount,"bakjudesCount":bakjudesCount,_token:"{{csrf_token()}}"},
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000){
                        layer.msg('修改成功',function () {
                            window.location.reload();
                        });
                    }
                    else{
                       alert(res.msg);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        });

        $("#changejudges").click(function(){
            var bakjudges = $(".bakjudges");
            var judges= $(".judges");

            var confirmIndexStr="";
            var notconfirmIndexStr="";

            for(var i=0;i<bakjudges.length;i++) {
                if(bakjudges[i].checked)
                    confirmIndexStr+=bakjudges[i].value+",";
                else
                    notconfirmIndexStr+=bakjudges[i].value+",";
            }

            for(var i=0;i<judges.length;i++) {
                if(judges[i].checked)
                    confirmIndexStr+=judges[i].value+",";
                else
                    notconfirmIndexStr+=judges[i].value+",";
            }

            confirmIndexStr = confirmIndexStr.substr(0, confirmIndexStr.length - 1);
            notconfirmIndexStr = notconfirmIndexStr.substr(0, notconfirmIndexStr.length - 1);
            $.ajax({
                url:"/admin/judgesassign/randomjudges",
                data:{
                    confirmIndexStr:confirmIndexStr,
                    notconfirmIndexStr:notconfirmIndexStr,
                    id:{{$judgesassign["id"]}},
                    _token:'{{csrf_token()}}'
                },
                type:'post',
                dataType:'json',
                success:(res) => {
                    window.location.reload()
                }
            });
        });

        layui.use('form', function(){
            rondompage.form = layui.form();
            rondompage.form.on('checkbox(alljudges)', function(data){
                var judges= $(".judges");
               for(var i=0;i<judges.length;i++) {
                   judges[i].checked= data.elem.checked;
               }
                rondompage.form.render('checkbox');
            });

            rondompage.form.on('checkbox(allbakjudges)', function(data){
                var bakjudges = $(".bakjudges");
                for(var i=0;i<bakjudges.length;i++) {
                    bakjudges[i].checked= data.elem.checked;
                }
                rondompage.form.render('checkbox');
            });
        });

        window.onload= rondompage.onload();
    </script>
@endsection





