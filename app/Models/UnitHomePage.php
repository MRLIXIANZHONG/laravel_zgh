<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-23 下午 7:04
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    class UnitHomePage extends  Model
{
    use SoftDeletes;

    protected $table = 'unit_homepage';

    protected $primaryKey = 'id';

}