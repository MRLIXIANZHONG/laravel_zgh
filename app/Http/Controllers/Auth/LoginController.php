<?php

namespace App\Http\Controllers\Auth;

use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\AdminUsersDTO;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.max' => '登录账号不能为空',
            'password.required'  => '密码不能为空',
        ]);
        //dd($request->all());
        //检验验证码
        $code=$request->input('loginCode');
//        if (strtolower($code) !=strtolower(session()->get('CAPTCHA_IMG'))){
//            $request->flash();
//            return back()->withErrors('验证码错误');
//        }


        $dto = $this->requestHelper->makeDTO(AdminUsersDTO::class, $request);
        $res = ServiceHelper::make('Admin\AuthService')->authLogin($dto);
        if($res['code']!=1000){
            $request->flash();
            return back()->withErrors($res['msg']);
        }else{
            Cookie::queue('admininfo', json_encode($res['data']), 10*60*3);
            ServiceHelper::make('Admin\AuthService')->authRedisPermissions($res['data']['id']);
            //redirect('/admin/index')->send();
             return redirect('/admin/index');
        }
    }

    public function logout(Request $request)
    {
//        Cookie::forget('admininfo');
        Cookie::queue(Cookie::forget('admininfo'));
        return redirect('/admin/login');
    }

    /**
     * 设置并输出图片
     */
    public function getCaptcha()
    {

        $phrase = new PhraseBuilder();
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象,配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色25,25,112
        $builder->setBackgroundColor(25, 25, 112);
        // 设置倾斜角度
        $builder->setMaxAngle(25);
        // 设置验证码后面最大行数
        $builder->setMaxBehindLines(10);
        // 设置验证码前面最大行数
        $builder->setMaxFrontLines(10);
        // 设置验证码颜色
        $builder->setTextColor(255, 255, 0);
        // 可以设置图片宽高及字体
        $builder->build($width = 150, $height = 40, $font = null);

        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        session()->put('CAPTCHA_IMG', $phrase);

        // 生成图片
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }

}
