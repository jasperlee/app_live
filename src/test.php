<?php

require __DIR__ .'/../vendor/soweredu/vendor/autoload.php';

use \soweredu\live\LssAPI;
// curl \
//     -X POST \
//     -d "{"id":"1","content":"Hello world!","date":"2015-06-30 19:42:21"}" \
//     "https://httpbin.org/post"

//$url = 'http://openapi.aodianyun.com/v2/LSS.GetAppLiveStatus';
//$url = 'http://openapi.aodianyun.com/v2/LSS.GetApp';
/*
$data = array(
'access_id' => '310902426204',
'access_key' => '4y4MWt8x7enylydwDkdh4m7Xg49turCM',
//'appid' => 'test-lss',
//"stream"=>"test"
);
$curl = new Curl();
$curl->setHeader('Content-Type', 'application/json');
$curl->post($url, $data);
var_dump($curl->post($url, $data));

 */

$class = new LssAPI('310902426204', '4y4MWt8x7enylydwDkdh4m7Xg49turCM');

echo "<pre>";
print_r($class->getApp());
echo "</pre>";
