/*

SQL

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组表';

-- ----------------------------
-- Records of tb_admin_group
-- ----------------------------
INSERT INTO `tb_admin_group` VALUES ('1', 'admin', 'admin', '0', '2017-07-04 17:23:42', '0000-00-00 00:00:00', '2017-06-28 10:55:07', '0000-00-00 00:00:00', '', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group` VALUES ('5', '测试', '22233', '0', '2017-07-01 23:24:55', '0000-00-00 00:00:00', '2017-07-01 23:18:33', '2017-07-01 23:24:55', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_group` VALUES ('6', 'test', '111', '0', '2017-07-01 23:25:12', '0000-00-00 00:00:00', '2017-07-01 23:25:12', '0000-00-00 00:00:00', 'gust', 'gust', '127.0.0.1', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COMMENT='后台分组权限关系表';

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of tb_admin_member
-- ----------------------------
INSERT INTO `tb_admin_member` VALUES ('1', 'admin', null, '1', null, '0', null, null, null, null, '$2y$10$xtn/IRD/AWRYs1/Veoy.yuNyW3GbI.r5bL2RVT9TDGRdvjoQ6.Ufu', '0', '', 'admin@jjj.com', '0', '0', '219', null, '2017-07-05 14:38:08', '127.0.0.1', '2017-07-05 01:00:49', '220.115.236.250', '0', '1', '0', '2017-07-05 14:38:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member` VALUES ('2', '哈哈', null, '1', null, '0', null, null, null, null, null, '0', '', null, '0', '0', '1', null, null, null, null, null, '0', '1', '0', '2017-06-30 18:03:31', '0000-00-00 00:00:00', '2017-06-28 10:55:07', '2017-06-30 18:03:31', '', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member` VALUES ('3', 'test2', null, '1', null, '0', null, null, null, null, null, '0', '', null, '0', '0', '1', null, null, null, null, null, '0', '1', '0', '2017-07-04 17:03:23', '0000-00-00 00:00:00', '2017-06-28 10:59:39', '2017-07-04 17:03:23', '', '', null, '0');
INSERT INTO `tb_admin_member` VALUES ('4', 'asdasd', null, '1', null, '0', null, null, null, null, null, '0', '', '11@112222.com', '0', '0', '1', null, null, null, null, null, '0', '1', '0', '2017-07-04 17:03:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-04 17:03:18', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member` VALUES ('6', 'asd阿萨德', null, '1', null, '0', null, null, null, null, '$2y$10$sxCe8645hhrMHb9d1wEXPux43wJZQs68mmHlIIJr3xHxIaYeBD3PS', '0', '123', 'cccccccc@33.com', '0', '0', '1', null, null, null, null, null, '0', '1', '0', '2017-07-04 17:03:12', '0000-00-00 00:00:00', '2017-07-01 22:20:24', '2017-07-04 17:03:12', 'gust', 'gust', '127.0.0.1', '0');
INSERT INTO `tb_admin_member` VALUES ('7', '测试账号', null, '1', null, '0', null, null, null, null, '$2y$10$4HoqxdcEx0F9PffYOEIso.nlDpqh5SHeLPn/Z.PHRm601N7PRXq..', '0', '', 'test@tkc8.com', '0', '0', '55', null, '2017-07-06 08:45:03', '221.238.11.98', '2017-07-05 22:31:36', '220.115.236.250', '0', '1', '0', '2017-07-06 08:45:04', '0000-00-00 00:00:00', '2017-07-04 17:03:00', '0000-00-00 00:00:00', 'gust', 'gust', '221.238.11.98', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='后台用户分组关系表';

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
