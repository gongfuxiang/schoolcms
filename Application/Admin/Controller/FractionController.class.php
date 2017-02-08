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
     * [Index 学生成绩列表]
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
		$m = M('Fraction');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('admin_page_number');
		$total = $m->alias('f')->join('__STUDENT__ AS s ON s.id = f.student_id')->where($where)->count();
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$param,
				'url'		=>	U('Admin/Fraction/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$field = array('s.username', 's.gender', 's.class_id', 'f.score', 'f.subject_id', 'f.score_id', 'f.id', 'f.student_id', 'f.comment', 'f.add_time');
		$list = $m->alias('f')->join('__STUDENT__ AS s ON s.id = f.student_id')->where($where)->field($field)->limit($page->GetPageStarNumber(), $number)->select();
		// 数据列表
		$this->assign('list', $this->SetDataHandle($list));

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 学生成绩等级
		$this->assign('common_fraction_level_list', L('common_fraction_level_list'));

		// 科目
		$subject_list = M('Subject')->field(array('id', 'name'))->where(array('is_enable'=>1))->select();
		$this->assign('subject_list', $subject_list);

		// 成绩期号
		$this->assign('score_list', M('Score')->select());

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// Excel地址
		$this->assign('excel_url', U('Admin/Fraction/ExcelExport', $param));

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
		$field = array('s.username', 's.gender', 's.class_id', 'f.score', 'f.subject_id', 'f.score_id', 'f.id', 'f.student_id', 'f.comment', 'f.add_time');
		$data = $this->SetDataHandle(M('Fraction')->alias('f')->join('__STUDENT__ AS s ON s.id = f.student_id')->where($where)->field($field)->select());

		// Excel驱动导出数据
		$excel = new \My\Excel(array('filename'=>'fraction', 'title'=>L('excel_fraction_title_list'), 'data'=>$data, 'msg'=>L('common_not_data_tips')));
		$excel->Export();
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
		$where['f.semester_id'] = MyC('admin_semester_id');

		// 模糊
		if(!empty($_REQUEST['keyword']))
		{
			$where['s.username'] = array('like', '%'.I('keyword').'%');
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 等值
			if(I('class_id', 0) > 0)
			{
				$where['s.class_id'] = intval(I('class_id'));
			}
			if(I('score_id', 0) > 0)
			{
				$where['f.score_id'] = intval(I('score_id'));
			}
			if(I('subject_id', 0) > 0)
			{
				$where['f.subject_id'] = intval(I('subject_id'));
			}

			if(I('score_level', -1) > -1)
			{
				$level = L('common_fraction_level_list')[I('score_level')];
				$where[] = array(
						array('f.score' => array('egt', $level['min'])),
						array('f.score' => array('elt', $level['max'])),
					);
			}
		}
		return $where;
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
			$score = M('Score');
			$subject = M('Subject');
			$class = M('Class');
			$score_level = L('common_fraction_level_list');
			foreach($data as $k=>$v)
			{
				// 班级
				$tmp_class = $class->field(array('pid', 'name'))->find($v['class_id']);
				if(!empty($tmp_class))
				{
					$p_name = ($tmp_class['pid'] > 0) ? $class->where(array('id'=>$tmp_class['pid']))->getField('name') : '';
					$data[$k]['class_name'] = empty($p_name) ? $tmp_class['name'] : $p_name.'-'.$tmp_class['name'];
				} else {
					$data[$k]['class_name'] = '';
				}
				
				// 科目
				$data[$k]['subject_name'] = $subject->where(array('id'=>$v['subject_id']))->getField('name');

				// 成绩期号
				$data[$k]['score_name'] = $score->where(array('id'=>$v['score_id']))->getField('name');

				// 成绩等级
				foreach($score_level as $level)
				{
					if($v['score'] >= $level['min'] && $v['score'] <= $level['max'])
					{
						$data[$k]['score_level'] = $level['name'];
					}
				}
				if(!isset($data[$k]['score_level']))
				{
					$data[$k]['score_level'] = '';
				}

				// 添加时间
				$data[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);

				// 性别
				$data[$k]['gender'] = L('common_gender_list')[$v['gender']]['name'];
			}
		}
		return $data;
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
		if(empty($_REQUEST['id']))
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

		$this->display('SaveInfo');
	}

	/**
	 * [Save 学生成绩添加/编辑]
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
	 * [Add 学生成绩添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 学生成绩对象
		$m = D('Fraction');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 数据不能重复
			$this->IsExistData();

			// 额外数据处理
			$m->add_time	=	time();
			$m->comment 	=	I('comment');

			// 学期id
			$m->semester_id	=	MyC('admin_semester_id');
			
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
	 * [Edit 学生成绩编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		$this->error(L('common_unauthorized_access'));
	}

	/**
	 * [IsExistData 校验数据不能重复添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-08T22:08:46+0800
	 */
	private function IsExistData()
	{
		// 数据是否已存在
		$where = array(
				'semester_id'	=>	MyC('admin_semester_id'),
				'student_id'	=>	I('student_id'),
				'subject_id'	=>	I('subject_id'),
				'score_id'		=>	I('score_id'),
			);
		$tmp = M('Fraction')->where($where)->getField('id');
		if(!empty($tmp))
		{
			$this->ajaxReturn(L('common_data_is_exist_error'), -2);
		}
	}

	/**
	 * [Delete 学生成绩删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:40:29+0800
	 */
	public function Delete()
	{
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数是否有误
		if(empty($_POST['id']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 参数处理
		list($id, $student_id) = (stripos(I('id'), '-') === false) ? array() : explode('-', I('id'));

		// 删除数据
		if($id != null && $student_id != null)
		{
			if(M('Fraction')->where(array('id'=>$id, 'student_id'=>$student_id))->delete())
			{
				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn(L('common_param_error'), -1);
		}
	}
}
?>