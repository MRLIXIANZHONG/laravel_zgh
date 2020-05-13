<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nominee extends Model
{
    use SoftDeletes;

    protected $table = 'nominees';

    protected $primaryKey = 'id';

    protected $fillable = [];
    /**
     * @var int|mixed|null
     */
    private $industry_id;
    /**
     * @var mixed|string|null
     */
    private $staff_img;
    /**
     * @var int|mixed|null
     */
    private $case_scheme_id;
    /**
     * @var mixed|string|null
     */
    private $month_win;
    /**
     * @var mixed|string|null
     */
    private $caption;
    /**
     * @var int|mixed|null
     */
    private $kind;
    /**
     * @var int|mixed|null
     */
    private $unit_id;
    /**
     * @var mixed|string|null
     */
    private $organization_name;
    /**
     * @var int|mixed|null
     */
    private $organization_id;
    /**
     * @var mixed|string|null
     */
    private $bank_staff_name;
    /**
     * @var mixed|string|null
     */
    private $staff_name;
    /**
     * @var mixed|string|null
     */
    private $staff_phone;
    /**
     * @var mixed|string|null
     */
    private $bank_card;
    /**
     * @var mixed|string|null
     */
    private $bank_name;
    /**
     * @var mixed|string|null
     */
    private $bank_card_img;

    public function getKindAttribute($value)
    {
        $kindName = [1 => '劳动之星', 2 => '技能之星', 3 => '创新之星', 4 => '服务之星'];
        if ($value != null)
            return $kindName[$value];
        else
            return null;
    }

    public function units()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id', 'id');
    }
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization', 'organization_id', 'id');
    }

    public function caseSchemes()
    {
        return $this->belongsTo('App\Models\CaseSchemes', 'case_scheme_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo('App\Models\Industry', 'industry_id', 'id');
    }

    public function experience()
    {
        return $this->hasMany('App\Models\Nominees_experience', 'mainId', 'id');
    }
    public function imglist()
    {
        return $this->hasMany('App\Models\Nominess_img', 'mainId', 'id');
    }
    public function videolist()
    {
        return $this->hasMany('App\Models\Nominess_video', 'mainId', 'id');
    }
}