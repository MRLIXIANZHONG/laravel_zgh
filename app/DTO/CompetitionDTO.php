<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class CompetitionDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var string | null
     * @description 首页描述
     */
    private  $home_mark;
    /**
     * @var string | null
     * @description 首页图片
     */
    private  $home_img;
    /**
     * @var string | null
     * @description 主题标题
     */
    private  $theme_title;
    /**
     * @var string | null
     * @description 主题描述
     */
    private  $theme_mark;
    /**
     * @var string | null
     * @description 主题图标
     */
    private  $theme_img;
    /**
     * @var string | null
     * @description 专题描述
     */
    private  $special_mark;
    /**
     * @var string | null
     * @description 专题图片
     */
    private  $special_img;
    /**
     * @var integer | null
     * @description 参赛企业0 不显示 1 显示
     */
    private  $org_show;
    /**
     * @var integer | null
     * @description 竞赛新闻 0不显示 1 显示
     */
    private  $news_show;
    /**
     * @var integer | null
     * @description 竞赛视频 0 不显示 1 显示
     */
    private  $video_show;
    /**
     * @var datetime | null
     * @description 创建时间
     */
    private $created_at;
    /**
     * @var datetime | null
     * @description 修改时间
     */
    private $updated_at;
    /**
     * @var datetime | null
     * @description 删除时间
     */
    private $deleted_at;

    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getHomeMark(): string
    {
        return $this->home_mark;
    }

    /**
     * @param string|null $home_mark
     */
    public function setHomeMark(string $home_mark)
    {
        $this->home_mark = $home_mark;
    }

    /**
     * @return string|null
     */
    public function getHomeImg(): string
    {
        return $this->home_img;
    }

    /**
     * @param string|null $home_img
     */
    public function setHomeImg(string $home_img)
    {
        $this->home_img = $home_img;
    }

    /**
     * @return string|null
     */
    public function getThemeTitle(): string
    {
        return $this->theme_title;
    }

    /**
     * @param string|null $theme_title
     */
    public function setThemeTitle(string $theme_title)
    {
        $this->theme_title = $theme_title;
    }

    /**
     * @return string|null
     */
    public function getThemeMark(): string
    {
        return $this->theme_mark;
    }

    /**
     * @param string|null $theme_mark
     */
    public function setThemeMark(string $theme_mark)
    {
        $this->theme_mark = $theme_mark;
    }

    /**
     * @return string|null
     */
    public function getThemeImg(): string
    {
        return $this->theme_img;
    }

    /**
     * @param string|null $theme_img
     */
    public function setThemeImg(string $theme_img)
    {
        $this->theme_img = $theme_img;
    }

    /**
     * @return string|null
     */
    public function getSpecialMark(): string
    {
        return $this->special_mark;
    }

    /**
     * @param string|null $special_mark
     */
    public function setSpecialMark(string $special_mark)
    {
        $this->special_mark = $special_mark;
    }

    /**
     * @return string|null
     */
    public function getSpecialImg(): string
    {
        return $this->special_img;
    }

    /**
     * @param string|null $special_img
     */
    public function setSpecialImg(string $special_img)
    {
        $this->special_img = $special_img;
    }

    /**
     * @return int|null
     */
    public function getOrgShow(): int
    {
        return $this->org_show;
    }

    /**
     * @param int|null $org_show
     */
    public function setOrgShow(int $org_show)
    {
        $this->org_show = $org_show;
    }

    /**
     * @return int|null
     */
    public function getNewsShow(): int
    {
        return $this->news_show;
    }

    /**
     * @param int|null $news_show
     */
    public function setNewsShow(int $news_show)
    {
        $this->news_show = $news_show;
    }

    /**
     * @return int|null
     */
    public function getVideoShow(): int
    {
        return $this->video_show;
    }

    /**
     * @param int|null $video_show
     */
    public function setVideoShow(int $video_show)
    {
        $this->video_show = $video_show;
    }

    /**
     * @return datetime|null
     */
    public function getCreatedAt(): datetime
    {
        return $this->created_at;
    }

    /**
     * @param datetime|null $created_at
     */
    public function setCreatedAt(datetime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return datetime|null
     */
    public function getUpdatedAt(): datetime
    {
        return $this->updated_at;
    }

    /**
     * @param datetime|null $updated_at
     */
    public function setUpdatedAt(datetime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return datetime|null
     */
    public function getDeletedAt(): datetime
    {
        return $this->deleted_at;
    }

    /**
     * @param datetime|null $deleted_at
     */
    public function setDeletedAt(datetime $deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }


}