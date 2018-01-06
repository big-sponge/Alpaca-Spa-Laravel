/*
Navicat MySQL Data Transfer

Source Server         : 122.152.215.93
Source Server Version : 50548
Source Host           : 122.152.215.93:3306
Source Database       : db_tpfull

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2018-01-06 21:31:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_auth`;
CREATE TABLE `tb_admin_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `controller` varchar(50) DEFAULT NULL COMMENT '控制器',
  `action` varchar(50) DEFAULT NULL COMMENT '动作',
  `menu_id` varchar(50) DEFAULT NULL COMMENT '菜单ID',
  `menu_status` tinyint(2) DEFAULT '1' COMMENT '菜单状态，默认1-跳转显示，2-高亮，3-无效',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态 1为一级，2为二级 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';

-- ----------------------------
-- Records of tb_admin_auth
-- ----------------------------
INSERT INTO `tb_admin_auth` VALUES ('1', '一般权限', '', '', null, null, '1', '0', '1', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('2', '个人信息', '', 'auth', 'info', '', '1', '1', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('3', '修改密码', '', 'auth', 'resetPwdByOld', '', '1', '1', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('4', '用户管理（后台）', '', '', '', '', '1', '0', '1', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('5', '查看用户列表', '', 'admin', 'getMemberList', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('6', '编辑用户', null, 'admin', 'editMember', '', '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('7', '删除用户', null, 'admin', 'deleteMember', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('8', '查看分组列表', null, 'admin', 'getGroupList', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('9', '编辑分组', null, 'admin', 'editGroup', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('10', '删除分组', null, 'admin', 'deleteGroup', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('11', '查看权限列表', null, 'admin', 'getAuthList', null, '1', '4', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('12', '定时任务', null, '', '', null, '1', '0', '1', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('13', '查看定时任务进程状态', null, 'crontab', 'status', null, '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('14', '开始定时任务进程', null, 'crontab', 'start', null, '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('15', '停止定时任务进程', null, 'crontab', 'stop', null, '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('16', '编辑定时任务', null, 'crontab', 'editTask', null, '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('17', '设置指定定时任务状态', null, 'crontab', 'changeTaskStatus', '', '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('18', '获取指定定时任务', null, 'crontab', 'getIndexTask', null, '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('19', '删除指定定时任务', null, 'crontab', 'removeTask', '', '1', '12', '2', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_auth` VALUES ('20', '获取定时任务列表', null, 'crontab', 'listTask', null, '1', '12', '2', '1', null, null, null, '', '', null);

-- ----------------------------
-- Table structure for tb_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_group`;
CREATE TABLE `tb_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组id',
  `name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '分组描述',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组表';

-- ----------------------------
-- Records of tb_admin_group
-- ----------------------------
INSERT INTO `tb_admin_group` VALUES ('1', 'admin', 'admin', '2017-07-04 17:23:42', '2017-06-28 10:55:07', null, '', 'gust', '127.0.0.1');
INSERT INTO `tb_admin_group` VALUES ('2', '测试', '测试', '2018-01-06 21:26:43', '2017-07-01 23:25:12', null, 'gust', 'admin', '220.115.236.125');

-- ----------------------------
-- Table structure for tb_admin_group_auth
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_group_auth`;
CREATE TABLE `tb_admin_group_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组权限关系表';

-- ----------------------------
-- Records of tb_admin_group_auth
-- ----------------------------
INSERT INTO `tb_admin_group_auth` VALUES ('1', '2', '2', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('2', '2', '5', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('3', '2', '8', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('4', '2', '11', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('5', '2', '13', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('6', '2', '18', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');
INSERT INTO `tb_admin_group_auth` VALUES ('7', '2', '20', '1', '2018-01-06 21:26:43', '2018-01-06 21:26:43', null, 'admin', 'admin', '220.115.236.125');

-- ----------------------------
-- Table structure for tb_admin_member
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_member`;
CREATE TABLE `tb_admin_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名称',
  `real_name` varchar(20) DEFAULT NULL COMMENT '真实姓名',
  `id_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '枚举-证件种类, 1=身份证',
  `id_no` varchar(250) DEFAULT NULL COMMENT '证件号码',
  `checking_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '枚举-认证状态,0=未认证=no，1=认证',
  `checking_time` datetime DEFAULT NULL COMMENT '认证时间',
  `avatar` varchar(200) DEFAULT NULL COMMENT '会员头像',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别 1男 2女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `passwd` varchar(100) DEFAULT NULL COMMENT '密码',
  `member_level` tinyint(4) DEFAULT '0' COMMENT '用户级别 0 普通 1 VIP',
  `mobile` varchar(15) DEFAULT '' COMMENT '手机号',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile_bind` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未绑定1已绑定',
  `email_bind` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未绑定1已绑定',
  `login_times` int(11) DEFAULT '1' COMMENT '登录次数',
  `reg_time` datetime DEFAULT NULL COMMENT '会员注册时间',
  `login_time` datetime DEFAULT NULL COMMENT '当前登录时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '上次登录ip',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`),
  KEY `ix_email` (`email`),
  KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of tb_admin_member
-- ----------------------------
INSERT INTO `tb_admin_member` VALUES ('1', 'admin', null, '1', null, '0', null, null, null, null, '$2y$10$xtn/IRD/AWRYs1/Veoy.yuNyW3GbI.r5bL2RVT9TDGRdvjoQ6.Ufu', '0', '', 'admin@tkc8.com', '0', '0', '263', null, '2017-12-12 11:14:41', '221.238.11.98', '2017-12-12 11:14:41', '221.238.11.98', '0', '1', '2018-01-06 21:29:29', null, null, '', 'admin', '221.238.11.98');
INSERT INTO `tb_admin_member` VALUES ('2', '测试账号', null, '1', null, '0', null, null, null, null, '$2y$10$4HoqxdcEx0F9PffYOEIso.nlDpqh5SHeLPn/Z.PHRm601N7PRXq..', '0', '', 'test@tkc8.com', '0', '0', '4896', null, '2018-01-06 21:29:38', '220.115.236.125', '2018-01-06 20:59:32', '220.115.236.125', '0', '1', '2018-01-06 21:29:38', '2017-07-04 17:03:00', null, 'gust', 'gust', '220.115.236.125');

-- ----------------------------
-- Table structure for tb_admin_member_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_member_group`;
CREATE TABLE `tb_admin_member_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户分组id',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `role` tinyint(2) DEFAULT '0' COMMENT '角色, 默认0-普通，1-组管理员',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台用户分组关系表';

-- ----------------------------
-- Records of tb_admin_member_group
-- ----------------------------
INSERT INTO `tb_admin_member_group` VALUES ('1', '1', '1', '0', '1', null, null, null, '', '', null);
INSERT INTO `tb_admin_member_group` VALUES ('2', '2', '2', '0', '1', '2018-01-06 21:26:56', '2018-01-06 21:26:56', null, 'admin', 'admin', '220.115.236.125');

-- ----------------------------
-- Table structure for tb_user_auth
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_auth`;
CREATE TABLE `tb_user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `controller` varchar(50) DEFAULT NULL COMMENT '控制器',
  `action` varchar(50) DEFAULT NULL COMMENT '动作',
  `menu_id` varchar(50) DEFAULT NULL COMMENT '菜单ID',
  `menu_status` tinyint(2) DEFAULT '1' COMMENT '菜单状态，默认1-跳转显示，2-高亮，3-无效',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态 1为一级，2为二级 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台权限表';

-- ----------------------------
-- Records of tb_user_auth
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_group`;
CREATE TABLE `tb_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组id',
  `name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '分组描述',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台分组表';

-- ----------------------------
-- Records of tb_user_group
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user_group_auth
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_group_auth`;
CREATE TABLE `tb_user_group_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台分组权限关系表';

-- ----------------------------
-- Records of tb_user_group_auth
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user_member
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_member`;
CREATE TABLE `tb_user_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名称',
  `real_name` varchar(20) DEFAULT NULL COMMENT '真实姓名',
  `id_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '枚举-证件种类, 1=身份证',
  `id_no` varchar(250) DEFAULT NULL COMMENT '证件号码',
  `checking_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '枚举-认证状态,0=未认证=no，1=认证',
  `checking_time` datetime DEFAULT NULL COMMENT '认证时间',
  `avatar` varchar(200) DEFAULT NULL COMMENT '会员头像',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别 1男 2女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `passwd` varchar(100) DEFAULT NULL COMMENT '密码',
  `member_level` tinyint(4) DEFAULT '0' COMMENT '用户级别 0 普通 1 VIP',
  `mobile` varchar(15) DEFAULT '' COMMENT '手机号',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile_bind` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未绑定1已绑定',
  `email_bind` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未绑定1已绑定',
  `login_times` int(11) DEFAULT '1' COMMENT '登录次数',
  `reg_time` datetime DEFAULT NULL COMMENT '会员注册时间',
  `login_time` datetime DEFAULT NULL COMMENT '当前登录时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '上次登录ip',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`),
  KEY `ix_email` (`email`),
  KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='前台用户表';

-- ----------------------------
-- Records of tb_user_member
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user_member_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_member_group`;
CREATE TABLE `tb_user_member_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户分组id',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `role` tinyint(2) DEFAULT '0' COMMENT '角色, 默认0-普通，1-组管理员',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台用户分组关系表';

-- ----------------------------
-- Records of tb_user_member_group
-- ----------------------------

-- ----------------------------
-- Table structure for tb_user_wx
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_wx`;
CREATE TABLE `tb_user_wx` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `open_id` char(50) NOT NULL COMMENT 'openid',
  `name` char(50) DEFAULT '' COMMENT '昵称',
  `avatar` char(255) DEFAULT '' COMMENT '头像URL',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COMMENT='用户微信信息表';

-- ----------------------------
-- Records of tb_user_wx
-- ----------------------------
INSERT INTO `tb_user_wx` VALUES ('1', 'otUf91XGREEsyWhYBLoS5_rOOtKU', '大弹簧', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '2017-08-14 15:15:30', '2017-08-14 15:15:30', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('2', 'otUf91eXE58FXeWLC8ycZ84TT_Eo', 'Fay', 'http://wx.qlogo.cn/mmopen/IHUqBJMlBwxsItgE0WyiaHVgCxC148vyuIXuiaM3LIe3OxGSAxVnUTib9jqcQhNhVBQrIh1iaqpZBUMQr3K6e2NHiaNGgtDw8tGWJ/0', '0', '2017-08-21 21:10:07', '2017-08-21 21:10:07', null, 'gust', 'gust', '220.115.236.21');
INSERT INTO `tb_user_wx` VALUES ('3', 'otUf91b8nxKZB0fbsB6u5smPwXik', 'lina', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXsuI2yrt7SHKspnXkdkZzjqQGnibcw1FyJjfI4qBxYuqiaHjDJf8mibibM4RViaicd2TwNG7wcAdfwf6Bg/0', '0', '2017-08-22 11:40:04', '2017-08-22 11:40:04', null, 'gust', 'gust', '60.29.127.158');
INSERT INTO `tb_user_wx` VALUES ('4', 'otUf91SsG1QbvrEoPRjE94Eg4ZPc', '雨晨似墨', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXvY2If59RUicnSO3beSSqdtPzLk92dpHXF8avTqO1otQTyrZ5qoJRBJ3IllqBJuK9yMTRmmjIkicTV/0', '0', '2017-08-22 11:41:24', '2017-08-22 11:41:24', null, 'gust', 'gust', '60.29.127.158');
INSERT INTO `tb_user_wx` VALUES ('8', '-', 'kang', '', '0', '2017-09-01 15:31:59', '2017-09-01 15:31:59', null, 'gust', 'gust', '120.239.14.182');
INSERT INTO `tb_user_wx` VALUES ('9', '-', 'passenger', '', '0', '2017-09-04 09:17:36', '2017-09-04 09:17:36', null, 'gust', 'gust', '101.226.102.80');
INSERT INTO `tb_user_wx` VALUES ('17', 'otUf91aHDNS1nbg0JcDogJh9ckEg', '?我不该拥有这么美的梦??', 'http://wx.qlogo.cn/mmopen/AbruuZ3ILCl3577Diaev5ZNa3eOdLOnu8MENibolJeMGiaQDyyQGMkt673TRG1x4V070fH3XwJGhl2ia7OwkYicEufQ/0', '0', '2017-09-06 18:36:10', '2017-09-06 18:36:10', null, 'gust', 'gust', '118.186.6.218');
INSERT INTO `tb_user_wx` VALUES ('18', 'otUf91Z2w0kZlAlpAPZPjSZJp-Sw', '微商小时代', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBSjZXE6hlH7Ls1XglvQgvL8K3tY6yUDLfGcxKWICczmPyntCcdwibyEBKV5l4MQGQo6UYsdcwx5iaQ/0', '0', '2017-09-06 19:05:25', '2017-09-06 19:05:25', null, 'gust', 'gust', '118.186.6.218');
INSERT INTO `tb_user_wx` VALUES ('26', '-', 'edfdf', '', '0', '2017-09-08 14:55:11', '2017-09-08 14:55:11', null, 'gust', 'gust', '139.189.97.13');
INSERT INTO `tb_user_wx` VALUES ('27', '-', 'CC', '', '0', '2017-09-08 16:32:02', '2017-09-08 16:32:02', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('30', '-', 'uuu', '', '0', '2017-09-08 18:29:10', '2017-09-08 18:29:10', null, 'gust', 'gust', '222.82.81.116');
INSERT INTO `tb_user_wx` VALUES ('31', '-', '123', '', '0', '2017-09-09 13:13:17', '2017-09-09 13:13:17', null, 'gust', 'gust', '222.82.95.212');
INSERT INTO `tb_user_wx` VALUES ('32', '-', '皮皮虾', '', '0', '2017-09-10 12:12:20', '2017-09-10 12:12:20', null, 'gust', 'gust', '183.39.196.86');
INSERT INTO `tb_user_wx` VALUES ('33', '-', 'mm', '', '0', '2017-09-10 12:25:38', '2017-09-10 12:25:38', null, 'gust', 'gust', '183.39.196.86');
INSERT INTO `tb_user_wx` VALUES ('34', '-', '666', '', '0', '2017-09-11 13:34:54', '2017-09-11 13:34:54', null, 'gust', 'gust', '115.206.134.92');
INSERT INTO `tb_user_wx` VALUES ('35', '-', '1', '', '0', '2017-09-11 17:44:01', '2017-09-11 17:44:01', null, 'gust', 'gust', '223.104.16.55');
INSERT INTO `tb_user_wx` VALUES ('36', '-', 'pulong', '', '0', '2017-09-11 22:29:24', '2017-09-11 22:29:24', null, 'gust', 'gust', '125.70.205.109');
INSERT INTO `tb_user_wx` VALUES ('37', '-', 'QQ', '', '0', '2017-09-12 15:40:16', '2017-09-12 15:40:16', null, 'gust', 'gust', '60.29.127.158');
INSERT INTO `tb_user_wx` VALUES ('38', '-', '33', '', '0', '2017-09-12 22:35:15', '2017-09-12 22:35:15', null, 'gust', 'gust', '61.158.149.216');
INSERT INTO `tb_user_wx` VALUES ('40', '-', '哈哈哈', '', '0', '2017-09-18 23:39:51', '2017-09-18 23:39:51', null, 'gust', 'gust', '122.242.65.220');
INSERT INTO `tb_user_wx` VALUES ('41', '-', '红红火火', '', '0', '2017-09-19 13:53:08', '2017-09-19 13:53:08', null, 'gust', 'gust', '140.243.34.202');
INSERT INTO `tb_user_wx` VALUES ('42', '-', 'ttt', '', '0', '2017-09-20 11:00:10', '2017-09-20 11:00:10', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('43', 'otUf91ZHKCgi1MsmGWOCOga9GKtg', 'yavana', 'http://wx.qlogo.cn/mmopen/5naj4jqUIqsNeT02hjnPn36Dx5qFsfxGCQZXGjXicT1ToxozibnPAs6RX9JHrzneLJH6ZQCKWfHzibAQNgFY7veawWNkShfFGxw/0', '0', '2017-09-20 16:51:49', '2017-09-20 16:51:49', null, 'gust', 'gust', '222.209.233.132');
INSERT INTO `tb_user_wx` VALUES ('44', '-', '12312', '', '0', '2017-09-20 17:36:15', '2017-09-20 17:36:15', null, 'gust', 'gust', '60.29.127.158');
INSERT INTO `tb_user_wx` VALUES ('45', '-', '哈哈哈', '', '0', '2017-09-20 22:13:30', '2017-09-20 22:13:30', null, 'gust', 'gust', '119.85.101.218');
INSERT INTO `tb_user_wx` VALUES ('46', '-', 'rabbit', '', '0', '2017-09-21 14:34:04', '2017-09-21 14:34:04', null, 'gust', 'gust', '221.196.56.206');
INSERT INTO `tb_user_wx` VALUES ('47', '-', 'test', '', '0', '2017-09-21 15:58:18', '2017-09-21 15:58:18', null, 'gust', 'gust', '113.66.228.180');
INSERT INTO `tb_user_wx` VALUES ('48', '-', '23234', '', '0', '2017-09-26 18:04:39', '2017-09-26 18:04:39', null, 'gust', 'gust', '122.227.25.58');
INSERT INTO `tb_user_wx` VALUES ('49', '-', 'npy', '', '0', '2017-10-02 09:35:47', '2017-10-02 09:35:47', null, 'gust', 'gust', '115.34.174.49');
INSERT INTO `tb_user_wx` VALUES ('50', '-', 'npy', '', '0', '2017-10-02 09:35:48', '2017-10-02 09:35:48', null, 'npy', 'npy', '115.34.174.49');
INSERT INTO `tb_user_wx` VALUES ('51', '-', 'test', '', '0', '2017-10-02 09:36:46', '2017-10-02 09:36:46', null, 'gust', 'gust', '123.151.152.214');
INSERT INTO `tb_user_wx` VALUES ('52', '-', 'kkk', '', '0', '2017-10-08 13:18:46', '2017-10-08 13:18:46', null, 'gust', 'gust', '117.136.86.39');
INSERT INTO `tb_user_wx` VALUES ('53', '-', 'gg', '', '0', '2017-10-10 20:49:35', '2017-10-10 20:49:35', null, 'gust', 'gust', '124.15.193.200');
INSERT INTO `tb_user_wx` VALUES ('54', '-', '12', '', '0', '2017-10-11 05:44:51', '2017-10-11 05:44:51', null, 'gust', 'gust', '60.178.38.11');
INSERT INTO `tb_user_wx` VALUES ('55', '-', '1111', '', '0', '2017-10-13 17:20:34', '2017-10-13 17:20:34', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('56', '-', 'Lux', '', '0', '2017-10-13 18:07:20', '2017-10-13 18:07:20', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('57', '-', 'aa', '', '0', '2017-10-13 18:08:07', '2017-10-13 18:08:07', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('58', '-', '111', '', '0', '2017-10-13 23:05:25', '2017-10-13 23:05:25', null, 'gust', 'gust', '220.115.236.239');
INSERT INTO `tb_user_wx` VALUES ('59', '-', '大于', '', '0', '2017-10-14 10:13:46', '2017-10-14 10:13:46', null, 'gust', 'gust', '119.166.176.75');
INSERT INTO `tb_user_wx` VALUES ('60', '-', 'wxwx', '', '0', '2017-10-17 15:28:54', '2017-10-17 15:28:54', null, 'gust', 'gust', '223.104.174.70');
INSERT INTO `tb_user_wx` VALUES ('61', '-', '好久', '', '0', '2017-10-22 17:20:30', '2017-10-22 17:20:30', null, 'gust', 'gust', '125.119.101.115');
INSERT INTO `tb_user_wx` VALUES ('62', '-', 'ffghf', '', '0', '2017-10-22 17:26:20', '2017-10-22 17:26:20', null, 'gust', 'gust', '125.119.101.115');
INSERT INTO `tb_user_wx` VALUES ('63', 'otUf91V0AOqlpNVj6l37D2sHvaT4', '/:turn1', 'http://wx.qlogo.cn/mmopen/IHUqBJMlBwxsItgE0WyiaHYclSYx46ibB0tQRhcKHKpsGDuiaXCxE1IiaaFyefCDL85j70NBQ9dEzv5vFhySictYiabjYydW3M8Dyq/0', '0', '2017-10-23 16:33:57', '2017-10-23 16:33:57', null, 'gust', 'gust', '182.18.15.50');
INSERT INTO `tb_user_wx` VALUES ('64', '-', '以后好好', '', '0', '2017-11-02 20:39:39', '2017-11-02 20:39:39', null, 'gust', 'gust', '183.3.255.28');
INSERT INTO `tb_user_wx` VALUES ('65', '-', '？', '', '0', '2017-11-03 15:30:51', '2017-11-03 15:30:51', null, 'gust', 'gust', '182.18.19.162');
INSERT INTO `tb_user_wx` VALUES ('66', '-', 'l w c', '', '0', '2017-11-03 15:31:21', '2017-11-03 15:31:21', null, 'gust', 'gust', '182.18.19.162');
INSERT INTO `tb_user_wx` VALUES ('67', '-', '～', '', '0', '2017-11-03 15:54:40', '2017-11-03 15:54:40', null, 'gust', 'gust', '113.247.2.82');
INSERT INTO `tb_user_wx` VALUES ('68', '-', 'Moon', '', '0', '2017-11-08 17:32:15', '2017-11-08 17:32:15', null, 'gust', 'gust', '222.90.69.234');
INSERT INTO `tb_user_wx` VALUES ('69', '-', 'gg', '', '0', '2017-11-09 10:07:02', '2017-11-09 10:07:02', null, 'gust', 'gust', '123.150.129.203');
INSERT INTO `tb_user_wx` VALUES ('70', '-', 'semi', '', '0', '2017-11-10 00:16:37', '2017-11-10 00:16:37', null, 'gust', 'gust', '124.117.123.197');
INSERT INTO `tb_user_wx` VALUES ('71', '-', 'adm', '', '0', '2017-11-10 17:21:33', '2017-11-10 17:21:33', null, 'gust', 'gust', '119.4.180.171');
INSERT INTO `tb_user_wx` VALUES ('72', '-', '123', '', '0', '2017-11-15 09:37:13', '2017-11-15 09:37:13', null, 'gust', 'gust', '222.90.69.234');
INSERT INTO `tb_user_wx` VALUES ('73', '-', '健健康康', '', '0', '2017-11-15 13:29:59', '2017-11-15 13:29:59', null, 'gust', 'gust', '122.192.14.195');
INSERT INTO `tb_user_wx` VALUES ('74', '-', 'GG', '', '0', '2017-11-15 18:26:37', '2017-11-15 18:26:37', null, 'gust', 'gust', '120.84.141.88');
INSERT INTO `tb_user_wx` VALUES ('75', '-', '123', '', '0', '2017-11-16 10:18:41', '2017-11-16 10:18:41', null, 'gust', 'gust', '124.129.208.84');
INSERT INTO `tb_user_wx` VALUES ('76', '-', '11111', '', '0', '2017-11-17 15:33:21', '2017-11-17 15:33:21', null, 'gust', 'gust', '27.47.5.51');
INSERT INTO `tb_user_wx` VALUES ('77', '-', '123333', '', '0', '2017-11-17 15:33:59', '2017-11-17 15:33:59', null, 'gust', 'gust', '27.47.5.51');
INSERT INTO `tb_user_wx` VALUES ('78', '-', 'q', '', '0', '2017-11-19 21:47:43', '2017-11-19 21:47:43', null, 'gust', 'gust', '110.184.71.204');
INSERT INTO `tb_user_wx` VALUES ('79', '-', '清平乐', '', '0', '2017-11-20 09:33:32', '2017-11-20 09:33:32', null, 'gust', 'gust', '117.136.62.44');
INSERT INTO `tb_user_wx` VALUES ('80', '-', 'kfjfkfkkf', '', '0', '2017-11-22 09:40:00', '2017-11-22 09:40:00', null, 'gust', 'gust', '223.104.188.165');
INSERT INTO `tb_user_wx` VALUES ('81', 'otUf91eUx_WyWhk5FyJE85TZXOoc', '悟定·不住', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLC9eyoia8nxSqsqE5KD1rhUkUQzMybS4iczKeTFcZaMiakibXyrHL5AUYbQ0sqwz147yHibHP2dDfYfic3Q/0', '0', '2017-11-23 14:55:09', '2017-11-23 14:55:09', null, 'gust', 'gust', '221.13.1.253');
INSERT INTO `tb_user_wx` VALUES ('82', '-', 'qq', '', '0', '2017-11-27 15:11:19', '2017-11-27 15:11:19', null, 'gust', 'gust', '180.79.34.157');
INSERT INTO `tb_user_wx` VALUES ('83', '-', 'gggg', '', '0', '2017-12-04 18:59:14', '2017-12-04 18:59:14', null, 'gust', 'gust', '117.101.164.10');
INSERT INTO `tb_user_wx` VALUES ('84', '-', '花生', '', '0', '2017-12-06 14:20:44', '2017-12-06 14:20:44', null, 'gust', 'gust', '117.136.79.164');
INSERT INTO `tb_user_wx` VALUES ('85', '-', 'hhhh', '', '0', '2017-12-12 11:50:09', '2017-12-12 11:50:09', null, 'gust', 'gust', '124.202.195.174');
INSERT INTO `tb_user_wx` VALUES ('86', '-', '啧啧啧', '', '0', '2017-12-12 12:05:50', '2017-12-12 12:05:50', null, 'gust', 'gust', '119.39.248.15');
INSERT INTO `tb_user_wx` VALUES ('87', '-', '京津冀', '', '0', '2017-12-13 15:34:59', '2017-12-13 15:34:59', null, 'gust', 'gust', '211.103.82.178');
INSERT INTO `tb_user_wx` VALUES ('88', '-', 'g g', '', '0', '2017-12-13 16:05:57', '2017-12-13 16:05:57', null, 'gust', 'gust', '101.81.250.75');
INSERT INTO `tb_user_wx` VALUES ('89', '-', 'KK', '', '0', '2017-12-13 16:14:58', '2017-12-13 16:14:58', null, 'gust', 'gust', '47.91.154.93');
INSERT INTO `tb_user_wx` VALUES ('90', '-', 'MM', '', '0', '2017-12-13 16:19:11', '2017-12-13 16:19:11', null, 'gust', 'gust', '47.91.154.93');
INSERT INTO `tb_user_wx` VALUES ('91', '-', '111', '', '0', '2017-12-18 12:35:14', '2017-12-18 12:35:14', null, 'gust', 'gust', '180.79.34.157');
INSERT INTO `tb_user_wx` VALUES ('92', '-', '12312', '', '0', '2017-12-22 10:54:05', '2017-12-22 10:54:05', null, 'gust', 'gust', '221.238.11.98');
INSERT INTO `tb_user_wx` VALUES ('93', '-', '123456', '', '0', '2017-12-22 11:02:09', '2017-12-22 11:02:09', null, 'gust', 'gust', '27.187.50.130');
INSERT INTO `tb_user_wx` VALUES ('94', '-', '并不代表', '', '0', '2017-12-27 10:44:53', '2017-12-27 10:44:53', null, 'gust', 'gust', '183.162.47.172');
INSERT INTO `tb_user_wx` VALUES ('95', '-', '213213213', '', '0', '2018-01-03 15:12:25', '2018-01-03 15:12:25', null, 'gust', 'gust', '114.86.42.232');

-- ----------------------------
-- Table structure for tb_ws_token
-- ----------------------------
DROP TABLE IF EXISTS `tb_ws_token`;
CREATE TABLE `tb_ws_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `member_id` char(50) NOT NULL COMMENT '用户id',
  `member_type` tinyint(2) DEFAULT '1' COMMENT '用户类型，枚举|1-用户-USER|2-管理员-ADMIN',
  `token` varchar(65) DEFAULT '' COMMENT 'TOKEN',
  `available_time` datetime DEFAULT null COMMENT '有效截至时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3088 DEFAULT CHARSET=utf8mb4 COMMENT='websocket登录token表';

-- ----------------------------
-- Records of tb_ws_token
-- ----------------------------
INSERT INTO `tb_ws_token` VALUES ('2638', '7', '2', '4c292be210f42e907f1701944fd4e1b8', '2017-12-12 11:12:17', '2017-12-12 11:07:17', '2017-12-12 11:07:17', null, '测试账号', '测试账号', '221.238.11.98');
INSERT INTO `tb_ws_token` VALUES ('2639', '7', '2', '7e83351f4364f612a74e1f91de117990', '2017-12-12 11:14:39', '2017-12-12 11:09:39', '2017-12-12 11:09:39', null, '测试账号', '测试账号', '221.238.11.98');
INSERT INTO `tb_ws_token` VALUES ('2640', '7', '2', '2ffac388c38a2fe542f493c1d7e64e90', '2017-12-12 11:15:53', '2017-12-12 11:10:53', '2017-12-12 11:10:53', null, '测试账号', '测试账号', '221.238.11.98');
INSERT INTO `tb_ws_token` VALUES ('2641', '7', '2', '9714c3eb44770f489f81f1121e84542e', '2017-12-12 11:16:12', '2017-12-12 11:11:12', '2017-12-12 11:11:12', null, '测试账号', '测试账号', '221.238.11.98');
INSERT INTO `tb_ws_token` VALUES ('2642', '7', '2', '36098419b90e6863949c175b8db85a8b', '2017-12-12 11:18:08', '2017-12-12 11:13:08', '2017-12-12 11:13:08', null, '测试账号', '测试账号', '221.238.11.98');
INSERT INTO `tb_ws_token` VALUES ('2815', '7', '2', '73fe072bd592b57954a95e79b350937f', '2017-12-22 20:34:20', '2017-12-22 20:29:20', '2017-12-22 20:29:20', null, '测试账号', '测试账号', '222.212.66.148');
INSERT INTO `tb_ws_token` VALUES ('2966', '7', '2', '5fe47f7d99b4fffcf870845e60442d92', '2017-12-29 15:13:58', '2017-12-29 15:08:58', '2017-12-29 15:08:58', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2967', '7', '2', '794fef92d66c5a705f41d7890cf00318', '2017-12-29 15:14:19', '2017-12-29 15:09:19', '2017-12-29 15:09:19', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2968', '7', '2', '115f7878f478260bae87144673062ddb', '2017-12-29 15:15:47', '2017-12-29 15:10:47', '2017-12-29 15:10:47', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2969', '7', '2', '7f2699eeebcf6cd09d765a017b8251f8', '2017-12-29 15:15:55', '2017-12-29 15:10:55', '2017-12-29 15:10:55', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2970', '7', '2', 'dfaad3849c2aa8bba7843139e04692f8', '2017-12-29 15:16:14', '2017-12-29 15:11:14', '2017-12-29 15:11:14', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2971', '7', '2', 'fd5d0fad0f9e56cc325ddc3e67d1665a', '2017-12-29 15:16:21', '2017-12-29 15:11:21', '2017-12-29 15:11:21', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2976', '7', '2', '90d0cc8844a823290b8ef76fcd506a39', '2017-12-29 15:35:20', '2017-12-29 15:30:20', '2017-12-29 15:30:20', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2977', '7', '2', '1b23ea0a603a1c0a4570f158948281de', '2017-12-29 15:35:46', '2017-12-29 15:30:46', '2017-12-29 15:30:46', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2978', '7', '2', '44e9d21d7e3439fa6edb204fa21f39e1', '2017-12-29 15:36:01', '2017-12-29 15:31:01', '2017-12-29 15:31:01', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('2983', '7', '2', 'b1fe80a677577f2ff94780ff0801066a', '2017-12-29 16:11:52', '2017-12-29 16:06:52', '2017-12-29 16:06:52', null, '测试账号', '测试账号', '58.100.142.51');
INSERT INTO `tb_ws_token` VALUES ('3070', '7', '2', '1e793fe657593cb57df445bf7e49ed56', '2018-01-05 13:43:03', '2018-01-05 13:38:03', '2018-01-05 13:38:03', null, '测试账号', '测试账号', '183.157.160.194');
