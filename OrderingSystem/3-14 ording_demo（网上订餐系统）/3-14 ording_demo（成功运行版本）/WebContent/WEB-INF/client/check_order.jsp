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
<title>用户下单</title>
<link rel="stylesheet" type="text/css"
	href="<%=path%>/om-ui/css/apusic/om-apusic.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css" />
<link rel="stylesheet" type="text/css"
	href="<%=path%>/css/client/check_order.css" />
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
<script type="text/javascript" src="<%=path%>/dwr/util.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/engine.js"></script>
<script type="text/javascript"
	src="<%=path%>/dwr/interface/messagePush.js"></script>
<script language="javascript" src="<%=path%>/js/client/checkOrder.js"></script>
<script language="javascript">
//这个方法用来启动该页面的ReverseAjax功能
dwr.engine.setActiveReverseAjax(true);
//设置在页面关闭时，通知服务端销毁会话
dwr.engine.setNotifyServerOnPageUnload(true);

var tag = '${LOGIN_USER_SESSION_KEY.id}';//自定义一个标签
if(tag.length > 0)messagePush.onPageLoad(tag);
//这个函数是提供给后台推送的时候调用的
function businessAceptOrder(content){
	var ele = '<div class="fl_address"><div class="already"><li>商家已接单'
		+'</li></div><div class="alreadyTime">' + new Date().Format('yyyy-MM-dd hh:mm:ss') + '</div></div>';
	$('#customerOrderInfDiv').append(ele);
}
</script>
</head>
<body>
	<div class="container">
		<jsp:include page="../include/header.jsp" />
		<jsp:include page="../include/search.jsp" />
		<jsp:include page="../include/navi.jsp" />
		<div id="orderIdDiv" style="display: none;">${orderId}</div>
		<div class="myorder_storeName">
			<a id="storeName1" class="ca-brown" href="#">未知店铺名</a> -------->确认购买
		</div>
		<div class="clearfix">
			<div class="order-info-wrapper" id="customerOrderInfDiv">
				<div class="fl_address">
					<h4>订单状态</h4>
				</div>
				<hr />

				<div class="fl_address">
					<div class="orderRecept">
						<li>订单已提交，请耐心等待</li>
					</div>
					<div class="receptTime" id="orderCreateTime"></div>
				</div>
				<div class="fl_address">
					<div class="already">
						<li>等待商家接单</li>
					</div>
					<div class="alreadyTime" id="orderWaitBusTime"></div>
				</div>
				<!-- <div class="fl_address">
					<div class="orderfinish">
						<li>订单完成</li>
					</div>
					<div class="finishTime">
						<button>确认</button>
						10:50
					</div>
				</div>
				<div class="fl_address">
					<div class="ordercomment">
						<li>订单评价</li>
					</div>
					<div class="foodcomment">
						<input></input>
						<button class="comment">提交</button>
					</div>
				</div> -->
			</div>
			<div class="order-info-wrapper">
				<div class="fl_address">
					<h4>订单详情</h4>
				</div>
				<hr />
				<div class="food_list" id="storeName2">未知店铺名</div>
				<!-- <div class="food_list">
					<div class="order-food-name">水煮排骨</div>
					<div class="order-food-price">
						¥<span>13</span>*<span>1</span>
					</div>
				</div> -->
				<div class="fl_address">
					<div class="allprice" id="allPrice">合计</div>
					<div id="allpricenum" class="allpricenum">
						¥<span>0</span>
					</div>
				</div>
				<div class="sendInf">
				<div class="food_list1" id="addressDiv">
					配送地址：
					<!-- <span>陆珊莉</span><span>女士</span>:<span>15607732513</span>&nbsp;<span>桂电女生18#</span></div>-->
				</div>
				<div class="food_list2" id="guestNeed">备注：<!-- <span>加饭</span> -->
				</div> 
				</div>
			</div>
			</div>
			<jsp:include page="../include/footer.jsp" />
</body>
</html>