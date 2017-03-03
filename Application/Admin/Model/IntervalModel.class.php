<?php

namespace Admin\Model;
use Think\Model;

/**
 * 时段模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class IntervalModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(
		// 添加,编辑
		array('name', 'CheckName', '{%interval_name_format}', 1, 'callback', 3),
		array('is_enable', array(0,1), '{%common_enable_tips}', 1, 'in', 3),
		array('sort', 'CheckSort', '{%common_sort_error}', 1, 'function', 3),
	);

	/**
	 * [CheckName 时段名称格式校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckName()
	{
		return (preg_match('/'.L('common_regex_interval').'/', I('name')) == 1) ? true : false;
	}
}
?>