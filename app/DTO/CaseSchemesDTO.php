<?php
/**
 *
 * @author ccoo004
 * @date 2020-04-08 下午 3:25
 */

namespace App\DTO;


class CaseSchemesDTO extends DTO
{
    /**
     * @var int | null
     * @description 评选时间节点ID
     */
    private $id;
    /**
     * @var string|null
     * @description 标题
     */
    private $title;
    /**
     * @var string|null
     * @description 唯一代码
     */
    private $code;
    /**
     * @var string|null
     * @description 类型
     */
    private $type;
    /**
     * @var int|null
     * @description 排序
     */
    private $sort;
    /**
     * @var string|null
     * @description 展示开始时间
     */
    private $showStime;
    /**
     * @var string|null
     * @description 展示结束时间
     */
    private $showEtime;
    /**
     * @var string|null
     * @description 企业推选开始时间
     */
    private $qyStime;
    /**
     * @var string|null
     * @description 企业推选结束时间
     */
    private $qyEtime;
    /**
     * @var string|null
     * @description 工会推选开始时间
     */
    private $ghStime;
    /**
     * @var string|null
     * @description 工会推选结束时间
     */
    private $ghEtime;
    /**
     * @var string|null
     * @description 专家投票开始时间
     */
    private $zjStime;
    /**
     * @var string|null
     * @description 专家投票结束时间
     */
    private $zjEtime;
    /**
     * @var string|null
     * @description 年度投票开始时间
     */
    private $yearStime;
    /**
     * @var string|null
     * @description 年度投票结束时间
     */
    private $yearEtime;
    /**
     * @var string|null
     * @description
     */
    private $createdAt;
    /**
     * @var string|null
     * @description
     */
    private $updatedAt;
    /**
     * @var string|null
     * @description 删除时间
     */
    private $deletedAt;

    /**
     * @var 获取的类型
     */
    private $codeType;
    /**
     * @var int | null
     * @description 是否开启
     */
    private $isOpen;
    /**
     * @var int | null
     * @description 所在位置
     */
    private $isWhere;
    /**
     * @var string|null
     * @description 颁奖时间
     */
    private $prizeAt;

    private $showIsJoin;
    private $showIsOpen;
    private $qyIsJoin;
    /**
     * @var int|null
     * @description 工会ID
     */
    private $unitId;
    /**
     * @var string|null
     * @description 展示说明
     */
    private $show_explain;
    /**
     * @var string|null
     * @description 企业推选说明说明
     */
    private $qy_explain;
    /**
     * @var string|null
     * @description 基层工会推选说明
     */
    private $gh_explain;
    /**
     * @var string|null
     * @description 总工会筛选开始时间
     */
    private $zgh_stime;
    /**
     * @var string|null
     * @description 总工会筛选结束时间
     */
    private $zgh_etime;
    /**
     * @var int|null
     * @description 是否需要总工会参与
     */
    private $zgh_is_join;
    /**
     * @var int|null
     * @description 总工会筛选状态
     */
    private $zgh_is_open;
    /**
     * @var string|null
     * @description  专家投票说明
     */
    private $zj_explain;
    /**
     * @var string|null
     * @description 年度投票说明
     */
    private $year_explain;
    /**
     * @var string|null
     * @description 大众评选说明
     */
    private $public_explain;
    /**
     * @var string|null
     * @description 赛事说明说明
     */
    private $activity_explain;
    /**
     * @var string|null
     * @description 总工会筛选说明
     */
    private $zgh_explain;

    /**
     * @return string|null
     */
    public function getPublicExplain(): ?string
    {
        return $this->public_explain;
    }

    /**
     * @param string|null $public_explain
     */
    public function setPublicExplain(?string $public_explain): void
    {
        $this->public_explain = $public_explain;
    }

    /**
     * @return string|null
     */
    public function getActivityExplain(): ?string
    {
        return $this->activity_explain;
    }

    /**
     * @param string|null $activity_explain
     */
    public function setActivityExplain(?string $activity_explain): void
    {
        $this->activity_explain = $activity_explain;
    }

