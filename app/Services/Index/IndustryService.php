<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-26 上午 11:13
 */

namespace App\Services\Index;


use App\Models\Industry;
use App\Services\Service;

class IndustryService extends Service
{

    /**
     * 获取行业列表
     */
    public function getList()
    {
        return Industry::query()->select('id','industry_name as name')->get();
    }

}