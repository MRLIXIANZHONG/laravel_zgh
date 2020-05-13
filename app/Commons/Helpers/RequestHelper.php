<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:21
 */

namespace App\Commons\Helpers;


use App\Http\Requests\Request;

class RequestHelper
{
    public function makeDTO($dtoClass, Request $request)
    {
        $request = $request ? : request();
        return new $dtoClass($request->all());
    }
}