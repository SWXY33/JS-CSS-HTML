<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>
<%String deviceId=request.getParameter("deviceId");
String brandMode=request.getParameter("brandMode");
String deviceMac=request.getParameter("deviceMac");
String connectionState=request.getParameter("connectionState");
String phone=request.getParameter("phone");
String deviceType=request.getParameter("deviceType");
String electricityConsumption=request.getParameter("electricityConsumption");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加设备</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link rel="stylesheet" type="text/css" href="css/OperationLog.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<style>

</style>

</head>

<body>

	<div class="container">

		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>设备操控记录</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
			<form class="modifydivice" id="modifyDivice"  method="post" action="">
				<div class="xx">
					
					<div id="aa">
					设备类型：<%=deviceType%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;设备型号：<%=brandMode %>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					设备ID：<lable style="color:#0080ff"><%=deviceId %></lable>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;设备MAC:<lable style="color:#0080ff"><%=deviceMac %></lable> 	
					</div>
					<div class="bb">
					
					
					</div>
					
				    <div id="aa">
					<a class="escswitch" href="escswitch">返回</a>
					</div>
					
				</div>
		</form>
		</div>
	</div>
	

</body>
</html>