<?php

namespace Home\Controller;

/**
 * 冒泡
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-03-02T22:48:35+0800
 */
class BubbleController extends CommonController
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
	 * [Index 冒泡]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-02T22:48:35+0800
	 */
	public function Index()
	{
		$this->assign('data', $this->GetMoodData());
		$this->assign('common_user_visible_list', L('common_user_visible_list'));
		$this->assign('bubble_nav_list', L('bubble_nav_list'));
		$this->display('Index');
	}

	/**
	 * [GetMoodData 获取说说数据]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-08T22:20:34+0800
	 */
	private function GetMoodData()
	{
		// 基础数据
		$page = isset($_POST['page']) ? intval($_POST['page']) : 0;
		$number = 10;

		// 返回字段
		$field = array('m.id', 'm.user_id', 'm.content', 'm.visible', 'm.add_time', 'u.nickname');

		// 条件
		$where = array();
		if(I('type') == 'own')
		{
			$where['u.id'] = $this->user['id'];
		}

		// 数据处理
		return $this->MoodDataHandle(M('Mood')->alias('m')->join('__USER__ AS u ON m.user_id=u.id')->field($field)->where($where)->order('m.id desc')->limit($page*$number, $number)->select());
	}

	/**
	 * [MoodDataHandle 说说数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-08T20:14:19+0800
	 * @param    [array]     $data [需要处理的数据]
	 * @return   [array]           [处理好的说说数据]
	 */
	private function MoodDataHandle($data)
	{
		if(!empty($data) && is_array($data))
		{
			foreach($data as $k=>&$v)
			{
				// 昵称
				if(empty($v['nickname']))
				{
					$v['nickname'] = L('common_bubble_mood_nickname');
				}

				// 发表时间
				$v['add_time'] = date('m-d H:i', $v['add_time']);
			}
		}
		return $data;
	}

	/**
	 * [MoodSave 说说保存]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-08T13:21:34+0800
	 */
	public function MoodSave()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 说说模型
		$m = D('Mood');

		// 编辑
		if($m->create($_POST, 1) !== false)
		{
			$m->user_id		=	$this->user['id'];
			$m->content 	=	I('content');
			$m->add_time	=	time();

			// 开启事务
			$m->startTrans();

			// 更新用户签名
			if(I('is_sign') == 1)
			{
				$data = array(
						'signature'	=>	$m->content,
						'upd_time'	=>	time(),
					);
				$user_state = (M('User')->where(array('id'=>$this->user['id']))->save($data) !== false);
			} else {
				$user_state = true;
			}

			// 添加历史签名
			$mood_state = $m->add();

			// 状态
			if($user_state && $mood_state > 0)
			{
				// 提交事务
				$m->commit();

				// 更新用户session数据
				if(I('is_sign') == 1)
				{
					$this->UserLoginRecord($this->user['id']);
				}

				$this->ajaxReturn(L('common_operation_publish_success'));
			} else {

				// 回滚事务
				$m->rollback();
				$this->ajaxReturn(L('common_operation_publish_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [MoodMore 查看更多说说]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-08T22:14:22+0800
	 */
	public function MoodMore()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 数据
		$data = $this->GetMoodData();
		if(empty($data))
		{
			$code = -100;
			$msg = L('common_not_data_tips');
		} else {
			$code = 0;
			$msg = L('common_operation_success');
		}
		$this->ajaxReturn($msg, $code, $data);

	}

	/**
	 * [Delete 说说删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:36:12+0800
	 */
	public function Delete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 数据删除
		if(M('Mood')->where(array('id'=>I('id'), 'user_id'=>$this->user['id']))->delete())
		{
			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}
}
?>