@extends('common.list')
@section('title', '专家列表')
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
@section('header')
    <div class="layui-inline">
        <a class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" href="{{url('/admin/judges')}}"><i class="layui-icon">&#x1002;</i></a>
    </div>
    <div class="layui-inline">
        <input type="text" value="{{$checkJudges->getName()}}" name="name" placeholder="请输专家名" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="kind" class="layui-input">
            <option value="">选择专家类型</option>
            <option value="1" @if($checkJudges->getKind()==1) selected @endif>专家</option>
            <option value="2" @if($checkJudges->getKind()==2) selected @endif>劳模</option>
            <option value="3" @if($checkJudges->getKind()==3) selected @endif>媒体</option>
            <option value="4" @if($checkJudges->getKind()==4) selected @endif>巴渝工匠</option>
        </select>
    </div>
    <div class="layui-inline" class="layui-input">
        <select name="industry">
            <option value="">选择行业类型</option>
            @foreach($industry as $item)
                <option value="{{$item->id}}" @if($item->id==$checkJudges->getIndustry()) selected @endif>{{$item->industry_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
    <div class="layui-inline addproduct-div" style="position: relative">
        @if($userrole==6)
            <a href="/admin/judges/store" target="_self" class="layui-btn layui-btn-normal" >添加专家</a>
        @endif
        <a href="/admin/judges/recommend" target="_self" class="layui-btn layui-btn-normal" >推荐专家</a>
        <a href="/admin/judges/expore" target="_self" class="layui-btn layui-btn-normal" id="expore" >导出</a>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-skin="nob" id="app">
        <colgroup>

        </colgroup>
        <thead>
        <tr>
            @if($userrole==5)
            <th>审核操作<br/><input type="checkbox" id="allselect" lay-filter="allselect"></th>
            @endif
            <th>序号</th>
            <th>专家姓名</th>
            <th>专家头像</th>
            <th>专家类型</th>
            <th>所属行业</th>
            <th>审核状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Judgeses as $item)
            <tr>
                @if($userrole==5)
                <td>
                    @if($item['check_state']==0)
                        <input class="onedata" type="checkbox" @if($item['check_state']===1)checked @endif value="{{$item['id']}}" lay-filter="oneselect">
                        @endif
                </td>
                @endif
                <td>{{$item['id']}}</td>
                <td>{{$item['name']}}</td>
                <td>
                    <img src="{{$item['photo']}}" alt="" height="100" width="100">
                </td>
                <td>
                    @if($item['kind']==1)
                        专家
                    @endif
                    @if($item['kind']==2)
                        劳模
                    @endif
                    @if($item['kind']==3)
                        媒体
                    @endif
                </td>
                <td>
                    @if($item->Industry)
                    {{$item->Industry['industry_name']}}
                    @endif
                </td>
                <td>
                    @if($item['check_state']==0)
                        未审核
                    @elseif($item['check_state']==1)
                        审核通过
                    @else
                        审核驳回
                    @endif
                </td>
                <td>
                    @if($userrole==6)
                    <a href="/admin/honorjudges/list?JudgesId={{$item['id']}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe624;</i>添加专家荣誉
                    </a>
                    @endif
                    <a href="/admin/judges/show?id={{$item['id']}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe615;</i>查看
                    </a>
                    <a href="/admin/judges/update?id={{$item['id']}}" class="layui-btn layui-btn-small layui-btn-blue">
                        <i class="layui-icon">&#xe642;</i>修改
                    </a>
                    <button class="layui-btn layui-btn-small layui-btn-danger" onclick="deleteProduct('{{$item['id']}}')">
                        <i class="layui-icon">&#xe640;</i>删除
                    </button>
                    @if($userrole==5&&$item['check_state']==0)
                    <button class="layui-btn layui-btn-small layui-btn-blue" onclick="nopass('{{$item['id']}}')">
                        <i class="layui-icon">&#x1006;</i>驳回
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
        @if(empty($Judgeses))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$Judgeses->appends([
            'name'=>$checkJudges->getName(),
            'kind'=>$checkJudges->getKind(),
            'industry'=>$checkJudges->getIndustry(),
        ])->render()}}
    </div>
@endsection
@section('js')
    <script src="/static/admin/layui/lay/modules/layer.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var form;

        $(function(){
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

            // $("#allselect").change(function () {
            //     var thisdata = $(".onedata");
            //     for(var i=0;i<thisdata.length;i++){
            //         var aaa = thisdata[i];
            //     }
            // });
            //
            // $(".onedata").change(function () {
            //     var id = this.attributes["value"].value ;
            // });
            
        });

        function sendupdate(id,check_state,type){
            $.ajax({
                url:"/admin/judges/update",
                data:{
                    id:id,
                    check_state:check_state,
                    sendtype:type,
                    _token:'{{csrf_token()}}'
                },
                type:'post',
                dataType:'json',
                success:(res) => {
                    if(res.code==1000)
                        window.location.reload();
                    else
                        layer.msg(res.msg);
                }
            })
        }
        layui.use('form', function(){
            form = layui.form();
            form.on('checkbox(allselect)', function(data){
               var alldata = $(".onedata");
               var indexstr="";
               for (var i=0;i<alldata.length;i++){
                   indexstr+= alldata[i].attributes["value"].value+"," ;
               }
                indexstr=indexstr.substr(0,indexstr.length-1);
                var check_state= data.elem.checked?1:0;
                sendupdate(indexstr,check_state,1);
            });
            form.on('checkbox(oneselect)', function(data){
               var id= data.value;
               var check_state= data.elem.checked?1:0;
                sendupdate(id,check_state,null);
            });
            window.onload=function(){
                var alldata = $(".onedata");
                var flag=true;
                for (var i=0;i<alldata.length;i++){
                    if(!alldata[i].checked) {
                        flag=false;
                        break;
                    }
                }

                $("#allselect")[0].checked= flag;
                form.render();
            }
        });

        function deleteProduct(id){
            layui.use('jquery',()=>{
                var $ = layui.jquery;
                if(confirm("确定删除吗")){
                    $.ajax({
                        url:"/admin/judges/destroy",
                        data:{
                            id:id,
                            _token:'{{csrf_token()}}'
                        },
                        type:'post',
                        dataType:'json',
                        success:(res) => {
                            window.location.reload()
                        }
                    })
                }
            });
        }

        function nopass(id){
            layer.open({
                type: 2,
                title: '',
                shadeClose: true,
                shade: false,
                maxmin: true, //开启最大化最小化按钮
                area: ['893px', '600px'],
                content: "/admin/judges/update?id="+id+"&editType=1",
                cancel: function(){
                    window.location.reload();
                }

            });
        }

    </script>
@endsection





