/*
 Navicat MySQL Data Transfer

 Source Server         : 本机
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : schoolcms_2.0

 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 12/24/2016 23:42:07 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sc_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin`;
CREATE TABLE `sc_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `username` char(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `login_pwd` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `login_salt` char(6) NOT NULL DEFAULT '' COMMENT '登录密码配合加密字符串',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `login_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属角色组',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
--  Records of `sc_admin`
-- ----------------------------
BEGIN;
INSERT INTO `sc_admin` VALUES ('1', 'admin', '8af65239c040c66d58296ddf12fc7537', '857676', '17091959688', '2', '43', '1482592500', '1', '1481350313', '2016-12-24 23:15:00'), ('8', 'gongfuxiang', 'e028c185f85bdef63089250b3fceefa0', '494119', '', '2', '6', '1482592534', '2', '1481727557', '2016-12-24 23:15:34'), ('9', 'devil', '81d04f57c20e7c17695e158690d516c5', '258364', '', '2', '0', '0', '2', '1482592520', '2016-12-24 23:15:20');
COMMIT;

-- ----------------------------
--  Table structure for `sc_power`
-- ----------------------------
DROP TABLE IF EXISTS `sc_power`;
CREATE TABLE `sc_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限父级id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '权限名称',
  `control` char(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='权限';

-- ----------------------------
--  Records of `sc_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_power` VALUES ('1', '0', '权限控制', 'Power', 'Index', '1', '1', '1481612301'), ('4', '1', '角色管理', 'Power', 'Role', '11', '1', '1481639037'), ('8', '0', '商品管理', 'aaa', 'fff', '2', '1', '1481697671'), ('10', '8', '规格管理', 'fff', 'wwww', '0', '1', '1481727987'), ('11', '8', '图片管理', 'dfs', 'sdf', '0', '1', '1481728003'), ('12', '8', '属性管理', 'sdf', 'dffff', '20', '1', '1481728021'), ('13', '1', '权限分配', 'Power', 'Index', '21', '1', '1482156143'), ('15', '1', '权限添加/编辑', 'Power', 'PowerSave', '22', '0', '1482243750'), ('16', '1', '权限删除', 'Power', 'PowerDelete', '23', '0', '1482243797'), ('17', '1', '角色组添加/编辑页面', 'Power', 'RoleSaveInfo', '12', '0', '1482243855'), ('18', '1', '角色组添加/编辑', 'Power', 'RoleSave', '13', '0', '1482243888'), ('19', '1', '管理员添加/编辑页面', 'Admin', 'SaveInfo', '2', '0', '1482244637'), ('20', '1', '管理员添加/编辑', 'Admin', 'Save', '3', '0', '1482244666'), ('21', '1', '管理员删除', 'Admin', 'Delete', '4', '0', '1482244688'), ('22', '1', '管理员列表', 'Admin', 'Index', '1', '1', '1482568868'), ('23', '1', '角色删除', 'Power', 'RoleDelete', '14', '0', '1482569155');
COMMIT;

-- ----------------------------
--  Table structure for `sc_role`
-- ----------------------------
DROP TABLE IF EXISTS `sc_role`;
CREATE TABLE `sc_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色组id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='角色组';

-- ----------------------------
--  Records of `sc_role`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role` VALUES ('1', '系统管理员', '1', '111', '2016-12-18 15:54:00'), ('2', '管理员', '1', '0', '2016-12-18 15:54:31'), ('3', '运营总监', '1', '0', '2016-12-17 21:06:08'), ('4', '普通客服', '1', '0', '2016-12-17 21:06:08'), ('5', '新媒体专营', '0', '0', '2016-12-17 21:06:08'), ('6', '测试角色', '0', '1482049270', '2016-12-18 16:21:10'), ('9', '发广告', '1', '1482049321', '2016-12-18 16:22:01');
COMMIT;

-- ----------------------------
--  Table structure for `sc_role_power`
-- ----------------------------
DROP TABLE IF EXISTS `sc_role_power`;
CREATE TABLE `sc_role_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `power_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 COMMENT='角色与权限管理';

-- ----------------------------
--  Records of `sc_role_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_power` VALUES ('56', '3', '8', '1482048726'), ('57', '3', '10', '1482048726'), ('58', '3', '11', '1482048726'), ('59', '4', '1', '1482048733'), ('60', '4', '4', '1482048733'), ('61', '4', '8', '1482048733'), ('62', '4', '12', '1482048733'), ('63', '6', '1', '1482049270'), ('64', '6', '4', '1482049270'), ('65', '6', '8', '1482049270'), ('66', '6', '10', '1482049270'), ('67', '6', '12', '1482049270'), ('72', '9', '1', '1482049321'), ('73', '9', '4', '1482049321'), ('80', '5', '8', '1482050768'), ('81', '5', '10', '1482050768'), ('160', '1', '1', '1482569176'), ('161', '1', '22', '1482569176'), ('162', '1', '19', '1482569176'), ('163', '1', '20', '1482569176'), ('164', '1', '21', '1482569176'), ('165', '1', '4', '1482569176'), ('166', '1', '17', '1482569176'), ('167', '1', '18', '1482569176'), ('168', '1', '23', '1482569176'), ('169', '1', '13', '1482569176'), ('170', '1', '15', '1482569176'), ('171', '1', '16', '1482569176'), ('172', '1', '8', '1482569176'), ('173', '1', '10', '1482569176'), ('174', '1', '11', '1482569176'), ('175', '1', '12', '1482569176'), ('176', '2', '1', '1482585760'), ('177', '2', '22', '1482585760'), ('178', '2', '4', '1482585760'), ('179', '2', '13', '1482585760'), ('180', '2', '8', '1482585760'), ('181', '2', '10', '1482585760'), ('182', '2', '11', '1482585760'), ('183', '2', '12', '1482585760');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
