<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt"%>
<%String deviceId=request.getParameter("deviceId");
String brandMode=request.getParameter("brandMode");
String deviceMac=request.getParameter("deviceMac");
String connectionState=request.getParameter("connectionState");
String phone=request.getParameter("phone");
String deviceType=request.getParameter("deviceType");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开关管理</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link rel="stylesheet" type="text/css" href="css/getDeviceBindedByBrandMode.css" />
<script src="js/jquery-3.4.1.min.js"></script>

</head>


<body>

	<div class="container">

		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="displayArea">
				<div class="on-offDivice">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>开关管理</b>
				</div>
				<a href="#" target="_blank"><img src="icon/refresh.png"
					width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
					height="3" />
				<div class="on-offInf">
					<div class="operationDiv">
						<a href="addbind"><input name="" value="＋ 新增" class="add-i"
						type="button" /></a>
						<input name="" value="▶启动" class="start-i" type="button" /> <input
							name="" value="■ 停止" class="stop-i" type="button" /> <input
							name="" value="۞ 配置" class="config-i" type="button" /> <input
							name="" value="× 删除" class="delete-i" type="button" />
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
							<li>定时情况</li>
							<li>设备型号</li>
							<li>操作</li>
						</ul>
					</div>
					<div class="diviceInfArea">
					<ul>
							<li><%=brandMode %></li>
							<li><%=deviceId %></li>
							<li><%=deviceMac %></li>
							<li><%=connectionState %></li>
							<li><%=phone %></li>
							<li>null</li>
							<li><%=deviceType%></li>
							<li><a href="switchmodify?deviceId=<%=deviceId %>
							&brandMode=<%=brandMode %>
							&deviceMac=<%=deviceMac %>
							&connectionState=<%=connectionState %>
							&phone=<%=phone %>
							&deviceType=<%=deviceType%>">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li><%=brandMode %></li>
							<li><%=deviceId %></li>
							<li><%=deviceMac %></li>
							<li><%=connectionState %></li>
							<li><%=phone %></li>
							<li>null</li>
							<li><%=deviceType%></li>
							<li><a href="switchmodify?deviceId=<%=deviceId %>
							&brandMode=<%=brandMode %>
							&deviceMac=<%=deviceMac %>
							&connectionState=<%=connectionState %>
							&phone=<%=phone %>
							&deviceType=<%=deviceType%>">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
							<li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						<ul>
						    <li>${requestScope.brandMode}</li>
							<li>${requestScope.deviceId}</li>
							<li>${requestScope.deviceMac}</li>
							<li>${requestScope.connectionState}</li>
							<li>${requestScope.phone}</li>
							<li>null</li>
							<li>${requestScope.deviceType}</li>
							<li><a href="">编辑</a> |  <a href="">操作记录</a></li>
						</ul>
						
						
					<script>
					function getDeviceBindedByBrandMode() {
							var str = "";
							//计算当月的天数和每月第一天都是周几，day_month和day_year都从上面获得
							var totalDay = daysMonth(my_month, my_year);
							var firstDay = dayStart(my_month, my_year);
							//添加每个月的空白部分
							for (var i = 0; i < firstDay; i++) {
								str += "<li>" + "</li>";
							}

							//从一号开始添加直到totalDay，并为pre，next和当天添加样式
					var myclass;
				for (var i = 1; i <= totalDay; i++) {
					//三种情况年份小，年分相等月份小，年月相等，天数小
					//点击pre和next之后，my_month和my_year会发生变化，将其与现在的直接获取的再进行比较
					//i与my_day进行比较,pre和next变化时，my_day是不变的
					console.log(my_year + " " + my_month + " " + my_day);
					console.log(my_date.getFullYear() + " "
							+ my_date.getMonth() + " " + my_date.getDay());
					if ((my_year < my_date.getFullYear())
							|| (my_year == my_date.getFullYear() && my_month < my_date
									.getMonth())
							|| (my_year == my_date.getFullYear()
									&& my_month == my_date.getMonth() && i < my_day)) {
						myclass = " class='lightgrey'";
					} else if (my_year == my_date.getFullYear()
							&& my_month == my_date.getMonth() && i == my_day) {
						myclass = "class = 'green greenbox'";
					} else {
						myclass = "class = 'darkgrey'";
					}
					str += "<li "+myclass+">" + i + "</li>";
				}
				older.innerHTML = str;
				ctitle.innerHTML = month_name[my_month];
				cyear.innerHTML = my_year;
						}
				getDeviceBindedByBrandMode();
				</script>
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
			</div></div></div>
			</div>
			</div>
</body>
</html>