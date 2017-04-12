<?php

namespace Admin\Controller;

/**
 * 学生管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class StudentController extends CommonController
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
     * [Index 学生列表]
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
		$m = M('Student');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('admin_page_number');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$m->where($where)->count(),
				'where'		=>	$param,
				'url'		=>	U('Admin/Student/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$list = $this->SetDataHandle($m->where($where)->limit($page->GetPageStarNumber(), $number)->order('id desc')->select());

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 学生状态
		$this->assign('common_student_state_list', L('common_student_state_list'));

		// 缴费状态
		$this->assign('common_tuition_state_list', L('common_tuition_state_list'));

		// 地区
		$region_list = M('Region')->field(array('id', 'name'))->where(array('is_enable'=>1))->select();
		$this->assign('region_list', $region_list);

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// 数据列表
		$this->assign('list', $list);

		// Excel导出地址
		$this->assign('excel_url', U('Admin/Student/ExcelExport', $param));

		// Excel导入基础数据
		$this->assign('excel_import_tips', L('student_excel_import_tips'));
		$this->assign('excel_import_form_url', U('Admin/Student/ExcelImport'));
		$this->assign('excel_import_format_url', U('Admin/Student/ExcelExport', ['type'=>'format_download']));

		$this->display('Index');
	}

	/**
	 * [ExcelImport excel导入]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-06T16:48:56+0800
	 */
	public function ExcelImport()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 文件上传校验
		$error = FileUploadError('excel');
		if($error !== true)
		{
			$this->ajaxReturn($error, -1);
		}

		// excel驱动
		$excel = new \My\Excel(array('title'=>L('excel_student_impoet_title_list'), 'msg'=>L('common_not_data_tips')));
		$data = $excel->Import();
		if(empty($data))
		{
			$this->ajaxReturn(L('common_not_data_tips'), -2);
		}

		// 学生导入模型
		$m = D('StudentImport');

		// 开始处理导入数据
		$success = 0;
		$error = array();
		foreach($data as $k=>$v)
		{
			// 数据处理
			$v = $this->ExcelImportDataDealWith($v);

			// 数据自动校验
			if($m->create($v, 1) !== false)
			{
				// 额外数据处理
				$m->birthday	=	strtotime($v['birthday']);
				$m->semester_id	=	MyC('admin_semester_id');
				
				// 开启事务
				$m->startTrans();

				// 学生是否已存在编号
				$number = $m->where(array('id_card'=>I('id_card')))->getField('number');

				// 数据写入
				$student_id = $m->add();

				// 更新学号
				if(empty($number))
				{
					$number = GenerateStudentNumber($student_id);
				}
				$number_state = $m->where(array('id'=>$student_id))->save(array('number'=>$number));

				if($student_id > 0 && $number_state !== false)
				{
					// 提交事务
					$m->commit();
					$success++;
				} else {
					// 回滚事务
					$m->rollback();
					$error[] = $v['username'].' ['.L('common_operation_add_error').']';
				}
			} else {
				$error[] = $v['username'].' ['.current($m->getError()).']';
			}
		}
		$this->ajaxReturn(L('common_operation_success'), 0, array('success'=>$success, 'error'=>$error));
	}

	/**
	 * [ExcelImportDataDealWith 学生excel导入数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-07T12:04:05+0800
	 * @param    [array]          $data [学生数据]
	 * @return   [array]                [处理好的数据]
	 */
	private function ExcelImportDataDealWith($data)
	{
		if(!empty($data) && is_array($data))
		{
			// 数据列表
			$gender_list = LangValueKeyFlip(L('common_gender_list'), 0);
			$student_state_list = LangValueKeyFlip(L('common_student_state_list'), 0);
			$tuition_state_list = LangValueKeyFlip(L('common_tuition_state_list'), 0);

			// M对象
			$r = M('Region');
			$c = M('Class');


			// 删除n学生编号
			if(isset($data['number']))
			{
				unset($data['number']);
			}

			// 数据安全处理
			foreach($data as $ks=>$vs)
			{
				$data[$ks] = I('data.'.$ks, '', '', $data);
			}
			
			// 性别
			if(!empty($data['gender']))
			{
				// 性别
				$data['gender'] = isset($gender_list[$data['gender']]) ? $gender_list[$data['gender']] : $gender_list['default'];
			}

			// 学生状态
			if(!empty($data['state']))
			{
				$data['state'] = isset($student_state_list[$data['state']]) ? $student_state_list[$data['state']] : $student_state_list['default'];
			}

			// 缴费状态
			if(!empty($data['tuition_state']))
			{
				$data['tuition_state'] = isset($tuition_state_list[$data['tuition_state']]) ? $tuition_state_list[$data['tuition_state']] : $tuition_state_list['default'];
			}

			// 地区
			if(!empty($data['region_name']))
			{
				$data['region_id'] = $r->where(array('name'=>$data['region_name']))->getField('id');
				unset($data['region_name']);
			}

			// 班级
			if(!empty($data['class_name']))
			{
				if(strpos($data['class_name'], '-') === false)
				{
					$temp_class_name = $data['class_name'];
				} else {
					$temp_ex = explode('-', $data['class_name']);
					$temp_class_name = $temp_ex[1];
				}
				$data['class_id'] = $c->where(array('name'=>$temp_class_name))->getField('id');
				unset($data['class_name']);
			}

			// 添加时间
			if(!empty($data['add_time']))
			{
				$data['add_time'] = strtotime($data['add_time']);
			} else {
				$data['add_time'] = time();
			}
		}
		return $data;
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
		// 类型
		switch(I('type'))
		{
			// 格式下载类型不查询数据,只导出标题格式
			case 'format_download' :
				$title = L('excel_student_impoet_title_list');
				$data = array();
				break;

			// 默认按照当前条件查询数据
			default :
				$title = L('excel_student_title_list');
				$data = $this->SetDataHandle(M('Student')->where($this->GetIndexWhere())->select());
		}

		// Excel驱动导出数据
		$excel = new \My\Excel(array('filename'=>'student', 'title'=>$title, 'data'=>$data, 'msg'=>L('common_not_data_tips')));
		$excel->Export();
	}

	/**
	 * [SetDataHandle 数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-29T21:27:15+0800
	 * @param    [array]      $data [学生数据]
	 * @return   [array]            [处理好的数据]
	 */
	private function SetDataHandle($data)
	{
		if(!empty($data))
		{
			$c = M('Class');
			$r = M('Region');
			foreach($data as $k=>$v)
			{
				// 班级
				$tmp_class = $c->field(array('pid', 'name'))->find($v['class_id']);
				if(!empty($tmp_class))
				{
					$p_name = ($tmp_class['pid'] > 0) ? $c->where(array('id'=>$tmp_class['pid']))->getField('name') : '';
					$data[$k]['class_name'] = empty($p_name) ? $tmp_class['name'] : $p_name.'-'.$tmp_class['name'];
				} else {
					$data[$k]['class_name'] = '';
				}
				
				// 地区
				$data[$k]['region_name'] = $r->where(array('id'=>$v['region_id']))->getField('name');

				// 出生
				$data[$k]['birthday'] = date('Y-m-d', $v['birthday']);

				// 报名时间
				$data[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);

				// 更新时间
				$data[$k]['upd_time'] = date('Y-m-d H:i:s', $v['upd_time']);

				// 性别
				$data[$k]['gender'] = L('common_gender_list')[$v['gender']]['name'];

				// 状态
				$data[$k]['state'] = L('common_student_state_list')[$v['state']]['name'];

				// 缴费状态
				$data[$k]['tuition_state'] = L('common_tuition_state_list')[$v['tuition_state']]['name'];
			}
		}
		return $data;
	}

	/**
	 * [GetIndexWhere 学生列表条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T22:16:29+0800
	 */
	private function GetIndexWhere()
	{
		$where = array();

		// 学期id
		$where['semester_id'] = MyC('admin_semester_id');

		// 模糊
		if(!empty($_REQUEST['keyword']))
		{
			$like_keyword = array('like', '%'.I('keyword').'%');
			$where[] = array(
					'username'		=>	$like_keyword,
					'id_card'		=>	$like_keyword,
					'number'		=>	$like_keyword,
					'tel'			=>	$like_keyword,
					'my_mobile'		=>	$like_keyword,
					'parent_mobile'	=>	$like_keyword,
					'email'			=>	$like_keyword,
					'_logic'		=>	'or',
				);
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 等值
			if(I('class_id', 0) > 0)
			{
				$where['class_id'] = intval(I('class_id'));
			}
			if(I('region_id', 0) > 0)
			{
				$where['region_id'] = intval(I('region_id'));
			}
			if(I('gender', -1) > -1)
			{
				$where['gender'] = intval(I('gender', 0));
			}
			if(I('state', -1) > -1)
			{
				$where['state'] = intval(I('state', 0));
			}
			if(I('tuition_state', -1) > -1)
			{
				$where['tuition_state'] = intval(I('tuition_state', 0));
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
	 * [SaveInfo 学生添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 学生信息
		$data = empty($_REQUEST['id']) ? array() : M('Student')->find(I('id'));
		if(!empty($data['birthday']))
		{
			$data['birthday'] = date('Y-m-d', $data['birthday']);
		}
		$this->assign('data', $data);

		// 地区
		$region_list = M('Region')->field(array('id', 'name'))->where(array('is_enable'=>1))->select();
		$this->assign('region_list', $region_list);

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 学生状态
		$this->assign('common_student_state_list', L('common_student_state_list'));

		// 缴费状态
		$this->assign('common_tuition_state_list', L('common_tuition_state_list'));

		$this->display('SaveInfo');
	}

	/**
	 * [Save 学生添加/编辑]
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
		if(empty($_POST['id']))
		{
			$this->Add();

		// 编辑
		} else {
			$this->Edit();
		}
	}

	/**
	 * [Add 学生添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 学生模型
		$m = D('Student');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 额外数据处理
			$m->add_time	=	time();
			$m->birthday	=	strtotime($m->birthday);
			$m->semester_id	=	MyC('admin_semester_id');
			$m->username 	=	I('username');
			$m->address 	=	I('address');
			
			// 开启事务
			$m->startTrans();

			// 学生是否已存在编号
			$number = $m->where(array('id_card'=>I('id_card')))->getField('number');

			// 数据写入
			$student_id = $m->add();

			// 更新学号
			if(empty($number))
			{
				$number = GenerateStudentNumber($student_id);
			}
			$number_state = $m->where(array('id'=>$student_id))->save(array('number'=>$number));

			if($student_id > 0 && $number_state !== false)
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
	 * [Edit 学生编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		// 学生模型
		$m = D('Student');

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
			unset($m->id_card, $m->number);

			// 更新数据库
			if($m->where(array('id'=>I('id'), 'id_card'=>I('id_card'), 'number'=>I('number')))->save())
			{
				$this->ajaxReturn(L('common_operation_edit_success'));
			} else {
				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Delete 学生删除]
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
			// 学生模型
			$s = M('Student');

			// 学生是否存在
			$student = $s->where(array('id'=>$id, 'id_card'=>$id_card))->getField('id');
			if(empty($student))
			{
				$this->ajaxReturn(L('student_no_exist_error'), -2);
			}

			// 开启事务
			$s->startTrans();

			// 删除学生
			$s_state = $s->where(array('id'=>$id, 'id_card'=>$id_card))->delete();

			// 删除成绩
			$f_state = M('Fraction')->where(array('student_id'=>$id))->delete();
			if($s_state !== false && $f_state !== false)
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