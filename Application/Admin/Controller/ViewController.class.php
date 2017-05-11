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
		// 参数
		$type = I('type', 'home');

		// 布局页面类型
		$this->assign('layout_type', $type);

		// 布局+模块列表
		$this->assign('data', $this->GetLayoutList());

		// 友情链接
		$this->assign('link', LayoutLink($type));

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
						$article = LayoutArticleList($lay->GetLayoutMouleWhere($iv), $iv);

						// 模块数据生成
						$fun = GetViewTitleStyleFun($iv['title_style']);
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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
				$article = LayoutArticleList($lay->GetLayoutMouleWhere($_POST), $_POST);

				// 模块数据生成
				$fun = GetViewTitleStyleFun(I('title_style'));
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
	 * [ModuleAdd 模块添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-17T16:49:58+0800
	 */
	public function ModuleAdd()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

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

	/**
	 * [LayoutExport 布局数据导出]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-05-11T16:24:34+0800
	 */
	public function LayoutExport()
	{
		$type = I('type', 'home');
		$data = M('Layout')->where(array('type'=>$type))->select();
		if(!empty($data))
		{
			$module = M('LayoutModule');
			foreach($data as &$v)
			{
				$v['item'] = $module->where(array('layout_id'=>$v['id']))->select();
			}
		}

		// 输出内容
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=layout-'.$type.'.txt');
		header('Pragma: no-cache');
		header('Expires: 0');
		echo serialize($data);
	}

	/**
	 * [LayoutImport 布局数据导入]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-05-11T16:43:53+0800
	 */
	public function LayoutImport()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 文件上传校验
		$error = FileUploadError('file');
		if($error !== true)
		{
			$this->ajaxReturn($error, -1);
		}

		// 文件格式化校验
		$type = array('text/plain');
		if(!in_array($_FILES['file']['type'], $type))
		{
			$this->ajaxReturn(L('theme_upload_error'), -2);
		}
		
		// 读取文件内容
		$data = unserialize(file_get_contents($_FILES['file']['tmp_name']));

		// 初始化变量
		$failure = 0;
		$del_state = false;

		// 数据导入
		if(!empty($data) && is_array($data))
		{
			// 模型
			$layout = M('Layout');
			$module = M('LayoutModule');

			// 开启事务
			$layout->startTrans();

			// 开始处理数据
			foreach($data as $v)
			{
				// 删除原始数据
				if($del_state == false && !empty($v['type']))
				{
					if(!$this->LayoutImportDelete($layout, $module, $v['type']))
					{
						$failure++;
					}
					$del_state = true;
				}

				// 插入模块数据
				if(!empty($v['item']))
				{
					foreach($v['item'] as $vs)
					{
						if($module->add($vs) === false)
						{
							$failure++;
						}
					}
				}

				// 插入新的布局
				if($layout->add($v) === false)
				{
					$failure++;
				}
			}
		}

		// 状态
		if($failure == 0)
		{
			// 提交事务
			$layout->commit();

			$this->ajaxReturn(L('common_import_success_name'));
		} else {
			// 回滚事务
			$layout->rollback();

			$this->ajaxReturn(L('common_import_error_name'), -100);
		}
	}

	/**
	 * [LayoutImportDelete 布局导入删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-05-11T17:23:58+0800
	 * @param    [object] 	  $layout [布局模型]
	 * @param    [object] 	  $module [模块模型]
	 * @param    [string]     $type [布局类型(home, channel, detail)]
	 * @return   [boolean]          [成功true, 失败false]
	 */
	private function LayoutImportDelete($layout, $module, $type)
	{
		$failure = 0;
		$data = $layout->where(array('type'=>$type))->select();
		if(!empty($data))
		{
			foreach($data as $v)
			{
				if($layout->delete($v['id']) === false)
				{
					$failure++;
				}
				if($module->where(array('layout_id'=>$v['id']))->delete() === false)
				{
					$failure++;
				}
			}
		}
		return ($failure == 0);
	}
}
?>