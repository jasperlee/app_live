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
    <title>网络课堂（教师端）</title>
    <link rel="Shortcut Icon" href="images/favicon.ico">
    <link href="css/index.css" rel="stylesheet" />
    <script type="text/javascript" src="http://cdn.aodianyun.com/static/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/player/swfobject.js"></script>
    <script src="http://cdn.aodianyun.com/wis/app.js"></script>
     <script src="http://cdn.aodianyun.com/wis/api.js"></script>
    <script src="js/index-ui.js"></script>
    <script src="js/index-wis.js"></script>
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
        $(function () {
            var init_ok = false;
            var width = 278;
            var height = 180;
            var flashvars = {
                url: lssPublishAddr + "/" + thApp + "/",
                stream: thStream,
                volume: 100 / 100.0,      /* 0 - 1 */
                mode: "publish",
                camIndex: -1,           //摄像头索引
                micIndex: -1,           //麦克风索引
                camWidth: 320,          //摄像头宽
                camHeight: 240,         //摄像头高
                camFps: 10,             //摄像头采集帧率
                keyFrameInterval: 10,   //关键帧间隔
                videoByteRate: 20480,   //视频码率，单位字节每秒
                videoQuality: 80,       //视频质量 1-100
                audioSampleRate: 44,    //音频采样率，单位KHz  可以为5,8,11,22,44
                //noVideo: false,
                bStart: false,
                notifyId: "thPublish",
                onInit: function (notifyId) {
                    init_ok = true;
                },
                onRtmpEvent: function (e, notifyId) {
                    if (e == "NetStream.Publish.PublisherExists") {
                        offMicBtnClick();
                        alert("已经有人上麦咯");
                    }
                },
                onClickEvent: function (notifyId) {
                    console.log("onClickEvent...", notifyId);
                }
            };
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "always";
            params.allowfullscreen = "true";
            params.wmode = "Opaque";
            var attributes = {
                id: "vvMedia1",
                name: "vvMedia1",
                align: "middle"
            };
            swfobject.embedSWF(
                "js/player/player.swf", "vvMedia1",
                width, height,
                "11.0.0", "js/player/playerProductInstall.swf",
                flashvars, params, attributes);
            swfobject.createCSS("#vvMedia1", "display:block;text-align:left;");

            function setVolume(volume) {
                var player = document.getElementById('player');
                if (init_ok) {
                    player.SetVolume(volume / 100.0);
                }
            }
            window.voiceSlider = $(".voiceValue").sliderBar({
                value:100,
                valueChanged: function (slider) {
                    var setVolume = $('#micFrame')[0].contentWindow.setVolume;
                    if (!!setVolume) {
                        setVolume(slider.value);
                    }
                }
            });
            window.micSlider = $(".micValue").sliderBar({
                value: 100,
                valueChanged: function (slider) {
                    var player = document.getElementById('player');
                    if (init_ok) {
                        player.SetVolume(volume / 100.0);
                    }
                }
            });
            $(".offMicBtn").click(function () {
                if ($(this).attr("lssState") == "on") {
                    offMicBtnClick();
                } else {
                    document.getElementById('vvMedia1').SetMode("publish", lssPublishAddr + "/" + thApp + "/", thStream, 0, 0);
                    document.getElementById('vvMedia1').StartPlayer();
                    $(this).attr("lssState", "on");
                    $(this).html("下&nbsp;&nbsp;&nbsp;麦");

                }
            });
        });
        function offMicBtnClick() {
            $(".offMicBtn").attr("lssState", "off");
            $(".offMicBtn").html("上&nbsp;&nbsp;&nbsp;麦");

            document.getElementById('vvMedia1').StopPlayer();
        };
    </script>
</head>
<body >
<div class="mainBody">
<div class="topBar">
    <span class="leftLabel">在线教育-教师端 [ <span id="">李鑫老师</span> ]</span>
    <span class="rightLabel">在线用户：<span id="topTotalLabel">0</span></span>
