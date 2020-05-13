<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 上午 11:58
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\HomeIndexDTO;
use App\Http\Requests\Admin\NewsRequest;
use phpDocumentor\Reflection\Types\Array_;

class HomeIndexController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**获取首页统计
     * @return json
     */
    public function getHomeStatistics(NewsRequest $request)
    {
        $sulg = $this->admininfo['role_slug'];
        $dto = $this->requestHelper->makeDTO(HomeIndexDTO::class, $request);
        $dto->setOrgId($this->admininfo['org_id']);//企业ID
        $dto->setUnitsId($this->admininfo['units_id']);//公会ID
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $dto->setRoleSlug($sulg);//角色类型

        if ($sulg == "enterprise")
            $data = ServiceHelper::make('Admin\HomeIndexService')->getEnterpriseHome($dto);
        else if ($sulg == "union")
            $data = ServiceHelper::make('Admin\HomeIndexService')->getUnionHome($dto);
        else
            $data = ServiceHelper::make('Admin\HomeIndexService')->getAdminUnionHome($dto);
        return view('admin.welcome', ['countList' => $data, 'admininfo' => $this->admininfo]);
        // return view('admin.welcome', ['countList' => $data['respon'],'browseCount'=>$data['browseCount'][0]]);
    }

    /**获取巴渝首页统计
     * @return json
     */
    public function getByHomeStatistics(NewsRequest $request)
    {
        $sulg = $this->admininfo['role_slug'];
        $dto = $this->requestHelper->makeDTO(HomeIndexDTO::class, $request);
        $dto->setOrgId($this->admininfo['org_id']);//企业ID
        $dto->setUnitsId($this->admininfo['units_id']);//公会ID
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $dto->setRoleSlug($sulg);//角色类型
        if ($sulg == "union")
            $data = ServiceHelper::make('Admin\HomeIndexService')->getByUnionHome($dto);
        else
            $data = ServiceHelper::make('Admin\HomeIndexService')->getByAdminUnionHome($dto);
        return view('admin.welcomeby', ['countList' => $data, 'admininfo' => $this->admininfo]);
        // return view('admin.welcome', ['countList' => $data['respon'],'browseCount'=>$data['browseCount'][0]]);
    }

    /**
     * 企业 获取优秀个人 数据
     */
    public function getEnterpriseData()
    {
        $beginTime = request('beginTime');
        $endTime = request('endTime');
        $type = request('type');
        $dataType = request('dataType');//获取数据类型
        $billId = $this->admininfo['org_id'];//企业ID
        if ($dataType == 'union')
            $billId = $this->admininfo['units_id'];//公会ID
        else if ($dataType == 'adminunion')
            $billId = -1;//总工会查所有
        $arr = ['beginTime' => $beginTime, 'endTime' => $endTime, 'billId' => $billId, 'type' => $type];
        if ($dataType == 'yxgr')//企业优秀个人数据
            $data = ServiceHelper::make('Admin\HomeIndexService')->getPersonData($arr);
        else if ($dataType == 'wuxiao')//企业优秀五小
            $data = ServiceHelper::make('Admin\HomeIndexService')->getFiveSmallData($arr);
        else if ($dataType == 'plan')//企业 优秀方案
            $data = ServiceHelper::make('Admin\HomeIndexService')->getGoodPlanData($arr);
        else if ($dataType == 'news')//企业 新闻
            $data = ServiceHelper::make('Admin\HomeIndexService')->getNewsData($arr);
        else if ($dataType == 'browse')//活动浏览量
            $data = ServiceHelper::make('Admin\HomeIndexService')->getBrowseData($arr);
        else if ($dataType == 'star')//活动点赞
            $data = ServiceHelper::make('Admin\HomeIndexService')->getStarData($arr);
        else if ($dataType == 'union')//获取公会数据
            $data = ServiceHelper::make('Admin\HomeIndexService')->getUnionData($arr);
        else if ($dataType == 'adminunion')//获取公会数据
            $data = ServiceHelper::make('Admin\HomeIndexService')->getAdminUnionData($arr);
        return $data;
    }


}