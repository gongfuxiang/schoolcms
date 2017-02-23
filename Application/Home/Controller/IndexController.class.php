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
		$this->assign('data', $this->GetLayoutList('home'));

		// 友情链接
		$this->assign('link', $this->GetLayoutLink('home'));

		$this->display();
	}
}
?>