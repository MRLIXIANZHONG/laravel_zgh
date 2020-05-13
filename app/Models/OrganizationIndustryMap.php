<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 17:57
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrganizationIndustryMap extends Model
{
    protected $table = 'organization_industry_maps';

    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id',
        'industry_id',
        'updated_at',
        'created_at',
    ];
}