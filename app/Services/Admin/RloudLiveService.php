<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Admin;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\OrganizationDTO;
use App\DTO\RloudLiveDTO;
use App\Jobs\SendMsg;
use App\Models\Organization;
use App\Models\RloudLive;
use App\Services\Service;

class RloudLiveService extends Service
{
    public function getList(RloudLiveDTO $dto)
    {
        $role_id = $dto->getRoleId();//角色ID 1 超级管理员 总工会 2 基层管理员 3 企业
        $Org_Id = $dto->getOrgId();//企业ID
        $Units_id = $dto->getUnitsId();//公会ID
        $role_slug = $dto->getRoleSlug();//获取角色类型 administrator  平台管理员 union 工会     enterprise 企业  adminunion 总工会

        $builder = RloudLive::query();
        $builder->leftJoin('industry_tag', 'rloud_live.industry', 'industry_tag.id');
//        $builder->leftJoin("organizations", 'rloud_live.org_id', '=', 'organizations.id');
        //  $builder->leftJoin("units", 'rloud_live.unit_id', '=', 'units.id');
        $dto->getTitle() && $builder->where('rloud_live.title', 'like', '%' . $dto->getTitle() . '%');
        $dto->getType() && $builder->where('rloud_live.type', $dto->getType());
        $dto->getSystemVersion() && $builder->where('rloud_live.system_version', $dto->getSystemVersion());
        //前台0无法传上来 所以未审核的状态前台用2代替 后台来进行转换
        $dto->getCheckState() && $builder->where('rloud_live.check_state', ($dto->getCheckState() == 2 ? 0 : $dto->getCheckState()));

        //企业 查询自己的
        if ($role_slug == 'enterprise' || !empty($Org_Id))
            $builder->where('rloud_live.org_id', $Org_Id);
        //基层公会查询 自己下面所有企业的
        if ($role_slug == 'union' && !empty($Units_id)) {
            $builder->where(function ($query) use ($Org_Id, $Units_id) {
                $query->where('rloud_live.unit_id', $Units_id)->orWhere('organizations.id', $Org_Id);
            });
        }
        if (request('exportExcel') == 1) {
            // "organizations.name as organizations_name", "units.name as units_name",
            $response = $builder->select(["rloud_live.*", "industry_tag.industry_name"])->orderByDesc('rloud_live.check_state')->orderByDesc('rloud_live.created_at')->get();
            $array = $response->toArray();
            foreach ($array as $key => $val) {
                //直播类型
                if ($val['type'] == '1') {
                    $array[$key]['type'] = '直播';
                } else if ($val['type'] == '2') {
                    $array[$key]['type'] = '录播';
                } else if ($val['type'] == '3') {
                    $array[$key]['type'] = '回放';
                } else if ($val['type'] == '4') {
                    $array[$key]['type'] = '竞赛视频';
                }
            }
            //['所属公会', 'units_name'], ['所属企业', 'organizations_name'],
            $dataExcel = [
                [['竞技类型', 'type'], ['标题', 'title'],
                    ['所属行业', 'industry_name'], ['链接地址', 'weburl'], ['视频连接', 'video_url']
                ], $array, json_decode(json_encode('云竞技')) . time()];
            ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);

        } else {
            //"organizations.name as organizations_name", "units.name as units_name",
            $response = $builder->select(["rloud_live.*", "industry_tag.industry_name"])->orderByDesc('rloud_live.check_state')->orderByDesc('rloud_live.created_at')->paginate(15);
            return $response;
        }
    }

    //获取编辑窗口数据
    public function getDetail($id)
    {

        $result = RloudLive::query()->find($id);
        return $result;
    }

    //获取详情页面数据
    public function getDetailPage($id)
    {

        $builder = RloudLive::query();
        $builder->leftJoin('industry_tag', 'rloud_live.industry', 'industry_tag.id');
        $builder->leftJoin("organizations", 'rloud_live.org_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'rloud_live.unit_id', '=', 'units.id');
        $builder->where('rloud_live.id', $id);
        $response = $builder->select(["rloud_live.*", "organizations.name as organizations_name", "units.name as units_name", "industry_tag.industry_name"])->get();
        return $response;
    }

    //保存
    public function store(RloudLiveDTO $dto)
    {
        if ($dto->getId() == 0) {
            $rloudLive = new RloudLive();
            $rloudLive->unit_id = empty($dto->getUnitsId()) ? 0 : $dto->getUnitsId();//基层的
            $rloudLive->check_state = 0; //审核状态
            $rloudLive->creat_userid = $dto->getCreatUserid(); //创建人
            $this->dispatch(new SendMsg(['id' => 74], ['admin_id' => $dto->getCreatUserid(), 'title' => '云竞技审核', 'content' => "【" . $dto->getTitle() . "】云竞技视频需要您审核"], 1));
        } else {
            $rloudLive = RloudLive::query()->find($dto->getId());
        }

        $rloudLive->org_id = empty($dto->getOrgId()) ? 0 : $dto->getOrgId();
        $rloudLive->title = $dto->getTitle();
        $rloudLive->industry = $dto->getIndustry();
        $rloudLive->special_id = 0;// $dto->getSpecialId();
        $rloudLive->type = $dto->getType();
        $rloudLive->content = $dto->getContent();
        $rloudLive->weburl = $dto->getWeburl();
        $rloudLive->img_url = $dto->getImgUrl();
        $rloudLive->video_url = $dto->getVideoUrl();
        $rloudLive->system_version = $dto->getSystemVersion(); //重庆总工会
        $rloudLive->start_time = $dto->getStartTime(); //开始时间
        $rloudLive->end_time = $dto->getEndTime(); //结束时间
        $rloudLive->virtual_traffic = $dto->getVirtualTraffic(); //结束时间
        $flag = $rloudLive->save();
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }

    //修改审核状态
    public function update(RloudLiveDTO $dto)
    {
        $id = $dto->getId();
        $rloud = RloudLive::where('id', $id);
        $checkstate = $dto->getCheckState();
        $rloudModel = $rloud->first();
        if ($checkstate == 1) {
            $titleMsg = '通过';
            $msg = "【" . $rloudModel->title . "】云竞技视频已审核通过";
        } else {
            $titleMsg = '撤销';
            $msg = "【" . $rloudModel->title . "】云竞技视频已撤销审核";
        }
        $this->dispatch(new SendMsg(['id' => $rloudModel->creat_userid], ['admin_id' => $rloudModel->creat_userid, 'title' => '云竞技审核-' . $titleMsg, 'content' => $msg], 1));

        $flag = $rloud->update(['check_state' => $checkstate]);
        if ($flag) {
            $msg = '{"code":1000,"msg":"操作成功"}';
        } else {
            $msg = '{"code":1001,"msg":"操作失败"}';
        }
        return $msg;
    }


    //软删除
    public function destroy(RloudLiveDTO $dto)
    {
        $id = $dto->getId();
        $flag = RloudLive::destroy('id', $id);
        if ($flag) {
            $msg = '{"code":1000,"msg":"操作成功"}';
        } else {
            $msg = '{"code":1001,"msg":"操作失败"}';
        }
        return $msg;
    }


    public function getListOrg(OrganizationDTO $dto)
    {
        $builder = Organization::query();
        $builder->where('check_state', 2)->select(['id', 'name']);

        $result = $builder->get();
        return $result;
    }

}