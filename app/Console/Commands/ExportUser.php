<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/5/6
 * Time: 14:50
 */

namespace App\Console\Commands;


use App\Models\AdminUsers;
use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Console\Command;
use DB;

class ExportUser extends Command
{
    protected $signature = 'user_data:export';

    protected $description = '将工会企业帐号导入到用户表';

    protected $unitAdminUser = [];

    protected $organizationAdminUser = [];

    protected $adminRoleUsers = [];

    public function handle()
    {
        $time = date('Y-m-d H:i:s', time());
        $organizations = Organization::query()->where('unit_id','!=',0)
            ->where('id', '!=', 3)->get();
        $units = Unit::query()->get();

        $zghAdminUser = new AdminUsers();
        $zghAdminUser->username = 'zonggonghui';
        $zghAdminUser->password = md5('123456'.env('JWT_KEY'));
        $zghAdminUser->name = '重庆市总工会';
        $zghAdminUser->created_at = $time;
        $zghAdminUser->updated_at = $time;
        $zghAdminUser->system_version = 'cqzgh';
        $zghAdminUser->save();

        DB::table('admin_role_users')->insert([
            'role_id' => 4,
            'user_id' => $zghAdminUser->id,
        ]);

        foreach ($units as $key => $unit) {
            $unitAdminUser = new AdminUsers();
            $unitAdminUser->username = $unit->username;
            $unitAdminUser->password = md5('123456'.env('JWT_KEY'));
            $unitAdminUser->name = $unit->name;
            $unitAdminUser->avatar = $unit->photo;
            $unitAdminUser->created_at = $time;
            $unitAdminUser->updated_at = $time;
            $unitAdminUser->system_version = 'cqzgh';
            $unitAdminUser->units_id = $unit->id;
            $unitAdminUser->save();

            DB::table('admin_role_users')->insert([
                'role_id' => 2,
                'user_id' => $unitAdminUser->id,
            ]);

            $this->info($unitAdminUser->id.': insert finished');
        }

        $this->info('unit insert finished');
        foreach ($organizations as $key => $organization) {
            $organizationAdminUser = new AdminUsers();
            $organizationAdminUser->username = $organization->username;
            $organizationAdminUser->password = md5('123456'.env('JWT_KEY'));
            $organizationAdminUser->name = $organization->name;
            $organizationAdminUser->avatar = $organization->photo;
            $organizationAdminUser->created_at = $time;
            $organizationAdminUser->updated_at = $time;
            $organizationAdminUser->system_version = 'cqzgh';
            $organizationAdminUser->units_id = $organization->unit_id;
            $organizationAdminUser->org_id = $organization->id;
            $organizationAdminUser->save();

            DB::table('admin_role_users')->insert([
                'role_id' => 3,
                'user_id' => $organizationAdminUser->id,
            ]);
            $this->info($organizationAdminUser->id.': insert finished');
        }

        $this->info('insert finished');
    }
}