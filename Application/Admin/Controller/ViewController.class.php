<?php

namespace Admin\Controller;

/**
 * 界面管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ViewController extends CommonController
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
     * [Index 列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 布局页面类型
		$this->assign('layout_type', I('type', 'home'));

		// 布局+模块列表
		$this->assign('data', $this->GetLayoutList());

		// 友情链接
		$this->assign('link', $this->GetLayoutLink());

		// 文章分类
		$this->assign('article_class_list', M('ArticleClass')->field(array('id', 'name'))->where(array('is_enable'=>1))->select());

		// 排序
		$this->assign('common_view_sort_list', L('common_view_sort_list'));

		// 时间
		$this->assign('common_view_time_list', L('common_view_time_list'));

		// 标题显示样式
		$this->assign('common_view_title_style_list', L('common_view_title_style_list'));

		// 打开方式
		$this->assign('common_view_link_open_way_list', L('common_view_link_open_way_list'));

		// 日期格式
		$this->assign('common_view_date_format_list', L('common_view_date_format_list'));

		$this->display('Index');
	}

	/**
	 * [GetLayoutLink 获取布局-友情链接]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-22T10:17:14+0800
	 */
	private function GetLayoutLink()
	{
		// 友情链接
		$layout = M('Layout')->field(array('id', 'is_enable'))->where(array('type'=>I('type', 'home').'_link'))->find();
		if(!empty($layout))
		{
			$data = M('Link')->field(array('id', 'name', 'url', 'is_new_window_open', 'describe'))->where(array('is_enable'=>1))->order('sort asc')->select();
		} else {
			$data = array();
		}
		return array('layout'=>$layout, 'data'=>$data);
	}

	/**
	 * [GetLayoutList 获取布局-模块列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-22T10:15:40+0800
	 */
	private function GetLayoutList()
	{
		// 布局+模块列表
		$data = M('Layout')->field(array('id', 'value', 'is_enable'))->where(array('type'=>I('type', 'home')))->order('sort asc, id desc')->select();
		if(!empty($data))
		{
			// 布局模块处理驱动
			$lay = \My\LayoutModule::SetInstance();

			// 开始处理布局数据
			foreach($data as $k=>$v)
			{
				// 模块
				$item = M('LayoutModule')->where(array('layout_id'=>$v['id']))->select();
				if(!empty($item))
				{
					foreach($item as $ik=>$iv)
					{
						// 参数条件json
						$temp_json = $iv;
						if(strlen($temp_json['article_class_id']) > 0)
						{
							$temp_json['article_class_id'] = explode(',', $temp_json['article_class_id']);
						}
						$iv['json'] = json_encode($temp_json);

						// 获取文章数据
						$article = $this->GetArticleList($lay->GetLayoutMouleWhere($iv));

						// 模块数据生成
						$fun = L('common_view_title_style_list')[$iv['title_style']]['fun'];
						$iv['html'] = method_exists($lay, $fun) ? $lay->$fun($article, $iv) : '';

						// 重新赋值
						$item[$ik] = $iv;
					}
				}
				$data[$k]['item'] = $item;
			}
		}
		return $data;
	}

	/**
	 * [GetLayoutModuleData 获取模块数据-及保存模块数据]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-11T21:18:00+0800
	 */
	public function GetLayoutModuleData()
	{
		// 布局模块处理驱动
		$lay = \My\LayoutModule::SetInstance();

		// 模块模型
		$m = D('LayoutModule');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			// 额外数据
			$m->upd_time	=	time();
			$m->right_title	=	str_replace('；', ';', I('right_title'));
			$m->keyword 	=	str_replace(array('；', '—'), array(';', '-'), I('keyword'));
			$m->name 		=	I('name');
			$m->right_title =	I('right_title');
			$m->article_id 	=	I('article_id');
			$m->keyword 	=	I('keyword');

			// 更新数据库
			if($m->where(array('id'=>I('id')))->save())
			{
				// 获取文章数据
				$article = $this->GetArticleList($lay->GetLayoutMouleWhere($_POST));

				// 模块数据生成
				$fun = L('common_view_title_style_list')[I('title_style')]['fun'];
				if(method_exists($lay, $fun))
				{
					$html = $lay->$fun($article, $_POST);
					if(strlen($_POST['article_class_id']) > 0)
					{
						$_POST['article_class_id'] = explode(',', $_POST['article_class_id']);
					}
					$result = array('html' => $html, 'json' => json_encode($_POST));
					$this->ajaxReturn(L('common_operation_edit_success'), 0, $result);
				} else {
					$this->ajaxReturn(str_replace('{$1}', $fun, L('common_method_exists_error')), -101);
				}
			} else {
				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [GetArticleList 获取新闻数据列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-21T14:39:04+0800
	 * @param    [array]    $where [条件列表]
	 * @return   [array]           [新闻数据列表]
	 */
	private function GetArticleList($where)
	{
		return $this->DataHandle(M('Article')->where($where['where'])->order($where['sort'])->limit($where['n'])->select());
	}

	/**
	 * [DataHandle 数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-15T15:38:13+0800
	 * @param    [array]      $data [需要处理的数据]
	 */
	private function DataHandle($data)
	{
		if(!empty($data))
		{
			foreach($data as $k=>$v)
			{
				// 图片
				if(!empty($v['image']))
				{
					$data[$k]['image'] = unserialize($v['image']);
				}

				// url地址
				$data[$k]['url'] = empty($v['jump_url']) ? str_replace('admin.php', 'index.php', U('Home/Article/Index', array('id'=>$v['id']))) : $v['jump_url'];
			}
		}
		return $data;
	}

	/**
	 * [ModuleAdd 模块添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-17T16:49:58+0800
	 */
	public function ModuleAdd()
	{
		// 布局类型
		if(empty($_POST['id']))
		{
			$this->ajaxReturn(L('view_module_param_save_tips'), -1);
		}

		// 数据添加
		$data = array(
				'layout_id'		=>	I('id'),
				'add_time'		=>	time(),
				'upd_time'		=>	time(),
			);
		$id = M('LayoutModule')->add($data);
		if($id > 0)
		{
			$this->ajaxReturn(L('common_operation_add_success'), 0, $id);
		} else {
			$this->ajaxReturn(L('common_operation_add_error'), -100);
		}
	}

	/**
	 * [LayoutSave 布局保存]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-17T16:49:58+0800
	 */
	public function LayoutSave()
	{
		// 布局类型
		if(empty($_POST['type']) || empty($_POST['value']))
		{
			$this->ajaxReturn(L('view_layout_param_save_tips'), -1);
		}

		// 布局数据添加
		$data = array(
				'type'		=>	I('type'),
				'value'		=>	I('value'),
				'upd_time'	=>	time(),
			);
		$layout_id = M('Layout')->add($data);
		if($layout_id > 0)
		{
			$result = array('layout_id' => $layout_id);
			$module = array('100' => 1, '84' => 2, '48' => 2, '633' => 3, '363' => 3, '336' => 3);
			if(array_key_exists($data['value'], $module))
			{
				$count = $module[$data['value']];
				for($i=1; $i<=$count; $i++)
				{
					// 模块数据添加
					$temp_field = 'module'.$i.'_id';
					$temp_module = array(
							'layout_id'		=>	$layout_id,
							'add_time'		=>	time(),
							'upd_time'		=>	time(),
						);
					$result[$temp_field] = M('LayoutModule')->add($temp_module);
				}
				$module_count = $count;
			} else {
				$module_count = 0;
			}
			$result['module_count']	=	$module_count;
			$this->ajaxReturn(L('common_operation_add_success'), 0, $result);
		} else {
			$this->ajaxReturn(L('common_operation_add_error'), -100);
		}
	}

	/**
	 * [StateUpdate 状态更新]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-12T22:23:06+0800
	 */
	public function StateUpdate()
	{
		// 参数
		if(empty($_POST['id']) || !isset($_POST['state']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 数据更新
		if(M('Layout')->where(array('id'=>I('id')))->save(array('is_enable'=>I('state'))))
		{
			$this->ajaxReturn(L('common_operation_edit_success'));
		} else {
			$this->ajaxReturn(L('common_operation_edit_error'), -100);
		}
	}

	/**
	 * [LayoutDelete 布局删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T13:30:50+0800
	 */
	public function LayoutDelete()
	{
		// 参数
		if(empty($_POST['id']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		// 布局模型
		$m = M('Layout');

		// 开启事务
		$m->startTrans();

		// 删除数据
		if($m->delete(I('id')) !== false && M('LayoutModule')->where(array('layout_id'=>I('id')))->delete() !== false)
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
	 * [ModuleDelete 模块删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T13:30:50+0800
	 */
	public function ModuleDelete()
	{
		// 参数
		if(empty($_POST['id']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		if(M('LayoutModule')->delete(I('id')) !== false)
		{
			$this->ajaxReturn(L('common_operation_delete_success'));
		} else {
			$this->ajaxReturn(L('common_operation_delete_error'), -100);
		}
	}

	/**
	 * [LayoutSortSave 布局排序保存]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T16:02:56+0800
	 */
	public function LayoutSortSave()
	{
		// 参数
		if(empty($_POST['data']) || !is_array($_POST['data']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		$success = 0;
		$failure = 0;
		$m = M('Layout');
		foreach($_POST['data'] as $k=>$v)
		{
			if($m->where(array('id'=>intval($v)))->save(array('sort'=>$k)))
			{
				$success++;
			} else {
				$failure++;
			}
		}
		if($success > 0)
		{
			$this->ajaxReturn(L('common_operation_success'));
		} else {
			$this->ajaxReturn(L('common_operation_error'), -100);
		}
	}
}
?>