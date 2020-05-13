<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segments extends Model
{
    use SoftDeletes;
    
    protected $table = 'segments';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function organizationPlan()
    {
        return $this->belongsTo(OrganizationsPlan::class, 'organization_plan_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'organization_id', 'id');
    }
}