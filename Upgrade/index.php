<?php

/**
 * 升级向导
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-01-11T21:51:08+0800
 */

// 编码
header('Content-type:text/html;charset=utf-8');

// 版本
$ver = '2.1';

// 检测是否已升级过
if(file_exists('./upgrade_'.$ver.'.lock'))
{
    exit('已经升级过，重新升级需要先删除./Upgrade/upgrade_'.$ver.'.lock 文件');
}

// 引入配置文件
$config =  require '../Application/Common/Conf/master.php';
if(empty($config))
{
    exit('../Application/Common/Conf/master.php 配置文件没找到');
}

// 引入公共方法
require '../Application/Common/Common/function.php';
if(function_exists('DelDirFile'))
{
    DelDirFile('../Application/Runtime/Cache');
    DelDirFile('../Application/Runtime/Data');
    DelDirFile('../Application/Runtime/My');
    DelDirFile('../Application/Runtime/Temp');
} else {
    exit('函数未定义[DelDirFile]，请确保升级包文件已覆盖旧文件');
}

// 数据库配置信息
if(empty($config['DB_HOST']) || empty($config['DB_NAME']) || empty($config['DB_USER']) || empty($config['DB_PWD']) || empty($config['DB_PORT']))
{
    exit('数据库配置信息有误');
}

// 连接数据库
$link = @new mysqli("{$config['DB_HOST']}:{$config['DB_PORT']}",$config['DB_USER'],$config['DB_PWD']);

// 获取错误信息
$error = $link->connect_error;
if(!is_null($error))
{
    exit('数据库链接失败：'.$error);
}

// 设置字符集
if(empty($config['DB_CHARSET']))
{
    $config['DB_CHARSET'] = 'utf8';
}
$link->query("SET NAMES '{$config['DB_CHARSET']}'");

// 版本校验
if($link->server_info < 5.0)
{
    exit('请将您的mysql升级到5.0以上');
}

// 数据库是否存在
$is_exist_sql = "SELECT * FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME`='{$config['DB_NAME']}'";
$temp = $link->query($is_exist_sql);
if(!is_object($temp) || $temp->num_rows == 0)
{
    exit('数据库不存在['.$config['DB_NAME'].']');
}

// 选中数据库
$link->select_db($config['DB_NAME']);

// 升级sql
$sql_array = preg_split("/;[\r\n]+/", str_replace('sc_', $config['DB_PREFIX'], file_get_contents('./sql_'.$ver.'.sql')));

// sql运行
$error = 0;
if(!empty($sql_array) && is_array($sql_array))
{
    foreach($sql_array as $sql)
    {
        if(!empty($sql))
        {
            if(!$link->query($sql))
            {
                $error++;
            }
        }
    }
}

// 关闭mysql连接
$link->close();

// 是否运行成功
if($error == 0)
{
    @touch('./upgrade_'.$ver.'.lock');
    exit('恭喜您升级成功 ^_^！');
} else {
    exit('升级失败['.$error.']');
}
?>