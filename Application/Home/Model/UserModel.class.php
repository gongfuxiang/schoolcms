<?php

namespace Home\Model;
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
		// 注册
		array('mobile', 'CheckMobile', '{%common_mobile_format_error}', 1, 'function', 1),
		array('verify', 'CheckVerifyExpire', '{%common_verify_expire}', 1, 'callback', 1),
		array('verify', 'CheckVerifyCorrect', '{%common_verify_error}', 1, 'callback', 1),
		array('pwd', 'CheckLoginPwd', '{%user_reg_pwd_format}', 1, 'function', 1),

		// 登录
		array('mobile', 'CheckMobile', '{%common_mobile_format_error}', 1, 'function', 4),
		array('pwd', 'CheckLoginPwd', '{%user_reg_pwd_format}', 1, 'function', 4),
		array('pwd', 'CheckPwdCorrect', '{%user_common_pwd_error}', 1, 'callback', 4),
	);

	/**
	 * [CheckVerifyExpire 验证码是否过期校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T10:29:47+0800
	 */
	public function CheckVerifyExpire()
	{
		// 验证码公共基础参数
		$verify_param = array(
				'key_prefix' => 'reg',
				'expire_time' => MyC('common_sms_expire_time')
			);
		$sms = new \My\Sms($verify_param);
		return $sms->CheckExpire();
	}

	/**
	 * [CheckVerifyCorrect 验证码是否正确校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T10:29:47+0800
	 */
	public function CheckVerifyCorrect()
	{
		// 验证码公共基础参数
		$verify_param = array(
				'key_prefix' => 'reg',
				'expire_time' => MyC('common_sms_expire_time')
			);
		$sms = new \My\Sms($verify_param);
		return $sms->CheckCorrect(I('code'));
	}

	/**
	 * [CheckPwdCorrect 密码是否正确校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T10:29:47+0800
	 */
	public function CheckPwdCorrect()
	{
		
	}
}
?>