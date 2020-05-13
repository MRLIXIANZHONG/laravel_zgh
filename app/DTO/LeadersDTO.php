<?php


namespace App\DTO;


class LeadersDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id ;

    /**
     * @var integer | null
     * @description 参赛企业ID
     */
    private $organizationId  ;

    /**
     * @var string | null
     * @description 姓名
     */
    private $name ;

    /**
     * @var string | null
     * @description 电话
     */
    private $phone ;

    /**
     * @var string | null
     * @description 岗位
     */
    private $position ;

    /**
     * @var string | null
     * @description 方案名称
     */
    private $duty ;

    /**
     * @var string | null
     * @description 上传时间
     */
    private $createdAt;

    /**
     * @var string | null
     * @description 更新时间
     */
    private $updatedAt ;

    /**
     * @var string | null
     * @description 图片地址
     */
    private $imgUrl;

    private $video_url;

    private $pagelimite;
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
    public function getOrganizationId(): ? int
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
    public function getPhone(): ?string
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
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param string|null $position
     */
    public function setPosition(?string $position)
    {
        $this->position = $position;
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
    public function getUpdatedAt():? string
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
     * @return string|null
     */
    public function getImgUrl():? string
    {
        return $this->imgUrl;
    }

    /**
     * @param string|null $imgUrl
     */
    public function setImgUrl(? string $imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return mixed
     */
    public function getPagelimite()
    {
        return $this->pagelimite;
    }

    /**
     * @param mixed $pagelimite
     */
    public function setPagelimite($pagelimite)
    {
        $this->pagelimite = $pagelimite;
    }

    /**
     * @return mixed
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * @param mixed $video_url
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;
    }


}