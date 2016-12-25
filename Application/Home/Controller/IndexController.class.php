<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 首页
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class IndexController extends Controller
{
	public function index()
	{
		$this->display();
	}
}