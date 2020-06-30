<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" /> 
<title>首页</title>
<script src="js/jquery-3.4.1.min.js"></script>

<style>*{text-align:left;}
div{width:1900px;height:50px;float:left;}
</style>
</head>

<body>

<div><b>${requestScope.name}</b>您好，欢迎登录</div>
<form name="update" action="updateUser" method="post">
<div><input name="user_id" value="${requestScope.id}" type="hidden"/></div>
<div>用户名:<input name="Name" type="text" value="${requestScope.name}"></input></div>
<div>密码:<input name="Pwd" type="text" value="${requestScope.pwd}"></input></div>
<div>职务:<input name="Job" type="text" value="${requestScope.job}"></input></div>
<div><input type="submit" value="保存"></input></div>
</form>
<div><a href="index.jsp">注销</a></div>
<script type="text/javascript">
var Id="${requestScope.id}";
var Name="${requestScope.name}";
var Pwd="${requestScope.pwd}";
var Job="${requestScope.job}";
//document.getElementById("id").innerHTML=Id;
//document.getElementById("name").innerHTML=Name;
//document.getElementById("pwd").innerHTML=Pwd;
//document.getElementById("job").innerHTML=Job;
</script>



</body>
</html>