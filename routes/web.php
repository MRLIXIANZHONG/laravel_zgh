<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('error');
});

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
], function () {
    Route::resource('news', 'NewsController');

    Route::post('uploadqrcode', 'AdminUserController@upLoadQRCode');
    Route::get('qrcode', 'AdminUserController@qrCode');

    //TODO
    Route::post('upload', 'UploadController@upload');
    //TODO 统计曲线图
    Route::get('statistics', 'StatisticController@index');

    //TODO 企业标签模块
    Route::get('industries', 'IndustryController@index');
    Route::get('industries/create', 'IndustryController@create');
    Route::get('industries/{industry}', 'IndustryController@show');
    Route::post('industry', 'IndustryController@store');
    Route::put('industries/{industry}', 'IndustryController@update');
    Route::get('industries/{industry}/edit', 'IndustryController@edit');
    Route::delete('industries/{industry}', 'IndustryController@destroy');

    //TODO 企业模块
    Route::get('organizations', 'OrganizationController@index');
    Route::get('organizations/create', 'OrganizationController@create');
    Route::get('organizations/{organization}', 'OrganizationController@show');
    Route::post('organization', 'OrganizationController@store');
    Route::put('organizations/{organization}', 'OrganizationController@update');
    Route::get('organizations/{organization}/edit', 'OrganizationController@edit');
    Route::delete('organizations/{organization}', 'OrganizationController@destroy');
    Route::post('organizations/{organization}/check', 'OrganizationController@check');
    Route::post('organizations/{organization}/reject', 'OrganizationController@reject');
    //TODO 企业账号重置密码
    Route::patch('organizations/{organization}/set_password', 'OrganizationController@setPassword');
    //TODO 企业推送
    Route::patch('organizations/{organization}/pull', 'OrganizationController@pull');
    //TODO 设置虚拟浏览点赞量
    Route::patch('organizations/{organization}/set_virtual', 'OrganizationController@setVirtual');

    //TODO 企业个人中心
    Route::get('organization_user', 'OrganizationUserController@edit');
    // TODO 修改企业信息
    Route::put('organization_user', 'OrganizationUserController@update');

    //TODO 网络竞技企业统计
    Route::get('wl_organizations', 'WlOrganizationController@index');
    Route::get('wl_organization_export', 'WlOrganizationController@export');
    //Route::patch('organizations', 'OrganizationController@index');

    //TODO 巴渝工匠企业统计
    Route::get('by_organizations', 'ByOrganizationController@index');
    Route::get('by_organization_export', 'ByOrganizationController@export');
    //Route::patch('organizations', 'OrganizationController@index');

    //TODO 企业审核
    Route::patch('organizations/{organization}/check', 'OrganizationController@check');
    //TODO 企业驳回
    Route::patch('organizations/{organization}/reject', 'OrganizationController@reject');

    //TODO 基层工会模块
    Route::get('units', 'UnitController@index');
    Route::get('units/create', 'UnitController@create');
    Route::post('unit', 'UnitController@store');
    Route::get('unit/gethomepage', 'UnitController@getHomePage');
    Route::post('unit/updatehomepage', 'UnitController@updateHomePage');
    Route::get('units/{unit}', 'UnitController@show');
    Route::get('units/{unit}/edit', 'UnitController@edit');
    Route::put('units/{unit}', 'UnitController@update');
    Route::delete('units/{unit}', 'UnitController@destroy');
    //TODO 设置密码
    Route::patch('units/{unit}/set_password', 'UnitController@setPassword');
    //TODO 设置虚拟浏览点赞量
    Route::patch('units/{unit}/set_virtual', 'UnitController@setVirtual');

    //TODO 工会个人中心
    Route::get('unit_user', 'UnitUserController@edit');

    //TODO 基层工会审核
    Route::patch('units/{unit}/check', 'UnitController@check');
    //TODO 基层工会驳回
    Route::patch('units/{unit}/reject', 'UnitController@reject');

    //TODO 网络竞技工会统计
    Route::get('wl_units', 'WlUnitController@index');
    Route::get('wl_units_export', 'WlUnitController@export');
    //Route::patch('organizations', 'OrganizationController@index');

    //TODO 巴渝工匠工会统计
    Route::get('by_units', 'ByUnitController@index');
    Route::get('by_units_export', 'ByUnitController@export');
    //Route::patch('organizations', 'OrganizationController@index');

    //TODO 申请工匠模块
    Route::get('craftsmans', 'CraftsmanController@index');
    Route::get('craftsmans/create', 'CraftsmanController@create');
    Route::get('craftsmans/{craftsman}', 'CraftsmanController@show');
    Route::post('craftsman', 'CraftsmanController@storeCraftsman');
    Route::get('craftsmans/{craftsman}/edit', 'CraftsmanController@edit');
    Route::put('craftsmans/{craftsman}', 'CraftsmanController@updateCraftsman');
    Route::delete('craftsmans/{craftsman}', 'CraftsmanController@destroy');

    //TODO 申请工匠新增荣誉页面
    Route::get('craftsmans/{craftsman}/create_honor', 'CraftsmanController@createCraftsmanHonor');
    //TODO 申请工匠新增荣誉
    Route::post('craftsmans/{craftsman}/honor', 'CraftsmanController@storeCraftsmanHonor');
    //TODO 删除候选工匠荣誉
    Route::delete('craftsmans/{craftsman}/honors/{honor}', 'CraftsmanController@deleteCraftsmanHonor');

    //TODO 推送工匠
    Route::patch('craftsmans/{craftsman}/pull', 'CraftsmanController@pull');

    //TODO 候选工匠导出
    Route::get('candidate_craftsmans/export', 'CandidateCraftsmanController@export');

    //TODO 候选工匠模块
    Route::get('candidate_craftsmans', 'CandidateCraftsmanController@index');
    Route::get('candidate_craftsmans/create', 'CandidateCraftsmanController@create');
    Route::get('candidate_craftsmans/{candidate_craftsman}', 'CandidateCraftsmanController@show');
    Route::post('candidate_craftsman', 'CandidateCraftsmanController@store');
    Route::get('candidate_craftsmans/{candidate_craftsman}/edit', 'CandidateCraftsmanController@edit');
    Route::put('candidate_craftsmans/{candidate_craftsman}', 'CandidateCraftsmanController@updateCraftsman');
    Route::delete('candidate_craftsmans/{candidate_craftsman}', 'CandidateCraftsmanController@destroy');

    //TODO 候选工匠设置虚拟浏览点赞量
    Route::patch('candidate_craftsmans/{candidate_craftsman}/set_virtual', 'CandidateCraftsmanController@setVirtual');
    //TODO 候选工匠审核
    Route::patch('candidate_craftsmans/{candidate_craftsman}/check', 'CandidateCraftsmanController@check');
    //TODO 候选工匠驳回
    Route::patch('candidate_craftsmans/{candidate_craftsman}/reject', 'CandidateCraftsmanController@reject');
    //TODO 评选工匠
    Route::patch('candidate_craftsmans/{candidate_craftsman}/set_craftsman', 'CandidateCraftsmanController@setCraftsman');
    //TODO 专家打分
    Route::patch('candidate_craftsmans/{candidate_craftsman}/expert_score', 'CandidateCraftsmanController@expertScore');

    //TODO 工匠导出
    Route::get('is_craftsmans/export', 'IsCraftsmanController@export');

    //TODO 工匠模块
    Route::get('is_craftsmans', 'IsCraftsmanController@index');
    Route::get('is_craftsmans/create', 'IsCraftsmanController@create');
    Route::get('is_craftsmans/{is_craftsman}', 'IsCraftsmanController@show');
    Route::post('is_craftsman', 'IsCraftsmanController@isCraftsmanStore');
    Route::get('is_craftsmans/{is_craftsman}/edit', 'IsCraftsmanController@edit');
    Route::put('is_craftsmans/{is_craftsman}', 'IsCraftsmanController@isCraftsmanUpdate');
    Route::delete('is_craftsmans/{is_craftsman}', 'IsCraftsmanController@destroy');

    //TODO 无用工匠申请列表模块
    Route::get('apply_craftsmans', 'ApplyCraftsmanController@index');
    Route::get('apply_craftsmans/create', 'ApplyCraftsmanController@create');
    Route::get('apply_craftsmans/{apply_craftsman}', 'ApplyCraftsmanController@show');
    Route::post('apply_craftsman', 'ApplyCraftsmanController@store');
    Route::get('apply_craftsmans/{apply_craftsman}/edit', 'ApplyCraftsmanController@edit');
    Route::put('apply_craftsmans/{apply_craftsman}', 'ApplyCraftsmanController@update');
    Route::delete('apply_craftsmans/{apply_craftsman}', 'ApplyCraftsmanController@destroy');

    //TODO 历史工匠模块
    Route::get('history_craftsmans', 'HistoryCraftsmanController@index');
    Route::get('history_craftsmans/create', 'HistoryCraftsmanController@create');
    Route::get('history_craftsmans/{history_craftsman}', 'HistoryCraftsmanController@show');
    Route::post('history_craftsman', 'HistoryCraftsmanController@store');
    Route::get('history_craftsmans/{history_craftsman}/edit', 'HistoryCraftsmanController@edit');
    Route::put('history_craftsmans/{history_craftsman}', 'HistoryCraftsmanController@update');
    Route::delete('history_craftsmans/{history_craftsman}', 'HistoryCraftsmanController@destroy');

    //TODO 赛事活动模块


    //TODO 新闻模块
    Route::post('news/show', 'NewsController@show');
    Route::post('news/destroy', 'NewsController@destroy');
    Route::post('news/sendnews', 'NewsController@sendNews');
    Route::post('news/checknews', 'NewsController@checkNews');
    Route::post('news/upload', 'NewsController@upload');
    Route::post('news/delFile', 'NewsController@delFile');
    Route::post('news/showHome', 'NewsController@showHome');
    Route::post('news/uploadueditor', 'NewsController@uploadUeditor');
    Route::post('news/releasenews', 'NewsController@releaseNews');
    Route::post('news/setvirtual', 'NewsController@setVirtual');
    Route::get('news/detail/{id}', 'NewsController@showDetail');

    //TODO 方案模块
    Route::get('organizationsplan', 'OrganizationsPlanController@index');
    Route::get('organizationsplan/show', 'OrganizationsPlanController@show');
    Route::get('organizationsplan/store', 'OrganizationsPlanController@getstore');
    Route::post('organizationsplan/store', 'OrganizationsPlanController@store');
    Route::post('organizationsplan/destroy', 'OrganizationsPlanController@destroy');
    Route::get('organizationsplan/update', 'OrganizationsPlanController@getUpdate');
    Route::post('organizationsplan/update', 'OrganizationsPlanController@update');
    Route::post('organizationsplan/changecheckstate', 'OrganizationsPlanController@changeCheckState');
    Route::get('organizationsplan/excellentselection', 'OrganizationsPlanController@getExcellentSelection');
    Route::get('organizationsplan/storerecommend', 'OrganizationsPlanController@getRecommend');
    Route::post('organizationsplan/excellentselection', 'OrganizationsPlanController@excellentSelection');
    Route::post('organizationsplan/storerecommend', 'OrganizationsPlanController@recommend');
    Route::get('organizationsplan/storeleaders', 'OrganizationsPlanController@getStoreleaders');
    Route::post('organizationsplan/storeordestroyleaders', 'OrganizationsPlanController@storeOrDestroyLeaders');
    Route::get('organizationsplan/storesegments', 'OrganizationsPlanController@getStoresegments');
    Route::post('organizationsplan/storesegments', 'OrganizationsPlanController@storesegments');
    Route::get('organizationsplan/excellentrelation', 'OrganizationsPlanController@getExcellentrelation');
    Route::post('organizationsplan/excellentrelation', 'OrganizationsPlanController@excellentrelation');
    Route::get('organizationsplan/expore', 'OrganizationsPlanController@expore');

    //TODO 方案活动
    Route::get('segments', 'SegmentsController@index');
    Route::get('segments/show', 'SegmentsController@show');
    Route::get('segments/store', 'SegmentsController@getStore');
    Route::post('segments/store', 'SegmentsController@store');
    Route::get('segments/update', 'SegmentsController@getUpdate');
    Route::post('segments/update', 'SegmentsController@update');
    Route::post('segments/destroy', 'SegmentsController@destroy');

    //TODO 专家模块
    Route::get('judges/detail', 'JudgesController@detail');
    Route::get('judges/show', 'JudgesController@show');
    Route::get('judges/update', 'JudgesController@getupdate');
    Route::post('judges/update', 'JudgesController@update');
    Route::get('judges', 'JudgesController@index');
    Route::get('judges/store', 'JudgesController@getStore');
    Route::post('judges/store', 'JudgesController@store');
    Route::post('judges/destroy', 'JudgesController@destroy');
    Route::get('judges/recommend', 'JudgesController@getRecommend');
    Route::post('judges/recommend', 'JudgesController@recommend');
    Route::get('judges/honor', 'JudgesController@getHonor');
    Route::post('judges/honor', 'JudgesController@honor');
    Route::get('judges/expore', 'JudgesController@expore');
    Route::post('judges/score', 'JudgesController@score');
    Route::get('judges/score', 'JudgesController@getScore');
    Route::get('judges/scorelist', 'JudgesController@getScoreList');
    

    Route::get('honorjudges/list', 'HonorJudgesController@List');
    Route::get('honorjudges/store', 'HonorJudgesController@getstore');
    Route::post('honorjudges/store', 'HonorJudgesController@store');
    Route::get('honorjudges/edit', 'HonorJudgesController@getUpdate');
    Route::post('honorjudges/edit', 'HonorJudgesController@update');
    Route::post('honorjudges/destroy', 'HonorJudgesController@destroy');
    Route::get('honorjudges/show', 'HonorJudgesController@show');

    //TODO 专家指派模块
    Route::get('judgesassign/index', 'JudgesAssignController@index');
    Route::get('judgesassign/store', 'JudgesAssignController@getStore');
    Route::post('judgesassign/store', 'JudgesAssignController@store');
    Route::get('judgesassign/randomjudges', 'JudgesAssignController@getRandomJudges');
    Route::post('judgesassign/randomjudges', 'JudgesAssignController@randomJudges');
    Route::post('judgesassign/destroyjudgejudgesassign','JudgesAssignController@destroyJudgeJudgesAssign');
    Route::get('judgesassign/update','JudgesAssignController@getUpdate');
    Route::post('judgesassign/update','JudgesAssignController@update');
    Route::post('judgesassign/dorandom', 'JudgesAssignController@doRandom');
    Route::post('judgesassign/destroy', 'JudgesAssignController@destroy');
    Route::get('judgesassign/expore', 'JudgesAssignController@expore');
    Route::get('judgesassign/addjudgesassign', 'JudgesAssignController@getAddJudgesassign');
    Route::post('judgesassign/addjudgesassign', 'JudgesAssignController@addJudgesassign');


    //TODO 方案领导模块
    Route::get('leaders/show', 'LeadersController@show');
    Route::get('leaders/update', 'LeadersController@getupdate');
    Route::post('leaders/update', 'LeadersController@update');
    Route::get('leaders', 'LeadersController@index');
    Route::get('leaders/store', 'LeadersController@getStore');
    Route::post('leaders/store', 'LeadersController@store');
    Route::get('leaders/update', 'LeadersController@getupdate');
    Route::post('leaders/update', 'LeadersController@update');
    Route::post('leaders/destroy', 'LeadersController@destroy');

    Route::resource('index', 'IndexController');
    //TODO 云竞技模块
    Route::resource('rloudlive', 'RloudLiveController');
    Route::post('rloudlive/destroy', 'RloudLiveController@destroy');
    Route::post('rloudlive/check', 'RloudLiveController@check');
    Route::get('rloudlive/detail/{id}', 'RloudLiveController@showDetail');


    //TODO banner
    Route::resource('banner', 'BannerController');
    Route::post('banner/destroy', 'BannerController@destroy');
    Route::post('banner/update', 'BannerController@update');
    //TODO 错误页面
    Route::get('error', 'ErrorController@error');
    //TODO 获取首页数据
    Route::get('welcome', 'HomeIndexController@getHomeStatistics');
    Route::get('welcome/enterprise', 'HomeIndexController@getEnterpriseData');
    //TODO 获取巴渝首页数据
    Route::get('welcomeby', 'HomeIndexController@getByHomeStatistics');

    //TODO 专题管理
    Route::resource('specialmanage', 'Special_manageController');
    //TODO 竞赛专题
    Route::resource('competition', 'CompetitionController');


});

