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

class Nominees_experience extends Model
{
    use SoftDeletes;
    protected $table = 'nominees_experience';

    protected $primaryKey = 'id';
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [];
}