<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'namespace' => 'Index'
], function () {

    //TODO 工匠列表
    Route::get('craftsmans', 'CraftsmanController@index');
    //TODO 工匠详情
    Route::get('craftsmans/{craftsman}', 'CraftsmanController@show');

    //TODO 候选工匠列表
    Route::get('candidate_craftsmans', 'CandidateCraftsmanController@index');
    //TODO 候选工匠详情
    Route::get('candidate_craftsmans/{candidate_craftsman}', 'CandidateCraftsmanController@show');
    //TODO 候选工匠点赞
    Route::get('candidate_craftsmans/{candidate_craftsman}/star', 'CandidateCraftsmanController@star');

    //TODO 历史工匠列表
    Route::get('history_craftsmans', 'HistoryCraftsmanController@index');
    //TODO 历史工匠详情
    Route::get('history_craftsmans/{history_craftsman}', 'HistoryCraftsmanController@show');

    //TODO 候选工匠PC点赞
    Route::post('craftsmans_star/{craftsman}', 'CraftsmanController@pcStar');
    //TODO 候选工匠YD端点赞
    Route::post('craftsman_ydstar/{craftsman}', 'CraftsmanController@ydStar');

    //TODO 基层工会列表`
    Route::get('units', 'UnitController@index');
    //TODO 基层工会详情
    Route::get('units/{unit}', 'UnitController@show');

    //TODO 企业单位列表
    Route::get('organizations', 'OrganizationController@index');
    //TODO 获取参赛企业列表
    Route::get('orgjoin', 'OrganizationController@getOrg');
    //TODO 企业单位详情
    Route::get('organizations/{organization}', 'OrganizationController@show');
    Route::get('organizations/detail/{id}', 'OrganizationController@getDetailById');

    //TODO 重点竞赛页面
    Route::get('sport_organizations', 'OrganizationController@getSportList');

    //TODO 赛事活动列表
    Route::get('segments', 'SegmentsController@index');
    //TODO 赛事活动详情
    Route::get('segments/{segment}', 'SegmentsController@show');

    //TODO 获取首页新闻 必要 system_version 版本号
    Route::get('news', 'NewsController@getIndexNewsList');
    //TODO 新闻列表 必要参数 page:1 system_version 版本号 当前页 非必要参数 title 搜索标题 source 新闻类型
    Route::get('news/list', 'NewsController@getNewsList');
    //TODO 新闻详情 必要参数 id
    Route::get('news/detail', 'NewsController@getNewsDetail');
    //TODO 新闻点赞 必要参数 id 每次+1
    Route::post('news/star', 'NewsController@setStarCount');
    //TODO 新闻浏览 必要参数 id 每次+1
    Route::post('news/browse', 'NewsController@setBrowseCount');
    //TODO 云竞技直播 列表 必要参数 system_version 版本号
    Route::get('rloudlive', 'RloudLiveController@getIndexRloudList');
    //TODO Banner  必要参数 system_version 版本号
    Route::get('banner', 'BannerController@getBanner');


    //TODO 获取首页方案统计数据
    Route::get('organizationsplan/organizationsplancount', 'OrganizationsPlanController@getOrganizationsPlanStatisticsCount');
    //TODO 方案列表
    Route::get('organizationsplan/index', 'OrganizationsPlanController@index');
    //TODO 方案详情
    Route::get('organizationsplan/getdetail', 'OrganizationsPlanController@getDetail');
    //TODO 方案点赞 必要参数 id 每次+1
    Route::post('organizationsplan/star', 'OrganizationsPlanController@setStarCount');
    //TODO 方案PC点赞 必要参数 id 每次+1
    Route::get('organizationsplan/planpcstar', 'OrganizationsPlanController@planPCStar');
    //TODO 方案浏览 必要参数 id 每次+1
    Route::get('organizationsplan/browse', 'OrganizationsPlanController@setBrowseCount');
    //TODO 工会优秀方案统计
    Route::get('organizationsplan/unitstatistics', 'OrganizationsPlanController@unitStatistics');

    //TODO 专家详情
    Route::get('judges/index', 'JudgesController@index');
    //TODO 专家列表
    Route::get('judges/getdetail/{id}', 'JudgesController@getDetail');

    //TODO 用户是否点过赞
    Route::get('userstarlog/checkuserstarlog', 'UserstarLogController@checkUserStarLog');

    //TODO 添加点赞记录
    Route::get('userstarlog/storeuserstarlog', 'UserstarLogController@storeUserStarLog');

    //TODO 用户是否关注
    Route::get('wechatusers/checkisdel', 'WechatUsersController@checkIsDel');

    Route::get('caseschem/detail', 'CaseSchemeController@detail');
    Route::get('caseschem/get_list', 'CaseSchemeController@getList');
    //TODO 巴渝首页
    Route::get('byhome', 'ByHomeController@getByMobieHomeIndex');
    Route::get('byhome/pc', 'ByHomeController@getByPCIndex');
    //TODO 活动浏览量+1 巴渝活动 id 1 网络评选 id 2 公会的不传ID 传unit_id(公会自身ID)  3 企业传 org_id   3中参数一个请求只能有一种
    Route::post('byhome/setbrowsecount', 'ByHomeController@setBrowseCount');
    //TODO 获取网络竞技大赛首页信息
    Route::get('unionhome/{id}', 'ByHomeController@getUnionMobieHome');
    Route::get('industry', 'IndustryController@getList');
    //TODO 获取公会信息
    Route::get('units', 'UnitController@index');

    //TODO 获取网络筛选首页数据
    Route::get('getnetwork', 'ByHomeController@getNetWorkIndex');
    Route::get('getgopyright/{sys}', 'ByHomeController@getCopyright');


    //TODO 移动端总工会统计
    Route::get('statistic/adminunionmodel', 'StatisticController@adminunionModel');
    Route::get('statistic/unionmodel', 'StatisticController@unionModel');

    //TODO 获取网络筛选pc首页数据
    Route::get('getnetworkpc', 'ByHomeController@getNetWorkPcIndex');    //TODO 获取重点竞赛
    Route::get('rloudlive/competition', 'RloudLiveController@getCompetition');

    //TODO 获取工会的名称
    Route::get('unitname', 'ByHomeController@getUnitName');

});
Route::group([
    'namespace' => 'Index'
    , 'prefix' => 'nominees',
], function () {

    //TODO 优秀个人
    Route::get('getlist', 'NomineeController@getList');
    Route::get('getdetail/{id}', 'NomineeController@getDetail');
    Route::post('setlike', 'NomineeController@star');
    Route::post('pcsetlike', 'NomineeController@pcstar');

});
Route::group([
    'namespace' => 'Index'
    , 'prefix' => 'wuxiao',
], function () {

    //TODO 五小
    Route::get('getlist', 'OrganizationWuxiaoController@getList');
    Route::get('getdetail/{id}', 'OrganizationWuxiaoController@getDetail');
    Route::post('setlike', 'OrganizationWuxiaoController@setLike');
    Route::post('setpclike', 'OrganizationWuxiaoController@setPCLike');

});

Route::group([
    'namespace' => 'Wechat',
    'prefix'    => 'wxchat',
], function () {
    Route::get('get_jssdk', 'WechatController@getJsSdk');
});