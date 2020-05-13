<?php
/**
 * Note:
 * Think:
 * User: HuYang-BJB
 * Date: 2019/4/28 0028
 * Time: 16:15
 * Class ErrorCode
 */

namespace App\Exceptions;

/**
 * Note:错误状态码
 * Think:
 * User: HuYang-BJB
 * Date: 2019/4/28 0028
 * Time: 16:15
 * @package App\Exceptions
 */
class ErrorCode
{
    const SERVER_ERROR = 500;

    //token异常
    const TOKEN_ERROR = 600;

    //token未设置
    const TOKEN_NOT_SET = 601;

    //token为空
    const TOKEN_IS_NULL = 602;
    //token过期
    const TOKEN_IS_EXPIRED = 603;
    //参数异常
    const PARAMETER_ERROR = 604;

    //参赛集体异常
    const ORGANIZATION_ERROR = 700;

    //方案领导异常
    const LEADER_ERROR = 800;

    //方案员工异常
    const STAFF_ERROR = 900;

    //审核异常
    const SUBMIT_ERROR = 1000;

    //推荐错误
    const NOMINEE_ERROR = 1100;
	
	const PRESSIONS_ERROR=400;
}