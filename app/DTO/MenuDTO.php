<?php


namespace App\DTO;


class MenuDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;


    /**
     * @var integer | null
     * @description 用户名
     */
    private $parent_id;


    /**
     * @var integer | null
     * @description 排序
     */
    private $order;


    /**
     * @var string | null
     * @description 名称
     */
    private $title;


    /**
     * @var string | null
     * @description 图标
     */
    private $icon;


    /**
     * @var string | null
     * @description 链接路由
     */
    private $uri;


    /**
     * @var array | null
     * @description 角色数组
     */
    private $roles;

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
     * @var string | null
     * @description 版本
     */
    private $system_version;



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

    /**
     * @return int|null
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }

    /**
     * @param int|null $order
     */
    public function setOrder(?int $order)
    {
        $this->order = $order;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     */
    public function setIcon(?string $icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param string|null $uri
     */
    public function setUri(?string $uri)
    {
        $this->uri = $uri;
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
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array|null $roles
     */
    public function setRoles(?array $roles)
    {
        $this->roles = $roles;
    }



}