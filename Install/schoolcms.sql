/*
 Navicat MySQL Data Transfer

 Source Server         : 本机
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : schoolcms_2.0

 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 01/08/2017 17:58:51 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员';

-- ----------------------------
--  Records of `sc_admin`
-- ----------------------------
BEGIN;
INSERT INTO `sc_admin` VALUES ('1', 'admin', 'eb37fedfc854951082b1ea8076466f66', '708633', '', '0', '74', '1483863346', '1', '1481350313', '2017-01-08 17:04:42');
COMMIT;

-- ----------------------------
--  Table structure for `sc_class`
-- ----------------------------
DROP TABLE IF EXISTS `sc_class`;
CREATE TABLE `sc_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='班级类别';

-- ----------------------------
--  Records of `sc_class`
-- ----------------------------
BEGIN;
INSERT INTO `sc_class` VALUES ('7', '0', '一年级', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '二年级', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '三年级', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '一班', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '二班', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('19', '10', '天才班', '1', '0', '1482922284', '2016-12-28 18:51:24'), ('20', '10', '优秀班', '1', '0', '1482922305', '2016-12-28 18:51:45'), ('21', '10', '普通班', '1', '0', '1482922320', '2016-12-28 18:52:00');
COMMIT;

-- ----------------------------
--  Table structure for `sc_config`
-- ----------------------------
DROP TABLE IF EXISTS `sc_config`;
CREATE TABLE `sc_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '基本设置id',
  `value` char(60) NOT NULL DEFAULT '' COMMENT '值',
  `name` char(38) NOT NULL DEFAULT '' COMMENT '名称',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '描述',
  `error_tips` char(150) NOT NULL DEFAULT '' COMMENT '错误提示',
  `only_tag` char(60) NOT NULL DEFAULT '' COMMENT '唯一的标记',
  PRIMARY KEY (`id`),
  UNIQUE KEY `only_tag` (`only_tag`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='基本配置参数';

-- ----------------------------
--  Records of `sc_config`
-- ----------------------------
BEGIN;
INSERT INTO `sc_config` VALUES ('15', '10', '分页数量', '分页显示数量', '分页不能超过3位数', 'page_number'), ('3', '20', '成绩等级', '差', '差,较差,中,良,优，不能超过3位数', 'fraction_weak'), ('4', '40', '成绩等级', '较差', '', 'fraction_poor'), ('5', '60', '成绩等级', '中', '', 'fraction_commonly'), ('6', '80', '成绩等级', '良', '', 'fraction_good'), ('7', '100', '成绩等级', '优', '', 'fraction_excellent'), ('8', '8', '学期', '当前学期类id', '请选择学期', 'semester_id'), ('11', '0', 'csv编码', 'csv模块编码选择', '请选择编码', 'csv_charset');
COMMIT;

-- ----------------------------
--  Table structure for `sc_course`
-- ----------------------------
DROP TABLE IF EXISTS `sc_course`;
CREATE TABLE `sc_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '班级id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `week_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '周天id',
  `interval_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时段id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_class_subject_week_interval` (`teacher_id`,`class_id`,`subject_id`,`week_id`,`interval_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `week_id` (`week_id`),
  KEY `interval_id` (`interval_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='教师课程';

-- ----------------------------
--  Table structure for `sc_fraction`
-- ----------------------------
DROP TABLE IF EXISTS `sc_fraction`;
CREATE TABLE `sc_fraction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '成绩id',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `student_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学生id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `score_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '成绩期号',
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分数',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `score_id` (`score_id`),
  KEY `score` (`score`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='学生成绩';

-- ----------------------------
--  Table structure for `sc_interval`
-- ----------------------------
DROP TABLE IF EXISTS `sc_interval`;
CREATE TABLE `sc_interval` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='时段类别';

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='权限';

-- ----------------------------
--  Records of `sc_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_power` VALUES ('1', '0', '权限控制', 'Power', 'Index', '1', '1', '1481612301'), ('4', '1', '角色管理', 'Power', 'Role', '11', '1', '1481639037'), ('8', '0', '类别管理', 'Routine', 'Index', '5', '1', '1481697671'), ('10', '8', '班级分类', 'Class', 'Index', '20', '1', '1481727987'), ('11', '8', '科目分类', 'Subject', 'Index', '30', '1', '1481728003'), ('12', '8', '学期分类', 'Semester', 'Index', '0', '1', '1481728021'), ('13', '1', '权限分配', 'Power', 'Index', '21', '1', '1482156143'), ('15', '1', '权限添加/编辑', 'Power', 'PowerSave', '22', '0', '1482243750'), ('16', '1', '权限删除', 'Power', 'PowerDelete', '23', '0', '1482243797'), ('17', '1', '角色组添加/编辑页面', 'Power', 'RoleSaveInfo', '12', '0', '1482243855'), ('18', '1', '角色组添加/编辑', 'Power', 'RoleSave', '13', '0', '1482243888'), ('19', '1', '管理员添加/编辑页面', 'Admin', 'SaveInfo', '2', '0', '1482244637'), ('20', '1', '管理员添加/编辑', 'Admin', 'Save', '3', '0', '1482244666'), ('21', '1', '管理员删除', 'Admin', 'Delete', '4', '0', '1482244688'), ('22', '1', '管理员列表', 'Admin', 'Index', '1', '1', '1482568868'), ('23', '1', '角色删除', 'Power', 'RoleDelete', '14', '0', '1482569155'), ('24', '8', '成绩分类', 'Score', 'Index', '40', '1', '1482638641'), ('25', '8', '周分类', 'Week', 'Index', '50', '1', '1482638899'), ('26', '8', '时段分类', 'Interval', 'Index', '60', '1', '1482638982'), ('27', '8', '地区管理', 'Region', 'Index', '70', '1', '1482639024'), ('28', '0', '学生管理', 'Student', 'Index', '2', '1', '1482854151'), ('29', '28', '学生列表', 'Student', 'Index', '1', '1', '1482854186'), ('30', '0', '成绩管理', 'Fraction', 'Index', '3', '1', '1482854384'), ('31', '30', '学生成绩', 'Fraction', 'Index', '1', '1', '1482854429'), ('32', '28', '学生添加/编辑页面', 'Student', 'SaveInfo', '2', '0', '1482915262'), ('33', '28', '学生添加/编辑', 'Student', 'Save', '3', '0', '1482915761'), ('34', '28', '学生删除', 'Student', 'Delete', '4', '0', '1482915804'), ('35', '30', '成绩录入页面', 'Fraction', 'SaveInfo', '2', '0', '1483096318'), ('36', '30', '成绩删除', 'Fraction', 'Delete', '4', '0', '1483096348'), ('37', '30', '成绩添加/编辑', 'Fraction', 'Save', '3', '0', '1483176255'), ('38', '0', '教师管理', 'Teacher', 'Index', '4', '1', '1483283430'), ('39', '38', '教师管理', 'Teacher', 'Index', '1', '1', '1483283546'), ('40', '38', '课程安排', 'Course', 'Index', '20', '1', '1483283640'), ('41', '0', '配置设置', 'Config', 'Index', '0', '1', '1483362358'), ('42', '41', '配置保存', 'Config', 'Save', '1', '0', '1483432335'), ('43', '8', '学期添加/编辑', 'Semester', 'Save', '1', '0', '1483456550'), ('44', '8', '班级添加/编辑', 'Class', 'Save', '21', '0', '1483456605'), ('45', '8', '科目添加/编辑', 'Subject', 'Save', '31', '0', '1483456640'), ('46', '8', '成绩添加/编辑', 'Score', 'Save', '41', '0', '1483456687'), ('47', '8', '周添加/编辑', 'Week', 'Save', '51', '0', '1483456721'), ('48', '8', '时段添加/编辑', 'Interval', 'Save', '61', '0', '1483456748'), ('49', '8', '地区添加/编辑', 'Region', 'Save', '71', '0', '1483456778'), ('50', '8', '学期删除', 'Semester', 'Delete', '2', '0', '1483457140'), ('51', '8', '班级删除', 'Class', 'Delete', '22', '0', '1483457222'), ('52', '8', '科目删除', 'Subject', 'Delete', '32', '0', '1483457265'), ('53', '8', '成绩删除', 'Score', 'Delete', '42', '0', '1483457291'), ('54', '8', '周删除', 'Week', 'Delete', '52', '0', '1483457365'), ('55', '8', '时段删除', 'Interval', 'Delete', '62', '0', '1483457405'), ('56', '8', '地区删除', 'Region', 'Delete', '72', '0', '1483457442'), ('57', '38', '教师添加/编辑页面', 'Teacher', 'SaveInfo', '2', '0', '1483616439'), ('58', '38', '教师添加/编辑', 'Teacher', 'Save', '3', '0', '1483616492'), ('59', '38', '教师删除', 'Teacher', 'Delete', '4', '0', '1483616569'), ('60', '38', '课程添加/编辑页面', 'Course', 'SaveInfo', '21', '0', '1483790861'), ('61', '38', '课程添加/编辑', 'Course', 'Save', '22', '0', '1483790940'), ('62', '38', '课程删除', 'Course', 'Delete', '23', '0', '1483790962');
COMMIT;

-- ----------------------------
--  Table structure for `sc_region`
-- ----------------------------
DROP TABLE IF EXISTS `sc_region`;
CREATE TABLE `sc_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='角色组';

-- ----------------------------
--  Records of `sc_role`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role` VALUES ('1', '系统管理员', '1', '1481350313', '2017-01-08 17:06:24');
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
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `power_id` (`power_id`)
) ENGINE=InnoDB AUTO_INCREMENT=689 DEFAULT CHARSET=utf8 COMMENT='角色与权限管理';

-- ----------------------------
--  Records of `sc_role_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_power` VALUES ('570', '1', '41', '1483791035'), ('571', '1', '42', '1483791035'), ('572', '1', '1', '1483791035'), ('573', '1', '22', '1483791035'), ('574', '1', '19', '1483791035'), ('575', '1', '20', '1483791035'), ('576', '1', '21', '1483791035'), ('577', '1', '4', '1483791035'), ('578', '1', '17', '1483791035'), ('579', '1', '18', '1483791035'), ('580', '1', '23', '1483791035'), ('581', '1', '13', '1483791035'), ('582', '1', '15', '1483791035'), ('583', '1', '16', '1483791035'), ('584', '1', '28', '1483791035'), ('585', '1', '29', '1483791035'), ('586', '1', '32', '1483791035'), ('587', '1', '33', '1483791035'), ('588', '1', '34', '1483791035'), ('589', '1', '30', '1483791035'), ('590', '1', '31', '1483791035'), ('591', '1', '35', '1483791035'), ('592', '1', '37', '1483791035'), ('593', '1', '36', '1483791035'), ('594', '1', '38', '1483791035'), ('595', '1', '39', '1483791035'), ('596', '1', '57', '1483791035'), ('597', '1', '58', '1483791035'), ('598', '1', '59', '1483791035'), ('599', '1', '40', '1483791035'), ('600', '1', '60', '1483791035'), ('601', '1', '61', '1483791035'), ('602', '1', '62', '1483791035'), ('603', '1', '8', '1483791035'), ('604', '1', '12', '1483791035'), ('605', '1', '43', '1483791035'), ('606', '1', '50', '1483791035'), ('607', '1', '10', '1483791035'), ('608', '1', '44', '1483791035'), ('609', '1', '51', '1483791035'), ('610', '1', '11', '1483791035'), ('611', '1', '45', '1483791035'), ('612', '1', '52', '1483791035'), ('613', '1', '24', '1483791035'), ('614', '1', '46', '1483791035'), ('615', '1', '53', '1483791035'), ('616', '1', '25', '1483791035'), ('617', '1', '47', '1483791035'), ('618', '1', '54', '1483791035'), ('619', '1', '26', '1483791035'), ('620', '1', '48', '1483791035'), ('621', '1', '55', '1483791035'), ('622', '1', '27', '1483791035'), ('623', '1', '49', '1483791035'), ('624', '1', '56', '1483791035');
COMMIT;

-- ----------------------------
--  Table structure for `sc_score`
-- ----------------------------
DROP TABLE IF EXISTS `sc_score`;
CREATE TABLE `sc_score` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='成绩类别';

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
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='学期类别';

-- ----------------------------
--  Records of `sc_semester`
-- ----------------------------
BEGIN;
INSERT INTO `sc_semester` VALUES ('7', '2016上学期', '1', '1', '0', '2016-12-25 14:41:23'), ('8', '2016下学期', '1', '0', '0', '2016-12-25 14:41:38');
COMMIT;

-- ----------------------------
--  Table structure for `sc_student`
-- ----------------------------
DROP TABLE IF EXISTS `sc_student`;
CREATE TABLE `sc_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `id_card` char(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '班级id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '地区id',
  `address` char(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `tel` char(15) NOT NULL DEFAULT '' COMMENT '联系方式（手机或座机）',
  `state` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '学生状态（0待入学, 1在读, 2已毕业, 3弃学, 4已开除）',
  `tuition_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '学费缴纳状态（0未缴费，1缴费）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_card_semester_id` (`id_card`,`semester_id`),
  KEY `class_id` (`class_id`),
  KEY `region_id` (`region_id`),
  KEY `state` (`state`),
  KEY `tuition_state` (`tuition_state`),
  KEY `birthday` (`birthday`),
  KEY `gender` (`gender`),
  KEY `semester_id` (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='学生';

-- ----------------------------
--  Table structure for `sc_subject`
-- ----------------------------
DROP TABLE IF EXISTS `sc_subject`;
CREATE TABLE `sc_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='科目类别';

-- ----------------------------
--  Records of `sc_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_subject` VALUES ('12', '语文', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '数学', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '政治', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '化学', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '地理', '1', '0', '1482851855', '2016-12-27 23:17:35');
COMMIT;

-- ----------------------------
--  Table structure for `sc_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `sc_teacher`;
CREATE TABLE `sc_teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `id_card` char(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `address` char(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `tel` char(15) NOT NULL DEFAULT '' COMMENT '联系方式（手机或座机）',
  `state` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '教师状态（0待报道, 1在职, 2已离职, 3已退休, 4已开除）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_card` (`id_card`) USING BTREE,
  KEY `state` (`state`),
  KEY `birthday` (`birthday`),
  KEY `gender` (`gender`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='教师';

-- ----------------------------
--  Table structure for `sc_week`
-- ----------------------------
DROP TABLE IF EXISTS `sc_week`;
CREATE TABLE `sc_week` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='周天类别';

-- ----------------------------
--  Records of `sc_week`
-- ----------------------------
BEGIN;
INSERT INTO `sc_week` VALUES ('12', '星期一', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '星期二', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '星期三', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '星期四', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '星期五', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '星期六', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '星期日', '1', '0', '1482852593', '2016-12-27 23:29:53');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
