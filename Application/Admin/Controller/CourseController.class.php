<?php

namespace Admin\Controller;

/**
 * 教师课程管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CourseController extends CommonController
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
     * [Index 教师课程列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 参数
		$param = array_merge($_POST, $_GET);

		// 模型对象
		$m = M('Course');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('page_number');
		$total = $m->alias('AS c')->join(' INNER JOIN __TEACHER__ AS t ON c.teacher_id = t.id INNER JOIN __CLASS__ AS cs ON c.class_id = cs.id INNER JOIN __SUBJECT__ AS s ON c.subject_id = s.id INNER JOIN __WEEK__ AS w ON c.week_id = w.id INNER JOIN __INTERVAL__ AS i ON c.interval_id = i.id')->where($where)->count();
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$param,
				'url'		=>	U('Admin/Fraction/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$field = array('c.id, t.username AS teacher_name', 'cs.name AS class_name', 's.name AS subject_name', 'w.name AS week_name', 'i.name AS interval_name');
		$list = $m->alias('AS c')->join(' INNER JOIN __TEACHER__ AS t ON c.teacher_id = t.id INNER JOIN __CLASS__ AS cs ON c.class_id = cs.id INNER JOIN __SUBJECT__ AS s ON c.subject_id = s.id INNER JOIN __WEEK__ AS w ON c.week_id = w.id INNER JOIN __INTERVAL__ AS i ON c.interval_id = i.id')->where($where)->field($field)->limit($page->GetPageStarNumber(), $number)->select();

		// 数据列表
		$this->assign('list', $list);

		// 字段
		$field = array('id', 'name');

		// 条件
		$where = array('is_enable'=>1);

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 周天
		$this->assign('week_list', M('Week')->field($field)->where($where)->select());

		// 科目
		$this->assign('subject_list', M('Subject')->field($field)->where($where)->select());

		// 时段
		$this->assign('interval_list', M('Interval')->field($field)->where($where)->select());

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		$this->display();
	}

	/**
	 * [GetIndexWhere 教师课程列表条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T22:16:29+0800
	 */
	private function GetIndexWhere()
	{
		$where = array();

		// 模糊
		if(!empty(I('keyword')))
		{
			$where['t.username'] = array('like', '%'.I('keyword').'%');
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 等值
			if(I('class_id', 0) > 0)
			{
				$where['c.class_id'] = intval(I('class_id'));
			}
			if(I('week_id', 0) > 0)
			{
				$where['c.week_id'] = intval(I('week_id'));
			}
			if(I('subject_id', 0) > 0)
			{
				$where['c.subject_id'] = intval(I('subject_id'));
			}
			if(I('interval_id', 0) > 0)
			{
				$where['c.interval_id'] = intval(I('interval_id'));
			}
		}
		return $where;
	}

	/**
	 * [SaveInfo 教师课程添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 课程信息
		if(empty(I('id')))
		{
			$data = array('teacher_id'=>I('teacher_id'));
			$request_url = U('Admin/Teacher/Index');
		} else {
			$data = M('Course')->find(I('id'));
			$request_url = U('Admin/Course/Index');
		}
		$this->assign('request_url', $request_url);
		$this->assign('data', $data);

		// 字段
		$field = array('id', 'name');

		// 条件
		$where = array('is_enable'=>1);

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 周天
		$this->assign('week_list', M('Week')->field($field)->where($where)->select());

		// 科目
		$this->assign('subject_list', M('Subject')->field($field)->where($where)->select());

		// 时段
		$this->assign('interval_list', M('Interval')->field($field)->where($where)->select());

		$this->display();
	}

	/**
	 * [Save 教师课程添加/编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function Save()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 添加
		if(empty(I('id')))
		{
			$this->Add();

		// 编辑
		} else {
			$this->Edit();
		}
	}

	/**
	 * [Add 教师课程添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 教师课程模型
		$m = D('Course');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 数据是否已存在
			$where = array(
					'teacher_id'	=>	I('teacher_id'),
					'class_id'		=>	I('class_id'),
					'subject_id'	=>	I('subject_id'),
					'week_id'		=>	I('week_id'),
					'interval_id'	=>	I('interval_id'),
				);
			$tmp = $m->where($where)->getField('id');
			if(!empty($tmp))
			{
				$this->ajaxReturn(L('common_data_is_exist_error'), -2);
			}
			
			// 额外数据处理
			$m->add_time	=	time();
			
			// 写入数据库
			if($m->add())
			{
				$this->ajaxReturn(L('common_operation_add_success'));
			} else {
				$this->ajaxReturn(L('common_operation_add_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Edit 教师课程编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		// 教师课程模型
		$m = D('Course');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			// 移除 id
			unset($m->id, $m->teacher_id);

			// 更新数据库
			if($m->where(array('id'=>I('id'), 'teacher_id'=>I('teacher_id')))->save())
			{
				$this->ajaxReturn(L('common_operation_edit_success'));
			} else {
				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		}
	}

	/**
	 * [Delete 教师课程删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-15T11:03:30+0800
	 */
	public function Delete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数处理
		if(empty(I('id')))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 删除数据
		if(M('Course')->delete(I('id')))
		{
			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}
}
?>