<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;

//个人图集
class Nominess_imgDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;
    /**
     * @var integer | null
     * @description 个人主表ID
     */
    private $mainId ;
    /**
     * @var string | null
     * @description 标题
     */
    private $title ;
    /**
     * @var string | null
     * @description 图片路径
     */
    private $img_url ;
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
     * @var datetime | null
     * @description 删除时间
     */
    private $deleted_at;

    /**
     * @return int|null
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(int $sort)
    {
        $this->sort = $sort;
    }
    /**
     * @var integer | null
     * @description 排序码
     */
    private $sort ;

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
    public function getMainId(): int
    {
        return $this->mainId;
    }

    /**
     * @param int|null $mianId
     */
    public function setMainId(int $mainId)
    {
        $this->mainId = $mainId;
    }

    /**
     * @return string|null
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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