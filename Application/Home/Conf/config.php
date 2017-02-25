<?php

/**
 * 模块配置信息
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */

return array(
	// 图片host, 数据库图片地址以/Public/...开头
	'IMAGE_HOST'					=>	substr(__MY_URL__, 0, -1),

	// 伪静态后缀
	'URL_HTML_SUFFIX'				=>	MyC('home_seo_url_html_suffix'),

	// URL模式
	'URL_MODEL'          			=>	MyC('home_seo_url_model'),

	// 缓存key列表
	'cache_home_channel_key'		=>	'cache_home_channel_data',
);