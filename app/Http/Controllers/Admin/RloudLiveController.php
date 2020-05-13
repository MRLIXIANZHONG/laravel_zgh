<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 19:33
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\IndustryDTO;
use App\DTO\OrganizationDTO;
use App\DTO\RloudLiveDTO;
use App\Http\Requests\Admin\RloudLiveRequest;
use App\Models\RloudLive;

class RloudLiveController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }


//首页
    public function index(RloudLiveRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(RloudLiveDTO::class, $request);
        $dto->setRoleId($this->admininfo['role_id']);//角色
        $dto->setOrgId($this->admininfo['org_id']);//企业
        $dto->setUnitsId($this->admininfo['units_id']);//公会
        $dto->setRoleSlug($this->admininfo['role_slug']);//角色
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $response = ServiceHelper::make('Admin\RloudLiveService')->getList($dto);



        return view('rloudLive.list', ['rloudLive' => $response, 'search' => $dto,'admininfo' => $this->admininfo]);
    }
    //打开编辑窗口
    public function show($id)
    {
        if ($id == '0') {
            $request = new RloudLive();
        } else {
            $request = ServiceHelper::make('Admin\RloudLiveService')->getDetail($id);
        }
        //获取企业
        $orgList = ServiceHelper::make('Admin\RloudLiveService')->getListOrg(new OrganizationDTO([]));
        $industryList = ServiceHelper::make('Admin\IndustryService')->getList(new IndustryDTO([]));

        return view('rloudLive.edit', ['rloudLiveModel' => $request, 'industryList' => $industryList,'orgList'=>$orgList]);
    }

    /**
     * 新闻云竞技详情页
     **/
    public function showDetail($id)
    {
        $request = ServiceHelper::make('Admin\RloudLiveService')->getDetailPage($id);

        return view('rloudLive.detail', ['rloudLive' => $request[0]]);
    }

    /**保存数据 新增 修改*/
    public function store(RloudLiveRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(RloudLiveDTO::class, $request);
        $dto->setRoleId($this->admininfo['role_id']);//角色
     //   $dto->setOrgId($this->admininfo['org_id']);//企业
        $dto->setUnitsId($this->admininfo['units_id']);//公会

        if ($dto->getId() == 0)//新增的时候 添加创建人ID
            $dto->setCreatUserid($this->admininfo['id']);//创建人ID
        $dto->setSystemVersion($this->admininfo['system_version']);//版本号
        return $request = ServiceHelper::make('Admin\RloudLiveService')->store($dto);
    }

    /**删除*/
    public function destroy(RloudLiveRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(RloudLiveDTO::class, $request);
        return $request = ServiceHelper::make('Admin\RloudLiveService')->destroy($dto);
    }

    /**审核*/
    public function check(RloudLiveRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(RloudLiveDTO::class, $request);
        return $request = ServiceHelper::make('Admin\RloudLiveService')->update($dto);
    }
}