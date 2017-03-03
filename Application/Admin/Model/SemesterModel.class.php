<?php

namespace Admin\Model;
use Think\Model;

/**
 * 学期模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class SemesterModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(
		// 添加,编辑
		array('name', 'CheckName', '{%common_name_format}', 1, 'callback', 3),
		array('is_enable', array(0,1), '{%common_enable_tips}', 1, 'in', 3),
		array('sort', 'CheckSort', '{%common_sort_error}', 1, 'function', 3),
	);

	/**
	 * [CheckName 学期名称校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckName()
	{
		$len = Utf8Strlen(I('name'));
		return ($len >= 2 && $len <= 16);
	}
}
?>