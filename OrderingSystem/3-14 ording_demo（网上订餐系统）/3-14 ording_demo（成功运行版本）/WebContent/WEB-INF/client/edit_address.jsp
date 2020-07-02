<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>收货地址</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script language="javascript" src="<%=path%>/js/client/editAddress.js"></script>
</head>
<body>
	<form id="form0">
		<table class="grid_layout" cellspacing="1" cellpadding="0" border="0">
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<tr>
			<td class="td_left">联系人：</td>
			<td class="td_right" style="vertical-align:middle">
				<!-- <label for="addressName">联系人</label> -->
				<input id="addressName" name="addressName" type="text" value="${name}">
			</td>
			<td class="td_left">性别：</td>
			<td class="td_right" style="vertical-align:middle">
				<label><input name="addressSex" type="radio" value="先生" <c:if test="${sex=='先生' or empty sex}"> checked='checked'</c:if> />先生</label> 
				<label><input name="addressSex" type="radio" value="女士" <c:if test="${sex=='女士'}"> checked='checked'</c:if> />女士 </label> 
			</td>
		</tr>
		<tr>
			<td class="td_left">手机号码：</td>
			<td class="td_right" style="vertical-align:middle" colspan="3">
				<input id="addressPhone" name="addressPhone" type="text" value="${tel}"/>
			</td>
		</tr>
		<tr>
			<td class="td_left">收货地址：</td>
			<td class="td_right" style="vertical-align:middle;" colspan="3">
				<input id="addressStr" name="addressStr" type="text" value="${address}" style="width: 557px;"/>
			</td>
		</tr>
		</table>
	</form>
</body>
</html>