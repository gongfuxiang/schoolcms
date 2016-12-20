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

	// 左边权限菜单
	protected $left_menu;

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
		// 权限
		$this->PowerInit();

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
				// success模式下code=0, error模式下code参数-1
				$data = array('msg'=>$msg['info'], 'code'=>-1, 'data'=>'');
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
			$this->error(L('common_login_invalid'), U('Admin/Admin/LoginInfo'));
		} else {
			// 用户
			$this->user = I('session.user');
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

		// 权限菜单
		$this->assign('left_menu', $this->left_menu);
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
		$role_id = isset($_SESSION['user']['role_id']) ? $_SESSION['user']['role_id'] : 0;
		if(!empty($role_id) && empty($_SESSION['left_menu']))
		{
			$p = M('Power');
			$field = array('p.id', 'p.name', 'p.control', 'p.action', 'p.is_view');
			$this->left_menu = $p->alias('p')->join('__ROLE_POWER__ AS rp ON p.id = rp.power_id')->where(array('rp.role_id'=>$role_id, 'p.pid'=>0))->field($field)->order('p.sort')->select();
			if(!empty($this->left_menu))
			{
				foreach($this->left_menu as $k=>$v)
				{
					// 权限
					$this->power[$v['id']] = $v['control'].'_'.$v['action'];

					// 获取子权限
					$item = $p->alias('p')->join('__ROLE_POWER__ AS rp ON p.id = rp.power_id')->where(array('rp.role_id'=>$role_id, 'p.pid'=>$v['id']))->field($field)->order('p.sort')->select();

					// 权限列表
					if(!empty($item))
					{
						foreach($item as $ks=>$vs)
						{
							// 权限
							$this->power[$vs['id']] = $vs['control'].'_'.$vs['action'];

							// 是否显示视图
							if($vs['is_view'] == 1)
							{
								// url
								$item[$ks]['url'] = U('Admin/'.$vs['control'].'/'.$vs['action']);
							} else {
								unset($item[$ks]);
							}
						}
					}

					// 是否显示视图
					if($v['is_view'] == 1)
					{
						// url
						$this->left_menu[$k]['url'] = U('Admin/'.$v['control'].'/'.$v['action']);

						// 子级
						$this->left_menu[$k]['item'] = $item;
					} else {
						unset($this->left_menu[$k]);
					}
				}
			}
			// 存储session
			$_SESSION['left_menu'] 	=	$this->left_menu;
			$_SESSION['power'] 		=	$this->power;
		} else {
			$this->left_menu 	=	I('session.left_menu');
			$this->power 		=	I('session.power');
		}
	}

	/**
	 * [Is_Power 是否有权限]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-20T19:18:29+0800
	 */
	protected function Is_Power()
	{
		if(!in_array(CONTROLLER_NAME.'_'.ACTION_NAME, $this->power))
		{
			$this->error(L('common_there_is_no_power'));
		}
	}
}
?>