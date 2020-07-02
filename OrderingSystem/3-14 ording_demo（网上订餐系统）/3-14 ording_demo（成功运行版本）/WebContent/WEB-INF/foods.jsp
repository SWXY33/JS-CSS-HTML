<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#joinInf td {
	text-align: center;
}
</style>
<title>信息资料</title>
</head>
<body>
	<h1>
		当前商家：hello， ${LOGIN_USER_SESSION_KEY.loginName}
			<a href="logout.action">退出</a>

	</h1>
<br></br>
菜单：
	${images_server_ip}:${images_server_port}
	<img src="http://${images_server_ip}:${images_server_port}/images/1.jpg"/>
</body>
</html>
