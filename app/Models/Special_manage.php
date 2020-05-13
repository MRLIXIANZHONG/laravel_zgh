<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Special_manage extends Model
{
    use SoftDeletes;

    protected $table = 'special_manage';

    protected $primaryKey = 'id';

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $fillable = [];


}