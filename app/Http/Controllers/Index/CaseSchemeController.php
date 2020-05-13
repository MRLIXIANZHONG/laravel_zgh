<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 下午 6:30
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Services\Index\CaseSchemeService;
use Illuminate\Http\JsonResponse;

class CaseSchemeController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function  detail()
    {
        CaseSchemeService:$CaseSchemeService=ServiceHelper::make('Index\CaseSchemeService');
        $caseScheme = $CaseSchemeService->detail();
        $caseSchemefile =  $CaseSchemeService->getfile(1);
        $rulefile =  $CaseSchemeService->getfile(2);
        $rewardsfile =  $CaseSchemeService->getfile(3);
        $array=(['caseScheme'=>$caseScheme,'caseSchemefile'=>$caseSchemefile,'rulefile'=>$rulefile,'rewardsfile'=>$rewardsfile]);
        return new JsonResponse($array);
    }

    public function getList()
    {
        $scheme = ServiceHelper::make('Index\CaseSchemeService')->getList();
        $files = ServiceHelper::make('Index\CaseSchemeService')->getFileList();

        $files = $files->each(function ($item) {
            $img = explode(',', data_get($item, 'img'));
            data_set($item, 'img', $img);
            $file = explode(',', data_get($item, 'file'));
            data_set($item, 'file', $file);
        });

        return response()->json(['scheme' => $scheme, 'files' => $files, 'code' => 1000]);
    }


}