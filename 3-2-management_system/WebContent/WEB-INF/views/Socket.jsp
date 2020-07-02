<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt"%>
<% 
String deviceId=(String)request.getAttribute("deviceId");
String deviceMac=(String)request.getAttribute("deviceMac");
String deviceType=(String)request.getAttribute("deviceType");
String brandMode=(String)request.getAttribute("brandMode");
String phone=(String)request.getAttribute("phone");
String connectionState=(String)request.getAttribute("connectionState");
String electricityConsumption=(String)request.getAttribute("electricityConsumption");
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开关管理</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<script src="js/jquery-3.4.1.min.js"></script>

</head>


<body>

	<div class="container">
		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>插座管理</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
			<div class="on-offInf">
				<div class="operationDiv">
					<a href="addbind"><input name="" value="＋ 新增" class="add-i"
						type="button" /></a> <input name="" value="▶启动" class="start-i"
						type="button" /> <input name="" value="■ 停止" class="stop-i"
						type="button" /> <input name="" value="۞ 配置" class="config-i"
						type="button" /> <input name="" value="× 删除" class="delete-i"
						type="button" />
					<div class="queryDiv">
					<form name=""queryByBrandMode"" action="queryByBrandMode" method="post">
					<div class="SearchText">
						<input name="querybybrandmode" type="text" class="search-text" placeholder="请输入设备型号" /></div>
					<input name="Submit" value="◎ 搜索" class="search-i" type="submit"/></form></div>

				<div class="diviceInfTitle">
					<ul>
						    <li>设备类型</li>
							<li>设备ID</li>
							<li>设备MAC</li>
							<li>状态</li>
							<li>绑定用户</li>
							<li>wifiMac</li>
							<li>设备型号</li>
							<li>操作</li>
						</ul>
				</div>
				<div class="diviceInfArea">
                                                      
					<ul class="aaa">
					        <li><%=deviceType%></li>
							<li><%=deviceId %></li>
							<li><%=deviceMac %></li>
							<li><%=connectionState %></li>
							<li><%=phone %></li>
							<li>null</li>
							<li><%=brandMode %></li>
							<li><a href="socketmodify?deviceId=<%=deviceId %>
							&brandMode=<%=brandMode %>
							&deviceMac=<%=deviceMac %>
							&connectionState=<%=connectionState %>
							&phone=<%=phone %>
							&deviceType=<%=deviceType%>
							&electricityConsumption=<%=electricityConsumption%>">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>1</li>
							<li>2</li>
							<li>3</li>
							<li>4</li>
							<li>5</li>
							<li>null</li>
							<li>7</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li>null</li>
							<li></li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
				</div>
				
				<div class="pageInfo"> 
				<ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a class="active" href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
 				    <li><a href="#">6</a></li>
  					<li><a href="#">7</a></li>
  					<li><a href="#">&raquo;</a></li>
				</ul>
				</div>
</div></div>
			</div>
			</div>
</body>
</html>