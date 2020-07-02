<%@ page language="java" contentType="text/html; charset=utf-8"
    pageEncoding="utf-8"%>
<%String path = request.getContextPath(); %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>注册商家</title>    
</head>
<body>
	<form action="businessRegister.action" method="post">
		<br>用户名：<input name="user.loginName" type="text" placeholder="用户名"/>
		<br>密码：        <input name="user.loginPwd" type="text" placeholder="密码"/>
		<br>手机号：    <input name="user.tel" type="text" placeholder="手机号" />
		<br>邮箱：        <input name="user.email" type="text" placeholder="邮箱"/>
		<br><input type="submit" value="注册商家"/>
	</form>
</body>
</html>