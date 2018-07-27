<?php 
require_once 'common.php';    //调用公共方法
check_login();

require_once 'pages.class.php';  //调用
$person = get_person_info();
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
                        <h1 class="page-head-line">查看投票</h1>
                        <h1 class="page-subhead-line">欢迎您浏览本页面进行在线投票！ </h1>
                    </div>
                </div>
                <!-- /. 新闻列表  -->
                <?php 
                $each_disNums= 3; //每页显示留言数
                $sqll = "select * from vote_info where state=1";
                $resultl = mysqli_query($link, $sqll);
                $nums = mysqli_num_rows($resultl);  //总留言数
                if (isset($_GET['page'])){
                	$current_page = $_GET['page'];  ///获取当前的页数
                }else {
                	$current_page = 1;    //默认页数为1；
                }

                $sql = "select * from vote_info where state=1 order by start_time desc limit ".($current_page-1)*$each_disNums.",".$each_disNums."";   //倒序排序，每页显示3个数据
                $result = mysqli_query($link, $sql);
                
                $no =1;
                while ($row=mysqli_fetch_assoc($result)){    //取出数据表中的数据
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                	
                	
                	echo "<P align='left' ><span style='font-size:20px; color:black;'>投票'".$no++."':<a href='vote_display.php?id=".$row['id']."'>《".$row['title']."》</a></span>"; //从数据库中导出数据并且按着id进行页面跳转
                	echo "<span vAlign=bottom noWrap align='center'>-------投票发起人：".$row['originater']."</span>";
                	echo "<span vAlign=bottom noWrap align='right'>【<a href='vote_result.php?id=".$row['id']."' style='text-decoration:none;color:grey;'>投票详情</a>】</span>";
                	echo "<p vAlign=bottom noWrap align='right'>参与人数：".$row['vote_nums']."</p>";
                	echo "<p vAlign=bottom noWrap align='right'>起始时间为：".$row['start_time']."</p>";
                	echo "<p vAlign=bottom noWrap align='right'>截止时间为：".$row['end_time']."</p>";
                	echo "</P>";    
                	/*echo "<TD vAlign=bottom noWrap align='center'>".$row['content']."</TD>";*/
                	
                	
                	echo "</div>";
                	echo "</div>";
                	echo "</div>";
                }
                ?>
                 <!-- ./新闻列表  -->
                 
                 <!-- 新闻换页  -->
                  <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                           	  <p><?php $page = new Pages($each_disNums, $nums, $current_page,3, "vote.php?page=", 1);?></p>
                        </div>
                    </div>
               	 </div>
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
			if(voteForm.cont.value==""){
			alert("请选择一项进行投票!");
			return false;  //false不提交数据
			}
				return true;
		}
    </script>

</body>
</html>
