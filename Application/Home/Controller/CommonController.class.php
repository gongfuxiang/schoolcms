<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 前台
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CommonController extends Controller
{
	// 顶部导航
	protected $nav_header;

	// 底部导航
	protected $nav_footer;

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
		// 菜单
		$this->NavInit();

		// 视图初始化
		$this->ViewInit();

		// 配置信息初始化
		$this->MyConfigInit();
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
				$result = array('msg'=>$msg['info'], 'code'=>-1, 'data'=>'');
			}
		}
		
		// 默认情况下，手动调用当前方法
		if(empty($result))
		{
			$result = array('msg'=>$msg, 'code'=>$code, 'data'=>$data);
		}

		// 错误情况下，防止提示信息为空
		if($result['code'] != 0 && empty($result['msg']))
		{
			$result['msg'] = L('common_operation_error');
		}
		exit(json_encode($result));
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

		// 导航
		$this->assign('nav_header', $this->nav_header);
		$this->assign('nav_footer', $this->nav_footer);

		// 当前页面选择导航状态
		$nav_pid	=	0;
		$nav_id 	=	0;
		foreach($this->nav_header as $v)
		{
			if(I('viewid') == $v['id'])
			{
				$nav_id = $v['id'];
			}
			if(!empty($v['item']))
			{
				foreach($v['item'] as $vs)
				{
					if(I('viewid') == $vs['id'])
					{
						$nav_pid = $v['id'];
						$nav_id = $vs['id'];
					}
				}
			}
		}
		$this->assign('nav_pid', $nav_pid);
		$this->assign('nav_id', $nav_id);
	}

	/**
	 * [NavInit 导航初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-19T22:41:20+0800
	 */
	private function NavInit()
	{
		// 读取缓存数据
		$this->nav_header = S(C('common_home_nav_header_key'));
		$this->nav_footer = S(C('common_home_nav_footer_key'));

		// 导航模型
		$m = M('Navigation');
		$field = array('id', 'pid', 'name', 'url', 'value', 'data_type', 'is_new_window_open');

		// 缓存没数据则从数据库重新读取,顶部菜单
		if(empty($this->nav_header))
		{
			$this->nav_header = NavDataDealWith($m->field($field)->where(array('nav_type'=>'header', 'pid'=>0))->order('sort')->select());
			if(!empty($this->nav_header))
			{
				foreach($this->nav_header as $k=>$v)
				{
					$this->nav_header[$k]['item'] = NavDataDealWith($m->field($field)->where(array('nav_type'=>'header', 'pid'=>$v['id']))->order('sort')->select());
				}
			}
			S(C('common_home_nav_header_key'), $this->nav_header);
		}

		// 底部导航
		if(empty($this->nav_footer))
		{
			$this->nav_footer = NavDataDealWith($m->field($field)->where(array('nav_type'=>'footer'))->order('sort')->select());
			S(C('common_home_nav_footer_key'), $this->nav_footer);
		}
	}

	/**
	 * [MyConfigInit 系统配置信息初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-03T21:36:55+0800
	 * @param    [int] $state [是否更新数据,0否,1是]
	 */
	protected function MyConfigInit($state = 0)
	{
		$key = C('common_my_config_key');
		$data = S($key);
		if($state == 1 || empty($data))
		{
			$data = M('Config')->getField('only_tag,value');
			S($key, $data);
		}
	}

	/**
	 * [GetClassList 获取班级列表,二级]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-30T13:26:00+0800
	 * @return [array] [班级列表]
	 */
	protected function GetClassList()
	{
		$m = M('Class');
		$data = $m->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>0))->select();
		if(!empty($data))
		{
			foreach($data as $k=>$v)
			{
				$data[$k]['item'] = $m->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>$v['id']))->select();
			}
		}
		return $data;
	}

	/**
	 * [GetRoomList 获取教室列表,二级]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-30T13:26:00+0800
	 * @return [array] [班级列表]
	 */
	protected function GetRoomList()
	{
		$m = M('Room');
		$data = $m->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>0))->select();
		if(!empty($data))
		{
			foreach($data as $k=>$v)
			{
				$data[$k]['item'] = $m->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>$v['id']))->select();
			}
		}
		return $data;
	}
}
?>