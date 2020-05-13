<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/9
 * Time: 16:25
 */

namespace App\DTO;


class OrganizationDTO extends DTO
{
    /**
     * @var int | null
     */
    protected $id;

    /**
     * @var array | null
     */
    protected $ids;

    /**
     * @var string | null  单位名称
     */
    protected $name;

    /**
     * @var int | null  1.国营控股企业 2.行政机关 3.港澳台、外商投资企业 4.民营控股企业 5.事业单位； 6.其他
     */
    protected $newType;

    /**
     * @var string | null   单位log
     */
    protected $photo;

    /**
     * @var array | null  行业标签
     */
    protected $industryTag;

    /**
     * @var string | null
     */
    protected $username;

    /**
     * @var string | null
     */
    protected $password;

    /**
     * @var string | null
     */
    protected $mobile;

    /**
     * @var int | null 上级工会
     */
    protected $unitId;

    /**
     * @var int | null 上级工会类型
     */
    protected $unitType;

    /**
     * @var string | null
     */
    protected $website;

    /**
     * @var string | null
     */
    protected $planName;

    /**
     * @var string | null
     */
    protected $summary;

    /**
     * @var string | null
     */
    protected $content;

    /**
     * @var string | null
     */
    protected $targetTask;

    /**
     * @var string | null
     */
    protected $achievementTarget;

    /**
     * @var string | null
     */
    protected $measures;

    /**
     * @var string | null
     */
    protected $commend;

    /**
     * @var string | null
     */
    protected $imgUrl;

    /**
     * @var string | null
     */
    protected $staffsInfo;

    /**
     * @var int | null   0未推送  1未审核   2审核通过  -1审核驳回
     */
    protected $checkState;

    /**
     * @var string | null
     */
    protected $createdAt;

    /**
     * @var string | null
     */
    protected $updatedAt;

    /**
     * @var int | null  项目等级 0非重点 1市重点 2国家重点
     */
    protected $grade;

    /**
     * @var int | null 员工总数
     */
    protected $staffCount;

    /**
     * @var string | null  农民工总数
     */
    protected $farmerCount;

    /**
     * @var string | null  账户
     */
    protected $account;

    /**
     * @var string | null  开户行
     */
    protected $bankName;

    /**
     * @var string | null   审核时间
     */
    protected $checkTime;

    /**
     * @var int | null   点赞数
     */
    protected $starCount;

    /**
     * @var string | null   浏览数
     */
    protected $browseCount;

    /**
     * @var array | null
     */
    protected $checkStates;

    /**
     * @var int | null
     */
    protected $virtualStar;

    /**
     * @var int | null
     */
    protected $virtualBrowse;

    /**
     * @var string | null
     */
    protected $rejectReason;

    /**
     * @var int | null  是否重点竞赛
     */
    protected $isCompetition;

    /**
     * @var string | null   分享标题
     */
    protected $shareTitle;

    /**
     * @var string | null   分享描述
     */
    protected $shareDescription;

    /**
     * @var string | null   分享图片
     */
    protected $shareImg;

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
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return array|null
     */
    public function getIds(): ?array
    {
        return $this->ids;
    }

