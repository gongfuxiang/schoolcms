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
	protected $_validate = array(
		//array('username', '', '帐号已经存在', 0, 'unique', 1),
		//array('password', 'checkPwd', '密码格式错误，需要6~18个字符', 1, 'function'),
		
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
		array('gender', array(0,1,2), '值的范围不正确！', 1, 'in', 3),
	);
}
?>