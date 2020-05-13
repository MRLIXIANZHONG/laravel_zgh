<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-10 上午 11:53
 */

namespace App\DTO;


class ExcellentDTO extends DTO
{
    /**
     * @var int | null
     * @description 赛事ID
     */
    private $id;
    /**
     *
     * @var int |null
     * @description 赛事类型
     */
    private $type;

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
    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    private function setId($id): void
    {
        $this->id = $id;
    }
}