<?php


namespace App\DTO;


class WechatKetDTO extends DTO
{
    /**
     * @var int | null
     * @description ID
     */
    private $id;

    /**
     * @var int | null
     * @description 后台用户ID
     */
    private $admin_id;

    /**
     * @var int | null
     * @description 关键字内容ID
     */
    private $kid;

    /**
     * @var string | null
     * @description 关键字
     */
    private $akey;

    /**
     * @var int | null
     * @description 查询类型
     */
    private $Pptype;


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
     * @var int | null
     * @description 是否使用
     */
    private  $is_exe;

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
     * @param timestamp|null $updated_at
     */
    public function setUpdatedAt(?timestamp $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return int|null
     */
    public function getIsExe(): ?int
    {
        return $this->is_exe;
    }

    /**
     * @param int|null $is_exe
     */
    public function setIsExe(?int $is_exe)
    {
        $this->is_exe = $is_exe;
    }





    /**
     * @return int|null
     */
    public function getAdminId(): ?int
    {
        return $this->admin_id;
    }

    /**
     * @param int|null $admin_id
     */
    public function setAdminId(?int $admin_id)
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return int|null
     */
    public function getKid(): ?int
    {
        return $this->kid;
    }

    /**
     * @param int|null $kid
     */
    public function setKid(?int $kid)
    {
        $this->kid = $kid;
    }

    /**
     * @return string|null
     */
    public function getAkey(): ?string
    {
        return $this->akey;
    }

    /**
     * @param string|null $akey
     */
    public function setAkey(?string $akey)
    {
        $this->akey = $akey;
    }

    /**
     * @return int|null
     */
    public function getPptype(): ?int
    {
        return $this->Pptype;
    }

    /**
     * @param int|null $Pptype
     */
    public function setPptype(?int $Pptype)
    {
        $this->Pptype = $Pptype;
    }



}