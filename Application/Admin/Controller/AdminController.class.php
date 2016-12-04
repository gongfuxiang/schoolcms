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
        parent::_initialize();
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
		/*$db = D('Admin');
		print_r($db->select());*/


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
		$admin = D('Admin');
		if($admin->create($_POST, 4))
		{
			exit('ok');
		}else{
			$this->ajaxReturn($admin->getError(), -1);
		}
	}
}
?>