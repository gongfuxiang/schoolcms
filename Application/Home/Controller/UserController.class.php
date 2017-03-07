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
	// 上一个页面url地址
	private $referer_url;

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

		// 上一个页面, 空则用户中心
		$this->referer_url = empty($_SERVER['HTTP_REFERER']) ? U('Home/User/Index') : $_SERVER['HTTP_REFERER'];
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
			$this->assign('referer_url', $this->referer_url);
			$this->display('RegInfo');
		} else {
			$this->assign('msg', L('common_close_user_reg_tips'));
			$this->display('/Public/TipsError');
		}
	}

	/**
	 * [Reg 用户注册]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T00:08:36+0800
	 */
	public function Reg()
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
		
		// 模型
		$m = D('User');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 额外数据处理
			$m->add_time	=	time();
			$m->upd_time	=	time();
			$m->salt 		=	GetNumberCode(6);
			$m->pwd 		=	LoginPwdEncryption(I('pwd'), $m->salt);

			// 数据添加
			if($m->add())
			{
				$this->ajaxReturn(L('common_reg_success'));
			} else {
				$this->ajaxReturn(L('common_reg_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
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
			$this->assign('referer_url', $this->referer_url);
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

		// 验证码公共基础参数
		$verify_param = array(
				'key_prefix' => 'reg',
				'expire_time' => MyC('common_sms_expire_time')
			);

		// 是否开启图片验证码
		if(MyC('home_user_reg_img_verify_state') == 1)
		{
			if(empty($_POST['verify']))
			{
				$this->ajaxReturn(L('common_param_error'), -1);
			}
			$verify = new \My\Verify($verify_param);
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
		$sms = new \My\Sms($verify_param);
		$code = GetNumberCode(6);
		if($sms->SendText(I('mobile'), MyC('home_sms_user_reg'), $code))
		{
			$this->ajaxReturn(L('common_send_success'));
		} else {
			$this->ajaxReturn(L('common_send_error').'['.$sms->error.']', -100);
		}
	}
}
?>