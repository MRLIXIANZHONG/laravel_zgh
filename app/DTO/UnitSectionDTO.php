<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/14
 * Time: 13:16
 */

namespace App\DTO;


class UnitSectionDTO extends DTO
{
    /**
     * @var int | null
     */
    protected $id;

    /**
     * @var array | null
     */
    protected $ids;

    /**
     * @var array | null
     */
    protected $unitIds;

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
     * @return array|null
     */
    public function getIds(): ?array
    {
        return $this->ids;
    }

    /**
     * @param array|null $ids
     */
    public function setIds(?array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return array|null
     */
    public function getUnitIds(): ?array
    {
        return $this->unitIds;
    }

    /**
     * @param array|null $unitIds
     */
    public function setUnitIds(?array $unitIds)
    {
        $this->unitIds = $unitIds;
    }

}