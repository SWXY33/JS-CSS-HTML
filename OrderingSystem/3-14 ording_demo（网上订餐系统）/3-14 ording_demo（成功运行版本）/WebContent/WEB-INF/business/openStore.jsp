<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>商家入驻</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/openStore.css"/>
<style type="text/css">
textarea {
	width:400px;
	border:1px solid #bbb;
    height: 42px;
    line-height: 22px;
    padding: 4px 3px;
    overflow: auto;
    resize: none;
}
</style>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script language="javascript" src="<%=path%>/js/business/openStore.js"></script>
<script type="text/javascript">
</script>
</head>
<body>
<div class="container">
	<jsp:include page="../include/header.jsp" />
	<jsp:include page="../include/search.jsp" />
	<jsp:include page="../include/navi.jsp" />
	<div class="w" id="openStoreDiv">
	<div class="mt">
		<h2>新建店铺</h2>
		<b></b>
	</div>
	<div class="mc">
		<!-- <ul class="tab">
			<li class="curr">个人用户</li>
			<li class="line"><a href="#">企业用户</a></li>
			<li><a href="#">校园用户</a></li>
		</ul> -->
		<form id="formOpenStore" method="post" action="<%=path%>/business/openStore!openStore.action">
		<div class="form">
			<div class="item">
				<span class="label"><b class="ftx04">*</b>店铺名称：</span>
				<div class="fl">
				<input type="text" id="storename" name="storename" class="text" tabindex="1" sta="0">
				<label id="storename_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="storename_error" class="null"></div>
				</div>
			</div>
			<div class="item" style="height: 78px">
				<span class="label"><b class="ftx04">*</b>店铺介绍：</span>
				<div class="fl">
				<textarea id="storeDescribe" name="storeDescribe" tabindex="2" style="font-size:14px;font-family: 微软雅黑, 宋体">
				</textarea>
				<label id="storeDescribe_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="storeDescribe_error" class="null"></div>
				</div>
			</div>
			<div class="item item_area">
				<span class="label"><b class="ftx04">*</b>店铺区域：</span>
				<div class="fl">
				<input id="province" name="province">
				<input id="city" name="city">
				<input id="county" name="county">
				<!-- <button id="refreshCombox">刷新下拉框</button> -->
				<span class="clr"></span>
				</div>
			</div>
			<div class="item">
				<span class="label"><b class="ftx04">*</b>详细地址：</span>
				<div class="fl">
				<input type="text" id="address" name="address" class="text" tabindex="1" sta="0">
				<label id="address_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="address_error" class="null"></div>
				</div>
			</div>
			<div class="item" style="height: 230px;">
				<span class="label"><b class="ftx04">*</b>门店logo：</span>
				<div class="fl">
				<img id="storeImg" src="<c:if test="${empty user.photo.relativePath}"><%=path%>/images/no-head.jpg</c:if>
				<c:if test="${! empty user.photo.relativePath}">${images_server}${user.photo.relativePath}</c:if>" 
				 style="width: 200px;height: 150px;border:1px solid #ccc; padding: 1px;" onerror="$(this).attr('src','<%=path%>/images/no-head.jpg');"  />	
				<span style="display: block; width: 160px; height: 30px; padding-top: 5px;">
					<a href="javascript:void(0);" id="openStore_upload_button">上传照片</a>
				</span>
				<input type="hidden" id="store_photo_id" name="storeImgName" class="text"/>
				<label id="storeImgName_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="storeImgName_error" class="null"></div>
				</div>
			</div>
			<div class="item">
				<span class="label">&nbsp;</span>
				<input type="submit" class="btn-img openSotre-btn-submit" id="registsubmit" value="提交" tabindex="8">
			</div>
		</div>
		</form>
	</div>
	</div>
	<jsp:include page="../include/footer.jsp" />
</div>
</body>
</html>