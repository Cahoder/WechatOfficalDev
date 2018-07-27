<?php 
require_once '../common.php';    //调用公共方法
require_once '../pages.class.php';  //调用
check_login();
check_power(3);
$person = get_person_info();
$id = $_GET['id'];   //获得用户点击的ID
$sql = "select * from lyb_info where id=$id";   //在数据库中找出相应的ID对应的数据
$result = mysqli_query($link, $sql);
$rows= mysqli_fetch_assoc($result);   //取出对应ID数据的所有数据
if (isset($_POST['btn'])){
	reply_msg($_POST['cont'],$id);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>留言板</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="../assets/css/basic.css" rel="stylesheet" />
    
   
    
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="view.php">留言板</a>
            </div>

           
        </nav>
                 <!-- /. NAV SIDE  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <div class="user-img-div">
                            <img src="../assets/img/user.png" class="img-thumbnail" />

                            <div class="inner-text">
                                用户ID:&nbsp;<?php echo $_SESSION['user_name']?>
                            <br />
                                <small>个人等级 : <?php echo get_person_dj($person['noodname']);?> </small>
                            </div>
                        </div>
                    </li>
                     <li>
                        <a href="../person.php"><i class="fa fa-dashboard "></i>个人信息</a>
                    </li>         
                    <li>
                        <a href="../register.php"><i class="fa fa-flash "></i>注册用户</a>
                    </li>
                     <li>
                        <a href="../index.php"><i class="fa fa-anchor "></i>登录用户</a>
                    </li>
                     <li>
                        <a href="../lyb.php"><i class="fa fa-bug "></i>在线留言</a>
                    </li>
                    <li>
                        <a href="../vote.php"><i class="fa fa-bug "></i>查看投票</a>
                    </li>
                    <li>
                        <a href="../view.php"><i class="fa fa-sign-in "></i>查看留言</a>
                    </li>
                   <?php if (get_user_power()<2){?>
                    <li>
                        <a href="#"><i class="fa fa-sitemap "></i>后台管理<span style="float: right;">↓</span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="user_admin.php"><i class="fa fa-bicycle "></i>用户管理</a>
                            </li>
                             <li>
                                <a href="msg_admin.php"><i class="fa fa-flask "></i>留言管理</a>
                            </li>
                            <li>
                                <a href="reply_admin.php"><i class="fa fa-flask "></i>回复管理</a>
                            </li>
                            <li>
                                <a href="letter_admin.php"><i class="fa fa-flask "></i>私信管理</a>
                            </li>
                            <li>
                                <a href="vote_admin.php"><i class="fa fa-flask "></i>投票管理</a>
                            </li>
                        </ul>
                    </li>
                   <?php }?>
                   
                    <li>
                        <a href="../index.php?action=out"><i class="fa fa-square-o "></i>退出登录</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">回复管理</h1>
                        <h1 class="page-subhead-line">欢迎进入后台管理系统,
						<?php 
						$person = get_person_info();
			
						switch ($person['power']) 
						{case 0: 
						echo "(超级管理员--" ;
						break; 
						case 1: 
			 			echo "(普通管理员--"; 
			 			break;}
			 			echo $_SESSION['user_name'].")";   
			 	?>
			 	</h1>
                    </div>
                </div>
                <!-- /. 在线留言  -->
                <?php 
                
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                ?>
                
                <table width= "90%" align="center"  bgColor=#ffffff   border=0 cellspacing="10px">
				  <tr align="center"><td><h4><?php echo $rows['title']?></h4></td></tr>
				  <tr align="center"><td >发布时间：<?php echo $rows['publish_time']?></td></tr>
				  <tr align="left" ><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rows['content']?></td></tr>
				  <tr align="right"><td >信息类型：<?php echo $rows['ly_type']?></td></tr>
				  <tr align="right"><td >发布作者：<?php echo $rows['author']?></td></tr>
				</table>
				<hr>
				<h4>用户留言：</h4>
					<?php 
					$each_disNums = 3; //每行显示留言数
					$new_sql = "select * from reply_info where ly_id=$id";   //寻找用户点击进去的id对应的留言信息
					$new_result = mysqli_query($link, $new_sql);  //执行上一条sql语句
					$all_nums = mysqli_num_rows($new_result);   //获取对应ID在数据库里的总的数据量
					if (isset($_GET['page'])){
						$current_page=$_GET['page'];   //获取当前按下的页数
					}else {
						$current_page=1;  //默认不点击显示第一页
					}
					
					$sql = "select * from reply_info where ly_id=$id limit ".($current_page-1)*$each_disNums.",".$each_disNums."";     //每页从第几个开始显示和显示数量
					$result = mysqli_query($link, $sql);   //执行上一条sql语句
					
					$float_num = 1;  //显示楼层数
					while ($new_row = mysqli_fetch_assoc($result)){   //取出数据表中的数据
					?>
					<table width="100%" height="5%"  align="center"  bgColor=#ffffff   border=0 cellspacing="10px">
							<tr>
							  <td align="left">
							  <?php
							  echo $new_row['ly_cont'];
							  if ($new_row['state']==0){
					       			echo " (当前显示)";
					       			echo "<button id='oper_no' value='".$new_row['id']."'>屏蔽</button><button id='oper_del' value='".$new_row['id']."' >删除</button>";
					       		}else{
					       			echo " (当前屏蔽)";
					       			echo "<button id='oper_yes' value='".$new_row['id']."'>显示</button><button id='oper_del' value='".$new_row['id']."'>删除</button>";
					       		}	
					       		?>
					       		</td>
							</tr>
							<tr>
							  <td align="right" >第<?php echo $float_num++?>楼，来自<?php echo $new_row['ly_people']?>在<?php echo $new_row['ly_time']?><a href="#">留言</a></td>
							</tr>
					</table>
					<hr>
					<?php }
					?>
			  	  <?php 
			  	  			$page = new Pages($each_disNums, $all_nums, $current_page,3, "reply_display.php?id=".$id."&page=", 1);     
			  	  ?>
                	
               <?php  	
                	echo "</div>";
                	echo "</div>";
                	echo "</div>";
                ?>
                 <!-- ./在线留言  -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <div id="footer-sec">
        &copy; 2017 留言板 | by Cahoder.Sm162
    </div>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
	<script type="text/javascript" src="../jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){   //jq语段，页面加载完成执行一段jq
				$("button").click(function(){
					var set = $(this).attr("id");  //获取当前按下的id
					switch(set){
					//隐藏留言
						case "oper_no":
							var state_change = confirm("你确定要屏蔽留言吗？");
							if(state_change){
							var get_id = $(this).attr("value");
								$.ajax({
								   type:"GET",   //获取方式
								   url:"revise_admin.php",  //请求文件地址
								   data:{id:get_id,oper_type:"dis_hide"},  //执行处理事件 
								   success:function(data){  //执行成功后做...
									 	alert(data);
									 	window.location.reload();
								    }
							    });
								window.location.reload();
							}	
						break;
					//显示留言
						case "oper_yes":
							var state_change = confirm("你确定要显示留言吗？");
							if(state_change){
							var get_id = $(this).attr("value");
								$.ajax({
								   type:"GET",   //获取方式
								   url:"revise_admin.php",  //请求文件地址
								   data:{id:get_id,oper_type:"dis_show"},  //执行处理事件 
								   success:function(data){  //执行成功后做...
									 	alert(data);
									 	window.location.reload();
								    }
							    });
								window.location.reload();
							}
						break;
					//删除留言
						case "oper_del":
							var state_change = confirm("你确定要删除留言吗？");
							if(state_change){
							var get_id = $(this).attr("value");
								$.ajax({
								   type:"GET",   //获取方式
								   url:"revise_admin.php",  //请求文件地址
								   data:{u_id:get_id,oper_type:"dis_delete"},  //执行处理事件 
								   	success:function(data){  //执行成功后做...
									 	alert(data);
									 	window.location.reload();
								   		 }
							   		 });
							}	
						break;
					}
				});
		});
			  
	</script>

</body>
</html>
