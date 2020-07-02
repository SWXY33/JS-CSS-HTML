<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/client/restaurant2.css"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script language="javascript" src="<%=path%>/js/client/restaurant2.js"></script>
<script language="javascript" src="<%=path%>/js/client/restaurantCommon.js"></script>
<script language="javascript" src="<%=path%>/js/client/parabola.js"></script>
</head>
<body>
<div class="container">
	<jsp:include page="../include/header.jsp" />
	<jsp:include page="../include/search.jsp" />
	<jsp:include page="../include/navi.jsp" />
	<input id="storeId" type="hidden" value="${storeId}" />
	<div class="mystore">
	<div class="others">
	<div id="sDescribeDiv" class="my_st">
	<center><h5>店铺公告：</h5></center><br>
	<!-- <span class="gonggao"></span> -->
	</div>
	<div class="welcome"><hr>
	<marquee scrollamount=3 FONT style="FONT-SIZE: 30pt; 
	FILTER: glow(color=black); 
	WIDTH: 100%; COLOR: #e4dc9b; 
	LINE-HEIGHT: 150%; 
	FONT-FAMILY: 华文彩云">
	<B>各位顾客您好，非常感谢您来到《莉莉订餐中心》，祝您订餐愉快！O(∩_∩)O</B>
	</FONT>
</marquee>
	</div>
	</div>
	<div class="my_s">
	<div class="order_manage" id="order_manage_div">
		<%-- <div class="store_menu">
			<div class="s_t">
			<img class="mystore_head" src="<%=path%>/images/storeHead/a.png"/>
			</div>
			<div class="s_t">
			<div class="mystore_name">翠竹亭</div>
			<div class="mystar_rank">
				<span class="mystar_ranking"><span class="star_score">★★★★☆</span></span>
				<span class="mystar_num">4.3分</span>
				<span class="mysale_num">月售3548单</span>
			</div>
			<div class="myprice">
				<span class="mystart_price">起送：￥7</span>
				<span class="mysend_time">
					<span><img src="<%=path%>/icon/icon_send_time.jpg" />30分钟</span>
				</span>
			</div>
			</div>
		</div> --%>
	</div>
	<div id="store_foods_div" class="store_foods">
		<%-- <div class="store_food">
		<a href="#" title="盖浇饭" class="id">
			<img class="store_head" src="<%=path%>/images/storeHead/3.jpg" />
		</a>
		<div class="myfood_name" >盖浇饭</div>
		<span class="mysale_num">月售35份</span>
		<div class="myprice">
			<span class="mystart_price">￥7/份
				<a href="javascript:;">
				<img src="<%=path%>/icon/add2.png"/>
				</a>
			</span>
		</div>
		</div> --%>
	</div>
	</div>
	<div id="flyItem" class="fly_item">
		<img src="" width="50" height="50"/>
	</div>
	<div class="mui-mbar-tabs">
	<div class="quick_link_mian">
	<div class="quick_links_panel">
	<div id="quick_links" class="quick_links">
		<li id="shopCart">
		<a href="#" class="message_list">
			<i class="message"></i>
			<div class="span">购物车</div>
			<span class="cart_num">0</span>
		</a>
		</li>
	</div>
	</div>
	<div id="quick_links_pop" class="quick_links_pop hide"></div>
	</div>
	</div>
	</div>
	<jsp:include page="../include/footer.jsp" />
</div>
</body>
</html>