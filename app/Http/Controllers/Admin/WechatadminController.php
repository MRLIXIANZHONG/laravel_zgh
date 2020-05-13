<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\WechatKetDTO;
use App\DTO\WechatReplyDTO;
use App\DTO\WechatSetingDTO;
use App\DTO\WechatUsersDTO;
use App\Exceptions\FailException;
use App\Http\Requests\Admin\WechatadminRequest;
use App\Services\UploadsService;

class WechatadminController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function getSeting(){
       $set= ServiceHelper::make('Admin\WechatAdminService')->getSeting();
       return view('wechat.setting',['system'=>$set]);

    }

    public function getKeyList(WechatadminRequest $wechatadminRequest){

        $dto = $this->requestHelper->makeDTO(WechatKetDTO::class, $wechatadminRequest);
        $list= ServiceHelper::make('Admin\WechatAdminService')->getKeyList($dto);
        request()->flash();
//        $list=json_decode(json_encode($list),true);
        return view('wechat.keyview',['list'=>$list]);

    }

    public function edit($id){
        $info= ServiceHelper::make('Admin\WechatAdminService')->getKeyInfo($id);
        $reply= ServiceHelper::make('Admin\WechatAdminService')->getReplyList();
        return view('wechat.edit',['info'=>$info,'id'=>$id,'reply'=>$reply]);
    }

    public function save(WechatadminRequest $wechatadminRequest){
        $dto = $this->requestHelper->makeDTO(WechatSetingDTO::class, $wechatadminRequest);
        ServiceHelper::make('Admin\WechatAdminService')->store($dto);
        return ['code'=>1000,'message'=>'保存成功'];
    }

    public function keysave(WechatadminRequest $wechatadminRequest){
        $dto = $this->requestHelper->makeDTO(WechatKetDTO::class, $wechatadminRequest);
        $dto->setAdminId($this->admininfo['id']);
        ServiceHelper::make('Admin\WechatAdminService')->keysave($dto);
        return ['code'=>1000,'message'=>'保存成功'];
    }

    public function replylist(WechatadminRequest $wechatadminRequest){
        $dto = $this->requestHelper->makeDTO(WechatReplyDTO::class, $wechatadminRequest);
        $list= ServiceHelper::make('Admin\WechatAdminService')->getReplyList($dto);
        request()->flash();
        return view('wechat.replylistview',['list'=>$list]);
    }

    public function replyedit($id){
        $info= ServiceHelper::make('Admin\WechatAdminService')->getReplyInfo($id);
        return view('wechat.replyedit',['info'=>$info,'id'=>$id]);
    }

    public function replysave(WechatadminRequest $wechatadminRequest){
        $dto = $this->requestHelper->makeDTO(WechatReplyDTO::class, $wechatadminRequest);
        $dto->setAdminId($this->admininfo['id']);
        $info= ServiceHelper::make('Admin\WechatAdminService')->getReplySave($dto);
        return ['code'=>1000,'message'=>"保存成功"];

    }

    public function adminWechatUpload(WechatadminRequest $wechatadminRequest) {
        $uploads= new UploadsService();
        $file=$wechatadminRequest->file('file');
        $url_path = 'uploads/wechat';
        $namePath=$uploads->upload($file,$url_path);

        return ['code'=>1000,'message'=>'上传成功','url'=>$namePath];

    }

    public function destroy($id){
        if(empty($id)){
            throw new FailException(['message'=>'缺失必要参数']);
        }
        ServiceHelper::make('Admin\WechatAdminService')->destroy($id);
        return ['code'=>1000,'message'=>'删除成功'];
    }


    public function wechatUserList(WechatadminRequest $wechatadminRequest){
        $dto = $this->requestHelper->makeDTO(WechatUsersDTO::class, $wechatadminRequest);
        $list=ServiceHelper::make('Admin\WechatAdminService')->wxUserList($dto);
        request()->flash();
        return view('wechat.wxuserlistview',['list'=>$list]);
    }

}