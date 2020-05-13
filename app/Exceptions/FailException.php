<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/4/28 0028
 * Time: 15:56
 * Class TestException
 */

namespace App\Exceptions;


class FailException extends BaseException
{
    public $code = 400;

    public $message = '系统错误';

    public $errorCode = ErrorCode::SERVER_ERROR;
}