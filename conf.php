<?php
class ADConf {
	const	AccessId = "310902426204";
	const	AccessKey = "4y4MWt8x7enylydwDkdh4m7Xg49turCM";
	const 	TisId = "d8ee78aaba905764b326af6a90ba3653";
	const 	DmsSKey = "s_ac043048798010e9cfdc42dbadec6f36";
}
$accessId = ADConf::AccessId;
$accessKey = ADConf::AccessKey;
$dmsSkey = ADConf::DmsSKey;
if(!empty($_REQUEST["tisId"])){
	$tisId = $_REQUEST["tisId"];
} else {
	$tisId = ADConf::TisId;
}
?>
