<?php

/**
 * 模块语言包
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	// 学生excel导出标题列表,
	// 索引对应数据库字段名称,
	// col对应excel列标记,
	// type定义excel数据类型
	'excel_student_title_list'		=>	array(
			'username'		=>	array(
					'col' => 'A',
					'name' => '学生姓名',
					'type' => 'string',
				),
			'number'		=>	array(
					'col' => 'B',
					'name' => '学生编号',
					'type' => 'int',
				),
			'id_card'		=>	array(
					'col' => 'C',
					'name' => '身份证号码',
					'type' => 'int',
				),
			'gender'		=>	array(
					'col' => 'D',
					'name' => '性别',
					'type' => 'string',
				),
			'birthday'		=>	array(
					'col' => 'E',
					'name' => '出生年日',
					'type' => 'string',
				),
			'tel'			=>	array(
					'col' => 'F',
					'name' => '座机号码',
					'type' => 'int',
				),
			'my_mobile'		=>	array(
					'col' => 'G',
					'name' => '学生手机',
					'type' => 'int',
				),
			'parent_mobile'	=>	array(
					'col' => 'H',
					'name' => '家长手机',
					'type' => 'int',
				),
			'email'			=>	array(
					'col' => 'I',
					'name' => '电子邮箱',
					'type' => 'string',
				),
			'state'			=>	array(
					'col' => 'J',
					'name' => '学生状态',
					'type' => 'string',
				),
			'tuition_state'	=>	array(
					'col' => 'K',
					'name' => '缴费状态',
					'type' => 'string',
				),
			'class_name'	=>	array(
					'col' => 'L',
					'name' => '班级',
					'type' => 'string',
				),
			'region_name'	=>	array(
					'col' => 'M',
					'name' => '地区',
					'type' => 'string',
				),
			'address'		=>	array(
					'col' => 'N',
					'name' => '详细地址',
					'type' => 'string',
				),
			'add_time'		=>	array(
					'col' => 'O',
					'name' => '报名时间',
					'type' => 'string',
				),
		),
	// 学生excel导出标题列表-导入格式
	'excel_student_impoet_title_list'		=>	array(
			'username'		=>	array(
					'col' => 'A',
					'name' => '学生姓名',
					'type' => 'string',
				),
			'id_card'		=>	array(
					'col' => 'B',
					'name' => '身份证号码',
					'type' => 'int',
				),
			'gender'		=>	array(
					'col' => 'C',
					'name' => '性别',
					'type' => 'string',
				),
			'birthday'		=>	array(
					'col' => 'D',
					'name' => '出生年日',
					'type' => 'string',
				),
			'tel'			=>	array(
					'col' => 'E',
					'name' => '座机号码',
					'type' => 'int',
				),
			'my_mobile'		=>	array(
					'col' => 'F',
					'name' => '学生手机',
					'type' => 'int',
				),
			'parent_mobile'	=>	array(
					'col' => 'G',
					'name' => '家长手机',
					'type' => 'int',
				),
			'email'			=>	array(
					'col' => 'H',
					'name' => '电子邮箱',
					'type' => 'string',
				),
			'state'			=>	array(
					'col' => 'I',
					'name' => '学生状态',
					'type' => 'string',
				),
			'tuition_state'	=>	array(
					'col' => 'J',
					'name' => '缴费状态',
					'type' => 'string',
				),
			'class_name'	=>	array(
					'col' => 'K',
					'name' => '班级',
					'type' => 'string',
				),
			'region_name'	=>	array(
					'col' => 'L',
					'name' => '地区',
					'type' => 'string',
				),
			'address'		=>	array(
					'col' => 'M',
					'name' => '详细地址',
					'type' => 'string',
				),
			'add_time'		=>	array(
					'col' => 'N',
					'name' => '报名时间',
					'type' => 'string',
				),
		),

	// 学生成绩excel导出标题列表
	'excel_fraction_title_list'		=>	array(
			'username'		=>	array(
					'col' => 'A',
					'name' => '学生姓名',
					'type' => 'string',
				),
			'gender'		=>	array(
					'col' => 'B',
					'name' => '性别',
					'type' => 'string',
				),
			'class_name'	=>	array(
					'col' => 'C',
					'name' => '班级',
					'type' => 'string',
				),
			'subject_name'	=>	array(
					'col' => 'D',
					'name' => '科目',
					'type' => 'string',
				),
			'score_name'	=>	array(
					'col' => 'E',
					'name' => '成绩类别',
					'type' => 'string',
				),
			'score'			=>	array(
					'col' => 'F',
					'name' => '成绩分数',
					'type' => 'int',
				),
			'score_level'	=>	array(
					'col' => 'G',
					'name' => '成绩等级',
					'type' => 'string',
				),
			'comment'		=>	array(
					'col' => 'H',
					'name' => '教师点评',
					'type' => 'string',
				),
			'add_time'		=>	array(
					'col' => 'I',
					'name' => '录入时间',
					'type' => 'string',
				),
		),
	// 学生成绩excel导出标题列表-导入格式
	'excel_fraction_import_title_list'		=>	array(
			'username'		=>	array(
					'col' => 'A',
					'name' => '学生姓名',
					'type' => 'string',
				),
			'number'		=>	array(
					'col' => 'B',
					'name' => '学生编号',
					'type' => 'int',
				),
			'id_card'		=>	array(
					'col' => 'C',
					'name' => '身份证号码',
					'type' => 'int',
				),
			'subject_name'	=>	array(
					'col' => 'D',
					'name' => '科目',
					'type' => 'string',
				),
			'score_name'	=>	array(
					'col' => 'E',
					'name' => '成绩类别',
					'type' => 'string',
				),
			'score'			=>	array(
					'col' => 'F',
					'name' => '成绩分数',
					'type' => 'int',
				),
			'comment'		=>	array(
					'col' => 'G',
					'name' => '教师点评',
					'type' => 'string',
				),
			'add_time'		=>	array(
					'col' => 'H',
					'name' => '录入时间',
					'type' => 'string',
				),
		),

	// 教师excel导出标题列表
	'excel_teacher_title_list'		=>	array(
			'username'		=>	array('col' => 'A', 'name' => '教师姓名'),
			'id_card'		=>	array('col' => 'B', 'name' => '身份证号码'),
			'gender'		=>	array('col' => 'C', 'name' => '性别'),
			'birthday'		=>	array('col' => 'D', 'name' => '出生年日'),
			'tel'			=>	array('col' => 'E', 'name' => '联系电话'),
			'address'		=>	array('col' => 'F', 'name' => '详细地址'),
			'state'			=>	array('col' => 'G', 'name' => '教师状态'),
			'subject_list'	=>	array('col' => 'H', 'name' => '贯通科目'),
			'add_time'		=>	array('col' => 'I', 'name' => '添加时间'),
		),

	// 教师课程excel导出标题列表
	'excel_course_title_list'		=>	array(
			'teacher_name'	=>	array('col' => 'A', 'name' => '教师姓名'),
			'class_name'	=>	array('col' => 'B', 'name' => '班级'),
			'subject_name'	=>	array('col' => 'C', 'name' => '科目'),
			'week_name'		=>	array('col' => 'D', 'name' => '周天'),
			'interval_name'	=>	array('col' => 'E', 'name' => '时段'),
			'room_name'		=>	array('col' => 'F', 'name' => '教室'),
			'state_text'	=>	array('col' => 'G', 'name' => '状态'),
			'add_time'		=>	array('col' => 'H', 'name' => '添加时间'),
		),

	// 文章excel导出标题列表
	'excel_article_title_list'		=>	array(
			'title'						=>	array('col' => 'A', 'name' => '标题'),
			'article_class_name'		=>	array('col' => 'B', 'name' => '文章分类'),
			'is_enable_text'			=>	array('col' => 'C', 'name' => '是否启用'),
			'content'					=>	array('col' => 'D', 'name' => '内容'),
			'add_time'					=>	array('col' => 'E', 'name' => '添加时间'),
		),
);
?>