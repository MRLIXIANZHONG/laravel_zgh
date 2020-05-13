<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 下午 3:35
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseSchemes extends Model
{
    use SoftDeletes;

    protected $table = 'case_schemes';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function caseSchemeType()
    {
        return $this->belongsTo('App\Models\CaseSchemeType', 'type', 'id');
    }

    public function nominees()
    {
        return $this->hasMany('App\Models\Nominee', 'case_scheme_id', 'id');
    }

    public function nomineeswin()
    {
        return $this->hasMany('App\Models\Nominee', 'case_scheme_id', 'id');
    }


    public function nomineesquartwin()
    {
        return $this->hasMany('App\Models\Nominee', 'quart', 'id');
    }

    public function nomineesquart()
    {
        return $this->hasMany('App\Models\Nominee', 'quart', 'id');
    }

    public function nomineesyeartwin()
    {
        return $this->hasMany('App\Models\Nominee', 'year', 'id');
    }

    public function nomineesyear()
    {
        return $this->hasMany('App\Models\Nominee', 'year', 'id');
    }

    public function wuxiao()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'case_scheme_id', 'id');
    }
    public function wuxiaowin()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'case_scheme_id', 'id');
    }

    public function wuxiaoquart()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'quart', 'id');
    }

    public function wuxiaoquartwin()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'quart', 'id');
    }


    public function wuxiaoyaer()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'year', 'id');
    }

    public function wuxiaoyaerwin()
    {
        return $this->hasMany('App\Models\OrganizationsWuxiao', 'year', 'id');
    }


//    public function getTypeAttribute($value)
//    {
//        $typeName = [1 => '月度之星', 2 => '季度之星', 3 => '年度之星'];
//        if ($value != null)
//            return $typeName[$value];
//        else
//            return null;
//    }
    /**
     * @var mixed|string|null
     */
//    private $title;
}