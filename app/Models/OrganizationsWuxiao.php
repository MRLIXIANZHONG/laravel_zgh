<?php
/**
 * 五小
 * @author ccoo004
 * @date 2020-04-11 上午 11:51
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrganizationsWuxiao extends Model
{
    protected $table = 'organizations_wuxiao';

    protected $primaryKey = 'id';

    protected $fillable = [];
    /**
     * @var int|mixed|null
     */
    private $industry_id;

    public function units()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id', 'id');
    }

    public function organizations()
    {
        return $this->belongsTo('App\Models\Organization', 'organization_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo('App\Models\Industry', 'industry_id', 'id');
    }

    public function caseSchemes()
    {
        return $this->belongsTo('App\Models\CaseSchemes', 'case_scheme_id', 'id');
    }
    public function getTypeAttribute($value)
    {
        $typeName = [1 => '小发明', 2 => '小创造', 3 => '小革新', 4 => '小建议', 5 => '小设计'];
        if ($value !== null)
            return $typeName[$value];
        else
            return null;
    }
//
//    public function getDeclarationStateAttribute($value)
//    {
//        $declarationStateName = [0 => '未申报', 1 => '已申报'];
//        if ($value !== null)
//            return $declarationStateName[$value];
//        else
//            return null;
//    }

    public function getOrganizationsTypeAttribute($value)
    {
        $OrganizationsType = [1=>'国营控股企业', 2=>'行政机关', 3=>'港澳台、外商投资企业', 4=>'民营控股企业' ,5=>'事业单位', 6=>'其他'];
        if ($value !== null)
            return $OrganizationsType[$value];
        else
            return null;
    }

//    public function getCheckStateAttribute($value)
//    {
//        $checkStateName = [0 => '未审核', 1 => '工会审核通过', 2 => '工会驳回', 3 => '活动管理方通过', 4 => '活动管理方驳回', 5 => '总工会通过', 6 => '总工会驳回'];
//        if ($value !== null)
//            return $checkStateName[$value];
//        else
//            return null;
//    }
}