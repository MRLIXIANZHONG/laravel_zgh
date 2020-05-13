<?php

namespace App\DTO;

class JudgesDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id;

    /**
     * @var string | null
     * @description 专家姓名
     */
    private $name;

    /**
     * @var string | null
     * @description 所属单位
     */
    private $department;

    /**
     * @var string | null
     * @description 专家电话
     */
    private $phone;

    /**
     * @var integer | null
     * @description 评委类别 1技能专家2劳模3媒体4历届巴渝工匠
     */
    private $kind;

    /**
     * @var integer | null
     * @description 行业类型
     */
    private $industry;

    /**
     * @var string | null
     * @description 擅长领域
     */
    private $skill;

    /**
     * @var string | null
     * @description 照片
     */
    private $photo;

    /**
     * @var string | null
     * @description 短信密码
     */
    private $password;

    /**
     * @var string | null
     * @description 最后发送短信时间
     */
    private $lastSendTime;

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
     * @var bool | null
     * @description 是否为推荐
     */
    private $isrecommend;

    /**
     * @var string | null
     * @description 视屏地址
     */
    private $videoUrl;

    /**
     * @var int | null
     * @description 状态
     */
    private $checkState;

    /**
     * @var string | null
     * @description 专家特长介绍
     */
    private $speciality;

    /**
     * @var string | null
     * @description 特长图片
     */
    private $specialityImgUrl;

    /**
     * @var string | null
     * @description 特长视频
     */
    private $specialityVideoUrl;

    /**
     * @var string | null
     * @description 驳回理由
     */
    private $nopassinfo;

    /**
     * @var string | null
     * @description 驳回理由
     */
    private $shareImgUrl;

    /**
     * @var string | null
     * @description 驳回理由
     */
    private $shareContent;

    /**
     * @var string | null
     * @description 驳回理由
     */
    private $shareTitle;

    /**
     * @return int| null
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int| null $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
    public function getDepartment():? string
    {
        return $this->department;
    }

    /**
     * @param string|null $department
     */
    public function setDepartment(?string $department)
    {
        $this->department = $department;
    }

    /**
     * @return string|null
     */
    public function getPhone():? string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
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
    public function setKind(?int $kind)
    {
        $this->kind = $kind;
    }

    /**
     * @return int|null
     */
    public function getIndustry():? int
    {
        return $this->industry;
    }

    /**
     * @param int|null $industry
     */
    public function setIndustry(?int $industry)
    {
        $this->industry = $industry;
    }

    /**
     * @return string|null
     */
    public function getSkill():? string
    {
        return $this->skill;
    }

    /**
     * @param string|null $skill
     */
    public function setSkill(?string $skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ? string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     */
    public function setPhoto(?string  $photo)
    {
        $this->photo = $photo;
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
    public function getLastSendTime():? string
    {
        return $this->lastSendTime;
    }

    /**
     * @param string|null $lastSendTime
     */
    public function setLastSendTime(string $lastSendTime)
    {
        $this->lastSendTime = $lastSendTime;
    }

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
     * @return bool|null
     */
    public function getIsrecommend():? bool
    {
        return $this->isrecommend;
    }

    /**
     * @param bool|null $isrecommend
     */
    public function setIsrecommend(?bool $isrecommend)
    {
        $this->isrecommend = $isrecommend;
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
    public function getSpeciality():? string
    {
        return $this->speciality;
    }

    /**
     * @param string|null $speciality
     */
    public function setSpeciality(?string $speciality)
    {
        $this->speciality = $speciality;
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

    /**
     * @return string|null
     */
    public function getSpecialityImgUrl():? string
    {
        return $this->specialityImgUrl;
    }

    /**
     * @param string|null $specialityImgUrl
     */
    public function setSpecialityImgUrl(?string $specialityImgUrl)
    {
        $this->specialityImgUrl = $specialityImgUrl;
    }

    /**
     * @return string|null
     */
    public function getSpecialityVideoUrl():? string
    {
        return $this->specialityVideoUrl;
    }

    /**
     * @param string|null $specialityVideoUrl
     */
    public function setSpecialityVideoUrl(?string $specialityVideoUrl)
    {
        $this->specialityVideoUrl = $specialityVideoUrl;
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
    public function setNopassinfo(?string $nopassinfo)
    {
        $this->nopassinfo = $nopassinfo;
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
     * @return string|null
     */
    public function getShareContent():? string
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
}