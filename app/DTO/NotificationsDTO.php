<?php


namespace App\DTO;


class NotificationsDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var string | null
     * @description 类型
     */
    private $type;

    /**
     * @var string | null
     * @description 关联模型
     */
    private $notifiable_type;


    /**
     * @var integer | null
     * @description 关联模型ID
     */
    private $notifiable_id;

    /**
     * @var string | null
     * @description 消息内容
     */
    private $data;


    /**
     * @var timestamp | null
     * @description 读取时间
     */
    private $read_at;


    /**
     * @var timestamp | null
     * @description 创建时间
     */
    private $created_at;

    /**
     * @var timestamp | null
     * @description 读取时间
     */
    private  $updated_at;


   /**
    * @var integer | null
    * @description 关联消息总览表ID
    */
    private  $not_id;

    /**
     * @var string | null
     * @description 消息总览表标题
     */
    private  $title;

    /**
     * @var integer | null
     * @description 消息总览表状态
     */
    private  $status;


    /**
     * @var string | null
     * @description 消息总览内容
     */
    private  $content;

    /**
     * @var integer | null
     * @description 后台操作人员
     */
    private $admin_id;

    /**
     * @var string | null
     * @description 接受短信者
     */
    private $toarray;

    /**
     * @return string|null
     */
    public function getToarray(): ?string
    {
        return $this->toarray;
    }

    /**
     * @param string|null $toarray
     */
    public function setToarray(?string $toarray)
    {
        $this->toarray = $toarray;
    }


    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
    }

    /**
     * @return int|null
     */
    public function getAdminId(): ?int
    {
        return $this->admin_id;
    }

    /**
     * @param int|null $admin_id
     */
    public function setAdminId(?int $admin_id)
    {
        $this->admin_id = $admin_id;
    }


    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
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
    public function setStatus(?int $status)
    {
        $this->status = $status;
    }



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
     * @return string|null
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getNotifiableType(): string
    {
        return $this->notifiable_type;
    }

    /**
     * @param string|null $notifiable_type
     */
    public function setNotifiableType(string $notifiable_type)
    {
        $this->notifiable_type = $notifiable_type;
    }

    /**
     * @return int|null
     */
    public function getNotifiableId(): int
    {
        return $this->notifiable_id;
    }

    /**
     * @param int|null $notifiable_id
     */
    public function setNotifiableId(int $notifiable_id)
    {
        $this->notifiable_id = $notifiable_id;
    }

    /**
     * @return string|null
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string|null $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return timestamp|null
     */
    public function getReadAt(): timestamp
    {
        return $this->read_at;
    }

    /**
     * @param timestamp|null $read_at
     */
    public function setReadAt(timestamp $read_at)
    {
        $this->read_at = $read_at;
    }

    /**
     * @return timestamp|null
     */
    public function getCreatedAt(): timestamp
    {
        return $this->created_at;
    }

    /**
     * @param timestamp|null $created_at
     */
    public function setCreatedAt(timestamp $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return timestamp|null
     */
    public function getUpdatedAt(): timestamp
    {
        return $this->updated_at;
    }

    /**
     * @param timestamp|null $updated_at
     */
    public function setUpdatedAt(timestamp $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return int|null
     */
    public function getNotId(): int
    {
        return $this->not_id;
    }

    /**
     * @param int|null $not_id
     */
    public function setNotId(int $not_id)
    {
        $this->not_id = $not_id;
    }


}