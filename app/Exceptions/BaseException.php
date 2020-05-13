<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/4/28 0028
 * Time: 15:55
 * Class BaseException
 */

namespace App\Exceptions;


class BaseException extends \Exception
{
    public $code = 400;

    public $message = 'invalid parameters';

    public $errorCode = ErrorCode::SERVER_ERROR;

    /**
     * Note:构造函数，接收一个关联数组
     * @User: Hu
     * @Date: 2019/1/3
     * @Time: 12:00
     * @Email:huyang61@qq.com
     * BaseException constructor.
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('message', $params)) {
            $this->message = $params['message'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }

}