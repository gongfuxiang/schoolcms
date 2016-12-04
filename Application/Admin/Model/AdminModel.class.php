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
		
		// 登录校验
		//array('username', '/^1((3|5|8){1}\d{1}|70)\d{8}$/', '用户名格式错误', 1, 'regex', 4),
		array('username', 'CheckUserName', '用户名格式 6~18 个字符（可以是字母数字下划线）', 1, 'function', 4),
		array('login_pwd', 'CheckLoginPwd', '密码格式 6~18 个字符', 1, 'function', 4),

	);
}
?>