    /**
     * @return string|null
     */
    public function getZghExplain(): ?string
    {
        return $this->zgh_explain;
    }

    /**
     * @param string|null $zgh_explain
     */
    public function setZghExplain(?string $zgh_explain): void
    {
        $this->zgh_explain = $zgh_explain;
    }

    /**
     * @return string|null
     */
    public function getShowExplain(): ?string
    {
        return $this->show_explain;
    }

    /**
     * @param string|null $show_explain
     */
    public function setShowExplain(?string $show_explain): void
    {
        $this->show_explain = $show_explain;
    }

    /**
     * @return string|null
     */
    public function getQyExplain(): ?string
    {
        return $this->qy_explain;
    }

    /**
     * @param string|null $qy_explain
     */
    public function setQyExplain(?string $qy_explain): void
    {
        $this->qy_explain = $qy_explain;
    }

    /**
     * @return string|null
     */
    public function getGhExplain(): ?string
    {
        return $this->gh_explain;
    }

    /**
     * @param string|null $gh_explain
     */
    public function setGhExplain(?string $gh_explain): void
    {
        $this->gh_explain = $gh_explain;
    }

    /**
     * @return string|null
     */
    public function getZghStime(): ?string
    {
        return $this->zgh_stime;
    }

    /**
     * @param string|null $zgh_stime
     */
    public function setZghStime(?string $zgh_stime): void
    {
        $this->zgh_stime = $zgh_stime;
    }

    /**
     * @return string|null
     */
    public function getZghEtime(): ?string
    {
        return $this->zgh_etime;
    }

    /**
     * @param string|null $zgh_etime
     */
    public function setZghEtime(?string $zgh_etime): void
    {
        $this->zgh_etime = $zgh_etime;
    }

    /**
     * @return int|null
     */
    public function getZghIsJoin(): ?int
    {
        return $this->zgh_is_join;
    }

    /**
     * @param int|null $zgh_is_join
     */
    public function setZghIsJoin(?int $zgh_is_join): void
    {
        $this->zgh_is_join = $zgh_is_join;
    }

    /**
     * @return int|null
     */
    public function getZghIsOpen(): ?int
    {
        return $this->zgh_is_open;
    }

    /**
     * @param int|null $zgh_is_open
     */
    public function setZghIsOpen(?int $zgh_is_open): void
    {
        $this->zgh_is_open = $zgh_is_open;
    }

    /**
     * @return string|null
     */
    public function getZjExplain(): ?string
    {
        return $this->zj_explain;
    }

    /**
     * @param string|null $zj_explain
     */
    public function setZjExplain(?string $zj_explain): void
    {
        $this->zj_explain = $zj_explain;
    }

    /**
     * @return string|null
     */
    public function getYearExplain(): ?string
    {
        return $this->year_explain;
    }

    /**
     * @param string|null $year_explain
     */
    public function setYearExplain(?string $year_explain): void
    {
        $this->year_explain = $year_explain;
    }

    /**
     * @return int|null
     */
    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    /**
     * @param int|null $unitId
     */
    public function setUnitId(?int $unitId): void
    {
        $this->unitId = $unitId;
    }

    /**
     * @return mixed
     */
    public function getShowIsJoin()
    {
        return $this->showIsJoin;
    }

    /**
     * @param mixed $showIsJoin
     */
    public function setShowIsJoin($showIsJoin): void
    {
        $this->showIsJoin = $showIsJoin;
    }

    /**
     * @return mixed
     */
    public function getShowIsOpen()
    {
        return $this->showIsOpen;
    }

    /**
     * @param mixed $showIsOpen
     */
    public function setShowIsOpen($showIsOpen): void
    {
        $this->showIsOpen = $showIsOpen;
    }

    /**
     * @return mixed
     */
    public function getQyIsJoin()
    {
        return $this->qyIsJoin;
    }

    /**
     * @param mixed $qyIsJoin
     */
    public function setQyIsJoin($qyIsJoin): void
    {
        $this->qyIsJoin = $qyIsJoin;
    }

