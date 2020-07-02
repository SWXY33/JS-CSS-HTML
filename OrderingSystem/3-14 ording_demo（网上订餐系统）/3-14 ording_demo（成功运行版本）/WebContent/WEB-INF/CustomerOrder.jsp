<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#joinInf td {
	text-align: center;
}
</style>
<title>商家</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/CustomerOrder.css"/>
<style>
.om-dialog .om-dialog-content{
padding: 0; margin: 0;
}
.om-grid {
overflow: visible;
position: relative;
}
</style>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script type="text/javascript">

</script>
</head>
<body>
<div class="container">
	<jsp:include page="include/header.jsp" />
	<jsp:include page="include/search.jsp" />
	<jsp:include page="include/navi.jsp" />
	<div class="restaurant">
	<div class="r_h">
	<img id="userImg" class="store_head" src="<%=path%>/images/storeHead/314be73e842a98d3b60117fe3916ef9d124928.png" 
				onmouseover="display()" onmouseout="disappear()"/>		
	</div>
	<div class="r_h">
	<div class="r"></div>
	<div class="store_name" value="${store.storeName}" name="store.storeName"><center>翠竹亭</center></div>
				<div class="star_rank">
				<span class="star_ranking"><span class="star_score">★★★★☆</span></span>
				<span class="star_num">4.3分</span>
				<span class="sale_num">月售3548单</span>
				</div>
				<div class="price">
				<span class="start_price">起送：￥7</span>
				<span class="send_time">
				<span><img src="<%=path%>/icon/icon_send_time.jpg"></img>30分钟</span>
				</span></div>
	</div>
	</div>
	<div class="menu">
	<a class="foods" href="#">菜单
	</a>
	<a class="foods" href="">评价 
	</a>
	<a href="a.jsp">a.jsp</a>
	</div>
	<div class="storehead">	
	<a href="#"><img id="userImg" class="store_head" src="<%=path%>/images/storeHead/3.jpg" 
				onmouseover="display()" onmouseout="disappear()"/></a>
				<div class="food_name" >盖浇饭</div>
				<span class="sale_num">月售35份</span>
				<div class="price">
				<span class="start_price">￥7/份</span>
				</div>
	<a href="#"><img id="userImg" class="store_head" src="<%=path%>/images/storeHead/3.jpg" 
				onmouseover="display()" onmouseout="disappear()"/></a>
				<div class="food_name" >盖浇饭</div>
				<span class="sale_num">月售35份</span>
				<div class="price">
				<span class="start_price">￥7/份</span>
				</div>			
</div>
	<jsp:include page="include/footer.jsp" />
</div>
</body>
</html>
