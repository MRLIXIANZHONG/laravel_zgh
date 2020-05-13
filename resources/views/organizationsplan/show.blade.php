@section('title', '方案编辑')
@extends('common.common')
@section("content")
<link rel="stylesheet" href="{{ env('APP_URL') }}/static/admin/css/thecustom.css">
<div class="layui-inline add-div" style="position:fixed;right: 20px;top:10px;z-index: 99999 ">
        <a class="layui-btn layui-btn-normal" type="button" href="/admin/organizationsplan" >返回</a>
    </div>
    <form class="layui-form tc-container mT0">
        <div class="layui-form-item" style="display: none;">
            <div class="layui-input-block">
                <input type="hidden" value="{{!empty($OrganizationsPlans['id']) ? $OrganizationsPlans['id'] : ''}}" name="id"  required lay-verify="id"  autocomplete="off">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">企业名：</label>
            <div class="layui-input-block">
                <input type="text" value="{{isset($OrganizationsPlans->organization->name)?$OrganizationsPlans->organization->name:''}}" name="" readonly  autocomplete="off" class="layui-input">
            </div>

        </div>

        <input type="hidden" value="{{!empty($OrganizationsPlans['organization_id']) ? $OrganizationsPlans['organization_id'] : 0}}" name="organization_id" readonly required lay-verify="organization_id"  autocomplete="off" class="layui-input">

        <div class="layui-form-item">
            <label class="layui-form-label">方案名称：</label>
            <div class="layui-input-block">
                <input type="text" value="{{!empty($OrganizationsPlans['plan_name']) ? $OrganizationsPlans['plan_name'] : ''}}" name="plan_name" readonly required lay-verify="plan_name"  autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案主题：</label>
            <div class="layui-input-block">
                @if($OrganizationsPlans['plan_theme']==1)
                    <input type="text" value="节能减排" name="" readonly  autocomplete="off" class="layui-input">
                @endif
                @if($OrganizationsPlans['plan_theme']==2)
                        <input type="text" value="灾害防治" name="" readonly  autocomplete="off" class="layui-input">
                @endif
                @if($OrganizationsPlans['plan_theme']==3)
                        <input type="text" value="安全生产" name="" readonly  autocomplete="off" class="layui-input">
                @endif
                @if($OrganizationsPlans['plan_theme']==4)
                    <input type="text" value="脱贫攻坚" name="" readonly  autocomplete="off" class="layui-input">
                @endif
                @if($OrganizationsPlans['plan_theme']==5)
                        <input type="text" value="安全生产" name="" readonly  autocomplete="off" class="layui-input">
                @endif
                @if($OrganizationsPlans['plan_theme']==6)
                        <input type="text" value="其他" name="" readonly  autocomplete="off" class="layui-input">
                @endif
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案概述：</label>
            <div class="layui-input-block">
                <textarea name="summary" readonly class="layui-textarea">{{!empty($OrganizationsPlans['summary']) ? $OrganizationsPlans['summary'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案内容：</label>
            <div class="layui-input-block">
                <textarea name="content" readonly class="layui-textarea">{{!empty($OrganizationsPlans['content']) ? $OrganizationsPlans['content'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案目标：</label>
            <div class="layui-input-block">
                <textarea name="target_task" readonly class="layui-textarea">{{!empty($OrganizationsPlans['target_task']) ? $OrganizationsPlans['target_task'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">绩效目标：</label>
            <div class="layui-input-block">
                <textarea name="achievement_target" readonly class="layui-textarea">{{!empty($OrganizationsPlans['achievement_target']) ? $OrganizationsPlans['achievement_target'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">实施措施：</label>
            <div class="layui-input-block">
                <textarea name="measures" readonly class="layui-textarea">{{!empty($OrganizationsPlans['measures']) ? $OrganizationsPlans['measures'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">表彰奖励：</label>
            <div class="layui-input-block">
                <textarea name="commend" readonly class="layui-textarea">{{!empty($OrganizationsPlans['commend']) ? $OrganizationsPlans['commend'] : ''}}</textarea>
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">方案图片地址：</label>
            <div class="layui-input-block">
                <img width="100px" height="100px" src=" {{$OrganizationsPlans['img_url']}}" alt="">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">参赛员工：</label>
            <div class="layui-input-block">
                <input type="text" readonly value="{{!empty($OrganizationsPlans['staffs_info']) ? $OrganizationsPlans['staffs_info'] : ''}}" name="staffs_info" required lay-verify="staffs_info" placeholder="请输入参赛员工" autocomplete="off" class="layui-input">
            </div>

        </div>
        

        <div class="layui-form-item">
            <label class="layui-form-label">项目等级：</label>
            <div class="layui-input-block">
                @if($OrganizationsPlans['grade']===0)非重点@endif
                @if($OrganizationsPlans['grade']===1)市重点@endif
                @if($OrganizationsPlans['grade']===2)国家重点@endif
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">点赞数：</label>
            <div class="layui-input-block">
                <input type="number" readonly value="{{!empty($OrganizationsPlans['star_count']) ? $OrganizationsPlans['star_count'] : ''}}" name="star_count" required lay-verify="star_count" placeholder="请输入点赞数" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">浏览数：</label>
            <div class="layui-input-block">
                <input type="number" readonly value="{{!empty($OrganizationsPlans['browse_count']) ? $OrganizationsPlans['browse_count'] : ''}}" name="browse_count" required lay-verify="browse_count" placeholder="请输入浏览数" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分享标题/PC端页面tile：</label>
            <div class="layui-input-block">
                <input type="text" readonly value="{{!empty($OrganizationsPlans['share_title']) ? $OrganizationsPlans['share_title'] : ''}}" name="share_title" required lay-verify="share_title" placeholder="请输入分享标题/PC端页面tile" autocomplete="off" class="layui-input">
            </div>

        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分享描述:</label>
            <div class="layui-input-block">
                <textarea readonly name="share_content" class="layui-textarea">{{!empty($OrganizationsPlans['share_content']) ? $OrganizationsPlans['share_content'] : ''}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">农名工数量：</label>
            <div class="layui-input-block">
                <input readonly type="number" value="{{!empty($OrganizationsPlans['farmer_count']) ? $OrganizationsPlans['farmer_count'] : ''}}" name="farmer_count"  class="layui-input">
            </div>

        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分享图片地址：</label>
            <div class="layui-input-block">
                <img width="100px" height="100px" src=" {{$OrganizationsPlans['share_img_url']}}" alt="">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分享描述：</label>
            <div class="layui-input-block">
                <textarea readonly placeholder="请输入分享描述" name="sharecontent"  class="layui-textarea">{{$OrganizationsPlans['share_content']}}</textarea>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分享标题/PC端页面tile：</label>
            <div class="layui-input-block">
                <textarea readonly placeholder="请输入分享标题/PC端页面tile" name="sharetitle" class="layui-textarea">{{$OrganizationsPlans['share_title']}}</textarea>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">驳回原因：</label>
            <div class="layui-input-block">
                <textarea readonly name="share_content" readonly class="layui-textarea">{{!empty($OrganizationsPlans['nopassinfo']) ? $OrganizationsPlans['nopassinfo'] : ''}}</textarea>
            </div>

        </div>
    </form>
@endsection



