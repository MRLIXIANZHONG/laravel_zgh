<?php

namespace App\Http\Controllers\Auth;

use App\Commons\Helpers\RequestHelper;
use App\DTO\OrganizationDTO;
use App\Http\Requests\Request;
use App\Services\Sms;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;
    protected $requestHelper;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:admin_users',
            'password' => 'required',
            'units_id' => 'required',
            'name' => 'required',
            'tel' => 'required',
            'title' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm(){
        //查询工会，和企业名称
        $units=DB::table('units')->where('check_status',1)->where('deleted_at',null)->select('id','name')->get();
        return view('auth.registered',compact('units'));
    }

    //注册
    public function setRegister(Request $request){
        if ($request->isMethod('post')){

            $data=$request->post();

            //验证手机验证码
            $code=Redis::get('tel_'.$data['tel']);
            if ($code !=$data['code']){
                return array('code' => 201, 'msg' => '短信验证码错误');
            }



            //验证数据
            $this->validator($data);
            //查询工会类型
            $value['unit_type']=DB::table('units')->where("id",$data['units_id'])->value('type');
            $value['unit_id']=$data['units_id'];
            $value['username']=$data['username'];//联系人
            $value['mobile']=$data['tel'];//联系人电话
            $value['name']=$data['title'];//公司名称
            $value['password']=md5($data['password'] . env('JWT_KEY'));

            $checkuser=Count(DB::table('admin_users')->where("username",$value['username'])->get());
            if($checkuser>0)
                return array('code' => 201, 'msg' => '该用户已存在');
           //开启事务
            DB::beginTransaction();

            try{
                $org_id=DB::table('organizations')->insertGetId($value);
                //添加管理员
               $user_id= DB::table('admin_users')->insertGetId(array(
                    'username'=>$value['username'],
                    'password'=>$value['password'],
                    'name'=>$data['name'],
                    'org_id'=>$org_id,
                    'units_id'=>$value['unit_id'],
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ));
                //添加权限
                DB::table('admin_role_users')->insert(array(
                    'role_id'=>3,
                    'user_id'=>$user_id,
                ));
                //提交
             DB::commit();

                return array('code' => 200, 'msg' => '成功');

            }catch (\Exception $e){


                DB::rollBack();

                return array('code' => 201, 'msg' => '失败','error'=>$e);
            }
        }
    }

    //获取短信验证码
    public function setSms(Request $request){
        if ($request->isMethod('post')){
            $tel=$request->post('tel');

            //开启事务
           DB::beginTransaction();
            try{
                //查询短信剩余条数
                $number=DB::table('sms_env')->where('id',1)->value('number');
                if ($number <=0){
                    //抛出异常
                    throw new \Exception('没有剩余短信条数了');
                }
                //随机生成验证码
                $code=rand(1000,9999);
                Redis::setex('tel_' . $tel, 60 * 10, $code);//10分钟有效
                //发送短信
                //$result=Sms::set_sms($tel,'模板名称',$code);//发送短信
                $result=$this->getSetTel($tel,$code);

                if ($result['MessageList']['code'] == 1000){
                    //发送成功
                    //写入短信日志
                    $id=DB::table('sms_log')->insertGetId(array(
                        'tel'=>$tel,
                        'content'=>'短信验证码为:'.$code,
                        'create_time'=>$_SERVER['REQUEST_TIME'],
                    ));
                    if (!$id){
                        //抛出异常
                        throw new \Exception('插入日志失败');
                    }
                    //短信数量更改
                    DB::table('sms_env')->where('id',1)->decrement('number',1);

                }else{
                    //抛出异常
                    throw new \Exception('短信发送失败');
                }
                //提交
                DB::commit();
                return array('code' => 200, 'msg' => '成功','scode'=>$code);

            }catch (\Exception $e){

                DB::rollBack();
                return array('code' => 201, 'msg' => '失败');
            }

        }

    }

   public function getSetTel($tel=null,$code=0)
    {

        //$tel='15683408249';
        $content="你的短信验证吗为：".$code;
        $ip=$_SERVER['REMOTE_ADDR'];
        /*param.Add("phone", phoneNum);//手机号
               param.Add("otype", 10); //短信发送类型
               param.Add("siteID", 9999);//城市ID
               param.Add("userID", 0);//户型
               param.Add("userName", "");//用户名
               param.Add("tag", "【工会手机绑定】");//类型说明
               param.Add("Content", "");//短信内容
               param.Add("sign", "【重庆总工会】");//短信签名内容
               param.Add("ip", ip);//IP
               param.Add("fromType", 1);//来源 0pc 1webapp 2安卓 3ios  5微生活
               param.Add("api", 2);//短信三方接口 0 漫道 1阿里 2软维
               request.ApiName = "smssendapi";
               request.Param = StringHelper.AppServerApiParamDispost(param);
               request.Method = "SmsSendAPI_SendSmsCode";
               request.version = "4.8";
               request.Sign = "32csd44fgdwertgyusdfsd1ewwejhhalsc1z5aWea2=";*/
        $request['Param']= '"phone":"'.$tel .'","siteID":9999,"userID":0,"userName":"","tag":"【工会手机绑定】","Content":"'.$content.'","sign":"【重庆总工会】","ip":"'.$ip.'","fromType":1,"api":2,"otype":10';
        $request['Method']="SmsSendAPI_SendSmsCode";
        $request['version']="4.8";
       // $request['appName'] = "CcooCity";
        $request['ApiName'] = "smssendapi";
       // $request['customerID'] = 8003;
        $request['sign'] = '32csd44fgdwertgyusdfsd1ewwejhhalsc1z5aWea2=';
        $info=(new Sms())->GetAppServerApi($request);
      /* if($info['MessageList']['code'] == 1000){
            return $info['ServerInfo'];
        }*/
        return $info;

    }



}
