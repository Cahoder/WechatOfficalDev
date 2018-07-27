<?php
session_start();
	$link = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB, SAE_MYSQL_PORT);
	mysqli_query($link, "set name'utf-8'");
	date_default_timezone_set('Asia/Shanghai');    //设置时区

	function register($user,$pd,$phone,$email,$intro){
		global $link;
		$sql = "select * from lyb_user where user_name = '".$user."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result)>0){
			show_msg("用户已存在","register.php");
		}else{
			$sql ="insert into lyb_user(user_name,password,telephone,email,intro,noodname,score,power) values ('".$user."','".md5($pd)."','".$phone."','".$email."','".$intro."',1,0,2)";    //插入数据到数据库
			$result = mysqli_query($link, $sql);
			if ($result){
			show_msg("注册成功,请登录！",'index.php');
		}else {
			echo "<script>alert('注册失败')</script>";
		}
	}
}	
  //登录
  	function login($user,$pwd){
  		global $link;
  		$sql = "select*from lyb_user where user_name ='".$user."'and password = '".md5($pwd)."'";
  		$result= mysqli_query($link,$sql);
  		if (mysqli_num_rows($result)>0){
  			$_SESSION['user_name'] = $user;    //保存cookie状态
  			$_SESSION['password'] = $pwd;
  			show_msg("登录成功!欢迎访问","view.php");
  		}
  		else {
  			echo "<script>alert('登陆失败')</script>";
  		}
  	}
  	
  	function show_msg($msg,$url){    //界面切换
  		$win_str = "<meta http-equiv='refresh' content='3; url=".$url."'>
  				<table width='200' border='1' align='center' >
  				<tbody>
  				<tr>
    			<th scope='col'>提示窗口</th>
  				</tr>
  				<tr>
    			<td>".$msg."<br>
  				页面将在3秒后跳转，如跳转失败，请点击<a href='".$url."'>跳转</a>
  				</td>
 				 </tr>
				</tbody>
  			    </table>";
  		echo $win_str;
  		exit();
  	}
  	
  	//查看个人详细信息
  	function get_person_info(){
  		global $link;
  		if (!empty($_SESSION['user_name'])){
  		$sql = "select * from lyb_user where user_name = '".$_SESSION['user_name']."'";    //获取登录时那个用户的其他所有信息
  		$result = mysqli_query($link, $sql);
  		$row = mysqli_fetch_assoc($result);
  		return $row;   //回调值赋给get_person_info();
  		}
  	}
  	
  	//查看个人等级信息
  	function get_person_dj($noodname){
  		global $link;
  		$sql = "select * from lyb_dj where id = $noodname";    //获取等级表中的ID 和 $person中的等级值进行对比，输出对应等级表对着的职务
  		$result = mysqli_query($link, $sql);
  		$row = mysqli_fetch_assoc($result);
  		echo $row['dj_name'];  //输出等级职务
  	}
  	
  	//发表留言
  	function publish_ly($title,$cont,$ly_type){
  		global $link;
  		$sql = "insert into lyb_info(title,content,ly_type,author,publish_time) values ('".$title."','".$cont."','".$ly_type."','".$_SESSION['user_name']."','".date("Y:m:d H:i:s")."')";    //写入值进入数据库
  		$result = mysqli_query($link, $sql);
  		if ($result){
  			//对用户进行积分增加
  			$sql = "update lyb_user set score=score+5 where user_name='".$_SESSION['user_name']."'";   //对当前发表留言的用户叠增积分
  			$result = mysqli_query($link, $sql); //执行sql指令
  			//判断用户是否符合升级条件
  			//1.获取用户当前的等级
  			$curr_sql = "select * from lyb_user where user_name='".$_SESSION['user_name']."'";   //从数据库li寻找当前登录用户的个人详细信息
  			$curr_res = mysqli_query($link, $curr_sql);
  			$curr_row = mysqli_fetch_assoc($curr_res);   //取出用户的个人信息变成数据保存在$curr_row中
  			$curr_dj = $curr_row['noodname'];
  			$curr_score = $curr_row['score'];   //当前用户的积分
  			//2.获取数据库lyb_dj下一等级所需的积分值
  			$next_sql = "select * from lyb_dj where id=".($curr_dj+1);  //寻找当前登录用户在lyb_dj数据表中对应下一个等级的数据值
  			$next_res = mysqli_query($link, $next_sql);
  			$next_row = mysqli_fetch_assoc($next_res);
  			$next_score = $next_row['dj_score'];   //下一等级所需要的积分
  			$next_dj_name = $next_row['dj_name'];
  			if ($curr_score>=$next_score){  //对比积分
  				$up_sql = "update lyb_user set noodname=noodname+1  where user_name='".$_SESSION['user_name']."'";   //更新当前用户等级值
  				$up_res = mysqli_query($link, $up_sql);  //执行语句指令
  				show_msg("留言成功,恭喜".$_SESSION['user_name']."升级为".$next_dj_name, "view.php");
  			}else {
  			show_msg("留言成功", 'view.php');
  		}
  		}else {
  			show_msg("留言失败", 'lyb.php');
  		}
  	}
  	
  	//检查是否退出登录状态
  	function check_login(){
  		if (empty($_SESSION['user_name'])){
  			show_msg("请先登录再查看详情！", "index.php");
  		}
  	}
  
  	//检查用户权限
  	function check_power($power){
  		$rows=get_user_power();  //调用函数get_user_power()回调的值
  		if ($rows>=$power){
  			show_msg("您没有权限访问！", "person.php");
  		}
  		
  	}
  	
  	//获取用户的权限
  	function get_user_power(){
  		global $link;
  		$sql = "select * from lyb_user where user_name='".$_SESSION['user_name']."'"; //获取当前登录的用户的信息
  		$result = mysqli_query($link, $sql);
  		$row = mysqli_fetch_assoc($result);
  		$power_s = $row['power'];
  		return $power_s;  //回调值赋给函数get_user_power()
  	}
  	
  	//回复留言
  	function reply_msg($ly_cont,$id){
  		global $link;
  		$sql="insert into reply_info(ly_id,ly_cont,ly_time,ly_people) values ($id,'".$ly_cont."','".date('Y:m:d H:i:s')."','".$_SESSION['user_name']."')"; //写入值进入数据库
  		$result = mysqli_query($link, $sql);
  		if ($result){
  			//对用户进行积分增加
  			$sql = "update lyb_user set score=score+2 where user_name='".$_SESSION['user_name']."'";   //对当前发表留言的用户叠增积分
  			$result = mysqli_query($link, $sql); //执行sql指令
  			//判断用户是否符合升级条件
  			//1.获取用户当前的等级
  			$curr_sql = "select * from lyb_user where user_name='".$_SESSION['user_name']."'";   //从数据库li寻找当前登录用户的个人详细信息
  			$curr_res = mysqli_query($link, $curr_sql);
  			$curr_row = mysqli_fetch_assoc($curr_res);   //取出用户的个人信息变成数据保存在$curr_row中
  			$curr_dj = $curr_row['noodname'];
  			$curr_score = $curr_row['score'];   //当前用户的积分
  			//2.获取数据库lyb_dj下一等级所需的积分值
  			$next_sql = "select * from lyb_dj where id=".($curr_dj+1);  //寻找当前登录用户在lyb_dj数据表中对应下一个等级的数据值
  			$next_res = mysqli_query($link, $next_sql);
  			$next_row = mysqli_fetch_assoc($next_res);
  			$next_score = $next_row['dj_score'];   //下一等级所需要的积分
  			$next_dj_name = $next_row['dj_name'];
  			if ($curr_score>=$next_score){  //对比积分
  				$up_sql = "update lyb_user set noodname=noodname+1  where user_name='".$_SESSION['user_name']."'";   //更新当前用户等级值
  				$up_res = mysqli_query($link, $up_sql);  //执行语句指令
  				show_msg("回复成功,恭喜".$_SESSION['user_name']."升级为".$next_dj_name, "display.php?id=".$id);
  			}else {
  				show_msg("回复成功", "display.php?id=".$id);
  			}
  		}else {
  			show_msg("回复失败","display.php?id=".$id);
  		}
  	}
  	//获取私信全部信息
  	function get_person_letter_info(){
  		global $link;
  		$sql = "select * from person_letter where sendto = '".$_SESSION['user_name']."' and read_state = 1";    //获取被发送的用户
  		$result = mysqli_query($link, $sql);
  		$row = mysqli_fetch_assoc($result);
  		if ($row){
  			return $row['read_state'];   //回调值赋给get_person_letter_info();
  		}
  		
  	}
  	
  	
  	//回复私信
  	function reply_people_message($reply_people,$reply_msg,$msg_type){
  		global $link;
  		$sql="insert into person_letter(sendto,sendfrom,send_cont,send_time,read_state,control_state,type) values ('".$reply_people."','".$_SESSION['user_name']."','".$reply_msg."','".date('Y-m-d')."',1,1,'".$msg_type."')"; //写入值进入数据库
  		$result_ = mysqli_query($link, $sql);
  		if ($result_){
  			echo "<script>alert('回信成功，敬候佳音！')</script>";
  		}else {
  			echo "<script>alert('回信失败！')</script>";
  		}
  	}
  	
  	//发送私信
  	function send_people_message($send_people,$send_msg,$msg_type){
  		global $link;
  		$sql="insert into person_letter(sendto,sendfrom,send_cont,send_time,read_state,control_state,type) values ('".$send_people."','".$_SESSION['user_name']."','".$send_msg."','".date('Y-m-d')."',1,1,'".$msg_type."')"; //写入值进入数据库
  		$result_ = mysqli_query($link, $sql);
  		if ($result_){
  			echo "<script>alert('回信成功，敬候佳音！')</script>";
  		}else {
  			echo "<script>alert('回信失败！')</script>";
  		}
  	}
  	
  	//获取投票总数
  	function get_vote_nums($vote_id){
  		global $link;
  		$sql = "select sum(vote_num) as count from vote_option where vote_id =".$vote_id;
  		$result = mysqli_query($link, $sql);
  		$sqlcount = mysqli_fetch_assoc($result);
  		$ascount = $sqlcount['count'];
  		return $ascount;
  	}
  	
  	//添加投票0.0
  	function publish_new_vote($title,$start_time,$end_time,$option){
  		global $link;
//   		$arr_length = sizeof($vote);
//   		//获取标题 开始时间 和 截至时间
//   		$num = 0;
//   		$option = array();
//   		foreach ($vote as $vote_val ){
//   			switch ($num){
//   				case 0:
//   					$vote_title = $vote_val;
//   					break;
//   				case 1:
//   					$start_time = $vote_val;
//   					break;
//   				case 2:
//   					$end_time = $vote_val;
//   					break;
//   				case ($arr_length-1):
//   					break;
//   				default:
//   					array_push($option, $vote_val);
//   			}
//   			$num++;
//   		}

  		$sql = "insert into vote_info(vote_nums,title,state,originater,start_time,end_time) values(0,'".$title."',1,'".$_SESSION['user_name']."','".$start_time."','".$end_time."')";
  		$result = mysqli_query($link, $sql);
  		
  		//获取投票的ID
  		$vote_id = mysqli_insert_id($link);
  		$flag = false;
  		for ($i=0;$i<sizeof($option);$i++){
  			$flag = mysqli_query($link,$aaa="insert into vote_option(vote_id,option_name,vote_num) values('".$vote_id."','".$option[$i]."',0)");
  		}
  		if ($flag && $result){
  			show_msg("新增投票成功！", "vote_admin.php");
  		}else{
  			show_msg("新增投票失败！", "vote_admin.php");
  		}
  	}