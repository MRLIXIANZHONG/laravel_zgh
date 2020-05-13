<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/4/29 0029
 * Time: 9:33
 * Class TokenException
 */

namespace App\Exceptions;


class TokenException extends BaseException
{
    public $code = 400;

    public $message = 'Token错误';

    public $errorCode = ErrorCode::TOKEN_ERROR;
}