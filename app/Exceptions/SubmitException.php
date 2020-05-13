<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/5/5 0005
 * Time: 9:35
 * Class LeaderException
 */

namespace App\Exceptions;


/**
 * Note:审核表异常
 * Think:
 * User: HuYang-BJB
 * Date: 2019/5/5 0005
 * Time: 9:35
 * @package App\Exceptions
 */
class SubmitException extends BaseException
{
    public $code = 400;

    public $message = '审核异常';

    public $errorCode = ErrorCode::SUBMIT_ERROR;
}