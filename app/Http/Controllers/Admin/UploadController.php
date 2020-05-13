<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/16
 * Time: 21:41
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Handlers\UploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;

class UploadController extends Controller
{
    public function upload(Request $request, UploadHandler $uploadHandler)
    {
        $file = $request->route('craftsman');
        $url = $uploadHandler->upload($request->photo, $file, $request->get('id'));

        return $url['path'];
    }
}