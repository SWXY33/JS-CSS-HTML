<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left</title>
<link rel="stylesheet" type="text/css" href="css/footer.css" />
<title>Insert title here</title>
</head>
<body>
<div class="footer">
                <div class="diviceInf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>设备详情</b></div>
                <div class="refresh2"><a href="#" target="_blank"><img src="icon/refresh.png" width="45" height="48"/></a></div>
                <div><img src="icon/redline.png" width="1630" height="3"/></div>
                <div class="diviceType1">
                <div class="On-Off">
                  <div class="on-off-img"><img src="icon/on-off.jpg" /></div>
                  <div class="on-off-name"><b>开 关</b></div>
                </div>
                <div class="on-off-inf">
                <form action="" method="get" name="On-Off-Inf" id="on_off">
                <div class="sum"><b>设备总数：${requestScope.switchcount}</b></div>
                <div class="online"><b>在线设备：</b></div>
                <div class="onlinesum"><b>${requestScope.switchconnectCount}</b></div>
                 </form>
                </div>
                </div>
                
                <div class="diviceType2">
                <div class="Socket">
                  <div class="socket-img"><img src="icon/socket.jpg" /></div>
                  <div class="socket-name"><b>插 座</b></div>
                </div>
                <div class="socket-inf">
                <form action="" method="get" name="Socket-Inf" id="socket">
                <div class="sum"><b>设备总数：${requestScope.socketcount}</b></div>
                <div class="online"><b>在线设备：</b></div>
                <div class="onlinesum"><b>${requestScope.socketconnectCount}</b></div>
                 </form>
                </div>
                </div>
              
                <div class="diviceType3">
                <div class="Curtain">
                  <div class="curtain-img"><img src="icon/curtain.jpg" /></div>
                  <div class="curtain-name"><b>窗 帘</b></div>
                </div>
                <div class="curtain-inf">
                <form action="" method="get" name="Curtain-Inf" id="curtain">
                <div class="sum"><b>设备总数：${requestScope.curtainscount}</b></div>
                <div class="online"><b>在线设备：</b></div>
                <div class="onlinesum"><b>${requestScope.curtainsconnectCount}</b></div>
                 </form>
                </div>
                </div> 
                <div class="diviceType4">
                <div class="Router">
                  <div class="router-img"><img src="icon/router.png" width="78" height="78"/></div>
                  <div class="router-name"><b>路 由</b></div>
                </div>
                <div class="router-inf">
                <form action="" method="get" name="Router-Inf" id="router">
                <div class="sum"><b>设备总数：暂无数据</b></div>
                <div class="online"><b>在线设备：</b></div>
                <div class="onlinesum"><b></b></div>
                 </form>
                </div>
                </div> 
                <div class="diviceType5">
                <div class=" PAS">
                  <div class="pas-img"><img src="icon/NWS.jpg" width="78" height="78"/></div>
                  <div class="pas-name"><b>新风系统</b></div>
                </div>
                <div class="pas-inf">
                <form action="" method="get" name="PAS-Inf" id="pas">
                <div class="sum"><b>设备总数：${requestScope.fresh_air_systemcount}</b></div>
                <div class="online"><b>在线设备：</b></div>
                <div class="onlinesum"><b>${requestScope.fresh_air_systemconnectCount}</b></div>
                 </form>
                </div>
                </div> 
           
               </div><!--footer-->
               
</body>
</html>