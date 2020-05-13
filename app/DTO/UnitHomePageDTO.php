<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-23 下午 6:56
 */

namespace App\DTO;


class UnitHomePageDTO extends DTO
{
    /**
     * @var int | null
     * @description ＩＤ
     */
    private $id;
    /**
     * @var int | null
     * @description 工会ＩＤ
     */
    private $unitId;
    /**
     * @var string | null
     * @description 工会名称
     */
    private $unitName;
    /**
     * @var string | null
     * @description 工会地址
     */
    private $unitUrl;
    /**
     * @var string | null
     * @description 封面
     */
    private $cover;
    /**
     * @var int | null
     * @description 主题颜色
     */
    private $themeColor;
    /**
     * @var string | null
     * @description 页面标题
     */
    private $pageTitle;
    /**
     * @var string | null
     * @description 页面描述
     */
    private $pageDescribe;
    /**
     * @var string | null
     * @description 微信分享头像
     */
    private $wechatPhoto;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    /**
     * @param int|null $unitId
     */
    public function setUnitId(?int $unitId): void
    {
        $this->unitId = $unitId;
    }

    /**
     * @return string|null
     */
    public function getUnitName(): ?string
    {
        return $this->unitName;
    }

    /**
     * @param string|null $unitName
     */
    public function setUnitName(?string $unitName): void
    {
        $this->unitName = $unitName;
    }

    /**
     * @return string|null
     */
    public function getUnitUrl(): ?string
    {
        return $this->unitUrl;
    }

    /**
     * @param string|null $unitUrl
     */
    public function setUnitUrl(?string $unitUrl): void
    {
        $this->unitUrl = $unitUrl;
    }

    /**
     * @return string|null
     */
    public function getCover(): ?string
    {
        return $this->cover;
    }

    /**
     * @param string|null $cover
     */
    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return int|null
     */
    public function getThemeColor(): ?int
    {
        return $this->themeColor;
    }

    /**
     * @param int|null $themeColor
     */
    public function setThemeColor(?int $themeColor): void
    {
        $this->themeColor = $themeColor;
    }

    /**
     * @return string|null
     */
    public function getPageTitle(): ?string
    {
        return $this->pageTitle;
    }

    /**
     * @param string|null $pageTitle
     */
    public function setPageTitle(?string $pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string|null
     */
    public function getPageDescribe(): ?string
    {
        return $this->pageDescribe;
    }

    /**
     * @param string|null $pageDescribe
     */
    public function setPageDescribe(?string $pageDescribe): void
    {
        $this->pageDescribe = $pageDescribe;
    }

    /**
     * @return string|null
     */
    public function getWechatPhoto(): ?string
    {
        return $this->wechatPhoto;
    }

    /**
     * @param string|null $wechatPhoto
     */
    public function setWechatPhoto(?string $wechatPhoto): void
    {
        $this->wechatPhoto = $wechatPhoto;
    }


}