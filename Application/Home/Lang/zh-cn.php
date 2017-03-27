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
					'icon'		=>	'am-icon-home',
				),
			array(
					'name'		=>	'学生信息',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-mortar-board fs-12',
					'item'		=>	array(
							array(
									'control'	=>	'Student',
									'action'	=>	'Index',
									'name'		=>	'学生列表',
									'is_show'	=>	1,
									'icon'		=>	'am-icon-th-list',
								)
						)
				),
			array(
					'name'		=>	'会员信息',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-user',
					'item'		=>	array(
							array(
									'control'	=>	'Personal',
									'action'	=>	'Index',
									'name'		=>	'个人资料',
									'is_show'	=>	1,
									'icon'		=>	'am-icon-gear',
								),
							array(
									'control'	=>	'Safety',
									'action'	=>	'Index',
									'name'		=>	'安全设置',
									'is_show'	=>	1,
									'icon'		=>	'am-icon-user-secret',
								),
							array(
									'control'	=>	'User',
									'action'	=>	'Logout',
									'name'		=>	'安全退出',
									'is_show'	=>	1,
									'icon'		=>	'am-icon-power-off',
								),
						)
				),
		),

	// 用户中心未显示的菜单active选中映射（小写）
	'user_left_menu_hidden_active'	=>	array(
			'studentpolyinfo'	=>	'studentindex',
			'studentscoreinfo'	=>	'studentindex',
			'personalsaveinfo'	=>	'Personalindex',
		),

	// 用户顶部导航
	'user_nav_menu'			=>	array(
			array(
					'control'	=>	'User',
					'action'	=>	'Index',
					'name'		=>	'个人中心',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-home',
				),
			array(
					'control'	=>	'Personal',
					'action'	=>	'Index',
					'name'		=>	'个人资料',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-gear',
				),
			array(
					'control'	=>	'Student',
					'action'	=>	'Index',
					'name'		=>	'学生列表',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-mortar-board fs-12 w-14',
				),
			array(
					'control'	=>	'Safety',
					'action'	=>	'Index',
					'name'		=>	'安全设置',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-user-secret',
				),
			array(
					'control'	=>	'User',
					'action'	=>	'Logout',
					'name'		=>	'安全退出',
					'is_show'	=>	1,
					'icon'		=>	'am-icon-power-off',
				),
		),
);
?>