    /**
     * @return mixed
     */
    public function getQyIsOpen()
    {
        return $this->qyIsOpen;
    }

    /**
     * @param mixed $qyIsOpen
     */
    public function setQyIsOpen($qyIsOpen): void
    {
        $this->qyIsOpen = $qyIsOpen;
    }

    /**
     * @return mixed
     */
    public function getGhIsJoin()
    {
        return $this->ghIsJoin;
    }

    /**
     * @param mixed $ghIsJoin
     */
    public function setGhIsJoin($ghIsJoin): void
    {
        $this->ghIsJoin = $ghIsJoin;
    }

    /**
     * @return mixed
     */
    public function getGhIsOpen()
    {
        return $this->ghIsOpen;
    }

    /**
     * @param mixed $ghIsOpen
     */
    public function setGhIsOpen($ghIsOpen): void
    {
        $this->ghIsOpen = $ghIsOpen;
    }

    /**
     * @return mixed
     */
    public function getZjIsJoin()
    {
        return $this->zjIsJoin;
    }

    /**
     * @param mixed $zjIsJoin
     */
    public function setZjIsJoin($zjIsJoin): void
    {
        $this->zjIsJoin = $zjIsJoin;
    }

    /**
     * @return mixed
     */
    public function getZjIsOpen()
    {
        return $this->zjIsOpen;
    }

    /**
     * @param mixed $zjIsOpen
     */
    public function setZjIsOpen($zjIsOpen): void
    {
        $this->zjIsOpen = $zjIsOpen;
    }

    /**
     * @return mixed
     */
    public function getYearIsJoin()
    {
        return $this->yearIsJoin;
    }

    /**
     * @param mixed $yearIsJoin
     */
    public function setYearIsJoin($yearIsJoin): void
    {
        $this->yearIsJoin = $yearIsJoin;
    }

    /**
     * @return mixed
     */
    public function getYearIsOpen()
    {
        return $this->yearIsOpen;
    }

    /**
     * @param mixed $yearIsOpen
     */
    public function setYearIsOpen($yearIsOpen): void
    {
        $this->yearIsOpen = $yearIsOpen;
    }

    /**
     * @return mixed
     */
    public function getActivityStime()
    {
        return $this->activityStime;
    }

    /**
     * @param mixed $activityStime
     */
    public function setActivityStime($activityStime): void
    {
        $this->activityStime = $activityStime;
    }

    /**
     * @return mixed
     */
    public function getActivityEtime()
    {
        return $this->activityEtime;
    }

    /**
     * @param mixed $activityEtime
     */
    public function setActivityEtime($activityEtime): void
    {
        $this->activityEtime = $activityEtime;
    }

    /**
     * @return mixed
     */
    public function getPublicStime()
    {
        return $this->publicStime;
    }

    /**
     * @param mixed $publicStime
     */
    public function setPublicStime($publicStime): void
    {
        $this->publicStime = $publicStime;
    }

    /**
     * @return mixed
     */
    public function getPublicEtime()
    {
        return $this->publicEtime;
    }

    /**
     * @param mixed $publicEtime
     */
    public function setPublicEtime($publicEtime): void
    {
        $this->publicEtime = $publicEtime;
    }

    /**
     * @return mixed
     */
    public function getPublicIsJoin()
    {
        return $this->publicIsJoin;
    }

    /**
     * @param mixed $publicIsJoin
     */
    public function setPublicIsJoin($publicIsJoin): void
    {
        $this->publicIsJoin = $publicIsJoin;
    }

    /**
     * @return mixed
     */
    public function getPublicIsOpen()
    {
        return $this->publicIsOpen;
    }

    /**
     * @param mixed $publicIsOpen
     */
    public function setPublicIsOpen($publicIsOpen): void
    {
        $this->publicIsOpen = $publicIsOpen;
    }

    private $qyIsOpen;
    private $ghIsJoin;
    private $ghIsOpen;
    private $zjIsJoin;
    private $zjIsOpen;
    private $yearIsJoin;
    private $yearIsOpen;
    private $activityStime;
    private $activityEtime;
    private $publicStime;
    private $publicEtime;
    private $publicIsJoin;
    private $publicIsOpen;

