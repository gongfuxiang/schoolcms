<?php

namespace Home\Controller;

/**
 * 首页
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class IndexController extends CommonController
{
	/**
	 * [Index 首页]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-02-22T16:50:32+0800
	 */
	public function Index()
	{
		// 布局+模块列表
		$this->assign('data', $this->GetLayoutList());

		// 友情链接
		$this->assign('link', $this->GetLayoutLink());

		$this->display();
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
		$data = M('Layout')->field(array('id', 'value'))->where(array('is_enable'=>1, 'type'=>'home'))->order('sort asc, id desc')->select();
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
						// 基础数据处理
						if(!empty($iv['article_class_id']))
						{
							$iv['article_class_id'] = unserialize($iv['article_class_id']);
						}

						// 获取文章数据
						$article = $this->GetArticleList($lay->GetLayoutMouleWhere($iv));

						// 模块数据生成
						$fun = L('common_view_title_style_list')[$iv['title_style']]['fun'];
						$html = method_exists($lay, $fun) ? $lay->$fun($article, $iv) : '';

						// 重新赋值
						$item[$ik] = $html;
					}
				}
				$data[$k]['item'] = $item;
			}
		}
		//print_r($data);
		return $data;
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
}
?>