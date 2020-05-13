<?php


namespace App\DTO;


class HonorJudgesDTO extends DTO
{
    /**
     * @var integer | null
     * @description ID
     */
    private $id;

    /**
     * @var string | null
     * @description 荣耀名
     */
     private $name;

    /**
     * @var string | null
     * @description 获得时间
     */
    private $honor_time;

    /**
     * @var string | null
     * @description 荣耀介绍
     */
    private $content;

    /**
     * @var string | null
     * @description 图片
     */
    private $img_url;

    /**
     * @var string | null
     * @description 专家id
     */
    private $judgesid;

    /**
     * @var int | null
     * @description 页面数据数
     */
    private $pagelimete;

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
    public function getHonorTime(): string
    {
        return $this->honor_time;
    }

    /**
     * @param string|null $honor_time
     */
    public function setHonorTime(string $honor_time)
    {
        $this->honor_time = $honor_time;
    }

    /**
     * @return string|null
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getImgUrl():? string
    {
        return $this->img_url;
    }

    /**
     * @param string|null $img_url
     */
    public function setImgUrl(?string $img_url)
    {
        $this->img_url = $img_url;
    }

    /**
     * @return string|null
     */
    public function getJudgesid():? string
    {
        return $this->judgesid;
    }

    /**
     * @param string|null $judgesid
     */
    public function setJudgesid(?string $judgesid)
    {
        $this->judgesid = $judgesid;
    }

    /**
     * @return int|null
     */
    public function getPagelimete():? int
    {
        return $this->pagelimete;
    }

    /**
     * @param int|null $pagelimete
     */
    public function setPagelimete(?int $pagelimete)
    {
        $this->pagelimete = $pagelimete;
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


}