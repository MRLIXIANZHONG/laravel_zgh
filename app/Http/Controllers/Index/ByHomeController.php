<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 10:41
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\BrowseCountDTO;
use App\DTO\NewsDTO;
use App\DTO\NomineeDTO;
use App\DTO\OrganizationsPlanDTO;
use App\DTO\OrganizationsWuxiaoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Request;
use App\Services\Index\ByHomeService;
use Illuminate\Http\JsonResponse;

class ByHomeController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }


    public function getByMobieHomeIndex()
    {
        $array = [
            'is_craftsman' => request()->get('is_craftsman'),
        ];
        try {
            $response = ServiceHelper::make('Index\ByHomeService')->getByMobieHomeIndex($array);


            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function getCopyright($sys)
    {
        try {
            $response = ServiceHelper::make('Index\ByHomeService')->getCopyright($sys);
            $uid = request('unit_id');
            $unitInfo=null;
            if ($uid)
                $unitInfo = ServiceHelper::make('Index\ByHomeService')->getUninInfo($uid);
            return array('code' => 1000, 'msg' => '成功', 'data' => $response,'unitInfo'=>$unitInfo);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    public function getByPCIndex()
    {
        try {

            $response = ServiceHelper::make('Index\ByHomeService')->getByPCHomeIndex();

            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    /**
     * 设置活动 公会 浏览量
     */
    public function setBrowseCount(BannerRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(BrowseCountDTO::class, $request);
            $response = ServiceHelper::make('Index\ByHomeService')->setBrowseCount($dto);

            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    /**
     * 获取基层公共首页数据
     * @param $id
     * @return
     */
    public function getUnionMobieHome($id)
    {

        if ($id) {
            //统计数据
            $countInfo = $response = ServiceHelper::make('Index\ByHomeService')->getHomeStatistics($id);
            $unionInfo = $response = ServiceHelper::make('Index\UnitService')->getHomeDetail($id);
            $newDto = new NewsDTO(['system_version' => 'cqzgh', 'unit_id' => $id, 'isShowHome' => 1, 'pageSize' => 4]);

            //新闻数据
            $newList = ServiceHelper::make('Index\NewsService')->getNewsList($newDto);

            $nomineeList = ServiceHelper::make('Index\NomineeService')->getList(new NomineeDTO(['unit_id' => $id,'recommend'=>1]));
            $wuxiaoList = ServiceHelper::make('Index\OrganizationWuxiaoService')->getList(new OrganizationsWuxiaoDTO(['unit_id' => $id,'recommend'=>1]));
            //$planList = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['unit_id' => $id, 'pagesize' => 16]));
            $orgList = ServiceHelper::make('Index\OrganizationService')->getJoinOrg($id);
            $planList = ServiceHelper::make('Index\OrganizationsPlanService')->getList(new OrganizationsPlanDTO(['unit_id' => $id,'pagesize'=>16]));
            $array = (['countInfo' => $countInfo, 'newList' => $newList, 'nomineeList' => $nomineeList, 'wuxiaoList' => $wuxiaoList, 'planList' => $planList, 'orgList' => $orgList, 'unionInfo' => $unionInfo]);
            return new JsonResponse($array);

        }
        return;
    }


    //获取网络竞赛首页数据
    public function getNetWorkIndex(Request $request)
    {

        $data = $request->all();
        if (isset($data['unit_id'])) {
            $list = (new ByHomeService())->getNetWorkIndex($data['unit_id']);
        } else {
            $list = (new ByHomeService())->getNetWorkIndex();
        }
        return $list;
    }

    //获取网络竞赛pc首页数据
    public function getNetWorkPcIndex(Request $request)
    {
        $data = $request->all();

        if (isset($data['unit_id'])) {
            $list = (new ByHomeService())->getNetWorkPcIndex($data['unit_id']);
        } else if(isset($data['kind'])) {
            $list = (new ByHomeService())->getNetWorkPcIndex_person($data['kind']);
        }else if(isset($data['type'])) {
            $list = (new ByHomeService())->getNetWorkPcIndex_wuxiao($data['type']);
        }else  {
            $list = (new ByHomeService())->getNetWorkPcIndex();
        }
        return $list;
    }

    //获取工会名称
    public function getUnitName(Request $request){
        $data = $request->all();
        $list=['code'=>200,'title'=>''];
        if (isset($data['unit_id'])) {
            $list['title'] = (new ByHomeService())->getUnitName($data['unit_id']);
        }
        return $list;
    }


}