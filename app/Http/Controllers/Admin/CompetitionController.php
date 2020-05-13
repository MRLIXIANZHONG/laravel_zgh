<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 上午 11:58
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CompetitionDTO;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\CompetitionRequest;

class CompetitionController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**
     * 编辑banner
     * @return mixed
     */
    public function index()
    {

        $request = ServiceHelper::make('Admin\CompetitionService')->getDetail();

        return view('competition.edit', ['competition' => $request]);
    }

    /**
     * 更新
     * @param BannerRequest $request
     * @return mixed
     */
    public function store(CompetitionRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CompetitionDTO::class, $request);
        return ServiceHelper::make('Admin\CompetitionService')->saveCompetition($dto);
    }
}