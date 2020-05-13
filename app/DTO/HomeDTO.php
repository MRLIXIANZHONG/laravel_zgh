<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-23 上午 11:14
 */

namespace App\DTO;


class HomeDTO extends DTO
{
    /**工匠类型
     * @var int | null
     */
    private $craftsmanType;

    /**
     * @return int|null
     */
    public function getCraftsmanType(): ?int
    {
        return $this->craftsmanType;
    }

    /**
     * @param int|null $craftsmanType
     */
    public function setCraftsmanType(?int $craftsmanType): void
    {
        $this->craftsmanType = $craftsmanType;
    }

}