<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 上午 10:27
 */

namespace App\Services\Admin;


use App\DTO\CaseFileDTO;
use App\Models\CaseFile;

class CaseFileService extends \App\Services\Service
{
    public function getList(CaseFileDTO $caseFileDTO)
    {
        $builder = CaseFile::query();
        //赛选状态
        if ($caseFileDTO->getStatus()&&$caseFileDTO->getStatus() !== -1)
            $builder->where('status', $caseFileDTO->getStatus());
        //是否推送到前台显示
        if ($caseFileDTO->getIsPush()&&$caseFileDTO->getIsPush() !== -1)
            $builder->where('is_push', $caseFileDTO->getIsPush());
        $caseFileDTO->getName() && $builder->where('name', 'like', '%' . $caseFileDTO->getName() . '%');
        return $builder->paginate(15);
    }

    public function getDetail($id)
    {
        return CaseFile::find($id);
    }
    public function destroy($id)
    {
        $flag = CaseFile::destroy('id', $id);
        if ($flag)
            return '{"code":1000,"message":"操作成功"}';
        else
            return '{"code":-1,"message":"操作失败"}';
    }

    public function update(CaseFileDTO $caseFileDTO)
    {
        if ($caseFileDTO->getId())
            $caseFile = CaseFile::find($caseFileDTO->getId());
        else
            $caseFile = new CaseFile();

        $caseFile->name = $caseFileDTO->getName();
        $caseFile->icon = $caseFileDTO->getIcon();
        $caseFile->context = $caseFileDTO->getContext();
        $caseFile->img = $caseFileDTO->getImg();
        $caseFile->file = $caseFileDTO->getFile();
        $caseFile->status = $caseFileDTO->getStatus();
        $caseFile->is_push = $caseFileDTO->getIsPush();
        $caseFileDTO->getType()&&$caseFile->type = $caseFileDTO->getType();
        if ($caseFile->save())
            return ['code' => '1000', 'message' => '操作成功'];
        else
            return ['code' => '-1', 'message' => '操作失败'];
    }

}