<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 11:43
 */

namespace App\Exceptions;



use Illuminate\Http\Request;

class InvalidArgumentException extends \Exception
{
    public function __construct(string $message = "", int $code = 422)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        if (strpos($request->route()->uri, 'api') !== false) {
            return response()->json(['message' => $this->message, 'code' => $this->code]);
        }

        return response()->json(['message' => $this->message, 'code' => 422]);
    }
}