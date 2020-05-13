<?php


namespace App\Services\Admin;


use App\DTO\BannerDTO;
use App\DTO\CompetitionDTO;
use App\Models\Banner;
use App\Models\Competition;
use App\Services\Service;

class CompetitionService extends Service
{

    /**
     * 获取竞赛专题
     * @return 竞赛专题
     */
    public function getDetail()
    {
        return Competition::query()->find(1);
    }

    /**
     * 修改专题
     * @param CompetitionDTO $competitionDTO
     * @return string
     */
    public function saveCompetition(CompetitionDTO $competitionDTO)
    {
        $competition = Competition::query()->find(1);
        $competition->home_mark = $competitionDTO->getHomeMark();
        $competition->home_img = $competitionDTO->getHomeImg();
        $competition->theme_title = $competitionDTO->getThemeTitle();
        $competition->theme_mark = $competitionDTO->getThemeMark();
        $competition->theme_img = $competitionDTO->getThemeImg();
        $competition->special_mark = $competitionDTO->getSpecialMark();
        $competition->special_img = $competitionDTO->getSpecialImg();
        $competition->org_show = $competitionDTO->getOrgShow();
        $competition->news_show = $competitionDTO->getNewsShow();
        $competition->video_show = $competitionDTO->getVideoShow();
        $result = $competition->save();
        if ($result)
            return ['code' => '1000', 'msg' => '操作成功'];
        else
            return ['code' => '-1', 'msg' => '操作失败'];
    }
}