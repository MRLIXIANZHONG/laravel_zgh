<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use Illuminate\Support\Facades\DB;
use jianyan\excel\Excel;

class IndexController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }


        public function index(){
            $menu=$this->getMenuList();
            return view('admin.index', [
                'menus' => $menu,
                'mid' => 1,
                'parent_id' => 1,
                'otherProject' => env('APP_URL'),
                'user' => $this->admininfo
            ]);
        }

        protected function getSysInfo()
        {
            $sys_info['ip'] = GetHostByName($_SERVER['SERVER_NAME']);
            $sys_info['phpv'] = phpversion();
            $sys_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
            $sys_info['time'] = date("Y-m-d H:i:s");
            $sys_info['domain'] = $_SERVER['HTTP_HOST'];
            $mysqlinfo = DB::select("SELECT VERSION() as version");
            $sys_info['mysql_version'] = $mysqlinfo[0]->version;
            return $sys_info;
        }


}