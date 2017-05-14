<?php

namespace Admin\Controller;

/**
 * 冒泡管理
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

		// 登录校验
		$this->Is_Login();

		// 权限校验
		$this->Is_Power();
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
		// 参数
		$param = array_merge($_POST, $_GET);

		// 条件
		$where = $this->GetIndexWhere();

		// 模型
		$m = M('Mood');

		// 分页
		$number = MyC('admin_page_number');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$m->alias('m')->join('__USER__ AS u ON m.user_id=u.id')->where($where)->count(),
				'where'		=>	$param,
				'url'		=>	U('Admin/Bubble/Index'),
			);
		$page = new \My\Page($page_param);

		// 查询字段
		$field = array('m.id', 'm.user_id', 'm.content', 'm.visible', 'm.add_time', 'u.nickname');

		// 数据处理
		$data = $this->MoodDataHandle($m->alias('m')->join('__USER__ AS u ON m.user_id=u.id')->field($field)->where($where)->limit($page->GetPageStarNumber(), $number)->order('m.id desc')->select());
		$this->assign('data', $data);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// 参数
		$this->assign('param', $param);

		// 基础数据
		$this->assign('common_user_visible_list', L('common_user_visible_list'));
		$this->assign('bubble_nav_list', L('bubble_nav_list'));

		$this->display('Index');
	}

	/**
	 * [GetIndexWhere 条件]
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
					'u.nickname'		=>	$like_keyword,
					'u.mobile'			=>	$like_keyword,
					'u.email'			=>	$like_keyword,
					'm.content'			=>	$like_keyword,
					'_logic'			=>	'or',
				);
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 表达式
			if(!empty($_REQUEST['time_start']))
			{
				$where['m.add_time'][] = array('gt', strtotime(I('time_start')));
			}
			if(!empty($_REQUEST['time_end']))
			{
				$where['m.add_time'][] = array('lt', strtotime(I('time_end')));
			}
		}
		return $where;
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
			$mp = M('MoodPraise');
			$mc = M('MoodComments');
			foreach($data as $k=>&$v)
			{
				// 昵称
				if(empty($v['nickname']))
				{
					$v['nickname'] = L('common_bubble_mood_nickname');
				}

				// 发表时间
				$v['add_time'] = date('m-d H:i', $v['add_time']);

				// 点赞
				$v['praise_count'] = $mp->where(array('mood_id'=>$v['id']))->count();
				$v['praise_list'] = $mp->alias('mp')->join('__USER__ AS u ON u.id=mp.user_id')->field(array('mp.id', 'mp.add_time', 'u.nickname'))->where(array('mp.mood_id'=>$v['id']))->order('id desc')->select();

				// 评论总数
				$v['comments_count'] = $mc->where(array('mood_id'=>$v['id']))->count();

				// 评论列表
				$v['comments'] = $this->GetMoodComments($v['id']);
			}
		}
		return $data;
	}

	/**
	 * [GetMoodComments 获取说说评论]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-10T14:38:00+0800
	 * @param    [int]       $mood_id [说说id]
	 * @return   [array]              [评论列表]
	 */
	private function GetMoodComments($mood_id)
	{
		if(empty($mood_id))
		{
			return array();
		}

		// 评论列表
		$m = M('MoodComments');
		$field = array('mc.id', 'mc.user_id', 'mc.content', 'mc.reply_id', 'mc.add_time', 'u.nickname');
		$where = array('m.id'=>$mood_id, 'mc.reply_id'=>0);
		$data = $m->alias('mc')->join('__MOOD__ AS m ON mc.mood_id=m.id')->join('__USER__ AS u ON mc.user_id=u.id')->field($field)->where($where)->order('mc.id asc')->select();

		// 回复列表
		if(!empty($data))
		{
			$u = M('User');
			foreach($data as &$v)
			{
				// 评论时间
				$v['add_time'] = date('m-d H:i', $v['add_time']);

				// 评论内容
				$v['content'] = str_replace("\n", "<br />", $v['content']);

				$item_where = array('m.id'=>$mood_id, 'mc.parent_id'=>$v['id'], 'reply_id'=>array('gt', 0));
				$item = $m->alias('mc')->join('__MOOD__ AS m ON mc.mood_id=m.id')->join('__USER__ AS u ON mc.user_id=u.id')->field($field)->where($item_where)->order('mc.id asc')->select();
				if(!empty($item))
				{
					foreach($item as &$vs)
					{
						// 评论时间
						$vs['add_time'] = date('m-d H:i', $vs['add_time']);

						// 评论内容
						$vs['content'] = str_replace("\n", "<br />", $vs['content']);

						// 被回复的用户
						if($vs['reply_id'] > 0)
						{
							$uid = $m->where(array('id'=>$vs['reply_id']))->getField('user_id');
							if(!empty($uid))
							{
								$user = $u->field(array('id AS reply_user_id', 'nickname AS reply_nickname'))->find($uid);
								if(empty($user['reply_nickname']))
								{
									$user['reply_nickname'] = L('common_bubble_mood_nickname');
								}
								$vs = array_merge($vs, $user);
							}
						}
					}
					$v['item'] = $item;
				}
			}
		}
		return $data;
	}

	/**
	 * [MoodDelete 说说删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:36:12+0800
	 */
	public function MoodDelete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数
		$m = M('Mood');
		$id = I('id');

		// 开启事务
		$m->startTrans();

		// 数据删除[说说,点赞,评论]
		$mood_state = $m->where(array('id'=>$id))->delete();
		$praise_state = M('MoodPraise')->where(array('mood_id'=>$id))->delete();
		$comments_state = M('MoodComments')->where(array('mood_id'=>$id))->delete();
		if($mood_state !== false && $praise_state !== false && $comments_state !== false)
		{
			// 提交事务
			$m->commit();

			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			// 回滚事务
			$m->rollback();

			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}

	/**
	 * [MoodPraiseDelete 说说点赞删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:36:12+0800
	 */
	public function MoodPraiseDelete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 数据删除
		if(M('MoodPraise')->delete(I('id')))
		{
			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}

	/**
	 * [MoodCommentsDelete 说说评论删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:36:12+0800
	 */
	public function MoodCommentsDelete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数
		$id = I('id');

		// 模型
		$m = M('MoodComments');

		// 开启事务
		$m->startTrans();

		// 数据删除
		$state = $m->where(array('id'=>$id))->delete();
		$item_state = $m->where(array('parent_id'=>$id))->delete();
		$reply_state = $m->where(array('reply_id'=>$id))->delete();
		if($state !== false && $item_state !== false && $reply_state !== false)
		{
			// 提交事务
			$m->commit();

			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			// 回滚事务
			$m->rollback();

			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}
}
?>