</div>
<table class="centerHolder">
<tr>
<td>
    <div class="content" id="content">
        <div class="leftBox" id="leftBox" >
            <div class="boardView" id="boardView">
                <div class="toolsBar">
                    <div class="itemSuit colorList itemSuit-first">
                        <div class="toolLabel">颜色</div>
                        <div data-color="#FFD700" class="toolItem"><a style="background-color:#FFD700"></a></div>
                        <div data-color="#FF8C00" class="toolItem selectItem"><a style="background-color:#FF8C00"></a></div>
                        <div data-color="#000080" class="toolItem"><a style="background-color:#000080"></a></div>
                        <div data-color="#9ACD32" class="toolItem"><a style="background-color:#9ACD32"></a></div>
                        <div data-color="#B22222" class="toolItem"><a style="background-color:#B22222"></a></div>
                        <div data-color="#B0E0E6" class="toolItem toolItem-last"><a style="background-color:#B0E0E6"></a></div>
                    </div>
                    <div class="itemSuit lineList">
                        <div class="toolLabel">线粗</div>
                        <div data-line="1" class="toolItem selectItem"><a style="height:1px;"></a></div>
                        <div data-line="2" class="toolItem"><a style="height:2px;"></a></div>
                        <div data-line="4" class="toolItem toolItem-last"><a style="height:4px;"></a></div>
                    </div>
                    <div class="itemSuit toolList">
                        <div class="toolLabel">工具</div>
                        <div data-type="custom" class="toolItem selectItem"><a><img src="images/pen.png"></a></div>
                        <div data-type="rect" class="toolItem"><a><img src="images/rect.png"></a></div>
                        <div data-type="text" class="toolItem"><a><img src="images/texttool.png"></a></div>
                        <div data-type="clear" class="toolItem"><a><img src="images/eraser2.png"></a></div>
                        <div data-cmd="Clear" class="toolItem toolItem-last"><a><img src="images/eraser.png"></a></div>
                    </div>
                    <div class="itemSuit toolList itemSuit-last">
                        <div class="toolLabel"></div>
                        <div data-cmd="Lock" class="toolItem toolItem-last" id="lockTool"><a style="height:30px"><img src="images/lock.png" style="height:100%;"></a></div>
                    </div>
                </div>
                <div class="boardBox" id="boardBox">
                    <div id="wis_context">
                        <div id="wis_context_inner">
                        </div>
                    </div>
                </div>
                <div class="boardBottom">
                    <a href="javascript:WIS.ToPage(1)">&lt;
&lt;
</a>
                    <a href="javascript:WIS.PrevPage()">&lt;</a>
                    <select id="pageList">
                        <option value="1">1</option>
                    </select>
                    <a href="javascript:WIS.NextPage()">&gt;</a>
                    <a href="javascript:WIS.ToPage(pageNum)">&gt;
&gt;
</a>
                </div>
            </div>
            <div style="display:none;" class="videoView" id="videoView"></div>
        </div>
        <div class="rightBox">
            <div class="videoBox">
                <div class="displayBox" id="displayBox"><div id="playerView"><div id="vvMedia1"></div></div></div>
                <div class="displayCtrlBar">
                    <a class="switchBtn" onclick="switchView()"></a>
                    <a id="offMicBtn" class="offMicBtn tis-disableSelect">上&nbsp;
&nbsp;
&nbsp;
麦</a>
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
                    <a onclick="switchTab(this, '#tabBody4');">麦序</a>
                    <a onclick="switchTab(this,'#tabBody2');">文档</a>
                </div>
                <div class="tabBody">
                    <div id="tabBody1" class="tis-container chatWindow"></div>
                    <div id="tabBody2" class="docWindow" style="display:none;">
                        <div class="docList" id="docList">
                        </div>
                        <div class="docUploader">
                            <script>
                                function hasFlash() {
                                    if (document.all) {
                                        var swf = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
                                        if (swf) return true;
                                    } else {
                                        if (navigator.plugins && navigator.plugins.length > 0) {
                                            var swf = navigator.plugins["Shockwave Flash"];
                                            if (swf) return true;
                                        }
                                    }
                                    return false;
                                }
                                if (hasFlash()) {
                                    $(".docUploader").append('<iframe id="uploadify" src="wis/uploadify.html" style="height:100%;width:100%;background-color:white" frameborder="0"></iframe>');

                                } else {
                                    $(".docUploader").append("<a id=\"uploadBtn\" onclick=\"$('#uploadForm').contents().find('#fileUp').click();\">+上传文档&nbsp;&nbsp;</a>");

                                    $(".docUploader").append('<iframe id="uploadForm" style="height:0px;width:0px;display:none;"></iframe>');

                                }
                            </script>
                        </div>
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
                            <a class="clearMicList">清空列表</a>
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
