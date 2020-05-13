@section('title', '方案创建')
<link rel="stylesheet" href="/static/upload/xUploader.css">
@extends('common.common')
@section("content")
    <div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
    </div>
    <form class="layui-form" action="/admin/organizationsplan/store" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">企业名：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$organization['name']}}" Readonly='true' class="layui-input">
        </div>
    </div>

        <input type="hidden" value="{{$organization['unit_id']}}" name="unit_id"  autocomplete="off" class="layui-input">

        <input type="hidden" value="{{$organization['id']}}" name="organization_Id"  autocomplete="off" class="layui-input">


{{--    <div class="layui-form-item">--}}
{{--        <label class="layui-form-label">企业名:</label>--}}
{{--        <div class="layui-input-block">--}}
{{--            <select name="organization_Id" lay-filter="aihao">--}}
{{--                  @foreach($organization as $item)--}}
{{--                    <option value="{{$item['id']}}">{{$item['name']}}</option>--}}
{{--                  @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="layui-form-item">
        <label class="layui-form-label">方案名称：</label>
        <div class="layui-input-block">
            <input type="text" maxlength="45" value="" name="planName" lay-verify="required" placeholder="请输入方案名称(45个字符)" autocomplete="off" class="layui-input">
        </div>
    </div>
        
    <div class="layui-form-item">
        <label class="layui-form-label">方案主题:</label>
        <div class="layui-input-block">
            <select name="planTheme" lay-filter="planTheme">
                <option value="0">请选择方案主题</option>
                <option value="1">节能减排</option>
                <option value="2">灾害防治</option>
                <option value="3">安全生产</option>
                <option value="4">脱贫攻坚</option>
                <option value="5">安全生产</option>
                <option value="6">其他</option>
            </select>
        </div>
    </div>

     <div style="display: none" id="theme_info">
         <div class="layui-form-item layui-form-text">
             <label class="layui-form-label">方案主题介绍</label>
             <div class="layui-input-block">
                 <textarea maxlength="191" placeholder="方案主题介绍(最多191个字符)" name="themeInfo" class="layui-textarea"></textarea>
             </div>
         </div>
     </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案概述：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案概述(最多500个字符)" name="summary" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案内容：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案内容(最多500个字符)" name="content" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案目标：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案目标(最多500个字符)" name="targetTask" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>绩效目标：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入绩效目标(最多500个字符)" name="achievementTarget" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>实施措施：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入实施措施(最多500个字符)" name="measures" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>表彰奖励：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入表彰奖励(最多500个字符)" name="commend" class="layui-textarea" lay-verify="required"></textarea>
        </div>

    </div>

        <!--图片上传-->
        <div class="layui-form-item">
            <label class="layui-form-label">添加方案封面：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix ">
                    <img class="imgBox l imgBox2" width="100px" height="100px" data-prompt-position="bottomLeft:130,-80">
                    <div id="adBtn" class="adBtn l"></div>
                </div>
                <input type="hidden" name="img_url" id="titval1" class="hide-val"  data-sum="0" />
                <p style="color:#999"></p>
                <div style="height:50px"></div>
                <div class="progress" style="display:none">
                    <span class="text">0%</span>
                    <span class="percentage" style="width:0%;"></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分享标题/PC端页面tile：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="191" value="" name="share_title" placeholder="请输入分享标题/PC端页面tile(最多191个字符)" autocomplete="off" class="layui-input">
            </div>

        </div>
        
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分享描述:</label>
            <div class="layui-input-block">
                <textarea maxlength="191" placeholder="请输入分享描述(最多191个字符)" name="share_content" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">添加分享封面：</label>
            <div class="layui-input-block">
                <div class="img-box clearfix">
                    <img class="imgBox l imgBox1" width="100px" height="100px" data-prompt-position="bottomLeft:130,-80">
                    <div id="adBtn1" class="adBtn1 l"></div>
                </div>
                <input type="hidden" name="share_img_url" id="titval2" class="hide-val"  data-sum="0" />
                <p style="color:#999"> </p>
                <div class="progress1" style="display:none">
                    <span class="text1">0%</span>
                    <span class="percentage1" style="width:0%;"></span>
                </div>
            </div>
        </div>

    <div class="layui-form-item">
        <label class="layui-form-label">参赛员工：</label>
        <div class="layui-input-block">
            <input type="text" maxlength="1000" value="" name="staffs_info" placeholder="请输入参赛员工(最多1000个字符)" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">项目等级：</label>
        <div class="layui-input-block">
            <input type="radio" name="grade" title="非重点" value="0" />
            <input type="radio" name="grade" title="市重点" value="1" />
            <input type="radio" name="grade" title="国家重点" value="2" />
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">农名工数量：</label>
        <div class="layui-input-block">
            <input type="number" oninput="if(value.length>11)value=value.slice(0,11)" min="0" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" value="" name="farmer_count" placeholder="请输入农名工数量(最多11位数)" autocomplete="off" class="layui-input">
        </div>

    </div>

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
        </div>
    </div>

    </form>
@endsection
@section("js")
    <script type="text/javascript" src="http://r.imgccoo.cn/website/js/webuploader/webuploader.js"></script>
    <script src="{{env('APP_URL')}}/static/upload/upload.js"></script>
<script>
    var abc = new xUploader({
        btn: '#adBtn',
        progressElement: '.progress',
        progressElement1: '.progress .text',
        progressElement2: '.progress .percentage',
        valueElement: '#titval1',
        imgElement: '.imgBox2',
        upType: 'type1',
        imgLenth: '.imgBox .loading',
        maxLen: 1,
        singleSizeLimit: '5mb',
        server: "/admin/news/upload?_token={{csrf_token()}}&folder=organizationsplanImg"
    });

    var abc1 = new xUploader({
        btn: '#adBtn1',
        progressElement: '.progress1',
        progressElement1: '.progress1 .text1',
        progressElement2: '.progress1 .percentage1',
        valueElement: '#titval2',
        imgElement: '.imgBox1',
        upType: 'type1',
        imgLenth: '.imgBox1 .loading1',
        maxLen: 1,
        singleSizeLimit: '5mb',
        server: "/admin/news/upload?_token={{csrf_token()}}&folder=organizationsplanImg"
    });

    $(document).on('click', '.del-pics', function () {
        var url = $(this).closest('.loading').find('img').attr('src');
        abc.delFile(this, url);
        abc1.delFile(this, url);
        $.ajax({
            url: "{{url('/admin/news/delFile')}}",
            data: {'url': url,'_token':"{{csrf_token()}}"},
            type: 'POST',
            dataType: 'json',
            success: function (res) {

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    })

    layui.use(['form'], function () {
        var form = layui.form();
        form.render();
        form.on('select(planTheme)',function (data) {
             if(data.value==0)
                 $("#theme_info").css({"display":"none"});
             else
                 $("#theme_info").css({"display":"block"});

        });
        form.on('submit(formDemo)', function (data) {
            this.disabled=true;
            $.ajax({
                url: "{{url('admin/organizationsplan/store')}}",
                data: $('form').serialize(),
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if(res.code==1000)    {
                        layer.msg('添加成功', {icon: 6},function () {
                            var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                        });

                        window.location.href="/admin/organizationsplan";
                    }
                    else
                        layer.msg('修改失败');
                    this.disabled=false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    this.disabled=false;
                }
            });
            return false;
        });
    });
</script>
@endsection("js")


