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
<title>home</title>
<link rel="stylesheet" type="text/css"
	href="<%=path%>/om-ui/css/apusic/om-apusic.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css" />
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
<script type="text/javascript">
	$(function() {
		//下标start开始显示limit个
		var findStoreUrl = path + '/business/openStore!getStores.action'
			+ '?start=0&limit=20';
		lili.ajax.sys(findStoreUrl,null,function(data){
			if(data.length <= 0)return false;
			for(var i = 0; i < data.length; i++){
				var newStoreInfo = '<div class="head"><a href="#" id="'
					+ data[i].id + '"><img src="' + images_server
					+ data[i].logo.relativePath + '" class="store_head"/></a>'
					+ '<div class="store_name">' + data[i].storeName + '</div>'
					+ '<div class="star_rank"><span class="star_ranking">'
					+ '<span class="star_score">★★★★☆</span></span><span class="star_num">'
					+ '4.3分</span><span class="sale_num">月售3548单</span>'
					+ '</div><div class="price"><span class="start_price">起送：￥7</span>'
					+ '<span class="send_time"><span><img src="' + path
					+ '/icon/icon_send_time.jpg" />30分钟</span></span></div>' + '</div>';
				$('#storesInf').append(newStoreInfo);
			}
			$('.head').each(function(){
				$(this).children('a').click(function(){
					var sId = $(this).attr('id');//获得a标签的属性(id)的值
					window.location.href = path + '/customer/order!toStore.action'
						+ '?store.id=' + sId;
				});
			});
		});
	});
</script>
</head>
<body>
	<div class="container">
		<jsp:include page="include/header.jsp" />
		<jsp:include page="include/search.jsp" />
		<jsp:include page="include/navi.jsp" />
		<div id="storesInf" class="storehead">
		</div>
		<%-- <div class="storehead">
			<div class="head">
				<a href="#"><img id="userImg" class="store_head"
					src="<%=path%>/images/storeHead/314be73e842a98d3b60117fe3916ef9d124928.png"
					onmouseover="display()" onmouseout="disappear()" /></a>
				<div class="store_name">翠竹亭</div>
				<div class="star_rank">
					<span class="star_ranking"><span class="star_score">★★★★☆</span></span>
					<span class="star_num">4.3分</span> <span class="sale_num">月售3548单</span>
				</div>
				<div class="price">
					<span class="start_price">起送：￥7</span> <span class="send_time">
						<span><img src="<%=path%>/icon/icon_send_time.jpg"></img>30分钟</span>
					</span>
				</div>
			</div>
		</div> --%>
		<jsp:include page="include/footer.jsp" />
	</div>
</body>
</html>
