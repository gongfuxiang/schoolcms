<?php

/**
 * 模块语言包-页面设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	// 添加/编辑
	'view_class_text'				=>	'文章分类',
	'view_class_format'				=>	'至少选择一个分类',
	'view_all_class_text'			=>	'全部分类',
	'view_sort_text'				=>	'排序方式',
	'view_add_time_text'			=>	'发布时间',
	'view_upd_time_text'			=>	'更新时间',
	'view_sort_list'				=>	array(
			0 => array(
				'value'		=>	'new_desc',
				'name'		=>	'最新发布降序',
				'checked'	=>	true
			),
			1 => array(
				'value'		=>	'upd_desc',
				'name'		=>	'最新更新降序'
			),
			2 => array(
				'value'		=>	'browse_desc',
				'name'		=>	'浏览降序'
			),
		),
	'view_time_list'				=>	array(
			0 => array(
				'value'		=>	0,
				'name'		=>	'不限制',
				'checked'	=>	true
			),
			1 => array(
				'value'		=>	1,
				'name'		=>	'1小时内'
			),
			2 => array(
				'value'		=>	24,
				'name'		=>	'24小时内'
			),
			3 => array(
				'value'		=>	168,
				'name'		=>	'7天内'
			),
			4 => array(
				'value'		=>	720,
				'name'		=>	'1个月内'
			),
		),
);
?>