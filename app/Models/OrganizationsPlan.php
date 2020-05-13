<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationsPlan extends Model
{
    use SoftDeletes;

    protected $table = 'organizations_plan';

    protected $primaryKey = 'id';

    protected $fillable = [];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function leaders()
    {
        return $this->belongsToMany(Leaders::class);
    }
}