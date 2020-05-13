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
use App\DTO\RloudLiveDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RloudLiveRequest;

class RloudLiveController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**获取云竞技直播*/
    public function getIndexRloudList(RloudLiveRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(RloudLiveDTO::class, $request);
            $response = ServiceHelper::make('Index\RloudLiveService')->getIndexRloudList($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    /**
     * 获取竞赛相关信息
     */
    public function getCompetition()
    {
        try {
            $response = ServiceHelper::make('Index\RloudLiveService')->getCompetition();
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }
}