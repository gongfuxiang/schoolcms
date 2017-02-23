<?php

namespace Home\Controller;

/**
 * 文章
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ArticleController extends CommonController
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
	}

	/**
     * [Index 文章列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		$article = M('Article')->where(array('id'=>I('id'), 'is_enable'=>1))->find();
		if(!empty($article['content']))
		{
			// 静态资源地址处理
			$article['content'] = ContentStaticReplace($article['content'], 'get');

			// 时间
			$article['add_time'] = date('Y/m/d', $article['add_time']);
		} else {
			exit(L('article_on_exist_error'));
		}
		$this->assign('article', $article);

		// 布局+模块列表
		$this->assign('data', $this->GetLayoutList('detail'));

		// 友情链接
		$this->assign('link', $this->GetLayoutLink('detail'));

		$this->display('Index');
	}
}
?>