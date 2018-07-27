
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
require_once 'common.php';
if (isset($_POST['btn'])){
	login($_POST['user'],$_POST['pwd']);
}

if (isset($_GET['action'])){
	if ($_GET['action']=="out"){
		session_destroy();
		show_msg("退出成功", "index.php");
	}
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
                                    <h5>Enter Details to Login</h5>
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Your Username " name="user"/>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Your Password" name="pwd"/>
                                        </div>
                                       
                                    <div class="form-group">
<!--                                             <label class="checkbox-inline"  > -->
                                                <input type="checkbox"  name="remember" /> Remember me
<!--                                             </label> -->
                                            <span class="pull-right">
                                                   <a href="register.php" >Register </a>
                                            </span>
                                        </div>
                                     
                                     <button name="btn"  type="submit" value="" style="font-size: 20px;">Login</button>                                   
                                    </form>
                            </div>
                           
                        </div>           
                
        </div>
    </div>

    
    <script type="text/javascript">
		function check(){
				var user = LoginForm.user.value;
				var pd = LoginForm.pwd.value;		
				if(user==""||pd==""){
					alert("用户名或者密码不能为空");
					return false;  //false不提交数据
				}
				return true;
			}
    </script>
</body>
</html>







<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();//回传消息
$wechatObj->creat_private_menu();//创建自定义菜单

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    
    //获取access_token
    public function get_access_token(){
    	//初始化一个curl
        $ch = curl_init();
        //设置url 和相应的选项
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx226711cb571c972d&secret=d97e92171d83ad3e2d5c9c16cae0a7a7");
        curl_setopt($ch, CURLOPT_HEADER, 0); //是否输入文件流头，0是是、1是否
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //是否输入文件内容，0是是、1是否
        $data = curl_exec($ch);   //执行上面操作
        $retu_str = json_decode($data,true);  //是否将文件流解码为数组,true时返回数组，false时返回对象
        curl_close($ch);  //释放资源
        return $retu_str['access_token'];  //返回数组数据
    }
    
    //创建自定义菜单
    public function creat_private_menu(){
    	$menuStr='{
        	"button":[
            	{	
                    "name":"我的学校",
                    "sub_button":[
                    	{
                        	"type":"click",
                            "name":"我的学校",
                            "key":"001"
                        },
                        {
                        	"type":"view",
                            "name":"绑定账号",
                            "url":"http://cahoder.applinzi.com/weixin_connect/oauth2.php"
                        }
                    ]
                },
                
                {
                	"name":"菜单",
                    "sub_button":[
                    	{
                        	"type":"view",
                   		    "name":"百度一下",
                    		"url":"http://www.baidu.com/"
                        },
                        {
                        	"type":"pic_photo_or_album",
                   		    "name":"拍照或者相册发图",
                    	    "key": "rselfmenu_1_1", 
                   		    "sub_button": [ ]
                        },
                        {
                        	"type":"click",
                    		"name":"赞一下我吧",
                    		"key":"002_001"
                        }
                    ]
                },
                
                {
                	"name":"关于我",
                    "sub_button":[
                    	{
                        	"type":"view",
                            "name":"小德留言板",
                            "url":"http://cahoder.applinzi.com/"
                        },
                        {
                        	"type":"view",
                            "name":"珊珊",
                            "url":"https://baike.baidu.com/item/%E7%8F%8A%E7%8F%8A/303555?fr=aladdin"
                        }
                    ]
                }
            ]
        }';
      $this->get_curl_date($menuStr);//将json数据通过curl对象函数传输出去
    }
    
    //利用curl对象调用微信接口，创建自定义菜单
    public function get_curl_date($data){
    	$Access_token = $this->get_access_token();
        $ch = curl_init();
        //设置url变量 和相应的选项
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Access_token);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//是否进行证书认证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//是否进行证书认证
        if (!empty($data))
        {  
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //post上传json数据
        }  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//
        $output = curl_exec($ch);  //执行操作
        curl_close($ch); //释放资源
        var_dump($output);//打印数据
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);//将用户发送的消息全部加载完成再继续进行
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将xml格式的消息转化成PHP所认识的格式
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $time = time();
            	$msgType = $postObj->MsgType;
            
            	$textTpl_subscribe="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Event><![CDATA[%s]]></Event>
                </xml>";
            	
            	$textTpl_event_click="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Event><![CDATA[%s]]></Event>
                <EventKey><![CDATA[%s]]></EventKey>
                </xml>";
            
            	$textTpl_location="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Location_X>23.134521</Location_X>
                <Location_Y>113.358803</Location_Y>
                <Scale>%s</Scale>
                <Label><![CDATA[位置信息]]></Label>
                <MsgId>%s</MsgId>
                </xml>";
            
                $textTpl_text ="<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
				</xml>";
            
            	$textTpl_text_tuwen1 ="<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>1</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                </Articles>
				</xml>";
            
            	$textTpl_text_tuwen2 ="<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>2</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                <item><Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                </Articles>
				</xml>";
            
            	$textTpl_img ="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Image><MediaId><![CDATA[%s]]></MediaId></Image>
                </xml>";
            
            	$textTpl_voi = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>
				</xml>";
            
            	$textTpl_video = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[video]]></MsgType>
				<Video>
                <MediaId><![CDATA[%s]]></MediaId>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                </Video>
				</xml>";
				switch($msgType)
                {
                    //关注推送消息
                    case "event":
                    $eventType = $postObj->Event;
                        if($eventType=="subscribe"){
                           $msgType = "text";
                           $contentStr = "欢迎关注小德公众测试号！\n 1.发送图片回复图片 2.发送文字回复内容";
                	 	   $resultStr = sprintf($textTpl_text, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                           echo $resultStr;
                        }
                        if($eventType=="CLICK"){
                           $eventKey = $postObj->EventKey;
                           switch($eventKey)
               				 { 
                                //针对不同点击的eventkey
                               case "001":
                                  $msgType = "news";
                                  $title1 = "广东轻工职业技术学院";
                        		  $des1 = "学院简介";
                                  $picurl1 = "http://www.gdqy.edu.cn/viscms/r/cms/gdqy/moban112/images/gdqylogo.jpg";
                                  $url1 = "https://baike.baidu.com/item/%E5%B9%BF%E4%B8%9C%E8%BD%BB%E5%B7%A5%E8%81%8C%E4%B8%9A%E6%8A%80%E6%9C%AF%E5%AD%A6%E9%99%A2/2794713?fr=aladdin";
                                  $resultStr = sprintf($textTpl_text_tuwen1, $fromUsername, $toUsername, $time, $title1, $des1, $picurl1, $url1);
                           	   echo $resultStr;
                               break;
                               case "002":
                                  
                               break;
                               case "002_001":
                               //访问数据库
                               $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                               mysql_select_db("app_cahoder");
                               $sql = "update update_dianzan set update_click=update_click+1";
                               $result = mysql_query($sql,$link); //执行sql指令
                               $select_sql = "select * from update_dianzan";   //从数据库更新数据
                               $result_ = mysql_query($select_sql,$link); //执行sql指令
                               $row = mysql_fetch_array($result_);
                               
                               $msgType = "text";
                          	   $contentStr = "谢谢你的点赞，目前已有".$row['update_click']."人点赞！";
                	 	       $resultStr = sprintf($textTpl_text, $fromUsername, $toUsername, $time, $msgType, $contentStr); 
                               echo $resultStr;
                               break;
                           	 }
                        }
                    break;
                    //回复文本消息
                    case "text":
                    $keyword = trim($postObj->Content);  //仅针对文字内容获取有效
                    if($keyword=="图文")
                    {
                    	$title1 = "书记、校长开讲新学期思政第一课";
                        $des1 = "第一篇推文";
                        $picurl1 = "http://www.gdqy.edu.cn/viscms/u/cms/gdqy/201803/271855232tej.jpg";
                        $url1 = "http://www.gdqy.edu.cn/viscms/jiaoshi9944/20180327/210575.html";
                        $title2 = "财贸学子夺第二届OCALE全国跨境电商创新创业能力大赛团体一等奖";
                        $des2 = "第二篇推文";
                        $picurl2 = "http://www.gdqy.edu.cn/viscms/u/cms/gdqy/201803/261651263a4i.jpg";
                        $url2 = "http://www.gdqy.edu.cn/viscms/rongyu7652/20180326/210480.html";
                        $resultStr = sprintf($textTpl_text_tuwen2, $fromUsername, $toUsername, $time, $title1, $des1, $picurl1, $url1, $title2, $des2, $picurl2, $url2 );
                    }
                    elseif($keyword=="视频")
                    {
                    	$title="你要的视频呐！";
                        $media_id = "MG8KSXrmwHO1ZdStV9Udgt7ywnn-KEmAi0_3YIE24Gil71HH0PxJOn0QZwlo_OLq";
                        $desc = "动物篇！";
                        $resultStr = sprintf($textTpl_video, $fromUsername, $toUsername, $time, $media_id, $title, $desc);
                    }
                    elseif($keyword=="token")
                    {
                    	$contentStr .= "您的access_token是：".$this->get_access_token();
                	 	$resultStr = sprintf($textTpl_text, $fromUsername, $toUsername, $time, $msgType, $contentStr);	
                    }
                    else{
                	$contentStr = "消息发送者：".$fromUsername."\n";
                    $contentStr .= "消息接收者：".$toUsername."\n";
                    $contentStr .= "消息发送时间：".date("T-M-D H:I:S",time())."\n";
                    $contentStr .= "消息类型：".$postObj->MsgType."\n";
                    $contentStr .= "消息内容：".$postObj->Content."\n";
                    $contentStr .= "消息ID：".$postObj->MsgId."\n";
                	$resultStr = sprintf($textTpl_text, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    }
                    echo $resultStr;
                	break;
            		
                    //回复图片消息
                    case "image":
                    $media_id="KVesAwB9mcSOLmMVFtXOkRHvvVIvnYq39ivHUy2ZuNmkGqK4W5aLhL7Vxjj_MaFi";
                	$resultStr = sprintf($textTpl_img, $fromUsername, $toUsername, $time, $msgType, $media_id);
                	echo $resultStr;
                    break;
                    
                    //回复语音消息
                    case "voice";
                    $media_id="m_zQv_hhkk9XQBXWzMo-DKiyxFbG3s6EAP3aUonOKsBpKX_mAR-KNUEcVItUmOyn";
                    $resultStr = sprintf($textTpl_voi, $fromUsername, $toUsername, $time, $msgType, $media_id);
                	echo $resultStr;
                    break;
                    
                    
               }
        }
        else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>




