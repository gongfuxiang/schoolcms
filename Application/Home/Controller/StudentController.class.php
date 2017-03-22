<?php

namespace Home\Controller;

/**
 * 学生
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-03-02T22:48:35+0800
 */
class StudentController extends CommonController
{
	/**
	 * [_initialize 前置操作-继承公共前置方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function _initialize()
	{
		// 调用父类前置方法
		parent::_initialize();
	}

	/**
	 * [Index 首页]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-22T16:50:32+0800
	 */
	public function Index()
	{
		$this->display('Index');
	}

	/**
	 * [PolyInfo 学生关联-页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-15T11:22:33+0800
	 */
	public function PolyInfo()
	{
		$this->display('PolyInfo');
	}

	/**
	 * [Poly 学生关联]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-22T16:47:29+0800
	 */
	public function Poly()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数是否有误
		if(empty($_POST['id']) || empty($_POST['accounts']) || empty($_POST['verify']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 账户是否存在
		$accounts = I('accounts');
		$field = $this->StudentPolyAccountsCheck($accounts);

		// 验证码校验
		$verify_param = array(
				'key_prefix' => 'student_poly',
				'expire_time' => MyC('common_verify_expire_time'),
				'time_interval'	=>	MyC('common_verify_time_interval'),
			);
		if($field == 'email')
		{
			$obj = new \My\Email($verify_param);
			
		} else {
			$obj = new \My\Sms($verify_param);
		}
		// 是否已过期
		if(!$obj->CheckExpire())
		{
			$this->ajaxReturn(L('common_verify_expire'), -10);
		}
		// 是否正确
		if(!$obj->CheckCorrect(I('verify')))
		{
			$this->ajaxReturn(L('common_verify_error'), -11);
		}

		// 查询用户数据
		$where = array('id'=>I('id'), $field=>$accounts, 'semester_id'=>MyC('admin_semester_id'));
		$student_id = M('Student')->where($where)->getField('id');
		if(!empty($student_id))
		{
			$data = array(
					'student_id'	=>	$student_id,
					'user_id'		=>	$this->user['id'],
					'add_time'		=>	time(),
				);
			if(M('UserStudent')->add($data))
			{
				// 清除验证码
				$obj->Remove();

				$this->ajaxReturn(L('common_operation_join_success'));
			}
			$this->ajaxReturn(L('common_operation_join_error'), -100);
		}
		$this->ajaxReturn(L('common_student_no_exist_error'), -1000);
	}

	/**
	 * [PolyQuery 学生关联-数据查询]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-17T16:58:26+0800
	 */
	public function PolyQuery()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数是否有误
		if(empty($_POST['username']) || empty($_POST['student_number']) || empty($_POST['id_card']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 查询用户数据
		$where = array('username'=>I('username'), 'number'=>I('student_number'), 'id_card'=>I('id_card'), 'semester_id'=>MyC('admin_semester_id'));
		$data = M('Student')->field(array('id', 'my_mobile', 'parent_mobile', 'email'))->where($where)->find();
		if(!empty($data))
		{
			// 是否已关联过
			$temp = M('UserStudent')->where(array('student_id'=>$data['id'], 'user_id'=>$this->user['id']))->getField('id');
			if(!empty($temp))
			{
				$this->ajaxReturn(L('student_join_accounts_exist_tips'), -2);
			}

			// 封装返回数据
			$result = array('id' => $data['id'], 'contact_list' => array());
			if(!empty($data['my_mobile']))
			{
				$result['contact_list'][] = $data['my_mobile'];
			}
			if(!empty($data['parent_mobile']))
			{
				$result['contact_list'][] = $data['parent_mobile'];
			}
			if(!empty($data['email']))
			{
				$result['contact_list'][] = $data['email'];
			}
			$this->ajaxReturn(L('common_operation_success'), 0, $result);
		}
		$this->ajaxReturn(L('common_student_no_exist_error'), -1000);
	}

	/**
	 * [PolyVerifyEntry 学生关联-验证码显示]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-05T15:10:21+0800
	 */
	public function PolyVerifyEntry()
	{
		$this->CommonVerifyEntry(I('type', 'student_poly'));
	}

	/**
	 * [PolyVerifySend 学生关联-验证码发送]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-10T17:35:03+0800
	 */
	public function PolyVerifySend()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数
		$accounts = I('accounts');
		if(empty($accounts))
		{
			$this->ajaxReturn(L('common_param_error'), -10);
		}

		// 账户是否存在
		$type = $this->StudentPolyAccountsCheck($accounts);

		// 验证码公共基础参数
		$verify_param = array(
				'key_prefix' => 'student_poly',
				'expire_time' => MyC('common_verify_expire_time'),
				'time_interval'	=>	MyC('common_verify_time_interval'),
			);

		// 是否开启图片验证码
		$verify = $this->CommonIsImaVerify($verify_param);

		// 验证码
		$code = GetNumberCode(6);

		// 邮箱
		if($type == 'email')
		{
			$obj = new \My\Email($verify_param);
			$email_param = array(
					'email'		=>	$accounts,
					'content'	=>	MyC('home_email_user_forget_pwd'),
					'title'		=>	MyC('home_site_name').' - '.L('common_email_send_user_reg_title'),
					'code'		=>	$code,
				);
			$state = $obj->SendHtml($email_param);

		// 短信
		} else {
			$obj = new \My\Sms($verify_param);
			$state = $obj->SendText($accounts, MyC('home_sms_user_forget_pwd'), $code);
		}

		// 状态
		if($state)
		{
			// 清除验证码
			if(isset($verify) && is_object($verify))
			{
				$verify->Remove();
			}

			$this->ajaxReturn(L('common_send_success'));
		} else {
			$this->ajaxReturn(L('common_send_error').'['.$obj->error.']', -100);
		}
	}

	/**
	 * [StudentPolyAccountsCheck 学生是否存在]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-22T17:39:56+0800
	 * @param    [string]       $accounts [my_mobile, parent_mobile, email]
	 * @return   [string]                 [表字段名称 my_mobile, parent_mobile, email]
	 */
	private function StudentPolyAccountsCheck($accounts)
	{
		$field = array('my_mobile', 'parent_mobile', 'email');
		$where = array(
				'my_mobile'		=>	$accounts,
				'parent_mobile'	=>	$accounts,
				'email'			=>	$accounts,
				'semester_id'	=>	MyC('admin_semester_id'),
				'_logic'		=>	'OR',
			);
		$data = M('Student')->field($field)->where($where)->find();
		if(!empty($data))
		{
			foreach($field as $temp_key=>$temp_field)
			{
				if($temp_field == $accounts)
				{
					return $temp_key;
				}
			}
		} else {
			$this->ajaxReturn(L('common_student_no_exist_error'), -1000);
		}
	}
}
?>