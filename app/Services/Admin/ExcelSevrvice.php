<?php


namespace App\Services\Admin;


use App\Exceptions\FailException;
use App\Services\Service;
use jianyan\excel\Excel;
use function PHPSTORM_META\type;

class ExcelSevrvice extends Service
{
    /**
     * @param $header 生成的表头
     * @param $data 需要导出的查询出来的数据
     * @param $name 生成名字
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *      参数格式
     *    $dataExcel = [$header, $data,'excel标题'];
     *    $header = [
     *    ['ID', 'id'],
     *    ['手机号码', 'mobile'], // 规则不填默认text
     *    ['openid', 'openid'],
     *    ['昵称', 'nickname'],
     *    ['关注/扫描', 'type'],
     *    ['性别', 'sex'],
     *    ['创建时间', 'created_at'],
     *    ];
     *    $list=[];
     *    $data=[
     *    ['id'=>1,'mobile'=>1872333666,'openid'=>12323,'nickname'=>12,'type'=>12 ,'sex'=>12 ,'created_at'=>12],
     *     ['id'=>2,'mobile'=>1231321,'openid'=>34324,'nickname'=>3,'type'=>4 ,'sex'=>5 ,'created_at'=>8,'created_atsssaaa'=>213213],
     *    ['id'=>3,'mobile'=>213,'openid'=>3443,'nickname'=>34,'type'=>5 ,'sex'=>7 ,'created_at'=>8,'created_atss'=>8],
     *    ];
     */

    public function exportExcel($dataExcel)
    {
        $header = $dataExcel[0];
        $data = $dataExcel[1];
        $name = count($dataExcel)==3?$dataExcel[2]: '';
        $list = [];
        foreach ($data as $dkey => $dval) {
            $list_be = [];
            foreach ($header as $val) {
                $list_be[$val[1]] = $dval[$val[1]];
            }
            array_push($list, $list_be);
        }
        try {
            return Excel::exportData($list, $header, $name);
        } catch (\Exception $e) {
            throw new FailException([
                'message' => $e->getMessage()
            ]);
        }
    }

//    public function exportExcel($header, $data, $name = '')
//    {
//
//        foreach ($data as $dkey => $dval) {
//            $list_be = [];
//            foreach ($header as $key => $val) {
//                $list_be[$val[1]] = $dval[$val[1]];
//            }
//            array_push($list, $list_be);
//        }
//        try {
//            return Excel::exportData($list, $header, $name);
//        } catch (\Exception $e) {
//            throw new FailException([
//                'message' => $e->getMessage()
//            ]);
//        }
//    }
}