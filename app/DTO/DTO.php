<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 18:06
 */

namespace App\DTO;


class DTO
{
    /**
     * @var int | null
     */
    protected $page;

    /**
     * @var int | null
     */
    protected $pageSize = 15;

    /**
     * @var int | null 角色ID
     */
    protected $role_id;

    /**
     * @var int | null 企业ID
     */
    protected $org_id;

    /**
     * @var int | null 专家ID
     */
    protected $jun_id;

    /**
     * @var string | null
     * @description 版本
     */
    private $system_version;

    /**
     * @return int|null
     */
    public function getJunId(): ?int
    {
        return $this->jun_id;
    }

    /**
     * @param int|null $jun_id
     */
    public function setJunId(?int $jun_id)
    {
        $this->jun_id = $jun_id;
    }

    /**
     * @return string|null
     */
    public function getSystemVersion(): ?string
    {
        return $this->system_version;
    }

    /**
     * @param string|null $system_version
     */
    public function setSystemVersion(?string $system_version)
    {
        $this->system_version = $system_version;
    }


    /**
     * @return string|null
     */
    public function getRoleSlug(): string
    {
        return $this->role_slug;
    }

    /**
     * @param string|null $role_slug
     */
    public function setRoleSlug(string $role_slug)
    {
        $this->role_slug = $role_slug;
    }

    /**
     * @var string | null 角色类型 administrator  平台管理员 union 工会     enterprise 企业  adminunion 总工会
     */
    protected $role_slug;

    /**
     * @return int|null
     */
    public function getOrgId(): ?int
    {
        return $this->org_id;
    }

    /**
     * @param int|null $org_id
     */
    public function setOrgId(?int $org_id)
    {
        $this->org_id = $org_id;
    }

    /**
     * @return int|null
     */
    public function getUnitsId(): ?int
    {
        return $this->units_id;
    }

    /**
     * @param int|null $units_id
     */
    public function setUnitsId(?int $units_id)
    {
        $this->units_id = $units_id;
    }

    /**
     * @var int | null 公会ID
     */
    protected $units_id;

    /**
     * @return int|null
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @param int|null $role_id
     */
    public function setRoleId(int $role_id)
    {
        $this->role_id = $role_id;
    }

    /**
     * @var bool | null
     */
    protected $location = false;

    /**
     * @var bool 是否严格模式
     */
    protected $strict = false;

    /**
     * @var array 可选项列表
     */
    protected $optional = [];

    public function __construct(array $attributes, $strict = false)
    {
        $this->strict = $strict;
        $this->fill($attributes);
    }

    /**
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param int|null $page
     */
    public function setPage(?int $page)
    {
        $this->page = $page;
    }

    /**
     * @return int|null
     */
    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    /**
     * @param int|null $pageSize
     */
    public function setPageSize(?int $pageSize)
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return bool|null
     */
    public function getLocation(): ?bool
    {
        return $this->location;
    }

    /**
     * @param bool|null $location
     */
    public function setLocation(?bool $location)
    {
        $this->location = $location;
    }

    private function fill(array $attributes)
    {
        if ( empty($attributes) ) return ;

        // 如果未给于set方法，无法进行设置值
        // $attributes = array_except($attributes, $this->hidden);

        if ($this->strict) {
            $attributes = collect($attributes)->map(function ($attribute, $key) {
                return $attribute ?? array_get($this->optional, $key);
            })->toArray();
        }

        foreach ($attributes as $key => $attribute) {
            $arrs = explode('_', $key);
            $str = 'set';

            foreach ($arrs as $arr) {
                $arr = ucfirst($arr);
                $str = $str.$arr;
            }

            if (method_exists($this, $str)) {
                $this->$str($attribute);
            }
        }
    }
}