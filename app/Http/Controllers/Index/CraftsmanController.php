<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/13
 * Time: 10:41
 */

namespace App\Http\Controllers\Index;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\CraftsmanDTO;
use App\DTO\OrganizationDTO;
use App\DTO\UnitDTO;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CraftsmanRequest;
use App\Models\Craftsman;
use App\Models\CraftsmanExtend;
use App\Models\Organization;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class CraftsmanController extends Controller
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function index(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $craftsmans = ServiceHelper::make('Index\CraftsmanService')->getList($dto);

        if ($craftsmans instanceof LengthAwarePaginator) {
//            $orgIds = implode(',', $craftsmans->getCollection()->pluck('organization_id')->toArray());
//            $orgIds = !empty($orgIds) ? $orgIds : 0;
//            $industries = collect(DB::select("select `oim`.`organization_id`,`it`.`industry_name` from `organization_industry_maps` `oim`
//            left join `industry_tag` `it` on `oim`.`industry_id` = `it`.`id` where `oim`.`organization_id` in ($orgIds)"));
            $organizations = Organization::query()->whereIn('id', $craftsmans->getCollection()
                ->pluck('organization_id'))->get();
            $units = Unit::query()->whereIn('id', $craftsmans->getCollection()->pluck('unit_id'))->get();
            $collect = $craftsmans->getCollection()->each(function ($item) use ($organizations, $units) {
//                $industry = $industries->where('organization_id', $item->organization_id)->pluck('industry_name')->toArray();
//                $industry = implode(',', $industry);
                $org = $organizations->where('id', $item->organization_id)->first();
                $unt = $units->where('id', $item->unit_id)->first();
                data_set($item, 'unit_id_name', data_get($unt, 'name', ''));
                data_set($item, 'organization_id_name', data_get($org, 'name', ''));
                data_set($item, 'star_count', $item->star + $item->virtual_star);
                data_set($item, 'browse_count', $item->browse_amount + $item->virtual_browse);
                //data_set($item, 'industry_name', $industry);
            });
            $craftsmans->setCollection($collect);
        } else {
//            $orgIds = implode(',', $craftsmans->pluck('organization_id')->toArray());
//            $orgIds = !empty($orgIds) ? $orgIds : 0;
//            $industries = collect(DB::select("select `oim`.`organization_id`,`it`.`industry_name` from `organization_industry_maps` `oim`
//            left join `industry_tag` `it` on `oim`.`industry_id` = `it`.`id` where `oim`.`organization_id` in ($orgIds)"));
            $organizations = Organization::query()->whereIn('id', $craftsmans->pluck('organization_id'))->get();
            $units = Unit::query()->whereIn('id', $craftsmans->pluck('unit_id'))->get();
            $craftsmans = $craftsmans->each(function ($item) use ($organizations, $units) {
//                $industry = $industries->where('organization_id', $item->organization_id)->pluck('industry_name')->toArray();
//                $industry = implode(',', $industry);
                $org = $organizations->where('id', $item->organization_id)->first();
                $unt = $units->where('id', $item->unit_id)->first();
                data_set($item, 'unit_id_name', data_get($unt, 'name', ''));
                data_set($item, 'organization_id_name', data_get($org, 'name', ''));
                data_set($item, 'star_count', $item->star + $item->virtual_star);
                data_set($item, 'browse_count', $item->browse_amount + $item->virtual_browse);
                //data_set($item, 'industry_name', $industry);
            });
        }

        return response()->json(['craftsmans' => $craftsmans, 'code' => 200]);
    }

    public function show(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $craftsman = ServiceHelper::make('Index\CraftsmanService')->getDetail($dto);
        $browseAmount = ServiceHelper::make('Index\CraftsmanService')->setBrowse($dto);

        $unit = Unit::query()->where('id', $craftsman->unit_id)->first();
        $organization = Organization::query()->where('id', $craftsman->organization_id)->first();
        $videos = DB::table('craftsmans_extend')->where('type',1)->where('craftsman_id',$craftsman->id)
            ->get(['craftsman_id','video','video_cover']);
        $craftsmanHonor = CraftsmanExtend::query()->where('type',2)->where('craftsman_id',$craftsman->id)
            ->get(['craftsman_id','honor_name','honor_description', 'honor_time', 'honor_image']);

        $craftsmanHonor = $craftsmanHonor->each(function($item) {
            if ($item['honor_image'] != '') {
                data_set($item, 'honor_image', explode(',',$item['honor_image']));
            }
        });

        $organizationId = $craftsman->organization_id;
        $industries = collect(DB::select("select `oim`.`organization_id`,`it`.`industry_name` from `organization_industry_maps` `oim`
            left join `industry_tag` `it` on `oim`.`industry_id` = `it`.`id` where `oim`.`organization_id` in ($organizationId) and 
            `it`.`deleted_at` is null"));
        $industryName = implode(',', $industries->pluck('industry_name')->toArray());
        data_set($craftsman, 'unit_id_name', data_get($unit, 'name', ''));
        data_set($craftsman, 'organization_id_name', data_get($organization, 'name', ''));
        data_set($craftsman, 'total_browse', data_get($craftsman,'virtual_browse',0) + $browseAmount);
        data_set($craftsman, 'total_star', data_get($craftsman,'star',0) +
            data_get($craftsman,'virtual_star',0));
        data_set($craftsman, 'industay_name', $industryName);

        data_set($craftsman, 'craftsman_honor', '');

        if($craftsman->image !== null) {
            $imgArr = explode(',', $craftsman->image);
            data_set($craftsman, 'image', collect($imgArr));
        } else {
            data_set($craftsman, 'image', collect());
        }
        if($craftsman->video !== null) {
            $videoArr = explode(',', $craftsman->video);
            data_set($craftsman, 'video', collect($videoArr));
        } else {
            data_set($craftsman, 'video', collect());
        }
        data_set($craftsman, 'craftsman_honor', $craftsmanHonor);

        return response()->json(['data' => $craftsman, 'code' => 200]);
    }

    public function pcStar($id)
    {
        if (!$this->checkStarTime([8])) {
            return response()->json(['message' => '大众评选未开始或已结束', 'code' => 500]);
        }

        $checkResult = ServiceHelper::make('Index\UserstarLogService')->checkPCUserStarLog([
            request()->getClientIp(),
            4,
            $id,
        ]);

        if ($checkResult !== 0) {
            return response()->json(['message' => '今天已点过赞', 'code' => 500]);
        }

        $starResult = ServiceHelper::make('Index\UserstarLogService')->storePCUserStarLog([
            request()->getClientIp(),
            4,
            $id,
        ]);

        if ($starResult !== 1) {
            return response()->json(['message' => '已点过赞', 'code' => 500]);
        }

        $craftsman = Craftsman::query()->where('id', $id)->first();
        if (!$craftsman) {
            return response()->json(['message' => '工匠未找到', 'code' => 500]);
        }
        $craftsman->star = $craftsman->star + 1;
        $craftsman->save();

        return response()->json(['message' => '点赞成功', 'code' => 500]);
    }

    public function ydStar(CraftsmanRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(CraftsmanDTO::class, $request);
        $dto->setId($request->route('craftsman'));
        $array = [$dto->getOpenid(), 4, $dto->getId()];
        $response = ServiceHelper::make('Index\UserstarLogService')->storeUserStarLog($array);

        if ($response !== 1) {
            return response()->json(['msg' => '用户未关注微信公众号,请先关注渝工娘家人微信公众号,然后回复 by_'.$dto->getId().' 关键字', 'code' => 500]);
        }

        ServiceHelper::make('Index\CraftsmanService')->star($dto);

        return response()->json(['msg' => '点赞成功', 'code' => 1000]);
    }
}