<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 21:27
 */

namespace App\DTO;


class NewsDTO extends DTO
{
    /**
     * @var integer | null
     * @description 主键ID
     */
    private $id;

    /**
     * @var integer | null
     * @description 新闻来源：1企业报送 2媒体发布 3市总工会自主采写
     */
    private $source;

    /**
     * @var integer | null
     * @description 参赛企业ID
     */
    private $organization_id;

    /**
     * @var int | null
     * @description 工会ID
     */
    private $unit_id;

    /**
     * @var string | null
     * @description 新闻标题
     */
    private $title;

    /**
     * @var string | null
     * @description 新闻摘要
     */
    private $abstract;

    /**
     * @var string | null
     * @description 新闻内容
     */
    private $content;
    /**
     * @var string | null
     * @description 新闻视频 ，号分割
     */
    private $img_url;
    /**
     * @var string | null
     * @description 新闻视频 ，号分割
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
     * @description 发布状态0 未发布 1 已发布
     */
    private $send_state;
    /**
     * @var string | null
     * @description 发布人
     */
    private $send_user;
    /**
     * @var datetime | null
     * @description 发布时间
     */
    private $send_time;

    /**
     * @var string | null
     * @description 新闻类型（1 工匠新闻 2 网络竞技新闻）
     */
    private $news_type;
    /**
     * @var int | null
     * @description 创建人DI
     */
    private $creat_userid;

    /**
     * @return int|null
     */
    public function getCreatUserid(): ?int
    {
        return $this->creat_userid;
    }

    /**
     * @param int|null $creat_userid
     */
    public function setCreatUserid(?int $creat_userid)
    {
        $this->creat_userid = $creat_userid;
    }

    /**
     * @var integer | null
     * @description 是否在本系统打开 0.否 1.是
     */
    private $is_open;

    /**
     * @return int|null
     */
    public function getIsOpen(): int
    {
        return $this->is_open;
    }

    /**
     * @param int|null $is_open
     */
    public function setIsOpen(int $is_open)
    {
        $this->is_open = $is_open;
    }

    /**
     * @return string|null
     */
    public function getNewsType(): string
    {
        return $this->news_type;
    }

    /**
     * @param string|null $news_type
     */
    public function setNewsType(string $news_type)
    {
        $this->news_type = $news_type;
    }

    /**
     * @return string|null
     */
    public function getReasonRejection(): ?string
    {
        return $this->reason_rejection;
    }

    /**
     * @param string|null $reason_rejection
     */
    public function setReasonRejection(?string $reason_rejection)
    {
        $this->reason_rejection = $reason_rejection;
    }
    /**
     * @var string | null
     * @description 审核理由
     */
    private $reason_rejection;

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
     * @var integer | null
     * @description 虚拟浏览量
     */
    private $virtual_traffic;
    /**
     * @return string|null
     */
    public function getSendState(): ?string
    {
        return $this->send_state;
    }

    /**
     * @param string|null $send_state
     */
    public function setSendState(string $send_state)
    {
        $this->send_state = $send_state;
    }

    /**
     * @return string|null
     */
    public function getSendUser(): string
    {
        return $this->send_user;
    }

    /**
     * @param string|null $send_user
     */
    public function setSendUser(string $send_user)
    {
        $this->send_user = $send_user;
    }

    /**
     * @return datetime|null
     */
    public function getSendTime(): ?datetime
    {
        return $this->send_time;
    }

    /**
     * @param datetime|null $send_time
     */
    public function setSendTime(?datetime $send_time)
    {
        $this->send_time = $send_time;
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

    /**
     * @var integer | null
     * @description 0未审核   1审核通过  -1审核驳回
     */
    private $check_state;
    /**
     * @var integer | null
     * @description 审核阶段 0企业阶段 1基础工会阶段  2总工会阶段
     */
    private $check_stage;
    /**
     * @var string | null
     * @description 新闻外部地址
     */
    private $weburl;

    /**
     * @var string | null
     * @description 创建时间
     */
    private $createdAt;

    /**
     * @var integer | null;
     * @description 0未审核   1审核通过  -1审核驳回
     */
    private $checkState;

    /**
     * @var int | null;
     * @description 是否显示首页（0 否 1是）
     */
    private $isShowHome;



    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getIsShowHome(): ?int
    {
        return $this->isShowHome;
    }

    /**
     * @param int|null $isShowHome
     */
    public function setIsShowHome(?int $isShowHome)
    {
        $this->isShowHome = $isShowHome;
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
    public function getOrganizationId(): ?int
    {
        return $this->organization_id;
    }

    /**
     * @param int|null $organization_id
     */
    public function setOrganizationId(?int $organization_id)
    {
        $this->organization_id = $organization_id;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): ?int
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
     * @return int|null
     */
    public function getCheckState(): ?int
    {
        return $this->check_state;
    }

    /**
     * @param int|null $check_state
     */
    public function setCheckState(int $check_state)
    {
        $this->check_state = $check_state;
    }

    /**
     * @return int|null
     */
    public function getCheckStage(): int
    {
        return $this->check_stage;
    }

    /**
     * @param int|null $check_stage
     */
    public function setCheckStage(int $check_stage)
    {
        $this->check_stage = $check_stage;
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
     * @return int|null
     */
    public function getBrowseCount(): int
    {
        return $this->browse_count;
    }

    /**
     * @param int|null $browse_count
     */
    public function setBrowseCount(int $browse_count)
    {
        $this->browse_count = $browse_count;
    }

    /**
     * @return int|null
     */
    public function getStarCount(): int
    {
        return $this->star_count;
    }

    /**
     * @param int|null $star_count
     */
    public function setStarCount(int $star_count)
    {
        $this->star_count = $star_count;
    }

    /**
     * @return int|null
     */
    public function getSource(): ?int
    {
        return $this->source;
    }

    /**
     * @param int|null $source
     */
    public function setSource(?int $source)
    {
        $this->source = $source;
    }

    /**
     * @var integer | null
     * @description 浏览数
     */
    private $browse_count;
    /**
     * @var integer | null
     * @description 点赞数
     */
    private $star_count;


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
    public function getAbstract(): string
    {
        return $this->abstract;
    }

    /**
     * @param string|null $abstract
     */
    public function setAbstract(string $abstract)
    {
        $this->abstract = $abstract;
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
     * @return string
     */
    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     */
    public function setVideoUrl(?string $videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }
}