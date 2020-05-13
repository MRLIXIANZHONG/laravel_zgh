<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-14 下午 3:43
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NomineesPlan extends  Model
{
    use SoftDeletes;

    protected $table = 'nominees_organizations_plan';

    protected $primaryKey = 'id';
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */

    protected $fillable = [];

    public function organizationsPlan()
    {
        return $this->belongsTo('App\Models\OrganizationsPlan', 'organizations_plan_id', 'id');
    }
}