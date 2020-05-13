<?php


namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Craftsman;
use App\Models\Nominee;
use App\Models\OrganizationsPlan;
use App\Models\OrganizationsWuxiao;
use App\Models\WechatConfig;
use App\Models\WechatKeysSel;
use App\Models\WechatUsers;
use App\Services\Jssdk;
use App\Services\UploadsService;
use EasyWeChat\Kernel\Messages\Article;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;
use Illuminate\Support\Facades\Redis;
use EasyWeChat\Factory;

class WechatController extends Controller
{
    protected $app;
    public function __construct(){
        $wechat_config=WechatConfig::query();
        $wechatconfig_data = $wechat_config->first();
        $config = [
            'app_id' => $wechatconfig_data['app_id'],
            'secret' =>  $wechatconfig_data['secret'],
            'token'=>$wechatconfig_data['token'],
            'aes_key' => $wechatconfig_data['aes_key'],
        ];
        $this->app= Factory::officialAccount($config);
    }
    public function serve()
    {

        $that=$this;
        $this->app->server->push(function($message) use ($that){
            $openid=$message['FromUserName'];
            $that->saveUser($openid);
            if($message['MsgType']=='text'){
                return  $that->getKey($message['Content'],$openid);
            }elseif($message['MsgType']=='event'){


                if($message['Event']=='subscribe'){
                    return "欢迎关注oocc!";
                }
                if($message['Event']=='unsubscribe'){
                    $that->delUser($openid);
                    $myfile = fopen("newfile.txt", "w");
                    fwrite($myfile, 'xxxx'.$openid);
                }

            }else{
                return "不太明白您的意思！";
            }


        });
        return $this->app->server->serve();
    }


    public function saveUser($openid){
        //  $openid=Redis::get('openid');
        //$app = app('wechat.official_account');
        $userService=$this->app->user;
        $user = $userService->get($openid);
        $wxusers=new WechatUsers();
        $is_data=$wxusers::query()->where('openid','=',$openid)->first();
        if($is_data){
            $wxusers::query()->where('openid','=',$openid)->update([
                'isdel'=>$user['subscribe'],
                'nickname'=>$user['nickname'],
                'sex'=>$user['sex'],
                'lgg'=>$user['language'],
                'city'=>$user['city'],
                'province'=>$user['province'],
                'country'=>$user['country'],
                'headimgurl'=>$user['headimgurl'],
                'updated_at'=>date('Y-m-d H:i:s',time())

            ]);
        }else{
            $wxusers::query()->insert([
                'isdel'=>$user['subscribe'],
                'openid'=>$openid,
                'nickname'=>$user['nickname'],
                'sex'=>$user['sex'],
                'lgg'=>$user['language'],
                'city'=>$user['city'],
                'province'=>$user['province'],
                'country'=>$user['country'],
                'headimgurl'=>$user['headimgurl'],
                'created_at'=>date('Y-m-d H:i:s',time())
            ]);
        }
        Redis::set('user',json_encode($user));
    }

    public function getUserInfo(){
        dd(Redis::get('user'));
    }


    public function delUser($openid){
        $wxusers=new WechatUsers();
        $is_data=$wxusers::query()->where('openid','=',$openid)->first();
        if($is_data){
            $wxusers::query()->where('openid','=',$openid)->update([
                'isdel'=>0,
            ]);
        }
    }


    public function upload(Request $request){
        $material = $this->app->material;
        $uploads= new UploadsService();
        $file=$request->file('file');

        $url_path = 'uploads/wechat';
        $namePath=$uploads->upload($file,$url_path);
        $result = $material->uploadImage($namePath);  // 请使用绝对路径写法！除非你正确的理解了相对路径（好多人是没理解对的）！

    }


