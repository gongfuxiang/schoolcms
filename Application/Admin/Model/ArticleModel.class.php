<?php

namespace Admin\Model;
use Think\Model;

/**
 * 文章模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ArticleModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('title', 'CheckTitle', '{%article_title_format}', 1, 'callback', 3),
		array('article_class_id', 'IsExistArticleClassId', '{%article_article_class_id_error}', 1, 'callback', 3),
		array('title_color', 'CheckTitleColor', '{%common_color_format}', 2, 'callback', 3),
		array('jump_url', 'CheckJumpUrl', '{%article_jump_url_format}', 2, 'callback', 3),
		array('is_enable', array(0,1), '{%common_enable_tips}', 1, 'in', 3),
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
	 * [IsExistArticleClassId 文章分类是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistArticleClassId()
	{
		$temp = $this->db(0)->table('__ARTICLE_CLASS__')->field(array('id'))->find(I('article_class_id'));
		return !empty($temp);
	}

	/**
	 * [CheckTitleColor 颜色值校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckTitleColor()
	{
		return (preg_match('/'.L('common_regex_color').'/', I('title_color')) == 1) ? true : false;
	}

	/**
	 * [CheckJumpUrl 跳转url地址校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckJumpUrl()
	{
		return (preg_match('/'.L('common_regex_url').'/', I('jump_url')) == 1) ? true : false;
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