Route::group(['namespace' => "Auth", 'prefix' => 'admin'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'RegisterController@setRegister');
        //TODO 测试短信
    Route::post('/setsms', 'RegisterController@setSms');
});

Route::group([
    'namespace' => "Admin", 'prefix' => 'admin'
], function () {

    Route::get('/caseschemes/index', 'CaseSchemesController@index');
    Route::post('/caseschemes/store', 'CaseSchemesController@store');
    Route::post('/caseschemes/update', 'CaseSchemesController@update');
    Route::get('/caseschemes/edit', 'CaseSchemesController@edit');
    Route::post('/caseschemes/destroy/{id}', 'CaseSchemesController@destroy');
    Route::get('/caseschemes/detail/{id}', 'CaseSchemesController@detail');
    Route::get('/caseschemes/nominee', 'CaseSchemesController@nominee');
    Route::get('/caseschemes/wuxiao', 'CaseSchemesController@wuxiao');
    Route::get('/casefile/index', 'CaseFileController@index');
    Route::get('/casefile/edit', 'CaseFileController@edit');
    Route::post('/casefile/update', 'CaseFileController@update');
    Route::get('/casefile/detail/{id}', 'CaseFileController@detail');
    Route::post('/casefile/destroy/{id}', 'CaseFileController@destroy');


    Route::get('/nominees/index', 'NomineesContoller@index');
    Route::get('/nominees/detail/{id}', 'NomineesContoller@show');
    //删除优秀个人
    Route::post('/nominees/destroy/{id}', 'NomineesContoller@destroy');
    //编辑优秀个人
    Route::get('/nominees/edit', 'NomineesContoller@edit');
    //添加
    Route::post('/nominees/store', 'NomineesContoller@store');
    //修改
    Route::post('/nominees/update', 'NomineesContoller@update');
    //导出Excel
    Route::get('/nominees/exportexcel', 'NomineesContoller@exportExcel');
    //设置为月、季、年、度之星
    Route::post('/nominees/check', 'NomineesContoller@check');
    //设置为季度之星
    Route::post('/nominees/quarter/{id}', 'NomineesContoller@quarter');
    Route::post('/nominees/year/{id}', 'NomineesContoller@year');
    Route::post('/nominees/setvirtual', 'NomineesContoller@setvirtual');
    Route::post('/nominees/recommend', 'NomineesContoller@recommend');



    //取消月、季、年、度之星
    Route::post('/nominees/cancelexcellent', 'NomineesContoller@cancelExcellent');
    Route::post('/nominees/declare/{id}', 'NomineesContoller@declare');

    Route::get('/wuxiao/index', 'OrganizationsWuxiaoController@index');
    Route::get('/wuxiao/edit', 'OrganizationsWuxiaoController@edit');
    //添加五小
    Route::post('/wuxiao/store', 'OrganizationsWuxiaoController@store');
    //修改五小
    Route::post('/wuxiao/update', 'OrganizationsWuxiaoController@update');
    //获取详情
    Route::get('/wuxiao/detail/{id}', 'OrganizationsWuxiaoController@detail');
    //五小申报
    Route::post('/wuxiao/declaration/{id}', 'OrganizationsWuxiaoController@declaration');
    //删除
    Route::post('/wuxiao/destroy/{id}', 'OrganizationsWuxiaoController@destroy');
    //审核
    Route::post('/wuxiao/check', 'OrganizationsWuxiaoController@check');
    //推荐
    Route::post('/wuxiao/recommend', 'OrganizationsWuxiaoController@recommend');
    //设置为优秀
    Route::post('/wuxiao/quarter/{id}', 'OrganizationsWuxiaoController@quarter');
    Route::post('/wuxiao/year/{id}', 'OrganizationsWuxiaoController@year');
    Route::post('/wuxiao/excellent', 'OrganizationsWuxiaoController@excellent');
    Route::get('/wuxiao/exportexcel', 'OrganizationsWuxiaoController@exportExcel');
    Route::post('/wuxiao/setvirtual', 'OrganizationsWuxiaoController@setvirtual');
    Route::get('menu/index', 'MenuController@index');

    Route::post('menu/sort', 'MenuController@changeSort');

    Route::get('menu/edit/{id}', 'MenuController@edit');

    Route::post('menu/save', 'MenuController@save');

    Route::any('menu/delete/{id}', 'MenuController@destroy');

    Route::get('roles/index', 'RoleController@index');

    Route::get('roles/edit/{id}', 'RoleController@edit');

    Route::post('roles/getpermission', 'RoleController@getPermission');

    Route::post('roles/save', 'RoleController@save');

    Route::get('roles/delete/{id}', 'RoleController@destroy');

    Route::get('permission/index', 'PermissionsController@index');

    Route::get('permission/edit/{id}', 'PermissionsController@edit');

    Route::post('permission/save', 'PermissionsController@save');

    Route::any('permission/delete/{id}', 'PermissionsController@destroy');

    Route::get('adminuser/index', 'AdminUserController@index');

    Route::get('adminuser/edit/{id}', 'AdminUserController@edit');

    Route::post('adminuser/save', 'AdminUserController@save');

    Route::any('adminuser/delete/{id}', 'AdminUserController@destroy');

    Route::get('notificatinlist/index', 'NotificationsController@index');

    Route::get('notificatinlist/readlist/{id}', 'NotificationsController@readlist');

    Route::get('notificatinlist/edit/{id}', 'NotificationsController@edit');

    Route::get('notificatinlist/smsedit/{id}', 'NotificationsController@smsedit');

    Route::post('notificatinlist/getadminuserlist/{id}', 'NotificationsController@getAdminUserList');

    Route::post('notificatinlist/sendmsg', 'NotificationsController@sendmsg');

    Route::post('notificatinlist/getmynnot', 'NotificationsController@getmynnot');

    Route::get('notificatinlist/mynot', 'NotificationsController@mynot');

    Route::get('notificatinlist/notinfo/{id}', 'NotificationsController@notinfo');

    Route::post('notificatinlist/save', 'NotificationsController@save');

    Route::get('wechat/setting', 'WechatadminController@getSeting');

    Route::post('wechat/save', 'WechatadminController@save');

    Route::get('wechat/getkeylist', 'WechatadminController@getKeyList');

    Route::get('wechat/edit/{id}', 'WechatadminController@edit');

    Route::post('wechat/keysave', 'WechatadminController@keysave');

    Route::get('wechat/replylist', 'WechatadminController@replylist');

    Route::get('wechat/replyedit/{id}', 'WechatadminController@replyedit');

    Route::any('wechat/adminwechatupload', 'WechatadminController@adminWechatUpload');

    Route::post('wechat/replysave', 'WechatadminController@replysave');

    Route::any('wechat/delete/{id}', 'WechatadminController@destroy');

    Route::get('wechat/wxuserplylist', 'WechatadminController@wechatUserList');





    //TODO 个人荣誉

    Route::get('/nominees/indexexperience', 'NomineesContoller@indexExperience');
    Route::get('/nominees/editexperience', 'NomineesContoller@editExperience');
    Route::post('/nominees/destroyexperience/{id}', 'NomineesContoller@destroyExperience');
    Route::post('/nominees/saveexperience', 'NomineesContoller@savEexperience');

    //TODO 个人荣誉图集

    Route::get('/nominees/indeximg', 'NomineesContoller@indexImg');
    Route::get('/nominees/editimg', 'NomineesContoller@editImg');
    Route::post('/nominees/destroyimg/{id}', 'NomineesContoller@destroyImg');
    Route::post('/nominees/saveimg', 'NomineesContoller@saveImg');
    //TODO 个人荣誉视频

    Route::get('/nominees/indexvideo', 'NomineesContoller@indexVideo');
    Route::get('/nominees/editvideo', 'NomineesContoller@editVideo');
    Route::post('/nominees/destroyvideo/{id}', 'NomineesContoller@destroyVideo');
    Route::post('/nominees/savevideo', 'NomineesContoller@saveVideo');

});

Route::group(['namespace' => "Auth", 'prefix' => 'admin'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/getCaptcha', 'LoginController@getCaptcha')->name('getCaptcha');


});

Route::any('/wechat', 'Wechat\WechatController@serve');
Route::post('/wechatupload', 'Wechat\WechatController@upload');
Route::get('/getspecialkey/{key}', 'Wechat\WechatController@getSpecialKey');