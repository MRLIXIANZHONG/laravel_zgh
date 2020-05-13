<?php


namespace App\Http\Controllers\Admin;

use App\Exceptions\ErrorException;
use App\Exceptions\FailException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\TokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\AdminRoles;
use App\Models\AdminUsers as AdminUserModle;
use App\Models\Notifications;
use Illuminate\Support\Facades\Cookie;
use DB;

class BaseController extends Controller
{
    protected $admininfo;

    protected function __construct()
    {
        $controller=request()->route()->getAction()['controller'];

        if(!empty(request()->all()['getActionByAdmin'])){
        }
        $decrypted=$this->getCookie('admininfo');
        if(empty($decrypted)){
            $this->errorOut();
        }

        try{
            $this->admininfo=json_decode($decrypted,true);
        }catch (\Exception $e){
                $this->errorOut();
        }
    

        if(!$this->hasPressiosn($controller)){

            if(request()->method()=='GET'){

                redirect('/admin/error')->send();
                exit;

            }
            throw new FailException([
                'message'=>'您暂时没有权限'
            ]);
        }


    }

    /**
     * 获取cookie
     * @param $cookiename
     * @return string
     */
    public function getCookie($cookiename){
        $admininfo=Cookie::get($cookiename);
        $payload = $admininfo;
        $key = env('APP_KEY');
        $secret_type = config("app.cipher");
        $payload = json_decode(base64_decode($payload), true);
        $iv = base64_decode($payload['iv']);
        $key = base64_decode(substr($key, 7));
        $decrypted = \openssl_decrypt($payload['value'], $secret_type, $key, 0, $iv);
        return $decrypted;
    }

    /**
     * 退出登陆
     * @throws TokenException
     */
    public function errorOut(){
        $request=new Request();
        if($request->method()=='GET'){
            redirect('/admin/login')->send();
            exit;
        }

        throw new TokenException([
            'message'=>'登录过期'
        ]);
    }

    public function hasPressiosn($controller){

        $adminRoles=new AdminRoles();
        $adminUser=new AdminUserModle();
        $adminUser->id=$this->admininfo['id'];
        $adminRoles->id=$this->admininfo['role_id'];
        return $adminRoles->hasPermissions($controller);
    }

    public function  getMenuList(){
        $adminRoles=new AdminRoles();
        $adminUser=new AdminUserModle();
        $adminUser->id=$this->admininfo['id'];
        $adminRoles->id=$this->admininfo['role_id'];
        $adminRolesArr=$adminRoles->menus()->get()->toArray();
        $newMenuList=[];
        foreach ($adminRolesArr as $key => $val){
            if($val['parent_id']==0){
                array_push($newMenuList,$val);
            }
        }
        foreach ($newMenuList as $mkey=>$mval){
            $newMenuList[$mkey]['children']=[];
            foreach ($adminRolesArr as $akey => $aval){
                if($aval['parent_id']==$mval['id']){
                    $newMenuList[$mkey]['children'][]=$aval;
                }
            }
        }

       return $newMenuList;

    }

    public function getNotList(){
        $count=0;
        if($this->admininfo['id']) {
            $count = Notifications::query()->where("notifiable_id", $this->admininfo['id'])->where('read_at', '=', null)->count();
        }
        return $count;

    }

    public function checkAuth()
    {
        if ($this->admininfo['roles'][0]['id'] == 2) {
            $info = DB::table('units')->where('id',$this->admininfo['units_id'])->first();
            if ($info->check_status != 1) {
                throw new ErrorException('您的申报还未审核,请耐心等待审核');
            }
        } elseif ($this->admininfo['roles'][0]['id'] == 3) {
            $info = DB::table('organizations')->where('id',$this->admininfo['org_id'])->first();
            if ($info->check_state != 2) {
                throw new ErrorException('您的申报还未审核,请耐心等待审核');
            }
        }
    }

    public function wxCheck(?array $arr)
    {
        if (!isset($arr['openid'])) {
            return false;
        }
        $wxUser = DB::table("wx_cusers")->where('openid', $arr['openid'])->first();

        if (!$wxUser) {
            return false;
        }

        return true;
    }

}