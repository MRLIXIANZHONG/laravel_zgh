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
use App\DTO\NewsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;

class NewsController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    //获取首页新闻
    public function getIndexNewsList(NewsRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
            $response = ServiceHelper::make('Index\NewsService')->getIndexNewsList($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }


    //获取新闻列表
    public function getNewsList(NewsRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
            $response = ServiceHelper::make('Index\NewsService')->getNewsList($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }

    //获取新闻详情
    public function getNewsDetail(NewsRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
            $response = ServiceHelper::make('Index\NewsService')->getNewsDetail($dto);

            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }


    //点赞功能
    public function setStarCount(NewsRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
            $response = ServiceHelper::make('Index\NewsService')->setStarCount($dto);

            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }


    //浏览功能
    public function setBrowseCount(NewsRequest $request)
    {
        try {
            $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
            $response = ServiceHelper::make('Index\NewsService')->setBrowseCount($dto);
            return array('code' => 1000, 'msg' => '成功', 'data' => $response);
        } catch (Exception $e) {
            return array('code' => -1, 'msg' => '异常：' . $e->getMessage());
        }
    }


}