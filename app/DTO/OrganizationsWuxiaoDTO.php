<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-11 上午 11:55
 */

namespace App\DTO;


class OrganizationsWuxiaoDTO extends DTO
{

    /**
     * @var int | null
     * @description 五小ID
     */
    private $id;
    /**
     * @var int | null
     * @description 参赛企业ID
     */
    private $organizationId;
    /**
     * @var int|null
     */
    private $unitId;
    /**
     * @var int | null
     * @description 五小类型：1小发明 2小创造 3小革新 4小建议 5小设计'
     */
    private $type;
    /**
     * @var string | null
     * @description 五小名称
     */
    private $planName;
    /**
     * @var string | null
     * @description 五小概述
     */
    private $summary;
    /**
     * @var string | null
     * @description 五小内容 班组集体介绍
     */
    private $content;
    /**
     * @var string | null
     * @description 五小图片地址 ，号分割
     */
    private $imgUrl;
    /**
     * @var string | null
     * @description 五小视频地址 ，号分割
     */
    private $videoUrl;
    /**
     * @var int | null
     * @description 0未审核   1基层工会审核通过  2基层工会驳回 3总工会审核通过 4总工会驳回
     */
    private $checkState;
    /**
     * @var string | null
     * @description 五小名称
     */
    private $createdAt;
    /**
     * @var string | null
     * @description 五小名称
     */
    private $updatedAt;
    /**
     * @var int | null
     * @description 浏览数
     */
    private $browseCount;
    /**
     * @var int | null
     * @description 点赞数
     */
    private $starCount;
    /**
     * @var string|null
     * @description 封面图片
     */
    private $cover;
    /**
     * @var int |null
     * @description 申报状态 0未申报 2 基础工会已申报 1企业已申报
     */
    private $declarationState;
    /**
     * @var string |null
     * @description 审核时间（最新审核时间）
     */
    private $checkTime;
    /**
     * @var string |null
     * @description 审核意见
     */
    private $checkOpinion;
    /**
     * @var string |null
     * @description 所获奖项
     */
    private $awards;

    /**
     * @var string |null
     * @description 企业名称
     */
    private $organizationName;
    /**
     * @var string |null
     * @description 申报时间
     */
    private $declarationTime;
    /**
     * @var string |null
     * @description 获得奖项
     */
    private $reward;
    /**
     * @var int |null
     * @description 获得奖项
     */
    private $industryId;
    /**
     * @var int |null
     * @description 获得奖项
     */
    private $caseSchemeId;
    /**
     * @description  是否获奖
     * @var int | null
     */
    private $isWin;
    /**
     * @description  虚拟浏览数量
     * @var int | null
     */
    private $vBrowseCount;
    /**
     * 微信的Openid
     * @var string |null
     */
    private $openid;
    /**
     * @description  获奖类型 1月度 2季度 3年度
     * @var int | null
     */
    private $isWinType;
    /**
     * @description  推荐到前台
     * @var int | null
     */
    private $recommend;

    /**
     * @return int|null
     */
    public function getRecommend(): ?int
    {
        return $this->recommend;
    }

    /**
     * @param int|null $recommend
     */
    public function setRecommend(?int $recommend): void
    {
        $this->recommend = $recommend;
    }
    /**
     * @description  获奖类型 1月度 2季度 3年度
     * @var string | null
     */
    private $keyword;

    /**
     * @return int|null
     */
    public function getAdminid(): ?int
    {
        return $this->adminid;
    }

    /**
     * @param int|null $adminid
     */
    public function setAdminid(?int $adminid): void
    {
        $this->adminid = $adminid;
    }

    /**
     * @description
     * @var int | null
     */
    private $adminid;

