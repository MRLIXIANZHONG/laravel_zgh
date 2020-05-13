<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 19:35
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class StateMachine extends Command
{
    protected $signature = "status:update";

    protected $description = "调控系统数据的状态转化";

    public function handle()
    {
        $time = date('Y-m-d', time());
        $lives = DB::table('rloud_live')->where('type', 1)->where('end_time', '<', $time)->get();
        DB::table('rloud_live')->whereIn('id', $lives->pluck('id'))->update([
            'type' => 3,
        ]);
    }
}