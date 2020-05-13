<?php


namespace App\DTO;


class JudgesScoreDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id ;

    /**
     * @var integer | null
     * @description ID
     */
    private $judges_id ;

    /**
     * @var integer | null
     * @description ID
     */
    private $scoreType ;

    /**
     * @var integer | null
     * @description ID
     */
    private $scoreTypeId ;

    /**
     * @var integer | null
     * @description ID
     */
    private $caseSchemesId ;

    /**
     * @var integer | null
     * @description 分数
     */
    private $score;

    /**
     * @return int|null
     */
    public function getJudgesId(): int
    {
        return $this->judges_id;
    }

    /**
     * @param int|null $judges_id
     */
    public function setJudgesId(int $judges_id)
    {
        $this->judges_id = $judges_id;
    }

    /**
     * @return int|null
     */
    public function getScoreType(): int
    {
        return $this->scoreType;
    }

    /**
     * @param int|null $scoreType
     */
    public function setScoreType(int $scoreType)
    {
        $this->scoreType = $scoreType;
    }

    /**
     * @return int|null
     */
    public function getScoreTypeId(): int
    {
        return $this->scoreTypeId;
    }

    /**
     * @param int|null $scoreTypeId
     */
    public function setScoreTypeId(int $scoreTypeId)
    {
        $this->scoreTypeId = $scoreTypeId;
    }

    /**
     * @return int|null
     */
    public function getCaseSchemesId(): int
    {
        return $this->caseSchemesId;
    }

    /**
     * @param int|null $caseSchemesId
     */
    public function setCaseSchemesId(int $caseSchemesId)
    {
        $this->caseSchemesId = $caseSchemesId;
    }

    /**
     * @return int|null
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int|null $score
     */
    public function setScore(int $score)
    {
        $this->score = $score;
    }

    
}