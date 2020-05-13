<?php


namespace App\Services\Admin;


use App\DTO\JudgesAssignDTO;
use App\Models\JudgeJudgesAssign;
use App\Models\JudgesAssign;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class JudgesAssignService extends Service
{
    public function getList(JudgesAssignDTO $JudgesAssignDTO)
    {
        $builder = JudgesAssign::query();
        $JudgesAssignDTO->getId() && $builder->where('id',  $JudgesAssignDTO->getId());
        $JudgesAssignDTO->getName() && $builder->where('name', 'like', '%' . $JudgesAssignDTO->getName() . '%');
        if($JudgesAssignDTO->getPageSize()==-1)
            return  $builder->get();
        return $builder->paginate(15);
    }

    public function store(JudgesAssignDTO $dto){
        $JudgesAssign = new JudgesAssign;
        $JudgesAssign->name = $dto->getName();
        $JudgesAssign->judesCount = $dto->getJudesCount();
        $JudgesAssign->bakjudesCount = $dto->getBakjudesCount();
        $JudgesAssign->endtime = $dto->getEndtime();
        $JudgesAssign->state =0;
        $JudgesAssign->case_schemes_id = $dto->getCaseSchemesId();
        $JudgesAssign->system_version = 'cqzgh';
        $JudgesAssign->save();
        return '{"code":1000,"msg":"成功"}';
    }

    public function update(JudgesAssignDTO $dto){
        $state= $dto->getState();
        $JudgesAssign = JudgesAssign::find($dto->getId());
        $dto->getName()&&$JudgesAssign->name = $dto->getName();
        $dto->getJudesCount()&&$JudgesAssign->judesCount = $dto->getJudesCount();
        $dto->getBakjudesCount()&&$JudgesAssign->bakjudesCount = $dto->getBakjudesCount();
        $dto->getEndtime()&&$JudgesAssign->endtime = $dto->getEndtime();
        $JudgesAssign->nopassinfo = $dto->getNopassinfo();
        if(isset($state));
            $JudgesAssign->state = $dto->getState();
        $dto->getCaseSchemesId()&&$JudgesAssign->case_schemes_id = $dto->getCaseSchemesId();
        $JudgesAssign->save();
        if($state==-1)
            return '{"code":2000,"msg":"成功"}';
        return '{"code":1000,"msg":"成功"}';
    }

    public function getDetail($id){
        $model = JudgesAssign::query()->find($id);
        return $model;
    }

    public function updateState($array){
        if(!empty($array[0]))
            $confirmaffected = DB::update("update judge_judgesAssign set state = 1 where id in(".$array[0]." )");
        if(!empty($array[1]))
             $notconfirmaffected = DB::update("update judge_judgesAssign set state = 0 where id in(".$array[1]." )");
        return '{"code":1000,"msg":"操作成功"}';
    }

    public function checkJudges($id){
        $Judges = DB::select ("select 
            b.name as name,
            b.kind as kind,
            c.industry_name as industryName,
            a.state as state,
            a.judgeAssignType as judgeAssignType,
            a.id as id
            from judge_judgesAssign a
            JOIN judges b
            ON
            a.judge_id=b.id
            JOIN industry_tag c
            ON
            b.industry=c.id
            where judgesAssign_id=".$id." and a.judgeAssignType=1");
        return  $Judges;
    }

    public function checkBakJudges($id){
        $Judges = DB::select ("select 
            b.name as name,
            b.kind as kind,
            c.industry_name as industryName,
            a.state as state,
            a.judgeAssignType as judgeAssignType,
            a.id as id
            from judge_judgesAssign a
            JOIN judges b
            ON
            a.judge_id=b.id
            JOIN industry_tag c
            ON
            b.industry=c.id
            where judgesAssign_id=".$id." and a.judgeAssignType=2");
        return  $Judges;
    }

    // $parameterarray id:指派表id ,judesId:专家id ,judesType:专家类型 1专家2备选专家
    public function addJudgesassign($parameterarray) {
        $model = JudgesAssign::query()->find($parameterarray['id']);
        if(date($model->endtime)<=date('Y-m-d',time()))
            return '{"code":1001,"msg":"时间超时"}';
        //先查询,对比数量
        if($parameterarray['judesType']==1){
            $notbakcount=DB::select ("select Count(judge_id) as allcount from judge_judgesAssign where judgesAssign_id=".$parameterarray['id']." and judgeAssignType=1;");
            $workcount= $notbakcount[0]->allcount+1;
            if($model->judesCount<$workcount)
                return '{"code":1001,"msg":"数量超过,请调整数量"}';
        }
        else{
            $bakcount=DB::select ("select Count(judge_id) as allcount from judge_judgesAssign where judgesAssign_id=".$parameterarray['id']." and judgeAssignType=2;");
            $bakworkcount= $bakcount[0]->allcount+1;
            if($model->bakjudesCount<$bakworkcount)
                return '{"code":1001,"msg":"数量超过,请调整数量"}';
        }

        $sqlstr=" insert into judge_judgesAssign (judge_id,judgesAssign_id,state,judgeAssignType) 
                 VALUES (".$parameterarray['judesId'].",".$parameterarray['id'].",0,".$parameterarray['judesType'].")";
        $affected = DB::insert($sqlstr);
        if($affected>0)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":1001,"msg":"操作失败"}';
    }
        
    // $parameterarray id:指派表id judesCount:指派专家数 bakjudesCount:备选指派专家数
    public function doRandom($parameterarray){

        if($parameterarray['judesCount']<0)
            return  '{"code":1001,"msg":"专家不能为负数"}';
        if($parameterarray['bakjudesCount']<0)
            return  '{"code":1001,"msg":"专家不能为负数"}';
        if($parameterarray['judesCount']==0&&$parameterarray['bakjudesCount']==0)
            return  '{"code":1001,"msg":"不能同时为0"}';

        //先查询,对比数量
        $bakcount=DB::select ("select Count(judge_id) as allcount from judge_judgesAssign where judgesAssign_id=".$parameterarray['id']." and judgeAssignType=2;");
        $notbakcount=DB::select ("select Count(judge_id) as allcount from judge_judgesAssign where judgesAssign_id=".$parameterarray['id']." and judgeAssignType=1;");
        $model = JudgesAssign::query()->find($parameterarray['id']);
        if(date($model->endtime)<=date('Y-m-d',time()))
            return '{"code":1001,"msg":"时间超时"}';
        $workcount= $notbakcount[0]->allcount+$parameterarray['judesCount'];
        $bakworkcount= $bakcount[0]->allcount+$parameterarray['bakjudesCount'];
        if($model->judesCount<$workcount||$model->bakjudesCount<$bakworkcount)
            return '{"code":1001,"msg":"数量超过,请调整数量"}';
        if($model->judesCount==0||$model->bakjudesCount==0)
            return '{"code":1001,"msg":"请调整委派数量"}';
        
        $sqlstr=" insert into judge_judgesAssign (judge_id,judgesAssign_id,state,judgeAssignType) VALUES ";

        //查找不包含在关联表中数据
       $judgeIdList= DB::select ("select id from judges where check_state=1 and id not in (select judge_id from judge_judgesAssign where judgesAssign_id=".$parameterarray['id'].")");

        $changeArray = [];

        foreach ($judgeIdList as $item)
        {
            array_push($changeArray,$item->id);
        }

        $judesArray=[];

        if(empty($changeArray)||(Count($changeArray)<$parameterarray['judesCount']+$parameterarray['bakjudesCount']))
            return  '{"code":1001,"msg":"专家库数量不足"}';

        if(!empty($parameterarray['judesCount'])){
            //随机专家index
            $judesArrayIndex=(array)array_rand($changeArray,$parameterarray['judesCount']);
            //取专家数组
            foreach ($judesArrayIndex as $item)
            {
                $sqlstr=$sqlstr."(".$changeArray[$item].",".$parameterarray['id'].",0,1) ,";
                array_push($judesArray,$changeArray[$item]);
            }
        }
        //去掉包含专家数组
        $removeArray =array_diff($changeArray, $judesArray);
        $bakjudesArray=[];

        if(!empty($parameterarray['bakjudesCount'])){
             // 随机备选专家index
            $bakjudesArrayIndex=(array)array_rand($removeArray,$parameterarray['bakjudesCount']);
            //取专家数组
            foreach ($bakjudesArrayIndex as $item)
            {
                $sqlstr=$sqlstr."(".$removeArray[$item].",".$parameterarray['id'].",0,2) ,";
                array_push($bakjudesArray,$removeArray[$item]);
            }
        }
        
        $sqlstr = preg_replace('#.$#i', ';', $sqlstr);
        $affected = DB::insert($sqlstr);
        if($affected>0)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":1001,"msg":"操作失败"}';
    }

    public function checkUpdate($judgesAssignid){
        $judges=JudgeJudgesAssign::query();
        $judges->where('judgesAssign_id',$judgesAssignid);
        $data= $judges->get();
        return count($data)>0;
    }

    public function destroy($id){
        DB::delete('delete from judge_judgesAssign where judgesAssign_id='.$id);
        $JudgesAssign = JudgesAssign::find($id);
        $JudgesAssign->delete();
        return '{"code":1000,"msg":"操作成功"}';
    }

    public function exporeJudgesAssign(JudgesAssignDTO $dto){
        $judgeList=DB::select("
          select  (select GROUP_CONCAT(judges.name) as bakjudgesname  from judge_judgesAssign 
            JOIN judges
            on judges.id=judge_judgesAssign.judge_id
            JOIN JudgesAssign
            on JudgesAssign.id=judge_judgesAssign.judgesAssign_id
            where  judgeAssignType=2  and judgesAssign_id=a.id
            GROUP BY JudgesAssign.name) as bakjudgesname ,
             (select GROUP_CONCAT(judges.name) as bakjudgesname  from judge_judgesAssign 
            JOIN judges
            on judges.id=judge_judgesAssign.judge_id
            JOIN JudgesAssign
            on JudgesAssign.id=judge_judgesAssign.judgesAssign_id
            where  judgeAssignType=1  and judgesAssign_id=a.id
            GROUP BY JudgesAssign.name)as judgesname ,
            name,id,judesCount,bakjudesCount,endtime,state,case_schemes_id,created_at,updated_at,system_version from JudgesAssign a
        ");
        return  $judgeList;
    }
}