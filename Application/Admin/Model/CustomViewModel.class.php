<?php

namespace Admin\Model;
use Think\Model;

/**
 * 自定义页面模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CustomViewModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('title', 'CheckTitle', '{%article_title_format}', 1, 'callback', 3),
		array('is_enable', array(0,1), '{%common_enable_tips}', 1, 'in', 3),
		array('is_header', array(0,1), '{%common_is_header_tips}', 1, 'in', 3),
		array('is_footer', array(0,1), '{%common_is_footer_tips}', 1, 'in', 3),
		array('is_full_screen', array(0,1), '{%common_is_full_screen_tips}', 1, 'in', 3),
		array('content', 'CheckContent', '{%article_content_format_mobile}', 1, 'callback', 3),
	);

	/**
	 * [CheckTitle 标题校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckTitle()
	{
		$len = Utf8Strlen(I('title'));
		return ($len >= 3 && $len <= 60);
	}

	/**
	 * [CheckContent 内容校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckContent()
	{
		$len = Utf8Strlen(I('content'));
		return ($len >= 50 && $len <= 105000);
	}
}
?>