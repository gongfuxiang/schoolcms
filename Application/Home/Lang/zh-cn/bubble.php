<?php

/**
 * 模块语言包-冒泡
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
	'bubble_mood_placeholder'			=>	'说点什么吧',
	'bubble_mood_format'				=>	'先随便说两句吧......',
	'bubble_mood_error'					=>	'说说内容格式 1~168 个字符之间',
	'bubble_visible_text'				=>	'可见范围：',
	'bubble_visible_error'				=>	'可见范围值有误',
	'bubble_is_sign_hover'				=>	'同步至个人签名',
	'bubble_nav_list'					=>	array(
			array('type' => 'all', 'url' => U('Home/Bubble/Index', ['type'=>'all']), 'name' => '冒泡广场'),
			array('type' => 'own', 'url' => U('Home/Bubble/Index', ['type'=>'own']),'name' => '本人冒泡'),
		),
);
?>