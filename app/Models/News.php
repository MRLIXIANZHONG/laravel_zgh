<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:37
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $table = 'news';

    protected $primaryKey = 'id';
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getSourceAttribute($value)
    {
        $stateName = [1 => '企业新闻', 2 => '媒体新闻'];

        if (!empty($value)) return $stateName[$value];
        else
            return null;
    }

    protected $fillable = [];

}