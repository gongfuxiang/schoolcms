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
		// 登录校验
		$this->Is_Login();
		
		// 权限校验
		$this->Is_Power();

		// 参数
		$param = array_merge($_POST, $_GET);

		// 模型对象
		$m = M('Fraction');

		// 条件
		$where = $this->GetStudentIndexWhere();

		// 分页
		$number = 1;
		$total = $m->alias('f')->join('__STUDENT__ AS s ON s.id = f.student_id')->where($where)->count('s.id');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$param,
				'url'		=>	U('Admin/Fraction/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$field = array('s.username', 's.gender', 's.class_id', 'f.score', 'f.subject_id', 'f.score_id');
		$list = $m->alias('f')->join('__STUDENT__ AS s ON s.id = f.student_id')->where($where)->field($field)->select();
		$list = $this->SetDataHandle($list);

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

		// 数据列表
		$this->assign('list', $list);

		$this->display();
	}

	/**
	 * [GetStudentIndexWhere 学生列表条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T22:16:29+0800
	 */
	private function GetStudentIndexWhere()
	{
		$where = array();

		// 模糊
		if(!empty(I('keyword')))
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
			}
		}
		return $data;
	}

	/**
	 * [GetClassList 获取班级列表,二级]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-30T13:26:00+0800
	 * @return [array] [班级列表]
	 */
	private function GetClassList()
	{
		$c = M('Class');
		$data = $c->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>0))->select();
		if(!empty($data))
		{
			foreach($data as $k=>$v)
			{
				$data[$k]['item'] = $c->field(array('id', 'name'))->where(array('is_enable'=>1, 'pid'=>$v['id']))->select();
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
		if(empty(I('id')))
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
}
?>