<?php
session_start();
$type_ = $_GET['revise_type'];
$conn = mysqli_connect("localhost", "login", "123456", "lyb_proj");
switch ($type_)
{
	case "check_name":
		$user = $_GET['user'];
		$sql = "select * from lyb_user where user_name='".$user."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
				echo "已被使用!";
		}else {
				echo "可以使用!";
		}
		break;
	case "pin_change":
	$new_pwd = $_GET['pwd'];
	$sql = "update lyb_user set password='".md5($new_pwd)."' where user_name='".$_SESSION['user_name']."'";
	$result = mysqli_query($conn, $sql);
	if ($result){
		echo "修改成功";
	}else {
		echo "修改失败";
	}
	break;
	//普通用户删除消息（实际只是屏蔽）
	case "msg_hide":
		$change_id = $_GET['oper_id'];
		$sql = "update person_letter set control_state = 0 where id='".$change_id."'";
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "删除成功";
		}else {
			echo "删除失败";
		}
		$sqll = "update person_letter set read_state = 0 where id='".$change_id."'";
		$resultl = mysqli_query($conn, $sqll);
		break;
	//查看留言详细信息
	case "look_display":
		$look_id = $_GET['message_id'];
		$sql = "select send_cont from person_letter where id='".$look_id."'";
		$result = mysqli_query($conn, $sql);
		$msg = mysqli_fetch_array($result);
		echo $msg['send_cont'];
		$sqll = "update person_letter set read_state = 0 where id='".$look_id."'";
		$resultl = mysqli_query($conn, $sqll);
		break;
	//选择投票选项
	case "vote_opt_choice":
		$choice_opt_id = $_GET['opt_id'];
		$sql = "update vote_option set vote_num = vote_num+1 where id=".$choice_opt_id;
		$result = mysqli_query($conn, $sql);
		
		$sql_ = "update vote_info set vote_nums = vote_nums+1";
		$result_ = mysqli_query($conn, $sql_);
		if ($result&&$result_){
			echo "投票成功！";
			
		}else {
			echo "投票失败！";
		}
		break;
}