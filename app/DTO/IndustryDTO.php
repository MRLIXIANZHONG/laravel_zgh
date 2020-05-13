<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/8
 * Time: 16:18
 */

namespace App\DTO;


class IndustryDTO extends DTO
{
    /**
     * @var int | null
     */
    protected $id;

    /**
     * @var string | null
     */
    protected $industryName;

    /**
     * @var string | null
     */
    protected $description;

    /**
     * @var string | null
     */
    protected $createdAt;

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
    public function getIndustryName(): ?string
    {
        return $this->industryName;
    }

    /**
     * @param string|null $industryName
     */
    public function setIndustryName(?string $industryName)
    {
        $this->industryName = $industryName;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

}