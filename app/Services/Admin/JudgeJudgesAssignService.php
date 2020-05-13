<?php


namespace App\Services\Admin;


use App\Models\JudgeJudgesAssign;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class JudgeJudgesAssignService extends Service
{

    public function destroy($id)
    {
        $JudgeJudgesAssign = JudgeJudgesAssign::find($id);

        $JudgeJudgesAssign->delete();

        return '{"code":1000,"msg":"操作成功"}';
    }

//    public function check($id){
//        $selectionJudgesArry =DB::select("
//               select
//                b.name ,
//                b.photo,
//                b.industry,
//                b.kind,
//                c.industry_name
//                from
//                judge_judgesAssign a
//                JOIN judges b
//                on
//                a.judge_id =b.id
//                JOIN industry_tag c
//                on
//                c.id=b.industry
//                where a.state=1 and  b.id=
//        ".$id);
//
//        return $selectionJudgesArry;
//    }

    public function  check($id){
        //dd($id);
         $judges=JudgeJudgesAssign::query();
         $judges->where('judge_id','=',$id) ;
         $judges->where('state','=',1);
         $data=$judges->get();
         return count($data)>0;
    }
}