<?php

namespace App\Console\Commands;

use App\Commons\Helpers\ServiceHelper;
use App\Models\AdminUsers;
use App\Models\Organization;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:myconmmand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
//        $param1 = $this->argument('param1'); // 不指定参数名的情况下用argument
//        $param2 = $this->option('param2'); // 用--开头指定参数名


        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, 1000);

        $this->info("开始查询");
        $data= ServiceHelper::make('Admin\AuthService')->getOTO();
        $this->info("查询完毕，开始执行导入");
       foreach ($data as $key =>$val){

           if(!AdminUsers::query()->where('username',$val['username'])->limit([1,10])->get()->toArray()){
               $adminUsersmodel=new AdminUsers();
               $userid=$adminUsersmodel->query()->insertGetId([
                   'username'=>$val['username'],
                   'name'=>$val['name'],
                   'password'=>$val['password'],
                   'org_id'=>$val['id'],
                   'units_id'=>$val['unit_id'],
                   'system_version'=>'cqzgh',
               ]);
               $adminUsersmodel->id=$userid;
               $adminUsersmodel->saveRoles(3);
           }

           $progressBar->advance();
       }
        $progressBar->finish();
        echo "\n";

    }
}
