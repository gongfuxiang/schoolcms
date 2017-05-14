<?php

/**
 * 模块语言包-页面设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	'view_name_text'						=>	'模块名称',
	'view_name_format'						=>	'格式 0~30 个字符之间',
	'view_right_title_text'					=>	'右标题',
	'view_right_title_format'				=>	'格式 0~255 个字符之间',
	'view_right_title_tips'					=>	'标题与链接使用[ ; ]符号隔开<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格式如 右标题;http://schoolcms.org/',
	'view_article_id_text'					=>	'指定主题',
	'view_article_id_placeholder'			=>	'指定文章id',
	'view_article_id_format'				=>	'半角逗号隔开（以数字开头结尾）格式如 1,2,3',
	'view_article_id_tips'					=>	'半角逗号隔开（以数字开头结尾）<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格式如 1,2,3<br />指定主题后，其它条件将失效',
	'view_keyword_text'						=>	'关键字',
	'view_keyword_format'					=>	'标题包含的关键字 0~255 个字符之间',
	'view_keyword_tips'						=>	'并且条件使用[ - ]符号<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格式如 win-unix<br />或条件使用[ | ]符号<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格式如 win|unix<br />并且+或使用[ ; ]符号隔开<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格式如 win-unix;win|unix<br />最大255个字符',
	'view_show_number_text'					=>	'显示条数',
	'view_show_number_format'				=>	'显示条数 1~1000 数值之间',
	'view_abstract_number_text'				=>	'摘要字数',
	'view_abstract_number_tips'				=>	'摘要文字数，默认80',
	'view_abstract_number_format'			=>	'字数 5~500 数值之间',
	'view_class_text'						=>	'文章分类',
	'view_class_format'						=>	'至少选择一个分类',
	'view_all_class_text'					=>	'全部分类',
	'view_sort_text'						=>	'排序方式',
	'view_add_time_text'					=>	'发布时间',
	'view_upd_time_text'					=>	'更新时间',
	'view_title_style_text'					=>	'显示样式',
	'view_link_open_way_text'				=>	'打开方式',
	'view_date_format_text'					=>	'日期格式',
	'view_data_cache_time_text'				=>	'数据缓存',
	'view_data_cache_time_placeholder'		=>	'数据缓存有效时间',
	'view_data_cache_time_tips'				=>	'数据缓存时间，单位（分钟）<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;默认60分钟，0不缓存数据',
	'view_summary_text'						=>	'自定义',
	'view_summary_placeholder'				=>	'自定义内容',
	'view_summary_tips'						=>	'自定义内容后，以上筛选规则将失效（可以是html代码）',
	'view_sort_type_format'					=>	'排序方式范围值有误',
	'view_add_time_interval_format'			=>	'发布时间范围值有误',
	'view_upd_time_interval_format'			=>	'更新时间范围值有误',
	'view_title_style_format'				=>	'标题显示样式范围值有误',
	'view_view_link_open_way_format_format'	=>	'打开方式范围值有误',
	'view_date_format_format'				=>	'日期格式范围值有误',

	'view_layout_param_save_tips'			=>	'布局参数有误',
	'view_module_param_save_tips'			=>	'模块参数有误',
	'view_module_edit_title'				=>	'模块编辑',

	'view_nav_home'							=>	'首页',
	'view_nav_channel'						=>	'频道',
	'view_nav_detail'						=>	'详情',
	'view_layout_module_tips'				=>	'浏览器宽度<br />&nbsp;&nbsp;&nbsp;sm：小于641 px<br />&nbsp;&nbsp;&nbsp;md：小于1025 px<br />&nbsp;&nbsp;&nbsp;lg：大于等于1025 px<br /><br />比例布局<br />&nbsp;&nbsp;&nbsp;宽度分割成12块，3块一个小布局<br /><br />[ x ] 代表当前布局所展示模块的数量，可能是一个数值，也有可能是一个布局形式',
	'view_no_edit_area'						=>	'基础内容区域，不可编辑',
	'view_layout_import_tips'				=>	'请上传主题数据txt文件',
);
?>