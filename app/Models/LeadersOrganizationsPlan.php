<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LeadersOrganizationsPlan extends Model
{
    protected $table = 'leaders_organizations_plan';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function OrganizationsPlan()
    {
        return $this->belongsToMany(OrganizationsPlan::class,'lorganizations_plan_id','id');
    }

    public function leaders()
    {
        return $this->belongsToMany(Leaders::class,'leaders_id','id');
    }
}