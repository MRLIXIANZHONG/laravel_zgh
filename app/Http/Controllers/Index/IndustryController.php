<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-26 上午 11:49
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;

class IndustryController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * 获取行业列表
     * @return array
     */
    public function getList()
    {

        try {
            $industryService = ServiceHelper::make('Index\IndustryService');
            $industryList = $industryService->getList();
            return array('code' => 1000, 'msg' => '成功', 'industryList' => $industryList);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }

    }
}