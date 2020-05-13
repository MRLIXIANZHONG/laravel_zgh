<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class BannerDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var string | null
     * @description 图片地址
     */
    private $img_url;

    /**
     * @var integer | null
     * @description 正在使用（0 否 1是）
     */
    private $is_use;

    /**
     * @var datetime | null
     * @description 修改时间
     */
    private $updated_at;
    /**
     * @var datetime | null
     * @description 删除时间
     */
    private $deleted_at;

    /**
     * @var datetime | null
     * @description 创建时间
     */
    private $created_at;

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
     * @return string|null
     */
    public function getImgUrl(): ?string
    {
        return $this->img_url;
    }

    /**
     * @param string|null $img_url
     */
    public function setImgUrl(?string $img_url)
    {
        $this->img_url = $img_url;
    }

    /**
     * @return int|null
     */
    public function getIsUse(): int
    {
        return $this->is_use;
    }

    /**
     * @param int|null $is_use
     */
    public function setIsUse(int $is_use)
    {
        $this->is_use = $is_use;
    }

    /**
     * @return datetime|null
     */
    public function getCreatedAt(): datetime
    {
        return $this->created_at;
    }

    /**
     * @param datetime|null $created_at
     */
    public function setCreatedAt(datetime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return datetime|null
     */
    public function getUpdatedAt(): datetime
    {
        return $this->updated_at;
    }

    /**
     * @param datetime|null $updated_at
     */
    public function setUpdatedAt(datetime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return datetime|null
     */
    public function getDeletedAt(): datetime
    {
        return $this->deleted_at;
    }

    /**
     * @param datetime|null $deleted_at
     */
    public function setDeletedAt(datetime $deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

}