<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class Special_manageDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var string | null
     * @description 专题标题
     */
    private $title;
    /**
     * @var string | null
     * @description 专题描述
     */
    private $mark;
    /**
     * @var string | null
     * @description 顶部banner
     */
    private $banner;

    /**
     * @var string | null
     * @description 专题头像
     */
    private $title_img;
    /**
     * @var string | null
     * @description 活动精神
     */
    private $spirit;
    /**
     * @var string | null
     * @description 主办单位
     */
    private $sponsor_unit;
    /**
     * @var string | null
     * @description 备案号
     */
    private $record_numbe;
    /**
     * @var string | null
     * @description 地址
     */
    private $address;
    /**
     * @var string | null
     * @description 邮编
     */
    private $zip_code;
    /**
     * @var string | null
     * @description 版权信息
     */
    private $copyright_information;
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
    public function getMark(): string
    {
        return $this->mark;
    }

    /**
     * @param string|null $mark
     */
    public function setMark(string $mark)
    {
        $this->mark = $mark;
    }

    /**
     * @return string|null
     */
    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * @param string|null $banner
     */
    public function setBanner(?string $banner)
    {
        $this->banner = $banner;
    }

    /**
     * @return string|null
     */
    public function getTitleImg(): ?string
    {
        return $this->title_img;
    }

    /**
     * @param string|null $title_img
     */
    public function setTitleImg(?string $title_img)
    {
        $this->title_img = $title_img;
    }

    /**
     * @return string|null
     */
    public function getSpirit(): string
    {
        return $this->spirit;
    }

    /**
     * @param string|null $spirit
     */
    public function setSpirit(string $spirit)
    {
        $this->spirit = $spirit;
    }

    /**
     * @return string|null
     */
    public function getSponsorUnit(): string
    {
        return $this->sponsor_unit;
    }

    /**
     * @param string|null $sponsor_unit
     */
    public function setSponsorUnit(string $sponsor_unit)
    {
        $this->sponsor_unit = $sponsor_unit;
    }

    /**
     * @return string|null
     */
    public function getRecordNumbe(): string
    {
        return $this->record_numbe;
    }

    /**
     * @param string|null $record_numbe
     */
    public function setRecordNumbe(string $record_numbe)
    {
        $this->record_numbe = $record_numbe;
    }

    /**
     * @return string|null
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    /**
     * @param string|null $zip_code
     */
    public function setZipCode(string $zip_code)
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return string|null
     */
    public function getCopyrightInformation(): string
    {
        return $this->copyright_information;
    }

    /**
     * @param string|null $copyright_information
     */
    public function setCopyrightInformation(string $copyright_information)
    {
        $this->copyright_information = $copyright_information;
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

}