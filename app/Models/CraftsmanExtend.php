<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/5/7
 * Time: 14:13
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CraftsmanExtend extends Model
{
    use SoftDeletes;

    protected $table = 'craftsmans_extend';

    protected $primaryKey = 'id';
}