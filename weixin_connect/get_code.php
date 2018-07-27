<?php
	$code = $_GET['code'];  //获取oauth2.php回调的code值
	$appid = "wx226711cb571c972d";
	$secret = "d97e92171d83ad3e2d5c9c16cae0a7a7";

	$code_toGet_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
	echo $code_toGet_token_url;

	public function getAccess_tokenJson($url){
    	//初始化一个curl
        $ch = curl_init();
        //设置url 和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//是否进行证书认证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//是否进行证书认证
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//将信息以文件流形式输出
        $output_data = curl_exec($ch);   //执行上面操作
        curl_close($ch);  //释放资源
        return json_decode($output_data,true);  //将数据以json格式传出
    }

$code_toGet_token = getAccess_tokenJson($code_toGet_token_url);  //调用获取accesstoken json数据的方法
var_dump($code_toGet_token);   
	
?>