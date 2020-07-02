<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<%
	String path = request.getContextPath();
%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商家接单</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/business/storeOrder.css" />
<style>
.om-dialog .om-dialog-content {
	padding: 0;
	margin: 0;
}

.om-grid {
	overflow: visible;
	position: relative;
}
</style>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript"
	src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js"
	contextPath="<%=path%>" imgPath="${images_server}">
</script>
</head>
<body>
	<div class="container">
		<jsp:include page="../include/header.jsp" />
		<jsp:include page="../include/search.jsp" />
		<jsp:include page="../include/navi.jsp" />
		<div id="orderIdDiv" style="display: none;">${orderId}</div>
		<div class="myorder_storeName">
			<a id="storeName1" class="ca-brown" href="#">未知店铺名</a>
			-------->确认订单
		</div>
		<div class="clearfix">
		<div class="order-info-wrapper">
			<div class="fl_address">
				<h4>订单状态</h4>
			</div>
			<hr />
			
			<div class="fl_address">
			<div class="newOrder">10:26<li>您有新的外卖订单，请及时查收</li></div>
			<div class="receptOrder"><input type="submit" value="接收订单"></input></div>	
		</div>
		<div class="fl_address">
			<div class="jiedan">10:27<li>您已接单</li></div>
		</div>
		<div class="fl_address">
			<div class="finishOrder">10:27<li>订单完成</li></div>
		</div>
		<div class="fl_address">
			<div class="ordercomment">10:27<li>订单评价</li></div>
			<div class="foodComment">非常好吃</div>	
				
		</div>
		</div>
		<div class="order-info-wrapper">
		<div class="fl_address">
				<h4>订单详情</h4>
			</div>
			<hr />
			<div class="food_list">翠竹亭</div>
			<div class="food_list">
				<div class="order-food-name">水煮排骨</div>
				<div class="order-food-price">13块</div>
			</div>
			<div class="fl_address">
			<div class="allprice">合计</div>
			<div id="allpricenum" class="allpricenum"></div>	
		</div>
		<div class="food_list">配送地址：陆珊莉 15607732513 桂电女生18#</div>
		</div>
	</div>
		<jsp:include page="../include/footer.jsp" />
	</div>
</body>
</html>