<?php


namespace App\Services\Admin;


use App\Models\AdminRoles;
use App\Services\Service;

class AdminRolesService extends Service
{
    public function checkRolesSlug($slug)
    {
        $builder = AdminRoles::where('slug', $slug)->first();
        return $builder;
    }
}