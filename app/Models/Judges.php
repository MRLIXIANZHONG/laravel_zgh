<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Judges extends Model
{
    protected $table = 'judges';

    protected $primaryKey = 'id';

//    public function Industry()
//    {
//        return $this->hasOne(Industry::class,'id','industry');
//    }
//    public function industry_name()
//    {
//        return $this->belongsTo('App\Models\Industry', 'industry', 'id');
//    }
}