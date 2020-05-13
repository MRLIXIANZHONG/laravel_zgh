<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leaders extends Model
{
    use SoftDeletes;
    
    protected $table = 'leaders';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }
}