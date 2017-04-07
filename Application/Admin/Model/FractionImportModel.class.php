<?php

namespace Admin\Model;
use Think\Model;

/**
 * 成绩导入模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class FractionImportModel extends CommonModel
{
	// 表名
	protected $tableName = 'fraction';

	// 开启批量验证状态
	protected $patchValidate = true;

	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('score', 'CheckScore', '{%fraction_score_format}', 1, 'callback', 3),
		array('score_id', 'IsExistScoreId', '{%fraction_score_id_error}', 1, 'callback', 3),
		array('subject_id', 'IsExistSubjectId', '{%fraction_subject_error}', 1, 'callback', 3),
		array('student_id', 'IsExistStudentId', '{%fraction_student_id_error}', 1, 'callback', 3),
		array('comment', 'CheckComment', '{%fraction_comment_format}', 1, 'callback', 3),
	);

	/**
	 * [CheckComment 教师点评校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 * @param    [string] $value [校验值]
	 */
	public function CheckComment($value)
	{
		return (Utf8Strlen($value) <= 255);
	}

	/**
	 * [CheckScore 分数校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 * @param    [string] $value [校验值]
	 */
	public function CheckScore($value)
	{
		return (preg_match('/'.L('common_regex_score').'/', $value) == 1) ? true : false;
	}

	/**
	 * [IsExistScoreId 成绩分类id是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @param    [string] $value [校验值]
	 * @return   [boolean]       [存在true, 不存在false]
	 */
	public function IsExistScoreId($value)
	{
		$id = $this->db(0)->table('__SCORE__')->where(array('id'=>$value))->getField('id');
		return !empty($id);
	}

	/**
	 * [IsExistSubjectId 科目分类id是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @param    [string] $value [校验值]
	 * @return   [boolean]       [存在true, 不存在false]
	 */
	public function IsExistSubjectId($value)
	{
		$id = $this->db(0)->table('__SUBJECT__')->where(array('id'=>$value))->getField('id');
		return !empty($id);
	}

	/**
	 * [IsExistStudentId 学生id是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @param    [string] $value [校验值]
	 * @return   [boolean]       [存在true, 不存在false]
	 */
	public function IsExistStudentId($value)
	{
		$id = $this->db(0)->table('__STUDENT__')->where(array('id'=>$value))->getField('id');
		return !empty($id);
	}
}
?>