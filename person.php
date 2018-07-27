<?php 
require_once 'common.php';    //调用公共方法
check_login();
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
                    
                        <h1 class="page-head-line">个人中心</h1>
                        <h1 class="page-subhead-line">欢迎您浏览本留言板，期待向我们提出宝贵意见！ </h1>
                    </div>
                </div>
                <!-- /. 个人中心  -->
                <?php 
                
                	echo "<div class='row'>";
                	echo "<div class='col-md-12'>";
                	echo "<div class='alert alert-info'>";
                ?>
                	<table width= "90%" align="center"  bgColor=#ffffff   border=1 >
					<ul>
					<li>用户：<?php echo $_SESSION['user_name'];?><a href='person_letter.php'   style="float:right;text-decoration:none;color:red;">我的私信<?php if (get_person_letter_info()){echo "<img alt='新消息！' src='./assets/img/news.gif' style='width:80px;'>";}?></a></li>
					<li>密码：<input  id="change_pin" name="change_pin"  type="password"  value="<?php echo $person['password'];?>"></input>-修改密码</li>
					<li>邮箱：<?php echo $person['email'];?></li>
					<li>电话：<?php echo $person['telephone'];?></li>
					<li>个人简介：<?php echo $person['intro'];?></li>
					<li>个人积分：<?php echo $person['score'];?></li>
					<li>个人权限：
					<?php  
					switch ($person['power']){
						case 0:
							echo "超级管理员"; 
							break;
						case 1:
							echo "普通管理员";
							break;
						case 2:
							echo "普通用户";
							break;
						case 3:
							echo "受限用户";
							break;
						case 4:
							echo "非法用户";
							break;
					}
					?></li>
					<li  >个人等级：<?php echo get_person_dj($person['noodname']);?></li>   
					</ul>     

					<p   align="right"><a href="#"  onclick="javascript:history.go(-1);"   >返回上一页</a></p>    
				</table>
                	
               <?php  	
                	echo "</div>";
                	echo "</div>";
                	echo "</div>";
                ?>
                 <!-- ./个人中心  -->
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
	<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
	//修改密码
		$(document).ready(function(){   //jq语段，页面加载完成执行一段jq
				$('#change_pin').change(function(){   //change
					var is_change = confirm("你确定要修改密码吗？");
					if(is_change){
						var new_pwd = $(this).val();
						var user_id = $(this).attr("id");
						var revise = "pin_change"	
						$.ajax({
						   type:"GET",   //获取方式
						   url:"revise.php",  //请求文件地址
						   data:{pwd:new_pwd,revise_type:revise,id:user_id},  //执行处理事件
						   success:function(data){  //执行成功后做...
							 	alert(data);
							 	
						    }
					    });
						window.location.reload();
						}
				    });
			    });
	</script>

</body>
</html>
