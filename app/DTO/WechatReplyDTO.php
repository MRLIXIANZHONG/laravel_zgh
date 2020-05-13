<?php


namespace App\DTO;


class WechatReplyDTO extends DTO
{
    /**
     * @var int | null
     * @description ID
     */
    private $id;

    /**
     * @var int | null
     * @description 后台用户ID
     */
    private $admin_id;

    /**
     * @var int | null
     * @description 回复类型
     */
    private $msgkind;

    /**
     * @var string | null
     * @description 点击数
     */
    private $msghit;

    /**
     * @var int | null
     * @description 是否隐藏
     */
    private $msghide;

    /**
     * @var string | null
     * @description 回复标题
     */
    private $title;

    /**
     * @var string | null
     * @description 回复内容
     */
    private $content;

    /**
     * @var string | null
     * @description 回复图文图片
     */
    private $content_img;

    /**
     * @var string | null
     * @description 回复图文链接
     */
    private $content_url;

    /**
     * @var string | null
     * @description 回复mediaId
     */
    private $content_mediaId;

    /**
     * @var int | null
     * @description 排序
     */
    private $view_lev;


    /**
     * @var timestamp | null
     * @description 创建时间
     */
    private $created_at;


    /**
     * @var timestamp | null
     * @description 修改时间
     */
    private $updated_at;

    /**
     * @return string|null
     */
    public function getContentMediaId(): string
    {
        return $this->content_mediaId;
    }

    /**
     * @param string|null $content_mediaId
     */
    public function setContentMediaId(string $content_mediaId)
    {
        $this->content_mediaId = $content_mediaId;
    }


    /**
     * @return string|null
     */
    public function getContentUrl(): ?string
    {
        return $this->content_url;
    }

    /**
     * @param string|null $content_url
     */
    public function setContentUrl(?string $content_url)
    {
        $this->content_url = $content_url;
    }


    /**
     * @return string|null
     */
    public function getContentImg(): ?string
    {
        return $this->content_img;
    }

    /**
     * @param string|null $content_img
     */
    public function setContentImg(?string $content_img)
    {
        $this->content_img = $content_img;
    }



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
     * @return int|null
     */
    public function getMsgkind(): ?int
    {
        return $this->msgkind;
    }

    /**
     * @param int|null $msgkind
     */
    public function setMsgkind(?int $msgkind)
    {
        $this->msgkind = $msgkind;
    }

    /**
     * @return null|string
     */
    public function getMsghit(): ?string
    {
        return $this->msghit;
    }

    /**
     * @param null|string $msghit
     */
    public function setMsghit(?string $msghit)
    {
        $this->msghit = $msghit;
    }

    /**
     * @return int|null
     */
    public function getMsghide(): ?int
    {
        return $this->msghide;
    }

    /**
     * @param int|null $msghide
     */
    public function setMsghide(?int $msghide)
    {
        $this->msghide = $msghide;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param null|string $content
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
    }

    /**
     * @return int|null
     */
    public function getViewLev(): ?int
    {
        return $this->view_lev;
    }

    /**
     * @param int|null $view_lev
     */
    public function setViewLev(?int $view_lev)
    {
        $this->view_lev = $view_lev;
    }

    /**
     * @return timestamp|null
     */
    public function getCreatedAt(): ?timestamp
    {
        return $this->created_at;
    }

    /**
     * @param timestamp|null $created_at
     */
    public function setCreatedAt(?timestamp $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return timestamp|null
     */
    public function getUpdatedAt(): ?timestamp
    {
        return $this->updated_at;
    }

    /**
     * @param timestamp|null $updated_at
     */
    public function setUpdatedAt(?timestamp $updated_at)
    {
        $this->updated_at = $updated_at;
    }



}