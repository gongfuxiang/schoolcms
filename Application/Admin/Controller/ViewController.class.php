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
	 * [GetLayoutModuleData 获取模块数据-及保存模块数据]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-11T21:18:00+0800
	 */
	public function GetLayoutModuleData()
	{
		// 条件处理
		$where = $this->GetLayoutMouleWhere();

		// 模块模型
		$m = D('LayoutModule');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			// 额外数据
			$m->upd_time	=	time();
			$m->where 		=	serialize($where);
			$m->right_title	=	str_replace('；', ';', I('right_title'));
			$m->keyword 	=	str_replace(array('；', '—'), array(';', '-'), I('keyword'));

			// 更新数据库
			if($m->where(array('id'=>I('id')))->save())
			{
				// 数据保存
				$data = $this->DataHandle(M('Article')->where($where['where'])->order($where['sort'])->limit($where['n'])->select());

				// 模块数据生成
				$fun = L('common_view_title_style_list')[I('title_style')]['fun'];
				$lay = \My\LayoutModule::SetInstance();
				$html = $lay->$fun($data, $_POST);
				$this->ajaxReturn(L('common_operation_edit_success'), 0, $html);
			} else {
				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
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
				// 摘要字数
				$abstract_number = isset($_POST['abstract_number']) ? intval($_POST['abstract_number']) : 80;
				$data[$k]['content'] = mb_substr(strip_tags($v['content']), 0, $abstract_number, C('DEFAULT_CHARSET'));

				// 图片
				if(!empty($v['image']))
				{
					$data[$k]['image'] = unserialize($v['image']);
				}

				// 日期格式
				$date_format = empty($_POST['date_format']) ? 'Y-m-d' : L('common_view_date_format_list')[I('date_format')]['value'];
				$data[$k]['add_time'] = date($date_format, $v['add_time']);

				// url地址
				$data[$k]['url'] = empty($v['jump_url']) ? str_replace('admin.php', 'index.php', U('Home/Article/Index', array('id'=>$v['id']))) : $v['jump_url'];
			}
		}
		return $data;
	}

	/**
	 * [GetLayoutMouleWhere 获取布局模块条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-14T22:08:22+0800
	 */
	private function GetLayoutMouleWhere()
	{
		// 条件初始化
		$where = array();

		// 是否启用
		$where['is_enable'] = 1;

		// 是否指定文章id
		if(empty($_POST['article_id']))
		{
			// 文章分类
			if(!empty($_POST['article_class_id']) && $_POST['article_class_id'][0] != 0)
			{
				$where['article_class_id'] = array('in', implode(',', I('article_class_id')));
			}

			// 发布时间
			if(!empty($_POST['add_time_interval']))
			{
				$where['add_time_interval'] = array('gt', time()-(L('common_view_time_list')[I('add_time_interval')]['value'])*60);
			}

			// 更新时间
			if(!empty($_POST['upd_time_interval']))
			{
				$where['upd_time_interval'] = array('gt', time()-(L('common_view_time_list')[I('upd_time_interval')]['value'])*60);
			}

			// 关键字
			if(!empty($_POST['keyword']))
			{
				$keyword = str_replace(array('；', '—'), array(';', '-'), I('keyword'));
				if(strpos($keyword, ';') === false)
				{
					$where['title'][] = $this->TitleWhereJoin($keyword);
				} else {
					$keyword_all = explode(';', $keyword);
					foreach($keyword_all as $temp_keyword)
					{
						$where['title'][] = $this->TitleWhereJoin($temp_keyword);
					}
				}
			}
		} else {
			$where['id'] = array('in', str_replace('，', ',', I('article_id')));
		}

		// 排序方式
		$sort = empty($_POST['sort_type']) ? '' : str_replace('-', ' ', L('common_view_sort_list')[I('sort_type')]['value']);

		// 读取条数
		$n = max(1, isset($_POST['show_number']) ? intval($_POST['show_number']) : 10);

		// 返回数据
		return array('where' => $where, 'sort' => $sort, 'n' => $n);
	}

	/**
	 * [TitleWhereJoin 关键字检索条件拼接]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-15T14:07:48+0800
	 * @param    [string]      $keyword [需要解析的关键字]
	 * @return   [array] 				[拼接完成的关键字]
	 */
	private function TitleWhereJoin($keyword)
	{
		// 标记判断, 并且-, 或|
		$tag = (strpos($keyword, '-') !== false) ? '-' : ((strpos($keyword, '|') !== false) ? '|' : '');

		// 数据处理
		if(empty($tag))
		{
			return array('eq', $keyword);
		} else {
			$join = ($tag == '-') ? 'AND' : (($tag == '|') ? 'OR' : '');
			$temp_all = explode($tag, $keyword);
			foreach($temp_all as $k=>$temp_keyword)
			{
				$temp_all[$k] = '%'.$temp_keyword.'%';
			}
			return array('like', $temp_all, $join);
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
			$module = array('100' => 1, '31' => 2, '13' => 2, '211' => 3, '121' => 3, '112' => 3);
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