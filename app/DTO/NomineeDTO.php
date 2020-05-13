<?php


namespace App\DTO;


class NomineeDTO extends DTO
{

    /**
     * @var integer
     * @description
     */
    private $id;
    /**
     * @var int
     * @description 参赛员工ID
     */
    private $staffId;
    /**
     * @var string
     * @description 参赛员工姓名
     */
    private $staffName;
    /**
     * @var string|null
     * @description 参赛员工电话
     */
    private $staffPhone;
    /**
     * @var string|null
     * @description 银行卡号
     */
    private $bankCard;
    /**
     * @var string|null
     * @description 开户行
     */
    private $bankName;
    /**
     * @var string|null
     * @description 开户姓名
     */
    private $bankStaffName;
    /**
     * @var int|null
     * @description 参赛企业ID
     */
    private $organizationId;
    /**
     * @var string|null
     * @description 参赛企业名称
     */
    private $organizationName;
    /**
     * @var int|null
     * @description 审核工会ID
     */
    private $unitId;
    /**
     * @var string|null
     * @description 工会Name
     */
    private $unitName;
    /**
     * 关键字
     * @var string|null
     */
    private $keyword;
    /**
     * 微信的OPENID
     * @var string|null
     */
    private $openid;

    /**
     * @description  获奖类型 1月度 2季度 3年度
     * @var int | null
     */
    private $isWinType;

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
     * @var int|null
     * @description 推荐类型：1劳动之星，2技能之星，3创新之星，4服务之星
     */
    private $kind;
    /**
     * @var string|null
     * @description 推荐理由
     */
    private $caption;
    /**
     * @var string|null
     * @description 月度被选中时间
     */
    private $monthWin;
    /**
     * @var string
     * @description 季度被选中
     */
    private $quarterWin;
    /**
     * @var string |null
     * @description 年度被选中
     */
    private $yearWin;
    /**
     * @var int|null
     * @description 所属参赛时间节点ID
     */
    private $caseSchemeId;
    /**
     * @var int|null
     * @description 季度投票排名
     */
    private $quarterRank;
    /**
     * @var int|null
     * @description 年度投票排名
     */
    private $yearRank;
    /**
     * @var string |null
     */
    private $createdAt;
    /**
     * @var string |null
     */
    private $updatedAt;
    /**
     * @var string |null
     */
    private $deletedAt;
    /**
     * @var string |null
     */
    private $quart;
    /**
     * @var string |null
     */
    private $quarterVoteSum;
    /**
     * @var string |null
     */
    private $yearVoteSum;
    /**
     * @var string |null
     * @description 查询关键字
     */
    private $systemVersion;
    /**
     * @var string |null
     * @description 关联的方案ID
     */
    private $planId;
    /**
     * @var int |null
     * @description 行业
     */
    private $industryId;
    /**
     * @var string |null
     * @description 银行卡图片
     */
    private $bankCardImg;
    /**
     * @var int |null
     * @description 企业类型
     */
    private $orgType;

    /**
     * @var int | null
     * description 申报状态
     */
    private $declareStatus;
    /**
     * @var int | null
     * description 审核状态
     */
    private $checkStatus;

//    private  $declareAt;
    /**
     * @var string | null
     * description 审核意见
     */
    private $checkOpinion;

    /**
     * @description  数据列表分类 0 全部  1 待审核 2 已申报/待审核 3 已审核 4 已驳回 5已获奖
     * @var int | null
     */
    private $classList;
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
     * @description  年份
     * @var int | null
     */
    private $yearpart;
    /**
     * @description
     * @var int | null
     */
    private $adminid;

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
     * @return int|null
     */
    public function getYearpart(): ?int
    {
        return $this->yearpart;
    }

