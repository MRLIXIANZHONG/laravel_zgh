<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class BrowseCountDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var string | null
     * @description 类型 by 巴渝活动 cqzgh 网络评选 gh 公会流量
     */
    private $type;

    /**
     * @var integer | null
     * @description 活动浏览量
     */
    private $browse_count;

    /**
     * @var integer | null
     * @description 公会ID
     */
    private $unit_id;



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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return int|null
     */
    public function getBrowseCount(): int
    {
        return $this->browse_count;
    }

    /**
     * @param int|null $browse_count
     */
    public function setBrowseCount(int $browse_count)
    {
        $this->browse_count = $browse_count;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): ?int
    {
        return $this->unit_id;
    }

    /**
     * @param int|null $unit_id
     */
    public function setUnitId(?int $unit_id)
    {
        $this->unit_id = $unit_id;
    }



}