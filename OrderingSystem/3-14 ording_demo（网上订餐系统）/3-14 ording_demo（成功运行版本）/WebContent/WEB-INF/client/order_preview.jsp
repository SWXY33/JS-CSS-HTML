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
<title>订单状态</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/client/order_preview.css" />
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
<script language="javascript" src="<%=path%>/js/client/order.js"></script>
</head>
<body>
	<div class="container">
		<jsp:include page="../include/header.jsp" />
		<jsp:include page="../include/search.jsp" />
		<jsp:include page="../include/navi.jsp" />
		<div id="shopCartInfDiv" style="display: none;">${jsonArray}</div>
		<form id="form0">
		<div class="myorder_storeName">
			<a id="storeName" class="ca-brown" href="#">未知店铺名</a>
			-------->确认购买
			<input type="hidden" id="storeId" />
		</div>
		<div class="clearfix">
		<div class="order-info-wrapper">
			<div id="fl_address" class="fl_address">
				<div class="food-name">菜品</div>
				<div class="food-price">价格/份数</div>
			</div>
			<!-- <div class="food_list">
				<div class="order-food-name">水煮排骨</div>
				<div class="order-food-price">13块</div>
			</div> -->
			<div id="fl_address" class="fl_address">
			<div class="allprice">合计</div>
			<div id="allpricenum" class="allpricenum"></div>	
		</div>
		</div>
		<div class="dishes_rap">
			<div class="address" id="chooseAddress">
				<div class="address-title">请选择您的收餐地址</div>
				<div class="new_address">
					<a class="address-new" id="address-new"><img src="<%=path%>/icon/add2.png" />添加新地址</a>
				</div>
			</div>
			<!-- <div class="address-head">
			<div class="destination"><span>陆珊莉</span><span>女士</span>：<span>15607732513</span></div>
			<div class="destination">桂电尧山校区女生18#</div>
			</div> -->
			<div class="address-head">
				<div class="leave-message-short">
					<label for="message">给商家留言：</label>
					<input id="leaveMessageInput" name="leaveMessage" class="show-tags" type="text" placeholder="不要辣，多放盐等口味要求" />
				</div>
				<div class="pay-field">
					<div class="pay-option">
						付款方式： 
						<label>
						<input id="payOnline" name="payMethod" type="radio" value="在线支付" />
						在线支付</label>
						<label>
						<input id="payOnFace" name="payMethod" type="radio" value="餐到付款" checked="checked" />
						餐到付款</label>
					</div>
				</div>
				<a class="s-btnw" id="confirmOrder"><span class="s-btn">确认订单</span></a>
				<div class="ct-black"> 
					您需支付&nbsp;<span class="price-lightred-new">¥</span><span id="totalPrice"></span>
				</div>
				<div id="order-address-warning" class="order-address-warning" style="display: none;">* 请选择送餐地址</div>
				<div id="order-bank-card-warning" class="order-address-warning" style="display: none;">* 银行卡接口开发中</div>
			</div>
		</div>
		</div>
		</form>
		<jsp:include page="../include/footer.jsp" />
	</div>
</body>
</html>
