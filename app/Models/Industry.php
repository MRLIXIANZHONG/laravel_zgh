<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/8
 * Time: 16:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;

    protected $table = 'industry_tag';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'industry_name',
        'description',
        'updated_at',
        'created_at',
    ];

    public function organization()
    {
        //return $this->belongsToMany(Organization::class, 'organization', 'id', 'in')
    }
}