    /**
     * @param int|null $yearpart
     */
    public function setYearpart(?int $yearpart): void
    {
        $this->yearpart = $yearpart;
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
    public function getCheckStatus(): ?int
    {
        return $this->checkStatus;
    }

    /**
     * @return int|null
     */
    public function getClassList(): ?int
    {
        return $this->classList;
    }

    /**
     * @param int|null $classList
     */
    public function setClassList(?int $classList): void
    {
        $this->classList = $classList;
    }

    /**
     * @param int|null $checkStatus
     */
    public function setCheckStatus(?int $checkStatus): void
    {
        $this->checkStatus = $checkStatus;
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
     * @return int|null
     */
    public function getDeclareStatus(): ?int
    {
        return $this->declareStatus;
    }

    /**
     * @param int|null $declareStatus
     */
    public function setDeclareStatus(?int $declareStatus): void
    {
        $this->declareStatus = $declareStatus;
    }

    /**
     * @return int|null
     */
    public function getOrgType(): ?int
    {
        return $this->orgType;
    }

    /**
     * @param int|null $orgType
     */
    public function setOrgType(?int $orgType): void
    {
        $this->orgType = $orgType;
    }

    /**
     * @return string|null
     */
    public function getBankCardImg(): ?string
    {
        return $this->bankCardImg;
    }

    /**
     * @param string|null $bankCardImg
     */
    public function setBankCardImg(?string $bankCardImg): void
    {
        $this->bankCardImg = $bankCardImg;
    }

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
    public function getStaffImg(): ?string
    {
        return $this->staffImg;
    }

    /**
     * @param string|null $staffImg
     */
    public function setStaffImg(?string $staffImg)
    {
        $this->staffImg = $staffImg;
    }

    /**
     * @var string |null
     * @description 关联的方案ID
     */
    private $staffImg;

    /**
     * @return string|null
     */
    public function getPlanId(): ?string
    {
        return $this->planId;
    }

    /**
     * @param string|null $planId
     */
    public function setPlanId(?string $planId): void
    {
        $this->planId = $planId;
    }


    /**
     * @return string|null
     */
    public function getSystemVersion(): ?string
    {
        return $this->systemVersion;
    }

    /**
     * @param string|null $systemVersion
     */
    public function setSystemVersion(?string $systemVersion)
    {
        $this->systemVersion = $systemVersion;
    }

    /**
     * @return string|null
     */


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStaffId()
    {
        return $this->staffId;
    }

    /**
     * @param int $staffId
     */
    public function setStaffId(?int $staffId): void
    {
        $this->staffId = $staffId;
    }

    /**
     * @return string
     */
    public function getStaffName(): ?string
    {
        return $this->staffName;
    }

    /**
     * @param string $staffName
     * @return string|null
     */
    public function setStaffName(?string $staffName)
    {
        $this->staffName = $staffName;
    }

    /**
     * @return string|null
     */
    public function getStaffPhone(): ?string
    {
        return $this->staffPhone;
    }

    /**
     * @param string|null $staffPhone
     */
    public function setStaffPhone(?string $staffPhone)
    {
        $this->staffPhone = $staffPhone;
    }

    /**
     * @return string|null
     */
    public function getBankCard(): ?string
    {
        return $this->bankCard;
    }

    /**
     * @param string|null $bankCard
     */
    public function setBankCard(?string $bankCard)
    {
        $this->bankCard = $bankCard;
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
    public function setBankName(?string $bankName): void
    {
        $this->bankName = $bankName;
    }

    /**
     * @return string|null
     */
    public function getBankStaffName(): ?string
    {
        return $this->bankStaffName;
    }

    /**
     * @param string|null $bankStaffName
     */
    public function setBankStaffName(?string $bankStaffName): void
    {
        $this->bankStaffName = $bankStaffName;
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
    public function getKind(): ?int
    {
        return $this->kind;
    }

    /**
     * @param int|null $kind
     */
    public function setKind(?int $kind): void
    {
        $this->kind = $kind;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     */
    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return string|null
     */
    public function getMonthWin(): ?string
    {
        return $this->monthWin;
    }

    /**
     * @param string|null $monthWin
     */
    public function setMonthWin(?string $monthWin): void
    {
        $this->monthWin = $monthWin;
    }

    /**
     * @return string
     */
    public function getQuarterWin(): ?string
    {
        return $this->quarterWin;
    }

    /**
     * @param string $quarterWin
     */
    public function setQuarterWin(string $quarterWin): void
    {
        $this->quarterWin = $quarterWin;
    }

    /**
     * @return string|null
     */
    public function getYearWin(): ?string
    {
        return $this->yearWin;
    }

    /**
     * @param string|null $yearWin
     */
    public function setYearWin(?string $yearWin): void
    {
        $this->yearWin = $yearWin;
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
    public function getQuarterRank(): ?int
    {
        return $this->quarterRank;
    }

    /**
     * @param int|null $quarterRank
     */
    public function setQuarterRank(?int $quarterRank): void
    {
        $this->quarterRank = $quarterRank;
    }

    /**
     * @return int|null
     */
    public function getYearRank(): ?int
    {
        return $this->yearRank;
    }

    /**
     * @param int|null $yearRank
     */
    public function setYearRank(?int $yearRank): void
    {
        $this->yearRank = $yearRank;
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
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @param string|null $deletedAt
     */
    public function setDeletedAt(?string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return string|null
     */
    public function getQuart(): ?string
    {
        return $this->quart;
    }

    /**
     * @param string|null $quart
     */
    public function setQuart(?string $quart): void
    {
        $this->quart = $quart;
    }

    /**
     * @return string|null
     */
    public function getQuarterVoteSum(): ?string
    {
        return $this->quarterVoteSum;
    }

    /**
     * @param string|null $quarterVoteSum
     */
    public function setQuarterVoteSum(?string $quarterVoteSum): void
    {
        $this->quarterVoteSum = $quarterVoteSum;
    }

    /**
     * @return string|null
     */
    public function getYearVoteSum(): ?string
    {
        return $this->yearVoteSum;
    }

    /**
     * @param string|null $yearVoteSum
     */
    public function setYearVoteSum(?string $yearVoteSum): void
    {
        $this->yearVoteSum = $yearVoteSum;
    }

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