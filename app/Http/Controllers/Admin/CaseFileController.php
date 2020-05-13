<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 上午 10:29
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CaseFileDTO;
use App\Http\Requests\Admin\CaseFileRequest;
use App\Models\CaseFile;
use Illuminate\Http\Request;

class CaseFileController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(CaseFileRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseFileDTO::class, $request);

        $casefileList = ServiceHelper::make('Admin\CaseFileService')->getList($dto);

        return view('caseschemes.file', ['casefileList' => $casefileList, 'caseFiledto' => $dto]);
    }

    /**
     * 编辑赛事节点
     * @param Request $request
     * @return mixed
     */
    public function edit(CaseFileRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseFileDTO::class, $request);
        if ($dto->getId()) {
            $caseFile = ServiceHelper::make('Admin\CaseFileService')->getDetail($dto->getId());
        } else {
            $caseFile = new CaseFile();
        }
        return view('caseschemes.editcasefile', ['caseFile' => $caseFile]);
    }

    public function update(CaseFileRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CaseFileDTO::class, $request);
        if ($dto->getStatus() === null) {
            $dto->setStatus(0);
        }
        if ($dto->getIsPush() === null) {
            $dto->setIsPush(0);
        }
        return ServiceHelper::make('Admin\CaseFileService')->update($dto);
    }

    public function detail($id)
    {
        $caseFile = ServiceHelper::make('Admin\CaseFileService')->getDetail($id);
        return view('caseschemes.detailfile', ['caseFile' => $caseFile]);
    }

    public function destroy($id)
    {
        return ServiceHelper::make('Admin\CaseFileService')->destroy($id);
    }
}