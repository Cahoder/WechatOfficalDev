<?php
session_start();
$type_ = $_GET['oper_type'];
$conn = mysqli_connect("localhost", "login", "123456", "lyb_proj");
switch ($type_)
{
	case "power_change":
		$id = $_GET['id'];
		$power=$_GET['change_power'];
		$sql = "update lyb_user set power='".$power."' where id='".$id."'";    //按着id进行用户权限修改
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "权限修改成功!";
		}else {
			echo "权限修改失败!";
		}
		break;
	case "user_delete":
		$id = $_GET['id'];
		$sql = "delete from lyb_user where id = '".$id."'";    //按着id进行用户删除
		$result = mysqli_query($conn, $sql);
		if ($result){
			echo "用户删除成功！";
		}else {
			echo "用户删除失败！";
		}
		break;
	case "msg_delete":
		$u_id = $_GET['u_id'];
		$u_sql = "delete from lyb_info where id = '".$u_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		$reply_del = "delete from reply_info where ly_id = '".$u_id."'";    //按着id进行回复相应的信息全部删除
		$result_ = mysqli_query($conn, $reply_del);
		if ($u_result && $result_){
			echo "用户删除成功！";
		}else {
			echo "用户删除失败！";
		}
		break;
	case "msg_hide":
		$id = $_GET['id'];
		$sql = "update lyb_info set state='1' where id='".$id."'";    //按着id进行用户权限修改
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "屏蔽留言成功!";
		}else {
			echo "屏蔽留言失败!";
		}
		break;
	case "msg_show":
		$id = $_GET['id'];
		$sql = "update lyb_info set state='0' where id='".$id."'";    //按着id进行用户权限修改
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "显示留言成功!";
		}else {
			echo "显示留言失败!";
		}
		break;
	case "dis_hide":
		$id = $_GET['id'];
		$sql = "update reply_info set state='1' where id='".$id."'";    //按着id进行用户权限修改
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "屏蔽回复成功!";
		}else {
			echo "屏蔽回复失败!";
		}
		break;
	case "dis_show":
		$id = $_GET['id'];
		$sql = "update reply_info set state='0' where id='".$id."'";    //按着id进行用户权限修改
		$result = mysqli_query($conn, $sql);
		if($result){
			echo "显示回复成功!";
		}else {
			echo "显示回复失败!";
		}
		break;
	case "dis_delete":
		$u_id = $_GET['u_id'];
		$u_sql = "delete from reply_info where id = '".$u_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		if ($u_result){
			echo "回复删除成功！";
		}else {
			echo "回复删除失败！";
		}
	break;
	case "letter_hide":
		$hide_id = $_GET['hide_id'];
		$u_sql = "update person_letter set control_state='2' where id='".$hide_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		if ($u_result){
			echo "拦截成功！";
		}else {
			echo "拦截失败！";
		}
	break;
	case "letter_show":
		$show_id = $_GET['show_id'];
		$u_sql = "update person_letter set control_state='1' where id='".$show_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		if ($u_result){
			echo "恢复成功！";
		}else {
			echo "恢复失败！";
		}
		break;
	case "letter_delete":
		$del_id = $_GET['del_id'];
		$u_sql = "delete from person_letter where id = '".$del_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		if ($u_result){
			echo "删除成功！";
		}else {
			echo "删除失败！";
		}
		break;
	case "vote_delete":
		$vote_id = $_GET['vote_id'];
		$u_sql = "delete from vote_info where id = '".$vote_id."'";    //按着id进行用户删除
		$u_result = mysqli_query($conn, $u_sql);
		
		$u_sql_ = "delete from vote_option where vote_id = '".$vote_id."'";    //按着vote_id进行用户删除
		$u_result_ = mysqli_query($conn, $u_sql_);
		if ($u_result &&  $u_result_){
				echo "删除成功！";
			}else {
				echo "删除失败！";
			}
		break;
}