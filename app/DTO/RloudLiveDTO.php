<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class RloudLiveDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;
    /**
     * @var integer | null
     * @description 专题配置表ID
     */
    private $special_id;
    /**
     * @var integer | null
     * @description 内容类型：1直播竞赛 2录播竞赛 3直播竞赛回放
     */
    private $type;
    /**
     * @var string | null
     * @description 标题
     */
    private $title;
    /**
     * @var string | null
     * @description 内容
     */
    private $content;
    /**
     * @var string | null
     * @description 链接地址
     */
    private $weburl;
    /**
     * @var string | null
     * @description 图片 ，号分割
     */
    private $img_url;
    /**
     * @var string | null
     * @description 视频 ，号分割
     */
    private $video_url;
    /**
     * @var datetime | null
     * @description 创建时间
     */
    private $created_at;
    /**
     * @var datetime | null
     * @description 修改时间
     */
    private $updated_at;
    /**
     * @var datetime | null
     * @description 删除时间
     */
    private $deleted_at;
    /**
     * @var string | null
     * @description 行业
     */
    private $industry;
    /**
     * @var integer | null
     * @description 工会ID
     */
    private $unit_id;
    /**
     * @var string | null
     * @description 开始时间
     */
    private $start_time;
    /**
     * @var string | null
     * @description 结束时间
     */
    private $end_time;
    /**
     * @var integer | null
     * @description 0 未审核 1 审核通过
     */
    private $check_state;
    /**
     * @var integer | null
     * @description创建人ID
     */
    private $creat_userid;
    /**
     * @var integer | null
     * @description虚拟流量
     */
    private $virtual_traffic;

    /**
     * @return int|null
     */
    public function getVirtualTraffic(): int
    {
        return $this->virtual_traffic;
    }

    /**
     * @param int|null $virtual_traffic
     */
    public function setVirtualTraffic(int $virtual_traffic)
    {
        $this->virtual_traffic = $virtual_traffic;
    }

    /**
     * @return int|null
     */
    public function getCreatUserid(): int
    {
        return $this->creat_userid;
    }

    /**
     * @param int|null $creat_userid
     */
    public function setCreatUserid(int $creat_userid)
    {
        $this->creat_userid = $creat_userid;
    }

    /**
     * @return datetime|null
     */
    public function getStartTime(): string
    {
        return $this->start_time;
    }

    /**
     * @param datetime|null $start_time
     */
    public function setStartTime(string $start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return datetime|null
     */
    public function getEndTime(): string
    {
        return $this->end_time;
    }

    /**
     * @param datetime|null $end_time
     */
    public function setEndTime(string $end_time)
    {
        $this->end_time = $end_time;
    }

    /**
     * @return int|null
     */
    public function getCheckState(): ?int
    {
        return $this->check_state;
    }

    /**
     * @param int|null $check_state
     */
    public function setCheckState(?int $check_state)
    {
        $this->check_state = $check_state;
    }

    /**
     * @return string|null
     */
    public function getIndustry(): string
    {
        return $this->industry;
    }

    /**
     * @param string|null $industry
     */
    public function setIndustry(string $industry)
    {
        $this->industry = $industry;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): int
    {
        return $this->unit_id;
    }

    /**
     * @param int|null $unit_id
     */
    public function setUnitId(?int $unit_id)
    {
        $this->unit_id = $unit_id;
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
     * @return int|null
     */
    public function getSpecialId(): int
    {
        return $this->special_id;
    }

    /**
     * @param int|null $special_id
     */
    public function setSpecialId(int $special_id)
    {
        $this->special_id = $special_id;
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
    public function setType(?int $type)
    {
        $this->type = $type;
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
     * @return string|null
     */
    public function getWeburl(): ?string
    {
        return $this->weburl;
    }

    /**
     * @param string|null $weburl
     */
    public function setWeburl(?string $weburl)
    {
        $this->weburl = $weburl;
    }

    /**
     * @return string|null
     */
    public function getImgUrl(): ?string
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
    public function getVideoUrl(): ?string
    {
        return $this->video_url;
    }

    /**
     * @param string|null $video_url
     */
    public function setVideoUrl(?string $video_url)
    {
        $this->video_url = $video_url;
    }

    /**
     * @return datetime|null
     */
    public function getCreatedAt(): datetime
    {
        return $this->created_at;
    }

    /**
     * @param datetime|null $created_at
     */
    public function setCreatedAt(datetime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return datetime|null
     */
    public function getUpdatedAt(): datetime
    {
        return $this->updated_at;
    }

    /**
     * @param datetime|null $updated_at
     */
    public function setUpdatedAt(datetime $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return datetime|null
     */
    public function getDeletedAt(): datetime
    {
        return $this->deleted_at;
    }

    /**
     * @param datetime|null $deleted_at
     */
    public function setDeletedAt(datetime $deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }


}