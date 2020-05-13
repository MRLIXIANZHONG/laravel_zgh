<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/21
 * Time: 15:41
 */

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Closure;

class CrossDomain
{

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, Accept, X-CSRF-TOKEN, x-requested-with,content-type');
        header('Access-Control-Allow-Credentials:true');

        return $response;
    }
}