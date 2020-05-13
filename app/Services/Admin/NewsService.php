<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Admin;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\NewsDTO;
use App\Models\AdminUsers;
use App\Models\Industry;
use App\Models\News;
use App\Models\Unit;
use App\Services\Service;
use App\Jobs\SendMsg;

class NewsService extends Service
{
    public function getList(NewsDTO $dto)
    {
        $Org_Id = $dto->getOrgId();//企业ID
        $Units_id = $dto->getUnitsId();//公会ID
        $role_slug = $dto->getRoleSlug();//获取角色类型 administrator  平台管理员 union 工会     enterprise 企业  adminunion 总工会
        $version = $dto->getSystemVersion();
        $builder = News::query();
        $builder->leftJoin("organizations", 'news.organization_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'news.unit_id', '=', 'units.id');

        $dto->getTitle() && $builder->where('news.title', 'like', '%' . $dto->getTitle() . '%');
        $dto->getSource() && $builder->where('news.source', $dto->getSource());
        //前台0无法传上来 所以未审核的状态前台用3代替 后台来进行转换
        if ($dto->getCheckState() < 0)
            $builder->where('news.check_state', '<', 0);
        else {
            $dto->getCheckState() && $builder->where('news.check_state', ($dto->getCheckState() == 3 ? 0 : $dto->getCheckState()));
        }
        $dto->getSendState() && $builder->where('news.send_state', ($dto->getSendState() == 2 ? 0 : $dto->getSendState()));
        $builder->where('news.system_version', $version);

        //企业 查询自己的
        if ($role_slug == 'enterprise' || !empty($Org_Id))
            $builder->where('news.organization_id', $Org_Id);
        //基层公会查询 自己下面所有企业已提交的
        //巴渝新闻 都可以看
        if ($version == "cqzgh" && $role_slug == 'union' && !empty($Units_id)) {
            $builder->where(function ($query) use ($Units_id) {
                $query->where('news.unit_id', $Units_id)->whereNull('news.organization_id')->orWhere(function ($query1) use ($Units_id) {

                    $query1->where('organizations.unit_id', $Units_id)->where(function ($query1) {
                        $query1->where('news.check_stage', '>=', 1)->orwhere('news.check_state', -4);
                    });
                });
            });
            // $builder->where('news.check_stage', '>=', 1);
        }
        //总工会 只查看自己这个阶段的数据
        if ($role_slug == 'adminunion') {
            $builder->where('news.check_stage', '=', 4)->orWhere('news.check_state', -1);
        } else if ($role_slug == 'technology') {
            $builder->where('news.check_stage', '>=', 3)->orWhere('news.check_state', -2);
        } else if ($role_slug == 'administrator') {
            $builder->where('news.check_stage', '>=', 2)->orWhere('news.check_state', -3);;
        }
        //导出
        if (request('exportExcel') == 1) {
            $response = $builder->orderByDesc('news.isshowhome')->orderByDesc('news.check_state')->orderByDesc('news.check_stage')->orderByDesc('news.created_at')->
            select(["news.*", "organizations.name as organizations_name", "units.name as units_name"])->get();
            $array = $response->toArray();

            foreach ($array as $key => $val) {
                //审核阶段
                if ($val['check_stage'] == '0') {
                    $array[$key]['check_stage'] = '企业阶段';
                } else if ($val['check_stage'] == '1') {
                    $array[$key]['check_stage'] = '基础工会阶段';
                } else if ($val['check_stage'] == '2') {
                    $array[$key]['check_stage'] = '活动方阶段';
                } else if ($val['check_stage'] == '3') {
                    $array[$key]['check_stage'] = '市总经济技术部';
                } else if ($val['check_stage'] == '4') {
                    $array[$key]['check_stage'] = '总工会阶段';
                }

                //审核状态
                if ($val['check_state'] == '0')
                    $array[$key]['check_state'] = '未提交';
                else if ($val['check_state'] == '1')
                    $array[$key]['check_state'] = '待审核';
                else if ($val['check_state'] == '2')
                    $array[$key]['check_state'] = '审核通过';
                else if ($val['check_state'] == '-1')
                    $array[$key]['check_state'] = '总工会驳回';
                else if ($val['check_state'] == '-2')
                    $array[$key]['check_state'] = '技术部驳回';
                else if ($val['check_state'] == '-3')
                    $array[$key]['check_state'] = '活动方驳回';
                else if ($val['check_state'] == '-4')
                    $array[$key]['check_state'] = '基层工会驳回';
                //审核阶段
                if ($val['send_state'] == '0') {
                    $array[$key]['send_state'] = '未发布';
                } else if ($val['send_state'] == '1') {
                    $array[$key]['send_state'] = '已发布';
                }
                //审核阶段
                if ($val['system_version'] == 'by') {
                    $array[$key]['system_version'] = '巴渝工匠';
                } else if ($val['system_version'] == 'cqzgh') {
                    $array[$key]['system_version'] = '网络评选';
                } else if ($val['system_version'] == 'js') {
                    $array[$key]['system_version'] = '重点竞赛';
                }
                if (empty($array[$key]['weburl'])) {
                    $array[$key]['weburl'] = env('APP_URL') . '/' . $array[$key]['id'] . '.html';
                }

                //$array[$key]['id'] = env('APP_URL') . '/' . $array[$key]['id'] . '.html';

                $array[$key]['browse_count'] = $val['browse_count'] + $val['virtual_traffic'];
            }
            $excelName = '巴渝新闻';
            if ($version == 'js') {
                $excelName = '重点竞赛新闻';
            } else if ($version == 'cqzgh') {
                $excelName = '网络竞技新闻';
            }
            $dataExcel = [
                [['新闻标题', 'title'], ['新闻地址', 'weburl'], ['所属公会', 'units_name'], ['所属企业', 'organizations_name'],
                    ['新闻来源', 'source'], ['总浏览量', 'browse_count'],
                    ['审核状态', 'check_state'], ['审核阶段', 'check_stage'], ['发布状态', 'send_state'],
                    ['发布时间', 'send_time'], ['发布人', 'send_user']
                ], $array, $excelName . time()];
            ServiceHelper::make('Admin\ExcelSevrvice')->exportExcel($dataExcel);

        } else {
            $response = $builder->orderByDesc('news.isshowhome')->orderByDesc('news.check_state')->orderByDesc('news.check_stage')->orderByDesc('news.created_at')->select(["news.*", "organizations.name as organizations_name", "units.name as units_name"])->paginate(15);
            return $response;
        }
    }

    public function getDetail($id)
    {
        $result = News::query()->find($id);
        return $result;
    }

    /**
     * 获取所属行业
     */
    public function getIndustyDetail($id)
    {
        $news = News::query()->find($id);
        $result = Industry::query();
        $result->leftJoin("organization_industry_maps", 'organization_industry_maps.industry_id', '=', 'industry_tag.id');
        $result->where('organization_industry_maps.organization_id', $news->organization_id);
        $response = $result->select('industry_tag.industry_name')->get();
        return $response;
    }

    //保存
    public function store(NewsDTO $dto)
    {
        $role_slug = $dto->getRoleSlug();//获取角色类型 administrator  平台管理员 union 工会     enterprise 企业  adminunion 总工会
        $check_stage = 0;
        if ($dto->getId() == 0) {
            $news = new News();
            //公会 添加的新闻 审核阶段为公会阶段
            if ($role_slug == 'union') {
                $check_stage = 1;
            } else if ($role_slug == 'administrator') {//公会 添加的新闻为 活动方审核阶段
                $check_stage = 2;
            } else if ($role_slug == 'adminunion') {//公会 添加的新闻为总工会审核阶段
                $check_stage = 3;
            }
            $news->organization_id = empty($dto->getOrgId()) ? 0 : $dto->getOrgId();
            $news->unit_id = empty($dto->getUnitsId()) ? 0 : $dto->getUnitsId();//基层的
            $news->check_state = 0;//待提交
            $news->check_stage = $check_stage;//审核阶段
            $news->send_state = 0;//发布状态
            $news->system_version = $dto->getSystemVersion();//版本
            $news->virtual_traffic = 0;//虚拟浏览量
            $news->creat_userid = $dto->getCreatUserid();//获取创建人ID
        } else {
            $news = News::query()->find($dto->getId());

        }
        $msg = '';
        if ($role_slug == "union" || $role_slug == "enterprise") {
            if ($news->check_state == 2) {
                $msg = '{"code":1001,"msg":"该新闻已经审核，不允许修改"}';
            } else if ($news->check_state > 0) {
                $msg = '{"code":1002,"msg":"该新闻已经报送，不允许修改"}';
            }
        }
        if (!empty($msg)) {
            return $msg;
        }

        // $news->news_type = $dto->getNewsType();//；新闻类型
        $news->is_open = $dto->getIsOpen();//；是否在本系统打开 0.否 1.是
        $news->source = $dto->getSource();//；来源
        $news->title = $dto->getTitle();//标题
        $news->abstract = $dto->getAbstract();//摘要
        $news->content =str_replace('<img','<img referrerpolicy="no-referrer"', $dto->getContent());//内容
        $news->weburl = $dto->getWeburl();//外部链接地址
        $news->img_url = $dto->getImgUrl();//图片地址
        $news->video_url = $dto->getVideoUrl();//视频地址

        $flag = $news->save();
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';

    }

    //报送
    public function update(NewsDTO $dto)
    {
        $id = $dto->getId();
        $result = News::query()->find($id);
        if ($result->check_state > 0) {
            return '{"code":1001,"msg":"请选择未提交的数据操作"}';
        }
        $uid = $this->getUserId($result->check_state, $dto->getCheckStage(), $result->organization_id, $result->unit_id, $result->system_version);

        $this->dispatch(new SendMsg(['id' => $uid], ['admin_id' => $result->creat_userid, 'title' => '新闻报送', 'content' => "【" . $result->title . "】新闻需要您审核"], 1));
        $flag = News::where('id', $id)->update(['check_stage' => $dto->getCheckStage(), 'check_state' => 1]);
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }

    /**
     * 通过审核状态获取通知人
     * @param state $
     * @param stage $
     * @return string
     */
    public function getUserId($state, $stage, $orgid, $unitid, $system_version)
    {

        //企业报送新闻 给基层工会负责人发消息
        if ($state <= 0 && $stage == 1) {
            $uid = AdminUsers::query()->whereNull('org_id')->where('units_id', $unitid)->first()->id;
        } else if ($state <= 0 && $stage == 3) {//活动方添加的新闻 报送 给技术部。网络 竞技 新闻
            $uid = 78;
        } else if ($state <= 0 && $stage == 4) {//活动方添加新闻 报送给总工会 巴渝新闻
            $uid = 74;
        } else if ($state == 1 && $stage == 2) {//活动方审核
            $uid = 1;
        } else if ($state == 1 && $stage == 3) {//技术部审核
            $uid = 78;
        } else if ($state == 1 && $stage == 4) {//总工会
            $uid = 74;
        } else if ($state == 2 && $stage == 4) {//审核通过
            if ($system_version == "cqzgh" && $orgid != 0) //网络竞技的通知 提交企业 其他的通知活动执行管理员
                $uid = AdminUsers::query()->where('org_id', $orgid)->first()->id;
            else
                $uid = 1;
        } else if ($state <0) {//驳回
            if ($system_version == "cqzgh" && $orgid != 0) //驳回 通知对应的人
                $uid = AdminUsers::query()->where('org_id', $orgid)->first()->id;
            else
                $uid = 1;
        }
        return $uid;
    }

    //审核
    public function checkNews(NewsDTO $dto)
    {
        $checkType = request('checkType');//审核类型 1 同意 2 驳回
        $PassVal = request('PassVal');//驳回理由 
        $checkState = request('check_state');//驳回理由;//审核状态 0未审核   1审核通过  -1审核驳回
        $checkStage = request('check_stage');//审核阶段 0企业阶段 1基础工会阶段  2活动方审核3  总工会审核
        $sendState = request('sendState');//发布状态
        $news = News::where('id', $dto->getId());
        //通过并发布
        if ($sendState == 1) {
            $sendUser = $dto->getSendUser();
            $time = date('Y-m-d H:i:s', time());
            $flag = $news->update(['check_state' => $checkState, 'check_stage' => $checkStage, 'send_state' => $sendState, 'send_user' => $sendUser, 'send_time' => $time, 'reason_rejection' => $PassVal]);
        } else {
            $flag = $news->update(['check_state' => $checkState, 'check_stage' => $checkStage, 'reason_rejection' => $PassVal]);
        }
        $newsModel = $news->first();

        $titleMsg = '';
        if ($checkState == 1) {
            $msg = "【" . $newsModel->title . "】新闻需要您审核";
        } else if ($sendState == 1) {
            $msg = "【" . $newsModel->title . "】已通过总工会审核并发布";
        } else if ($checkState == 2) {
            $titleMsg = '-通过';
            $msg = "【" . $newsModel->title . "】已通过总工会审核";
        } else if ($checkState <0) {
            $titleMsg = '-驳回';
            $msg = "【" . $newsModel->title . "】新闻被驳回,驳回理由【" . $PassVal . "】";
        }

        $uid = $this->getUserId($newsModel->check_state, $newsModel->check_stage, $newsModel->organization_id, $newsModel->unit_id, $newsModel->system_version);
        $this->dispatch(new SendMsg(['id' => $uid], ['admin_id' => $dto->getCreatUserid(), 'title' => '新闻审核' . $titleMsg, 'content' => $msg], 1));

        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }

    //软删除
    public function destroy(NewsDTO $dto)
    {
        $id = $dto->getId();
        $result = News::query()->find($id);

        if ($result->check_state == 2) {
            return '{"code":1001,"msg":"已审核的不允许删除"}';
        }
        if ($result->check_state > 0) {
            return '{"code":1001,"msg":"只能删除待提交的数据"}';
        }

        $flag = News::destroy('id', $id);
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }


    //推送到首页
    public function showHome(NewsDTO $dto)
    {
        $id = $dto->getId();
        $result = News::query()->find($id);
        if ($result->check_state != 2) {
            return '{"code":1001,"msg":"只能推送审核通过的数据"}';
        }
        //显示首页的 在点击改成不首页展示
        $showHome = 1;
        if ($result->isShowHome == 1) {
            $showHome = 0;
        }
        $flag = News::where('id', $id)->update(['isShowHome' => $showHome]);
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }

    //发布撤销
    public function releaseNews(NewsDTO $dto)
    {
        $sendState = request('type');;//发布状态 0 撤销 1发布

        $sendUser = $dto->getSendUser();
        $time = date('Y-m-d H:i:s', time());

        $flag = News::where('id', $dto->getId())->update(['send_state' => $sendState, 'send_user' => $sendUser, 'send_time' => $time]);
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }

    //发布撤销
    public function setVirtual(NewsDTO $dto)
    {
        $flag = News::where('id', $dto->getId())->update(['virtual_traffic' => $dto->getVirtualTraffic()]);
        if ($flag)
            return '{"code":1000,"msg":"操作成功"}';
        else
            return '{"code":-1,"msg":"操作失败"}';
    }
}