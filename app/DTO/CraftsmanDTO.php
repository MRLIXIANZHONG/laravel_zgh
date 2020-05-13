<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/4/11
 * Time: 21:13
 */

namespace App\DTO;


class CraftsmanDTO extends DTO
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
     * @var string | null
     */
    protected $username;

    /**
     * @var string | null
     */
    protected $mobile;

    /**
     * @var string | null
     */
    protected $unitName;

    /**
     * @var string | null
     */
    protected $bankCard;

    /**
     * @var string | null
     */
    protected $bankUsername;

    /**
     * @var string | null
     */
    protected $bankName;

    /**
     * @var int | null
     */
    protected $from;

    /**
     * @var string | null
     */
    protected $photo;

    /**
     * @var string | null
     */
    protected $video;

    /**
     * @var string | null
     */
    protected $image;

    /**
     * @var string | null
     */
    protected $honor;

    /**
     * @var string | null
     */
    protected $describe;

    /**
     * @var array | null
     */
    protected $checkStatus;

    /**
     * @var string | null
     */
    protected $createdAt;

    /**
     * @var int | null
     */
    protected $star;

    /**
     * @var int | null
     */
    protected $browseAmount;

    /**
     * @var int | null
     */
    protected $isCraftsman;

    /**
     * @var array | null
     */
    protected $isCraftsmans;

    /**
     * @var string | null
     */
    protected $years;

    /**
     * @var int | null
     */
    protected $unitId;

    /**
     * @var int | null
     */
    protected $organizationId;

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
     * @var array | null
     */
    protected $activeIds;

    /**
     * @var int | null
     */
    protected $starTotal;

    /**
     * @var int | null
     */
    protected $browseTotal;

    /**
     * @var int | null
     */
    protected $activeId;

    /**
     * @var int | null
     */
    protected $score;

    /**
     * @var int | null
     */
    protected $checkStatu;

    /**
     * @var int | null
     */
    protected $isCrafts;

    /**
     * @var int | null    是否党员
     */
    protected $isPartyMember;

    /**
     * @var string | null   银行卡照片
     */
    protected $bankPhoto;

    /**
     * @var string | null   分享标题
     */
    protected $shareTitle;

    /**
     * @var string | null   分享图片
     */
    protected $sharePhoto;

    /**
     * @var string | null   分享描述
     */
    protected $shareDescription;

    /**
     * @var string | null   视频封面
     */
    protected $videoCover;

    /**
     * @var string | null   荣誉标题
     */
    protected $honorName;

    /**
     * @var string | null  荣誉描述
     */
    protected $honorDescription;

    /**
     * @var string | null   获得荣誉时间
     */
    protected $honorTime;

    /**
     * @var string | null   荣誉图集
     */
    protected $honorImage;

    /**
     * @var string | null  微信的openid
     */
    protected $openid;

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
     * @return string|null
     */
    public function getUnitName(): ?string
    {
        return $this->unitName;
    }

    /**
     * @param string|null $unitName
     */
    public function setUnitName(?string $unitName)
    {
        $this->unitName = $unitName;
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
    public function getBankUsername(): ?string
    {
        return $this->bankUsername;
    }

    /**
     * @param string|null $bankUsername
     */
    public function setBankUsername(?string $bankUsername)
    {
        $this->bankUsername = $bankUsername;
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
     * @return int|null
     */
    public function getFrom(): ?int
    {
        return $this->from;
    }

    /**
     * @param int|null $from
     */
    public function setFrom(?int $from)
    {
        $this->from = $from;
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
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     */
    public function setVideo(?string $video)
    {
        $this->video = $video;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image)
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getHonor(): ?string
    {
        return $this->honor;
    }

    /**
     * @param string|null $honor
     */
    public function setHonor(?string $honor)
    {
        $this->honor = $honor;
    }

    /**
     * @return string|null
     */
    public function getDescribe(): ?string
    {
        return $this->describe;
    }

    /**
     * @param string|null $describe
     */
    public function setDescribe(?string $describe)
    {
        $this->describe = $describe;
    }

    /**
     * @return array|null
     */
    public function getCheckStatus(): ?array
    {
        return $this->checkStatus;
    }

    /**
     * @param array|null $checkStatus
     */
    public function setCheckStatus(?array $checkStatus)
    {
        $this->checkStatus = $checkStatus;
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
     * @return int|null
     */
    public function getStar(): ?int
    {
        return $this->star;
    }

    /**
     * @param int|null $star
     */
    public function setStar(?int $star)
    {
        $this->star = $star;
    }

    /**
     * @return int|null
     */
    public function getBrowseAmount(): ?int
    {
        return $this->browseAmount;
    }

    /**
     * @param int|null $browseAmount
     */
    public function setBrowseAmount(?int $browseAmount)
    {
        $this->browseAmount = $browseAmount;
    }

    /**
     * @return int|null
     */
    public function getIsCraftsman(): ?int
    {
        return $this->isCraftsman;
    }

    /**
     * @param int|null $isCraftsman
     */
    public function setIsCraftsman(?int $isCraftsman)
    {
        $this->isCraftsman = $isCraftsman;
    }

    /**
     * @return array|null
     */
    public function getIsCraftsmans(): ?array
    {
        return $this->isCraftsmans;
    }

    /**
     * @param array|null $isCraftsmans
     */
    public function setIsCraftsmans(?array $isCraftsmans)
    {
        $this->isCraftsmans = $isCraftsmans;
    }

    /**
     * @return string|null
     */
    public function getYears(): ?string
    {
        return $this->years;
    }

    /**
     * @param string|null $years
     */
    public function setYears(?string $years)
    {
        $this->years = $years;
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
    public function setUnitId(?int $unitId)
    {
        $this->unitId = $unitId;
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
    public function setOrganizationId(?int $organizationId)
    {
        $this->organizationId = $organizationId;
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
     * @return array|null
     */
    public function getActiveIds(): ?array
    {
        return $this->activeIds;
    }

    /**
     * @param array|null $activeIds
     */
    public function setActiveIds(?array $activeIds)
    {
        $this->activeIds = $activeIds;
    }

    /**
     * @return int|null
     */
    public function getStarTotal(): ?int
    {
        return $this->starTotal;
    }

    /**
     * @param int|null $starTotal
     */
    public function setStarTotal(?int $starTotal)
    {
        $this->starTotal = $starTotal;
    }

    /**
     * @return int|null
     */
    public function getBrowseTotal(): ?int
    {
        return $this->browseTotal;
    }

    /**
     * @param int|null $browseTotal
     */
    public function setBrowseTotal(?int $browseTotal)
    {
        $this->browseTotal = $browseTotal;
    }

    /**
     * @return int|null
     */
    public function getActiveId(): ?int
    {
        return $this->activeId;
    }

    /**
     * @param int|null $activeId
     */
    public function setActiveId(?int $activeId)
    {
        $this->activeId = $activeId;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int|null $score
     */
    public function setScore(?int $score)
    {
        $this->score = $score;
    }

    /**
     * @return int|null
     */
    public function getCheckStatu(): ?int
    {
        return $this->checkStatu;
    }

    /**
     * @param int|null $checkStatu
     */
    public function setCheckStatu(?int $checkStatu)
    {
        $this->checkStatu = $checkStatu;
    }

    /**
     * @return int|null
     */
    public function getIsCrafts(): ?int
    {
        return $this->isCrafts;
    }

    /**
     * @param int|null $isCrafts
     */
    public function setIsCrafts(?int $isCrafts)
    {
        $this->isCrafts = $isCrafts;
    }

    /**
     * @return int|null
     */
    public function getIsPartyMember(): ?int
    {
        return $this->isPartyMember;
    }

    /**
     * @param int|null $isPartyMember
     */
    public function setIsPartyMember(?int $isPartyMember)
    {
        $this->isPartyMember = $isPartyMember;
    }

    /**
     * @return string|null
     */
    public function getBankPhoto(): ?string
    {
        return $this->bankPhoto;
    }

    /**
     * @param string|null $bankPhoto
     */
    public function setBankPhoto(?string $bankPhoto)
    {
        $this->bankPhoto = $bankPhoto;
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
    public function getSharePhoto(): ?string
    {
        return $this->sharePhoto;
    }

    /**
     * @param string|null $sharePhoto
     */
    public function setSharePhoto(?string $sharePhoto)
    {
        $this->sharePhoto = $sharePhoto;
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
    public function getVideoCover(): ?string
    {
        return $this->videoCover;
    }

    /**
     * @param string|null $videoCover
     */
    public function setVideoCover(?string $videoCover)
    {
        $this->videoCover = $videoCover;
    }

    /**
     * @return string|null
     */
    public function getHonorName(): ?string
    {
        return $this->honorName;
    }

    /**
     * @param string|null $honorName
     */
    public function setHonorName(?string $honorName)
    {
        $this->honorName = $honorName;
    }

    /**
     * @return string|null
     */
    public function getHonorDescription(): ?string
    {
        return $this->honorDescription;
    }

    /**
     * @param string|null $honorDescription
     */
    public function setHonorDescription(?string $honorDescription)
    {
        $this->honorDescription = $honorDescription;
    }

    /**
     * @return string|null
     */
    public function getHonorTime(): ?string
    {
        return $this->honorTime;
    }

    /**
     * @param string|null $honorTime
     */
    public function setHonorTime(?string $honorTime)
    {
        $this->honorTime = $honorTime;
    }

    /**
     * @return string|null
     */
    public function getHonorImage(): ?string
    {
        return $this->honorImage;
    }

    /**
     * @param string|null $honorImage
     */
    public function setHonorImage(?string $honorImage)
    {
        $this->honorImage = $honorImage;
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
    public function setOpenid(?string $openid)
    {
        $this->openid = $openid;
    }

}