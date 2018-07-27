<?php 
require_once 'common.php';    //调用公共方法
require_once 'pages.class.php';  //调用
$person = get_person_info();
 check_login();
 check_power(3);
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
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    
   
    
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
                            <img src="assets/img/user.png" class="img-thumbnail" />

                            <div class="inner-text">
                                用户ID:&nbsp;<?php echo $_SESSION['user_name']?>
                            <br />
                                <small>个人等级 : <?php echo get_person_dj($person['noodname']);?> </small>
                            </div>
                        </div>
                    </li>
                     <li>
                        <a href="person.php"><i class="fa fa-dashboard "></i>个人信息</a>
                    </li>         
                    <li>
                        <a href="register.php"><i class="fa fa-flash "></i>注册用户</a>
                    </li>
                     <li>
                        <a href="index.php"><i class="fa fa-anchor "></i>登录用户</a>
                    </li>
                     <li>
                        <a href="lyb.php"><i class="fa fa-bug "></i>在线留言</a>
                    </li>
                    <li>
                        <a href="vote.php"><i class="fa fa-bug "></i>查看投票</a>
                    </li>
                    <li>
                        <a href="view.php"><i class="fa fa-sign-in "></i>查看留言</a>
                    </li>
                   <?php if (get_user_power()<2){?>
                    <li>
                        <a href="#"><i class="fa fa-sitemap "></i>后台管理<span style="float: right;">↓</span></a>
                         <ul class="nav nav-second-level">
                            <li>
                                <a href="admin/user_admin.php"><i class="fa fa-bicycle "></i>用户管理</a>
                            </li>
                             <li>
                                <a href="admin/msg_admin.php"><i class="fa fa-flask "></i>留言管理</a>
                            </li>
                            <li>
                                <a href="admin/reply_admin.php"><i class="fa fa-flask "></i>回复管理</a>
                            </li>
                            <li>
                                <a href="admin/letter_admin.php"><i class="fa fa-flask "></i>私信管理</a>
                            </li>
                            <li>
                                <a href="admin/vote_admin.php"><i class="fa fa-flask "></i>投票管理</a>
                            </li>
                        </ul>
                    </li>
                   <?php }?>
                   
                    <li>
                        <a href="index.php?action=out"><i class="fa fa-square-o "></i>退出登录</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">留言详情</h1>
                        <h1 class="page-subhead-line">欢迎用户查看留言详情，期待向我们提出宝贵意见！ </h1>
                    </div>
                </div>
                <!-- /. 新闻列表  -->
                <?php 
                
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                	
                	echo "<p style='color:black; font-size:20px; font-weight:bold; text-align:center;'>".$rows['title']."</p>";
                	echo "<p style='color:grey; font-size:12px; font-weight:lighter; text-align:center;'>---发布于".$rows['publish_time']."---</p>";
                	echo "<br/>";
                	echo "<p style='color:black; font-size:20px; font-weight:normal; text-align:center;'>".$rows['content']."</p>";
                	echo "<br/>";
                	echo "<p style='color:grey; font-size:13px; font-weight:lighter; text-align:right;'>信息类型：".$rows['ly_type']."</p>";
                	echo "<p style='color:grey; font-size:13px; font-weight:lighter; text-align:right;'>发布作者:".$rows['author']."</p>";
                	echo "<br/>";
                	
                	echo "</div>";
                	echo "</div>";
                	echo "</div>";
                
                ?>
                 <!-- ./新闻列表  --> 
<form name="LoginForm" action="" method="post" onsubmit="return check()">  
				<div class="row">
					<div class="col-md-12">
						<div algin="center" style="background-color:#f7f7f7;  ">
					<?php 
					$each_disNums = 3; //每行显示留言数
					$new_sql = "select * from reply_info where ly_id=$id and state=0";   //寻找用户点击进去的id对应的留言信息
					$new_result = mysqli_query($link, $new_sql);  //执行上一条sql语句
					$all_nums = mysqli_num_rows($new_result);   //获取对应ID在数据库里的总的数据量
					if (isset($_GET['page'])){
						$current_page=$_GET['page'];   //获取当前按下的页数
					}else {
						$current_page=1;  //默认不点击显示第一页
					}
					
					$sql = "select * from reply_info where ly_id=$id and state=0 limit ".($current_page-1)*$each_disNums.",".$each_disNums."";     //每页从第几个开始显示和显示数量
					$result = mysqli_query($link, $sql);   //执行上一条sql语句
					
					$float_num = 1;  //显示楼层数
					while ($new_row = mysqli_fetch_assoc($result)){   //取出数据表中的数据
					?>
					<table width="100%" height="5%"  align="center"    border=0 >
							<tr>
							  <td align="left"><?php echo $new_row['ly_cont']?></td>
							</tr>
							<tr>
							  <td align="right" >第<?php echo $float_num++?>楼，来自<?php echo $new_row['ly_people']?>在<?php echo $new_row['ly_time']?></td>
							</tr>
					</table>
					<hr>
					<?php }
					?>
						</div>
						<p style="text-align: center;"><?php $page = new Pages($each_disNums, $all_nums, $current_page,3, "display.php?id=".$id."&page=", 2);?></p>
						</br>
					</div>
				</div>
				
				
                 <!-- 新闻回复  -->
                  <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success" align="center" >
                        <p>发表回复</p>
                           	  <textarea rows="5" cols="152" id="cont" name="cont"  ></textarea>
                           	  <p align="center" >
								
								<button name="btn"  type="submit" value="" >回复</button>
								<button name="reset"  value=""  type="reset">重置</button>
							  </p>
                        </div>
                    </div>
               	 </div>
                 <!--./ 新闻换页  -->
</form>
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
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
	<script type="text/javascript"> 
	function check(){
			if(LoginForm.cont.value==""){
			alert("内容不能为空!");
			return false;  //false不提交数据
			}
				return true;
		}
    </script>

</body>
</html>
 