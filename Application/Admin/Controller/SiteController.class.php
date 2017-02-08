<?php

namespace Admin\Controller;

/**
 * 站点设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class SiteController extends CommonController
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

		// 登录校验
		$this->Is_Login();

		// 权限校验
		$this->Is_Power();
	}

	/**
     * [Index 配置列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 学期
		$semester_list = M('Semester')->field(array('id', 'name'))->where(array('is_enable'=>1))->order('id desc')->select();
		$this->assign('semester_list', $semester_list);

		// csv
		$this->assign('common_excel_charset_list', L('common_excel_charset_list'));

		// 配置信息
		$data = M('Config')->getField('only_tag,name,describe,value,error_tips');
		$this->assign('data', $data);
		
		$this->display('Index');
	}

	/**
	 * [Save 数据保存]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-02T23:08:19+0800
	 */
	public function Save()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数校验
		if(empty($_POST))
		{
			$this->error(L('common_param_error'));
		}

		// 循环保存数据
		$success = 0;
		$c = M('Config');
		foreach($_POST as $k=>$v)
		{
			if($c->where(array('only_tag'=>$k))->save(array('value'=>$v)))
			{
				$success++;
			}
		}
		if($success > 0)
		{
			// 配置信息更新
			$this->MyConfigInit(1);

			$this->ajaxReturn(L('common_operation_edit_success').'['.$success.']');
		} else {
			$this->ajaxReturn(L('common_operation_edit_error'), -100);
		}
	}
}
?>