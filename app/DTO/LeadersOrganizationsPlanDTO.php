<?php


namespace App\DTO;


class LeadersOrganizationsPlanDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var integer | null
     * @description 方案id
     */
    private $organizations_plan_id;

    /**
     * @var integer | null
     * @description 领导id
     */
    private $leaders_id;

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
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getOrganizationsPlanId():? int
    {
        return $this->organizations_plan_id;
    }

    /**
     * @param int|null $organizations_plan_id
     */
    public function setOrganizationsPlanId(int $organizations_plan_id)
    {
        $this->organizations_plan_id = $organizations_plan_id;
    }

    /**
     * @return int|null
     */
    public function getLeadersId():? int
    {
        return $this->leaders_id;
    }

    /**
     * @param int|null $leaders_id
     */
    public function setLeadersId(int $leaders_id)
    {
        $this->leaders_id = $leaders_id;
    }
}