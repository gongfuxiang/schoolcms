<?php

namespace My;

/**
 * Excel驱动
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-01-10T21:51:08+0800
 */
class Excel
{
	private $filename;
	private $suffix;
	private $data;
	private $title;
	private $string;
	private $jump_url;
	private $msg;

	/**
	 * [__construct 构造方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-10T15:09:17+0800
	 * @param    [string]       $param['filename']	[文件名称（追加当前时间）]
	 * @param    [string]       $param['suffix']	[文件后缀名（默认xls）]
	 * @param    [string]       $param['jump_url']	[出错跳转url地址（默认上一个页面）]
	 * @param    [string]       $param['msg']		[错误提示信息]
	 * @param    [array]        $param['title']		[标题（一维数组，键值对）]
	 * @param    [array]        $param['data']		[数据（二维数组）]
	 */
	public function __construct($param = array())
	{
		// 文件名称
		$date = date('YmdHis');
		$this->filename = isset($param['filename']) ? $param['filename'].'-'.$date : $date;

		// 文件后缀名称
		$this->suffix = empty($param['suffix']) ? 'xls' : $param['suffix'];

		// 标题
		$this->title = isset($param['title']) ? $param['title'] : array();

		// 数据
		$this->data = isset($param['data']) ? $param['data'] : array();

		// 出错跳转地址
		$this->jump_url = empty($param['jump_url']) ? $_SERVER['HTTP_REFERER'] : $param['jump_url'];

		// 错误提示信息
		$this->msg = empty($param['msg']) ? 'data cannot be empty!' : $param['msg'];
	}

	/**
	 * [Export 文件导出]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-10T15:12:01+0800
	 */
	public function Export()
	{
		// 是否有数据
		if(empty($this->title) && empty($data))
		{
			echo '<script>alert("'.$this->msg.'");</script>';
			echo '<script>window.location.href="'.$this->jump_url.'"</script>';
			die;
		}

		// 标题
		$this->string .= implode("\t", $this->title)."\n";
		
		// 内容拼接
		foreach($this->data as $v)
		{
			if(is_array($v) && !empty($v))
			{
				foreach($this->title as $tk=>$tv)
				{
					$this->string .= $v[$tk]."\t";
				}
				$this->string = substr($this->string, 0, -2);
				$this->string .= "\n";
			}
		}
		// 获取配置编码类型
		$excel_charset = MyC('admin_excel_charset', 0);

		// 输出内容
		// 头部
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$this->filename.'.'.$this->suffix);
		header('Pragma: no-cache');
		header('Expires: 0');
		
		// 本身为utf-8不转换, 其它编码则进行转换
		if($excel_charset != 0)
		{
			$this->string = iconv('utf-8', L('common_excel_charset_list')[$excel_charset]['value'], $this->string);
		}
		echo $this->string;
	}
}
?>