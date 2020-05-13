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
            <div class="home-content col-lg-12 union">
                <div class="data-statistics-list col-lg-5">
                    <div class="plate good-personal-data">
                        <div class="plate-title">企业数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">报名企业</div>
                                <div class="val" id="org_bm">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">通过企业</div>
                                <div class="val" id="org_tg">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-5">
                    <div class="plate good-fivesmall-data">
                        <div class="plate-title">工匠数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">申报工匠</div>
                                <div class="val" id="gj_sb">0</div>
                            </div>
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">通过工匠</div>
                                <div class="val" id="gj_tg">0</div>
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
                        <div class="plate-title">工匠总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon2.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_gj">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-statistics-list col-lg-2">
                    <div class="plate good-plan-data">
                        <div class="plate-title">新闻总数</div>
                        <div class="plate-content">
                            <div class="content-list">
                                <img src="{{ env('APP_URL') }}/static/UploadFile/index/list_icon1.png" alt="">
                                <div class="label">总数</div>
                                <div class="val" id="zgh_news">0</div>
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

    //角色类型
    var role = '{{$admininfo['role_slug']}}';
    let json = JSON.parse('{!! json_encode($countList) !!}');
    if (role == 'union') {
        $(".union").css('display', 'block');
        $("#org_bm").text(json.data[0]['num'] || 0);
        $("#org_tg").text(json.data[1]['num'] || 0);
        $("#gj_sb").text(json.data[2]['num'] || 0);
        $("#gj_tg").text(json.data[3]['num'] || 0);
        $("#union_ll").text(json.data[5]['num'] || 0);
        $("#union_dz").text(json.data[4]['num'] || 0);

    } else if (role == 'administrator' || role == 'adminunion' ||  role == 'technology') {
        console.log(json.data);
        $(".adminunion").css('display', 'block');
        $("#zgh_union").text(json.data[0]['num'] || 0);
        $("#zgh_qy").text(json.data[1]['num'] || 0);
        $("#zgh_gj").text(json.data[2]['num'] || 0);
        $("#zgh_news").text(json.data[3]['num'] || 0);
        $("#zgh_ll").text(json.data[5]['num'] || 0);
        $("#zgh_dz").text(json.data[4]['num'] || 0);
    }

</script>
</body>
</html>