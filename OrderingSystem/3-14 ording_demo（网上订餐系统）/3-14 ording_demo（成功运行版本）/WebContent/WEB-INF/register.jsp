<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>注册</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/register.css"/>
<link rel="stylesheet" type="text/css" href="om-ui/css/apusic/om-apusic.css"/>
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
	<jsp:include page="include/header.jsp" />
	<jsp:include page="include/search.jsp" />
	<jsp:include page="include/navi.jsp" />
	<div class="w" id="registerDiv">
		<div class="mt">
		<h2>会员注册</h2>
		<b></b>
	</div>
	<div class="mc">
	<form id="registerVip" method="post" action="<%=path%>register/clientrRegister.action">
	<div class="form">
	<div class="item">
		<span class="label"><b class="ftx04">*</b>用户名：</span>
				<div class="fl">
				<input type="text" id="username" name="username" class="text" tabindex="1" sta="0">
				<label id="username_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="username_error" class="null"></div>
				</div>
				</div>
	<div class="item">
		<span class="label"><b class="ftx04">*</b>密码：</span>
				<div class="fl">
				<input type="text" id="password" name="password" class="text" tabindex="1" sta="0">
				<label id="password_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="password_error" class="null"></div>
				</div>
				</div>
	<div class="item">
		<span class="label"><b class="ftx04">*</b>手机号：</span>
				<div class="fl">
				<input type="text" id="telephone" name="telephone" class="text" tabindex="1" sta="0">
				<label id="telephone_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="telephone_error" class="null"></div>
				</div>
				</div>
	<div class="item">
		<span class="label"><b class="ftx04"></b>邮箱:</span>
				<div class="fl">
				<input type="text" id="email" name="email" class="text" tabindex="1" sta="0">
				<label id="email_succeed" class="blank"></label>
				<span class="clr"></span>
				<div id="email_error" class="null"></div>
				</div>
				</div>
				<div class="item">
				<span class="label">&nbsp;</span>
				<input type="submit" class="btn-img openSotre-btn-submit" id="registsubmit" value="注册会员" tabindex="8">
			</div>
		<!-- <div class="text-type"><div class="label-type">密码：</div><input class="login-infos" name="user.loginPwd" type="text" placeholder="密码"/></div>
		<div class="text-type"><div class="label-type">手机号：</div><input class="login-infos" name="user.tel" type="text" placeholder="手机号" /></div>
		<div class="text-type"><div class="label-type">邮箱：</div><input class="login-infos" name="user.email" type="text" placeholder="邮箱"/></div>
		<div class="text-type"><input class="btn-img registerBtn" id="registsubmit" type="submit" value="注册会员"/></div> -->
	</div>
	</form>
	</div>
	</div>
	<script>
		
	</script>
	<jsp:include page="include/footer.jsp" />
</div>
</body>
</html>

</html>