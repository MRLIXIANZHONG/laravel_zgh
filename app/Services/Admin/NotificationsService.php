<?php


namespace App\Services\Admin;


use App\DTO\NotificationsDTO;
use App\Exceptions\FailException;
use App\Jobs\SendMsg;
use App\Models\AdminUsers;
use App\Models\NotificationList;
use App\Models\Notifications;
use App\Services\Service;

class NotificationsService extends Service
{
    public function notificationList(NotificationsDTO $notificationsDTO){
       $notification_list=new NotificationList();
       $where=[];
       $title=$notificationsDTO->getTitle();
       if($title){
           array_push($where,['title','like','%'.$title.'%']);
       }
       $status=$notificationsDTO->getStatus();
        if($status>0){
            array_push($where,['status','=',$status]);
        }


       $res= $notification_list->with(['users'=>function($query){
           $query->select('admin_users.id','admin_users.username');
       }])->withCount(['read_notifications'=>function($querys){
            $querys->where('notifications.read_at','!=',null);
        }])->withCount('notifications')->where($where)->paginate(15);
        //dd(json_decode(json_encode($res),true));
        return $res;
    }


    public function notificationInfo($id){
        $notification_list=new NotificationList();

        $res= $notification_list->with(['users'=>function($query){
            $query->select('admin_users.id','admin_users.username');
        }])->with(['read_notifications'=>function($querys){
            $querys->where('notifications.read_at','!=',null);
        }])->with('notifications')->where("id","=",$id)->first();
        return $res;
    }

    public function notificationRedList($id){
        $notifications=new Notifications();
        return $notifications->with('busers')->with('organizations')->where('not_id','=',$id)->where('read_at','!=',null)->paginate(15);

    }

    public function save(NotificationsDTO $notificationsDTO){
            $notifications=new NotificationList();
            $notifications->title=$notificationsDTO->getTitle();
            $notifications->content=$notificationsDTO->getContent();
            $notifications->admin_id=$notificationsDTO->getAdminId();
           if($notificationsDTO->getId()){
               $notifications->id=$notificationsDTO->getId();
               $notifications->exists=true;
           }

        try{
            if (!$notifications->save()) {
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

    public function sendmsg(NotificationsDTO $dto){
        $toArray=json_decode($dto->getToarray(),true);
        $user=AdminUsers::query()->whereIn('id',$toArray)->get()->toArray();
        $id=$dto->getId();
        $not=NotificationList::query()->where("id","=",$id)->first();
        foreach ($user as $key =>$val) {
            $this->dispatch(new SendMsg($val, $not,0));
        }
        NotificationList::query()->where("id","=",$id)->update([
            'send_at'=>date("Y-m-d H:i:s",time()),
            'status'=>2
        ]);
    }

    public function myNotification($data){
            $dto=$data[0];
            $title=$dto->getTitle();
            $where=[];

            $status=$dto->getStatus();
            if($status==1){
                array_push($where,['read_at','!=',null]);
            }

            if($status==2){
                array_push($where,['read_at','=',null]);
            }
            if($title){
                array_push($where,['title','like','%'.$title.'%']);
            }
                $info = Notifications::query()->with(['users' => function ($query) {
                    $query->select('admin_users.id', 'admin_users.username');
                }])->where($where)->where('notifiable_id',$data[1])->orderByDesc('id')->paginate(15);


           return $info;
    }

    public function notificationInfoBySee($parr){
        $id=$parr[0];
        $uid=$parr[1];
        $read=$parr[2];
        $notification=new Notifications();
        if($read>0){
            Notifications::query()->where('id','=',$id)->where('notifiable_id','=',$uid)->update([
            'read_at'=>date("Y-m-d H:i:s",time())
            ]);
        }


        $res= $notification->with(['users'=>function($query){
            $query->select('admin_users.id','admin_users.username');
        }])->where("id","=",$id)->where('notifiable_id','=',$uid)->first();

        return $res;
    }


}