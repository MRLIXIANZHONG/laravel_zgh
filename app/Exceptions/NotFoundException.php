<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 11:24
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class NotFoundException extends Exception
{
    public function __construct(string $message = " ", int $code = 404)
    {
        parent::__construct($message, $code);
    }


    public function render(Request $request)
    {
        if (strpos($request->route()->uri, 'api') !== false) {
            return response()->json(['message' => $this->message, 'code' => $this->code]);
        }

        if (strpos($request->route()->uri, 'edit') !== false || strpos($request->route()->uri, 'create')) {
            return view('error', ['msg' => $this->message]);
        }

        if (strpos($request->route()->getActionName(), 'show') !== false) {
            return view('error', ['msg' => $this->message]);
        }

        return response()->json(['message' => $this->message, 'code' => 404]);
    }
}