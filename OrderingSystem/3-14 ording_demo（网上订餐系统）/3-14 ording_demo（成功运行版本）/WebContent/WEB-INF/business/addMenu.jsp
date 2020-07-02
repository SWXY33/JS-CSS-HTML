<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>新增菜色</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script language="javascript" src="<%=path%>/js/business/addMenu.js"></script>
</head>
<body>
	<form id="form0">
		<input id="storeId" type="hidden" value="${storeId}" name="storeMenu.store.id">
		<table class="grid_layout" cellspacing="1" cellpadding="0" border="0">
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<tr>
			<td class="td_left">菜名：</td>
			<td class="td_right" style="vertical-align:middle">
				<input type="text" name="storeMenu.menuName" value="${storeMenu.menuName}"/>
				<span class="errorMsg"></span>
			</td>
			<td rowspan="7" class="td_left">图片：</td>
			<td rowspan="7" class="td_right" align="center">
				<img id="menuImg" src="<c:if test="${empty storeMenu.photo.relativePath}"><%=path%>/images/no-head.jpg</c:if>
				<c:if test="${! empty storeMenu.photo.relativePath}">${images_server}${storeMenu.photo.relativePath}</c:if>" 
				 style="width: 200px;height: 150px;border:1px solid #ccc; padding: 1px;" onerror="$(this).attr('src','<%=path%>/images/no-head.jpg');" />	
				<span style="display: block; width: 160px; height: 30px; padding-top: 5px;">
					<a href="javascript:void(0);" id="storeMenu_upload_button">上传照片</a>
				</span>
			</td>
			<td>
				<input type="hidden" id="menu_photo_id" name="storeMenu.photo.id" value="${storeMenu.photo.id}" />
			</td>
		</tr>
		<tr>
			<td class="td_left">分类：</td>
			<td class="td_right" style="vertical-align:middle">
				<input id="menuType" name="storeMenu.menuType" value="${storeMenu.menuType}"/>
				<span class="errorMsg"></span>
			</td>
		</tr>
		<tr>
			<td class="td_left">价格：</td>
			<td class="td_right" style="vertical-align:middle">
				<input type="text" name="storeMenu.menuPrice" value="${storeMenu.menuPrice}"/>
				<span class="errorMsg"></span>
			</td>
		</tr>
		</table>
	</form>
</body>
</html>