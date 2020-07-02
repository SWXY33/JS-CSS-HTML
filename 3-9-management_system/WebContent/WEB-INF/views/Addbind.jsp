<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加设备</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link rel="stylesheet" type="text/css" href="css/Addbind.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<style>
a.esc{text-decoration:none;font-size:18px;margin:20px;}
</style>

</head>

<body>

	<div class="container">

		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>添加设备</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
			<form class="addbind" id="addNewDivice"  method="post" action="addNew">
				<div class="xx">
					<div id="aa">
						<div class="divicetype"><b>设备类型:</b></div>
						<div>
							<label><input type="radio" style="width: 20px; height: 20px" name="test" class="type-i" id="on-off" value=""></input> </label>
						    <span class = "span-style">开关</span></div>
						<div>
							<label><input type="radio" style="width: 20px; height: 20px" name="test" class="type-i" id="socket" value=""></input> </label>
							<span class="span-style">插座</span>
						</div>
						<div>
							<label><input type="radio"
								style="width: 20px; height: 20px" name="test" class="type-i"
								id="curtain" value=""></input> </label><span class="span-style">窗帘</span>
						</div>
						<div>
							<label><input type="radio" style="width: 20px; height: 20px" name="test" class="type-i" id="router" value=""></input> </label>
							<span class="span-style">路由</span>
						</div>
						<div>
							<label><input type="radio" name="test" class="type-i" id="PAS" value="" style="width: 20px; height: 20px"></input> </label>
							<span class="span-style">新风系统</span>
						</div>
					</div>
				    
					<div id="bb">
						<label><b>设备MAC：</b></label> <input type="text"/>
					</div>
					<div id="bb">
						<label><b>设备型号：</b></label>&nbsp; <input type="text"/>
					</div>
					<div id="bb">
						<label><b>绑定用户：</b></label> &nbsp;<input type="text"/>
					</div>
					<div id="bb">
						<input class="AddBt" type="submit" value="添加设备"/>
						<a class="esc" href="esc?devicetype=${requestScope.type}">返回</a>
					</div>
				</div>
		</form>
		</div>
	</div>
	

</body>
</html>