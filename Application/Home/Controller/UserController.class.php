<?php

namespace Home\Controller;

/**
 * 用户
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-03-02T22:48:35+0800
 */
class UserController extends CommonController
{
	/**
	 * [_initialize 前置操作-继承公共前置方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function _initialize()
	{
		// 调用父类前置方法
		parent::_initialize();
	}

	/**
	 * [Index 用户中心]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function Index()
	{
		$this->display('Index');
	}

	/**
	 * [RegInfo 用户注册页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function RegInfo()
	{
		if(MyC('home_user_reg_state') == 1)
		{
			$this->display('RegInfo');
		} else {
			$this->assign('msg', L('common_close_user_reg_tips'));
			$this->display('/Public/TipsError');
		}
	}

	/**
	 * [LoginInfo 用户登录页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function LoginInfo()
	{
		if(MyC('home_user_login_state') == 1)
		{
			$this->display('LoginInfo');
		} else {
			$this->assign('msg', L('common_close_user_login_tips'));
			$this->display('/Public/TipsError');
		}
	}

	/**
	 * [RegVerifyEntry 用户注册-验证码显示]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-05T15:10:21+0800
	 */
	public function RegVerifyEntry()
	{
		// 是否开启用户注册
		if(MyC('home_user_reg_state') == 1)
		{
			$param = array(
					'width' => 100,
					'height' => 32,
					'key_prefix' => 'reg',
				);
			$verify = new \My\Verify($param);
			$verify->Entry();
		}
	}

	/**
	 * [RegSmsSend 用户注册-短信验证码发送]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-05T19:17:10+0800
	 */
	public function RegSmsSend()
	{
		// 是否开启用户注册
		if(MyC('home_user_reg_state') != 1)
		{
			$this->error(L('common_close_user_reg_tips'));
		}

		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数
		if(empty($_POST['mobile']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 是否开启图片验证码
		if(true)
		{
			if(empty($_POST['verify']))
			{
				$this->ajaxReturn(L('common_param_error'), -1);
			}
			$verify = new \My\Verify(array('key_prefix'=>'reg'));
			if(!$verify->CheckExpire())
			{
				$this->ajaxReturn(L('common_verify_expire'), -2);
			}
			if(!$verify->CheckCorrect(I('verify')))
			{
				$this->ajaxReturn(L('common_verify_error'), -3);
			}
		}

		// 手机号码格式
		if(!CheckMobile(I('mobile')))
		{
			$this->ajaxReturn(L('common_mobile_format_error'), -4);
		}

		// 发送短信验证码
		$code = GetNumberCode(6);
		$content = str_replace('{code}', $code, MyC('common_sms_registered'));
		//if(Sms_Code_Send($content, I('mobile')))
		if(true)
		{
			$this->ajaxReturn(L('common_send_success'));
		} else {
			$this->ajaxReturn(L('common_send_error'), -100);
		}
	}
}
?>