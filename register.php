<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>留言板</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
</head>
<?php 
require_once 'common.php';    //调用公共方法

if (isset($_POST['btn'])){
		register($_POST['user'],$_POST['pwd1'],$_POST['phone'],$_POST['email'],$_POST['intro']);
    }
?>

<body style="background-color: #E2E2E2;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <p style="font-size:40px;">留言板</p>
            </div>
        </div>
         <div class="row ">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                           
                            <div class="panel-body">
                                <form name="LoginForm" action="" method="post" onsubmit="return check()">
                                    <hr />
                                    <h5>Enter Details to Register</h5>
                                       <br />
                                     	<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input id="user" type="text" class="form-control" placeholder="Your Username " name="user"/><span id="u_check" style="color:grey; font-family:黑体;"></span>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Your Password" name="pwd1"/>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Check Your Password" name="pwd2"/>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Your Phone " name="phone"/>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="text" class="form-control"  placeholder="Your Email" name="email"/>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="text" class="form-control"  placeholder="Your Intro" name="intro"/>
                                        </div>
                                    <div class="form-group">
                                            
                                            <span class="pull-right">
                                                   <a href="index.php" >Login </a>
                                            </span>
                                        </div>
                                     
                                     <button name="btn"  type="submit" value="" style="font-size: 20px;">Register</button>                                  
                                    </form>
                            </div>
                           
                        </div>
                
                
        </div>
    </div>

    
    
	 <script type="text/javascript">
		function check(){
				var user = LoginForm.user.value;
				var pd1 = LoginForm.pwd1.value;
				var pd2 = LoginForm.pwd2.value;		
				var phone = LoginForm.phone.value;
				var email = LoginForm.email.value;
				var intro = LoginForm.intro.value;		
				if(user==""||pd2==""||pd1==""||phone==""||email==""||intro==""){
					alert("请填写完整的信息");
					return false;  //false不提交数据
				}
				if(pd1 !=pd2){
					alert("输入的两次密码不一致");
					return false;
					}
				return true;
			}
    </script>
    <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){   //jq语段，页面加载完成执行一段jq
				$('#user').blur(function(){
						var username = $(this).val();
						var revise = "check_name";
							var user_id = $(this).attr("id");
						if($.trim(username)==""){
								$("#u_check").html("不能为空");
							}
						else{
						$.ajax({
						   type:"GET",   //获取方式
						   url:"revise.php",  //请求文件地址
						   data:{user:username,revise_type:revise,id:user_id},  //执行处理事件
						   success:function(data){  //执行成功后做...
							  $("#u_check").html(data);   //在id#u_check的对应位置显示data的触发事件
						    }
					    });
					   }
				    });	
			    });
	</script>
</body>
</html>
