<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/5/4
 * Time: 0:19
 */

namespace App\Exceptions;


class ErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 422)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return view('error', ['msg' => $this->message]);
    }
}