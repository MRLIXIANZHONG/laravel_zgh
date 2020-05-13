<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/10
 * Time: 15:41
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table = 'units';

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'name',
        'username',
        'mobile',
        'labour_star_amount',
        'skill_star_amount',
        'innovate_star_amount',
        'service_star_amount',
        'password',
        'banner',
    ];

    static public $TYPE = [
        1 => "市直机关工会联合会",
        2 => "产业工会",
        3 => "区县工会",
    ];
    public function homePage()
    {
        return $this->hasMany('App\Models\UnitHomePage', 'unit_id', 'id');
    }
}