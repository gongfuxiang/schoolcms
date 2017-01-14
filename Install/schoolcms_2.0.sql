/*
 Navicat MySQL Data Transfer

 Source Server         : 本机
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : schoolcms_2.0

 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 01/14/2017 12:26:42 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员';

-- ----------------------------
--  Records of `sc_admin`
-- ----------------------------
BEGIN;
INSERT INTO `sc_admin` VALUES ('1', 'admin', '3c585a2996ed0fd8925b6494ec9bcb0a', '242189', '', '2', '179', '1484276889', '1', '1481350313', '2017-01-13 11:08:09'), ('2', 'zhanglaoshi', '1148215dcaedf3021b737c9589d8371f', '326454', '', '2', '0', '0', '11', '1483936759', '2017-01-09 13:47:53'), ('3', 'testtest', 'ec14d5a6261cb104c7cb30e2c630f4b1', '668713', '', '0', '18', '1483957285', '12', '1483947758', '2017-01-09 18:21:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='班级类别';

-- ----------------------------
--  Records of `sc_class`
-- ----------------------------
BEGIN;
INSERT INTO `sc_class` VALUES ('7', '0', '一年级', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '二年级', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '三年级', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '一班', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '二班', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('19', '10', '天才班', '1', '0', '1482922284', '2016-12-28 18:51:24'), ('20', '10', '优秀班', '1', '0', '1482922305', '2016-12-28 18:51:45'), ('21', '10', '普通班', '1', '0', '1482922320', '2016-12-28 18:52:00'), ('22', '7', 'NickName', '1', '0', '1483927006', '2017-01-09 09:56:46'), ('23', '10', 'ddd', '1', '0', '1483927617', '2017-01-09 10:06:57'), ('24', '16', '1班', '1', '0', '1483951541', '2017-01-09 16:45:41');
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
INSERT INTO `sc_config` VALUES ('15', '10', '分页数量', '分页显示数量', '分页不能超过3位数', 'page_number'), ('3', '20', '成绩等级', '差', '差,较差,中,良,优，不能超过3位数', 'fraction_weak'), ('4', '40', '成绩等级', '较差', '', 'fraction_poor'), ('5', '60', '成绩等级', '中', '', 'fraction_commonly'), ('6', '80', '成绩等级', '良', '', 'fraction_good'), ('7', '100', '成绩等级', '优', '', 'fraction_excellent'), ('8', '7', '学期', '当前学期类id', '请选择学期', 'semester_id'), ('11', '1', 'Excel编码', 'excel模块编码选择', '请选择编码', 'excel_charset');
COMMIT;

-- ----------------------------
--  Table structure for `sc_course`
-- ----------------------------
DROP TABLE IF EXISTS `sc_course`;
CREATE TABLE `sc_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '班级id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `week_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '周天id',
  `interval_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时段id',
  `room_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教室id',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（0不可用，1可用）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `semester_teacher_class_subject_week_interval` (`semester_id`,`teacher_id`,`class_id`,`subject_id`,`week_id`,`interval_id`),
  UNIQUE KEY `semester_week_interval_room` (`semester_id`,`week_id`,`interval_id`,`room_id`) USING BTREE,
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `week_id` (`week_id`),
  KEY `interval_id` (`interval_id`),
  KEY `semester_id` (`semester_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师课程';

-- ----------------------------
--  Records of `sc_course`
-- ----------------------------
BEGIN;
INSERT INTO `sc_course` VALUES ('11', '7', '4', '18', '17', '12', '14', '18', '1', '1484219105', '2017-01-14 12:19:45'), ('12', '7', '1', '17', '19', '12', '14', '17', '1', '1484367651', '2017-01-14 12:20:51'), ('13', '7', '2', '18', '20', '12', '14', '19', '1', '1484367695', '2017-01-14 12:21:35'), ('14', '7', '2', '19', '20', '14', '14', '17', '1', '1484367735', '2017-01-14 12:22:15');
COMMIT;

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
  `comment` char(255) NOT NULL DEFAULT '' COMMENT '教师点评',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `semester_student_subject_score` (`semester_id`,`student_id`,`subject_id`,`score_id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `score_id` (`score_id`),
  KEY `score` (`score`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学生成绩';

-- ----------------------------
--  Records of `sc_fraction`
-- ----------------------------
BEGIN;
INSERT INTO `sc_fraction` VALUES ('14', '7', '8', '19', '14', '88', '', '1483957162', '2017-01-09 18:19:22'), ('15', '7', '8', '19', '12', '98', 'sss', '1484041760', '2017-01-10 17:52:04'), ('16', '7', '8', '17', '14', '87', 'dd', '1484041823', '2017-01-10 17:50:23'), ('17', '7', '9', '17', '14', '77', '不错，比以前进步多了&lt;script&gt;alert(\'hello\');&lt;/script&gt;', '1484041940', '2017-01-10 17:52:20'), ('18', '7', '11', '20', '17', '78', '还不错的哦~', '1484056861', '2017-01-10 22:01:01'), ('19', '7', '10', '19', '14', '84', '', '1484057026', '2017-01-10 22:03:46');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='时段类别';

-- ----------------------------
--  Records of `sc_interval`
-- ----------------------------
BEGIN;
INSERT INTO `sc_interval` VALUES ('14', '10:00-10:45', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '11:00-11:45', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '13:00-13:45', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '14:00-14:45', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '15:00-15:45', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '16:00-16:45', '1', '0', '1482852593', '2016-12-27 23:29:53');
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='权限';

-- ----------------------------
--  Records of `sc_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_power` VALUES ('1', '0', '权限控制', 'Power', 'Index', '1', '1', '1481612301'), ('4', '1', '角色管理', 'Power', 'Role', '11', '1', '1481639037'), ('8', '0', '类别管理', 'Routine', 'Index', '5', '1', '1481697671'), ('10', '8', '班级分类', 'Class', 'Index', '20', '1', '1481727987'), ('11', '8', '科目分类', 'Subject', 'Index', '30', '1', '1481728003'), ('12', '8', '学期分类', 'Semester', 'Index', '0', '1', '1481728021'), ('13', '1', '权限分配', 'Power', 'Index', '21', '1', '1482156143'), ('15', '1', '权限添加/编辑', 'Power', 'PowerSave', '22', '0', '1482243750'), ('16', '1', '权限删除', 'Power', 'PowerDelete', '23', '0', '1482243797'), ('17', '1', '角色组添加/编辑页面', 'Power', 'RoleSaveInfo', '12', '0', '1482243855'), ('18', '1', '角色组添加/编辑', 'Power', 'RoleSave', '13', '0', '1482243888'), ('19', '1', '管理员添加/编辑页面', 'Admin', 'SaveInfo', '2', '0', '1482244637'), ('20', '1', '管理员添加/编辑', 'Admin', 'Save', '3', '0', '1482244666'), ('21', '1', '管理员删除', 'Admin', 'Delete', '4', '0', '1482244688'), ('22', '1', '管理员列表', 'Admin', 'Index', '1', '1', '1482568868'), ('23', '1', '角色删除', 'Power', 'RoleDelete', '14', '0', '1482569155'), ('24', '8', '成绩分类', 'Score', 'Index', '40', '1', '1482638641'), ('25', '8', '周分类', 'Week', 'Index', '50', '1', '1482638899'), ('26', '8', '时段分类', 'Interval', 'Index', '60', '1', '1482638982'), ('27', '8', '地区管理', 'Region', 'Index', '70', '1', '1482639024'), ('28', '0', '学生管理', 'Student', 'Index', '2', '1', '1482854151'), ('29', '28', '学生列表', 'Student', 'Index', '1', '1', '1482854186'), ('30', '0', '成绩管理', 'Fraction', 'Index', '3', '1', '1482854384'), ('31', '30', '学生成绩', 'Fraction', 'Index', '1', '1', '1482854429'), ('32', '28', '学生添加/编辑页面', 'Student', 'SaveInfo', '2', '0', '1482915262'), ('33', '28', '学生添加/编辑', 'Student', 'Save', '3', '0', '1482915761'), ('34', '28', '学生删除', 'Student', 'Delete', '4', '0', '1482915804'), ('35', '30', '成绩录入页面', 'Fraction', 'SaveInfo', '2', '0', '1483096318'), ('36', '30', '成绩删除', 'Fraction', 'Delete', '4', '0', '1483096348'), ('37', '30', '成绩添加/编辑', 'Fraction', 'Save', '3', '0', '1483176255'), ('38', '0', '教师管理', 'Teacher', 'Index', '4', '1', '1483283430'), ('39', '38', '教师管理', 'Teacher', 'Index', '1', '1', '1483283546'), ('40', '38', '课程安排', 'Course', 'Index', '20', '1', '1483283640'), ('41', '0', '配置设置', 'Config', 'Index', '0', '1', '1483362358'), ('42', '41', '配置保存', 'Config', 'Save', '1', '0', '1483432335'), ('43', '8', '学期添加/编辑', 'Semester', 'Save', '1', '0', '1483456550'), ('44', '8', '班级添加/编辑', 'Class', 'Save', '21', '0', '1483456605'), ('45', '8', '科目添加/编辑', 'Subject', 'Save', '31', '0', '1483456640'), ('46', '8', '成绩添加/编辑', 'Score', 'Save', '41', '0', '1483456687'), ('47', '8', '周添加/编辑', 'Week', 'Save', '51', '0', '1483456721'), ('48', '8', '时段添加/编辑', 'Interval', 'Save', '61', '0', '1483456748'), ('49', '8', '地区添加/编辑', 'Region', 'Save', '71', '0', '1483456778'), ('50', '8', '学期删除', 'Semester', 'Delete', '2', '0', '1483457140'), ('51', '8', '班级删除', 'Class', 'Delete', '22', '0', '1483457222'), ('52', '8', '科目删除', 'Subject', 'Delete', '32', '0', '1483457265'), ('53', '8', '成绩删除', 'Score', 'Delete', '42', '0', '1483457291'), ('54', '8', '周删除', 'Week', 'Delete', '52', '0', '1483457365'), ('55', '8', '时段删除', 'Interval', 'Delete', '62', '0', '1483457405'), ('56', '8', '地区删除', 'Region', 'Delete', '72', '0', '1483457442'), ('57', '38', '教师添加/编辑页面', 'Teacher', 'SaveInfo', '2', '0', '1483616439'), ('58', '38', '教师添加/编辑', 'Teacher', 'Save', '3', '0', '1483616492'), ('59', '38', '教师删除', 'Teacher', 'Delete', '4', '0', '1483616569'), ('60', '38', '课程添加/编辑页面', 'Course', 'SaveInfo', '21', '0', '1483790861'), ('61', '38', '课程添加/编辑', 'Course', 'Save', '22', '0', '1483790940'), ('62', '38', '课程删除', 'Course', 'Delete', '23', '0', '1483790962'), ('63', '28', 'Excel导出', 'Student', 'ExcelExport', '5', '0', '1484058295'), ('64', '30', 'Excel导出', 'Fraction', 'ExcelExport', '5', '0', '1484058375'), ('65', '38', 'Excel导出', 'Teacher', 'ExcelExport', '5', '0', '1484058437'), ('66', '38', 'Excel导出', 'Course', 'ExcelExport', '24', '0', '1484058488'), ('67', '38', '课程状态更新', 'Course', 'StateUpdate', '25', '0', '1484231130'), ('68', '8', '教室管理', 'Room', 'Index', '80', '1', '1484304475'), ('69', '8', '教室添加/编辑', 'Room', 'Save', '81', '0', '1484304519'), ('70', '8', '教室删除', 'Room', 'Delete', '82', '0', '1484304545');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='地区';

-- ----------------------------
--  Records of `sc_region`
-- ----------------------------
BEGIN;
INSERT INTO `sc_region` VALUES ('7', '0', '谯家镇2', '1', '2', '0', '2016-12-25 14:41:23'), ('8', '7', '印山村2', '1', '0', '0', '2016-12-25 14:41:38'), ('9', '8', '康家坨', '1', '0', '0', '2016-12-25 14:41:54'), ('10', '0', '夹石镇', '0', '1', '0', '2016-12-25 14:42:31'), ('11', '10', '水进湾', '1', '0', '0', '2016-12-25 14:42:53'), ('12', '0', '小垫矮', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '8', '麻池', '1', '0', '0', '2016-12-25 17:19:00'), ('15', '8', '并蛋鸭', '1', '0', '0', '2016-12-25 17:19:17'), ('17', '0', '试试水', '1', '0', '1482847113', '2016-12-27 21:58:33'), ('18', '7', '时代复分', '1', '0', '1482850246', '2016-12-27 22:50:46'), ('19', '9', '的方法发', '1', '0', '1482851116', '2016-12-27 23:05:16'), ('20', '17', 'sdfsd', '1', '0', '1484204770', '2017-01-12 15:06:10');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色组';

-- ----------------------------
--  Records of `sc_role`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role` VALUES ('1', '系统管理员', '1', '1481350313', '2017-01-08 17:06:24'), ('11', '教师管理员', '1', '1483940867', '2017-01-09 13:47:47'), ('12', '超级管理员', '1', '1483947730', '2017-01-09 15:42:10');
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
) ENGINE=InnoDB AUTO_INCREMENT=980 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色与权限管理';

-- ----------------------------
--  Records of `sc_role_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_power` VALUES ('689', '11', '28', '1483940867'), ('690', '11', '29', '1483940867'), ('691', '11', '32', '1483940867'), ('692', '11', '33', '1483940867'), ('693', '11', '34', '1483940867'), ('694', '11', '30', '1483940867'), ('695', '11', '31', '1483940867'), ('696', '11', '35', '1483940867'), ('697', '11', '37', '1483940867'), ('698', '11', '36', '1483940867'), ('751', '12', '41', '1483947871'), ('752', '12', '42', '1483947871'), ('753', '12', '1', '1483947871'), ('754', '12', '22', '1483947871'), ('755', '12', '4', '1483947871'), ('756', '12', '13', '1483947871'), ('757', '12', '28', '1483947871'), ('758', '12', '29', '1483947871'), ('759', '12', '32', '1483947871'), ('760', '12', '33', '1483947871'), ('761', '12', '34', '1483947871'), ('762', '12', '30', '1483947871'), ('763', '12', '31', '1483947871'), ('764', '12', '35', '1483947871'), ('765', '12', '37', '1483947871'), ('766', '12', '36', '1483947871'), ('767', '12', '38', '1483947871'), ('768', '12', '39', '1483947871'), ('769', '12', '57', '1483947871'), ('770', '12', '58', '1483947871'), ('771', '12', '59', '1483947871'), ('772', '12', '40', '1483947871'), ('773', '12', '60', '1483947871'), ('774', '12', '61', '1483947871'), ('775', '12', '62', '1483947871'), ('776', '12', '8', '1483947871'), ('777', '12', '12', '1483947871'), ('778', '12', '43', '1483947871'), ('779', '12', '50', '1483947871'), ('780', '12', '10', '1483947871'), ('781', '12', '44', '1483947871'), ('782', '12', '51', '1483947871'), ('783', '12', '11', '1483947871'), ('784', '12', '45', '1483947871'), ('785', '12', '52', '1483947871'), ('786', '12', '24', '1483947871'), ('787', '12', '46', '1483947871'), ('788', '12', '53', '1483947871'), ('789', '12', '25', '1483947871'), ('790', '12', '47', '1483947871'), ('791', '12', '54', '1483947871'), ('792', '12', '26', '1483947871'), ('793', '12', '48', '1483947871'), ('794', '12', '55', '1483947871'), ('795', '12', '27', '1483947871'), ('796', '12', '49', '1483947871'), ('797', '12', '56', '1483947871'), ('917', '1', '41', '1484304570'), ('918', '1', '42', '1484304570'), ('919', '1', '1', '1484304570'), ('920', '1', '22', '1484304570'), ('921', '1', '19', '1484304570'), ('922', '1', '20', '1484304570'), ('923', '1', '21', '1484304570'), ('924', '1', '4', '1484304570'), ('925', '1', '17', '1484304570'), ('926', '1', '18', '1484304570'), ('927', '1', '23', '1484304570'), ('928', '1', '13', '1484304570'), ('929', '1', '15', '1484304570'), ('930', '1', '16', '1484304570'), ('931', '1', '28', '1484304570'), ('932', '1', '29', '1484304570'), ('933', '1', '32', '1484304570'), ('934', '1', '33', '1484304570'), ('935', '1', '34', '1484304570'), ('936', '1', '63', '1484304570'), ('937', '1', '30', '1484304570'), ('938', '1', '31', '1484304570'), ('939', '1', '35', '1484304570'), ('940', '1', '37', '1484304570'), ('941', '1', '36', '1484304570'), ('942', '1', '64', '1484304570'), ('943', '1', '38', '1484304570'), ('944', '1', '39', '1484304570'), ('945', '1', '57', '1484304570'), ('946', '1', '58', '1484304570'), ('947', '1', '59', '1484304570'), ('948', '1', '65', '1484304570'), ('949', '1', '40', '1484304570'), ('950', '1', '60', '1484304570'), ('951', '1', '61', '1484304570'), ('952', '1', '62', '1484304570'), ('953', '1', '66', '1484304570'), ('954', '1', '67', '1484304570'), ('955', '1', '8', '1484304570'), ('956', '1', '12', '1484304570'), ('957', '1', '43', '1484304570'), ('958', '1', '50', '1484304570'), ('959', '1', '10', '1484304570'), ('960', '1', '44', '1484304570'), ('961', '1', '51', '1484304570'), ('962', '1', '11', '1484304570'), ('963', '1', '45', '1484304570'), ('964', '1', '52', '1484304570'), ('965', '1', '24', '1484304570'), ('966', '1', '46', '1484304570'), ('967', '1', '53', '1484304570'), ('968', '1', '25', '1484304570'), ('969', '1', '47', '1484304570'), ('970', '1', '54', '1484304570'), ('971', '1', '26', '1484304570'), ('972', '1', '48', '1484304570'), ('973', '1', '55', '1484304570'), ('974', '1', '27', '1484304570'), ('975', '1', '49', '1484304570'), ('976', '1', '56', '1484304570'), ('977', '1', '68', '1484304570'), ('978', '1', '69', '1484304570'), ('979', '1', '70', '1484304570');
COMMIT;

-- ----------------------------
--  Table structure for `sc_room`
-- ----------------------------
DROP TABLE IF EXISTS `sc_room`;
CREATE TABLE `sc_room` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教室类别';

-- ----------------------------
--  Records of `sc_room`
-- ----------------------------
BEGIN;
INSERT INTO `sc_room` VALUES ('7', '0', '东区', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '西北区', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '天才班专用教室1号', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '教室一', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '教室二', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('19', '10', '教室一', '1', '0', '1482922284', '2016-12-28 18:51:24'), ('20', '10', '教室二', '1', '0', '1482922305', '2016-12-28 18:51:45'), ('21', '10', '教室三', '1', '0', '1482922320', '2016-12-28 18:52:00'), ('24', '0', 'VIP教室', '1', '0', '1483951541', '2017-01-09 16:45:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='成绩类别';

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学期类别';

-- ----------------------------
--  Records of `sc_semester`
-- ----------------------------
BEGIN;
INSERT INTO `sc_semester` VALUES ('7', '2016上学期', '1', '1', '0', '2016-12-25 14:41:23'), ('8', '2016下学期', '1', '0', '0', '2016-12-25 14:41:38'), ('18', 'dsdsa', '1', '0', '1483952728', '2017-01-09 17:05:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学生';

-- ----------------------------
--  Records of `sc_student`
-- ----------------------------
BEGIN;
INSERT INTO `sc_student` VALUES ('8', '留洋', '142613199904234622', '2', '917452800', '7', '17', '7', '', '03667879265', '0', '0', '1483932878', '2017-01-10 22:58:05'), ('9', '张三', '533338198988888888', '2', '736012800', '7', '19', '8', '学校附近的888号', '17000000000', '1', '1', '1483936027', '2017-01-09 12:27:07'), ('10', '武松打虎', '677771999999999992', '2', '633801600', '7', '20', '9', '', '17666666666', '1', '1', '1483936080', '2017-01-09 12:28:00'), ('11', '小花', '211118199102111666', '1', '736012800', '7', '19', '11', '住校', '13199999999', '1', '1', '1483936138', '2017-01-09 12:28:58'), ('12', '大哥哥', '399998198898998887', '2', '839433600', '7', '16', '14', '', '13222222222', '1', '1', '1483936199', '2017-01-09 12:29:59'), ('13', '11', '441801198810252656', '2', '1483891200', '7', '18', '9', '111', '15915110562', '3', '1', '1483948630', '2017-01-09 15:57:10');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='科目类别';

-- ----------------------------
--  Records of `sc_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_subject` VALUES ('17', '政治', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '化学', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '地理', '1', '0', '1482851855', '2016-12-27 23:17:35');
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
  UNIQUE KEY `id_card` (`id_card`),
  KEY `state` (`state`),
  KEY `birthday` (`birthday`),
  KEY `gender` (`gender`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师';

-- ----------------------------
--  Records of `sc_teacher`
-- ----------------------------
BEGIN;
INSERT INTO `sc_teacher` VALUES ('1', '张老师', '222228198888888888', '0', '318182400', '', '13888888888', '2', '1483936487', '2017-01-10 23:12:08'), ('2', '刘老师', '822228198999999999', '2', '2390400', '哈哈呵呵', '021-33333333', '1', '1483957038', '2017-01-10 23:17:21'), ('3', 'hello', '522228198888888888', '2', '1367424000', '梵蒂冈', '17602128368', '2', '1484211799', '2017-01-12 17:03:19'), ('4', '的方法', '522229199999999933', '2', '1367424000', '电饭锅sdfsfsdfdfs', '021-33333333', '1', '1484211920', '2017-01-12 17:13:46');
COMMIT;

-- ----------------------------
--  Table structure for `sc_teacher_subject`
-- ----------------------------
DROP TABLE IF EXISTS `sc_teacher_subject`;
CREATE TABLE `sc_teacher_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_subject` (`teacher_id`,`subject_id`),
  KEY `teacher_id` (`teacher_id`) USING BTREE,
  KEY `subject_id` (`subject_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师科目关联';

-- ----------------------------
--  Records of `sc_teacher_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_teacher_subject` VALUES ('14', '4', '17', '1484212426'), ('15', '4', '20', '1484212426'), ('16', '3', '19', '1484212442'), ('17', '3', '20', '1484212442'), ('18', '1', '17', '1484367612'), ('19', '1', '19', '1484367612'), ('20', '1', '20', '1484367612'), ('21', '2', '20', '1484367657');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='周天类别';

-- ----------------------------
--  Records of `sc_week`
-- ----------------------------
BEGIN;
INSERT INTO `sc_week` VALUES ('12', '星期一', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '星期二', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '星期三', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '星期四', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '星期五', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '星期六', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '星期日', '1', '0', '1482852593', '2016-12-27 23:29:53');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
