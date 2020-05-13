<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/22
 * Time: 16:20
 */

namespace App\DTO;


class StatisticDTO extends DTO
{
    /**
     * @var int | null    1.企业维度统计 2.工会维度统计 3.总工会每天汇总 4.总工会月度汇总
     */
    protected $type;

    /**
     * @var string | null
     */
    protected $date;

    /**
     * @var string | null
     */
    protected $month;

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     */
    public function setType(?int $type)
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date)
    {
        $this->date = $date;
    }

    /**
     * @return string|null
     */
    public function getMonth(): ?string
    {
        return $this->month;
    }

    /**
     * @param string|null $month
     */
    public function setMonth(?string $month)
    {
        $this->month = $month;
    }

}