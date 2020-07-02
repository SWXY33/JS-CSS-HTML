<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录</title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/login.css"/>
<link rel="stylesheet" type="text/css" href="om-ui/css/apusic/om-apusic.css"/>

<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}"></script>
<script type="text/javascript">
</script>
</head>
<body>
<div class="container">
	<jsp:include page="include/header.jsp" />
	<jsp:include page="include/search.jsp" />
	<jsp:include page="include/navi.jsp" />
	<div class="loginForm">
	<form action="login.action" method="post">
		<div class="login-div-phone"><label for="loginName">用户名</label>
		<input id="loginName" name="user.loginName" type="text" class="login-infos"/>
		</div>
		<div class="login-div-ranks"><label for="loginPwd">密码</label>
		<input id="loginPwd" name="user.loginPwd" type="password" class="login-infos"/>
		</div>
		<div class="login-div-sbt">
		<span class="rl"><input type="submit" value="登录" class="login-i"/></span>
		<span><a class="forget" href="#">忘记密码</a></span>
		</div>
	</form>
	</div>
	<script>
		var sends = {
			checked : 1,
			send : function() {
				var numbers = /^1\d{10}$/;
				var val = $('#loginPhone').val().replace(/\s+/g, ""); //获取输入手机号码
				if ($('.login-div-phone').find('span').length == 0
						&& $('.login-div-phone a').attr('class') == 'login-send1') {
					if (!numbers.test(val) || val.length == 0) {
						$('.login-div-phone').append('<span class="error">手机格式错误</span>');
						return false;
					}
				}
				if (numbers.test(val)) {
					if($('.login-div-phone a').attr('class') == 'login-send0')return false;
					var time = 30;
					$('.login-div-phone span').remove();
					function timeCountDown() {
						if (time == 0) {
							clearInterval(timer);
							$('.login-div-phone a').addClass('login-send1')
									.removeClass('login-send0').html("获取动态码");
							sends.checked = 1;
							return true;
						}
						$('.login-div-phone a').html(time + "S后再次发送");
						time--;
						return false;
						sends.checked = 0;
					}
					$('.login-div-phone a').addClass('login-send0').removeClass('login-send1');
					timeCountDown();
					var timer = setInterval(timeCountDown, 1000);
					var url = '<%=path%>/login!sendSms.action';
					lili.ajax.sys(url,{
						phone : val
					});
				}
			},
			conform : function(){
				var numbers = /^1\d{10}$/;
				var phone = $('#loginPhone').val().replace(/\s+/g, "");//获取输入手机号码
				if (!numbers.test(phone) || phone.length == 0) {
					if($('.login-div-phone').find('span').length == 0){
						$('.login-div-phone').append('<span class="error">手机格式错误</span>');
					}else{
						$('.login-div-phone span').html('手机格式错误');
					}
					return false;
				}
				$('.login-div-phone span').remove();
				var rank = $('#loginRanks').val();
				if(rank.length == 0){
					if($('.login-div-ranks').find('span').length == 0){
						$('.login-div-ranks').append('<span class="error">请输入动态码</span>');
					}else{
						$('.login-div-ranks span').html('请输入动态码');
					}
					return false;
				}
				$('.login-div-ranks span').remove();
				var url = '<%=path%>/login!loginBySms.action';
				lili.ajax.sys(url,{
					phone : phone,
					code : rank
				},function(data){
					if(data.success == true){
						window.location.href = '<%=path %>/business/openStore!preOpen.action';
					}else{
						var info = data.info;
						if($('.login-div-ranks').find('span').length == 0){
							$('.login-div-ranks').append('<span class="error">' + info + '</span>');
						}else{
							$('.login-div-ranks span').html(info);
						}
					}
				},function(){
					if($('.login-div-ranks').find('span').length == 0){
						$('.login-div-ranks').append('<span class="error">验证码错误或已过期</span>');
					}else{
						$('.login-div-ranks span').html('验证码错误或已过期');
					}
				},'json');
			}
		};
	</script>
	<jsp:include page="include/footer.jsp" />
</div>
</body>
</html>