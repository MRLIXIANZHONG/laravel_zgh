SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for industry_tag
-- ----------------------------
DROP TABLE IF EXISTS `industry_tag`;
CREATE TABLE `industry_tag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `industry_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '行业标签名',
  `description`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '行业标签名描述',
  `system_version`  varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `organization_industry_maps`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL DEFAULT 0 COMMENT '企业ID',
  `industry_id` int(11) NOT NULL DEFAULT 0 COMMENT '行业标签ID',
  `system_version`  varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

--
-- 表的结构 `organizations` 原企业方案表
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '单位名称',
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '单位类型',
  `abbreviation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简称',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7cce3f3421a47921c952faf5d37126ba' COMMENT '密码',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `unit_type` int(11) NOT NULL COMMENT '工会类型',
  `unit_id` int(11) NOT NULL COMMENT '上级工会名称',
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '企业官网（选填）',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司图片',
  `plan_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方案名称',
  `summary` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方案概述',
  `content` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方案内容',
  `target_task` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方案目标',
  `achievement_target` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '绩效目标',
  `measures` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '实施措施',
  `commend` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '表彰奖励',
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方案图片地址',
  `staffs_info` text COLLATE utf8mb4_unicode_ci COMMENT '参赛员工',
  `check_state` int(11) DEFAULT NULL COMMENT '0未审核   1审核通过  -1审核驳回',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `grade` int(11) DEFAULT '0' COMMENT '项目等级 0非重点 1市重点 2国家重点',
  `star_count` int(11) NOT NULL DEFAULT '0',
  `browse_count` int(11) NOT NULL DEFAULT '0',
  `system_version`  varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 表的结构 `units` 基层工会表
--
CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL COMMENT '工会类型',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '上级工会名称',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7cce3f3421a47921c952faf5d37126ba' COMMENT '密码',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系人',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `labour_star_amount` int(11) NOT NULL COMMENT '劳动之星推荐数',
  `skill_star_amount` int(11) NOT NULL COMMENT '技能之星推荐数',
  `innovate_star_amount` int(11) NOT NULL COMMENT '创新之星推荐数',
  `service_star_amount` int(11) NOT NULL DEFAULT '1' COMMENT '服务之星 推荐数量',
  `banner` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banner头图',
  `system_version`  varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 表的结构 `units_info` 基层工会详情表
--

