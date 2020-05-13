<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/12
 * Time: 15:58
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\CaseSchemes;
use App\Models\Craftsman;
use App\Models\CraftsmanExtend;
use App\Models\Industry;
use App\Models\JudgeJudgesAssign;
use App\Models\JudgesAssign;
use App\Models\Organization;
use App\Models\OrganizationIndustryMap;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;

class CandidateCraftsmanController extends BaseController
{
    protected $requestHelper;

    protected $adminStatus = [3,4,6,7,9,10,11,12,13];

    protected $unitStatus = [1,2,3,4,6,7,9,10,11,12,13];

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $search = [
            'username' => $dto->getUsername(),
            'mobile'   => $dto->getMobile(),
            'unit_id'  => $dto->getUnitId(),
        ];

        if ($this->admininfo['roles'][0]['id'] === 2) {
            $dto->setUnitId($this->admininfo['units_id']);
            $dto->setCheckStatus($this->unitStatus);
        } elseif (in_array($this->admininfo['roles'][0]['id'], [1,4])) {
            $dto->setCheckStatus($this->adminStatus);
        } elseif ($this->admininfo['roles'][0]['id'] === 5) {
            $judgesAssignIds = JudgeJudgesAssign::query()->where('judge_id', $this->admininfo['jun_id'])
                ->where('state', 1)->pluck('judgesAssign_id');
            $activeIds = JudgesAssign::query()->whereIn('id', $judgesAssignIds)->pluck('case_schemes_id')->toArray();
            if (!empty($activeIds)) {
                $dto->setCheckStatus($activeIds);
            }
        }

        $dto->setIsCraftsman(1);
        $craftsmans = ServiceHelper::make('Admin\CraftsmanService')->getCandidateList($dto);
        $role = $this->admininfo['role_id'];

        if ($craftsmans instanceof LengthAwarePaginator) {
            $units = Unit::query()->whereIn('id', $craftsmans->getCollection()->pluck('unit_id'))->get();
            $allUnit = Unit::query()->where('check_status', 1)->get(['id','name']);
            $organizations = Organization::query()
                ->whereIn('id', $craftsmans->getCollection()->pluck('organization_id'))->get();

            $collect = $craftsmans->each(function ($item) use ($units, $organizations) {
                $unit = $units->where('id',$item->unit_id)->first();
                $organization = $organizations->where('id',$item->organization_id)->first();
                data_set($item, 'unit_id_name', data_get($unit,'name', ''));
                data_set($item, 'organization_id_name', data_get($organization,'name', ''));
                data_set($item, 'unit_check', data_get($unit, 'username', '') );
                data_set($item, 'organization_check', data_get($organization, 'username', '') );
                data_set($item, 'check_status_name', $this->checkStatus[$item->check_status]);
                data_set($item, 'super_star', $item->star + $item->virtual_star);
                data_set($item, 'super_browse', $item->browse_amount + $item->virtual_browse);
            });
        }

        return view('candidate_craftsman.index', compact(['craftsmans', 'role', 'search', 'allUnit']));
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);

        $unit = ServiceHelper::make('Admin\UnitService')->getDetail(new UnitDTO([
            'id' => $craftsman->unit_id,
        ]));

        $organization = ServiceHelper::make('Admin\OrganizationService')->getDetail(new OrganizationDTO([
            'id' => $craftsman->organization_id,
        ]));

        $industryIds = OrganizationIndustryMap::query()->where('organization_id', $craftsman->organization_id)
            ->pluck('industry_id');
        $industryTags = Industry::query()->whereIn('id', $industryIds)->get();

        $craftsmanHonor = CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
            ->where('type', 2)->get();

        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);

        if($craftsman->image !== null) {
            $imgArr = explode(',', $craftsman->image);
            data_set($craftsman, 'imgArr', collect($imgArr));
        }
        if($craftsman->video !== null) {
            $videoArr = explode(',', $craftsman->video);
            data_set($craftsman, 'videoArr', collect($videoArr));
        }

        data_set($craftsman, 'industries', $industryTags);
        data_set($craftsman, 'unit_id_name', data_get($unit, 'name', ''));
        data_set($craftsman, 'unit_id_username', data_get($unit, 'username', ''));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name', ''));
        data_set($craftsman, 'organization_id_username', data_get($organization, 'username', ''));
        data_set($craftsman, 'super_star', $craftsman->star + $craftsman->virtual_star);
        data_set($craftsman, 'super_browse', $craftsman->browse_amount + $craftsman->virtual_browse);

        $check_status = $this->checkStatus;
        $role = $this->admininfo['roles'][0]['id'];

        return view('candidate_craftsman.show', compact(['craftsman', 'check_status','role']));
    }

