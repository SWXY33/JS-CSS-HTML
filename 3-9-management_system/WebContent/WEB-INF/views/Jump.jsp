<%@ page contentType="text/html; charset=utf-8" language="java"	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>开关管理</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link href="css/Page.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css"/>
<script type="text/javascript" src="js/sweetalert-dev.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>


</head>


<body>
<div class="container">
		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>开关管理</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
			<div class="on-offInf">
				<div class="operationDiv">
					<a href="addbind?type=${requestScope.deviceType}"><input name="" value="＋ 新增" class="add-i" type="button" /></a> 
					<input name="" value="▶启动" class="start-i" type="button" /> 
					<input name="" value="■ 停止" class="stop-i" type="button" /> 
					<input name="" value="۞ 配置" class="config-i" type="button" /> 
					<input name="" value="× 删除" class="delete-i" type="button" id="delete"/>
					<div class="queryDiv">
					<form name="querySwitch" action="querySwitch" method="post">
					<div class="SearchText">
						<input name="queryswitch" type="text" class="search-text" placeholder="请输入设备ID/型号" /></div>
					<input name="Submit" value="◎ 搜索" class="search-i" type="submit"/></form></div>
</div>
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
	   <div id="app">
    
    
  </div>
				
    </div>






</div></div>
			</div>
</body>
</html>