    public function getSpecialKey($key,$openid){
        $type=substr($key , 0 , 2);

        switch ($type)
        {
            case 'wx':
                preg_match("/wx(?<right>.*)/", $key, $matches);
                $id=trim($matches['right'])*1;
                //return $id;
                $data=OrganizationsWuxiao::query()->where('id','=',$id)->first();
                if(empty($data)){
                    return [];
                }
                $items = [
                    new NewsItem([
                        'title'       => '快来投票吧！ '.$data['plan_name'],
                        'description' => $data['plan_name'],
                        'url'         => 'xxxxxxxxxxxx'.'?id='.$id.'&openid='.$openid,
                        'image'       => env('APP_URL').$data['img_url'],
                    ]),
                ];
                return new News($items);

                break;
            case 'yx':
                preg_match("/yx(?<right>.*)/", $key, $matches);
                $id=trim($matches['right'])*1;
                $data=Nominee::query()->where('id','=',$id)->first();
                if(empty($data)){
                    return [];
                }
                $items = [
                    new NewsItem([
                        'title'       => '快来投票吧！ '.$data['staff_name'],
                        'description' => $data['staff_name'],
                        'url'         => 'xxxxxxxxxxxx'.'?id='.$id.'&openid='.$openid,
                        'image'       => env('APP_URL').$data['staff_img'],
                    ]),
                ];
                return new News($items);
                break;
            case 'fa':
                preg_match("/fa(?<right>.*)/", $key, $matches);
                $id=trim($matches['right'])*1;
                $data=OrganizationsPlan::query()->where('id','=',$id)->first();
                if(empty($data)){
                    return [];
                }
                $items = [
                    new NewsItem([
                        'title'       => '快来投票吧！ '.$data['plan_name'],
                        'description' => $data['plan_name'],
                        'url'         => 'xxxxxxxxxxxx'.'?id='.$id.'&openid='.$openid,
                        'image'       => env('APP_URL').$data['img_url'],
                    ]),
                ];
                return new News($items);
                break;
            case 'by':
                preg_match("/by(?<right>.*)/", $key, $matches);
                $id=trim($matches['right'])*1;
                $data=Craftsman::query()->where('id','=',$id)->first();
                if(empty($data)){
                    return [];
                }
                $items = [
                    new NewsItem([
                        'title'       => '快来投票吧！ '.$data['username'],
                        'description' => $data['username'],
                        'url'         => 'xxxxxxxxxxxx'.'?id='.$id.'&openid='.$openid,
                        'image'       => env('APP_URL').$data['photo'],
                    ]),
                ];
                return new News($items);
                break;
            default:
                return [];
        }

    }


    public function getKey($key,$openid){
        $res=$this->getSpecialKey($key,$openid);
        if(!empty($res)){
            return $res;
        }
        $where1=[];
        $where2=[];
        array_push($where1,['akey','=',$key]);
        array_push($where1,['Pptype','=',0]);
        array_push($where2,['akey','like','%'.$key.'%']);
        array_push($where2,['Pptype','=',1]);
        $wechatKeysSel=new WechatKeysSel();
        // $wechatKeysSel::query()->with('')->where()->orWhere()->first();
        $keydata=$wechatKeysSel::query()->with(['reply'=>function($query){
            $query->where("msghide","=","0")->select();
        }])->where('akey','=',$key)->where($where1)->orWhere($where2)->first();

        if(empty($keydata)){
            return "不太明白您的意思！";
        }

        if(empty($keydata['reply'])){
            return "不太明白您的意思！";
        }

        if($keydata['reply']['msgkind']==0){
            return $keydata['reply']['content'];
        }

        if($keydata['reply']['msgkind']==1){
            return new Image($keydata['reply']['content_mediaId']);
        }

        if($keydata['reply']['msgkind']==2){
            return new Video($keydata['reply']['content_mediaId'], [
                'title' => $keydata['reply']['title'],
                'description' => $keydata['reply']['title'],
            ]);
        }

        if($keydata['reply']['msgkind']==3){
            return new Voice($keydata['reply']['content_mediaId']);
        }

        if($keydata['reply']['msgkind']==4){
            $items = [
                new NewsItem([
                    'title'       => $keydata['reply']['title'],
                    'description' => $keydata['reply']['content'],
                    'url'         => $keydata['reply']['content_url'].'?openid='.$openid,
                    'image'       => env('APP_URL').$keydata['reply']['content_img'],
                ]),
            ];
            return new News($items);
        }

        if($keydata['reply']['msgkind']==5){
            return new Article([
                'title'   =>  $keydata['reply']['title'],
                'author'  => 'oocc',
                'content' => $keydata['reply']['content'],
            ]);

        }
    }

    public function getJsSdk(Request $request)
    {
//        Redis::setex('http://zghyd.hd3360.com/bygj/craftsman_detail.html?id=2', 8, 8995);
//        dd(Redis::get('http://zghyd.hd3360.com/bygj/craftsman_detail.html?id=2'));
        $url = $request->get('url');
        $weChatConfig = WechatConfig::query()->first();
        $wxInfo = new Jssdk($weChatConfig->app_id, $weChatConfig->secret, $url);
        $result = $wxInfo->getSignaturePackage();

        return response()->json(['wxInfo' => $result, 'code' => 1000]);
    }
}