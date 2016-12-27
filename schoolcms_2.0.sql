/*
 Navicat MySQL Data Transfer

 Source Server         : 本机
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : schoolcms_2.0

 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 12/28/2016 00:01:45 AM
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
INSERT INTO `sc_admin` VALUES ('1', 'admin', 'b825003659280e646565864daaee9ad8', '132343', '17091959688', '2', '48', '1482831975', '1', '1481350313', '2016-12-27 17:46:15'), ('8', 'gongfuxiang', '6912d902300a8598011d437ddb6f0f8b', '732006', '', '2', '18', '1482634427', '2', '1481727557', '2016-12-25 10:53:47'), ('9', 'devil', '81d04f57c20e7c17695e158690d516c5', '258364', '', '2', '0', '0', '2', '1482592520', '2016-12-24 23:15:20');
COMMIT;

-- ----------------------------
--  Table structure for `sc_class`
-- ----------------------------
DROP TABLE IF EXISTS `sc_class`;
CREATE TABLE `sc_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='班级';

-- ----------------------------
--  Records of `sc_class`
-- ----------------------------
BEGIN;
INSERT INTO `sc_class` VALUES ('7', '0', '一年级', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '二年级', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '三年级', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '一班', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '二班', '1', '0', '1482840577', '2016-12-27 20:09:37');
COMMIT;

-- ----------------------------
--  Table structure for `sc_interval`
-- ----------------------------
DROP TABLE IF EXISTS `sc_interval`;
CREATE TABLE `sc_interval` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='时段';

-- ----------------------------
--  Records of `sc_interval`
-- ----------------------------
BEGIN;
INSERT INTO `sc_interval` VALUES ('12', '09:00-09:45', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '10:00-10:45', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '11:00-11:45', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '13:00-13:45', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '14:00-14:45', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '15:00-15:45', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '16:00-16:45', '1', '0', '1482852593', '2016-12-27 23:29:53');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='权限';

-- ----------------------------
--  Records of `sc_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_power` VALUES ('1', '0', '权限控制', 'Power', 'Index', '1', '1', '1481612301'), ('4', '1', '角色管理', 'Power', 'Role', '11', '1', '1481639037'), ('8', '0', '类别管理', 'Routine', 'Index', '5', '1', '1481697671'), ('10', '8', '班级分类', 'Class', 'Index', '2', '1', '1481727987'), ('11', '8', '科目分类', 'Subject', 'Index', '3', '1', '1481728003'), ('12', '8', '学期分类', 'Semester', 'Index', '1', '1', '1481728021'), ('13', '1', '权限分配', 'Power', 'Index', '21', '1', '1482156143'), ('15', '1', '权限添加/编辑', 'Power', 'PowerSave', '22', '0', '1482243750'), ('16', '1', '权限删除', 'Power', 'PowerDelete', '23', '0', '1482243797'), ('17', '1', '角色组添加/编辑页面', 'Power', 'RoleSaveInfo', '12', '0', '1482243855'), ('18', '1', '角色组添加/编辑', 'Power', 'RoleSave', '13', '0', '1482243888'), ('19', '1', '管理员添加/编辑页面', 'Admin', 'SaveInfo', '2', '0', '1482244637'), ('20', '1', '管理员添加/编辑', 'Admin', 'Save', '3', '0', '1482244666'), ('21', '1', '管理员删除', 'Admin', 'Delete', '4', '0', '1482244688'), ('22', '1', '管理员列表', 'Admin', 'Index', '1', '1', '1482568868'), ('23', '1', '角色删除', 'Power', 'RoleDelete', '14', '0', '1482569155'), ('24', '8', '成绩分类', 'Score', 'Index', '4', '1', '1482638641'), ('25', '8', '周分类', 'Week', 'Index', '5', '1', '1482638899'), ('26', '8', '时段分类', 'Interval', 'Index', '6', '1', '1482638982'), ('27', '8', '地区管理', 'Region', 'Index', '7', '1', '1482639024'), ('28', '0', '学生管理', 'Student', 'Index', '2', '1', '1482854151'), ('29', '28', '学生列表', 'Student', 'Index', '1', '1', '1482854186'), ('30', '0', '成绩管理', 'Fraction', 'Index', '3', '1', '1482854384'), ('31', '30', '学生成绩', 'Fraction', 'Index', '1', '1', '1482854429');
COMMIT;

-- ----------------------------
--  Table structure for `sc_region`
-- ----------------------------
DROP TABLE IF EXISTS `sc_region`;
CREATE TABLE `sc_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='地区';

-- ----------------------------
--  Records of `sc_region`
-- ----------------------------
BEGIN;
INSERT INTO `sc_region` VALUES ('7', '0', '谯家镇2', '1', '2', '0', '2016-12-25 14:41:23'), ('8', '7', '印山村2', '1', '0', '0', '2016-12-25 14:41:38'), ('9', '8', '康家坨', '1', '0', '0', '2016-12-25 14:41:54'), ('10', '0', '夹石镇', '0', '1', '0', '2016-12-25 14:42:31'), ('11', '10', '水进湾', '1', '0', '0', '2016-12-25 14:42:53'), ('12', '10', '小垫矮', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '8', '麻池', '1', '0', '0', '2016-12-25 17:19:00'), ('15', '8', '并蛋鸭', '1', '0', '0', '2016-12-25 17:19:17'), ('17', '0', '试试水', '1', '0', '1482847113', '2016-12-27 21:58:33'), ('18', '7', '时代复分', '1', '0', '1482850246', '2016-12-27 22:50:46'), ('19', '9', '的方法发', '1', '0', '1482851116', '2016-12-27 23:05:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='角色组';

-- ----------------------------
--  Records of `sc_role`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role` VALUES ('1', '系统管理员', '1', '111', '2016-12-18 15:54:00'), ('2', '管理员', '1', '0', '2016-12-18 15:54:31'), ('3', '运营总监', '1', '0', '2016-12-17 21:06:08'), ('4', '普通客服', '1', '0', '2016-12-17 21:06:08'), ('5', '新媒体专营', '1', '0', '2016-12-25 23:26:58'), ('6', '测试角色', '0', '1482049270', '2016-12-18 16:21:10'), ('9', '发广告', '1', '1482049321', '2016-12-18 16:22:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8 COMMENT='角色与权限管理';

-- ----------------------------
--  Records of `sc_role_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_power` VALUES ('56', '3', '8', '1482048726'), ('57', '3', '10', '1482048726'), ('58', '3', '11', '1482048726'), ('59', '4', '1', '1482048733'), ('60', '4', '4', '1482048733'), ('61', '4', '8', '1482048733'), ('62', '4', '12', '1482048733'), ('63', '6', '1', '1482049270'), ('64', '6', '4', '1482049270'), ('65', '6', '8', '1482049270'), ('66', '6', '10', '1482049270'), ('67', '6', '12', '1482049270'), ('72', '9', '1', '1482049321'), ('73', '9', '4', '1482049321'), ('184', '2', '1', '1482598465'), ('185', '2', '22', '1482598465'), ('186', '2', '19', '1482598465'), ('187', '2', '4', '1482598465'), ('188', '2', '13', '1482598465'), ('189', '2', '8', '1482598465'), ('190', '2', '10', '1482598465'), ('191', '2', '11', '1482598465'), ('192', '2', '12', '1482598465'), ('213', '5', '8', '1482679618'), ('214', '5', '10', '1482679618'), ('215', '1', '1', '1482854457'), ('216', '1', '22', '1482854457'), ('217', '1', '19', '1482854457'), ('218', '1', '20', '1482854457'), ('219', '1', '21', '1482854457'), ('220', '1', '4', '1482854457'), ('221', '1', '17', '1482854457'), ('222', '1', '18', '1482854457'), ('223', '1', '23', '1482854457'), ('224', '1', '13', '1482854457'), ('225', '1', '15', '1482854457'), ('226', '1', '16', '1482854457'), ('227', '1', '28', '1482854457'), ('228', '1', '29', '1482854457'), ('229', '1', '30', '1482854457'), ('230', '1', '31', '1482854457'), ('231', '1', '8', '1482854457'), ('232', '1', '12', '1482854457'), ('233', '1', '10', '1482854457'), ('234', '1', '11', '1482854457'), ('235', '1', '24', '1482854457'), ('236', '1', '25', '1482854457'), ('237', '1', '26', '1482854457'), ('238', '1', '27', '1482854457');
COMMIT;

-- ----------------------------
--  Table structure for `sc_score`
-- ----------------------------
DROP TABLE IF EXISTS `sc_score`;
CREATE TABLE `sc_score` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='成绩';

-- ----------------------------
--  Records of `sc_score`
-- ----------------------------
BEGIN;
INSERT INTO `sc_score` VALUES ('12', '第一期', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '第二期', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '第三期', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '第四期', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '第五期', '1', '0', '1482851855', '2016-12-27 23:17:35');
COMMIT;

-- ----------------------------
--  Table structure for `sc_semester`
-- ----------------------------
DROP TABLE IF EXISTS `sc_semester`;
CREATE TABLE `sc_semester` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='学期';

-- ----------------------------
--  Records of `sc_semester`
-- ----------------------------
BEGIN;
INSERT INTO `sc_semester` VALUES ('7', '谯家镇333', '1', '2', '0', '2016-12-25 14:41:23'), ('8', '印山村', '1', '0', '0', '2016-12-25 14:41:38'), ('9', '康家坨', '1', '0', '0', '2016-12-25 14:41:54'), ('10', '夹石镇', '0', '1', '0', '2016-12-25 14:42:31'), ('11', '水进湾', '1', '0', '0', '2016-12-25 14:42:53'), ('12', '小垫矮', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '麻池', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '打发打发', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('18', '是多少', '1', '0', '1482840494', '2016-12-27 20:08:14');
COMMIT;

-- ----------------------------
--  Table structure for `sc_subject`
-- ----------------------------
DROP TABLE IF EXISTS `sc_subject`;
CREATE TABLE `sc_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='科目';

-- ----------------------------
--  Records of `sc_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_subject` VALUES ('12', '语文', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '数学', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '政治', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '化学', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '地理', '1', '0', '1482851855', '2016-12-27 23:17:35');
COMMIT;

-- ----------------------------
--  Table structure for `sc_week`
-- ----------------------------
DROP TABLE IF EXISTS `sc_week`;
CREATE TABLE `sc_week` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='周';

-- ----------------------------
--  Records of `sc_week`
-- ----------------------------
BEGIN;
INSERT INTO `sc_week` VALUES ('12', '星期一', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '星期二', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '星期三', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '星期四', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '星期五', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '星期六', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '星期日', '1', '0', '1482852593', '2016-12-27 23:29:53');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
