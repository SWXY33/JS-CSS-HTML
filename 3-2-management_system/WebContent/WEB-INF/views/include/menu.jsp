<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left</title>
<link rel="stylesheet" type="text/css" href="css/menu.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<style>
.nav a:link{text-decoration:none; color:#FFF;}/* 指正常的未被访问过的链接*/
.nav a:visited{text-decoration:none; color:#FFF;}/*指已经访问过的链接*/
.nav a:hover{text-decoration:none;color:#FFF;}/*指鼠标在链接*/
.nav a:active{text-decoration:none;color:#FFF;}/* 指正在点的链接*/
ul{
	margin:0;
	padding:0;
	list-style-type:none;
	text-align:center; 
 }
a{list-style-type:none;}
</head>

</style>
<script>
		$(function(){
    	$('.nav').on('click','li',function(){
    		$(this).addClass('clickstyle');
    		$(this).siblings().removeClass('clickstyle');
    	})
	})	
     </script>

<body>
<div class="left">
                <div class="logo"><img src="images/2.png" width="248" height="85"/></div>
                <form id="form0" action="" method="get" name="UserInf">
                <div class="LoginInf">
                <div class="LoginImg" id="Login-img">
                <span class="UploadHead"> <a href="#" target="_blank">
                <img src="images/no-head.jpg" width="100" height="100"/></a></span>
                </div>
                <div class="LoginInformation">
                <div class="login-div-name">
                <td class="UserName"><label for="loginName">姓 名: </label> </td>
                <td class=""> ${requestScope.user.username}</td>
                </div>
                <div class="login-div-job">
                <td class="UserJob"> <label for="userjob">职 位: </label>
                <td class="">Web前端</td></div>
                <div class="login-div-userid">
                <td class=""><label for="userid"> I D : </label>
                <td class=""> 000000000</td></div>
                </div>
                </div>
               </form>
               <ul class="nav">
               <a href="login"><li class="selected"><div class="Navbar">首页 Home &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li></a>
               <a href="switch"><li><div class="Navbar">开关 Switch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li></a>
               <li><div class="Navbar"><a href="socket">插座 Socket</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li>
               <a href="curtain"><li><div class="Navbar">窗帘 Curtain &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li></a>
               <li><div class="Navbar"><a href="router">路由 Router</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li>
               <li><div class="Navbar"><a href="PAS">新风系统 PAS</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li>
               <li><div class="Navbar"><a href="vue">vue测试</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li>
               <li><div class="Navbar"><a href="testPage">分页测试</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></li>
               </ul>
               </div><!-- left-->
</body>
</html>