<?php


namespace App\DTO;


class UserstarLogDTO extends DTO
{
    /**
     * @var int | null
     * @description ID
     */
    private $id;

    /**
     * @var int | null
     * @description 类型
     */
    private $type;

    /**
     * @var string | null
     * @description openid
     */
    private $openid;

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
     * @return int|null
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getOpenid(): string
    {
        return $this->openid;
    }

    /**
     * @param string|null $openid
     */
    public function setOpenid(string $openid)
    {
        $this->openid = $openid;
    }

    
}