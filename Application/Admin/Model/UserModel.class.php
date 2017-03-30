<?php

namespace Admin\Model;
use Think\Model;

/**
 * 用户模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('nickname', 'CheckNickName', '{%user_nickname_format}', 2, 'callback', 3),
		array('gender', array(0,1,2), '{%common_gender_tips}', 2, 'in', 3),
		array('birthday', 'CheckBirthday', '{%user_birthday_format}', 2, 'callback', 3),
		array('signature', 'CheckSignature', '{%user_signature_format}', 2, 'callback', 3),
		array('describe', 'CheckDescribe', '{%user_describe_format}', 2, 'callback', 3),
		array('mobile', 'CheckMobile', '{%common_mobile_format_error}', 2, 'callback', 3),
		array('email', 'CheckEmail', '{%common_email_format_error}', 2, 'callback', 3),
		array('mobile', '', '{%common_mobile_exist_error}', 2, 'unique', 3),
		array('email', '', '{%common_email_exist_error}', 2, 'unique', 3),

		// 添加
		array('pwd', 'CheckLoginPwd', '{%user_login_pwd_format}', 1, 'function', 1),

		// 编辑
		array('pwd', 'CheckLoginPwd', '{%user_login_pwd_format}', 2, 'function', 2),
	);

	/**
	 * [CheckNickName 昵称校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckNickName()
	{
		$len = Utf8Strlen(I('nickname'));
		return ($len <= 16);
	}

	/**
	 * [CheckBirthday 生日校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckBirthday()
	{
		return (preg_match('/'.L('common_regex_birthday').'/', I('birthday')) == 1) ? true : false;
	}

	/**
	 * [CheckSignature 个人签名校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckSignature()
	{
		$len = Utf8Strlen(I('signature'));
		return ($len <= 168);
	}

	/**
	 * [CheckDescribe 个人描述校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckDescribe()
	{
		$len = Utf8Strlen(I('describe'));
		return ($len <= 255);
	}

	/**
	 * [CheckMobile 手机号码校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckMobile()
	{
		return (preg_match('/'.L('common_regex_mobile').'/', I('mobile')) == 1) ? true : false;
	}

	/**
	 * [CheckEmail 电子邮箱校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckEmail()
	{
		return (preg_match('/'.L('common_regex_email').'/', I('email')) == 1) ? true : false;
	}
}
?>