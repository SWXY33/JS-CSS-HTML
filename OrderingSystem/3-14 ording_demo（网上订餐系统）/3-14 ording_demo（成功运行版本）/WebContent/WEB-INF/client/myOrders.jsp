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
<title>所有订单</title>
<link rel="stylesheet" type="text/css"
	href="<%=path%>/om-ui/css/apusic/om-apusic.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css" />
<link rel="stylesheet" type="text/css" href="<%=path%>/css/business/allOrder.css" />
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript"
	src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js"
	contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script type="text/javascript" src="<%=path%>/dwr/util.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/engine.js"></script>
<script type="text/javascript" src="<%=path%>/dwr/interface/messagePush.js"></script>
<script language="javascript" src="<%=path%>/js/business/allOrder.js"></script>
</head>
<body>
	<div class="container">
		<jsp:include page="../include/header.jsp" />
		<jsp:include page="../include/search.jsp" />
		<jsp:include page="../include/navi.jsp" />
		所有订单
		<div id="storeId" style="display: none;">${storeId}</div>
		<!-- <table>
			<tbody>
				<tr>
					<td>
						<label><input type="checkbox" /><span class="orderDateClass">2016-05-01</span></label>
						<span><span>订单号</span><span>:</span><span class="orderNumClass">1549842034505391</span></span>
					</td>
					<td>
						<span>
							<a>蒸之味</a>
						</span>
					</td>
					<td>
						<a class="acceptOrder" name="orderId" onclick="">接受订单</a>
						<a href="#" title="删除订单" target="_blank" id="delOrder">
							<i></i>
						</a>
					</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td>
						<div><span>水煮肉片</span></div>
					</td>
					<td>
						<div><span>¥</span><span>10</span>*<span>1</span></div>
					</td>
				</tr>
			</tbody>
		</table> -->
		<div id="orderPageDiv"></div>
		<jsp:include page="../include/footer.jsp" />
	</div>
</body>
</html>