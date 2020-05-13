<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 上午 10:19
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 赛事文件
 * Class CaseFile
 * @package App\Models
 */
class CaseFile extends  Model
{
    use SoftDeletes;

    protected $table = 'case_file';

    protected $primaryKey = 'id';
}