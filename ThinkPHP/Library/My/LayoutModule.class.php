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
			// 打开方式
			$blank = (isset($this->rules['link_open_way']) && L('common_view_link_open_way_list')[$this->rules['link_open_way']]['value'] == 'blank') ? 'target="_blank"' : '';

			// 标题颜色
			$title_color = (!empty($v['title_color'])) ? 'style="color:'.$v['title_color'].';"' : '';

			// 内容
			$this->html .= '<li><a href="'.$v['url'].'" '.$blank.' title="'.$v['title'].'" class="am-text-truncate" '.$title_color.'>'.$v['title'].'</a></li>';
		}
		$this->html .= '</ul></div></div>';

		// 数据返回
		return $this->html;
	}
}
?>