<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 11:34
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrganizationSection extends Model
{
    protected $table = 'organization_section';

    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id',
        'name',
        'phone',
        'position',
        'duty'
    ];
}