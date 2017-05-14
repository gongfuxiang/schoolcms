<?php

namespace Admin\Model;
use Think\Model;

/**
 * 模块模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class LayoutModule extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 编辑
		array('name', 'CheckName', '{%view_name_format}', 2, 'callback', 2),
		array('right_title', 'CheckRightTitle', '{%view_right_title_format}', 2, 'callback', 2),
		array('article_id', 'CheckArticleId', '{%view_article_id_format}', 2, 'callback', 2),
		array('keyword', 'CheckKeyword', '{%view_keyword_format}', 2, 'callback', 2),
		array('show_number', 'CheckShowNumber', '{%view_show_number_format}', 2, 'callback', 2),
		array('abstract_number', 'CheckAbstractNumber', '{%view_abstract_number_format}', 2, 'callback', 2),
		array('sort_type', array(0,1,2), '{%view_sort_type_format}', 2, 'in', 2),
		array('add_time_interval', array(0,1,2,3,4), '{%view_add_time_interval_format}', 2, 'in', 2),
		array('upd_time_interval', array(0,1,2,3,4), '{%view_upd_time_interval_format}', 2, 'in', 2),
		array('title_style', array(0,1,2,3,4,5,6,7,8,9), '{%view_title_style_format}', 2, 'in', 2),
		array('link_open_way', array(0,1), '{%view_link_open_way_format}', 2, 'in', 2),
		array('date_format', array(0,1,2,3), '{%view_date_format_format}', 2, 'in', 2),
	);

	/**
	 * [CheckName 模块名称校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckName()
	{
		$len = Utf8Strlen(I('name'));
		return ($len <= 30);
	}

	/**
	 * [CheckRightTitle 右标题校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckRightTitle()
	{
		$len = Utf8Strlen(I('right_title'));
		return ($len <= 255);
	}

	/**
	 * [CheckArticleId 指定主题id校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckArticleId()
	{
		return (preg_match('/'.L('common_regex_id_comma_split').'/', I('article_id')) == 1) ? true : false;
	}

	/**
	 * [CheckKeyword 关键字校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckKeyword()
	{
		$len = Utf8Strlen(I('keyword'));
		return ($len <= 255);
	}

	/**
	 * [CheckShowNumber 显示条数校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckShowNumber()
	{
		return (I('show_number') >= 1 && I('show_number') <= 1000);
	}

	/**
	 * [CheckAbstractNumber 摘要字数校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckAbstractNumber()
	{
		return (I('abstract_number') >= 5 && I('abstract_number') <= 500);
	}
}
?>