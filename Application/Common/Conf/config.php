<?php

/**
 * 公共配置信息
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	// 默认模块
	'DEFAULT_MODULE'     	=>	'Home',

	// URL模式
	'URL_MODEL'          	=>	'2',

	// 开启session
	'SESSION_AUTO_START' 	=>	true,

	// 设置默认的模板主题
	'DEFAULT_THEME'       	=>  'Default',

	// 模板静态文件后缀
	'TMPL_TEMPLATE_SUFFIX'	=>	'.html',

	// 模板定界符
	'TMPL_L_DELIM'			=>	'{{',
	'TMPL_R_DELIM'			=>	'}}',

	// 开启语言包功能
	'LANG_SWITCH_ON'		=>	true,

	// 默认语言
	'DEFAULT_LANG'          =>	'zh-cn',

	// 默认输出编码
	'DEFAULT_CHARSET'		=>	'utf-8',

	// 默认AJAX 数据返回格式,可选JSON XML
	'DEFAULT_AJAX_RETURN'	=>	'JSON',

	// 默认参数过滤方法 用于I函数
	'DEFAULT_FILTER'		=>	'htmlspecialchars',

	// 错误显示信息,非调试模式有效
	'ERROR_MESSAGE'			=>	'页面错误！请稍后再试～',

	// 默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR'		=>	'Public:JumpError',

	// 默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'	=>	'Public:JumpSuccess',
);