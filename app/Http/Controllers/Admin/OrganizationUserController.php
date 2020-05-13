<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/26
 * Time: 10:10
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\Exceptions\InvalidArgumentException;
use App\Models\Industry;
use App\Models\Organization;
use App\Models\OrganizationIndustryMap;
use App\Models\Unit;
use App\Http\Requests\Request;
use DB;

class OrganizationUserController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function edit(Request $request)
    {
        $organizationId = $this->admininfo['org_id'] ?? 68;
        $organization = Organization::query()->where('id', $organizationId)->first();

        if (!$organization) {
            throw new InvalidArgumentException('资源不存在');
        }

        $units = Unit::query()->where('check_status',1)->get();
        $industries = Industry::query()->get();
        $unit = Unit::query()->where('id', $organization->unit_id)->first();
        $industry = DB::select("select `oim`.`organization_id`,`it`.`id`,`it`.`industry_name` from `organization_industry_maps` as `oim` left join 
        `industry_tag` as `it` on `oim`.`industry_id` = `it`.`id` where `organization_id` in ($organizationId)");
        $industry = collect($industry)->pluck('id')->toArray();

        data_set($organization, 'unit_id_name', data_get($unit,'name', ''));
        data_set($organization, 'industry', $industry);

        //return response()->json(['organization' => $organization, 'units' => $units, 'industries' => $industries]);
        return view('organization_user.edit',compact(['organization','units','industries']));
    }

    public function update(Request $request)
    {
        $id = $this->admininfo['org_id'];
        $dto = $this->requestHelper->makeDTO(OrganizationDTO::class, $request);
        $dto->setId($id);
        $organization = ServiceHelper::make('Admin\OrganizationService')->update($dto);
        if (!empty($request->get('industry_tag'))) {
            $arr = [];
            foreach ($request->get('industry_tag') as $item) {
                $ar['organization_id'] = $id;
                $ar['industry_id'] = $item;
                $arr[] = $ar;
                unset($ar);
            }
            OrganizationIndustryMap::query()->insert($arr);
        }

        DB::table('admin_users')->where('org_id', $id)->update([
            'password'   =>   $organization->password,
            'name'       =>   $organization->name,
            'username'   =>   $organization->username,
            'units_id'   =>   $organization->unit_id,
        ]);

        $units = Unit::query()->where('check_status',1)->get();
        $industries = Industry::query()->get();
        $unit = Unit::query()->where('id', $organization->unit_id)->first();
        $industry = DB::select("select `oim`.`organization_id`,`it`.`industry_name` from `organization_industry_maps` as `oim` left join 
        `industry_tag` as `it` on `oim`.`industry_id` = `it`.`id` where `organization_id` in ($id)");
        $industry = collect($industry)->pluck('industry_name')->toArray();

        data_set($organization, 'unit_id_name', data_get($unit,'name', ''));
        data_set($organization, 'industry', $industry);
        return view('organization_user.edit',compact(['organization','units','industries']));
    }
}