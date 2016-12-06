<?php

namespace Admin\Controller;

/**
 * 管理员
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class AdminController extends CommonController
{
	/**
	 * [_initialize 前置操作-继承公共前置方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:39:08+0800
	 */
	public function _initialize()
	{
		// 调用父类前置方法
        parent::_initialize();
    }

    /**
     * [Index 管理员列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function Index()
    {
    	$this->display();
    }

    /**
     * [SaveInfo 管理员编辑及添加页面]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function SaveInfo()
    {
    	$this->display();
    }

    /**
     * [LoginInfo 登录页面]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:55:53+0800
     */
	public function LoginInfo()
	{
		// 是否已登录
		if(!empty($_SESSION['user']))
		{
			redirect(U('/Admin/Index/Index'));
		}

		$this->display();
	}

	/**
	 * [Login 管理员登录]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T21:46:49+0800
	 */
	public function Login()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'), U('/Admin/Index/Index'));
		}

		// 登录业务处理
		$db = D('Admin');
		if($db->create($_POST, 4))
		{
			// 获取管理员
			$user = $db->field('id,username,login_pwd,login_salt,mobile')->where(array('username'=>I('username')))->find();
			if(empty($user))
			{
				$this->ajaxReturn(ReturnData(L('login_username_no_exist'), -2));
			}

			// 密码校验
			$login_pwd = LoginPwdEncryption(I('login_pwd'), $user['login_salt']);
			if($login_pwd != $user['login_pwd'])
			{
				$this->ajaxReturn(ReturnData(L('login_login_pwd_error'), -3));
			}

			// 校验成功
			// session存储
			unset($user['login_pwd'], $user['login_salt']);
			$_SESSION['user'] = $user;

			// 返回数据
			if(empty($_SESSION['user']))
			{
				$this->ajaxReturn(ReturnData(L('login_login_error'), -100));
			} else {
				$this->ajaxReturn(ReturnData(L('login_login_success')));
			}
		} else {
			// 自动验证失败
			$this->ajaxReturn(ReturnData($db->getError(), -1));
		}
	}

	/**
	 * [Logout 退出]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-05T14:31:23+0800
	 */
	public function Logout()
	{
		session_destroy();
		redirect(U('/Admin/Index/Index'));
	}
}
?>