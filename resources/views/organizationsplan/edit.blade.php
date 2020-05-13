@section('title', '方案编辑')
@extends('common.common')
@section("content")
<link rel="stylesheet" href="/static/upload/xUploader.css">
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
    </div>
    @if(empty($editType))
    <form class="layui-form tc-container mT0" action="/admin/organizationsplan/update" method="post">
    <input type="hidden" value="{{!empty($OrganizationsPlans['id']) ? $OrganizationsPlans['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">

    <input type="hidden" value="{{!empty($OrganizationsPlans['organization_id']) ? $OrganizationsPlans['organization_id'] : ''}}" name="organization_id"  autocomplete="off" class="layui-input">

     <input type="hidden" value="{{$OrganizationsPlans->organization->unit_id}}" name="unit_id"  autocomplete="off" class="layui-input">
        
      <div class="layui-form-item">
        <label class="layui-form-label">企业名：</label>
        <div class="layui-input-block">
            <input type="text" value="{{!empty($OrganizationsPlans->organization->name) ? $OrganizationsPlans->organization->name : ''}}"  readonly autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案名称：</label>
        <div class="layui-input-block">
            <input type="text" maxlength="45" value="{{!empty($OrganizationsPlans['plan_name']) ? $OrganizationsPlans['plan_name'] : ''}}" name="plan_name" lay-verify="required" placeholder="请输入方案名称(最多45个字符)" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">方案主题：</label>
        <div class="layui-input-block">
            <select name="planTheme" lay-filter="planTheme">
                <option value="0">请选择方案主题</option>
                <option value="1" @if($OrganizationsPlans['plan_theme']===1)selected="" @endif>节能减排</option>
                <option value="2" @if($OrganizationsPlans['plan_theme']===2)selected="" @endif>灾害防治</option>
                <option value="3" @if($OrganizationsPlans['plan_theme']===3)selected="" @endif>安全生产</option>
                <option value="4" @if($OrganizationsPlans['plan_theme']===4)selected="" @endif>脱贫攻坚</option>
                <option value="5" @if($OrganizationsPlans['plan_theme']===5)selected="" @endif>安全生产</option>
                <option value="6" @if($OrganizationsPlans['plan_theme']===6)selected="" @endif>其他</option>
            </select>
        </div>
    </div>

    <div style="display: @if($OrganizationsPlans['plan_theme']>=1) block" @else none" @endif id="theme_info">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">方案主题介绍：</label>
            <div class="layui-input-block">
                <textarea maxlength="191" placeholder="方案主题介绍(最多191个字符)" name="themeInfo" class="layui-textarea">{{$OrganizationsPlans['theme_info']}}</textarea>
            </div>
        </div>
    </div>
        
    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案概述：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案概述(最多500个字符)" lay-verify="required" name="summary" class="layui-textarea">{{!empty($OrganizationsPlans['summary']) ? $OrganizationsPlans['summary'] : ''}}</textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案内容：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案内容(最多500个字符)" lay-verify="required" name="content" class="layui-textarea">{{!empty($OrganizationsPlans['content']) ? $OrganizationsPlans['content'] : ''}}</textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>方案目标：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入方案目标(最多500个字符)" lay-verify="required" name="target_task" class="layui-textarea">{{!empty($OrganizationsPlans['target_task']) ? $OrganizationsPlans['target_task'] : ''}}</textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>绩效目标：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入绩效目标(最多500个字符)" lay-verify="required" name="achievement_target" class="layui-textarea">{{!empty($OrganizationsPlans['achievement_target']) ? $OrganizationsPlans['achievement_target'] : ''}}</textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>实施措施：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入实施措施(最多500个字符)" lay-verify="required" name="measures" class="layui-textarea">{{!empty($OrganizationsPlans['measures']) ? $OrganizationsPlans['measures'] : ''}}</textarea>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span style="color:red;position: relative;top: 3px;">* </span>表彰奖励：</label>
        <div class="layui-input-block">
            <textarea maxlength="500" placeholder="请输入表彰奖励(最多500个字符)" lay-verify="required" name="commend" class="layui-textarea">{{!empty($OrganizationsPlans['commend']) ? $OrganizationsPlans['commend'] : ''}}</textarea>
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
        <label class="layui-form-label">参赛员工：</label>
        <div class="layui-input-block">
            <input type="text"  maxlength="1000" value="{{!empty($OrganizationsPlans['staffs_info']) ? $OrganizationsPlans['staffs_info'] : ''}}" name="staffs_info" required lay-verify="staffs_info" placeholder="请输入参赛员工(最多1000个字符)" autocomplete="off" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">项目等级：</label>
        <div class="layui-input-block">
            <input type="radio" name="grade" title="非重点" value="0" @if($OrganizationsPlans['grade']===0)checked @endif  />
            <input type="radio" name="grade" title="市重点" value="1" @if($OrganizationsPlans['grade']===1)checked @endif  />
            <input type="radio" name="grade" title="国家重点" value="2" @if($OrganizationsPlans['grade']===2)checked @endif  />
        </div>
    </div>

        @if($userrole>=5)
    <div class="layui-form-item">
        <label class="layui-form-label">审核：</label>
        <div class="layui-input-block">
            <input type="radio" name="check_state" title="未推送基层工会" value="-6" @if($OrganizationsPlans['check_state']==-6)checked @endif  />
            <input type="radio" name="check_state" title="基层工会未审核" value="0" @if($OrganizationsPlans['check_state']==0)checked @endif  />
            <input type="radio" name="check_state" title="基层工会审核通过" value="1" @if($OrganizationsPlans['check_state']==1)checked @endif  />
            <input type="radio" name="check_state" title="基层工会审核驳回" value="-1" @if($OrganizationsPlans['check_state']==-1)checked @endif  />
            <input type="radio" name="check_state" title="活动方通未审核" value="2" @if($OrganizationsPlans['check_state']==2)checked @endif  />
            <input type="radio" name="check_state" title="活动方通过" value="3" @if($OrganizationsPlans['check_state']==3)checked @endif  />
            <input type="radio" name="check_state" title="活动房驳回" value="-3" @if($OrganizationsPlans['check_state']==-3)checked @endif  />
            <input type="radio" name="check_state" title="总工会未审核" value="4" @if($OrganizationsPlans['check_state']==4)checked @endif  />
            <input type="radio" name="check_state" title="总工会审核" value="5" @if($OrganizationsPlans['check_state']==5)checked @endif  />
            <input type="radio" name="check_state" title="总工会驳回" value="-5" @if($OrganizationsPlans['check_state']==-5)checked @endif  />
        </div>
    </div>
          @endif
        @if($userrole>0)
        <div class="layui-form-item">
            <label class="layui-form-label">虚拟浏览量：</label>
            <div class="layui-input-block">
                <input type="number" min = 0 onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" oninput="if(value.length>11)value=value.slice(0,11)" value="{{!empty($OrganizationsPlans['fictitious_browse_count']) ? $OrganizationsPlans['fictitious_browse_count'] : ''}}" name="fictitious_browse_count" required lay-verify="fictitious_browse_count" placeholder="请输入虚拟浏览量(最多11位数)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">虚拟点赞数：</label>
            <div class="layui-input-block">
                <input type="number" min = 0 oninput="if(value.length>11)value=value.slice(0,11)" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" value="{{!empty($OrganizationsPlans['fictitious_star_count']) ? $OrganizationsPlans['fictitious_star_count'] : ''}}" name="fictitious_star_count" required lay-verify="fictitious_star_count" placeholder="请输入虚拟点赞数(最多11位数)" autocomplete="off" class="layui-input">
            </div>

        </div>

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">点赞数：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="number" oninput="if(value.length>11)value=value.slice(0,11)" value="{{!empty($OrganizationsPlans['star_count']) ? $OrganizationsPlans['star_count'] : ''}}" name="star_count" required lay-verify="star_count" placeholder="请输入浏览量(最多11位数)" autocomplete="off" class="layui-input">--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">浏览数：</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="number" oninput="if(value.length>11)value=value.slice(0,11)" value="{{!empty($OrganizationsPlans['browse_count']) ? $OrganizationsPlans['browse_count'] : ''}}" name="browse_count" required lay-verify="browse_count" placeholder="请输入点赞数(最多11位数)" autocomplete="off" class="layui-input">--}}
{{--            </div>--}}

