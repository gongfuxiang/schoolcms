<?php

/**
 * 安装向导
 */
// 编码
header('Content-type:text/html;charset=utf-8');

// 检测是否安装过
if(file_exists('./install.lock'))
{
    exit('你已经安装过该系统，重新安装需要先删除./Install/install.lock 文件');
}

// 参数
$c = isset($_GET['c']) ? trim($_GET['c']) : '';

// 同意协议页面
if($c == 'agreement' || empty($c))
{
    exit(require './agreement.html');
}
// 检测环境页面
if($c == 'test')
{
    exit(require './test.html');
}
// 创建数据库页面
if($c == 'create')
{
    exit(require './create.html');
}
// 安装成功页面
if($c == 'success')
{
    // 判断是否为post
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $data=$_POST;
        // 连接数据库
        $link=@new mysqli("{$data['DB_HOST']}:{$data['DB_PORT']}",$data['DB_USER'],$data['DB_PWD']);
        // 获取错误信息
        $error=$link->connect_error;
        if (!is_null($error)) {
            // 转义防止和alert中的引号冲突
            $error=addslashes($error);
            die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
        }
        // 设置字符集
        $link->query("SET NAMES 'utf8'");
        $link->server_info>5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
        // 创建数据库并选中
        if(!$link->select_db($data['DB_NAME'])){
            $create_sql='CREATE DATABASE IF NOT EXISTS '.$data['DB_NAME'].' DEFAULT CHARACTER SET utf8;';
            $link->query($create_sql) or die('创建数据库失败');
            $link->select_db($data['DB_NAME']);
        }
        // 导入sql数据并创建表
        $schoolcms_str=file_get_contents('./schoolcms.sql');
        $sql_array=preg_split("/;[\r\n]+/", str_replace('sc_',$data['DB_PREFIX'],$schoolcms_str));
        foreach ($sql_array as $k => $v) {
            if (!empty($v)) {
                $link->query($v);
            }
        }
        $link->close();
        $db_str=<<<php
<?php

/**
 * 数据库配置信息-自动安装生成
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
return array(
    // 数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '{$data['DB_HOST']}', // 服务器地址
    'DB_NAME'   => '{$data['DB_NAME']}', // 数据库名
    'DB_USER'   => '{$data['DB_USER']}', // 用户名
    'DB_PWD'    => '{$data['DB_PWD']}', // 密码
    'DB_PORT'   => {$data['DB_PORT']}, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => '{$data['DB_PREFIX']}', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  false, // 数据库调试模式 开启后可以记录SQL日志
);
?>
php;
        // 创建数据库链接配置文件,master,develop,test,debug 分别都更新，core模式没更改
        file_put_contents('../Application/Common/Conf/master.php', $db_str);
        file_put_contents('../Application/Common/Conf/develop.php', $db_str);
        file_put_contents('../Application/Common/Conf/test.php', $db_str);
        file_put_contents('../Application/Common/Conf/debug.php', $db_str);
        @touch('./install.lock');
        exit(require './success.html');
    }
}
exit('非法访问');
?>