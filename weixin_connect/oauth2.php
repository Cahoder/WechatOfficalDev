<?php
	$appid = "wx226711cb571c972d";
	$rediect_url = urlencode("http://cahoder.applinzi.com/weixin_connect/get_code.php");

	$get_oauth2 = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$rediect_url."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
	header("Location:".$get_oauth2);
echo $get_oauth2;
?>