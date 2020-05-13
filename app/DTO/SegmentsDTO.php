<?php


namespace App\DTO;


class segmentsDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id;

    /**
     * @var integer | null
     * @description 企业ID
     */
    private $organizationId;

    /**
     * @var integer | null
     * @description 企业方案ID
     */
    private $organizationPlanId;

    /**
     * @var integer | null
     * @description 当前阶段数(用于排序)
     */
    private $stageNumber;

    /**
     * @var string | null
     * @description 阶段名
     */
    private $name;

    /**
     * @var string | null
     * @description 介绍，描述
     */
    private $describe;

    /**
     * @var string | null
     * @description 开始时间
     */
    private $startTime;

    /**
     * @var string | null
     * @description 结束时间
     */
    private $endTime;

    /**
     * @var string | null
     * @description 图片地址 ,号分割
     */
    private $imgUrl;

    /**
     * @var string | null
     * @description 视频地址 ,号分割
     */
    private $videoUrl;

    /**
     * @var integer | null
     * @description 审核单ID
     */
    private $submitId;

//    /**
//     * @var integer | null
//     * @description 0未审核1基层工会审核通过-1基层工会审核驳回2活动方通未审核3活动方通过 -3活动房驳回4总工会未审核5总工会审核-5总工会驳回
//     */
//    private $checkState;

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
     * @var string | null
     * @description 驳回理由
     */
    private $reasonRejection;

    /**
     * @return int|null
     */
    public function getId():? int
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
     * @return int|null
     */
    public function getOrganizationPlanId(): ?int
    {
        return $this->organizationPlanId;
    }

    /**
     * @param int|null $organizationPlanId
     */
    public function setOrganizationPlanId(? int $organizationPlanId)
    {
        $this->organizationPlanId = $organizationPlanId;
    }

    /**
     * @return int|null
     */
    public function getStageNumber():? int
    {
        return $this->stageNumber;
    }

    /**
     * @param int|null $stageNumber
     */
    public function setStageNumber(?int $stageNumber)
    {
        $this->stageNumber = $stageNumber;
    }

    /**
     * @return string|null
     */
    public function getName():? string
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
    public function getDescribe():? string
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
     * @return string|null
     */
    public function getStartTime():? string
    {
        return $this->startTime;
    }

    /**
     * @param string|null $startTime
     */
    public function setStartTime(?string $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime():? string
    {
        return $this->endTime;
    }

    /**
     * @param string|null $endTime
     */
    public function setEndTime(?string $endTime)
    {
        $this->endTime = $endTime;
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
     * @return int|null
     */
    public function getSubmitId():? int
    {
        return $this->submitId;
    }

    /**
     * @param int|null $submitId
     */
    public function setSubmitId(?int $submitId)
    {
        $this->submitId = $submitId;
    }

//    /**
//     * @return int|null
//     */
//    public function getCheckState():? int
//    {
//        return $this->checkState;
//    }
//
//    /**
//     * @param int|null $checkState
//     */
//    public function setCheckState(int $checkState)
//    {
//        $this->checkState = $checkState;
//    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getReasonRejection(): ?string
    {
        return $this->reasonRejection;
    }

    /**
     * @param string|null $reasonRejection
     */
    public function setReasonRejection(?string $reasonRejection)
    {
        $this->reasonRejection = $reasonRejection;
    }

    /**
     * @return string|null
     */
    public function getVideoUrl():? string
    {
        return $this->videoUrl;
    }

    /**
     * @param string|null $videoUrl
     */
    public function setVideoUrl(?string $videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

}