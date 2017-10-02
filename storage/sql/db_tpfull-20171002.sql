/*
Navicat MySQL Data Transfer

Source Server         : 123.206.190.125
Source Server Version : 50548
Source Host           : 123.206.190.125:3306
Source Database       : db_tpfull

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2017-10-02 10:07:41
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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';

-- ----------------------------
-- Records of tb_admin_auth
-- ----------------------------
INSERT INTO `tb_admin_auth` VALUES ('1', '一般权限', '', '', null, null, '1', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('2', '个人信息', '', 'auth', 'info', '', '1', '1', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('3', '修改密码', '', 'auth', 'resetPwdByOld', '', '1', '1', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('4', '用户管理（后台）', '', '', '', '', '1', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('5', '查看用户列表', '', 'admin', 'getMemberList', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('6', '编辑用户', null, 'admin', 'editMember', '', '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('7', '删除用户', null, 'admin', 'deleteMember', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('8', '查看分组列表', null, 'admin', 'getGroupList', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('9', '编辑分组', null, 'admin', 'editGroup', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('10', '删除分组', null, 'admin', 'deleteGroup', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('11', '查看权限列表', null, 'admin', 'getAuthList', null, '1', '4', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('12', '定时任务', null, '', '', null, '1', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('13', '查看定时任务进程状态', null, 'crontab', 'status', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('14', '开始定时任务进程', null, 'crontab', 'start', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('15', '停止定时任务进程', null, 'crontab', 'stop', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('16', '编辑定时任务', null, 'crontab', 'editTask', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('17', '设置指定定时任务状态', null, 'crontab', 'changeTaskStatus', '', '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('18', '获取指定定时任务', null, 'crontab', 'getIndexTask', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('19', '删除指定定时任务', null, 'crontab', 'removeTask', '', '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('20', '获取定时任务列表', null, 'crontab', 'listTask', null, '1', '12', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('23', '活动管理', null, '', null, null, '1', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_auth` VALUES ('24', '查看活动列表', null, 'shake', 'getActivityList', null, '1', '23', '2', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');

-- ----------------------------
-- Table structure for tb_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_group`;
CREATE TABLE `tb_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组id',
  `name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '分组描述',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组表';

-- ----------------------------
-- Records of tb_admin_group
-- ----------------------------
INSERT INTO `tb_admin_group` VALUES ('1', 'admin', 'admin', '0', '2017-07-04 17:23:42', '0000-00-00 00:00:00', '2017-06-28 10:55:07', '0000-00-00 00:00:00', '', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group` VALUES ('5', '测试', '22233', '0', '2017-07-01 23:24:55', '0000-00-00 00:00:00', '2017-07-01 23:18:33', '2017-07-01 23:24:55', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group` VALUES ('6', 'test', '111', '0', '2017-07-01 23:25:12', '0000-00-00 00:00:00', '2017-07-01 23:25:12', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group` VALUES ('7', '查看活动', '查看活动权限', '0', '2017-08-22 09:43:59', '0000-00-00 00:00:00', '2017-08-22 09:43:59', '0000-00-00 00:00:00', 'admin', 'admin', '221.238.11.98', '0');

-- ----------------------------
-- Table structure for tb_admin_group_auth
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_group_auth`;
CREATE TABLE `tb_admin_group_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为冻结',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组权限关系表';

-- ----------------------------
-- Records of tb_admin_group_auth
-- ----------------------------
INSERT INTO `tb_admin_group_auth` VALUES ('1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_group_auth` VALUES ('7', '5', '18', '1', '0', '2017-07-01 23:18:57', '0000-00-00 00:00:00', '2017-07-01 23:18:33', '2017-07-01 23:18:57', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('8', '5', '19', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:34', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('9', '5', '20', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:34', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('10', '5', '21', '1', '0', '2017-07-01 23:18:57', '0000-00-00 00:00:00', '2017-07-01 23:18:34', '2017-07-01 23:18:57', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('11', '5', '22', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:34', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('12', '5', '19', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:57', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('13', '5', '20', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:57', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('14', '5', '22', '1', '0', '2017-07-01 23:20:32', '0000-00-00 00:00:00', '2017-07-01 23:18:57', '2017-07-01 23:20:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('15', '6', '5', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:12', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('16', '6', '6', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:12', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('17', '6', '7', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('18', '6', '8', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('19', '6', '9', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('20', '6', '10', '1', '0', '2017-07-01 23:25:29', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '2017-07-01 23:25:29', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('21', '6', '11', '1', '0', '2017-07-01 23:25:13', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('22', '6', '12', '1', '0', '2017-07-04 17:23:26', '0000-00-00 00:00:00', '2017-07-01 23:25:13', '2017-07-04 17:23:26', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('23', '6', '11', '1', '0', '2017-07-01 23:25:28', '0000-00-00 00:00:00', '2017-07-01 23:25:28', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('24', '6', '12', '1', '0', '2017-07-04 17:23:26', '0000-00-00 00:00:00', '2017-07-01 23:25:29', '2017-07-04 17:23:26', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('25', '6', '1', '1', '0', '2017-07-04 17:27:45', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '2017-07-04 17:27:45', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('26', '6', '2', '1', '0', '2017-07-04 17:23:25', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('27', '6', '3', '1', '0', '2017-07-04 17:27:45', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '2017-07-04 17:27:45', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('28', '6', '5', '1', '0', '2017-07-04 17:23:25', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('29', '6', '8', '1', '0', '2017-07-04 17:23:25', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('30', '6', '11', '1', '0', '2017-07-04 17:23:25', '0000-00-00 00:00:00', '2017-07-04 17:23:25', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('31', '6', '13', '1', '0', '2017-07-04 17:23:26', '0000-00-00 00:00:00', '2017-07-04 17:23:26', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('32', '6', '18', '1', '0', '2017-07-04 17:23:26', '0000-00-00 00:00:00', '2017-07-04 17:23:26', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('33', '6', '20', '1', '0', '2017-07-04 17:23:26', '0000-00-00 00:00:00', '2017-07-04 17:23:26', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('34', '1', '2', '1', '0', '2017-07-04 17:23:42', '0000-00-00 00:00:00', '2017-07-04 17:23:42', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('35', '1', '3', '1', '0', '2017-07-04 17:23:42', '0000-00-00 00:00:00', '2017-07-04 17:23:42', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('36', '1', '4', '1', '0', '2017-07-04 17:23:42', '0000-00-00 00:00:00', '2017-07-04 17:23:42', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('37', '1', '5', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('38', '1', '6', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('39', '1', '7', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('40', '1', '8', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('41', '1', '9', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('42', '1', '10', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('43', '1', '11', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('44', '1', '12', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('45', '1', '13', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('46', '1', '14', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('47', '1', '15', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('48', '1', '16', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('49', '1', '17', '1', '0', '2017-07-04 17:23:43', '0000-00-00 00:00:00', '2017-07-04 17:23:43', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('50', '1', '18', '1', '0', '2017-07-04 17:23:44', '0000-00-00 00:00:00', '2017-07-04 17:23:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('51', '1', '19', '1', '0', '2017-07-04 17:23:44', '0000-00-00 00:00:00', '2017-07-04 17:23:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('52', '1', '20', '1', '0', '2017-07-04 17:23:44', '0000-00-00 00:00:00', '2017-07-04 17:23:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('53', '6', '2', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('54', '6', '5', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('55', '6', '8', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('56', '6', '11', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('57', '6', '13', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('58', '6', '18', '1', '0', '2017-07-04 17:27:44', '0000-00-00 00:00:00', '2017-07-04 17:27:44', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('59', '6', '20', '1', '0', '2017-07-04 17:27:45', '0000-00-00 00:00:00', '2017-07-04 17:27:45', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('60', '7', '23', '1', '0', '2017-08-22 09:43:59', '0000-00-00 00:00:00', '2017-08-22 09:43:59', '0000-00-00 00:00:00', 'admin', 'admin', '221.238.11.98', '0');
INSERT INTO `tb_admin_group_auth` VALUES ('61', '7', '24', '1', '0', '2017-08-22 09:43:59', '0000-00-00 00:00:00', '2017-08-22 09:43:59', '0000-00-00 00:00:00', 'admin', 'admin', '221.238.11.98', '0');

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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`),
  KEY `ix_email` (`email`),
  KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of tb_admin_member
-- ----------------------------
INSERT INTO `tb_admin_member` VALUES ('1', 'admin', null, '1', null, '0', null, null, null, null, '$2y$10$xtn/IRD/AWRYs1/Veoy.yuNyW3GbI.r5bL2RVT9TDGRdvjoQ6.Ufu', '0', '', 'admin@tkc8.com', '0', '0', '230', null, '2017-09-18 12:02:54', '60.29.127.158', '2017-09-20 17:42:16', '60.29.127.158', '0', '1', '0', '2017-09-20 17:42:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '测试账号', '60.29.127.158', '0');
INSERT INTO `tb_admin_member` VALUES ('7', '测试账号', null, '1', null, '0', null, null, null, null, '$2y$10$4HoqxdcEx0F9PffYOEIso.nlDpqh5SHeLPn/Z.PHRm601N7PRXq..', '0', '', 'test@tkc8.com', '0', '0', '2526', null, '2017-09-21 13:20:22', '221.238.11.98', '2017-09-21 13:20:22', '221.238.11.98', '0', '1', '0', '2017-10-02 09:40:15', '0000-00-00 00:00:00', '2017-07-04 17:03:00', '0000-00-00 00:00:00', 'gust', '测试账号', '221.238.11.98', '0');
INSERT INTO `tb_admin_member` VALUES ('8', '测试帐号-活动2', null, '1', null, '0', null, null, null, null, '$2y$10$9TbIFHeSYwU6HYSOHicNEeSVTEUeSp3JlVAN0.gn9xSnoR8HVwqvu', '0', '', 'test2@tkc8.com', '0', '0', '101', null, '2017-09-20 17:43:38', '60.29.127.158', '2017-09-20 17:41:37', '60.29.127.158', '0', '1', '0', '2017-09-20 17:43:38', '0000-00-00 00:00:00', '2017-08-22 09:43:31', '0000-00-00 00:00:00', 'admin', 'gust', '60.29.127.158', '0');

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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='后台用户分组关系表';

-- ----------------------------
-- Records of tb_admin_member_group
-- ----------------------------
INSERT INTO `tb_admin_member_group` VALUES ('1', '1', '1', '0', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');
INSERT INTO `tb_admin_member_group` VALUES ('2', '4', '1', '0', '1', '0', '2017-07-01 21:15:32', '0000-00-00 00:00:00', '2017-07-01 21:15:21', '2017-07-01 21:15:32', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('3', '4', '1', '0', '1', '0', '2017-07-01 21:16:34', '0000-00-00 00:00:00', '2017-07-01 21:16:11', '2017-07-01 21:16:34', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('4', '4', '1', '0', '1', '0', '2017-07-01 22:16:34', '0000-00-00 00:00:00', '2017-07-01 22:16:25', '2017-07-01 22:16:34', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('5', '4', '1', '0', '1', '0', '2017-07-01 22:17:53', '0000-00-00 00:00:00', '2017-07-01 22:17:53', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('6', '6', '1', '0', '1', '0', '2017-07-01 23:26:06', '0000-00-00 00:00:00', '2017-07-01 23:25:57', '2017-07-01 23:26:06', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('7', '6', '6', '0', '1', '0', '2017-07-01 23:25:57', '0000-00-00 00:00:00', '2017-07-01 23:25:57', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('8', '7', '6', '0', '1', '0', '2017-07-04 17:23:57', '0000-00-00 00:00:00', '2017-07-04 17:23:57', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member_group` VALUES ('9', '8', '6', '0', '1', '0', '2017-08-22 09:43:31', '0000-00-00 00:00:00', '2017-08-22 09:43:31', '0000-00-00 00:00:00', 'admin', 'admin', '221.238.11.98', '0');
INSERT INTO `tb_admin_member_group` VALUES ('10', '8', '7', '0', '1', '0', '2017-08-22 09:45:03', '0000-00-00 00:00:00', '2017-08-22 09:45:03', '0000-00-00 00:00:00', 'admin', 'admin', '221.238.11.98', '0');

-- ----------------------------
-- Table structure for tb_goods
-- ----------------------------
DROP TABLE IF EXISTS `tb_goods`;
CREATE TABLE `tb_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `common_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品公共表id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称（+规格名称）',
  `jingle` varchar(150) NOT NULL DEFAULT '' COMMENT '商品广告词',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `store_name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `gc_id_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `gc_id_2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `gc_id_3` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '商品价格',
  `market_price` int(11) NOT NULL DEFAULT '0' COMMENT '市场价',
  `sn` varchar(50) NOT NULL DEFAULT '0' COMMENT '商家编号',
  `click_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数量',
  `sale_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collect_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `spec` text NOT NULL COMMENT '商品规格序列化',
  `storage` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '商品主图',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，2违规（禁售）',
  `verify_state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '商品审核 1通过，0未通过，10审核中',
  `goods_freight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费 0为免运费',
  `evaluation_good_star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluation_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品表';

-- ----------------------------
-- Records of tb_goods
-- ----------------------------

-- ----------------------------
-- Table structure for tb_order
-- ----------------------------
DROP TABLE IF EXISTS `tb_order`;
CREATE TABLE `tb_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sn` varchar(50) NOT NULL COMMENT '订单编号',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单类型，0 普通订单 1 父订单 2 子订单',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父订单Id',
  `deliver_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发货时间',
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '付款时间',
  `finnish_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单完成时间',
  `shipping_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '配送时间',
  `evaluation_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '评价时间',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卖家店铺id',
  `store_name` varchar(50) NOT NULL DEFAULT '' COMMENT '卖家店铺名称',
  `buyer_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '买家id',
  `buyer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '买家姓名',
  `buyer_email` varchar(80) NOT NULL DEFAULT '' COMMENT '买家电子邮箱',
  `buyer_type` tinyint(2) DEFAULT '1' COMMENT '用户类型，枚举|1-用户-USER|2-微信用户-USER_WX',
  `order_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总价格',
  `goods_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品总价格',
  `shipping_fee` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '运费',
  `order_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单状态，枚举|0-已取消-CANCEL|1-创建成功-CREATED|2-已付款-PAYED|3-已发货-DELAYED|40-已收货-DONE',
  `evaluation_state` tinyint(4) DEFAULT '0' COMMENT '评价状态，枚举|0-未评价-no|1-已评价-YES|2-已过期未评价-OVER',
  `refund_state` tinyint(1) unsigned DEFAULT '0' COMMENT '退款状态，枚举|0-无退款-NONE|1-部分退款-PART|2-全部-ALL',
  `store_del_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商家删除状态, 枚举|0-未删除-NO|1-回收站-REC|2-永久删除-DEL',
  `buyer_del_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '买家删除状态, 枚举|0-未删除-NO|1-回收站-REC|2-永久删除-DEL',
  `is_lock` tinyint(1) unsigned DEFAULT '0' COMMENT '锁定状态，枚举|0-正常-NO|1-锁定-YES',
  `shipping_express_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '配送公司ID',
  `deliver_explain` varchar(500) DEFAULT '' COMMENT '发货备注',
  `order_message` varchar(300) DEFAULT NULL COMMENT '订单留言',
  `invoice_info` varchar(500) DEFAULT '' COMMENT '发票信息',
  `store_address_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '发货地址ID',
  `store_address` varchar(500) DEFAULT '' COMMENT '发货地址',
  `reciver_name` varchar(50) NOT NULL COMMENT '收货人姓名',
  `reciver_phone` varchar(50) NOT NULL COMMENT '收货人电话',
  `reciver_province_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收货人省级ID',
  `reciver_city_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收货人市级ID',
  `reciver_area_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收货人区级ID',
  `reciver_info` varchar(500) NOT NULL COMMENT '收货人其它信息',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单表';

-- ----------------------------
-- Records of tb_order
-- ----------------------------

-- ----------------------------
-- Table structure for tb_shake_activity
-- ----------------------------
DROP TABLE IF EXISTS `tb_shake_activity`;
CREATE TABLE `tb_shake_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `merchant_id` int(11) unsigned DEFAULT '1' COMMENT '所属商家ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '活动类型,枚举|1-微摇奖-YAO|2-微夺宝-DUO',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '名称',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属省',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属城市',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `business_name` char(60) NOT NULL DEFAULT '' COMMENT '举办商家',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态，1:未开始,2:活动中,3:已结束',
  `business_logo` char(200) NOT NULL DEFAULT '' COMMENT '商家LOGO',
  `prize_address` char(100) NOT NULL DEFAULT '' COMMENT '兑奖地址',
  `background_img` char(200) NOT NULL DEFAULT '' COMMENT '大屏背景图片',
  `wechat_qrcode` char(200) NOT NULL DEFAULT '' COMMENT '手机端公众号二维码',
  `wechat_qrcode_text` char(100) NOT NULL DEFAULT '' COMMENT '手机端公众号引导文案',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='摇一摇活动表';

-- ----------------------------
-- Records of tb_shake_activity
-- ----------------------------
INSERT INTO `tb_shake_activity` VALUES ('1', '1', '1', '龙湾露营亲子嘉年华', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '', '', '', '', '', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', null, '0');

-- ----------------------------
-- Table structure for tb_shake_item
-- ----------------------------
DROP TABLE IF EXISTS `tb_shake_item`;
CREATE TABLE `tb_shake_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '活动轮次ID',
  `activity_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应活动表ID',
  `item_index` int(11) NOT NULL DEFAULT '0' COMMENT '轮次数',
  `shake_limit` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '摇一摇次数(达到次数,活动结束)',
  `win_limit` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '中奖人数限制',
  `part_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `subscribe_count` int(11) NOT NULL DEFAULT '0' COMMENT '关注公众号人数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,枚举|1-未开始-WAIT|2-进行中-DOING|3-已结束-DOEN',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间.用来标识具活动3分钟未达到限制次数自动结束游戏',
  `time_slot` int(11) NOT NULL DEFAULT '1' COMMENT '时段',
  `time_slot_sign` int(11) NOT NULL DEFAULT '1' COMMENT '时段标记(页面点击结束时+1)',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`),
  KEY `idx_activity_id` (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='活动轮次表';

-- ----------------------------
-- Records of tb_shake_item
-- ----------------------------
INSERT INTO `tb_shake_item` VALUES ('6', '1', '1', '30', '3', '0', '0', '3', '0000-00-00 00:00:00', '1', '1', '2017-08-20 15:28:34', '0000-00-00 00:00:00', '2017-08-20 15:28:34', '0000-00-00 00:00:00', '测试账号', '测试账号', '220.115.236.46', '0');
INSERT INTO `tb_shake_item` VALUES ('7', '1', '2', '30', '1', '0', '0', '1', '0000-00-00 00:00:00', '1', '1', '2017-09-18 11:41:52', '0000-00-00 00:00:00', '2017-08-20 15:34:29', '0000-00-00 00:00:00', '测试账号', '测试账号', '221.238.11.98', '0');

-- ----------------------------
-- Table structure for tb_shake_record
-- ----------------------------
DROP TABLE IF EXISTS `tb_shake_record`;
CREATE TABLE `tb_shake_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '摇一摇参与ID',
  `activity_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动ID',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '摇一摇ID',
  `item_index` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参与轮次',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `nickname` char(64) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `avatar` char(150) NOT NULL DEFAULT '' COMMENT '头像',
  `is_subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否关注公众号.0否,1是',
  `shake_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '摇一摇次数',
  `user_rank` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户名次',
  `ticket` char(50) NOT NULL DEFAULT '' COMMENT '票根',
  `ticket_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,枚举|0-未获取-NONE|1-未使用-UNUSED|2-已使用-DONE',
  `ticket_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '兑奖时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`),
  KEY `idx_shake_count` (`shake_count`),
  KEY `idx_item_id_user_id` (`item_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COMMENT='活动参与记录表';

-- ----------------------------
-- Records of tb_shake_record
-- ----------------------------
INSERT INTO `tb_shake_record` VALUES ('30', '1', '7', '2', '1', '大弹簧', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '50', '1', '', '1', '2017-08-21 18:01:27', '2017-09-18 11:40:07', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('31', '1', '7', '2', '3', 'lina', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXsuI2yrt7SHKspnXkdkZzjqQGnibcw1FyJjfI4qBxYuqiaHjDJf8mibibM4RViaicd2TwNG7wcAdfwf6Bg/0', '0', '30', '1', '', '1', '2017-08-21 18:01:27', '2017-09-18 11:42:14', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', 'lina', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('32', '1', '7', '2', '4', '雨晨似墨', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXvY2If59RUicnSO3beSSqdtPzLk92dpHXF8avTqO1otQTyrZ5qoJRBJ3IllqBJuK9yMTRmmjIkicTV/0', '0', '30', '1', '', '1', '2017-08-21 18:01:27', '2017-09-18 11:46:53', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '雨晨似墨', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('33', '1', '7', '2', '11', 'NAME11', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '3', '12', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('34', '1', '7', '2', '13', 'NAME13', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '1', '15', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('35', '1', '7', '2', '8', 'NAME8', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '1', '14', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('36', '1', '7', '2', '12', 'NAME12', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '5', '9', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('37', '1', '7', '2', '15', 'NAME15', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '5', '10', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('38', '1', '7', '2', '7', 'NAME7', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '5', '8', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('39', '1', '7', '2', '2', 'Fay', 'http://wx.qlogo.cn/mmopen/IHUqBJMlBwxsItgE0WyiaHVgCxC148vyuIXuiaM3LIe3OxGSAxVnUTib9jqcQhNhVBQrIh1iaqpZBUMQr3K6e2NHiaNGgtDw8tGWJ/0', '0', '100', '1', '', '1', '2017-08-21 18:01:27', '2017-08-23 23:35:36', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', 'Fay', '220.115.236.21', '0');
INSERT INTO `tb_shake_record` VALUES ('40', '1', '7', '2', '5', 'NAME5', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '5', '7', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('41', '1', '7', '2', '6', 'NAME6', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '8', '2', '', '1', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('42', '1', '7', '2', '10', 'NAME10', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '7', '4', '', '1', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('43', '1', '7', '2', '14', 'NAME14', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '6', '6', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');
INSERT INTO `tb_shake_record` VALUES ('44', '1', '7', '2', '9', 'NAME9', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '4', '11', '', '0', '2017-08-21 18:01:27', '2017-08-21 19:14:52', '0000-00-00 00:00:00', '2017-08-21 18:01:27', '0000-00-00 00:00:00', '大弹簧', '大弹簧', '221.238.11.98', '0');

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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`),
  KEY `ix_email` (`email`),
  KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='前台用户表';

-- ----------------------------
-- Records of tb_user_member
-- ----------------------------
INSERT INTO `tb_user_member` VALUES ('1', 'user', null, '1', null, '0', null, null, null, null, '$2y$10$4HoqxdcEx0F9PffYOEIso.nlDpqh5SHeLPn/Z.PHRm601N7PRXq..', '0', '', 'user@tkc8.com', '0', '0', '39', null, '2017-09-27 18:48:22', '117.136.38.66', '2017-09-26 18:04:17', '122.227.25.58', '0', '1', '0', '2017-09-27 18:48:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'gust', '117.136.38.66', '0');
INSERT INTO `tb_user_member` VALUES ('8', '自行车', null, '1', null, '0', null, null, null, null, null, '0', '', null, '0', '0', '1', null, '2017-08-31 17:21:23', '221.238.11.98', null, null, '0', '1', '0', '2017-08-31 17:21:23', '0000-00-00 00:00:00', '2017-08-31 17:21:23', '0000-00-00 00:00:00', 'gust', 'gust', '221.238.11.98', '0');

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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人id',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人id',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
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
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COMMENT='用户微信信息表';

-- ----------------------------
-- Records of tb_user_wx
-- ----------------------------
INSERT INTO `tb_user_wx` VALUES ('1', 'otUf91XGREEsyWhYBLoS5_rOOtKU', '大弹簧', 'http://wx.qlogo.cn/mmopen/DQ3EM1IIKIPIcGIaf0N8GmcPtl9VebJUlPzMPZGRBqlbaIgSvEIjefZvt7icpcOMbCmuaM0NHD9KxDP6hib52kFQ/0', '0', '0', '2017-08-14 15:15:30', '0000-00-00 00:00:00', '2017-08-14 15:15:30', '0000-00-00 00:00:00', 'gust', 'gust', '221.238.11.98', '0');
INSERT INTO `tb_user_wx` VALUES ('2', 'otUf91eXE58FXeWLC8ycZ84TT_Eo', 'Fay', 'http://wx.qlogo.cn/mmopen/IHUqBJMlBwxsItgE0WyiaHVgCxC148vyuIXuiaM3LIe3OxGSAxVnUTib9jqcQhNhVBQrIh1iaqpZBUMQr3K6e2NHiaNGgtDw8tGWJ/0', '0', '0', '2017-08-21 21:10:07', '0000-00-00 00:00:00', '2017-08-21 21:10:07', '0000-00-00 00:00:00', 'gust', 'gust', '220.115.236.21', '0');
INSERT INTO `tb_user_wx` VALUES ('3', 'otUf91b8nxKZB0fbsB6u5smPwXik', 'lina', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXsuI2yrt7SHKspnXkdkZzjqQGnibcw1FyJjfI4qBxYuqiaHjDJf8mibibM4RViaicd2TwNG7wcAdfwf6Bg/0', '0', '0', '2017-08-22 11:40:04', '0000-00-00 00:00:00', '2017-08-22 11:40:04', '0000-00-00 00:00:00', 'gust', 'gust', '60.29.127.158', '0');
INSERT INTO `tb_user_wx` VALUES ('4', 'otUf91SsG1QbvrEoPRjE94Eg4ZPc', '雨晨似墨', 'http://wx.qlogo.cn/mmopen/5naj4jqUIquPvicIRvGESXvY2If59RUicnSO3beSSqdtPzLk92dpHXF8avTqO1otQTyrZ5qoJRBJ3IllqBJuK9yMTRmmjIkicTV/0', '0', '0', '2017-08-22 11:41:24', '0000-00-00 00:00:00', '2017-08-22 11:41:24', '0000-00-00 00:00:00', 'gust', 'gust', '60.29.127.158', '0');
INSERT INTO `tb_user_wx` VALUES ('8', '-', 'kang', '', '0', '0', '2017-09-01 15:31:59', '0000-00-00 00:00:00', '2017-09-01 15:31:59', '0000-00-00 00:00:00', 'gust', 'gust', '120.239.14.182', '0');
INSERT INTO `tb_user_wx` VALUES ('9', '-', 'passenger', '', '0', '0', '2017-09-04 09:17:36', '0000-00-00 00:00:00', '2017-09-04 09:17:36', '0000-00-00 00:00:00', 'gust', 'gust', '101.226.102.80', '0');
INSERT INTO `tb_user_wx` VALUES ('17', 'otUf91aHDNS1nbg0JcDogJh9ckEg', '?我不该拥有这么美的梦??', 'http://wx.qlogo.cn/mmopen/AbruuZ3ILCl3577Diaev5ZNa3eOdLOnu8MENibolJeMGiaQDyyQGMkt673TRG1x4V070fH3XwJGhl2ia7OwkYicEufQ/0', '0', '0', '2017-09-06 18:36:10', '0000-00-00 00:00:00', '2017-09-06 18:36:10', '0000-00-00 00:00:00', 'gust', 'gust', '118.186.6.218', '0');
INSERT INTO `tb_user_wx` VALUES ('18', 'otUf91Z2w0kZlAlpAPZPjSZJp-Sw', '微商小时代', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBSjZXE6hlH7Ls1XglvQgvL8K3tY6yUDLfGcxKWICczmPyntCcdwibyEBKV5l4MQGQo6UYsdcwx5iaQ/0', '0', '0', '2017-09-06 19:05:25', '0000-00-00 00:00:00', '2017-09-06 19:05:25', '0000-00-00 00:00:00', 'gust', 'gust', '118.186.6.218', '0');
INSERT INTO `tb_user_wx` VALUES ('26', '-', 'edfdf', '', '0', '0', '2017-09-08 14:55:11', '0000-00-00 00:00:00', '2017-09-08 14:55:11', '0000-00-00 00:00:00', 'gust', 'gust', '139.189.97.13', '0');
INSERT INTO `tb_user_wx` VALUES ('27', '-', 'CC', '', '0', '0', '2017-09-08 16:32:02', '0000-00-00 00:00:00', '2017-09-08 16:32:02', '0000-00-00 00:00:00', 'gust', 'gust', '221.238.11.98', '0');
INSERT INTO `tb_user_wx` VALUES ('30', '-', 'uuu', '', '0', '0', '2017-09-08 18:29:10', '0000-00-00 00:00:00', '2017-09-08 18:29:10', '0000-00-00 00:00:00', 'gust', 'gust', '222.82.81.116', '0');
INSERT INTO `tb_user_wx` VALUES ('31', '-', '123', '', '0', '0', '2017-09-09 13:13:17', '0000-00-00 00:00:00', '2017-09-09 13:13:17', '0000-00-00 00:00:00', 'gust', 'gust', '222.82.95.212', '0');
INSERT INTO `tb_user_wx` VALUES ('32', '-', '皮皮虾', '', '0', '0', '2017-09-10 12:12:20', '0000-00-00 00:00:00', '2017-09-10 12:12:20', '0000-00-00 00:00:00', 'gust', 'gust', '183.39.196.86', '0');
INSERT INTO `tb_user_wx` VALUES ('33', '-', 'mm', '', '0', '0', '2017-09-10 12:25:38', '0000-00-00 00:00:00', '2017-09-10 12:25:38', '0000-00-00 00:00:00', 'gust', 'gust', '183.39.196.86', '0');
INSERT INTO `tb_user_wx` VALUES ('34', '-', '666', '', '0', '0', '2017-09-11 13:34:54', '0000-00-00 00:00:00', '2017-09-11 13:34:54', '0000-00-00 00:00:00', 'gust', 'gust', '115.206.134.92', '0');
INSERT INTO `tb_user_wx` VALUES ('35', '-', '1', '', '0', '0', '2017-09-11 17:44:01', '0000-00-00 00:00:00', '2017-09-11 17:44:01', '0000-00-00 00:00:00', 'gust', 'gust', '223.104.16.55', '0');
INSERT INTO `tb_user_wx` VALUES ('36', '-', 'pulong', '', '0', '0', '2017-09-11 22:29:24', '0000-00-00 00:00:00', '2017-09-11 22:29:24', '0000-00-00 00:00:00', 'gust', 'gust', '125.70.205.109', '0');
INSERT INTO `tb_user_wx` VALUES ('37', '-', 'QQ', '', '0', '0', '2017-09-12 15:40:16', '0000-00-00 00:00:00', '2017-09-12 15:40:16', '0000-00-00 00:00:00', 'gust', 'gust', '60.29.127.158', '0');
INSERT INTO `tb_user_wx` VALUES ('38', '-', '33', '', '0', '0', '2017-09-12 22:35:15', '0000-00-00 00:00:00', '2017-09-12 22:35:15', '0000-00-00 00:00:00', 'gust', 'gust', '61.158.149.216', '0');
INSERT INTO `tb_user_wx` VALUES ('40', '-', '哈哈哈', '', '0', '0', '2017-09-18 23:39:51', '0000-00-00 00:00:00', '2017-09-18 23:39:51', '0000-00-00 00:00:00', 'gust', 'gust', '122.242.65.220', '0');
INSERT INTO `tb_user_wx` VALUES ('41', '-', '红红火火', '', '0', '0', '2017-09-19 13:53:08', '0000-00-00 00:00:00', '2017-09-19 13:53:08', '0000-00-00 00:00:00', 'gust', 'gust', '140.243.34.202', '0');
INSERT INTO `tb_user_wx` VALUES ('42', '-', 'ttt', '', '0', '0', '2017-09-20 11:00:10', '0000-00-00 00:00:00', '2017-09-20 11:00:10', '0000-00-00 00:00:00', 'gust', 'gust', '221.238.11.98', '0');
INSERT INTO `tb_user_wx` VALUES ('43', 'otUf91ZHKCgi1MsmGWOCOga9GKtg', 'yavana', 'http://wx.qlogo.cn/mmopen/5naj4jqUIqsNeT02hjnPn36Dx5qFsfxGCQZXGjXicT1ToxozibnPAs6RX9JHrzneLJH6ZQCKWfHzibAQNgFY7veawWNkShfFGxw/0', '0', '0', '2017-09-20 16:51:49', '0000-00-00 00:00:00', '2017-09-20 16:51:49', '0000-00-00 00:00:00', 'gust', 'gust', '222.209.233.132', '0');
INSERT INTO `tb_user_wx` VALUES ('44', '-', '12312', '', '0', '0', '2017-09-20 17:36:15', '0000-00-00 00:00:00', '2017-09-20 17:36:15', '0000-00-00 00:00:00', 'gust', 'gust', '60.29.127.158', '0');
INSERT INTO `tb_user_wx` VALUES ('45', '-', '哈哈哈', '', '0', '0', '2017-09-20 22:13:30', '0000-00-00 00:00:00', '2017-09-20 22:13:30', '0000-00-00 00:00:00', 'gust', 'gust', '119.85.101.218', '0');
INSERT INTO `tb_user_wx` VALUES ('46', '-', 'rabbit', '', '0', '0', '2017-09-21 14:34:04', '0000-00-00 00:00:00', '2017-09-21 14:34:04', '0000-00-00 00:00:00', 'gust', 'gust', '221.196.56.206', '0');
INSERT INTO `tb_user_wx` VALUES ('47', '-', 'test', '', '0', '0', '2017-09-21 15:58:18', '0000-00-00 00:00:00', '2017-09-21 15:58:18', '0000-00-00 00:00:00', 'gust', 'gust', '113.66.228.180', '0');
INSERT INTO `tb_user_wx` VALUES ('48', '-', '23234', '', '0', '0', '2017-09-26 18:04:39', '0000-00-00 00:00:00', '2017-09-26 18:04:39', '0000-00-00 00:00:00', 'gust', 'gust', '122.227.25.58', '0');
INSERT INTO `tb_user_wx` VALUES ('49', '-', 'npy', '', '0', '0', '2017-10-02 09:35:47', '0000-00-00 00:00:00', '2017-10-02 09:35:47', '0000-00-00 00:00:00', 'gust', 'gust', '115.34.174.49', '0');
INSERT INTO `tb_user_wx` VALUES ('50', '-', 'npy', '', '0', '0', '2017-10-02 09:35:48', '0000-00-00 00:00:00', '2017-10-02 09:35:48', '0000-00-00 00:00:00', 'npy', 'npy', '115.34.174.49', '0');
INSERT INTO `tb_user_wx` VALUES ('51', '-', 'test', '', '0', '0', '2017-10-02 09:36:46', '0000-00-00 00:00:00', '2017-10-02 09:36:46', '0000-00-00 00:00:00', 'gust', 'gust', '123.151.152.214', '0');

-- ----------------------------
-- Table structure for tb_ws_token
-- ----------------------------
DROP TABLE IF EXISTS `tb_ws_token`;
CREATE TABLE `tb_ws_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `member_id` char(50) NOT NULL COMMENT '用户id',
  `member_type` tinyint(2) DEFAULT '1' COMMENT '用户类型，枚举|1-用户-USER|2-管理员-ADMIN',
  `token` varchar(65) DEFAULT '' COMMENT 'TOKEN',
  `available_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '有效截至时间',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '0可用 1不可用',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `audit_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '删除时间',
  `creator` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人信息',
  `updater` varchar(64) NOT NULL DEFAULT '' COMMENT '更新人信息',
  `ip` varchar(16) DEFAULT NULL COMMENT '加入IP',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序字段 0-9权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1980 DEFAULT CHARSET=utf8mb4 COMMENT='websocket登录token表';

-- ----------------------------
-- Records of tb_ws_token
-- ----------------------------
