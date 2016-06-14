<?php

namespace soweredu\live;

require_once __DIR__ .'/../vendor/autoload.php';

use \Curl\Curl;

/**
 * Class LssAPI
 * @package soweredu\live
 */
class LssAPI {
	private $accessId;
	private $accessKey;

	private $host = 'http://openapi.aodianyun.com';

	/**
	 * [__construct 初始化密钥]
	 * @param [String] $accessId  [安全校验ID]
	 * @param [String] $accessKey [安全校验码]
	 */
	public function __construct($accessId, $accessKey) {
		$this->accessId  = $accessId;
		$this->accessKey = $accessKey;
	}

	/**
	 * [Sign 签名]
	 * @param  [String] $str [签名字符]
	 * @return string [String] $str [签名字符]
	 */
	public function Sign($str) {
		$signature = $this->accessId.":".base64_encode(hash_hmac("sha1", $str, $this->accessKey, true));
		return $signature;
	}

	/**
	 * [request CURL POST 请求]
	 * @param $url
	 * @param array $data
	 * @return array|mixed [array]         [响应结果]
	 * @internal param $ [String] $url  [接口地址]
	 * @internal param $ [array]  $data   [请求参数]
	 */
	public function request($url, array $data) {
		$curl = new Curl();
		$curl->setHeader('Content-Type', 'application/json');
		$curl->post($url, $data);
		$res = $curl->post($url, $data);
		//print_r($res);
		$arr = json_decode($res, true);
		if (json_last_error() != JSON_ERROR_NONE) {
			$arr = array();
		}
		return $arr;
	}

