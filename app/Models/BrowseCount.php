<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrowseCount extends Model
{
    use SoftDeletes;

    protected $table = 'browse_count';

    protected $primaryKey = 'id';

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $fillable = [];
}