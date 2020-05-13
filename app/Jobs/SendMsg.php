<?php

namespace App\Jobs;

use App\Models\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class SendMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $users;
    protected $not;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users,$not,$type)
    {
        $this->users= $users;
        $this->not=$not;
        $this->type=$type;  //后台管理员发送消息0，系统消息1
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

                $rnot=Redis::get('notifications_'.$this->users['id']);
                    if ($rnot) {
                        $rnot = json_decode($rnot, true);
                    } else {
                        $rnot = [];
                    }
                    if (empty($rnot)) {
                        $rnot = [];
                    }
                    $notsid=0;
                    if(!$this->type) {
                        if (empty(Notifications::query()->where('not_id', '=', $this->not['id'])->where('notifiable_id', '=', $this->users['id'])->first())) {
                            $notsid=Notifications::query()->insertGetId([
                                'not_id' => $this->not['id'],
                                'title'=>$this->not['title'],
                                'data' => $this->not['content'],
                                'notifiable_type'=>$this->type,
                                'admin_id' => $this->not['admin_id'],  //发送者
                                'notifiable_id' => $this->users['id'],  //接受者
                                'created_at' => date('Y-m-d H:i:s', time())
                            ]);

                        }
                    }else{
                        $notsid=Notifications::query()->insertGetId([
                            'title'=>$this->not['title'],
                            'data' => $this->not['content'],
                            'notifiable_type'=>$this->type,
                            'admin_id' => $this->not['admin_id'],  //发送者
                            'notifiable_id' => $this->users['id'],  //接受者
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);

                    }
                    if($notsid){
                        if (!in_array($notsid, $rnot)) {
                            array_push($rnot, $notsid);
                            Redis::set('notifications_' . $this->users['id'], json_encode($rnot));
                        }
                    }




    }

//    public function failed()
//    {
//        \Log::error($this->name.'队列任务执行失败'."\n".date('Y-m-d H:i:s'));
//    }
}
