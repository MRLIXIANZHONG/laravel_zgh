ALTER table byzghdb_test.organizations_wuxiao  
ADD 'unit_id'  int(11) NOT NULL COMMENT '审核工会ID', 
ADD 'cover'  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面',
add 'declaration_state' int(1) DEFAULT 0 COMMENT '申报状态 0未申报 1 已申报',
add 'check_state' int(11) DEFAULT NULL COMMENT '0未审核   1审核通过  -1审核驳回',
add 'check_time' timestamp NULL DEFAULT NULL COMMENT '审核时间',
add 'check_opinion' varchar(500) DEFAULT NULL COMMENT '审核意见',
add 'awards' varchar(500) DEFAULT NULL COMMENT '所获奖项',
add 'awards_time' timestamp NULL DEFAULT NULL COMMENT '获奖时间'


ALTER TABLE `byzghdb_test`.`nominees` 
ADD COLUMN `bank_card_img` varchar(255) NULL COMMENT '银行卡照片' AFTER `bank_staff_name`;


CREATE TABLE byzghdb_test.nominees_organizations_plan (
  id int(11) NOT NULL AUTO_INCREMENT,
  nominee_id int(11) NOT NULL COMMENT '优秀个人ID',
  organizations_plan_id int(11) NOT NULL COMMENT '企业方案ID',
  create_at timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  updated_at timestamp NULL DEFAULT NULL COMMENT '修改时间',
  deleted_at timestamp NULL DEFAULT NULL COMMENT '删除时间',
  organizations_id int(11) NOT NULL COMMENT '企业ID',
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 28,
AVG_ROW_LENGTH = 963,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

ALTER TABLE `byzghdb_test`.`organizations_wuxiao` 
ADD COLUMN `rewards` varchar(255) NULL COMMENT '获得奖项' AFTER `declaration_time`;

ALTER TABLE `byzghdb_test`.`case_schemes` 
ADD COLUMN `is_open` int(1) ZEROFILL NULL DEFAULT 0 COMMENT '是否开启' AFTER `system_version`;

ALTER TABLE `byzghdb_test`.`organizations_wuxiao` 
ADD COLUMN `industry_id` int(11) NULL COMMENT '所属行业' AFTER `rewards`;

ALTER TABLE `byzghdb_test`.`nominees` 
ADD COLUMN `declare_status` int(11) NULL COMMENT '申报状态' AFTER `system_version`;

ALTER TABLE `byzghdb_test`.`nominees` 
MODIFY COLUMN `declare_status` int(11) NULL DEFAULT 0 COMMENT '申报状态 1已申报 0未申报 ' AFTER `system_version`,
ADD COLUMN `check_status` int(11) NULL COMMENT '审核状态 0未审核 1通过 2未通过' AFTER `declare_status`,
ADD COLUMN `declare_at` timestamp(0) NULL COMMENT '申报时间' AFTER `check_status`,
ADD COLUMN `check_at` timestamp(0) NULL COMMENT '审核时间' AFTER `declare_at`;

alter table organizations_wuxiao
	add case_scheme_id int null comment '推荐赛事';
	
	ALTER TABLE case_schemes 
  ADD COLUMN prize_at TIMESTAMP NULL DEFAULT NULL COMMENT '颁奖时间';
  
  
  
  create table case_scheme_type
(
    id         int(10)                             not null
        primary key,
    name       varchar(255)                        not null comment '赛事类型名',
    create_at  timestamp default CURRENT_TIMESTAMP null comment '创建时间',
    deleted_at timestamp                           null comment '删除时间',
    update_at  timestamp                           null comment '更新时间'
)
    comment '赛事类型';
	
	
	
	ALTER TABLE `byzghdb_test`.`organizations_wuxiao` 
ADD COLUMN `month_win` timestamp(0) NULL COMMENT '月度被选中' AFTER `case_scheme_id`,
ADD COLUMN `quarter_win` timestamp(0) NULL COMMENT '季度被选中' AFTER `month_win`,
ADD COLUMN `year_win` timestamp(0) NULL COMMENT '年度被选中' AFTER `quarter_win`,
ADD COLUMN `quarter_rank` int(11) NULL COMMENT '季度票数' AFTER `year_win`,
ADD COLUMN `year_rank` int(11) NULL COMMENT '年度票数' AFTER `quarter_rank`,
ADD COLUMN `quart` int(11) NULL COMMENT '季度赛事ID' AFTER `year_rank`;

ALTER TABLE `byzghdb_test`.`nominees` 
ADD COLUMN `year` int(11) NULL COMMENT '年度赛事' AFTER `quart`;


ALTER TABLE `byzghdb_test`.`organizations_wuxiao` 
ADD COLUMN `year` int(11) NULL COMMENT '年度赛事ＩＤ' AFTER `deleted_at`;

ALTER TABLE `byzghdb_test`.`nominees` 
ADD COLUMN `browse_count` int(11) NULL COMMENT '浏览数量' AFTER `year_vote_sum`,


ALTER TABLE `byzghdb_test`.`case_schemes` 
ADD COLUMN `show_is_join` int(1) NULL COMMENT '是否参与展示' AFTER `show_etime`,
ADD COLUMN `show_is_open` int(1) NULL COMMENT '展示是否开启' AFTER `show_is_join`,
ADD COLUMN `qy_is_join` int(1) NULL COMMENT '企业推选是否参加' AFTER `qy_etime`,
ADD COLUMN `qy_is_open` int(1) NULL COMMENT '企业推选是否开启' AFTER `qy_is_join`,
ADD COLUMN `gh_is_join` int(1) NULL COMMENT '基层工会是否参与' AFTER `gh_etime`,
ADD COLUMN `gh_is_open` int(1) NULL COMMENT '工会推选是否开启' AFTER `gh_is_join`,
ADD COLUMN `zj_is_join` int(1) NULL COMMENT '专家是否参与投票' AFTER `zj_etime`,
ADD COLUMN `zj_is_open` int NULL COMMENT '专家投票是否开启' AFTER `zj_is_join`,
ADD COLUMN `year_is_join` int(1) NULL COMMENT '是否参与年度投票' AFTER `year_etime`,
ADD COLUMN `year_is_open` int(1) NULL COMMENT '年度投票是否开启' AFTER `year_is_join`,
ADD COLUMN `activity_stime` timestamp(0) NULL COMMENT '活动开始时间' AFTER `prize_at`,
ADD COLUMN `activity_etime` timestamp(0) NULL COMMENT '活动结束时间' AFTER `activity_stime`,
ADD COLUMN `public_stime` timestamp(0) NULL COMMENT '大众评选' AFTER `activity_etime`,
ADD COLUMN `public_etime` timestamp(0) NULL COMMENT '大众评选结束时间' AFTER `public_stime`,
ADD COLUMN `public_is_join` int(1) NULL COMMENT '大众是否参与' AFTER `public_etime`,
ADD COLUMN `public_is_open` int(1) NULL COMMENT '大众是否开启' AFTER `public_is_join`;
ADD COLUMN `show_explain` varchar(500) NULL COMMENT '展示描述' AFTER `show_is_open`,
ADD COLUMN `qy_explain` varchar(500) NULL COMMENT '企业推选描述' AFTER `qy_is_open`,
ADD COLUMN `gh_explain` varchar(500) NULL COMMENT '工会推选描述' AFTER `gh_is_open`,
ADD COLUMN `zgh_stime` timestamp(0) NULL COMMENT '总工会筛选开始时间' AFTER `gh_explain`,
ADD COLUMN `zgh_etime` timestamp(0) NULL COMMENT '总工会筛选结束时间' AFTER `zgh_stime`,
ADD COLUMN `zgh_is_join` int(1) NULL COMMENT '总工会是否参与' AFTER `zgh_etime`,
ADD COLUMN `zgh_is_open` int(1) NULL COMMENT '总工会筛选是否开启' AFTER `zgh_is_join`,
ADD COLUMN `zj_explain` varchar(500) NULL COMMENT '专家投票描述' AFTER `zj_is_open`,
ADD COLUMN `year_explain` varchar(500) NULL COMMENT '年度投票描述' AFTER `year_is_open`;
ADD COLUMN `zgh_explain` varchar(500) NULL COMMENT '总工会筛选说明' AFTER `zgh_is_open`,
ADD COLUMN `activity_explain` varchar(500) NULL COMMENT '活动说明' AFTER `activity_etime`,
ADD COLUMN `public_explain` varchar(500) NULL COMMENT '大众评选说明' AFTER `public_is_open`;


alter table nominees
	add browse_count int default 0 null comment '浏览量',

	add v_browse_count int default 0 null comment '虚拟浏览量',

	add v_star_count int default 0 null comment '虚拟点赞数量';


ALTER TABLE `byzghdb_test`.`organizations_wuxiao` 
ADD COLUMN `v_browse_count` int(11) NULL COMMENT '虚拟浏览量' AFTER `year`,
ADD COLUMN `v_star_count` int(11) NULL COMMENT '虚拟点赞数' AFTER `v_browse_count`;




CREATE TABLE `byzghdb_test`.`case_file`  (
  `id` int(11) auto_increment NOT NULL,
  `name` varchar(255) NULL COMMENT '名称',
  `icon` varchar(255) NULL COMMENT '图标',
  `context` varchar(500) NULL COMMENT '内容',
  `img` varchar(500) NULL COMMENT '图片',
  `file` varchar(500) NULL COMMENT '文件',
  `type` int(11) NULL DEFAULT 1 COMMENT '文件类型 1活动文件 2活动规则文件 3活动奖项文件'
  `status` int(1) default 0 NULL COMMENT '状态',
  `created_at` timestamp(0) NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL COMMENT '更新时间',
  `deleted_at` timestamp(0) NULL COMMENT '删除时间',
  `is_push` int(1) default 0 NULL COMMENT '是否重点',
  PRIMARY KEY (`id`)
) COMMENT = '赛事文件';
CREATE TABLE byzghdb_test.unit_homepage (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  unit_id int(11) DEFAULT NULL COMMENT '工会ID',
  unit_name varchar(255) DEFAULT NULL COMMENT '工会名称',
  unit_url varchar(255) DEFAULT NULL COMMENT '工会地址',
  cover varchar(255) DEFAULT NULL COMMENT '封面',
  theme_color int(1) DEFAULT 1 COMMENT '主体颜色 1-蓝色 2-红色',
  page_title varchar(255) DEFAULT NULL COMMENT '页面标题',
  page_describe varchar(1000) DEFAULT NULL COMMENT '页面描述',
  wechat_photo varchar(255) DEFAULT NULL COMMENT '分享微信头像',
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  deleted_at timestamp NULL  COMMENT '删除时间',
  PRIMARY KEY (id)
)
ENGINE = INNODB,
COMMENT = '工会主页';

alter table nominees
	add recommend int default 0 null comment '是否推荐';
	
	alter table organizations_wuxiao
	add recommend int default 0 null comment '推荐到前台';