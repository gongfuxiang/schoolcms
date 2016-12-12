<?php

/**
 * 公共语言包
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	// 站点信息
	'common_site_name'					=>	'Hello',
	'common_site_title'					=>	'SchoolCMS后台管理系统',
	'common_site_title'					=>	'hello',

	// 公共
	'common_login_invalid'				=>	'登录失效，请重新登录',
	'common_jump_tips'					=>	'页面跳转中...',
	'common_form_loading_tips'			=>	'处理中...',
	'common_mobile_name'				=>	'手机号码',
	'common_mobile_format_error'		=>	'手机号码格式错误',
	'common_id_card_name'				=>	'身份证',
	'common_id_url_name'				=>	'url地址',
	'common_id_ip_name'					=>	'ip地址',
	'common_admin_name'					=>	'管理员',
	'common_not_login_name'				=>	'未登录',
	'common_not_data_tips'				=>	'没有数据',
	'common_create_time_name'			=>	'创建时间',

	'common_param_error'				=>	'参数错误',
	'common_format_error'				=>	'格式错误',
	'common_format_success'				=>	'格式正确',
	'common_success'					=>	'正确',
	'common_error'						=>	'错误',
	'common_username_already_exist'		=>	'帐号已经存在',

	'common_operation_name'				=>	'操作',
	'common_operation_add'				=>	'新增',
	'common_operation_edit'				=>	'编辑',
	'common_operation_delete'			=>	'删除',
	'common_operation_back'				=>	'返回',
	'common_operation_save'				=>	'保存',
	'common_operation_query'			=>	'查询',
	'common_operation_success'			=>	'操作成功',
	'common_operation_error'			=>	'操作失败',
	'common_operation_add_success'		=>	'新增成功',
	'common_operation_add_error'		=>	'新增失败',
	'common_operation_edit_success'		=>	'编辑成功',
	'common_operation_edit_error'		=>	'编辑失败',
	'common_operation_delete_success'	=>	'删除成功',
	'common_operation_delete_error'		=>	'删除失败',
	'common_operation_unauthorized'		=>	'非法操作',
	'common_value_not_change'			=>	'数据未改变',

	'common_view_gender_name'			=>	'性别',

	'common_unauthorized_access'		=>	'非法访问',
	'nav_fulltext_open'					=>	'开启全屏',
	'nav_fulltext_exit'					=>	'退出全屏',
	'nav_switch_text'					=>	'导航切换',

	// 性别
	'common_gender_list'				=>	array(
			0 => array('id' => 0, 'name' => '保密', 'checked' => true),
			1 => array('id' => 1, 'name' => '女'),
			2 => array('id' => 2, 'name' => '男'),
		),

	// 正则
	// 用户名
	'common_regex_username'				=>	'^[A-Za-z0-9_]{5,18}$',

	// 用户名
	'common_regex_pwd'					=>	'^.{5,18}$',

	// 手机号码
	'common_regex_mobile'				=>	'^1((3|5|8){1}\d{1}|70)\d{8}$',

	// 身份证号码
	'common_regex_id_card'				=>	'^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$',

	// 身份证号码
	'common_regex_price'				=>	'^([0-9]{1}\d{0,6})(\.\d{1,2})?$',

	// ip
	'common_regex_ip'					=>	'^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$',

	// url
	'common_regex_url'					=>	'^http[s]?:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$',
);
?>