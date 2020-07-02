<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>我的店铺</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/mystore.css"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/util.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/engine.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/interface/messagePush.js"></script>
<script type="text/javascript" src="<%=path%>/js/playVoice.js"></script>
<script type="text/javascript">
//这个方法用来启动该页面的ReverseAjax功能
dwr.engine.setActiveReverseAjax(true);
//设置在页面关闭时，通知服务端销毁会话
dwr.engine.setNotifyServerOnPageUnload(true);

var tag = '${LOGIN_USER_SESSION_KEY.id}';//自定义一个标签
if(tag.length > 0)messagePush.onPageLoad(tag);
//这个函数是提供给后台推送的时候调用的
function showOrderTip(content){
	if($('#ordingTipFlag').attr('class') == 'flag2'){
		return;
	}
	$('#ordingTipFlag').attr('class','flag2');
	$('#orderAudio')[0].play();
	$.omMessageTip.show({
		title : '提示',
		content : '您有新的订单,<a href="<%=path%>/business/orderInf!allOrder.action?storeId=${storeId}">查看</a>',
		onClose : function(){
			$('#ordingTipFlag').attr('class','flag1');
		}
	});
}
</script>
<script language="javascript" src="<%=path%>/js/business/mystore.js"></script>
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
	
	<div class="findOrder"><hr>订单中心：
	<a href="<%=path%>/business/orderInf!allOrder.action?storeId=${storeId}" style=" color:blue; font-size:30px;">查看订单</a><hr>
	</div>
	<div class="findOrder" >
	<marquee scrollamount=3 FONT style="FONT-SIZE: 30pt; 
	FILTER: glow(color=black); 
	WIDTH: 100%; COLOR: #e4dc9b; 
	LINE-HEIGHT: 150%; 
	FONT-FAMILY: 华文彩云">
	<B>各位商家您好，非常感谢您加盟《莉莉订餐中心》，祝您生意兴隆O(∩_∩)O</B>
	</FONT>
</marquee></div>
	</div>
 	<div class="my_s">
	<div class="order_manage" id="order_manage_div">
	<div class="add-food">
	<button id="addMenuBtn">新增菜色</button>
	</div>
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
			<span class="mystart_price">￥7/份</span>
		</div>
		</div> --%>
	</div>
	</div>
	
	</div>
	<jsp:include page="../include/footer.jsp" />
</div>
</body>
</html>