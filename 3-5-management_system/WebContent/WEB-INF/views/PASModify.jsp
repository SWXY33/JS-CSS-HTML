<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>
<%String deviceId=request.getParameter("deviceId");
String brandMode=request.getParameter("brandMode");
String deviceMac=request.getParameter("deviceMac");
String connectionState=request.getParameter("connectionState");
String phone=request.getParameter("phone");
String deviceType=request.getParameter("deviceType");
String reversing=request.getParameter("reversing");
String percentage=request.getParameter("percentage");
String electricityConsumption=request.getParameter("electricityConsumption");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link rel="stylesheet" type="text/css" href="css/Modify.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<style>

</style>

</head>

<body>

	<div class="container">

		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>新风系统设备详情</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
			<form class="modifydivice" id="modifyDivice"  method="post" action="">
				<div class="xx">
					
					<div id="aa">
					设备类型：&nbsp;&nbsp;&nbsp;<%=deviceType%>
					</div>
					<div id="aa">
					<div class="bb">设备型号：<%=brandMode %></div>
					
					<div id="aa">
					设备MAC：&nbsp;&nbsp;&nbsp;<lable style="color:#0080ff"><%=deviceMac %></lable>
					</div>
					<div id="aa">
					局域网MAC:&nbsp;&nbsp;&nbsp;<lable style="color:#0080ff"><%=deviceMac %></lable>
					</div>
					
					<div id="aa">
					<script>
					function showconnection(){
					var connectionState1="<%=connectionState%>";
					var c1=document.getElementById('c1');
					var c2=document.getElementById('c2');
					if(connectionState1==0){
						c2.style.display='none';
					}else{
						c1.style.display='none';
					}
					}
					
					</script>
					<div class="bb">设备连接状态:
					<div class="cc" id="c1">不在线</div>
					<div class="cc" id="c2">在线</div></div>
					<div class="bb">（<a onclick="showconnection()">断开连接</a>）</div>
					</div>
					<div id="aa">
					设备定时情况:&nbsp;&nbsp;&nbsp; 
					<input type="checkbox" id="toggle-button"><!--label中的for跟input的id绑定。作用是在点击label时选中input或者取消选中input-->
    <label for="toggle-button" class="button-label">
        <span class="circle"></span>
        <span class="text on">开</span>
        <span class="text off">关</span>
    </label>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
                                                                       定时设定：
  <div class="settime"><form name="form" id="form">
  <select name="week" size="1" class="setTime" id="week" >
    <option>星期一</option>
    <option>星期二</option>
    <option>星期三</option>
    <option>星期四</option>
    <option>星期五</option>
    <option>星期六</option>
    <option>星期日</option> 
  </select>
 <input name="openstate"id="openstate" type="text"></input>:
 <input name="opentime"id="opentime" type="text"></input>（开）-
  <input name="closestate"id="closestate" type="text"></input>:
 <input name="closetime"id="closetime" type="text"></input>（关）  
  </select>
</form></div>
					</div>
					
				    <div id="aa">
					<a class="escPAS" href="escPAS?deviceId=<%=deviceId %>
							&brandMode=<%=brandMode %>
							&deviceMac=<%=deviceMac %>
							&connectionState=<%=connectionState %>
							&phone=<%=phone %>
							&deviceType=<%=deviceType%>
							&electricityConsumption=<%=electricityConsumption%>
							&reversing=<%=reversing%>
                            &percentage=<%=percentage%>">返回</a>
					</div>
					
				</div>
		</form>
		</div>
	</div>
	

</body>
</html>