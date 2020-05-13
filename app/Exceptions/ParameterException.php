<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/5/5 0005
 * Time: 9:51
 * Class ParameterException
 */

namespace App\Exceptions;


class ParameterException extends BaseException
{
    public $code = 400;

    public $message = '参数异常';

    public $errorCode = ErrorCode::PARAMETER_ERROR;
}