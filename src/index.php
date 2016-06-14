<?php

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/../vendor/soweredu/vendor/autoload.php';

use RestService\Server;
use soweredu\live\LssAPI;

Server::create('/')
    ->addGetRoute('test', function(){
        $class = new LssAPI('310902426204', '4y4MWt8x7enylydwDkdh4m7Xg49turCM');
        $res = $class->getApp();
        return $res;
    })
    ->addGetRoute('foo/(.*)', function($bar){
        return $bar;
    })
    ->run();

