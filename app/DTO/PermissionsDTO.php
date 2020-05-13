<?php


namespace App\DTO;


class PermissionsDTO extends DTO
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
     * @description 权限控制链接
     */
    private $http_path;


    /**
     * @var string | null
     * @description 权限控制请求方式
     */
    private $http_method;

    /**
     * @var integer | null
     * @description 父级id
     */
    private $parent_id;


    /**
     * @var string | null
     * @description 关联角色
     */
    private $permission_roles;

    /**
     * @return array|null
     */
    public function getPermissionRoles(): array
    {
        return $this->permission_roles;
    }

    /**
     * @param string|null $permission_roles
     */
    public function setPermissionRoles(array $permission_roles)
    {
        $this->permission_roles = $permission_roles;
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
    public function getHttpPath(): ?string
    {
        return $this->http_path;
    }

    /**
     * @param string|null $http_path
     */
    public function setHttpPath(?string $http_path)
    {
        $this->http_path = $http_path;
    }

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string
    {
        return $this->http_method;
    }

    /**
     * @param string|null $http_method
     */
    public function setHttpMethod(?string $http_method)
    {
        $this->http_method = $http_method;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     */
    public function setParentId(?int $parent_id)
    {
        $this->parent_id = $parent_id;
    }


}