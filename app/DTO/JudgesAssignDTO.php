<?php


namespace App\DTO;


class JudgesAssignDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id;

    /**
     * @var string | null
     * @description 方案名称
     */
    private $name;

    /**
     * @var integer | null
     * @description 专家数
     */
    private $judesCount;

    /**
     * @var integer | null
     * @description 备选专家数
     */
    private $bakjudesCount;

    /**
     * @var string | null
     * @description 名单确认截止时间
     */
    private $endtime;

    /**
     * @var int | null
     * @description 专家指派状态
     */
    private $state;

    /**
     * @var integer | null
     * @description 关联活动id
     */
    private $case_schemes_id ;

    /**
     * @var string | null
     * @description 创建时间
     */
    private $createdAt;

    /**
     * @var string | null
     * @description 更新时间
     */
    private $updatedAt;

    /**
     * @var string | null
     * @description 版本
     */
    private $systemVersion;

    /**
     * @var string | null
     * @description 驳回原因
     */
    private $nopassinfo;
    
    /**
     * @return int|null
     */
    public function getId():? int
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
    public function getName():? string
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
     * @return int|null
     */
    public function getJudesCount():? int
    {
        return $this->judesCount;
    }

    /**
     * @param int|null $judesCount
     */
    public function setJudesCount(?int $judesCount)
    {
        $this->judesCount = $judesCount;
    }

    /**
     * @return int|null
     */
    public function getBakjudesCount():? int
    {
        return $this->bakjudesCount;
    }

    /**
     * @param int|null $bakjudesCount
     */
    public function setBakjudesCount(?int $bakjudesCount)
    {
        $this->bakjudesCount = $bakjudesCount;
    }

    /**
     * @return string|null
     */
    public function getEndtime():? string
    {
        return $this->endtime;
    }

    /**
     * @param string|null $endtime
     */
    public function setEndtime(?string $endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * @return int|null
     */
    public function getState():? int
    {
        return $this->state;
    }

    /**
     * @param int|null $state
     */
    public function setState(?int $state)
    {
        $this->state = $state;
    }

    /**
     * @return int|null
     */
    public function getCaseSchemesId():? int
    {
        return $this->case_schemes_id;
    }

    /**
     * @param int|null $case_schemes_id
     */
    public function setCaseSchemesId(?int $case_schemes_id)
    {
        $this->case_schemes_id = $case_schemes_id;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt():? string
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

    /**
     * @return string|null
     */
    public function getUpdatedAt():? string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getSystemVersion():? string
    {
        return $this->systemVersion;
    }

    /**
     * @param string|null systemVersion
     */
    public function setSystemVersion(? string  $systemVersion)
    {
        $this->systemVersion = $systemVersion;
    }

    /**
     * @return string|null
     */
    public function getNopassinfo():? string
    {
        return $this->nopassinfo;
    }

    /**
     * @param string|null $nopassinfo
     */
    public function setNopassinfo(?string  $nopassinfo)
    {
        $this->nopassinfo = $nopassinfo;
    }
    
}