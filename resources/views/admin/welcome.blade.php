<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>网站后台管理系统</title>
    <link rel="stylesheet" type="text/css"
          href="{{$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']}}/static/admin/layui/css/layui.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']}}/static/admin/css/admin.css"/>
</head>
<style type="text/css">
    .home-title {
        margin: 20px 10px;
        display: flex;
        align-items: center;
    }

    .home-title img {
        width: 22px;
        height: 20px;
        object-fit: cover;
        margin-right: 8px;
    }

    .home-title span {
        font-size: 20px;
        color: #333;
    }

    .data-statistics-list {
        height: 288px;
        padding: 10px;
    }

    .data-statistics-list .plate {
        width: 100%;
        height: 100%;
        box-shadow: 0px 2px 20px rgba(226, 226, 226, 0.5);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .good-personal-data {
        background: linear-gradient(135deg, rgba(255, 175, 139, 1) 0%, rgba(247, 82, 106, 1) 100%);
    }

    .good-fivesmall-data {
        background: linear-gradient(135deg, rgba(163, 173, 254, 1) 0%, rgba(140, 100, 239, 1) 100%);
    }

    .views-data {
        background: linear-gradient(314deg, rgba(9, 225, 180, 1) 0%, rgba(137, 215, 239, 1) 100%);
    }

    .good-plan-data {
        background: linear-gradient(135deg, rgba(130, 219, 255, 1) 0%, rgba(34, 134, 252, 1) 100%);
    }

    .news-data {
        background: linear-gradient(135deg, rgba(255, 213, 132, 1) 0%, rgba(255, 163, 37, 1) 100%);
    }

    .click-like-data {
        background: linear-gradient(135deg, rgba(254, 162, 185, 1) 0%, rgba(237, 61, 130, 1) 100%);
    }

    .data-statistics-list .plate-title {
        font-size: 20px;
        font-weight: bold;
        color: #FFF;
    }

    .data-statistics-list .plate-content {
        width: 100%;
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
    }

    .content-list {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .content-list img {
        width: 44px;
        height: 44px;
    }

    .content-list .label {
        font-size: 16px;
        color: #FFF;
        margin-top: 20px;
    }

    .content-list .val {
        font-size: 20px;
        color: #FFF;
        margin-top: 20px;
    }

    .enterprise-manage-list {
        height: 144px;
        padding: 10px;
    }

    .enterprise-manage-list .plate {
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 1);
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        /*justify-content: center;*/
    }

    .enterprise-manage-list .plate img {
        object-fit: cover;
        margin-right: 40px;
        margin-left: 56px;
    }

    .enterprise-manage-list .plate span {
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .chart-list {
        height: 470px;
        padding: 10px;
    }

    .chart-content {
        width: 100%;
        height: 100%;
        padding-top: 10px;
        background: rgba(255, 255, 255, 1);
        box-shadow: 0px 2px 20px rgba(226, 226, 226, 0.8);
        border-radius: 10px;
    }

    .chart-content .layui-form {
        width: 140px;
        height: 40px;
        float: right;
        margin-right: 20px;
    }

    .chart-content .chart {
        width: 100%;
        height: 400px;
        margin-top: 40px;
    }

    .enterprise {
        display: none;
    }

    .union {
        display: none;
    }

    .adminunion {
        display: none;
    }
</style>
<body>
<div class="wrap-container welcome-container">
    <div class="row">
        <div class="home-data-statistics col-lg-12">
            <div class="home-title col-lg-12">
                <img src="{{ env('APP_URL') }}/static/UploadFile/index/title_icon1.png" alt="">
                <span>数据统计区</span>
            </div>
            <!-- 数据统计板块1 -->
            <div class="home-content col-lg-12 enterprise">
                <div class="data-statistics-list col-lg-5">
                    <div class="plate good-personal-data">
                        <div class="plate-title">优秀个人数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">申报总数</div>
                                <div class="val" id="gr_sb">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">通过总数</div>
                                <div class="val" id="gr_tg">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon3.png" alt="">
                                <div class="label">获奖总数</div>
                                <div class="val" id="gr_hj">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-5">
                    <div class="plate good-fivesmall-data">
                        <div class="plate-title">优秀五小数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">申报总数</div>
                                <div class="val" id="wx_sb">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">通过总数</div>
                                <div class="val" id="wx_tg">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon3.png" alt="">
                                <div class="label">获奖总数</div>
                                <div class="val" id="wx_hj">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate views-data">
                        <div class="plate-title">活动浏览量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon4.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="qy_ll">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-5">
                    <div class="plate good-plan-data">
                        <div class="plate-title">优秀方案数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">申报总数</div>
                                <div class="val" id="fa_sb">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">通过总数</div>
                                <div class="val" id="fa_tg">0</div>
                            </div>
                            {{--                            <div class="content-list">--}}
                            {{--                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">--}}
                            {{--                                <div class="label">获奖总数</div>--}}
                            {{--                                <div class="val"  id="fa_hj">0</div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-5">
                    <div class="plate news-data">
                        <div class="plate-title">新闻提报数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon11.png" alt="">
                                <div class="label">提交总数</div>
                                <div class="val" id="xw_tb">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon5.png" alt="">
                                <div class="label">发布总数</div>
                                <div class="val" id="xw_fb">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">活动点赞量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon6.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="qy_dz">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 数据统计板块2 -->
            <div class="home-content col-lg-12 union">
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">参赛企业总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_qyAll">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-personal-data">
                        <div class="plate-title">优秀个人总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_gr">526552</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-plan-data">
                        <div class="plate-title">优秀方案总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_fn">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-fivesmall-data">
                        <div class="plate-title">优秀五小总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_wx">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate news-data">
                        <div class="plate-title">竞赛新闻总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon11.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_news">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate views-data">
                        <div class="plate-title">活动浏览量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon4.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_ll">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">活动点赞量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon6.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="union_dz">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 数据统计板块3 -->
            <div class="home-content col-lg-12 adminunion">
                <div class="data-statistics-list col-lg-2">
                    <div class="plate news-data">
                        <div class="plate-title">工会总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_union">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">企业总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_qy">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-personal-data">
                        <div class="plate-title">优秀个人总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_gr">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-plan-data">
                        <div class="plate-title">优秀方案总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_fa">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-fivesmall-data">
                        <div class="plate-title">优秀五小总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_wx">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">职工总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_zg">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">农民工总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_nmg">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate news-data">
                        <div class="plate-title">竞赛新闻总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon11.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_news">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">专家总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_zj">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate views-data">
                        <div class="plate-title">活动浏览量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon4.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_ll">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate click-like-data">
                        <div class="plate-title">活动点赞量数据</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon6.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_dz">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="home-title col-lg-12">
                <img src="{{ env('APP_URL') }}/static/UploadFile/index/title_icon2.png" alt="">
                <span>管理区</span>
                {{--                <span class="union">公会管理区</span>--}}
                {{--                <span class="adminunion">管理区</span>--}}
            </div>
            {{--            企业快捷菜单--}}
            <div class="home-content col-lg-12 enterprise">
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="优秀个人列表" data-url='/admin/nominees/index' data-id="999"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>优秀个人</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="五小列表" data-url='/admin/wuxiao/index'
                       data-id="998">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon8.png" alt="">
                            <span>优秀五小</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="方案管理"
                       data-url='/admin/organizationsplan' data-id="997">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon9.png" alt="">
                            <span>优秀方案</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="新闻列表"
                       data-url='/admin/news?system_version=cqzgh' data-id="996">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>新闻管理</span>
                        </div>
                    </a>
                </div>
            </div>

            {{--            公会--}}
            <div class="home-content col-lg-12 union">
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="企业列表" data-url='/admin/organizations' data-id="1000"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>企业管理</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="优秀个人列表" data-url='/admin/nominees/index' data-id="999"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>优秀个人</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="五小列表" data-url='/admin/wuxiao/index'
                       data-id="998">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon8.png" alt="">
                            <span>优秀五小</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="方案管理"
                       data-url='/admin/organizationsplan' data-id="997">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon9.png" alt="">
                            <span>优秀方案</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="新闻列表"
                       data-url='/admin/news?system_version=cqzgh' data-id="996">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>新闻管理</span>
                        </div>
                    </a>
                </div>

                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="优秀个人评审"
                       data-url='/admin/caseschemes/nominee' data-id="995">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>优秀个人评审</span>
                        </div>
                    </a>
                </div>

                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="五小评审"
                       data-url='/admin/caseschemes/wuxiao' data-id="994">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>五小评审</span>
                        </div>
                    </a>
                </div>
            </div>


            {{--            总公会--}}
            <div class="home-content col-lg-12 adminunion">
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="工会列表" data-url='/admin/units' data-id="995"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>工会管理</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="企业列表" data-url='/admin/organizations' data-id="996"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>企业管理</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" data-text="优秀个人列表" data-url='/admin/nominees/index' data-id="999"
                       class="clearfix indexNav">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon7.png" alt="">
                            <span>优秀个人</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="五小列表" data-url='/admin/wuxiao/index'
                       data-id="998">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon8.png" alt="">
                            <span>优秀五小</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="方案管理"
                       data-url='/admin/organizationsplan' data-id="997">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon9.png" alt="">
                            <span>优秀方案</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="新闻列表"
                       data-url='/admin/news?system_version=cqzgh' data-id="996">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>新闻管理</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="专家列表"
                       data-url='/admin/judges' data-id="993">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>专家管理</span>
                        </div>
                    </a>
                </div>
                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="优秀个人评审"
                       data-url='/admin/caseschemes/nominee' data-id="995">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>优秀个人评审</span>
                        </div>
                    </a>
                </div>

                <div class="enterprise-manage-list col-lg-3">
                    <a href="javascript:;" class="clearfix indexNav" data-text="五小评审"
                       data-url='/admin/caseschemes/wuxiao' data-id="994">
                        <div class="plate">
                            <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon10.png" alt="">
                            <span>五小评审</span>
                        </div>
                    </a>
                </div>
            </div>


            <div class="home-title col-lg-12 ">
                <img src="{{ env('APP_URL') }}/static/UploadFile/index/title_icon3.png" alt="">
                <span>业务数据</span>
            </div>
            <div class="home-content col-lg-12 enterprise">
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select dataType="yxgr">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="good-personal-chart"></div>
                    </div>
                </div>
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select  dataType="wuxiao">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="good-fivesmall-chart"></div>
                    </div>
                </div>
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select   dataType="plan">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="good-plan-chart"></div>
                    </div>
                </div>
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select   dataType="news">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="news-chart"></div>
                    </div>
                </div>
            </div>
            <div class="home-content col-lg-12 union">
                <div class="chart-list col-lg-12">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select dataType="union">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="union-chart"></div>
                    </div>
                </div>
            </div>
            <div class="home-content col-lg-12 adminunion">
                <div class="chart-list col-lg-12">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select dataType="adminunion">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="adminunion-chart"></div>
                    </div>
                </div>
            </div>
            <div class="home-title col-lg-12 enterprise">
                <img src="{{ env('APP_URL') }}/static/UploadFile/index/title_icon4.png" alt="">
                <span>活动数据</span>
            </div>
            <div class="home-content col-lg-12 enterprise">
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select  dataType="browse">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="views-chart"></div>
                    </div>
                </div>
                <div class="chart-list col-lg-6">
                    <div class="chart-content">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <select  dataType="star">
                                    <option value="1">近7天</option>
                                    <option value="2">近30天</option>
                                    <option value="3">月</option>
                                </select>
                            </div>
                        </form>
                        <div class="chart" id="click-like-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/admin/js/jquery.min.js?v={{rand(0,9999)}}"></script>

<!-- <script src="{{$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']}}/static/admin/lib/echarts/echarts.js"></script> -->

<script src="{{ env('APP_URL') }}/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/echarts.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/common.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ env('APP_URL') }}/static/admin/js/main.js" type="text/javascript" charset="utf-8"></script>
<script>
    function init_good_personal_chart(sbData, tgData, HjData, date) {
        var option = {
            title: {
                text: '优秀个人数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['申报总数', '通过总数', '获奖总数'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '申报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: sbData
            }, {
                name: '通过总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data: tgData
            }, {
                name: '获奖总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#FFD584'
                },
                data: HjData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('good-personal-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_good_fivesmall_chart(sbData, tgData, HjData, date) {
        var option = {
            title: {
                text: '优秀五小数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['申报总数', '通过总数', '获奖总数'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '申报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: sbData
            }, {
                name: '通过总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data: tgData
            }, {
                name: '获奖总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#FFD584'
                },
                data: HjData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('good-fivesmall-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_good_plan_chart(sbData, tgData, date) {
        var option = {
            title: {
                text: '优秀方案数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['申报总数', '通过总数'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '申报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: sbData
            }, {
                name: '通过总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data: tgData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('good-plan-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_news_chart(sbData, tgData, date) {
        var option = {
            title: {
                text: '新闻提报数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['提报总数', '发布总数'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '提报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data:sbData
            }, {
                name: '发布总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#FFD584'
                },
                data: tgData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('news-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_browse_chart(browseData,date) {
        var option = {
            title: {
                text: '用户浏览数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '申报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: browseData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('views-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_star_chart(starData,date) {
        var option = {
            title: {
                text: '用户点赞数据',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '申报总数',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: starData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('click-like-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_union_chart(qyData, yxgrData, wuxiaoData,planData,newsData,browseData,starData, date) {
        var option = {
            title: {
                text: '数据汇总',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['参赛企业', '优秀个人', '优秀五小', '优秀方案', '新闻','浏览量','点赞量'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '参赛企业',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: qyData
            }, {
                name: '优秀个人',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data: yxgrData
            }, {
                name: '优秀五小',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#FFD584'
                },
                data: wuxiaoData
            }, {
                name: '优秀方案',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#caff95'
                },
                data: planData
            }, {
                name: '新闻',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#35dcff'
                },
                data: newsData
            }, {
                name: '浏览量',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#ffa0cf'
                },
                data: browseData
            }, {
                name: '点赞量',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#ff703b'
                },
                data: starData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('union-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }

    function init_adminunion_chart(qyData, yxgrData, wuxiaoData,planData,newsData,browseData,starData, date) {
        var option = {
            title: {
                text: '数据汇总',
                left: '20',
                top: '20'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                icon: 'circle',
                data: ['参赛企业', '优秀个人', '优秀五小', '优秀方案', '新闻','浏览量','点赞量'],
                top: '20',
                right: '20'
            },
            grid: {
                left: '40',
                right: '40',
                top: '70',
                bottom: '20',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}, //是否显示坐标轴刻度
                    data: date
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLine: {show: false}, //是否显示轴线
                    axisTick: {show: false}  //是否显示坐标轴刻度
                }
            ],
            series: [{
                name: '参赛企业',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#BC0000'
                },
                data: qyData
            }, {
                name: '优秀个人',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#5D6FE8'
                },
                data: yxgrData
            }, {
                name: '优秀五小',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#FFD584'
                },
                data: wuxiaoData
            }, {
                name: '优秀方案',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#caff95'
                },
                data: planData
            }, {
                name: '新闻',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#35dcff'
                },
                data: newsData
            }, {
                name: '浏览量',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#ffa0cf'
                },
                data: browseData
            }, {
                name: '点赞量',
                type: 'line',
                symbol: 'none',
                itemStyle: {
                    color: '#ff703b'
                },
                data: starData
            }]
        };
        // 获取dom容器
        var myChart = echarts.init(document.getElementById('adminunion-chart'));
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        setTimeout(function () {
            window.onresize = function () {
                myChart.resize();
            }
        }, 200);
    }


    layui.use(['layer', 'jquery', 'form'], function () {
        var layer = layui.layer,
            $ = layui.jquery,
            form = layui.form();

        form.on('select', function (data) {
            let type = $(data.elem).attr('dataType');
            let value = data.value;
            if (type == "yxgr") {//加载企业优秀个人
                init_good_personal_data(value);
            } else if (type == "wuxiao") {//加载企业优秀五小
                init_good_fivesmall_data(value);
            }else if (type == "plan") {//加载企业优秀方案
                init_good_plan_data(value);
            }else if (type == "news") {//加载企业新闻
                init_news_data(value);
            }else if (type == "browse") {//加载活动浏览量
                init_browse_data(value);
            }else if (type == "star") {//加载活动点赞
                init_star_data(value);
            }else if (type == "union") {//加载公会信息
                init_union_data(value);
            }else if (type == "adminunion") {//加载公会信息
                init_adminunion_data(value);
            }
        });
    });

    //获取时间 type 1 近7天 2 30天 3 月
    function getDate(type) {
        var data = new Date();
        let beginTime;
        let endTime;
        if (type == 1) {
            let newdate = new Date(data - 7 * 24 * 3600 * 1000);
            beginTime = newdate.getFullYear() + '-' + (newdate.getMonth() + 1) + '-' + newdate.getDate();
            endTime = data.getFullYear() + '-' + (data.getMonth() + 1) + '-' + data.getDate();
        } else if (type == 2) {
            let newdate = new Date(data - 30 * 24 * 3600 * 1000);
            beginTime = newdate.getFullYear() + '-' + (newdate.getMonth() + 1) + '-' + newdate.getDate();
            endTime = data.getFullYear() + '-' + (data.getMonth() + 1) + '-' + data.getDate();
        } else if (type == 3) {
            beginTime = 1;
            endTime = data.getMonth() + 1;
        }

        return [beginTime, endTime];
    }
    //获取优秀个人数据 统计类型type 1 近7天 2 30天 3 月
    function init_good_personal_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'yxgr', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let sbData = [];
                let tgData = [];
                let hjData = [];
                let date = [];
                res.forEach(item => {
                    sbData.push(item.tb);
                    tgData.push(item.tg);
                    hjData.push(item.hj);
                    date.push(item.count_time);

                })
                init_good_personal_chart(sbData, tgData, hjData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取优秀方案数据 统计类型type 1 近7天 2 30天 3 月
    function init_good_fivesmall_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'wuxiao', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let sbData = [];
                let tgData = [];
                let hjData = [];
                let date = [];
                res.forEach(item => {
                    sbData.push(item.tb);
                    tgData.push(item.tg);
                    hjData.push(item.hj);
                    date.push(item.count_time);

                })
                init_good_fivesmall_chart(sbData, tgData, hjData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取优秀五小数据 统计类型type 1 近7天 2 30天 3 月
    function init_good_plan_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'plan', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let sbData = [];
                let tgData = [];
                let date = [];
                res.forEach(item => {
                    sbData.push(item.tb);
                    tgData.push(item.tg);
                    date.push(item.count_time);

                })
                init_good_plan_chart(sbData, tgData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取新闻 统计类型type 1 近7天 2 30天 3 月
    function init_news_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'news', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let sbData = [];
                let tgData = [];
                let date = [];
                res.forEach(item => {
                    sbData.push(item.tb);
                    tgData.push(item.tg);
                    date.push(item.count_time);

                })
                init_news_chart(sbData, tgData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取活动浏览量 统计类型type 1 近7天 2 30天 3 月
    function init_browse_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'browse', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let browseData = [];
                let date = [];
                res.forEach(item => {
                    browseData.push(item.tb);
                    date.push(item.count_time);

                })
                init_browse_chart(browseData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取活动点赞量 统计类型type 1 近7天 2 30天 3 月
    function init_star_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'star', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let starData = [];
                let date = [];
                res.forEach(item => {
                    starData.push(item.tb);
                    date.push(item.count_time);

                })
                init_star_chart(starData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取公会数据 统计类型type 1 近7天 2 30天 3 月
    function init_union_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'union', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let qyData = [];
                let yxgrData = [];
                let wuxiaoData = [];
                let planData = [];
                let newsData = [];
                let browseData = [];
                let starData = [];
                let date = [];
                res.forEach(item => {
                    qyData.push(item.qy);
                    yxgrData.push(item.yxgr);
                    wuxiaoData.push(item.wuxiao);
                    planData.push(item.plan);
                    newsData.push(item.news);
                    browseData.push(item.browse);
                    starData.push(item.star);
                    date.push(item.count_time);

                })
                init_union_chart(qyData, yxgrData, wuxiaoData,planData,newsData,browseData,starData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }
    //获取公会数据 统计类型type 1 近7天 2 30天 3 月
    function init_adminunion_data(type) {
        let d = getDate(type);
        let beginTime = d[0];
        let endTime = d[1];
        $.ajax({
            url: "{{url('/admin/welcome/enterprise')}}",
            data: {beginTime: beginTime, endTime: endTime, dataType: 'adminunion', type: type, _token: '{{csrf_token()}}'},
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let qyData = [];
                let yxgrData = [];
                let wuxiaoData = [];
                let planData = [];
                let newsData = [];
                let browseData = [];
                let starData = [];
                let date = [];
                res.forEach(item => {
                    qyData.push(item.qy);
                    yxgrData.push(item.yxgr);
                    wuxiaoData.push(item.wuxiao);
                    planData.push(item.plan);
                    newsData.push(item.news);
                    browseData.push(item.browse);
                    starData.push(item.star);
                    date.push(item.count_time);

                })
                init_adminunion_chart(qyData, yxgrData, wuxiaoData,planData,newsData,browseData,starData, date);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    }

    $(".indexNav").click(function () {

        var id = $(this).attr('data-id');
        var url = '{{env('')}}' + $(this).attr('data-url');
        var text = $(this).attr('data-text');
        if (!url) {
            return;
        }
        top.element.tabAdd('tab', {
            title: text,
            content: '<iframe src="' + url + '" name="iframe' + id + '" class="iframe" framborder="0" data-id="' + id + '" scrolling="auto" width="100%"  height="100%"></iframe>',
            id: id
        });
        top.element.tabChange('tab', id);
    });
    //角色类型
    var role = '{{$admininfo['role_slug']}}';
    let json = JSON.parse('{!! json_encode($countList) !!}');
    if (role == 'enterprise') {//企业
        init_good_personal_data(1);
        init_good_fivesmall_data(1);
        init_good_plan_data(1);
        init_news_data(1);
        init_browse_data(1);
        init_star_data(1);

        $(".enterprise").css('display', 'block')
        for (let type in json) {
            let jsonItem = json[type];
            if (type == 'nominees') {
                $("#gr_sb").text(jsonItem[0]["num"]);
                $("#gr_tg").text(jsonItem[1]["num"]);
                $("#gr_hj").text(jsonItem[2]["num"]);
            } else if (type == 'wuxiao') {
                $("#wx_sb").text(jsonItem[0]["num"]);
                $("#wx_tg").text(jsonItem[1]["num"]);
                $("#wx_hj").text(jsonItem[2]["num"]);
            } else if (type == 'plan') {
                $("#fn_sb").text(jsonItem[0]["num"]);
                $("#fn_tg").text(jsonItem[1]["num"]);
            } else if (type == 'news') {
                $("#xw_tb").text(jsonItem[0]["num"]);
                $("#xw_fb").text(jsonItem[1]["num"]);
            } else if (type == 'browse') {
                $("#qy_ll").text(jsonItem[0]["num"]);
            } else if (type == 'star') {
                $("#qy_dz").text(jsonItem[0]["num"]);
            }
        }
    } else if (role == 'union') {
        $(".union").css('display', 'block');
        init_union_data(1);
        for (let type in json) {
            let value = json[type][0]["num"];
            if (type == 'org') {
                $("#union_qyAll").text(value);
            } else if (type == 'nominees') {
                $("#union_gr").text(value);

            } else if (type == 'wuxiao') {
                $("#union_wx").text(value);
            } else if (type == 'plan') {
                $("#union_fn").text(value);
            } else if (type == 'news') {
                $("#union_news").text(value);
            } else if (type == 'browse') {
                $("#union_ll").text(value);
            } else if (type == 'star') {
                $("#union_dz").text(value);
            }
        }
    } else if (role == 'administrator' || role == 'adminunion'||  role == 'technology') {
        $(".adminunion").css('display', 'block')
        init_adminunion_data(1);
        for (let type in json) {
            let jsonItem = json[type];
            if (type == 'unit') {
                $("#zgh_union").text(jsonItem[0]["num"]);
            } else if (type == 'org') {
                $("#zgh_qy").text(jsonItem[0]["num"]);
                $("#zgh_zg").text(jsonItem[0]["staff_count"] || 0);
            } else if (type == 'nominees') {
                $("#zgh_gr").text(jsonItem[0]["num"]);
            } else if (type == 'wuxiao') {
                $("#zgh_wx").text(jsonItem[0]["num"]);
            } else if (type == 'plan') {
                $("#zgh_fa").text(jsonItem[0]["num"]);
                $("#zgh_nmg").text(jsonItem[0]["farmer_count"] || 0);
            } else if (type == 'news') {
                $("#zgh_news").text(jsonItem[0]["num"]);
            } else if (type == 'judges') {
                $("#zgh_zj").text(jsonItem[0]["num"]);
            } else if (type == 'browse') {
                $("#zgh_ll").text(jsonItem[0]["num"]);
            } else if (type == 'star') {
                $("#zgh_dz").text(jsonItem[0]["num"]);
            }
        }
    }

</script>
</body>
</html>