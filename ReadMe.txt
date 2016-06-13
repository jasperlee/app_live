1、将conf.php中$accessId、$accessKey、$dmsSkey、$tisId参数改写成自己的信息

2、js/index-wis.js中
	发布播放相关参数修改成自己的信息：
	lssApp = lssApp ? lssApp : "wsp_4640_1435544235";   //学生端lssApp
	lssStream = lssStream ? lssStream : "student";      //学生端lssStream
	thApp = thApp ? thApp : "wsp_4640_1435544235";      //教师端thApp
	thStream = thStream ? thStream : "teacher";         //教师段thStream
	adUserId = adUserId ? adUserId : "4640";            //奥点云帐号Id	
	将WIS相关参数部分的wisId修改成自己的信息：
    wisId = wisId ? wisId : "1916475f45b87b210bd50ace6db400b0";
    将TIS相关参数部分的tisId修改成自己的信息：
    tisId = tisId ? tisId : "c80e8f83ae41fc26545e7700a62a8a0e";
	
3、配置完毕后就可以运行了。系统分为教师端和学生端，教师端的页面manage.html，学生端的页面是room.html。