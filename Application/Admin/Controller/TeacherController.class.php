<?php

namespace Admin\Controller;

/**
 * 教师管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class TeacherController extends CommonController
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
     * [Index 教师列表]
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
		$m = M('Teacher');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('admin_page_number');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$m->where($where)->count(),
				'where'		=>	$param,
				'url'		=>	U('Admin/Teacher/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$list = $this->SetDataHandle($m->where($where)->limit($page->GetPageStarNumber(), $number)->select());

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 教师状态
		$this->assign('common_teacher_state_list', L('common_teacher_state_list'));

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// 数据列表
		$this->assign('list', $list);

		// Excel地址
		$this->assign('excel_url', U('Admin/Teacher/ExcelExport', $param));

		$this->display('Index');
	}

	/**
	 * [ExcelExport excel文件导出]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-10T15:46:00+0800
	 */
	public function ExcelExport()
	{
		// 条件
		$where = $this->GetIndexWhere();

		// 读取数据
		$data = $this->SetDataHandle(M('Teacher')->where($where)->select());

		// Excel驱动导出数据
		$excel = new \My\Excel(array('filename'=>'teacher', 'title'=>L('excel_teacher_title_list'), 'data'=>$data, 'msg'=>L('common_not_data_tips')));
		$excel->Export();
	}

	/**
	 * [SetDataHandle 数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-29T21:27:15+0800
	 * @param    [array]      $data [教师数据]
	 * @return   [array]            [处理好的数据]
	 */
	private function SetDataHandle($data)
	{
		if(!empty($data))
		{
			$ts = M('TeacherSubject');
			foreach($data as $k=>$v)
			{
				// 出生
				$data[$k]['birthday'] = date('Y-m-d', $v['birthday']);

				// 创建时间
				$data[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);

				// 更新时间
				$data[$k]['upd_time'] = date('Y-m-d H:i:s', $v['upd_time']);

				// 性别
				$data[$k]['gender'] = L('common_gender_list')[$v['gender']]['name'];

				// 状态
				$data[$k]['state'] = L('common_teacher_state_list')[$v['state']]['name'];

				// 贯通科目
				$temp = $ts->alias('AS ts')->join('__SUBJECT__ AS s ON ts.subject_id = s.id')->where(array('ts.teacher_id'=>$v['id']))->field(array('s.name AS name'))->getField('name', true);
				$data[$k]['subject_list'] = empty($temp) ? '' : implode(', ', $temp);
			}
		}
		return $data;
	}

	/**
	 * [GetIndexWhere 教师列表条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T22:16:29+0800
	 */
	private function GetIndexWhere()
	{
		$where = array();

		// 模糊
		if(!empty($_REQUEST['keyword']))
		{
			$like_keyword = array('like', '%'.I('keyword').'%');
			$where[] = array(
					'username'	=>	$like_keyword,
					'id_card'	=>	$like_keyword,
					'tel'		=>	$like_keyword,
					'mobile'	=>	$like_keyword,
					'address'	=>	$like_keyword,
					'email'		=>	$like_keyword,
					'_logic'	=>	'or',
				);
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 等值
			if(I('gender', -1) > -1)
			{
				$where['gender'] = intval(I('gender', 0));
			}
			if(I('state', -1) > -1)
			{
				$where['state'] = intval(I('state', 0));
			}

			// 表达式
			if(!empty($_REQUEST['time_start']))
			{
				$where['birthday'][] = array('gt', strtotime(I('time_start')));
			}
			if(!empty($_REQUEST['time_end']))
			{
				$where['birthday'][] = array('lt', strtotime(I('time_end')));
			}
		}
		return $where;
	}

	/**
	 * [SaveInfo 教师添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 教师信息
		$data = empty($_REQUEST['id']) ? array() : M('Teacher')->find(I('id'));
		if(!empty($data['birthday']))
		{
			$data['birthday'] = date('Y-m-d', $data['birthday']);

			// 科目关联数据
			$data['subject_id'] = M('TeacherSubject')->where(array('teacher_id'=>$data['id']))->getField('subject_id', true);
		}
		$this->assign('data', $data);

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 教师状态
		$this->assign('common_teacher_state_list', L('common_teacher_state_list'));

		// 科目列表
		$this->assign('subject_list', M('Subject')->field(array('id', 'name'))->where(array('is_enable'=>1))->select());		

		$this->display('SaveInfo');
	}

	/**
	 * [Save 教师添加/编辑]
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

		// 贯通科目参数处理
		if(!empty($_POST['subject_id']))
		{
			$_POST['subject_id'] = explode(',', $_POST['subject_id']);
		} else {
			$this->ajaxReturn(L('teacher_subject_format'), -2);
		}

		// 添加
		if(empty($_POST['id']))
		{
			$this->Add();

		// 编辑
		} else {
			$this->Edit();
		}
	}

	/**
	 * [Add 教师添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 教师对象
		$m = D('Teacher');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 额外数据处理
			$m->add_time	=	time();
			$m->upd_time	=	time();
			$m->birthday	=	strtotime($m->birthday);
			$m->username 	=	I('username');
			$m->address 	=	I('address');

			// 开启事务
			$m->startTrans();
			
			// 教师写入数据库
			$teacher_id = $m->add();

			// 添加教师科目关联数据
			$ts_state = true;
			$ts = M('TeacherSubject');
			foreach($_POST['subject_id'] as $subject_id)
			{
				if(!empty($subject_id))
				{
					$temp_data = array(
							'teacher_id'	=>	$teacher_id,
							'subject_id'	=>	$subject_id,
							'add_time'		=>	time(),
						);
					if(!$ts->add($temp_data))
					{
						$ts_state = false;
						break;
					}
				}
			}
			if($teacher_id && $ts_state)
			{
				// 提交事务
				$m->commit();

				$this->ajaxReturn(L('common_operation_add_success'));
			} else {
				// 回滚事务
				$m->rollback();

				$this->ajaxReturn(L('common_operation_add_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Edit 教师编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		// 教师对象
		$m = D('Teacher');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			// 额外数据处理
			if(!empty($m->birthday))
			{
				$m->birthday	=	strtotime($m->birthday);
			}
			$m->username 	=	I('username');
			$m->address 	=	I('address');
			$m->upd_time	=	time();

			// 移除不能更新的数据
			unset($m->id_card);

			// 开启事务
			$m->startTrans();

			// 教师id
			$teacher_id = I('id');

			// 更新教师
			$t_state = $m->where(array('id'=>$teacher_id, 'id_card'=>I('id_card')))->save();

			// 删除教师科目关联数据
			$ts = M('TeacherSubject');
			$ts_state_del = $ts->where(array('teacher_id'=>$teacher_id))->delete();

			// 添加教师科目关联数据
			$ts_state = true;
			foreach($_POST['subject_id'] as $subject_id)
			{
				if(!empty($subject_id))
				{
					$temp_data = array(
							'teacher_id'	=>	$teacher_id,
							'subject_id'	=>	$subject_id,
							'add_time'		=>	time(),
						);
					if(!$ts->add($temp_data))
					{
						$ts_state = false;
						break;
					}
				}
			}
			if($t_state !== false && $ts_state_del !== false && $ts_state !== false)
			{
				// 提交事务
				$m->commit();

				$this->ajaxReturn(L('common_operation_edit_success'));
			} else {
				// 回滚事务
				$m->rollback();

				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Delete 教师删除]
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
		list($id, $id_card) = (stripos(I('id'), '-') === false) ? array() : explode('-', I('id'));

		// 删除数据
		if($id != null && $id_card != null)
		{
			// 教师模型
			$s = M('Teacher');

			// 教师是否存在
			$teacher = $s->where(array('id'=>$id, 'id_card'=>$id_card))->getField('id');
			if(empty($teacher))
			{
				$this->ajaxReturn(L('teacher_no_exist_error'), -2);
			}

			// 开启事务
			$s->startTrans();

			// 删除教师
			$t_state = $s->where(array('id'=>$id, 'id_card'=>$id_card))->delete();

			// 删除课程
			$c_state = M('Course')->where(array('teacher_id'=>$id))->delete();
			if($t_state !== false && $c_state !== false)
			{
				// 提交事务
				$s->commit();

				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				// 回滚事务
				$s->rollback();
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn(L('common_param_error'), -1);
		}
	}
}
?>