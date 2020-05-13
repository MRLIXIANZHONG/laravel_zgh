<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/5/11
 * Time: 16:01
 */

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class Jssdk
{
    private $appId;
    private $appSecret;
    private $url;
    private $noncestr;
    private $timestamp;
    public function __construct($appId, $appSecret,$url) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->url = $url;
        $this->noncestr = $this->quickRandom(10);
        $this->timestamp = time();
    }

    public function getSignaturePackage()
    {
        $accessToken = $this->getAccessToken();
        $ticket = $this->getJsapiTicket($accessToken);

        $str = "jsapi_ticket=".$ticket."&noncestr=".$this->noncestr."&timestamp=".$this->timestamp."&url=".$this->url;
        $signature = sha1($str);

        return ['appId' => $this->appId, 'noncestr' => $this->noncestr, 'timestamp' => $this->timestamp, 'signature' => $signature];
    }

    public function getAccessToken()
    {
        $client = new Client();
        $response = $client->request('GET',"https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret);
        $accessToken = json_decode($response->getBody()->getContents());

        return $accessToken->access_token;
    }

    public function getJsapiTicket($accessToken)
    {
        $client = new Client();
        $response = $client->request('GET',"https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$accessToken."&type=jsapi");
        $jsapiTicket = json_decode($response->getBody()->getContents());

        return $jsapiTicket->ticket;
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

}