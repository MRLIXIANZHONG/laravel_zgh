<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\NotificationsDTO;
use App\Http\Requests\Admin\NotificationsRequest;
use Illuminate\Support\Facades\Redis;

class NotificationsController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(NotificationsRequest $notificationsRequest){
        $dto = $this->requestHelper->makeDTO(NotificationsDTO::class, $notificationsRequest);
        $data= ServiceHelper::make('Admin\NotificationsService')->notificationList($dto);

        request()->flash();
        return view('notifications.list', [
            'list' => $data
        ]);
    }

    public function edit($id){
        $info= ServiceHelper::make('Admin\NotificationsService')->notificationInfo($id);
        return view('notifications.edit', [
            'info' => $info,
            'id'=>$id
        ]);
    }

    public function smsedit($id){
        $info= ServiceHelper::make('Admin\NotificationsService')->notificationInfo($id);
        return view('notifications.smsedit', [
            'info' => $info,
            'id'=>$id
        ]);
    }

    public function getAdminUserList($id){
        $list= ServiceHelper::make('Admin\AdminUserService')->getAdminUsersAll();
        $info= ServiceHelper::make('Admin\NotificationsService')->notificationInfo($id);
        $res=[];
        foreach ($list as $key=>$val){
            if($list[$key]['organization']) {
                $list[$key]['title'] = $list[$key]['organization']['name'];
            }else{
                $list[$key]['title'] = $list[$key]['name'];
            }
            $list[$key]['checked']=false;
            foreach ($info->notifications as $nkey => $nval){
                if($nval->notifiable_id==$val['id']){
                    $list[$key]['checked']=true;
                }
            }
            array_push($res,['title'=>$list[$key]['title'],'id'=>$val['id'],'checked'=>$list[$key]['checked']]);
        }
        return ['code'=>1000,'data'=>$res,'message'=>'操作成功！'];
    }

    public function sendmsg(NotificationsRequest $notificationsRequest){
        $dto = $this->requestHelper->makeDTO(NotificationsDTO::class, $notificationsRequest);
        $dto->setAdminId($this->admininfo['id']);
        ServiceHelper::make('Admin\NotificationsService')->sendmsg($dto);
        return ['code'=>1000,'message'=>'操作成功！'];

    }

    public function save(NotificationsRequest $notificationsRequest){
        $dto = $this->requestHelper->makeDTO(NotificationsDTO::class, $notificationsRequest);
        $dto->setAdminId($this->admininfo['id']);
        ServiceHelper::make('Admin\NotificationsService')->save($dto);
        return ['code'=>1000,'message'=>'操作成功！'];
    }


    public function readlist($id){
        $data= ServiceHelper::make('Admin\NotificationsService')->notificationRedList($id);
        request()->flash();
        return view('notifications.read', [
            'list' => $data
        ]);
    }

    public function getmynnot(){

        $read=[];
        $rnot=[];
        $reads=Redis::get("read_nnotifications_".$this->admininfo['id']);
        $rnots=Redis::get('notifications_'.$this->admininfo['id']);
        if($rnots) {
            $rnot = json_decode($rnots, true);
        }

        if($reads) {
            $read = json_decode($reads, true);

        }

        foreach ($rnot as $rnkey=>$rnval){
            foreach ($read as $rekey=>$reval){
                if($rnval==$reval){
                    unset($rnot[$rnkey]);
                }
            }
        }

        $rnot = array_values($rnot);

        $info =[];

        if(!empty($rnot)) {
            $read=[];
            $reads=Redis::get("read_nnotifications_".$this->admininfo['id']);
            if($reads) {
                $read = json_decode($reads, true);
            }
            if(!in_array($rnot[0],$read)){
                array_push($read,$rnot[0]);
                Redis::set("read_nnotifications_".$this->admininfo['id'],json_encode($read));
            }

            $info = ServiceHelper::make('Admin\NotificationsService')->notificationInfoBySee([$rnot[0],$this->admininfo['id'],0]);
        }


        $nots=$this->getNotList();

        return ['code'=>1000,'message'=>'操作成功！','data'=>$info,'rnot'=>$rnots,'read'=>$read,'count'=>$nots];

    }

    public function mynot(NotificationsRequest $notificationsRequest){
        $dto = $this->requestHelper->makeDTO(NotificationsDTO::class, $notificationsRequest);
        $msg=[];
        if($this->admininfo['id']){

            $msg = ServiceHelper::make('Admin\NotificationsService')->myNotification([$dto,$this->admininfo['id']]);
        }
        request()->flash();

        return view('notifications.mynot', [
            'list' => $msg
        ]);


    }

    public function notinfo($id){
        $uid=$this->admininfo['id'];
        $read=1;
        $info= ServiceHelper::make('Admin\NotificationsService')->notificationInfoBySee([$id,$uid,$read]);
        return view('notifications.notinfo', [
            'info' => $info,
            'id'=>$id
        ]);
    }
//
//    public function sysnotinfo($id){
//        $uid=$this->admininfo['org_id'];
//        $info= ServiceHelper::make('Admin\NotificationsService')->notificationInfoBySee([$id,$uid]);
//        return view('notifications.notinfo', [
//            'info' => $info,
//            'id'=>$id
//        ]);
//    }
}