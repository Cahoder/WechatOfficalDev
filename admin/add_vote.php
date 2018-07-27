<?php 
require_once '../common.php';    //调用公共方法
check_login();
$person = get_person_info();



if (isset($_POST['btn'])){
	$option=$_POST['option'];  //把所有选项变成保存为数组
	publish_new_vote($_POST['title'],$_POST['start_time'],$_POST['end_time'],$option);
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
                        <h1 class="page-head-line">后台管理-发布投票</h1>
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
                
                
 <form name="LoginForm" action="" method="post" onsubmit="return check()"> 
   <div class="oz-form-fields"  style="width:450px;padding-top: 5px"> 
   
    <table style="width:700px;" id="optionContainer">  
        <tr id="option_0">   
            <td class="oz-form-topLabel"> 
                题目：
            </td>
            <td class="oz-property" >  
              <input type="text"  style="width:600px" id="vote_title" name="title">
            </td> 
            <td>*</td>  
        </tr>  
        <tr id="option_1">   
            <td class="oz-form-topLabel"> 
                开始时间：
            </td>  
            <td class="oz-property" >  
              <input type="text"  style="width:300px" id="start_time" name="start_time" value="<?php echo date("Y-m-d H:i:s");?>"> <span style="color: grey;font-size:10px;">* 格式：2014-12-22 17:33:22</span> 
            </td>
            
        </tr>  
        <tr id="option_2">   
            <td class="oz-form-topLabel"> 
                截止时间：
            </td>  
            <td class="oz-property" >  
              <input type="text"  style="width:300px" id="end_time" name="end_time" value="<?php echo date("Y-m-d H:i:s",time()+7*3600*24);?>"> <span style="color: grey;font-size:10px;">* 默认投票期限为7天</span>
            </td>  
            <td></td>
        </tr>  
        <tr id="kongge">   
            <td class="oz-form-topLabel" style="text-align:left; color:red;font-size:10px;"> 
               <span>（请输入选项）</span>
            </td>  
            <td class="oz-property"  >  
              
            </td>  
        </tr>  
        
        
        <tr id="option1">   
            <td class="oz-form-topLabel">选项1：</td>  
            <td class="oz-property" >  
                <input type="text"  style="width:300px" id="option0" name="option[]">  
            </td>  
            <td></td>  
        </tr>  
        <tr id="option2">   
            <td class="oz-form-topLabel">选项2：</td>  
            <td class="oz-property" >  
                <input type="text"  style="width:300px" id="option00" name="option[]">  
            </td>  
            <td></td>  
        </tr>  
        <tr id="option3">   
            <td class="oz-form-topLabel">选项3：</td>  
            <td class="oz-property" >  
                <input type="text"  style="width:300px" name="option[]"> <a href="#" onclick="delRow('3')">删除</a>
            </td>  
            
        </tr>  
        
    </table> 
    
    <div style="text-align: center;">  
    	<br>
        <button href="#" onclick="addRow()" type="button">添加选项</button>
    </div>  
    
</div>
					<br>
					<br>
			<p style="text-align:right;"><button name="btn"  type="submit" value="" >发布投票</button> <button name="reset"  value=""  type="reset">重置</button></p>	
				
</form> 
           
                	
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
	function check(){
		if(LoginForm.vote_title.value==""){
					alert("标题不能为空!");
					return false;  //false不提交数据
			}
		if(LoginForm.start_time.value==""){
			alert("投票起始时间不能为空!");
			return false;  //false不提交数据
	}
		if(LoginForm.end_time.value==""){
			alert("投票结束时间不能为空!");
			return false;  //false不提交数据
	}
		if(LoginForm.option0.value==""){
			alert("选项1-2不能为空！");
			return false;  //false不提交数据
	}
		if(LoginForm.option00.value==""){
			alert("选项1-2不能为空！");
			return false;  //false不提交数据
	}
				return true;
		}
    </script>
    
    
	<script type="text/javascript">
	//增加删除行数
		var rowCount=3;  //行数默认3行  
		//添加行  
		function addRow(){
			if (rowCount<5){
	  	  rowCount++;  
	   		 var newRow='<tr id="option'+rowCount+'"><td class="oz-form-topLabel">选项'+rowCount+'：</td><td class="oz-property" ><input type="text"  style="width:300px" name="option[]"><a href="#" onclick=delRow('+rowCount+')> 删除</a></td></tr>';  
	   		 $('#optionContainer').append(newRow);  
				}else{ alert("最多选择五个选项");}
			}
			//删除行  
			function delRow(rowIndex){  
	   		 $("#option"+rowIndex).remove();  
	    		rowCount--;  
			}

    </script>
    
    
</body>
</html>