    /**
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    /**
     * @param string|null $keyword
     */
    public function setKeyword(?string $keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @var array | null
     */
    private $organizationIds;

    /**
     * @return int|null
     */
    public function getIsWinType(): ?int
    {
        return $this->isWinType;
    }

    /**
     * @param int|null $isWinType
     */
    public function setIsWinType(?int $isWinType): void
    {
        $this->isWinType = $isWinType;
    }

    /**
     * @return string|null
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @param string|null $openid
     */
    public function setOpenid(?string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return int|null
     */
    public function getVBrowseCount(): ?int
    {
        return $this->vBrowseCount;
    }

    /**
     * @param int|null $vBrowseCount
     */
    public function setVBrowseCount(?int $vBrowseCount): void
    {
        $this->vBrowseCount = $vBrowseCount;
    }

    /**
     * @return int|null
     */
    public function getVStarCount(): ?int
    {
        return $this->vStarCount;
    }

    /**
     * @param int|null $vStarCount
     */
    public function setVStarCount(?int $vStarCount): void
    {
        $this->vStarCount = $vStarCount;
    }

    /**
     * @description  虚拟点赞数量
     * @var int |null
     */
    private $vStarCount;


    /**
     * @return int|null
     */
    public function getIsWin(): ?int
    {
        return $this->isWin;
    }

    /**
     * @param int|null $isWin
     */
    public function setIsWin(?int $isWin): void
    {
        $this->isWin = $isWin;
    }

    /**
     * @return int|null
     */
    public function getCaseSchemeId(): ?int
    {
        return $this->caseSchemeId;
    }

    /**
     * @param int|null $caseSchemeId
     */
    public function setCaseSchemeId(?int $caseSchemeId): void
    {
        $this->caseSchemeId = $caseSchemeId;
    }

    /**
     * @return int|null
     */
    public function getorgType(): ?int
    {
        return $this->orgType;
    }

    /**
     * @param int|null $orgType
     */
    public function setorgType(?int $orgType): void
    {
        $this->orgType = $orgType;
    }

    /**
     * @var int |null
     * @description 企业类型
     */
    public $orgType;

    /**
     * @return int|null
     */
    public function getIndustryId(): ?int
    {
        return $this->industryId;
    }

    /**
     * @param int|null $industryId
     */
    public function setIndustryId(?int $industryId): void
    {
        $this->industryId = $industryId;
    }

    /**
     * @return string|null
     */
    public function getReward(): ?string
    {
        return $this->reward;
    }

    /**
     * @param string|null $reward
     */
    public function setReward(?string $reward): void
    {
        $this->reward = $reward;
    }

    /**
     * @return string|null
     */
    public function getDeclarationTime(): ?string
    {
        return $this->declarationTime;
    }

    /**
     * @param string|null $declarationTime
     */
    public function setDeclarationTime(?string $declarationTime): void
    {
        $this->declarationTime = $declarationTime;
    }

    /**
     * @return string|null
     */
    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }

    /**
     * @param string|null $organizationName
     */
    public function setOrganizationName(?string $organizationName): void
    {
        $this->organizationName = $organizationName;
    }

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
    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    /**
     * @param int|null $organizationId
     */
    public function setOrganizationId(?int $organizationId): void
    {
        $this->organizationId = $organizationId;
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
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     */
    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getPlanName(): ?string
    {
        return $this->planName;
    }

    /**
     * @param string|null $planName
     */
    public function setPlanName(?string $planName): void
    {
        $this->planName = $planName;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     */
    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    /**
     * @param string|null $imgUrl
     */
    public function setImgUrl(?string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return string|null
     */
    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    /**
     * @param string|null $videoUrl
     */
    public function setVideoUrl(?string $videoUrl): void
    {
        $this->videoUrl = $videoUrl;
    }

    /**
     * @return int|null
     */
    public function getCheckState(): ?int
    {
        return $this->checkState;
    }

    /**
     * @param int|null $checkState
     */
    public function setCheckState(?int $checkState): void
    {
        $this->checkState = $checkState;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int|null
     */
    public function getBrowseCount(): ?int
    {
        return $this->browseCount;
    }

    /**
     * @param int|null $browseCount
     */
    public function setBrowseCount(?int $browseCount): void
    {
        $this->browseCount = $browseCount;
    }

    /**
     * @return int|null
     */
    public function getStarCount(): ?int
    {
        return $this->starCount;
    }

    /**
     * @param int|null $starCount
     */
    public function setStarCount(?int $starCount): void
    {
        $this->starCount = $starCount;
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
    public function getDeclarationState(): ?int
    {
        return $this->declarationState;
    }

    /**
     * @param int|null $declarationState
     */
    public function setDeclarationState(?int $declarationState): void
    {
        $this->declarationState = $declarationState;
    }

    /**
     * @return string|null
     */
    public function getCheckTime(): ?string
    {
        return $this->checkTime;
    }

    /**
     * @param string|null $checkTime
     */
    public function setCheckTime(?string $checkTime): void
    {
        $this->checkTime = $checkTime;
    }

    /**
     * @return string|null
     */
    public function getCheckOpinion(): ?string
    {
        return $this->checkOpinion;
    }

    /**
     * @param string|null $checkOpinion
     */
    public function setCheckOpinion(?string $checkOpinion): void
    {
        $this->checkOpinion = $checkOpinion;
    }

    /**
     * @return string|null
     */
    public function getAwards(): ?string
    {
        return $this->awards;
    }

    /**
     * @param string|null $awards
     */
    public function setAwards(?string $awards): void
    {
        $this->awards = $awards;
    }

    /**
     * @return string|null
     */
    public function getAwardsTime(): ?string
    {
        return $this->awardsTime;
    }

    /**
     * @param string|null $awardsTime
     */
    public function setAwardsTime(?string $awardsTime): void
    {
        $this->awardsTime = $awardsTime;
    }

    /**
     * @var string |null
     * @description 获奖时间
     */
    private $awardsTime;

    /**
     * @return array|null
     */
    public function getOrganizationIds(): ?array
    {
        return $this->organizationIds;
    }

    /**
     * @param array|null $organizationIds
     */
    public function setOrganizationIds(?array $organizationIds)
    {
        $this->organizationIds = $organizationIds;
    }

}