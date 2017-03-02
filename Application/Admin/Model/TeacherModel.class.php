<?php

namespace Admin\Model;
use Think\Model;

/**
 * 教师模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class TeacherModel extends CommonModel
{
	// 数据自动校验
	protected $_validate = array(		
		// 添加,编辑
		array('username', 'CheckUserName', '{%teacher_username_format}', 1, 'callback', 3),
		array('id_card', 'CheckIdCard', '{%common_view_id_card_format}', 1, 'callback', 3),
		array('gender', array(0,1,2), '{%common_gender_tips}', 1, 'in', 3),
		array('birthday', 'CheckBirthday', '{%teacher_birthday_format}', 2, 'callback', 3),
		array('state', array(0,1,2,3,4), '{%common_teacher_state_tips}', 1, 'in', 3),
		array('mobile', 'CheckMobile', '{%common_mobile_format_error}', 1, 'callback', 3),
		array('tel', 'CheckTel', '{%common_view_tel_error}', 2, 'callback', 3),
		array('email', 'CheckEmail', '{%common_email_format_error}', 2, 'callback', 3),

		// 添加
		array('id_card', 'UniqueIdCard', '{%common_is_exist_id_card_tips}', 1, 'callback', 1),

		// 编辑
		array('id_card', 'NoExistIdCard', '{%common_no_exist_id_card_tips}', 1, 'callback', 2),
	);

	/**
	 * [UniqueIdCard 身份证必须唯一]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-29T17:12:27+0800
	 * @return [boolean] [存在false, 不存在true]
	 */
	public function UniqueIdCard()
	{
		$id = $this->db(0)->where(array('id_card'=>I('id_card')))->getField('id');
		return empty($id);
	}

	/**
	 * [CheckUserName 姓名校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T19:29:30+0800
	 */
	public function CheckUserName()
	{
		$len = Utf8Strlen(I('username'));
		return ($len >= 2 && $len <= 16);
	}

	/**
	 * [CheckIdCard 身份证号码校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckIdCard()
	{
		return (preg_match('/'.L('common_regex_id_card').'/', I('id_card')) == 1) ? true : false;
	}

	/**
	 * [CheckBirthday 生日校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckBirthday()
	{
		return (preg_match('/'.L('common_regex_birthday').'/', I('birthday')) == 1) ? true : false;
	}

	/**
	 * [CheckMobile 手机号码校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckMobile()
	{
		return (preg_match('/'.L('common_regex_mobile').'/', I('mobile')) == 1) ? true : false;
	}

	/**
	 * [CheckTel 联系方式校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckTel()
	{
		return (preg_match('/'.L('common_regex_tel').'/', I('tel')) == 1) ? true : false;
	}

	/**
	 * [CheckEmail 电子邮箱校验]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T15:12:32+0800
	 */
	public function CheckEmail()
	{
		return (preg_match('/'.L('common_regex_email').'/', I('email')) == 1) ? true : false;
	}

	/**
	 * [NoExistIdCard 身份证号码是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:09:40+0800
	 * @return [boolean] [存在true, 不存在false]
	 */
	public function NoExistIdCard()
	{
		$id = $this->db(0)->where(array('id_card'=>I('id_card')))->getField('id');
		return !empty($id);
	}
}
?>