{{--        </div>--}}
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">农名工数量：</label>
            <div class="layui-input-block">
                <input type="number" min = 0 oninput="if(value.length>11)value=value.slice(0,11)" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" value="{{!empty($OrganizationsPlans['farmer_count']) ? $OrganizationsPlans['farmer_count'] : ''}}" name="farmer_count" required lay-verify="farmer_count" placeholder="请输入农名工数量(最多11位数)" autocomplete="off" class="layui-input">
            </div>

        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">分享标题/PC端页面tile：</label>
            <div class="layui-input-block">
                <input type="text" maxlength="191" value="{{!empty($OrganizationsPlans['share_title']) ? $OrganizationsPlans['share_title'] : ''}}" name="share_title" placeholder="请输入分享标题/PC端页面tile(最多191个字符)" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分享描述：</label>
            <div class="layui-input-block">
                <textarea maxlength="191" placeholder="请输入分享描述(最多191个字符)" name="share_content" class="layui-textarea">{{!empty($OrganizationsPlans['share_content']) ? $OrganizationsPlans['share_content'] : ''}}</textarea>
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

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
    @elseif($editType==1)
    <form>
        <div id="addlayer">
            <input type="hidden" value="{{!empty($OrganizationsPlans['id']) ? $OrganizationsPlans['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">

            <input type="hidden" value="{{!empty($OrganizationsPlans['organization_id']) ? $OrganizationsPlans['organization_id'] : ''}}" name="organization_id"  autocomplete="off" class="layui-input">

            <input type="hidden" value="{{$OrganizationsPlans->organization->unit_id}}" name="unit_id"  autocomplete="off" class="layui-input">

            <input type="hidden" value="{{$editType}}" name="editType"  autocomplete="off" class="layui-input">
            <div style="height: 100px;"></div>
            <div class="layui-form-item">
                <label class="layui-form-label">竞赛绩效（万元）:</label>
                <div class="layui-input-block">
                    <input type="number" oninput="if(value.length>10)value=value.slice(0,10)" value="" name="achievements" required lay-verify="achievements" placeholder="请输入竞赛绩效（万元）(10位数)" autocomplete="off" class="layui-input">
                </div>

            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">竞赛自评:</label>
                <div class="layui-input-block">
                    <textarea maxlength="191" placeholder="请输入竞赛自评(191个字符)" name="achievements_info" class="layui-textarea"></textarea>
                </div>
            </div>

        </div>
        <input type="hidden" name="nopassinfo" value="">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
    @elseif($editType==2)
        <form>
            <input type="hidden" value="{{!empty($OrganizationsPlans['id']) ? $OrganizationsPlans['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">

            <input type="hidden" value="{{!empty($OrganizationsPlans['organization_id']) ? $OrganizationsPlans['organization_id'] : ''}}" name="organization_id"  autocomplete="off" class="layui-input">

            <input type="hidden" value="{{$OrganizationsPlans->organization->unit_id}}" name="unit_id"  autocomplete="off" class="layui-input">

            <div style="width: 100%; height: 200px;"></div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">不通过原因:</label>
                <div class="layui-input-block">
                    <textarea maxlength="11" placeholder="请输入不通过原因" name="nopassinfo" class="layui-textarea"></textarea>
                </div>
            </div>
            <input type="hidden" name="check_state" value="{{$check_state}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </form>
    @endif
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
        abc.successDo('{{$OrganizationsPlans['img_url']}}',true);

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
        abc1.successDo('{{$OrganizationsPlans['share_img_url']}}',true);
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
                    url: "{{url('/admin/organizationsplan/update')}}",
                    data: $('form').serialize(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if(res.code==1000)    {
                            layer.msg('修改成功', {icon: 6},function () {
                                var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            });
                            
                            //self.location=document.referrer;
                            window.location.href="/admin/organizationsplan";
                        }
                        else if(res.code==2000){
                            layer.msg('修改成功,请关闭页面');
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


