﻿<?php
header("Content-Type: text/html;charset=utf-8");

ini_set("display_errors", "On");
error_reporting(E_ALL|E_STRICT);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>网络课堂（学生端）</title>
    <link rel="Shortcut Icon" href="images/favicon.ico">
    <link href="css/index.css" rel="stylesheet" />
    <script type="text/javascript" src="http://cdn.aodianyun.com/static/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianpublish/publish.js"></script>
    <script src="http://cdn.aodianyun.com/wis/app.js"></script>
     <script src="http://cdn.aodianyun.com/wis/api.js"></script>
    <script src="js/index-ui-c.js"></script>
    <script src="js/index-wis.js?wisWidth=861&wisHeight=608&manager=0"></script>
    <!--Tis默认UI样式-->
    <link href="http://cdn.aodianyun.com/tis/ui/default/css/jquery.splitter.css" rel="stylesheet" />
    <link href="http://cdn.aodianyun.com/tis/shared/css/idangerous.swiper.css" rel="stylesheet" />
    <link href="http://cdn.aodianyun.com/tis/ui/default/css/tis-ui-1.1.css" rel="stylesheet" />
    <!--Tis基础库-->
    <script type="text/javascript" src="http://cdn.aodianyun.com/static/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/tis/core/tis-api-1.1.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/tis/core/tis-1.1.js"></script>
    <!--Tis默认UI脚本-->
    <script type="text/javascript" src="http://cdn.aodianyun.com/tis/ui/default/js/jquery.splitter-0.14.0.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/tis/shared/js/idangerous.swiper-2.0.min.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/tis/ui/default/js/tis-ui-1.1.js"></script>
    <script type="text/javascript">
        var objectPlayer;
        $(function () {
            objectPlayer = new aodianPlayer({
                container: 'playerView',//播放器容器ID，必要参数
                rtmpUrl: thPlay,//控制台开通的APP rtmp地址，必要参数
                hlsUrl: thHlsPlay,
                /* 以下为可选参数*/
                width: '278',//播放器宽度，可用数字、百分比等
                height: '180',//播放器高度，可用数字、百分比等
                autostart: true,//是否自动播放，默认为false
                bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
                maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
                stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
                controlbardisplay: 'disable',//是否显示控制栏，值为：disable、enable默认为disable。
                defvolume: 100,
            });
            window.voiceSlider = $(".voiceValue").sliderBar({
                value:100,
                valueChanged: function (slider) {
                    if (!!objectPlayer.setVolume) {
                        objectPlayer.setVolume(slider.value);
                    }
                }
            });
            window.micSlider = $(".micValue").sliderBar({
                value: 100,
                valueChanged: function (slider) {
                    var setVolume = $('#micFrame')[0].contentWindow.setVolume;
                    if (!!setVolume) {
                        setVolume(slider.value);
                    }
                }
            });
            $(".offMicBtn").click(function () {
                sendCustomMessage({
                    msg: JSON.stringify({
                        msgType: "handUp",
                        clientId: getTisClientId(),
                        app: lssApp,
                        stream: lssStream
                    }),
                    success: function () {
                        console.log("发送举手消息成功");
                    },
                    error: function (error) {
                        console.log("发送举手消息失败:", error);
                    }
                });
            });
        });
    </script>
</head>
<body >
<div class="mainBody">
<div class="topBar">
    <span class="leftLabel">在线教育-学生端 [ <span id="topNameLabel"></span> ]</span>
    <span class="rightLabel">在线用户：<span id="topTotalLabel">0</span></span>
</div>
<table class="centerHolder">
<tr>
<td>
    <div class="content" id="content">
        <div class="leftBox" id="leftBox" >
            <div class="boardView" id="boardView" style="padding:0px;width:100%;height:100%;">
                <div class="boardBox" id="boardBox" style="width:100%;height:100%;">
                    <div id="wis_context">
                        <div id="wis_context_inner">
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:none;" class="videoView" id="videoView"></div>
        </div>
        <div class="rightBox">
            <div class="videoBox">
                <div class="displayBox" id="displayBox"><div id="playerView"></div></div>
                <div class="displayCtrlBar">
                    <a class="switchBtn" onclick="switchView()"></a>
                    <a class="offMicBtn tis-disableSelect" style="padding:0px 10px 0px 10px">申请发言</a>
                    <a class="adjustBtn">
                        <div class="adjustHead"></div>
                        <div class="sliderBar voiceValue"></div>
                        <div class="sliderBar micValue"></div>
                    </a>
                </div>
            </div>
            <div class="tabsBox">
                <div class="tabsHeader">
                    <a onclick="switchTab(this,'#tabBody1');" class="selectTab" href="javascript:tissplit.refresh()">聊天</a>
                    <a onclick="switchTab(this, '#tabBody3');">用户</a>
                    <a id="micTabBtn" onclick="switchTab(this, '#tabBody4');">麦序</a>
                </div>
                <div class="tabBody">
                    <div id="tabBody1" class="tis-container chatWindow"></div>
                    <div id="tabBody2" class="docWindow" style="display:none;">
                        <div class="docList" id="docList">
                        </div>
                        <div class="docUploader">
                            <a id="uploadBtn" onclick="$('#uploadForm').contents().find('#fileUp').click();">+上传文档&nbsp;
&nbsp;
</a>
                        </div>
                        <iframe id="uploadForm" style="height:0px;width:0px;display:none;"></iframe>
                    </div>
                    <div id="tabBody3" >
                        <div class="userList"></div>
                    </div>
                    <div id="tabBody4" class="micWindow">
                        <div id="micFrameWrap">
                            <div>当前发言者：<span id="curMicIdLabel"></span></div>
                            <iframe id="micFrame" frameborder="0"></iframe>
                        </div>
                        <div class="micList"></div>
                        <div>
                            <a class="clearMicList" style="display:none">发言完毕</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</td>
</tr>
</table>
</div>
</body>
</html>