//    public function create()
//    {
//        return view('candidate_craftsman.edit');
//    }
//
//    public function store(CraftsmanRequest $request)
//    {
//        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
//        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->store($dto);
//
//        return redirect('admin/candidate_craftsmans')->with('success', '添加成功！');
//    }

    public function edit(CraftsmanRequest $request)
    {
        $dto = new CraftsmanDTO([ 'id' => $request->route('candidate_craftsman')]);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->getDetail($dto);
        $role = $this->admininfo['role_id'];

        $craftsmanHonor = CraftsmanExtend::query()->where('craftsman_id', $dto->getId())
            ->where('type', 2)->get();

        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);

//        if($craftsman->image !== null) {
//            $imgArr = explode(',', $craftsman->image);
//            data_set($craftsman, 'image', collect($imgArr));
//        }
//        if($craftsman->video !== null) {
//            $videoArr = explode(',', $craftsman->video);
//            data_set($craftsman, 'video', collect($videoArr));
//        }

        return view('candidate_craftsman.edit', compact(['craftsman','role']));
    }

    public function updateCraftsman(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->update($dto);

        return response()->json(['message' => '修改成功', 'code' => 1000]);
    }

    public function destroy(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        $result = ServiceHelper::make('Admin\CraftsmanService')->delete($dto);

        return response()->json(['message' => '删除成功', 'code' => 1000]);
    }

    public function export(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setIsCraftsman(1);
        $craftsmans = ServiceHelper::make('Admin\CraftsmanService')->export($dto);

        $header = [
            ['序号','id'],
            ['姓名','username'],
            ['企业','organization_id_name'],
            ['企业类型','new_type_name'],
            ['行业','industries_name'],
            ['工会', 'unit_id_name'],
            ['企业联系人', 'organization_id_username'],
            ['企业联系电话','organization_id_mobile'],
            ['审核状态','check_status_name'],
            ['获奖状态','hj_status'],
            ['浏览量','browse_amount'],
            ['点赞量','star'],
            ['专家投票','score'],
        ];

        $excel = [$header,json_decode(json_encode($craftsmans),true),'候选工匠列表'];
        return ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($excel);
    }

    public function setVirtual(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->setVirtual($dto);

        return response()->json(['message' => '设置成功', 'code' => 1000]);
    }

    public function check(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));

        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();
        if (!$craftsman) {
            throw new InvalidArgumentException('工匠未找到');
        }

        $time = date('Y-m-d H:i:s', time());
        if ($this->admininfo['roles'][0]['id'] == 1) {
            $dto->setCheckStatus([6]);

        } elseif ($this->admininfo['roles'][0]['id'] === 4) {

            $caseScheme = CaseSchemes::query()->where('type', 8)
                ->where('is_open', 1)->where('zgh_is_open', 1)->first();
            if (!$caseScheme) {
                throw new NotFoundException('巴渝工匠总工会审核阶段暂未开启，敬请期待');
            }
            if ($time < $caseScheme->zgh_stime) {
                throw new InvalidArgumentException('巴渝工匠总工会审核时间未到');
            }
            if ($time > $caseScheme->zgh_etime) {
                throw new InvalidArgumentException('巴渝工匠总工会审核时间已过');
            }

            $dto->setCheckStatus([9]);
        } elseif ($this->admininfo['roles'][0]['id'] == 2) {

            $caseScheme = CaseSchemes::query()->where('type', 8)
                ->where('is_open', 1)->where('gh_is_open', 1)->first();
            if (!$caseScheme) {
                throw new NotFoundException('巴渝工匠工会审核阶段暂未开启，敬请期待');
            }
            if ($time < $caseScheme->gh_stime) {
                throw new InvalidArgumentException('巴渝工匠工会推选时间未到');
            }

            if ($time > $caseScheme->gh_etime) {
                throw new InvalidArgumentException('巴渝工匠工会推选时间已过');
            }

            if (in_array($craftsman->check_status, [6,9,10,11,12,13])) {
                throw new InvalidArgumentException('总工会已审核通过，不能重复审核');
            }

            $dto->setCheckStatus([3]);
        } else {
            throw new InvalidArgumentException('无权限');
        }

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->checkCraftsman($dto);

        return response()->json(['message' => '审核成功', 'code' => 1000]);
    }

    public function reject(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        $craftsman = Craftsman::query()->where('id', $dto->getId())->first();
        if (!$craftsman) {
            throw new InvalidArgumentException('工匠未找到');
        }

        $time = date('Y-m-d H:i:s', time());
        if ($this->admininfo['roles'][0]['id'] === 4) {
            $caseScheme = CaseSchemes::query()->where('type', 8)
                ->where('is_open', 1)->where('zgh_is_open', 1)->first();
            if (!$caseScheme) {
                throw new NotFoundException('巴渝工匠总工会审核阶段暂未开启，敬请期待');
            }
            if ($time < $caseScheme->zgh_stime) {
                throw new InvalidArgumentException('巴渝工匠总工会审核时间未到');
            }
            if ($time > $caseScheme->zgh_etime) {
                throw new InvalidArgumentException('巴渝工匠总工会审核时间已过');
            }
            $dto->setCheckStatus([7]);
        } elseif ($this->admininfo['roles'][0]['id'] == 1) {

            $dto->setCheckStatus([4]);
        } elseif ($this->admininfo['roles'][0]['id'] == 2) {

            $caseScheme = CaseSchemes::query()->where('type', 8)
                ->where('is_open', 1)->where('gh_is_open', 1)->first();
            if (!$caseScheme) {
                throw new NotFoundException('巴渝工匠工会审核阶段暂未开启，敬请期待');
            }
            if ($time < $caseScheme->gh_stime) {
                throw new InvalidArgumentException('巴渝工匠工会推选时间未到');
            }

            if ($time > $caseScheme->gh_etime) {
                throw new InvalidArgumentException('巴渝工匠工会推选时间已过');
            }
            if (in_array($craftsman->check_status, [6,9,10,11,12,13])) {
                throw new InvalidArgumentException('总工会已审核通过，不能重复审核');
            }
            $dto->setCheckStatus([2]);
            
        } else {
            throw new InvalidArgumentException('无权限');
        }

        $dto->setRejectReason($request->get('reject_reason'));
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->rejectCraftsman($dto);

        return response()->json(['message' => '驳回成功', 'code' => 1000]);
    }

    public function  setCraftsman(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));
        $dto->setIsCraftsman(2);
        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->setCraftsman($dto);

        return response()->json(['message' => '评选成功', 'code' => 1000]);
    }

    public function expertScore(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('candidate_craftsman'));

        $time = date('Y-m-d H:i:s', time());
        $caseScheme = CaseSchemes::query()->where('type', 8)
            ->where('is_open', 1)->where('zj_is_open', 1)->first();
        if (!$caseScheme) {
            throw new NotFoundException('巴渝工匠总工会审核阶段暂未开启，敬请期待');
        }
        if ($time < $caseScheme->zj_stime) {
            throw new InvalidArgumentException('专家投票时间未到');
        }
        if ($time > $caseScheme->zj_etime) {
            throw new InvalidArgumentException('专家投票时间已过');
        }

        $craftsman = ServiceHelper::make('Admin\CraftsmanService')->expertScore($dto);

        return response()->json(['message' => '投票成功', 'code' => 1000]);
    }

}