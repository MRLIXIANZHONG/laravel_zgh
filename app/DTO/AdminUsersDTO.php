<?php


namespace App\DTO;


class AdminUsersDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;


    /**
     * @var string | null
     * @description 用户名
     */
    private $username;


    /**
     * @var string | null
     * @description 密码
     */
    private $password;


    /**
     * @var string | null
     * @description 名称
     */
    private $name;


    /**
     * @var timestamp | null
     * @description 创建时间
     */
    private $created_at;


    /**
     * @var timestamp | null
     * @description 修改时间
     */
    private $updated_at;

    /**
     * @var integer | null
     * @description 手机号
     */
    private $mobile;

    /**
     * @return int|null
     */
    public function getMobile(): ?int
    {
        return $this->mobile;
    }

    /**
     * @param int|null $mobile
     */
    public function setMobile(?int $mobile)
    {
        $this->mobile = $mobile;
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
    public function setId(?int $id)
    {
        $this->id = $id;
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
     * @return timestamp|null
     */
    public function getCreatedAt(): ?timestamp
    {
        return $this->created_at;
    }

    /**
     * @param timestamp|null $created_at
     */
    public function setCreatedAt(?timestamp $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return timestamp|null
     */
    public function getUpdatedAt(): ?timestamp
    {
        return $this->updated_at;
    }

    /**
     * @param timestamp|null $timestamp
     */
    public function setTimestamp(?timestamp $timestamp)
    {
        $this->timestamp = $timestamp;
    }




}