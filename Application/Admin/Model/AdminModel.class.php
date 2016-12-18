<?php

namespace Admin\Model;
use Think\Model;

/**
 * 管理员模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class AdminModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 登录
		array('username', 'CheckUserName', '{%login_username_format}', 1, 'function', 4),
		array('login_pwd', 'CheckLoginPwd', '{%login_login_pwd_format}', 1, 'function', 4),

		// 注册
		array('username', '', '{%common_username_already_exist}', 1, 'unique', 1),
		array('login_pwd', 'CheckLoginPwd', '{%login_login_pwd_format}', 1, 'function', 1),

		// 编辑
		array('login_pwd', 'CheckLoginPwd', '{%login_login_pwd_format}', 2, 'function', 2),
		
		// 注册,编辑
		array('mobile', 'CheckMobile', '{%common_mobile_format_error}', 2, 'function', 3),
		array('gender', array(0,1,2), '{%common_gender_tips}', 1, 'in', 3),

		// 删除
		array('id', 'IsExistAdmin', '{%login_username_no_exist}', 1, 'callback', 5),
	);

	/**
	 * [IsExistAdmin 校验管理员是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 */
	public function IsExistAdmin()
	{
		$user = $this->db(0)->where(array('id'=>I('id')))->getField('id');
		return !empty($user);
	}
}
?>