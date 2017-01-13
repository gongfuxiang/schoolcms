# date   : 2017-01-08
# author : Devil
# version: 2.1

# PS 权限部分sql后面再导出添加

# 教师课程 - 添加学期id并且跳转顺序到id后面
ALTER TABLE `sc_course` ADD `semester_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '学期id' AFTER `id`;

# 教师课程 - 添加状态字段
ALTER TABLE `sc_course` ADD `state` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态（0不可用，1可用）' AFTER `interval_id`;

# 教师课程 - 唯一索引修改(加入学期)
ALTER TABLE `sc_course` DROP INDEX `teacher_class_subject_week_interval`;
ALTER TABLE `sc_course` ADD UNIQUE `semester_teacher_class_subject_week_interval` USING BTREE (`semester_id`, `teacher_id`, `class_id`, `subject_id`, `week_id`, `interval_id`);
ALTER TABLE `sc_course` ADD INDEX semester_id(`semester_id`);

# 配置信息更新 - csv变更为excel
UPDATE `sc_config` SET `only_tag`="excel_charset", `describe`="excel模块编码选择", `name`="Excel编码" WHERE `id`=11;

# 学生成绩 - 添加点评字段
ALTER TABLE `sc_fraction` ADD `comment` char(255) NOT NULL DEFAULT '' COMMENT '教师点评' AFTER `score`;

# 教师科目贯通关联表
CREATE TABLE `sc_teacher_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_subject` (`teacher_id`,`subject_id`),
  KEY `teacher_id` (`teacher_id`) USING BTREE,
  KEY `subject_id` (`subject_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师科目关联';
