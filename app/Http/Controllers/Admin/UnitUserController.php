<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/27
 * Time: 0:29
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;

class UnitUserController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}