<?php

namespace Admin\Controller;

/**
 * 权限管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class PowerController extends CommonController
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
		// 获取权限列表
		$field = array('id', 'pid', 'name', 'control', 'action', 'sort');
		$list = M('Power')->field($field)->where(array('pid'=>0))->select();
		if(!empty($list))
		{
			foreach($list as $k=>$v)
			{
				$item =  M('Power')->field($field)->where(array('pid'=>$v['id']))->select();
				if(!empty($item))
				{
					$list[$k]['item'] = $item;
				}
			}
		}
		$this->assign('list', $list);
		$this->display();
	}

	/**
	 * [PowerSave 权限添加/编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-13T21:41:03+0800
	 */
	public function PowerSave()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'), -401);
		}

		// id为空则表示是新增
		$m = D('Power');

		// 公共额外数据处理
		$m->sort 	=	intval(I('sort'));

		// 添加
		if(empty(I('id')))
		{
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
			}
		} else {
			// 编辑
			if($m->create($_POST, 2))
			{
				// 移除 id
				unset($m->id);

				// 更新数据库
				if($m->where(array('id'=>I('id')))->save())
				{
					$this->ajaxReturn(L('common_operation_edit_success'));
				} else {
					$this->ajaxReturn(L('common_operation_edit_error'), -100);
				}
			}
		}
		$this->ajaxReturn($m->getError(), -1);
	}

	/**
	 * [PowerDelete 权限删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:40:29+0800
	 */
	public function PowerDelete()
	{
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'), -401);
		}

		$m = D('Power');
		if($m->create($_POST, 5))
		{
			if($m->delete(I('id')))
			{
				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Role 角色组列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function Role()
	{
		$m = M('Role');
		$list = $m->field(array('id', 'name', 'is_enable'))->select();
		if(!empty($list))
		{
			foreach($list as $k=>$v)
			{
				// 关联查询权限和角色数据
				$list[$k]['item'] = $m->alias('r')->join('__ROLE_POWER__ AS rp ON rp.role_id = r.id')->join('__POWER__ AS p ON rp.power_id = p.id')->where(array('r.id'=>$v['id']))->field(array('p.id', 'p.name'))->select();
			}
		}
		$this->assign('list', $list);
		$this->display();
	}

	/**
	 * [RoleSaveInfo 角色组编辑和添加页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function RoleSaveInfo()
	{
		// 角色组
		$field = array('id', 'name');
		$role = M('Role')->field($field)->find(I('id'));
		// 还在写 $role_id = $this->GetSession('user.role_id', $role['id']);
		$power = array();
		if(!empty($role))
		{
			// 权限关联数据
			$action = M('RolePower')->where(array('role_id'=>$role_id))->getField('power_id', true);

			// 权限列表
			$m = M('Power');
			$power = $m->field(array('id', 'name'))->where(array('pid'=>0))->select();
			if(!empty($power))
			{
				foreach($power as $k=>$v)
				{
					// 是否有权限
					$power[$k]['is_power'] = in_array($v['id'], $action) ? 'ok' : 'no';

					// 获取子权限
					$item =  $m->field($field)->where(array('pid'=>$v['id']))->select();
					if(!empty($item))
					{
						foreach($item as $ks=>$vs)
						{
							$item[$ks]['is_power'] = in_array($vs['id'], $action) ? 'ok' : 'no';
						}
						$power[$k]['item'] = $item;
					}
				}
			}
		}
		$this->assign('common_is_enable_list', L('common_is_enable_list'));
		$this->assign('role', $role);
		$this->assign('power', $power);
		$this->display();
	}

	/**
	 * [RoleSave 角色组编辑和添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function RoleSave()
	{
		print_r($_POST);
	}

	/**
	 * [RoleDelete 角色删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-15T11:03:30+0800
	 */
	public function RoleDelete()
	{
		print_r($_POST);
	}
}
?>