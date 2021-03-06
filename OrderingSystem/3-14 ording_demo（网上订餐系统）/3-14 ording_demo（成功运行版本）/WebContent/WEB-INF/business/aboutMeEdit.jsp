<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>修改信息资料</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script language="javascript" src="<%=path%>/js/business/aboutMeEdit.js"></script>
</head>
<body>
	<form id="form0">
	<input value="${user.id}" id="userId" name="user.id" type="hidden">
	<input value="${user.userType}" name="user.userType" type="hidden">
		<table class="grid_layout" cellspacing="1" cellpadding="0" border="0">
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<col style="width:15%;"></col>
		<col style="width:35%;"></col>
		<tr>
			<td class="td_left">用户名：</td>
			<td class="td_right">
				<input value="${user.loginName}" name="user.loginName"/>
				<span class="errorMsg"></span>
			</td>
			<td rowspan="7" class="td_left">头像：</td>
			<td rowspan="7" class="td_right" align="center">
				<img id="userImg" src="<c:if test="${empty user.photo.relativePath}"><%=path%>/images/no-head.jpg</c:if>
				<c:if test="${! empty user.photo.relativePath}">${images_server}${user.photo.relativePath}</c:if>" 
				 style="width: 200px;height: 150px;border:1px solid #ccc; padding: 1px;" onerror="$(this).attr('src','<%=path%>/images/no-head.jpg');"  />	
				<span style="display: block; width: 160px; height: 30px; padding-top: 5px;">
					<a href="javascript:void(0);" id="_upload_button">上传照片</a>
				</span>
			</td>
			<td>
				<input type="hidden" id="photo_id" name="user.photo.id" value="${user.photo.id}" />
			</td>
		</tr>
		<tr>
			<td class="td_left">密码：</td>
			<td class="td_right">
				<input value="${user.loginPwd}" name="user.loginPwd" type="password">
			</td>
		</tr>
		<tr>
			<td class="td_left">真实姓名：</td>
			<td class="td_right">
				<input value="${user.realName}" name="user.realName">
			</td>
		</tr>
		<tr>
			<td class="td_left">电       话：</td>
			<td class="td_right">
				<input value="${user.tel}" name="user.tel">
			</td>
		</tr>
		<tr>
			<td class="td_left">邮      箱：</td>
			<td class="td_right">
				<input value="${user.email}" name="user.email">
			</td>
		</tr>
		<!-- <tr>
			<td class="td_left" >附件列表：</td>
            <td class="td_right">
            	<div id="test"></div>
            </td>
		</tr> -->
		</table>
	</form>
</body>
</html>