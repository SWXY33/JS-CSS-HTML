<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" /> 
<title>登录界面</title>
<link rel="stylesheet" type="text/css" href="css/sweetalert.css"/>
<script type="text/javascript" src="js/sweetalert-dev.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
</head>
<body>
<form name="LoginForm" action="Login" method="post">
<div>请输入用户名：<input name="loginname" type="text" ></input></div><br/>
<div>请输入密码：<input name="pwd" type="text" ></input></div><br/>
<div><input type="submit"  value="登录"/></div>
</form>
<br/><a href="register">注册</a>
<br/>

<a href="chaxun">点击查询Navicat for MySQL中test数据库的login表的详细数据</a>
<script type="text/javascript">
var msg="${requestScope.msg}";
if(msg!="succese"){
	swal("用户名或密码错误！");
}
else{
var allUser=${requestScope.Array};
var app = new Vue({
    el: '#app',
    data: {
    	arr:allUser
    },
    methods: {
    	deleteu:function(userid){
    		return 'deleteUser?id='+userid
    	},
        update:function(userid,username,userpwd,userjob){
    		return 'updateUser?user_id='+userid+'&&Name='+username+'&&Pwd='+userpwd+'&&Job='+userjob
    	}
    }
    })
}

</script>
</body>
</html>