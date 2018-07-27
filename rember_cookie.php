<?php 
/**
 * 记住密码/清空密码
 *
 * @param $phone
 * @param $pwd
 * @param $name
 */
function SeTpassword($phone, $pwd , $name, $type){
	if($type == 1) {
		$data = array(
				'phone' => $phone,
				'pwd' => $pwd
		);
		$key = base64_encode(json_encode($data));
		setcookie($name, $key, time() + 3600 * 24 * 7, '/', '', '', true);
	}else{
		setcookie($name,'' , time() - 3600 * 24 * 30, '/', '', '', true);
	}
}

/**
 * 得到保存的密码
 * @param $name
 * @return mixed
 */
function GetPassword($name){
	$info = array();
	if(!isset($_COOKIE[$name])){
		$data['errorCode'] = 1;
	}else{
		if($_COOKIE[$name] == ''){
			$data['errorCode'] = 1;
		}else{
			$key = json_decode(base64_decode($_COOKIE[$name], true),true);
			if(!is_array($key)){
				$data['errorCode'] = 1;
			}else{
				$data['errorCode'] = 0;
				$info['phone'] = $key['phone'];
				$info['pwd'] = $key['pwd'];
				$info['type'] = 1;
			}
		}
	}
	if($data['errorCode'] == 1){
		$info['phone'] = '';
		$info['pwd'] = '';
		$info['type'] = 0;
	}
	return $info;
}



?>