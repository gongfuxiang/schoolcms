<?php

namespace My;

/**
 * 布局模块驱动
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-01-10T21:51:08+0800
 */
class LayoutModule
{
	// 数据列表
	private $data;

	// 参数规则
	private $rules;

	// 拼接的html
	private $html;

	// 打开方式
	private $blank;

	/**
	 * [__construct 私有构造方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T17:59:50+0800
	 */
	private function __construct(){}

	/**
	 * [SetInstance 类静态方法入口]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:01:09+0800
	 */
	public static function SetInstance()
	{
		static $object = null;
		if(!$object) $object = new self();
		return $object;
	}

	/**
	 * [GetLayoutMouleWhere 获取布局模块条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-14T22:08:22+0800
	 * @param    [array]     $data 	[参数条件]
	 * @return   [array]            [条件列表]
	 */
	public function GetLayoutMouleWhere($data)
	{
		// 条件初始化
		$where = array();

		// 是否启用
		$where['is_enable'] = 1;

		// 是否指定文章id
		if(empty($data['article_id']))
		{
			// 文章分类
			if(!empty($data['article_class_id']) && $data['article_class_id'][0] != 0)
			{
				$where['article_class_id'] = array('in', implode(',', $data['article_class_id']));
			}

			// 发布时间
			if(!empty($data['add_time_interval']))
			{
				$where['add_time_interval'] = array('gt', time()-(L('common_view_time_list')[$data['add_time_interval']]['value'])*60);
			}

			// 更新时间
			if(!empty($data['upd_time_interval']))
			{
				$where['upd_time_interval'] = array('gt', time()-(L('common_view_time_list')[$data['upd_time_interval']]['value'])*60);
			}

			// 关键字
			if(!empty($data['keyword']))
			{
				$keyword = str_replace(array('；', '—'), array(';', '-'), $data['keyword']);
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
		$sort = empty($data['sort_type']) ? '' : str_replace('-', ' ', L('common_view_sort_list')[$data['sort_type']]['value']);

		// 读取条数
		$n = max(1, isset($data['show_number']) ? intval($data['show_number']) : 10);

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
	 * [DataInit 数初始化]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:08:20+0800
	 * @param    [array]     $data 	[数据列表]
	 * @param    [array]     $rules [参数规则]
	 */
	private function DataInit($data, $rules)
	{
		// 初始化
		$this->data = $data;
		$this->rules = $rules;
		$this->html = '';

		// 规则处理
		$this->rules['right_title'] = empty($this->rules['right_title']) ? array() : explode(';', str_replace('；', ';', $this->rules['right_title']));

		// 打开方式
		$this->blank = (isset($this->rules['link_open_way']) && L('common_view_link_open_way_list')[$this->rules['link_open_way']]['value'] == 'blank') ? 'target="_blank"' : '';
	}

	/**
	 * [ViewTitle 纯标题格式]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitle($data, $rules)
	{
		// 数据是否为空
		if(empty($data)) return '';

		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		if(!empty($this->rules['name']) || !empty($this->rules['right_title']))
		{
			$this->html .= '<div class="am-list-news-hd am-cf">';
			if(!empty($this->rules['name']))
			{
				$this->html .= '<h2>'.$this->rules['name'].'</h2>';
			}
			if(!empty($this->rules['right_title']))
			{
				if(isset($this->rules['right_title'][0]))
				{
					if(isset($this->rules['right_title'][1]))
					{
						$this->html .= '<span class="am-list-news-more am-fr">'.$this->rules['right_title'][0].'</span>';
					} else {
						$this->html .= '<a href="'.$this->rules['right_title'][1].'" target="_blank"><span class="am-list-news-more am-fr">'.$this->rules['right_title'][0].'</span></a>';
					}
				}
			}
			$this->html .= '</div>';
		}

		// 列表
		$this->html .= '<div class="am-list-news-bd"><ul class="am-list">';
		foreach($data as $k=>$v)
		{
			// 标题颜色
			$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

			// 内容
			$this->html .= '<li><a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a></li>';
		}
		$this->html .= '</ul></div></div>';

		// 数据返回
		return $this->html;
	}
}
?>