    /**
     * @return string|null
     */
    public function getPrizeAt(): ?string
    {
        return $this->prizeAt;
    }

    /**
     * @param string|null $prizeAt
     */
    public function setPrizeAt(?string $prizeAt): void
    {
        $this->prizeAt = $prizeAt;
    }


    /**
     * @return int|null
     */
    public function getIsWhere(): ?int
    {
        return $this->isWhere;
    }

    /**
     * @param int|null $isWhere
     */
    public function setIsWhere(?int $isWhere): void
    {
        $this->isWhere = $isWhere;
    }

    /**
     * @return int|null
     */
    public function getIsOpen(): ?int
    {
        return $this->isOpen;
    }

    /**
     * @param int|null $isOpen
     */
    public function setIsOpen(?int $isOpen): void
    {
        $this->isOpen = $isOpen;
    }

    /**
     * @return mixed
     */
    public function getCodeType()
    {
        return $this->codeType;
    }

    /**
     * @param mixed $codeType
     */
    public function setCodeType($codeType): void
    {
        $this->codeType = $codeType;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @param string|null $deletedAt
     */
    public function setDeletedAt(?string $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(?int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return int|null
     */
    public function getShowStime(): ?string
    {
        return $this->showStime;
    }

    /**
     * @param string|null $showStime
     */
    public function setShowStime(?string $showStime): void
    {
        $this->showStime = $showStime;
    }

    /**
     * @return string|null
     */
    public function getShowEtime(): ?string
    {
        return $this->showEtime;
    }

    /**
     * @param string|null $showEtime
     */
    public function setShowEtime(?string $showEtime): void
    {
        $this->showEtime = $showEtime;
    }

    /**
     * @return string|null
     */
    public function getQyStime(): ?string
    {
        return $this->qyStime;
    }

    /**
     * @param string|null $qyStime
     */
    public function setQyStime(?string $qyStime): void
    {
        $this->qyStime = $qyStime;
    }

    /**
     * @return string|null
     */
    public function getQyEtime(): ?string
    {
        return $this->qyEtime;
    }

    /**
     * @param string|null $qyEtime
     */
    public function setQyEtime(?string $qyEtime): void
    {
        $this->qyEtime = $qyEtime;
    }

    /**
     * @return string|null
     */
    public function getGhStime(): ?string
    {
        return $this->ghStime;
    }

    /**
     * @param string|null $ghStime
     */
    public function setGhStime(?string $ghStime): void
    {
        $this->ghStime = $ghStime;
    }

    /**
     * @return string|null
     */
    public function getGhEtime(): ?string
    {
        return $this->ghEtime;
    }

    /**
     * @param string|null $ghEtime
     */
    public function setGhEtime(?string $ghEtime): void
    {
        $this->ghEtime = $ghEtime;
    }

    /**
     * @return string|null
     */
    public function getZjStime(): ?string
    {
        return $this->zjStime;
    }

    /**
     * @param string|null $zjStime
     */
    public function setZjStime(?string $zjStime): void
    {
        $this->zjStime = $zjStime;
    }

    /**
     * @return string|null
     */
    public function getZjEtime(): ?string
    {
        return $this->zjEtime;
    }

    /**
     * @param string|null $zjEtime
     */
    public function setZjEtime(?string $zjEtime): void
    {
        $this->zjEtime = $zjEtime;
    }

    /**
     * @return string|null
     */
    public function getYearStime(): ?string
    {
        return $this->yearStime;
    }

    /**
     * @param string|null $yearStime
     */
    public function setYearStime(?string $yearStime): void
    {
        $this->yearStime = $yearStime;
    }

    /**
     * @return string|null
     */
    public function getYearEtime(): ?string
    {
        return $this->yearEtime;
    }

    /**
     * @param string|null $yearEtime
     */
    public function setYearEtime(?string $yearEtime): void
    {
        $this->yearEtime = $yearEtime;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}