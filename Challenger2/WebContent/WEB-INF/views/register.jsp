<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" /> 
<title>注册</title>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
<style></style>
</head>

<body>

<div>注册</div>
<form name="registeruser" method="post" action="add">
<div>用户名：<input  name="registername" type="text" placeholder="请输入用户名"/></div>
<div>密码：<input  name="registerpwd" type="text"  placeholder="请输入密码"/></div>
<div>职务：<input  name="registerjob" type="text"  placeholder="请输入职务"/></div>
<div><input type="submit"  value="注册"/></div>
</form>
<div><a href="index.jsp">返回</a></div>
<script type="text/javascript">

</script>

</body>
</html>