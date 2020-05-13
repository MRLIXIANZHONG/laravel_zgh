<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;

//个人荣誉
class Nominees_experienceDTO extends DTO
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
     * @description 荣誉名称
     */
    private $name ;

    /**
     * @var string | null
     * @description 荣誉时间 strat
     */
    private $startTime ;


    /**
     * @var string | null
     * @description 荣誉时间 end
     */
    private $endTime ;

    /**
     * @var string | null
     * @description 荣誉描述
     */
    private $mark ;

    /**
     * @var string | null
     * @description 荣誉图片 ，逗号隔开
     */
    private $img_url;
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
     * @description 排序
     */
    private $sort ;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @param string|null $startTime
     */
    public function setStartTime(string $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime(): string
    {
        return $this->endTime;
    }

    /**
     * @param string|null $endTime
     */
    public function setEndTime(string $endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return string|null
     */
    public function getMark(): ?string
    {
        return $this->mark;
    }

    /**
     * @param string|null $mark
     */
    public function setMark(?string $mark)
    {
        $this->mark = $mark;
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

}