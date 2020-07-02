<%@ page contentType="text/html; charset=utf-8" language="java"	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>设备IP地址</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/QueryIP.css"/>
<link href="css/Page.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css"/>
<script type="text/javascript" src="js/sweetalert-dev.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>


<style>
	.class1{
  background: #444;
  color: #bb9;
}

</style>

</head>


<body>
<div class="container">
		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>设备IP地址</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
		<div class="queryDiv">
					<form name="queryIP" action="queryIP" method="post">
					<div class="SearchText">
						<input name="queryip" type="text" class="search-text" placeholder="请输入设备MAC" /></div>
					<input name="Submit" value="◎ 查询" class="search-i" type="submit"/></form></div>
				<div class="diviceInfTitle">
					<ul>			
							<li>设备MAC</li>
							<li>设备ip</li>
							<li>设备所在省份</li>
							<li>设备所在城市</li>						
						</ul>
				</div>
				
				<div class="diviceInfArea"> 
	   <div id="app">
    <ul>    
	  <li>{{ipdata.mac}}</li>
	  <li>{{ipdata.ip}}</li>
	  <li>{{ipdata.province}}</li>
	  <li>{{ipdata.city}}</li>
    </ul>
    
  </div>
				
    </div>

<script type="text/javascript">
var IPdata =${requestScope.IPData};

  var app = new Vue({
    el: '#app',
    data: {
    	ipdata:IPdata
    }
    })

</script>




</div></div>
			</div>
</body>
</html>