CREATE TABLE `units_info` (
  `units_id` int(11) NOT NULL COMMENT '工会ID',
  `banner` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'banner头图',
  `model` int(11) NOT NULL COMMENT '展示模板',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `system_version`  varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 表的结构 `staffs` 企业员工表
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL COMMENT '参赛企业ID',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '电话',
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '岗位',
  `duty` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '职责',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '照片',
  `selection` int(11) NOT NULL DEFAULT '0' COMMENT '选拔状态 0未推选 1已经推选，2推选成功',
  `system_version` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `craftsmans` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `unit_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '所在单位',
  `bank_card` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '银行卡号',
  `bank_username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '户名',
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '推选来源',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `video` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '视屏文件',
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `honor` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '所获荣誉贡献',
  `describe` text COLLATE utf8mb4_unicode_ci COMMENT '推荐理由',
  `check_status`  int(2) NOT NULL DEFAULT 0 COMMENT '0.企业未推送 1.企业已推送 2.基层工会驳回 3.基层工会审核 4.基层工会已推送 5.活动执行方驳回 6.活动执行方审核 7.活动执行方已推送 8.总工会驳回 9.总工会审核通过',
  `check_status`  int(2) NOT NULL DEFAULT 0 COMMENT '0.企业未推送 1.企业已推送 2.上级工会驳回 3.上级工会审核 4.上级工会已推送 5.活动执行方驳回 6.活动执行方审核 7.活动执行方已推送 8.总工会驳回 9.总工会审核通过 10.大众评选已开始 11.大众评选已结束 12.专家评选开已始 13.专家评选已结束',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '申报时间',
  `updated_at` timestamp NULL DEFAULT NULL,
  `star` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `browse_amount` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `is_craftsman` int(1) NOT NULL DEFAULT '0' COMMENT '状态 0.未推选 1.候选 2.工匠',
  `system_version` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',   /** 新加的字段*/
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 表的结构 `craftsman_previous` 历届巴渝工匠
--

CREATE TABLE `craftsman_previous` (
  `id` int(10) UNSIGNED NOT NULL,
  `order` int(11) UNSIGEND NOT NULL DEFAULT 0 COMMENT '排序', /** 新加的字段*/
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `unit_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '职业',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '联系电话',
  `years` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '获奖年份',
  `describe` text COLLATE utf8mb4_unicode_ci COMMENT '人物描述',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '照片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `system_version` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统版本 cqzgh by',   /** 新加的字段*/
  `deleted_at` timestime DEFAULT NULL         /** 新加的字段*/
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;












alter table `craftsman_previous` add column `deleted_at` timestamp default null after `updated_at`;
alter table `craftsman_previous` add column `system_version` varchar(11) not null default 'by' comment '系统版本 cqzgh by' after `updated_at`;
update `craftsman_previous` set `system_version` = 'by';

alter table `craftsmans` add column `deleted_at` timestamp default null after `updated_at`;
alter table `craftsmans` add column `is_party` not null default 0 comment '0.不是党员 1.是党员' after `username`;
alter table `craftsmans` add column `system_version` varchar(11) not null default 'by' comment '系统版本 cqzgh by' after `updated_at`;

alter table `craftsmans` add column `organization_id` int(11) not null default 0 comment '所属企业' after `mobile`;
alter table `craftsmans` add column `unit_id` int(11) not null default 0 comment '所属上级工会' after `mobile`;
update `craftsmans` set `system_version` = 'by';


alter table `units` add column `address` varchar(50) not null default '' comment '基层工会地址' after `mobile`;
alter table `units` add column `phone` varchar(30) not null default '' comment '工会联系电话' after `mobile`;
alter table `units` add column `email` varchar(30) not null  default '' comment '基层工会电子邮箱' after `mobile`;
alter table `units` add column `duty` varchar(1000) not null default '' comment '工会职责' after `mobile`;
alter table `units` add column `description` varchar(1000) not null default '' comment '工会介绍' after `mobile`;

create table `unit_section` (
	`id` int(11) UNSIGNED not null AUTO_INCREMENT,
	`unit_id` int(11) not null default 0 comment '工会ID',
	`section` varchar(30) not null default '' comment '部门名称',
	`duty` varchar(1000) not null default '' comment '部门职责',
	`section_lead` varchar(500) not null default '' comment '部门领导',
	`system_version` varchar(11) NOT NULL default '' COMMENT '系统版本 cqzgh by',
	`updated_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`created_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`deleted_at` timestamp(0) DEFAULT NULL,
	primary key (`id`) using btree
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table `unit_leader` (
	`id` UNSIGNED int(11) not null AUTO_INCREMENT,
	`unit_id` int(11) not null default 0 comment '工会ID',
	`name` varchar(20) not null default '' comment '领导姓名',
	`mobile` varchar(20) not null default '' comment '手机号',
	`position` varchar(20) not null default '' comment '职位',
	`created_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`updated_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`deleted_at` timestamp(0) default null,
	primary key (`id`) using btree
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



ALTER TABLE `byzghdb_test`.`organizations`
MODIFY COLUMN `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '单位类型' AFTER `name`;

alter table `organizations` add column `staff_count` int(11) not null default 0 comment '员工总数';
alter table `organizations` add column `farmer_count` int(11) not null default 0 comment '农民工总数';
alter table `organizations` add column `account` int(11) not null default 0 comment '账户';
alter table `organizations` add column `bank_name` int(11) not null default 0 comment '开户行';

create table `star_log` (
	`id` bigint(11) not null AUTO_INCREMENT,
	`star_ip` varchar(11) not null default '127.0.0.1' comment '点赞用户的IP',
	`active_type` tinyint(2) not null default 0 comment '活动的类型 1.五小 2.优秀个人月度之星 3.优秀个人季度之星 4.优秀个人年度之星 5.参赛方案 6巴渝工匠',
	`date` varchar(20) not null default '0000-00-00' comment '点赞时间',
	`created_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

alter table `organizations` add column `check_time` timestamp(0) default null comment '审核时间';

alter table `craftsmans` add column `virtual_star` int(11) not null default 0 null comment '虚拟点赞量';
alter table `craftsmans` add column `virtual_browse` int(11) not null default 0 null comment '虚拟浏览量';
alter table `craftsmans` add column `reject_reason` varchar(300) not null default '' null comment '驳回理由';

alter table `craftsmans` add column `active_id` int(11) not null default 0 null comment '活动ID';
alter table `craftsmans` add column `star_total` int(11) not null default 0  comment '点赞总量';
alter table `craftsmans` add column `browse_total` int(11) not null default 0  comment '浏览总量';
alter table `craftsmans` add column `score` int(11) not null default 0 comment '专家打分数';

alter table `organizations` add column `virtual_star` int(11) not null default 0 comment '虚拟点赞总数';
alter table `organizations` add column `virtual_browse` int(11) not null default 0 comment '虚拟浏览总数';
alter table `organizations` add column `reject_reason` varchar(500) not null default '' comment '驳回理由';

alter table `organizations_plan` add column `deleted_at` timestamp(0) default null;
alter table `organizations_wuxiao` add column `deleted_at` timestamp(0) default null;

alter table `organizations` add column `is_competition` tinyint(2) not null default 0 comment '是否重点竞赛 0.不是 1.是';


create table `zgh_statistics` (
	`id` int(11) UNSIGNED not null AUTO_INCREMENT,
	`type` tinyint(2) not null default 0 comment '1.企业 2.工会 3.总工会每天汇总 4.总工会月度汇总',
	`type_id` int(11) not null default 0 comment '工会ID或企业ID',
	`yxgr_tb` int(11) not null default 0 comment '优秀个人提报数',
	`yxgr_yd` int(11) not null default 0 comment '优秀个人月度之星',
	`yxgr_jd` int(11) not null default 0 comment '优秀个人季度之星',
	`yxgr_nd` int(11) not null default 0 comment '优秀个人年度之星',
	`fa_tb` int(11) not null default 0 comment '方案提报数',
	`fa_cs` int(11) not null default 0 comment '基层工会审核通过的方案',
	`fa_fs` int(11) not null default 0 comment '方案复审通过数',
	`fa_jnjp` int(11) not null default 0 comment '节能减排方案数',
	`fa_zhfz` int(11) not null default 0 comment '灾害防治方案数',
	`fa_aqsc` int(11) not null default 0 comment '安全生产方案数',
	`fa_tpgj` int(11) not null default 0 comment '脱贫攻坚方案数',
	`fa_qt` int(11) not null default 0 comment '其他方案数',
	`fa_jt` int(11) not null default 0 comment '方案优秀集体数',
	`wx_tb` int(11) not null default 0 comment '五小提报数',
	`wx_yd` int(11) not null default 0 comment '五小月度数',
	`wx_jd` int(11) not null default 0 comment '五小季度数',
	`wx_nd` int(11) not null default 0 comment '五小年度数',
	`xw_tb` int(11) not null default 0 comment '提报新闻数',
	`xw_fb` int(11) not null default 0 comment '发布新闻数',
	`browse_amount` int(11) not null default 0 comment '浏览量',
	`star_amount` int(11) not null default 0 comment '点赞数',
	`score_amount` int(11) not null default 0 comment '总分数',
	`gj_tb` int(11) not null default 0 comment '工匠提报人数',
	`gj_fs` int(11) not null default 0 comment '工匠复审人数',
	`gj_hj` int(11) not null default 0 comment '工匠获奖人数',
	`gj_xwtb` int(11) not null default 0 comment '巴渝提报新闻',
	`gj_xwfb` int (11) not null default 0 comment '巴渝发布新闻',
	`by_browse` int (11) not null default 0 comment '巴渝浏览量',
	`by_star` int (11) not null default 0 comment '巴渝点赞量',
	`by_score` int (11) not null default 0 comment '巴渝总得分',
	`organization_count` int(11) not null default 0 comment '参赛企业数量',
	`staff_count` int(11) not null default 0 comment '企业参赛员工数',
	`date` date(0) default null comment '日期维度',
	`month` tinyint(2) not null default 0 comment '月份',
	`created_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`updated_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`deleted_at` timestamp(0) default null,
	primary key (`id`) using btree,
	index(`type_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

alter table `units` add column `check_status` tinyint(2) not null default 0 comment '审核状态 -1.驳回 0.未审核 1.已审核';
alter table `units` add column `honor_unit` tinyint(2) not null default 0 comment '荣誉工会 0.关 1.开';
alter table `units` add column `photo` varchar(100) not null default '' comment '工会logo';
alter table `units` add column `reject_reason` varchar(200) not null default '' comment '驳回理由';
alter table `units` add column `virtual_browse` int(11) not null default 0 comment '工会虚拟浏览量';
alter table `units` add column `virtual_star` int(11) not null default 0 comment '工会虚拟点赞量';

alter table `organizations` add column `deleted_at` timestamp(0) default null;

alter table `organizations` add column `share_title` varchar(30) not null default '' comment '分享标题';
alter table `organizations` add column `share_description` varchar(100) not null default '' comment '分享描述';
alter table `organizations` add column `share_img` varchar(100) not null default '' comment '分享图片';

alter table `news` add column `is_open` tinyint(2) not null default 1 comment '是否在本系统打开 0.否 1.是';

alter table `case_file` add column `active_type` tinyint(2) not null default 0 comment '活动类型 1.优秀个人 2.五小 3.方案 4.赛事';

alter table `craftsmans` add column `share_titale` varchar(15) not null default '' comment '分享标题';
alter table `craftsmans` add column `share_photo` varchar(50) not null default '' comment '分享头像';
alter table `craftsmans` add column `share_description` varchar(15) not null default '' comment '分享描述';

create table `craftsmans_extend` (
	`id` int(11) UNSIGNED not null AUTO_INCREMENT,
	`type` tinyint(2) not null default 0 comment '1.工匠视屏 2.工匠荣誉',
	`craftsman_id` int(11) not null default 0 comment '工匠ID',
	`video` varchar(300) not null default '' comment '工匠视屏',
	`video_cover` varchar(300) not null default '' comment '视屏封面',
	`honor_name` varchar(20) not null default '' comment '荣誉标题',
	`honor_description` varchar(500) not null default '' comment '荣誉描述',
	`honor_time` varchar(11) not null default '' comment '获得荣誉时间',
	`honor_image` varchar(500) not null default '' comment '荣誉图片',
	`created_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`updated_at` timestamp(0) not null default CURRENT_TIMESTAMP,
	`deleted_at` timestamp(0) default null,
	primary key (`id`) using btree
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

alter table `units` add column `share_img` varchar(100) not null default '' comment '分享图片';
alter table `units` add column `share_description` varchar(300) not null default '' comment '分享描述';
alter table `units` add column `share_title` varchar(12) not null default '' comment '分享标题';
alter table `zgh_statistics` add column `tb_qy` int(11) not null default 0 comment '提报的企业';








