<?php

namespace Admin\Controller;
use Think\Controller;

/**
 * 管理员
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CommonController extends Controller
{
	// 用户
	protected $user;

	// 权限
	protected $power;

	/**
	 * [__construt 构造方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:29:53+0800
	 * @param    [string]       $msg  [提示信息]
	 * @param    [int]          $code [状态码]
	 * @param    [mixed]        $data [数据]
	 */
	protected function _initialize()
	{
		// 视图初始化
		$this->ViewInit();
	}

	/**
	 * [ajaxReturn 重写ajax返回方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-07T22:03:40+0800
	 * @param    [string]       $msg  [提示信息]
	 * @param    [int]          $code [状态码]
	 * @param    [mixed]        $data [数据]
	 * @return   [json]               [json数据]
	 */
	protected function ajaxReturn($msg = '', $code = 0, $data = '')
	{
		// ajax的时候，success和error错误由当前方法接收
		if(IS_AJAX)
		{
			if(isset($msg['info']))
			{
				// success模式下code=0, error模式下使用url为code参数, error模式下未指定code默认-1
				$code = (isset($msg['status']) && $msg['status'] == 1) ? 0 : (empty($msg['url']) ? -1 : $msg['url']);
				$data = array('msg'=>$msg['info'], 'code'=>$code, 'data'=>'');
			}
		}
		
		// 默认情况下，手动调用当前方法
		if(empty($data))
		{
			$data = array('msg'=>$msg, 'code'=>$code, 'data'=>$data);
		}

		// 错误情况下，防止提示信息为空
		if($data['code'] != 0 && empty($data['msg']))
		{
			$data['msg'] = L('common_operation_error');
		}
		exit(json_encode($data));
	}

	/**
	 * [Is_Login 登录校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:42:35+0800
	 */
	protected function Is_Login()
	{
		if(empty($_SESSION['user']))
		{
			if(IS_AJAX)
			{
				$this->ajaxReturn(L('common_login_invalid'), -400);
			} else {
				redirect(U('Admin/Admin/LoginInfo'));
			}
		} else {
			// 用户
			$this->user = I('session.user');

			// 权限
			$this->PowerInit();
		}
	}

	/**
	 * [ViewInit 视图初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:30:06+0800
	 */
	public function ViewInit()
	{
		// 控制器静态文件状态css,js
		$module_css = MODULE_NAME.DS.'Css'.DS.CONTROLLER_NAME.'.css';
		$this->assign('module_css', file_exists(ROOT_PATH.'Public'.DS.$module_css) ? $module_css : '');
		$module_js = MODULE_NAME.DS.'Js'.DS.CONTROLLER_NAME.'.js';
		$this->assign('module_js', file_exists(ROOT_PATH.'Public'.DS.$module_js) ? $module_js : '');
	}

	/**
	 * [PowerInit 权限初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-19T22:41:20+0800
	 */
	private function PowerInit()
	{
		$p = M('Power');
		$list = $p->alias('p')->join('__ROLE_POWER__ AS rp ON p.id = rp.power_id')->where(array('rp.role_id'=>$this->user['role_id']))->field(array('p.id', 'p.name', 'p.control', 'p.action'))->select();

		//print_r($list);
	}
}
?>