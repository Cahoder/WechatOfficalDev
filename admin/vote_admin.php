<?php 
require_once '../common.php';    //调用公共方法
require_once '../pages.class.php';  //调用
check_login();
$person = get_person_info();


//获取选项总人数数据表
$sums_sql = "select * from vote_option ";
$sums_result = mysqli_query($link, $sums_sql);
$sums_row=mysqli_fetch_array($sums_result);
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
                        <a href="../login.php"><i class="fa fa-anchor "></i>登录用户</a>
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
                        <h1 class="page-head-line">后台管理-投票管理</h1>
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
			 	<a href="add_vote.php" style="color:red; margin-left:30px; font-style:normal;">【发起新投票】</a>
			 	</h1>
                    </div>
                </div>
                <!-- /. 在线留言  -->
                <?php 
                
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                ?>
                <p style="text-align: center; font-size:20px; font-weight:weight;color:black;">[已发布投票]</p>
                <table width= "100%" align="center"  bgColor=#ffffff   border=0>
				<TR ><th style="text-align: center;">序号</th><th style="text-align: center;">投票主题</th><th style="text-align: center;">参与人数</th><th style="text-align: center;">投票截止时间</th><th style="text-align: center;">投票管理</th></TR>
					       <?php 
					       $each_disNums= 3; //每页显示留言数
					       $sqll = "select * from vote_info";
					       $resultl = mysqli_query($link, $sqll);
					       $nums = mysqli_num_rows($resultl);  //总留言数
					       if (isset($_GET['page'])){
					       	$current_page = $_GET['page'];  ///获取当前的页数
					       }else {
					       		$current_page = 1;    //默认页数为1；
					       }
					       
					       
					       	$sql = "select * from vote_info order by end_time desc limit ".($current_page-1)*$each_disNums.",".$each_disNums."";   //倒序排序，每页显示3个数据
					       	$result = mysqli_query($link, $sql);
					       
					       $no =1;
					       	while ($row=mysqli_fetch_assoc($result)){    //取出数据表中的数据
					       		echo "<TR>";
					       		echo "<TD align='center'>".$no++."</TD>";
					       		echo "<TD vAlign=bottom noWrap align='center'><a href='../vote_result.php?id=".$row['id']."'>《".$row['title']."》</a></TD>";
					       		echo "<TD vAlign=bottom noWrap align='center'>".$row['vote_nums']."</TD>";
					       		
					       		echo "<TD vAlign=bottom noWrap align='center'>".$row['end_time']."</TD>";
					       		
					       		
					       		
					       			echo "<TD align=center vAlign=bottom noWrap  ><button id='vote_del' value='".$row['id']."' >删除</button></TD>";
					       			
					       		
					       		echo "</TR>";
					       	}
					       	echo "<TR align ='center'>";
					       	echo "<TD colspan=5 >";
					       	$page = new Pages($each_disNums, $nums, $current_page,3, "vote_admin.php?page=", 1);
					       	echo "</TD>";    //调用pages.class.php中的类方法
					       	echo "</TR>";
					       ?>
				</table>      	  
                        </div>
                    </div>
               	 </div>
                 <!--./ 用户已删除私信  -->
                 
                 
                 
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
					//删除投票
						case "vote_del":
							var state_change = confirm("你确定要删除投票吗？");
							if(state_change){
							var get_id = $(this).attr("value");
								$.ajax({
								   type:"GET",   //获取方式
								   url:"revise_admin.php",  //请求文件地址
								   data:{vote_id:get_id,oper_type:"vote_delete"},  //执行处理事件 
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
