<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-22 上午 10:18
 */

namespace App\DTO;


class CaseFileDTO extends DTO
{
    /**
     * @var int | null
     * @description ID
     */
    private $id;
    /**
     * @var string| null
     * @description 名称
     */
    private $name;
    /**
     * @var string | null
     * @description 图标
     */
    private $icon;
    /**
     * @var string | null
     * @description 内容
     */
    private $context;
    /**
     * @var string | null
     * @description 图片
     */
    private $img;
    /**
     * @var string | null
     * @description 文件
     */
    private $file;
    /**
     * @var int | null
     * @description 状态
     */
    private $status;
    /**
     * @var int | null
     * @description 文件类型
     */
    private $type;
    /**
     * @var int| null
     * @description 是否显示在前台
     */
    private $is_push;

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
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     */
    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * @param string|null $context
     */
    public function setContext(?string $context): void
    {
        $this->context = $context;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string|null
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param string|null $file
     */
    public function setFile(?string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getIsPush(): ?int
    {
        return $this->is_push;
    }

    /**
     * @param int|null $is_push
     */
    public function setIsPush(?int $is_push): void
    {
        $this->is_push = $is_push;
    }

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
}