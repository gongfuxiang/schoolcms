<?php

namespace Admin\Controller;

/**
 * 用户管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserController extends CommonController
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
     * [Index 用户列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 参数
		$param = array_merge($_POST, $_GET);

		// 模型模型
		$m = M('User');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('admin_page_number');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$m->where($where)->count(),
				'where'		=>	$param,
				'url'		=>	U('Admin/User/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$field = array('id', 'mobile', 'email', 'nickname', 'gender', 'birthday', 'signature', 'describe', 'state', 'add_time', 'upd_time');
		$list = $this->SetDataHandle($m->field($field)->where($where)->limit($page->GetPageStarNumber(), $number)->order('id desc')->select());

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 用户状态
		$this->assign('common_user_state_list', L('common_user_state_list'));

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// 数据列表
		$this->assign('list', $list);

		$this->display('Index');
	}

	/**
	 * [SetDataHandle 数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-29T21:27:15+0800
	 * @param    [array]      $data [用户数据]
	 * @return   [array]            [处理好的数据]
	 */
	private function SetDataHandle($data)
	{
		if(!empty($data))
		{
			foreach($data as &$v)
			{
				// 生日
				if($v['birthday'] > 0)
				{
					$v['birthday'] = date('Y-m-d', $v['birthday']);
				} 

				// 注册时间
				$v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);

				// 更新时间
				$v['upd_time'] = date('Y-m-d H:i:s', $v['upd_time']);

				// 性别
				$v['gender'] = L('common_gender_list')[$v['gender']]['name'];

				// 状态
				$v['state_text'] = L('common_user_state_list')[$v['state']]['name'];
			}
		}
		return $data;
	}

	/**
	 * [GetIndexWhere 用户列表条件]
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
					'nickname'		=>	$like_keyword,
					'mobile'		=>	$like_keyword,
					'email'		=>	$like_keyword,
					'_logic'		=>	'or',
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
				$where['add_time'][] = array('gt', strtotime(I('time_start')));
			}
			if(!empty($_REQUEST['time_end']))
			{
				$where['add_time'][] = array('lt', strtotime(I('time_end')));
			}
		}
		return $where;
	}

	/**
	 * [SaveInfo 用户添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 用户信息
		$data = empty($_REQUEST['id']) ? array() : M('User')->find(I('id'));
		$data['birthday'] = empty($data['birthday']) ? '' : date('Y-m-d', $data['birthday']);
		$this->assign('data', $data);

		// 性别
		$this->assign('common_gender_list', L('common_gender_list'));

		// 用户状态
		$this->assign('common_user_state_list', L('common_user_state_list'));

		$this->display('SaveInfo');
	}

	/**
	 * [Save 用户添加/编辑]
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

		// 用户账户校验
		if(empty($_POST['mobile']) && empty($_POST['email']))
		{
			$this->ajaxReturn(L('user_accounts_param_error'), -1);
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
	 * [Add 用户添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 用户模型
		$m = D('User');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 额外数据处理
			$m->salt 		=	GetNumberCode(6);
			$m->pwd 		=	LoginPwdEncryption(trim(I('pwd')), $m->salt);
			$m->nickname 	=	I('nickname');
			$m->signature 	=	I('signature');
			$m->describe 	=	I('describe');
			$m->add_time	=	time();

			// 数据添加
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
	 * [Edit 用户编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		// 用户模型
		$m = D('User');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			// 额外数据处理
			if(!empty($m->birthday))
			{
				$m->birthday	=	strtotime($m->birthday);
			}
			$m->nickname 	=	I('nickname');
			$m->signature 	=	I('signature');
			$m->describe 	=	I('describe');
			$m->upd_time	=	time();

			// 登录密码
			if(!empty($_POST['pwd']))
			{
				$m->salt 	=	GetNumberCode(6);
				$m->pwd 	=	LoginPwdEncryption(trim(I('pwd')), $m->salt);
			} else {
				unset($m->pwd);
			}

			// 更新数据库
			if($m->where(array('id'=>I('id')))->save())
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
	 * [Delete 用户删除]
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
		$id = I('id');

		// 删除数据
		if(!empty($id))
		{
			// 用户模型
			$u = M('User');

			// 用户是否存在
			$user = $u->where(array('id'=>$id))->getField('id');
			if(empty($user))
			{
				$this->ajaxReturn(L('common_user_no_exist_error'), -2);
			}

			// 开启事务
			$u->startTrans();

			// 删除用户
			$u_state = $u->where(array('id'=>$id))->delete();

			// 删除成绩
			$us_state = M('UserStudent')->where(array('user_id'=>$id))->delete();
			if($u_state !== false && $us_state !== false)
			{
				// 提交事务
				$u->commit();

				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				// 回滚事务
				$u->rollback();
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn(L('common_param_error'), -1);
		}
	}
}
?>