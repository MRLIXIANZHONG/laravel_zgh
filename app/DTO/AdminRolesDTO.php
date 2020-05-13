<?php


namespace App\DTO;


class AdminRolesDTO extends  DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;


    /**
     * @var string | null
     * @description 角色名称
     */
    private $name;


    /**
     * @var string | null
     * @description 角色标识
     */
    private $slug;



    /**
     * @var timestamp | null
     * @description 名称
     */
    private $created_at;


    /**
     * @var timestamp | null
     * @description 名称
     */
    private $updated_at;

    /**
     * @var string | null
     * @description 权限数组
     */
    private $permissions_list;

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
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug)
    {
        $this->slug = $slug;
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
     * @return string|null
     */
    public function getPermissionsList(): ?string
    {
        return $this->permissions_list;
    }

    /**
     * @param string|null $permissions_list
     */
    public function setPermissionsList(?string $permissions_list)
    {
        $this->permissions_list = $permissions_list;
    }




}