<?php


namespace App\DTO;


class WechatUsersDTO extends DTO
{
    /**
     * @var int | null
     * @description ID
     */
    private $id;

    /**
     * @var int | null
     * @description openid
     */
    private $openid;

    /**
     * @var int | null
     * @description 性别
     */
    private $sex;

    /**
     * @var string | null
     * @description 语言
     */
    private $lgg;

    /**
     * @var string | null
     * @description 昵称
     */
    private $nickname;

    /**
     * @var string | null
     * @description 城市
     */
    private $city;

    /**
     * @var string | null
     * @description 省份
     */
    private $province;

    /**
     * @var string | null
     * @description 国家
     */
    private $country;

    /**
     * @var string | null
     * @description 头像
     */
    private $headimgurl;

    /**
     * @var int | null
     * @description 是否关注
     */
    private $isdel;

    /**
     * @var int | null
     * @description 测试
     */
    private $istest;


    /**
     * @var datetime | null
     * @description 创建时间
     */
    private $created_at;


    /**
     * @var datetime | null
     * @description 修改时间
     */
    private $updated_at;

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
     * @return int|null
     */
    public function getOpenid(): ?int
    {
        return $this->openid;
    }

    /**
     * @param int|null $openid
     */
    public function setOpenid(?int $openid)
    {
        $this->openid = $openid;
    }

    /**
     * @return int|null
     */
    public function getSex(): ?int
    {
        return $this->sex;
    }

    /**
     * @param int|null $sex
     */
    public function setSex(?int $sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return string|null
     */
    public function getLgg(): ?string
    {
        return $this->lgg;
    }

    /**
     * @param string|null $lgg
     */
    public function setLgg(?string $lgg)
    {
        $this->lgg = $lgg;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @param string|null $province
     */
    public function setProvince(?string $province)
    {
        $this->province = $province;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getHeadimgurl(): ?string
    {
        return $this->headimgurl;
    }

    /**
     * @param string|null $headimgurl
     */
    public function setHeadimgurl(?string $headimgurl)
    {
        $this->headimgurl = $headimgurl;
    }

    /**
     * @return int|null
     */
    public function getIsdel(): ?int
    {
        return $this->isdel;
    }

    /**
     * @param int|null $isdel
     */
    public function setIsdel(?int $isdel)
    {
        $this->isdel = $isdel;
    }

    /**
     * @return int|null
     */
    public function getIstest(): ?int
    {
        return $this->istest;
    }

    /**
     * @param int|null $istest
     */
    public function setIstest(?int $istest)
    {
        $this->istest = $istest;
    }

    /**
     * @return datetime|null
     */
    public function getCreatedAt(): ?datetime
    {
        return $this->created_at;
    }

    /**
     * @param datetime|null $created_at
     */
    public function setCreatedAt(?datetime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return datetime|null
     */
    public function getUpdatedAt(): ?datetime
    {
        return $this->updated_at;
    }

    /**
     * @param datetime|null $updated_at
     */
    public function setUpdatedAt(?datetime $updated_at)
    {
        $this->updated_at = $updated_at;
    }



}