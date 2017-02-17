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
	 * [GetLayoutModuleData 获取模块数据]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-11T21:18:00+0800
	 */
	public function GetLayoutModuleData()
	{
		$result = $this->GetLayoutMouleWhere();
		$data = $this->DataHandle(M('Article')->where($result['where'])->order($result['sort'])->limit($result['n'])->select());

		$result = array(
			'data'				=>	$data,
			'fun'				=>	L('common_view_title_style_list')[I('title_style')]['fun'],
			'link_open_way'		=>	L('common_view_link_open_way_list')[I('link_open_way')]['value'],
			'name'				=>	I('name'),
			'right_title'		=>	empty($_POST['right_title']) ? array() : explode(';', I('right_title')),
		);
		$this->ajaxReturn('操作成功', 0, $result);
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
			if(!empty($_POST['add_time']))
			{
				$where['add_time'] = array('gt', time()-L('common_view_time_list')[I('add_time')]['value']);
			}

			// 更新时间
			if(!empty($_POST['upd_time']))
			{
				$where['upd_time'] = array('gt', time()-L('common_view_time_list')[I('upd_time')]['value']);
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
		$sort = empty($_POST['sort']) ? '' : str_replace('-', ' ', L('common_view_sort_list')[I('sort')]['value']);

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
}
?>