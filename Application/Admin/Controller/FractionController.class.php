<?php

namespace Admin\Controller;

/**
 * 学生成绩管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class FractionController extends CommonController
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
     * [Index 权限组列表]
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
	 * [SaveInfo 学生成绩添加页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 参数
		if(empty(I('id')))
		{
			$this->error(L('common_param_error'));
		}

		// 学生信息
		$student = M('Student')->field(array('id', 'username'))->find(I('id'));
		if(empty($student))
		{
			$this->error(L('fraction_student_error'));
		}
		$this->assign('student', $student);

		// 成绩
		$this->assign('score_list', M('Score')->select());

		// 科目
		$this->assign('subject_list', M('Subject')->select());

		$this->display();
	}
}
?>