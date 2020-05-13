<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class honorJudges extends Model
{
    protected $table = 'honor_judges';

    protected $primaryKey = 'id';

    public function Industry()
    {
        return $this->belongsTo(Judges::class,'id','judgesid');
    }
}