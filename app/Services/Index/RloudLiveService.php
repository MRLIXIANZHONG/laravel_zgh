<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:48
 */

namespace App\Services\Index;


use App\Commons\Helpers\ServiceHelper;
use App\DTO\NewsDTO;
use App\DTO\RloudLiveDTO;
use App\Models\RloudLive;
use App\Services\Service;
use Illuminate\Support\Facades\DB;

class RloudLiveService extends Service
{
    //获取云竞技直播列表
    public function getIndexRloudList(RloudLiveDTO $dto)
    {
        $builder = RloudLive::query();
        $builder->leftJoin('industry_tag', 'rloud_live.industry', 'industry_tag.id');
        $builder->leftJoin("organizations", 'rloud_live.org_id', '=', 'organizations.id');
        $builder->leftJoin("units", 'rloud_live.unit_id', '=', 'units.id');
        $builder->where('rloud_live.check_state', 1);//获取当前版本的数据
        $title = $dto->getTitle();
        $title && $builder->where(function ($query) use ($title) {
            $query->where('rloud_live.title', 'like', '%' . $title . '%')->orWhere('organizations.name', 'like', '%' . $title . '%');

        });
        $dto->getType() && $builder->where('rloud_live.type', $dto->getType());
        $response = $builder->select(["rloud_live.img_url", "rloud_live.title", "rloud_live.video_url", "rloud_live.content", "rloud_live.browse_count","rloud_live.virtual_traffic", "organizations.name as organizations_name", "units.name as units_name", "industry_tag.industry_name"])->orderByDesc('rloud_live.created_at')->paginate($dto->getPageSize());
        return $response;
    }


    /**
     * 获取竞赛相关信息
     */
    public function getCompetition()
    {
        //获取赛事精神
        $competition = ServiceHelper::make('Index\NewsService')->getCompetition();

        //获取赛事新闻
        $news = ServiceHelper::make('Index\NewsService')->getNewsList(new NewsDTO(['system_version' => 'js', 'pageSize' => '4']));

        $builder = RloudLive::query();
        $builder->where('check_state', 1);//审核通过
        $builder->where('type', 4);//重点竞赛视频
        $rloud = $builder->select(["rloud_live.img_url", "rloud_live.title", "rloud_live.video_url", "rloud_live.content", "rloud_live.browse_count"])->orderByDesc('created_at')->get();

        //获取参赛企业 分页5条
        $orgSql = "SELECT * FROM organizations 
WHERE	EXISTS ( SELECT plan.organization_id  FROM organizations_plan plan WHERE organizations.id = plan.organization_id AND plan.check_state > 0 )
and `is_competition` =1 
	 LIMIT 0,5" ;

        $org= DB::select($orgSql);

        return ['competition' => $competition, 'news' => $news, 'rloud' => $rloud,'org'=>$org];
    }
}