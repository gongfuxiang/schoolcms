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

	// 图片host
	private $image_host;

	/**
	 * [__construct 私有构造方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T17:59:50+0800
	 */
	private function __construct()
	{
		// 图片host
		$this->image_host = C('IMAGE_HOST');
	}

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

		// 是否强制带图片
		if(isset($data['title_style']) && in_array($data['title_style'], array(6, 8, 9, 10, 11, 12, 13, 14, 15)))
		{
			$where['image_count'] = array('egt', 1);
		}

		// 是否指定文章id
		if(empty($data['article_id']))
		{
			// 文章分类
			if(!empty($data['article_class_id']))
			{
				$where['article_class_id'] = array('in', $data['article_class_id']);
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
			$where['id'] = array('in', str_replace('，', ',', $data['article_id']));
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
	 * [GetTitleContent 获取标题内容]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-22T18:12:12+0800
	 */
	private function GetTitleContent()
	{
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
						$this->html .= '<a href="'.$this->rules['right_title'][1].'" target="_blank"><span class="am-list-news-more am-fr">'.$this->rules['right_title'][0].'</span></a>';
					} else {
						$this->html .= '<span class="am-list-news-more am-fr">'.$this->rules['right_title'][0].'</span>';
					}
				}
			}
			$this->html .= '</div>';
		}
	}

	/**
	 * [ViewTitle 纯标题]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitle($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li><a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a></li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewTitleAccess 标题+访问量]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitleAccess($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li class="am-g am-list-item-dated">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-list-item-hd" '.$title_color.'>'.$v['title'].'</a>';
				$this->html .= '<span class="am-list-date">'.str_replace('{$1}', $v['access_count'], L('common_template_access_count')).'</span>';

				$this->html .= '</li>';
			}
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewTitleCreateTime 标题+发布时间]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitleCreateTime($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li class="am-g am-list-item-dated">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-list-item-hd" '.$title_color.'>'.$v['title'].'</a>';

				// 日期
				$temp_date = date(L('common_view_date_format_list')[$this->rules['date_format']]['value'], $v['add_time']);
				$this->html .= '<span class="am-list-date">'.$temp_date.'</span>';

				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewTitleAbstract 标题+摘要]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitleAbstract($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li class="am-g am-list-item-desced">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a>';

				// 摘要字数
				$abstract_number = isset($this->rules['abstract_number']) ? intval($this->rules['abstract_number']) : 80;
				$temp_content = mb_substr(strip_tags($v['content']), 0, $abstract_number, C('DEFAULT_CHARSET'));
				$this->html .= '<div class="am-list-item-text">'.$temp_content.'</div>';

				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewTitleAbstractOne 标题+第一条摘要]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewTitleAbstractOne($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li class="am-g am-list-item-desced">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a>';

				// 第一条带摘要
				if($k == 0)
				{
					$abstract_number = isset($this->rules['abstract_number']) ? intval($this->rules['abstract_number']) : 80;
					$temp_content = mb_substr(strip_tags($v['content']), 0, $abstract_number, C('DEFAULT_CHARSET'));
					$this->html .= '<div class="am-list-item-text">'.$temp_content.'</div>';
				}

				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewImagesContent 图文]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesContent($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 摘要
				$abstract_number = isset($this->rules['abstract_number']) ? intval($this->rules['abstract_number']) : 80;
				$temp_content = mb_substr(strip_tags($v['content']), 0, $abstract_number, C('DEFAULT_CHARSET'));

				// 内容
				if(empty($v['image'][0]))
				{
					$this->html .= '<li class="am-g am-list-item-desced">';
					$this->html .= '<div class="am-list-main">';
				} else {
					$this->html .= '<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">';
					$this->html .= '<div class="am-u-sm-4 am-list-thumb"><a href="'.$v['url'].'" '.$this->blank.'><img src="'.$this->image_host.$v['image'][0].'" alt="'.$v['title'].'"/></a></div>';

					$this->html .= '<div class="am-u-sm-8 am-list-main">';
				}
				$this->html .= '<h3 class="am-list-item-hd"><a href="'.$v['url'].'" '.$this->blank.'>'.$v['title'].'</a></h3><div class="am-list-item-text">'.$temp_content.'</div></div>';
				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewOneIntroductionTwoTitle 一简介+两列标题]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewOneIntroductionTwoTitle($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul class="am-list">';
			foreach($data as $k=>$v)
			{
				// 标题颜色
				$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

				// 内容
				$this->html .= '<li class="am-g am-list-item-desced">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a>';

				// 第一条带摘要
				if($k%3 == 0)
				{
					$abstract_number = isset($this->rules['abstract_number']) ? intval($this->rules['abstract_number']) : 80;
					$temp_content = mb_substr(strip_tags($v['content']), 0, $abstract_number, C('DEFAULT_CHARSET'));
					$this->html .= '<div class="am-list-item-text">'.$temp_content.'</div>';
				}

				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewImagesSlide 文章图片幻灯片]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesSlide($data, $rules)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news am-list-news-default">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<div data-am-widget="slider" class="am-slider am-slider-c3" data-am-slider=\'{"controlNav":false}\'><ul class="am-slides">';
			$count = count($data);
			foreach($data as $k=>$v)
			{
				// 内容
				$this->html .= '<li style="height:;">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.' title="'.$v['title'].'"><img src="'.$this->image_host.$v['image'][0].'" alt="'.$v['title'].'" /></a>';
				$this->html .= '<div class="am-slider-desc"><div class="am-slider-counter"><span class="am-active">'.($k+1).'</span>/'.$count.'</div>'.$v['title'].'</div>';
				$this->html .= '</li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div></div>';

		// 数据返回
		return $this->html;
	}

	/**
	 * [ViewImagesList112 文章图片列表-112]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList112($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 1, 1, 2);
	}

	/**
	 * [ViewImagesList122 文章图片列表-122]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList122($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 1, 2, 2);
	}

	/**
	 * [ViewImagesList123 文章图片列表-123]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList123($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 1, 2, 3);
	}

	/**
	 * [ViewImagesList222 文章图片列表-222]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList222($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 2, 2, 2);
	}

	/**
	 * [ViewImagesList223 文章图片列表-223]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList223($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 2, 2, 3);
	}

	/**
	 * [ViewImagesList234 文章图片列表-234]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList234($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 2, 3, 4);
	}

	/**
	 * [ViewImagesList236 文章图片列表-236]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	public function ViewImagesList236($data, $rules)
	{
		return $this->ViewImagesList($data, $rules, 2, 3, 6);
	}

	/**
	 * [ViewImagesList 文章图片列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-20T18:06:08+0800
	 * @param    [array]    $data 	[数据列表]
	 * @param    [array]    $rules 	[参数规则]
	 */
	private function ViewImagesList($data, $rules, $sm, $md, $lg)
	{
		// 数据初始化
		$this->DataInit($data, $rules);

		// 开始处理数据
		$this->html = '<div class="am-list-news layout-images-list">';

		// 标题
		$this->GetTitleContent();

		// 数据列表
		$this->html .= '<div class="am-list-news-bd">';

		// 自定义内容为空, 并且数据列表不为空
		if(empty($this->rules['summary']) && !empty($data))
		{
			$this->html .= '<ul data-am-widget="gallery" class="am-gallery am-avg-sm-'.$sm.' am-avg-md-'.$md.' am-avg-lg-'.$lg.' am-gallery-overlay layout-gallery-overlay-'.$sm.$md.$lg.'" data-am-gallery="{}">';
			foreach($data as $k=>$v)
			{
				// 内容
				$this->html .= '<li><div class="am-gallery-item o-h">';
				$this->html .= '<a href="'.$v['url'].'" '.$this->blank.'><img src="'.$this->image_host.$v['image'][0].'"  alt="'.$v['title'].'"/><h3 class="am-gallery-title">'.$v['title'].'</h3></a>';
				$this->html .= '</div></li>';
			}
			$this->html .= '</ul>';
		} else {
			// 自定义内容
			$this->html .= $this->rules['summary'];
		}

		// 内容收尾处理
		$this->html .= '</div></div>';

		// 数据返回
		return $this->html;
	}
}
?>