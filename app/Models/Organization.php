<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 16:25
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $table = 'organizations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'username',
        'mobile',
        'unit_type',
        'unit_id',
        'website',
        'plan_name',
        'summary',
        'content',
        'target_task',
        'achievement_target',
        'measures',
        'img_url',
        'check_state',
        'photo',
        'abbreviation',
        'password',
        'grade'
    ];

    static public $GRADE = [
        0 => '非重点项目',
        1 => '市级重点项目',
        2 => '国家级重点项目'

    ];
    static public $UNIT_TYPE = [
        1 => "市直机关工会联合会",
        2 => "产业工会",
        3 => "区县工会",
    ];
    static public $TYPE = [
        1 => "工会",
        2 => "企业",
    ];

    static public $INDUSTRY = [
        1 => "农、林、牧、渔业",
        2 => "采矿业",
        3 => "制造业",
        4 => "电力、燃气及水的生产和供应",
        5 => "建筑业",
        6 => "交通运输、仓储和邮政",
        7 => "信息传输、计算机服务和软件业",
        8 => "住宿和餐饮业",
        9 => "金融业",
        10 => "房地产业",
        11 => "租赁和商务服务",
        12 => "科学研究、技术服务和地质勘查",
        13 => "水利、环境和公共设施管理",
        14 => "居民服务和其他服务",
        15 => "教育",
        16 => "卫生、社会保障和社会福利",
        17 => "文化、体育和娱乐业",
        18 => "公共管理和社会组织",
        19 => "国际组织",
        20 => "批发和零售"
    ];

    public function getUnitTypeAttribute($value)
    {
        if (isset(self::$UNIT_TYPE[$value])) {
            return self::$UNIT_TYPE[$value];
        } else {
            return '未设置';
        }
    }

//    public function getCheckStateAttribute($value)
//    {
//        if ($value === 1) {
//            return '审核通过';
//        } else if ($value === 0) {
//            return '未审核';
//        } else if ($value === -1) {
//            return '驳回';
//        } else {
//            return '';
//        }
//    }

    public function getGradeAttribute($value)
    {
        if (isset(self::$GRADE[$value])) {
            return self::$GRADE[$value];
        } else {
            return '未设置';
        }
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'organization_industry_maps', 'organization_id', 'industry_id');
    }
}