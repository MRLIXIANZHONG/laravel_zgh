<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 下午 6:50
 */

namespace App\Services\Index;


use App\Models\CaseFile;
use App\Models\CaseSchemes;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class CaseSchemeService extends Service
{

    public function detail()
    {
        return CaseSchemes::query()->where(['type' => 8, 'is_open' => 1])->first();
    }

    public function getList()
    {
         return CaseSchemes::query()->where('is_open',1)
             ->orderBy('activity_stime', 'asc')->get();
    }

    public function getFileList($activeType)
    {
        return CaseFile::query()->where('is_push', 1)
            ->where('status', 1)->get();
    }

    public function getfile($type)
    {
//        dd(CaseFile::query()->where(['is_push' => 1, 'status' => 1])->where('type',$type)->toSql());
        return CaseFile::query()->where(['is_push' => 1, 'status' => 1])->where('type', $type)->first();
    }

    //查询竞赛进程
    public function getProcess(){

        $cs= DB::table('case_schemes')->select('id','title','type','activity_stime','activity_etime')->whereNull('deleted_at')->orderBy('sort')->get();

        $list['nomineeList']=[];$list['wuxiaoList']=[];$list['collective']=[];
        $k1=0;
        $k2=0;
        $k3=0;
        if ($cs){
            foreach ($cs as $k=>$v){

                //优秀个人
                if (in_array($v->type,[1,2,3])){
                    $list['nomineeList'][$k1]=$v;
                    $list['nomineeList'][$k1]->activity_stime_int=$v->activity_stime ? strtotime($v->activity_stime) :0;
                    $list['nomineeList'][$k1]->activity_etime_int=$v->activity_etime ? strtotime($v->activity_etime) :0;
                    $list['nomineeList'][$k1]->activity_stime_y=$v->activity_stime ? date('m-d',strtotime($v->activity_stime)) :0;
                    $list['nomineeList'][$k1]->activity_etime_y=$v->activity_etime ? date('m-d',strtotime($v->activity_etime)) :0;
                    $k1++;
                }
                //优秀五小
                if (in_array($v->type,[4,5,6])){
                    $list['wuxiaoList'][$k2]=$v;
                    $list['wuxiaoList'][$k2]->activity_stime_int=$v->activity_stime ? strtotime($v->activity_stime) :0;
                    $list['wuxiaoList'][$k2]->activity_etime_int=$v->activity_etime ? strtotime($v->activity_etime) :0;
                    $list['wuxiaoList'][$k2]->activity_stime_y=$v->activity_stime ? date('m-d',strtotime($v->activity_stime)) :0;
                    $list['wuxiaoList'][$k2]->activity_etime_y=$v->activity_etime ? date('m-d',strtotime($v->activity_etime)) :0;
                    $k2++;
                }
                //优秀集体
                if ($v->type ==7){
                    $list['collective'][$k3]=$v;
                    $list['collective'][$k3]->activity_stime_int=$v->activity_stime ? strtotime($v->activity_stime) :0;
                    $list['collective'][$k3]->activity_etime_int=$v->activity_etime ? strtotime($v->activity_etime) :0;
                    $list['collective'][$k3]->activity_stime_y=$v->activity_stime ? date('m-d',strtotime($v->activity_stime)) :0;
                    $list['collective'][$k3]->activity_etime_y=$v->activity_etime ? date('m-d',strtotime($v->activity_etime)) :0;
                    $k3++;
                }

            }
        }
        return $list;
    }

}