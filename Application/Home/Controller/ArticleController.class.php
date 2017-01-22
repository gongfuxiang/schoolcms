<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 文章
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class ArticleController extends Controller
{
	/**
	 * [_initialize 前置操作-继承公共前置方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:39:08+0800
	 */
	/*public function _initialize()
	{
		// 调用父类前置方法
		parent::_initialize();
	}*/

	/**
     * [Index 文章列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		$data = M('Article')->where(array('id'=>I('id'), 'is_enable'=>1))->find();
		if(!empty($data['content']))
		{
			// 静态资源地址处理
			$data['content'] = ContentStaticReplace($data['content'], 'get');
		} else {
			exit('文章不存在或已删除');
		}
			
		$this->assign('data', $data);
		$this->display('Index');
	}
}
?>