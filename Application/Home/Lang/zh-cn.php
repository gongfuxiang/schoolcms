<?php

/**
 * 模块语言包-前台公共
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	// 用户中心菜单, is_show = [0禁用, 1启用]
	'user_left_menu'		=>	array(
			array(
					'control'	=>	'User',
					'action'	=>	'Index',
					'name'		=>	'个人中心',
					'is_show'	=>	1,
				),
			array(
					'name'		=>	'学生信息',
					'is_show'	=>	1,
					'item'		=>	array(
							array(
									'control'	=>	'Student',
									'action'	=>	'Index',
									'name'		=>	'学生列表',
									'is_show'	=>	1,
								),
							array(
									'control'	=>	'Score',
									'action'	=>	'Index',
									'name'		=>	'成绩查询',
									'is_show'	=>	1,
								),
						)
				),
			array(
					'name'		=>	'会员信息',
					'is_show'	=>	1,
					'item'		=>	array(
							array(
									'control'	=>	'Safety',
									'action'	=>	'Index',
									'name'		=>	'安全设置',
									'is_show'	=>	1,
								),
							array(
									'control'	=>	'User',
									'action'	=>	'Logout',
									'name'		=>	'安全退出',
									'is_show'	=>	1,
								),
						)
				),
		),
);
?>