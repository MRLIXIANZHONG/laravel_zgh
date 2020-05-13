<?php


namespace App\Services\Admin;


use App\DTO\WechatKetDTO;
use App\DTO\WechatReplyDTO;
use App\DTO\WechatSetingDTO;
use App\DTO\WechatUsersDTO;
use App\Exceptions\FailException;
use App\Exceptions\ParameterException;
use App\Models\WechatConfig;
use App\Models\WechatKeysSel;
use App\Models\WechatReply;
use App\Models\WechatUsers;
use App\Services\Service;
use EasyWeChat\Factory;

class WechatAdminService extends Service
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
    public function getSeting(){
        $wechat_config=new WechatConfig();
        return $wechat_config::query()->first();
    }

    public function getKeyList(WechatKetDTO $wechatKetDTO){
        $where=[];
        $wechatKeysSel=new WechatKeysSel();

        if($wechatKetDTO->getAkey()){

            array_push($where,['akey','like','%'.$wechatKetDTO->getAkey().'%']);
        }

        $status=$wechatKetDTO->getIsExe();
        if($status>0){
            array_push($where,['is_exe','=',$status]);
        }

        return $wechatKeysSel::query()->with(['reply'=>function($query){
            $query->where("msghide","=","0")->select();
        }])->where($where)->orderBy('id','desc')->paginate(15);

    }


    public function getKeyInfo($id){
        $wechatKeysSel=new WechatKeysSel();
        return $wechatKeysSel::query()->with(['reply'=>function($query){
            $query->where("msghide","=","0")->select();
        }])->where('id','=',$id)->first();
    }

    /**
     * 保存微信配置
     * @param WechatSetingDTO $wechatSetingDTO
     */
    public function store(WechatSetingDTO $wechatSetingDTO){

        $wechat_config=new WechatConfig();
        $wechat_config->app_id=$wechatSetingDTO->getAppId();
        $wechat_config->secret=$wechatSetingDTO->getSecret();
        $wechat_config->token=$wechatSetingDTO->getToken();
        $wechat_configdata=$wechat_config::query()->first();
        if($wechat_configdata) {
            $wechat_config::query()->where('app_id', '=', $wechat_config->app_id)->update([
                'app_id' => $wechat_config->app_id,
                'secret' => $wechat_config->secret,
                'token' => $wechat_config->token
            ]);
        }else{
            $wechat_config::query()->insert([
                'app_id' => $wechat_config->app_id,
                'secret' => $wechat_config->secret,
                'token' => $wechat_config->token,
            ]);
        }
    }

    public function keysave(WechatKetDTO $wechatKetDTO){
        $wechatket=new WechatKeysSel();
        $wechatket->kid=$wechatKetDTO->getKid();
        $wechatket->akey=$wechatKetDTO->getAkey();
        $wechatket->Pptype=$wechatKetDTO->getPptype();
        $wechatket->is_exe=$wechatKetDTO->getIsExe();

        if($wechatKetDTO->getId()){
            $wechatket->exists = true;
            $wechatket->id= $wechatKetDTO->getId();
            $wechatket->admin_id= $wechatKetDTO->getAdminId();
        }

        try{
            if (!$wechatket->save()) {
                throw new FailException([
                    'message'=>'保存失败'
                ]);
            }
        }catch (\Exception $e){
            throw new FailException([
                'message'=>'保存失败'
            ]);
        }

    }

    public function getReplyList(WechatReplyDTO $wechatReplyDTO=null){
        $where=[];
        $wechatReply=new WechatReply();
        if($wechatReplyDTO) {
            if ($wechatReplyDTO->getTitle()) {

                array_push($where, ['title', 'like', '%' . $wechatReplyDTO->getTitle() . '%']);
            }

            $status = $wechatReplyDTO->getMsgkind();


            if ($status) {
                $status=$status-1;
                array_push($where, ['msgkind', '=', $status]);
            }
            $res=$wechatReply::query()->where($where)->orderBy('id','desc')->paginate(15);
            foreach ($res as $rkey=>$rval){
                if($rval['msgkind']==0|| $rval['msgkind']==4 || $rval['msgkind']==5){
                    $rval['content']= mb_substr($rval['content'],0,50);
                }

            }
            return $res;
        }
        return $wechatReply::query()->where($where)->where('msghide','=',0)->orderBy('id','desc')->get()->toArray();
    }

    public function getReplyInfo($id){
        $wechatReply=new WechatReply();
        $replyInfo= $wechatReply::query()->where('id','=',$id)->first();
        if($replyInfo['msgkind']==2){
            //$replyInfo['content_video']= $this->app->material->get($replyInfo['content_mediaId'])['down_url'];
            $replyInfo['content_video']=env('APP_URL').$replyInfo['content'];
        }

        return $replyInfo;
    }


    public function getReplySave(WechatReplyDTO $wechatReplyDTO){
        $wechatReply=new WechatReply();

        $wechatReplyDTO->getTitle()&&$wechatReply->title=$wechatReplyDTO->getTitle();
        $wechatReplyDTO->getAdminId()&& $wechatReply->admin_id=$wechatReplyDTO->getAdminId();
        $wechatReplyDTO->getMsgkind()&&$wechatReply->msgkind=$wechatReplyDTO->getMsgkind();
        $wechatReplyDTO->getMsghit()&& $wechatReply->msghit=$wechatReplyDTO->getMsghit();
        $wechatReply->msghide=$wechatReplyDTO->getMsghide();
        $wechatReplyDTO->getViewLev()&&$wechatReply->view_lev=$wechatReplyDTO->getViewLev();

        if($wechatReplyDTO->getMsgkind()==4&&!$wechatReplyDTO->getContentImg()){    //判断上传图文图片不能为空

            throw new ParameterException([
                "message"=>'图文消息请上传图片'
            ]);

        }

        if($wechatReplyDTO->getMsgkind()==4&& !$wechatReplyDTO->getContentUrl()){  //判断上传图文链接不能为空
            throw new ParameterException([
                "message"=>'图文消息请填写链接地址'
            ]);
        }

        $wechatReply->content_url=$wechatReplyDTO->getContentUrl();

        if($wechatReplyDTO->getId()) {   //修改
            $replyInfo = $wechatReply::query()->where('id', '=', $wechatReplyDTO->getId())->first();
            if($replyInfo['content']!=$wechatReplyDTO->getContent()){    //如果内容有变化
                $wechatReplyDTO->getContent()&&$wechatReply->content=$wechatReplyDTO->getContent();  //修改内容
            }
            if($wechatReplyDTO->getMsgkind()==4 && $replyInfo['content_img']!=$wechatReplyDTO->getContentImg()) {  //如果图文中图片有变化
                $wechatReplyDTO->getContentImg() && $wechatReply->content_img = $wechatReplyDTO->getContentImg();
            }
        }else{   //新增
            $wechatReplyDTO->getContent()&&$wechatReply->content=$wechatReplyDTO->getContent();
            $wechatReplyDTO->getContentImg() && $wechatReply->content_img = $wechatReplyDTO->getContentImg();
        }

        if($wechatReply->content){   //如果有内容就上传素材
            if($wechatReplyDTO->getMsgkind()==1||$wechatReplyDTO->getMsgkind()==2||$wechatReplyDTO->getMsgkind()==3){
                $wechatReply->content_mediaId=$this->uploadWx($wechatReplyDTO->getMsgkind() ,$wechatReplyDTO->getContent(),$wechatReplyDTO->getTitle());
            }

        }

        if($wechatReplyDTO->getMsgkind()==4&&$wechatReply->content_img){  //如果有图文上传就上传素材
            $wechatReply->content_mediaId=$this->uploadWx($wechatReplyDTO->getMsgkind() ,$wechatReplyDTO->getContentImg());
        }



        if($wechatReplyDTO->getId()){
            $wechatReply->id=$wechatReplyDTO->getId();
            $wechatReply->exists=true;
        }


        try{
            if (!$wechatReply->save()) {
                throw new FailException([
                    'message'=>'保存失败'
                ]);
            }
        }catch (\Exception $e){
            throw new FailException([
                'message'=>'保存失败'
            ]);
        }

    }


    public function uploadWx($msgkind,$content,$title=''){

        $material = $this->app->material;
        if($msgkind==0||$msgkind==5){
            return $content;
        }else if($msgkind==1){
            $result = $material->uploadImage($content);
            if(!isset($result['media_id'])){
                throw new FailException([
                    'message'=>$result['errmsg']
                ]);
            }
            return $result['media_id'];
        }else if($msgkind==2){
            $result = $material->uploadVideo($content,$title,$title);
            if(!isset($result['media_id'])){
                throw new FailException([
                    'message'=>$result['errmsg']
                ]);
            }
            return $result['media_id'];
        }else if($msgkind==3){
            $result = $material->uploadVoice($content);
            if(!isset($result['media_id'])){
                throw new FailException([
                    'message'=>$result['errmsg']
                ]);
            }
            return $result['media_id'];
        }else if($msgkind==4){
            $result = $material->uploadImage($content);
            if(!isset($result['media_id'])){
                throw new FailException([
                    'message'=>$result['errmsg']
                ]);
            }
            return $result['media_id'];
        }else{
            return $content;
        }


    }

    public function destroy($id){
        $wechatKeysSel = new WechatKeysSel();
        $wechatKeysSel->id = $id;
        $wechatKeysSel->exists = true;
        if($wechatKeysSel->delete())return true;
    }

    public function wxUserList(WechatUsersDTO $wechatUsersDTO){
        $where=[];
        $wechatUsers=new WechatUsers();

        if($wechatUsersDTO->getNickname()){
            array_push($where,['nickname','like','%'.$wechatUsersDTO->getNickname().'%']);
        }

        return $wechatUsers::query()->where($where)->orderBy('id','desc')->paginate(15);
    }



}