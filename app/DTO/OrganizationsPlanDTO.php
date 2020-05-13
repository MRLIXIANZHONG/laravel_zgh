<?php


namespace App\DTO;


class OrganizationsPlanDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id;

    /**
     * @var integer | null
     * @description 工会id
     */
    private $unitId;

    /**
     * @var integer | null
     * @description 参赛企业ID
     */
    private $organizationId;

    /**
     * @var string | null
     * @description 方案名称
     */
    private $planName;

    /**
     * @var string | null
     * @description 方案概述
     */
    private $summary;

    /**
     * @var string | null
     * @description 方案内容
     */
    private $content;

    /**
     * @var string | null
     * @description 方案目标
     */
    private $targetTask;

    /**
     * @var string | null
     * @description 绩效目标
     */
    private $achievementTarget;

    /**
     * @var string | null
     * @description 实施措施
     */
    private $measures;

    /**
     * @var string | null
     * @description 表彰奖励
     */
    private $commend;

    /**
     * @var string | null
     * @description 方案图片地址
     */
    private $imgUrl;

    /**
     * @var string | null
     * @description 参赛员工
     */
    private $staffsInfo;

    /**
     * @var integer | null
     * @description 0未审核1基层工会审核通过-1基层工会审核驳回2活动方通未审核3活动方通过 -3活动房驳回4总工会未审核5总工会审核-5总工会驳回
     */
    private $checkState;

    /**
     * @var string | null
     * @description 创建时间
     */
    private $createdAt;

    /**
     * @var string | null
     * @description 更新时间
     */
    private $updatedAt;

    /**
     * @var integer | null
     * @description 项目等级 0非重点 1市重点 2国家重点
     */
    private $grade;

    /**
     * @var integer | null
     * @description 点赞数
     */
    private $starCount;

    /**
     * @var integer | null
     * @description 浏览数
     */
    private $browseCount;

    /**
     * @var integer | null
     * @description 页面数
     */
    private $pagelimite;

    /**
     * @var integer | null
     * @description 是否推荐
     */
    private $isrecommend;

    /**
     * @var integer | null
     * @description 是否优秀
     */
    private $isexcellent;

    /**
     * @var string | null
     * @description 是否删除
     */
    private $deletedAt;

    /**
     * @var int | null
     * @description 虚拟浏览量
     */
    private $fictitiousBrowseCount;

    /**
     * @var int | null
     * @description 虚拟点赞数
     */
    private $fictitiousStarCount;

    /**
     * @var int | null
     * @description 农名工数量
     */
    private $farmerCount;

    /**
     * @var string | null
     * @description 分享标题/PC端页面tile
     */
    private $shareTitle;

    /**
     * @var string | null
     * @description 分享方案描述
     */
    private $shareContent;

    /**
     * @var string | null
     * @description 分享方案封面地址
     */
    private $shareImgUrl;

    /**
     * @var int | null
     * @description 方案主题 0节能减排 1灾害防治 2安全生产 3脱贫攻坚 4安全生产 5其他
     */
    private $planTheme;

    /**
     * @var string | null
     * @description 方案介绍
     */
    private $themeInfo;

    /**
     * @var int | null
     * @description 竞赛绩效（万元）
     */
    private $achievements;

    /**
     * @var string | null
     * @description 竞赛自评
     */
    private $achievementsInfo;

    /**
     * @var string | null
     * @description 企业名(只是查询不对应表)
     */
    private $organizationName;

    /**
     * @var string | null
     * @description 组织类型(只是查询不对应表)
     */
    private $newType;

    /**
     * @var string | null
     * @description 行业(只是查询不对应表)
     */
    private $industry;

    /**
     * @var string | null
     * @description 驳回原因
     */
    private $nopassinfo;

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
     * @return int|null
     */
    public function getOrganizationId():? int
    {
        return $this->organizationId;
    }

    /**
     * @param int|null $organizationId
     */
    public function setOrganizationId(?int $organizationId)
    {
        $this->organizationId = $organizationId;
    }

    /**
     * @return string|null
     */
    public function getPlanName():? string
    {
        return $this->planName;
    }

    /**
     * @param string|null $planName
     */
    public function setPlanName(?string $planName)
    {
        $this->planName = $planName;
    }

    /**
     * @return string|null
     */
    public function getSummary():? string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     */
    public function setSummary(?string $summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string|null
     */
    public function getContent():? string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getTargetTask():? string
    {
        return $this->targetTask;
    }

    /**
     * @param string|null $targetTask
     */
    public function setTargetTask(?string $targetTask)
    {
        $this->targetTask = $targetTask;
    }

    /**
     * @return string|null
     */
    public function getAchievementTarget():? string
    {
        return $this->achievementTarget;
    }

    /**
     * @param string|null $achievementTarget
     */
    public function setAchievementTarget(?string $achievementTarget)
    {
        $this->achievementTarget = $achievementTarget;
    }

    /**
     * @return string|null
     */
    public function getMeasures(): ?string
    {
        return $this->measures;
    }

    /**
     * @param string|null $measures
     */
    public function setMeasures(?string $measures)
    {
        $this->measures = $measures;
    }

    /**
     * @return string|null
     */
    public function getCommend():? string
    {
        return $this->commend;
    }

    /**
     * @param string|null $commend
     */
    public function setCommend(?string $commend)
    {
        $this->commend = $commend;
    }

    /**
     * @return string|null
     */
    public function getImgUrl():? string
    {
        return $this->imgUrl;
    }

    /**
     * @param string|null $imgUrl
     */
    public function setImgUrl(?string $imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return string|null
     */
    public function getStaffsInfo():? string
    {
        return $this->staffsInfo;
    }

    /**
     * @param string|null $staffsInfo
     */
    public function setStaffsInfo(?string $staffsInfo)
    {
        $this->staffsInfo = $staffsInfo;
    }

    /**
     * @return int|null
     */
    public function getCheckState():? int
    {
        return $this->checkState;
    }

    /**
     * @param int|null $checkState
     */
    public function setCheckState(?int $checkState)
    {
        $this->checkState = $checkState;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt():? string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt)
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
    public function setUpdatedAt(?string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int|null
     */
    public function getGrade():? int
    {
        return $this->grade;
    }

    /**
     * @param int|null $grade
     */
    public function setGrade(?int $grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return int|null
     */
    public function getStarCount():? int
    {
        return $this->starCount;
    }

    /**
     * @param int|null $starCount
     */
    public function setStarCount(?int $starCount)
    {
        $this->starCount = $starCount;
    }

    /**
     * @return int|null
     */
    public function getBrowseCount():? int
    {
        return $this->browseCount;
    }

    /**
     * @param int|null $browseCount
     */
    public function setBrowseCount(?int $browseCount)
    {
        $this->browseCount = $browseCount;
    }

    /**
     * @return int|null
     */
    public function getPagelimite():? int
    {
        return $this->pagelimite;
    }
    
    /**
     * @return int|null
     */
    public function getIsrecommend():? int
    {
        return $this->isrecommend;
    }

    /**
     * @param int|null $isrecommend
     */
    public function setIsrecommend(?int $isrecommend)
    {
        $this->isrecommend = $isrecommend;
    }

    /**
     * @return int|null
     */
    public function getIsexcellent(): ?int
    {
        return $this->isexcellent;
    }

    /**
     * @param int|null $isexcellent
     */
    public function setIsexcellent(?int $isexcellent)
    {
        $this->isexcellent = $isexcellent;
    }

    /**
     * @return int|null
     */
    public function getFictitiousBrowseCount():? int
    {
        return $this->fictitiousBrowseCount;
    }

    /**
     * @param int|null $fictitiousBrowseCount
     */
    public function setFictitiousBrowseCount(?int $fictitiousBrowseCount)
    {
        $this->fictitiousBrowseCount = $fictitiousBrowseCount;
    }

    /**
     * @return int|null
     */
    public function getFictitiousStarCount():? int
    {
        return $this->fictitiousStarCount;
    }

    /**
     * @param int|null $fictitiousStarCount
     */
    public function setFictitiousStarCount(?int $fictitiousStarCount)
    {
        $this->fictitiousStarCount = $fictitiousStarCount;
    }

    /**
     * @return int|null
     */
    public function getFarmerCount(): ?int
    {
        return $this->farmerCount;
    }

    /**
     * @param int|null $farmerCount
     */
    public function setFarmerCount(?int $farmerCount)
    {
        $this->farmerCount = $farmerCount;
    }

    /**
     * @return string|null
     */
    public function getShareTitle():? string
    {
        return $this->shareTitle;
    }

    /**
     * @param string|null $shareTitle
     */
    public function setShareTitle(?string $shareTitle)
    {
        $this->shareTitle = $shareTitle;
    }

    /**
     * @return string|null
     */
    public function getShareContent(): ?string
    {
        return $this->shareContent;
    }

    /**
     * @param string|null $shareContent
     */
    public function setShareContent(?string $shareContent)
    {
        $this->shareContent = $shareContent;
    }

    /**
     * @return string|null
     */
    public function getShareImgUrl():? string
    {
        return $this->shareImgUrl;
    }

    /**
     * @param string|null $shareImgUrl
     */
    public function setShareImgUrl(?string $shareImgUrl)
    {
        $this->shareImgUrl = $shareImgUrl;
    }

    /**
     * @return int|null
     */
    public function getUnitId():? int
    {
        return $this->unitId;
    }

    /**
     * @param int|null $unitId
     */
    public function setUnitId(?int $unitId)
    {
        $this->unitId = $unitId;
    }

    /**
     * @return int|null
     */
    public function getPlanTheme():? int
    {
        return $this->planTheme;
    }

    /**
     * @param int|null $planTheme
     */
    public function setPlanTheme(?int $planTheme)
    {
        $this->planTheme = $planTheme;
    }

    /**
     * @return string|null
     */
    public function getThemeInfo(): ?string
    {
        return $this->themeInfo;
    }

    /**
     * @param string|null $themeInfo
     */
    public function setThemeInfo(?string $themeInfo)
    {
        $this->themeInfo = $themeInfo;
    }

    /**
     * @return int|null
     */
    public function getAchievements(): ?int
    {
        return $this->achievements;
    }

    /**
     * @param int|null $achievements
     */
    public function setAchievements(?int $achievements)
    {
        $this->achievements = $achievements;
    }

    /**
     * @return string|null
     */
    public function getAchievementsInfo():? string
    {
        return $this->achievementsInfo;
    }

    /**
     * @param string|null $achievementsInfo
     */
    public function setAchievementsInfo(?string $achievementsInfo)
    {
        $this->achievementsInfo = $achievementsInfo;
    }

    /**
     * @return string|null
     */
    public function getOrganizationName():? string
    {
        return $this->organizationName;
    }

    /**
     * @param string|null $organizationName
     */
    public function setOrganizationName(?string $organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return string|null
     */
    public function getNewType():? string
    {
        return $this->newType;
    }

    /**
     * @param string|null $newType
     */
    public function setNewType(?string $newType)
    {
        $this->newType = $newType;
    }

    /**
     * @return string|null
     */
    public function getIndustry():? string
    {
        return $this->industry;
    }

    /**
     * @param string|null $industry
     */
    public function setIndustry(?string $industry)
    {
        $this->industry = $industry;
    }

    /**
     * @return string|null
     */
    public function getNopassinfo():? string
    {
        return $this->nopassinfo;
    }

    /**
     * @param string|null $nopassinfo
     */
    public function setNopassinfo(?string  $nopassinfo)
    {
        $this->nopassinfo = $nopassinfo;
    }

}