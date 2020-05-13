<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Index;


use App\DTO\NewsDTO;
use App\Models\Competition;
use App\Models\News;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use function MongoDB\BSON\toJSON;
use Psy\Util\Json;

class NewsService extends Service
{
    //获取首页新闻列表
    public function getIndexNewsList(NewsDTO $dto)
    {
        $builder = News::query();
        $builder->leftJoin("organizations", 'news.organization_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'news.unit_id', '=', 'units.id');
        $dto->getSource() && $builder->where('news.source', $dto->getSource());//来源
        $builder->where('news.check_state', 2);//已审核
        $builder->where('news.send_state', 1);//已发布
        $builder->where('news.isShowHome', 1);//首页显示
        $builder->where('news.system_version', $dto->getSystemVersion());//获取当前版本的数据

        $response = $builder->orderByDesc('news.send_time')->
        select(["news.id", "news.img_url", "news.title", "news.send_time","news.abstract", "news.abstract", "news.source", "news.browse_count", "news.virtual_traffic", "organizations.name as organizations_name", "units.name as units_name"])
            ->get();
        return $response;
    }

    //获取新闻列表
    public function getNewsList(NewsDTO $dto)
    {
        $title = $dto->getTitle();
        $builder = News::query();
        $builder->leftJoin("organizations", 'news.organization_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'news.unit_id', '=', 'units.id');
        $dto->getTitle() &&
        $builder->where(function ($query) use ($title) {
            $query->where('news.title', 'like', '%' . $title . '%')->orWhere('organizations.name', 'like', '%' . $title . '%');
        });
        request('industryId') &&  $builder->leftJoin("organization_industry_maps", 'organization_industry_maps.organization_id', '=', 'organizations.id');
        $dto->getSource() && $builder->where('news.source', $dto->getSource());//来源
        $builder->where('news.check_state', 2);//已审核
        $builder->where('news.send_state', 1);//已发布
        $dto->getIsShowHome() && $builder->where('news.isShowHome', $dto->getIsShowHome());
        $dto->getUnitId() && $builder->where('news.unit_id', $dto->getUnitId());//
        $dto->getOrganizationId() && $builder->where('news.organization_id', $dto->getOrganizationId());//
        $builder->where('news.system_version', $dto->getSystemVersion());//获取当前版本的数据
        request('new_type') && $builder->where('organizations.new_type', request('new_type'));//
        request('industryId') && $builder->where('organization_industry_maps.industry_id', request('industryId'));//
        $response = $builder->orderByDesc('news.send_time')->
        select(["news.id", "news.img_url", "news.title","news.is_open", "news.weburl", "news.send_time", "news.abstract", "news.source", "news.browse_count", "news.virtual_traffic", "organizations.name as organizations_name", "units.name as units_name"])
            ->paginate($dto->getPageSize());
        return $response;
    }

    //获取新闻详情
    public function getNewsDetail(NewsDTO $dto)
    {
        $builder = News::query();
        $builder->leftJoin("organizations", 'news.organization_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'news.unit_id', '=', 'units.id');
        $builder->where('news.id', $dto->getId());

        $response = $builder->select(["news.id","news.img_url","news.title", "news.source", "news.send_time", "news.system_version",
            "news.browse_count", "news.virtual_traffic", "news.content", "organizations.name as organizations_name",
            "units.name as units_name", "news.abstract"])->first();
        //获取上一条记录
        $prev = News::query();
        $prev->where('news.check_state', 2);//已审核
        $prev->where('news.send_state', 1);//已发布
        $prev->where('news.is_open', 1);//本系统打开的
        $dto->getUnitId() && $prev->where('news.unit_id', $dto->getUnitId());//
        $dto->getOrganizationId() && $prev->where('news.organization_id', $dto->getOrganizationId());//

        $prev->where('news.send_time', '>', $response->send_time);//已发布
        $prev->where('news.system_version', $response->system_version);//获取当前版本的数据
        $prev1 = $prev->select(["news.id", "news.title"])->orderBy('news.send_time')->first();
        //获取下一条记录
        $next = News::query();
        $next->where('news.check_state', 2);//已审核
        $next->where('news.send_state', 1);//已发布
        $next->where('news.is_open', 1);//本系统打开的
        $dto->getUnitId() && $next->where('news.unit_id', $dto->getUnitId());//
        $dto->getOrganizationId() && $next->where('news.organization_id', $dto->getOrganizationId());//

        $next->where('news.send_time', '<', $response->send_time);//已发布
        $next->where('news.system_version', $response->system_version);//获取当前版本的数据
        $next1 = $next->select(["news.id", "news.title"])->orderByDesc('news.send_time')->first();

        return ['news' => $response, 'prev' => $prev1, 'next' => $next1];
    }

    //点赞+1功能
    public function setStarCount(NewsDTO $dto)
    {
        $builder = News::where('id', $dto->getId())->increment("star_count");
        return $builder;
    }

    //浏览+1
    public function setBrowseCount(NewsDTO $dto)
    {
        $builder = News::where('id', $dto->getId())->increment("browse_count");
        return $builder;
    }

    /**
     * 获取竞赛专题
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getCompetition()
    {
        return Competition::query()->first();
    }

}