	/**
	 * [getApp 获取LSS服务列表]
	 * @param null $num
	 * @param null $page
	 * @return array|mixed [array|mixed]  [LSS列表]
	 * @internal param $ [String] $num  [条数]
	 * @internal param $ [String] $page [页码]
	 */
	public function getApp($num = null, $page = null) {
		$url  = $this->host.'/v2/LSS.GetApp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
		);
		if ($num) {
			$data['num'] = $num;
		}
		if ($page) {
			$data['page'] = $page;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [openApp 开通LSS服务]
	 * @param $appId
	 * @param $appName
	 * @return array|mixed [array|mixed]     [开通状态]
	 * @internal param $ [String] $appId   [频道id]
	 * @internal param $ [String] $appName [频道名称]
	 */
	public function openApp($appId, $appName) {
		$url  = $this->host.'/v2/LSS.OpenApp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'appname'    => $appName,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [closeApp 关闭LSS服务]
	 * @param  [String] $appId [频道id]
	 * @return array|mixed [array|mixed]   [关闭频道]
	 */
	public function closeApp($appId) {
		$url  = $this->host.'/v2/LSS.CloseApp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [restartApp 重启LSS服务]
	 * @param  [String] $appId [频道id]
	 * @return array|mixed [array|mixed]   [重启频道]
	 */
	public function restartApp($appId) {
		$url  = $this->host.'/v2/LSS.RestartApp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [editApp 修改服务名称]
	 * @param $appId
	 * @param $appName
	 * @return array|mixed [array|mixed]     [修改名称]
	 * @internal param $ [String] $appId   [频道id]
	 * @internal param $ [String] $appName [频道名称]
	 */
	public function editApp($appId, $appName) {
		$url  = $this->host.'/v2/LSS.EditName';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'appname'    => $appName,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [getAppDns 获取域名防盗链]
	 * @param  [String] $appId [频道id]
	 * @return array|mixed [array|mixed]   [防盗链地址]
	 */
	public function getAppDns($appId) {

		$url  = $this->host.'/v2/LSS.GetAppDns';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [setAppDns 设置域名防盗链]
	 * @param $appId
	 * @param array $appDns
	 * @return array|mixed [array|mixed]      [链接列表]
	 * @internal param $ [String] $appId    [频道id]
	 * @internal param $ [array]  $appDns   [域名防盗链列表]
	 */
	public function setAppDns($appId, array $appDns) {
		$url  = $this->host.'/v2/LSS.SetAppDns';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		if ($appDns) {
			$data['appdns'] = $appDns;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [modMicPwd 设置发布令牌]
	 * @param $appId
	 * @param null $micPwd
	 * @param null $micExpire
	 * @return array|mixed [array|mixed]                [令牌字符]
	 * @internal param $ [String] $appId                [频道id]
	 * @internal param $ [String] $micPwd            [发布令牌]
	 * @internal param $ [String] $micExpire        [发布令牌有效时长,单位秒]
	 */
	public function modMicPwd($appId, $micPwd = null, $micExpire = null) {
		$url  = $this->host.'/v2/LSS.ModMicPwd';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		if ($micPwd) {
			$data['micpwd'] = $micPwd;
		}
		if ($micExpire) {
			$data['micexpire'] = $micExpire;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [设置播放令牌]
	 * @param $appId
	 * @param null $micPwd
	 * @param null $micExpire
	 * @return array|mixed [array|mixed]            [令牌字符]
	 * @internal param $ [String] $appId            [频道id]
	 * @internal param $ [String] $micPwd            [播放]
	 * @internal param $ [String] $micExpire        [播放令牌有效时长,单位秒]
	 */
	public function modPlayPwd($appId, $micPwd = null, $micExpire = null) {
		$url  = $this->host.'/v2/LSS.ModPlayPwd';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		if ($micPwd) {
			$data['micpwd'] = $micPwd;
		}
		if ($micExpire) {
			$data['micexpire'] = $micExpire;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [appFlow 流量查看]
	 * @param array $uptime
	 * @param $type
	 * @param bool $bByte
	 * @param null $appId
	 * @return array|mixed [array|mixed]     [流量数值]
	 * @internal param $ [array]   $uptime [流量数据时间周期,格式数组(时间跨度不能超过30天)]
	 * @internal param $ [String]  $type   [流量数据类型,count 或 kbps ]
	 * @internal param $ [boolean] $bByte  [true=流量数据(Byte)，false=带宽数据(bps) 。默认：false，当type="kbps"有效]
	 * @internal param $ [String]  $appId  [频道id]
	 */
	public function appFlow(array $uptime, $type, $bByte = false, $appId = null) {
		$url  = $this->host.'/v2/LSS.AppFlow';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'uptime'     => $uptime,
			'type'       => $type,
		);
		if ($bByte) {
			$data['bByte'] = $bByte;
		}
		if ($appId) {
			$data['appid'] = $appId;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [getMonthPeak 月流量查询]
	 * @param null $appId
	 * @param null $month
	 * @return array|mixed [array|mixed]   [月流量值]
	 * @internal param $ [String] $appId [频道id]
	 * @internal param $ [String] $month [查询时间,由年月组合,月份有前导零,值为数字．空，查询当月流量]
	 */
	public function getMonthPeak($appId = null, $month = null) {
		$url  = $this->host.'/v2/LSS.GetMonthPeak';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
		);
		if ($month) {
			$data['month'] = $month;
		}
		if ($appId) {
			$data['appid'] = $appId;
		}
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [SetMaxDuration 设置最大录制时间]
	 * @param $appId
	 * @param $maxrecordduration
	 * @return array|mixed [array|mixed]   [月流量值]
	 * @internal param $ [String] $appId [频道id]
	 * @internal param $ [integer] $maxrecordduration [录制时间(小时)]
	 *
	 *   [设置录制时间集,必须为数组,]
	 *   示例：“appList”:[ {“appid”:“test”,“maxrecordduration”:1} ];]
	 *
	 *   [maxrecordduration：录制时间(小时),设置范围1-8,值为数字 。必选
	 *     示例：“maxrecordduration”:1;]
	 *
	 */
	public function SetMaxDuration($appId, $maxrecordduration) {
		$url  = $this->host.'/v2/LSS.SetMaxDuration';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appList'    => array(
				array(
					'appid'             => $appId,
					'maxrecordduration' => $maxrecordduration,
				),
			),
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [stopOp 停止发布]
	 * @param $appId
	 * @param $stream
	 * @param $type
	 * @return array|mixed [array|mixed]    [停止发布]
	 * @internal param $ [String] $appId  [频道id]
	 * @internal param $ [String] $stream [stream]
	 * @internal param $ [String] $type   [操作类型，mic：停止发布, 示例：“type”:“mic”]
	 */
	public function stopOp($appId, $stream, $type) {
		$url  = $this->host.'/v2/LSS.ReplayOp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'stream'     => $stream,
			'type'       => $type,

		);
		//echo json_encode($data);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [replayOp 录制管理结束录制重新开始]
	 * @param $appId
	 * @param $stream
	 * @param $type
	 * @return array|mixed [array|mixed]    [重新录制]
	 * @internal param $ [String] $appId  [频道id]
	 * @internal param $ [String] $stream [stream]
	 * @internal param $ [String] $type   [操作类型，video：结束当前录制重新开始, 示例：“type”:"video"]
	 */
	public function replayOp($appId, $stream, $type) {
		$url  = $this->host.'/v2/LSS.ReplayOp';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'stream'     => $stream,
			'type'       => $type,
		);
		//echo json_encode($data);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [setAppReference App阀值设置]
	 * @param $appId
	 * @param $reference
	 * @return array|mixed [array|mixed]    [阀值设置]
	 * @internal param $ [String] $appId  [频道id]
	 * @internal param $ [String] $reference [阀值，示例：“reference”:“100”]
	 */
	public function setAppReference($appId, $reference) {
		$url  = $this->host.'/v2/LSS.SetAppReference';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'reference'  => $reference,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [getAppLiveStatus 判断是否直播]
	 * @param $appId
	 * @param $stream
	 * @return array|mixed [type]         [直播状态]
	 * @internal param $ [type] $appId  [频道id]
	 * @internal param $ [type] $stream [stream]
	 */
	public function getAppLiveStatus($appId, $stream) {
		$url  = $this->host.'/v2/LSS.GetAppLiveStatus';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'stream'     => $stream,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [getAppStreamLiving 判断是否直播]
	 * @param $appId
	 * @return array|mixed [type]         [直播状态]
	 * @internal param $ [type] $appId  [频道id]
	 */
	public function getAppStreamLiving($appId) {
		$url  = $this->host.'/v2/LSS.GetAppStreamLiving';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
		);
		$res = $this->request($url, $data);
		return $res;
	}

	/**
	 * [getPublishInfo 获取当前直播信息、流畅度]
	 * @param $appId
	 * @param $stream
	 * @return array|mixed [type]         [直播状态]
	 * @internal param $ [type] $appId  [频道id]
	 * @internal param $ [type] $stream [stream]
	 */
	public function getPublishInfo($appId = null, $stream = null) {
		$url  = $this->host.'/v2/LSS.GetPublishInfo';
		$data = array(
			'access_id'  => $this->accessId,
			'access_key' => $this->accessKey,
			'appid'      => $appId,
			'stream'     => $stream,
		);
		if ($appId) {
			$data['appid'] = $appId;
		}
		if ($stream) {
			$data['stream'] = $stream;
		}
		$res = $this->request($url, $data);
		return $res;
	}
}