    /**
     * @param array|null $ids
     */
    public function setIds(?array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getNewType(): ?int
    {
        return $this->newType;
    }

    /**
     * @param int|null $newType
     */
    public function setNewType(?int $newType)
    {
        $this->newType = $newType;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     */
    public function setPhoto(?string $photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return array|null
     */
    public function getIndustryTag(): ?array
    {
        return $this->industryTag;
    }

    /**
     * @param array|null $industryTag
     */
    public function setIndustryTag(?array $industryTag)
    {
        $this->industryTag = $industryTag;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     */
    public function setMobile(?string $mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    /**
     * @return int|null
     */
    public function getUnitType(): ?int
    {
        return $this->unitType;
    }

    /**
     * @param int|null $unitId
     */
    public function setUnitId(?int $unitId)
    {
        $this->unitId = $unitId;
    }

    /**
     * @param int|null $unitId
     */
    public function setUnitType(?int $unitType)
    {
        $this->unitType = $unitType;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     */
    public function setWebsite(?string $website)
    {
        $this->website = $website;
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
    public function setPlanName(?string $planName)
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
    public function setSummary(?string $summary)
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
    public function setContent(?string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getTargetTask(): ?string
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
    public function getAchievementTarget(): ?string
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
    public function getCommend(): ?string
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
    public function getImgUrl(): ?string
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
    public function getStaffsInfo(): ?string
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
    public function getCheckState(): ?int
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
    public function getCreatedAt(): ?string
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
    public function getGrade(): ?int
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
    public function getStaffCount(): ?int
    {
        return $this->staffCount;
    }

    /**
     * @param int|null $staffCount
     */
    public function setStaffCount(?int $staffCount)
    {
        $this->staffCount = $staffCount;
    }

    /**
     * @return string|null
     */
    public function getFarmerCount(): ?string
    {
        return $this->farmerCount;
    }

    /**
     * @param string|null $farmerCount
     */
    public function setFarmerCount(?string $farmerCount)
    {
        $this->farmerCount = $farmerCount;
    }

    /**
     * @return string|null
     */
    public function getAccount(): ?string
    {
        return $this->account;
    }

    /**
     * @param string|null $account
     */
    public function setAccount(?string $account)
    {
        $this->account = $account;
    }

    /**
     * @return string|null
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    /**
     * @param string|null $bankName
     */
    public function setBankName(?string $bankName)
    {
        $this->bankName = $bankName;
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
    public function setCheckTime(?string $checkTime)
    {
        $this->checkTime = $checkTime;
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
    public function setStarCount(?int $starCount)
    {
        $this->starCount = $starCount;
    }

    /**
     * @return string|null
     */
    public function getBrowseCount(): ?string
    {
        return $this->browseCount;
    }

    /**
     * @param string|null $browseCount
     */
    public function setBrowseCount(?string $browseCount)
    {
        $this->browseCount = $browseCount;
    }

    /**
     * @return array|null
     */
    public function getCheckStates(): ?array
    {
        return $this->checkStates;
    }

    /**
     * @param array|null $checkStates
     */
    public function setCheckStates(?array $checkStates)
    {
        $this->checkStates = $checkStates;
    }

    /**
     * @return int|null
     */
    public function getVirtualStar(): ?int
    {
        return $this->virtualStar;
    }

    /**
     * @param int|null $virtualStar
     */
    public function setVirtualStar(?int $virtualStar)
    {
        $this->virtualStar = $virtualStar;
    }

    /**
     * @return int|null
     */
    public function getVirtualBrowse(): ?int
    {
        return $this->virtualBrowse;
    }

    /**
     * @param int|null $virtualBrowse
     */
    public function setVirtualBrowse(?int $virtualBrowse)
    {
        $this->virtualBrowse = $virtualBrowse;
    }

    /**
     * @return string|null
     */
    public function getRejectReason(): ?string
    {
        return $this->rejectReason;
    }

    /**
     * @param string|null $rejectReason
     */
    public function setRejectReason(?string $rejectReason)
    {
        $this->rejectReason = $rejectReason;
    }

    /**
     * @return int|null
     */
    public function getIsCompetition(): ?int
    {
        return $this->isCompetition;
    }

    /**
     * @param int|null $isCompetition
     */
    public function setIsCompetition(?int $isCompetition)
    {
        $this->isCompetition = $isCompetition;
    }

    /**
     * @return string|null
     */
    public function getShareTitle(): ?string
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
    public function getShareDescription(): ?string
    {
        return $this->shareDescription;
    }

    /**
     * @param string|null $shareDescription
     */
    public function setShareDescription(?string $shareDescription)
    {
        $this->shareDescription = $shareDescription;
    }

    /**
     * @return string|null
     */
    public function getShareImg(): ?string
    {
        return $this->shareImg;
    }

    /**
     * @param string|null $shareImg
     */
    public function setShareImg(?string $shareImg)
    {
        $this->shareImg = $shareImg;
    }

}