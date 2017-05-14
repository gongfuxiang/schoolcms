<?php

namespace My;

/**
 * 短信驱动
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Sms
{
	private $expire_time;
	private $key_code;
	private $sign;
	public $error;

	/**
	 * [__construct 构造方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T14:03:02+0800
	 * @param    [int]        $param['interval_time'] 	[间隔时间（默认30）单位（秒）]
	 * @param    [int]        $param['expire_time'] 	[到期时间（默认30）单位（秒）]
	 * @param    [string]     $param['key_prefix'] 		[验证码种存储前缀key（默认 空）]
	 */
	public function __construct($param = array())
	{
		$this->sign = '【'.MyC('common_sms_sign').'】';
		$this->interval_time = isset($param['interval_time']) ? intval($param['interval_time']) : 30;
		$this->expire_time = isset($param['expire_time']) ? intval($param['expire_time']) : 30;
		$this->key_code = isset($param['key_prefix']) ? trim($param['key_prefix']).'_sms_code' : '_sms_code';
	}

	/**
	 * [SendText 发送文字短信]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T14:16:26+0800
	 * @param    [string]    $mobile  [手机号码]
	 * @param    [string]    $content [短信内容]
	 * @param    [string]    $code    [验证码（存在则种验证码）]
	 */
	public function SendText($mobile, $content, $code = '')
	{
		// 是否频繁操作
		if(!$this->IntervalTimeCheck())
		{
			$this->error = L('common_prevent_harassment_error');
			return false;
		}

		// 验证码替换
		if(!empty($code))
		{
			$content = str_replace('#code#', $code, $content);
		}

		// 请求发送
		$param = array(
				'apikey'  =>  MyC('common_sms_apikey'),
				'text'    =>  $this->sign.$content,
				'mobile'  =>  $mobile,
			);
		$result = json_decode(Fsockopen_Post('https://sms.yunpian.com/v2/sms/single_send.json', $param), true);

		// 错误信息
		if(isset($result['detail']))
		{
			$this->error = $result['detail'];
		}

		// 是否发送成功
		if(isset($result['code']) && $result['code'] == 0)
		{
			// 是否存在验证码
			if(!empty($code))
			{
				$this->KindofSession($code);
			}
			return true;
		}
		return false;
	}

	/**
	 * [KindofSession 种验证码session]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-07T14:59:13+0800
	 * @param    [string]      $code [验证码]
	 */
	private function KindofSession($code)
	{
		$_SESSION[$this->key_code] = array(
				'code' => $code,
				'time' => time(),
			);
	}

	/**
	 * [CheckExpire 验证码是否过期]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-05T19:02:26+0800
	 * @return   [boolean] [有效true, 无效false]
	 */
	public function CheckExpire()
	{
		if(isset($_SESSION[$this->key_code]))
		{
			$data = $_SESSION[$this->key_code];
			return (time() <= $data['time']+$this->expire_time);
		}
		return false;
	}

	/**
	 * [CheckCorrect 验证码是否正确]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-05T16:55:00+0800
	 * @param    [string] $code    [验证码（默认从post读取）]
	 * @return   [booolean]        [正确true, 错误false]
	 */
	public function CheckCorrect($code = '')
	{
		if(isset($_SESSION[$this->key_code]['code']))
		{
			if(empty($code) && isset($_POST['code']))
			{
				$code = trim($_POST['code']);
			}
			return ($_SESSION[$this->key_code]['code'] == $code);
		}
		return false;
	}

	/**
	 * [Remove 验证码清除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-08T10:18:20+0800
	 * @return   [other] [无返回值]
	 */
	public function Remove()
	{
		if(isset($_SESSION[$this->key_code]))
		{
			unset($_SESSION[$this->key_code]);
		}
	}

	/**
	 * [IntervalTimeCheck 是否已经超过控制的间隔时间]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-03-10T11:26:52+0800
	 * @return   [booolean]        [已超过间隔时间true, 未超过间隔时间false]
	 */
	private function IntervalTimeCheck()
	{
		if(isset($_SESSION[$this->key_code]))
		{
			$data = $_SESSION[$this->key_code];
			return (time() > $data['time']+$this->interval_time);
		}
		return true;
	}
}
?>