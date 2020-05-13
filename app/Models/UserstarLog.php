<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserstarLog extends Model
{
    use SoftDeletes;

    protected $table = 'userstar_log';

    protected $primaryKey = 'id';

    protected $fillable = [];
}