<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 公共应用入口文件

// 检测是否是新安装
if(is_dir("./Install") && !file_exists("./Install/install.lock"))
{
	$url = $_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],'index.php admin.php').'Install/index.php';
    exit(header('location:http://'.$url));
}

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 分之模式,master,develop,test,debug
define('APP_STATUS', 'develop');

/* 定义系统目录分隔符 */
define('DS', DIRECTORY_SEPARATOR);

// 定义应用目录
define('APP_PATH', './Application'.DS);

// 系统根目录
define('ROOT_PATH', dirname(__FILE__).DS);

?>