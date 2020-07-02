<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>navi</title>
<script type="text/javascript">
$(function(){
	//导航栏
	jQuery.navigation = function(obj) {
		$(obj).prepend('<span></span>');
		$(obj).each(function() {
			var linkText = $(this).find("a").html();
			$(this).find("span").show().html(linkText);
		});
		$(obj).hover(function() {
			$(this).find("span").stop().animate({
				marginTop: "-40"
			}, 250);
		} , function() {
			$(this).find("span").stop().animate({
				marginTop: "0"
			}, 250);
		});
	};
	$.navigation("#menu li");
});
</script>
</head>
<body>
<div id="menu">
	<ul>
	    <li><a href="home.action">首页</a></li>
	    <li><a href="<%=path %>/customer/order!myOrders.action">我的外卖</a></li>
	    <li><a href="<%=path %>/business/openStore!preOpen.action">加盟合作</a></li>
	    <li><a href="<%=path %>/business/openStore!preOpen.action">我的店铺</a></li>
	    <li><a href="#">论坛交流</a></li>
	</ul>
	<div class="cls"></div>
</div>
</body>
</html>