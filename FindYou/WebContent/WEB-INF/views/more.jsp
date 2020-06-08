<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<% request.setCharacterEncoding("UTF-8");%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" /> 
<title>more</title>
<script src="js/jquery-3.4.1.min.js"></script>

</head>
<body>

<h1>………………………………………………………………………………………………………</h1>
<h2>你使用的网络是：${requestScope.net}</h2>
<h2>当前时间是：${requestScope.time}</h2>
<h2>你在：${requestScope.country}${requestScope.province}${requestScope.city}${requestScope.xian}</h2>
<h2>你使用的设备是：${requestScope.deviceName}</h2>


</body>
</html>