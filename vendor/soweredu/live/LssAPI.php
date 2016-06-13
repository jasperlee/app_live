<?php

namespace soweredu\live;

require_once __DIR__ .'/../../php-curl-class/php-curl-class/vendor/autoload.php';

use \Curl\Curl;


class LssAPI
{
    private $accessId;
    private $accessKey;

    private $host = 'http://openapi.aodianyun.com';

    /**
     * LssAPI constructor.
     * @param $accessId
     * @param $accessKey
     */
    public function __construct($accessId,$accessKey) {
        $this->accessId = $accessId;
        $this->accessKey = $accessKey;
    }

    /**
     * @param $str
     * @return string
     */
    public function Sign($str){
        $signature = $this->accessId.":".base64_encode(hash_hmac("sha1", $str, $this->accessKey, true));
        return $signature;
    }

    /**
     * @param $url
     * @param array $data
     * @return array|mixed
     */
    public function request($url, $data = array()){
        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json');
        $curl->post($url, $data);
        $res = $curl->post($url, $data);
        $arr = json_decode($res, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $arr = array();
        }
        return $arr;
    }

    /**
     * @param null $num //条数
     * @param null $page //页码
     * @return array|mixed
     */
    public function getApp($num = null, $page = null){
        $url = $this->host . '/v2/LSS.GetApp';
        $data = array(
            'access_id' => $this->accessId,
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
     * @param $appId
     * @param $appName
     * @return array|mixed
     */
    public function openApp( $appId, $appName )
    {
        // TODO : 参数校验
        $url =  $this->host . '/v2/LSS.OpenApp';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
            'appname'   => $appName,
        );
        $res = $this->request( $url, $data );
        return $res;
    }

    /**
     * @param $appId
     * @return array|mixed
     */
    public function closeApp( $appId ){
        $url = $this->host . '/v2/LSS.CloseApp';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
        );

        $res = $this->request( $url , $data);
        return $res;
    }

    /**
     * @param $appId
     * @return array|mixed
     */
    public function restartApp( $appId ){
        $url = $this->host . '/v2/LSS.RestartApp';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
        );

        $res = $this->request( $url , $data);
        return $res;
    }

    /**
     * @param $appId
     * @param $appName
     * @return array|mixed
     */
    public function editApp( $appId, $appName ){
        // TODO : 参数校验
        $url =  $this->host . '/v2/LSS.EditName';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
            'appname'   => $appName,
        );
        $res = $this->request( $url, $data );
        return $res;
    }

    /**
     * @param $appId
     * @return array|mixed
     */
    public function getAppDns( $appId ) {

        $url =  $this->host . '/v2/LSS.GetAppDns';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
        );
        $res = $this->request( $url, $data );
        return $res;
    }

    /**
     * @param $appId
     * @param array $appDns
     * @return array|mixed
     */
    public function setAppDns( $appId, $appDns = array()){
        $url = $this->host . '/v2/LSS.SetAppDns';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
        );
        if ($appDns) {
            $data['appdns'] = $appDns;
        }
        $res = $this->request($url, $data);
        return $res;
    }

    /**
     * @param $appId
     * @param null $micPwd
     * @param null $micExpire
     * @return array|mixed
     */
    public function modMicPwd($appId, $micPwd = null, $micExpire = null)
    {
        $url = $this->host . '/v2/LSS.ModMicPwd';
        $data = array(
            'access_id' => $this->accessId,
            'access_key' => $this->accessKey,
            'appid'     => $appId,
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
}
