<?php

namespace Admin\Model;
use Think\Model;

/**
 * 教师课程模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CourseModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(
		// 添加,编辑
		array('teacher_id', 'IsExistTeacher', '{%course_teacher_tips}', 1, 'callback', 3),
		array('class_id', 'IsExistClass', '{%course_class_tips}', 1, 'callback', 3),
		array('subject_id', 'IsExistSubject', '{%course_subject_tips}', 1, 'callback', 3),
		array('week_id', 'IsExistWeek', '{%course_week_tips}', 1, 'callback', 3),
		array('interval_id', 'IsExistInterval', '{%course_interval_tips}', 1, 'callback', 3),
		array('room_id', 'IsExistRoom', '{%course_room_tips}', 1, 'callback', 3),
	);

	/**
	 * [IsExistTeacher 教师是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistTeacher()
	{
		$temp = $this->db(0)->table('__TEACHER__')->field(array('id'))->find(I('teacher_id'));
		return !empty($temp);
	}

	/**
	 * [IsExistClass 班级id是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-21T22:13:52+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistClass()
	{
		// 当用户操作自身的情况下不需要校验
		$class = $this->db(0)->table('__CLASS__')->field(array('id', 'pid'))->find(I('class_id'));
		if(empty($class))
		{
			return false;
		}

		if($class['pid'] == 0)
		{
			// 是否存在子级
			$count = $this->db(0)->table('__CLASS__')->where(array('pid'=>$class['id']))->count();
			return ($count == 0);
		} else {
			// 父级是否存在
			$count = $this->db(0)->table('__CLASS__')->where(array('id'=>$class['pid']))->count();
			return ($count > 0);
		}
	}

	/**
	 * [IsExistRoom 教室id是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-21T22:13:52+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistRoom()
	{
		// 当用户操作自身的情况下不需要校验
		$class = $this->db(0)->table('__ROOM__')->field(array('id', 'pid'))->find(I('room_id'));
		if(empty($class))
		{
			return false;
		}

		if($class['pid'] == 0)
		{
			// 是否存在子级
			$count = $this->db(0)->table('__ROOM__')->where(array('pid'=>$class['id']))->count();
			return ($count == 0);
		} else {
			// 父级是否存在
			$count = $this->db(0)->table('__ROOM__')->where(array('id'=>$class['pid']))->count();
			return ($count > 0);
		}
	}

	/**
	 * [IsExistSubject 教师关联的科目是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistSubject()
	{
		$temp = $this->db(0)->table('__TEACHER_SUBJECT__')->alias('AS ts')->join('__SUBJECT__ AS s ON ts.subject_id = s.id')->where(array('s.id'=>I('subject_id')))->field(array('s.id AS id'))->find();
		return !empty($temp);
	}

	/**
	 * [IsExistWeek 周天是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistWeek()
	{
		$temp = $this->db(0)->table('__WEEK__')->field(array('id'))->find(I('week_id'));
		return !empty($temp);
	}

	/**
	 * [IsExistInterval 时段是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function IsExistInterval()
	{
		$temp = $this->db(0)->table('__INTERVAL__')->field(array('id'))->find(I('interval_id'));
		return !empty($temp);
	}
}
?>