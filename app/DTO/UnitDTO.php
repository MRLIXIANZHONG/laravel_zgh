<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/10
 * Time: 15:45
 */

namespace App\DTO;


class UnitDTO extends DTO
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
     * @var int | null
     */
    protected $type;

    /**
     * @var string | null
     */
    protected $name;

    /**
     * @var string | null
     */
    protected $password;

    /**
     * @var string | null
     */
    protected $username;

    /**
     * @var string | null
     */
    protected $mobile;

    /**
     * @var int | null  劳动之星推荐数
     */
    protected $labourStarAmount;

    /**
     * @var int | null  技能之星推荐数
     */
    protected $skillStarAmount;

    /**
     * @var int | null 创新之星推荐数
     */
    protected $innovateStarAmount;

    /**
     * @var int | null  服务之星推荐数量
     */
    protected $serviceStarAmount;

    /**
     * @var string | null   开始修改时间
     */
    protected $startUpdateTime;

    /**
     * @var string | null   结束修改时间
     */
    protected $endUpdateTime;

    /**
     * @var string | null  开始创建时间
     */
    protected $startCreateTime;

    /**
     * @var string | null   结束创建时间
     */
    protected $endCreateTime;

    /**
     * @var string | null   工会头图
     */
    protected $banner;

    /**
     * @var string | null
     */
    protected $email;

    /**
     * @var string | null
     */
    protected $photo;

    /**
     * @var int | null  审核状态 -1.驳回 0.未审核 1.已审核
     */
    protected $checkStatus;

    /**
     * @var int | null
     */
    protected $honorUnit;

    /**
     * @var string | null
     */
    protected $address;

    /**
     * @var string | null
     */
    protected $description;

    /**
     * @var string | null
     */
    protected $duty;

    /**
     * @var string | null
     */
    protected $rejectReason;

    /**
     * @var int | null
     */
    protected $virtualBrowse;

    /**
     * @var int | null
     */
    protected $virtualStar;

    /**
     * @var string | null  分享标题
     */
    protected $shareTitle;

    /**
     * @var string | null  分享描述
     */
    protected $shareDescription;

    /**
     * @var string | null  分享图片
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
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     */
    public function setType(?int $type)
    {
        $this->type = $type;
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
     * @return int|null
     */
    public function getLabourStarAmount(): ?int
    {
        return $this->labourStarAmount;
    }

    /**
     * @param int|null $labourStarAmount
     */
    public function setLabourStarAmount(?int $labourStarAmount)
    {
        $this->labourStarAmount = $labourStarAmount;
    }

    /**
     * @return int|null
     */
    public function getSkillStarAmount(): ?int
    {
        return $this->skillStarAmount;
    }

    /**
     * @param int|null $skillStarAmount
     */
    public function setSkillStarAmount(?int $skillStarAmount)
    {
        $this->skillStarAmount = $skillStarAmount;
    }

    /**
     * @return int|null
     */
    public function getInnovateStarAmount(): ?int
    {
        return $this->innovateStarAmount;
    }

    /**
     * @param int|null $innovateStarAmount
     */
    public function setInnovateStarAmount(?int $innovateStarAmount)
    {
        $this->innovateStarAmount = $innovateStarAmount;
    }

    /**
     * @return int|null
     */
    public function getServiceStarAmount(): ?int
    {
        return $this->serviceStarAmount;
    }

    /**
     * @param int|null $serviceStarAmount
     */
    public function setServiceStarAmount(?int $serviceStarAmount)
    {
        $this->serviceStarAmount = $serviceStarAmount;
    }

    /**
     * @return string|null
     */
    public function getStartUpdateTime(): ?string
    {
        return $this->startUpdateTime;
    }

    /**
     * @param string|null $startUpdateTime
     */
    public function setStartUpdateTime(?string $startUpdateTime)
    {
        $this->startUpdateTime = $startUpdateTime;
    }

    /**
     * @return string|null
     */
    public function getEndUpdateTime(): ?string
    {
        return $this->endUpdateTime;
    }

    /**
     * @param string|null $endUpdateTime
     */
    public function setEndUpdateTime(?string $endUpdateTime)
    {
        $this->endUpdateTime = $endUpdateTime;
    }

    /**
     * @return string|null
     */
    public function getStartCreateTime(): ?string
    {
        return $this->startCreateTime;
    }

    /**
     * @param string|null $startCreateTime
     */
    public function setStartCreateTime(?string $startCreateTime)
    {
        $this->startCreateTime = $startCreateTime;
    }

    /**
     * @return string|null
     */
    public function getEndCreateTime(): ?string
    {
        return $this->endCreateTime;
    }

    /**
     * @param string|null $endCreateTime
     */
    public function setEndCreateTime(?string $endCreateTime)
    {
        $this->endCreateTime = $endCreateTime;
    }

    /**
     * @return string|null
     */
    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * @param string|null $banner
     */
    public function setBanner(?string $banner)
    {
        $this->banner = $banner;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
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
     * @return int|null
     */
    public function getCheckStatus(): ?int
    {
        return $this->checkStatus;
    }

    /**
     * @param int|null $checkStatus
     */
    public function setCheckStatus(?int $checkStatus)
    {
        $this->checkStatus = $checkStatus;
    }

    /**
     * @return int|null
     */
    public function getHonorUnit(): ?int
    {
        return $this->honorUnit;
    }

    /**
     * @param int|null $honorUnit
     */
    public function setHonorUnit(?int $honorUnit)
    {
        $this->honorUnit = $honorUnit;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getDuty(): ?string
    {
        return $this->duty;
    }

    /**
     * @param string|null $duty
     */
    public function setDuty(?string $duty)
    {
        $this->duty = $duty;
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