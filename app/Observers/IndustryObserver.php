<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 17:25
 */

namespace App\Observers;


use App\Models\Industry;

class IndustryObserver
{
    public function saving(Industry $industry)
    {
        $industry->system_version = env('SYSTEM_VERSION', 'cqzgh');
    }
}