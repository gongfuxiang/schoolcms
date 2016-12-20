<?php

namespace Admin\Model;
use Think\Model;

/**
 * 权限模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class PowerModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('name', 'CheckName', '{%power_name_format}', 1, 'callback', 3),
		array('control', 'CheckControl', '{%power_control_format}', 1, 'callback', 3),
		array('action', 'CheckAction', '{%power_action_format}', 1, 'callback', 3),
		array('pid', 'CheckPid', '{%power_level_format}', 2, 'callback', 3),

		// 删除
		array('id', 'CheckPowerIsExist', '{%power_no_exist_tips}', 1, 'callback', 5),
		array('id', 'CheckPowerIsItem', '{%power_exist_item_tips}', 1, 'callback', 5),
	);

	/**
	 * [CheckName 权限名称校验]
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

	/**
	 * [CheckAction 方法校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckAction()
	{
		return (preg_match('/'.L('common_regex_action').'/', I('action')) == 1) ? true : false;
	}

	/**
	 * [CheckControl 控制器校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckControl()
	{
		return (preg_match('/'.L('common_regex_control').'/', I('control')) == 1) ? true : false;
	}

	/**
	 * [CheckPid pid校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:32:40+0800
	 */
	public function CheckPid()
	{
		$pid = intval(I('pid'));
		if($pid > 0)
		{
			$id = $this->db(0)->where(array('id'=>$pid))->getField('id');
			return !empty($id);
		}
		return true;
	}

	/**
	 * [CheckPowerIsExist 校验权限是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 */
	public function CheckPowerIsExist()
	{
		$id = $this->db(0)->where(array('id'=>I('id')))->getField('id');
		return !empty($id);
	}

	/**
	 * [CheckPowerIsItem 校验权限是否存在子级]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 */
	public function CheckPowerIsItem()
	{
		$count = $this->db(0)->where(array('pid'=>I('id')))->count();
		return ($count <= 0);
	}
}
?>