<?php 
require_once 'common.php';    //调用公共方法
check_login();
$person = get_person_info();


$id = $_GET['id'];
$sql = "select title from vote_info where id = ".$id;
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);



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
                        <h1 class="page-head-line">在线投票</h1>
                        <h1 class="page-subhead-line">欢迎您进行在线投票，每位用户仅可以进行一次投票机会！</h1>
                    </div>
                </div>
                <!-- /. 投票题目  -->
               <?php 
               		
               		
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                	
                	echo "<p style='font-size:30px;'>题目：".$row['title'];
                	echo "<span vAlign=bottom noWrap  style='font-size:10px;float:right;'>【<a href='vote_result.php?id=".$id."' style='text-decoration:none;color:grey;'>投票详情</a>】</span></p>";
                	
                	echo "</div>";
                	echo "</div>";
                	echo "</div>";
                
                ?>
                <!-- ./投票题目  -->
                
                
                <!-- /. 进行投票  -->
                <form name="voteForm" action="" method="post" onsubmit="return check()"> 
                  <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                         <p>选项：</p>
                          <?php 
                          $option_sql = "select * from vote_option where vote_id = ".$id;
                          $option_result = mysqli_query($link, $option_sql);
                         
                          	echo "<tr>";
                          	while ($option_row=mysqli_fetch_assoc($option_result)){
                          	echo "<td>";
                          	echo "<p><INPUT name='vote_opt' class='vote_opt' type='radio' size='16'  value='".$option_row['id']."'>".$option_row['option_name']."</p>";
                          	echo "</td>";
                          	}
                          	echo "</tr>";
                          
                          ?>  
<!--                            <p ><button name="btn"  id="btn" type="submit" value="" >投票</button> <button name="reset"  value=""  type="reset">重置</button></p>  -->
                        </div>
                    </div>
                </div>
                </form>
                 <!-- /. 进行投票  -->
                
                
                 
                 
                 
                 <!--./ 新闻换页  -->
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
			if(voteForm.vote_opt.value==""){
			alert("请选择一项进行投票！");
			return false;  //false不提交数据
			}
			return true;
		}
    </script>

	
	
	<script type="text/javascript">
		$(document).ready(function(){   //jq语段，页面加载完成执行一段jq
				$(".vote_opt").click(function(){
							var get_id = $(this).val();
								$.ajax({
								   type:"GET",   //获取方式
								   url:"revise.php",  //请求文件地址
								   data:{opt_id:get_id,revise_type:"vote_opt_choice"},  //执行处理事件 
								   success:function(data){  //执行成功后做...
									 	alert(data);
									 	
								    }
						});
				});
		});
	</script>
</body>
</html>

