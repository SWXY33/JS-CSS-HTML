<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/home.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/login.css"/>
<style type="text/css">
.fl {
    float: left;
}
.fl .icon {
    margin: 5px 0 0 5px;
    background-image: url("<%=path%>/icon/warning.png");
    display: inline-block;
}
.i-dialog-shook-new {
    width: 36px;
    height: 36px;
}
.desc {
    margin-left: 54px;
    font-size: 16px;
    font-weight: 700;
    padding-top: 4px;
}
</style>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
</head>
<body>
<div class="container" style="width: 100%;overflow-y: hidden;overflow-x: hidden;">
	<div class="loginForm" style="margin: 0 0;">
	<div>
		<div class="fl"><i class="icon i-dialog-shook-new"></i></div>
		<div class="desc">为了保证送餐员能及时联系到您，请验证您的送餐手机号</div>
	</div>
	<div class="login-div-phone">
		<label for="loginPhone">手机</label>
		<input type="text" id="loginPhone" class="login-infos" placeholder="请输入手机" value="${tel}"/>
		<a href="javascript:;" class="login-send1" onclick="sends.send();">获取动态码</a>
	</div>
	<div class="login-div-ranks">
		<label for="loginRanks">验证码</label><input type="text" id="loginRanks" class="login-infos" placeholder="请输入验证码"  />
	</div>
	<div class="login-div-conform">
		<a href="javascript:;" class="login-conform" onclick="sends.conform();">提交</a>
	</div>
	<p style="color: #B5B5B5;">
	提示：
	未注册莉莉订餐中心账号的手机号，登录时将自动注册莉莉订餐中心账号，且代表您已同意
	<a href="#" target="_blank" style="color: #00b38a;">《莉莉订餐中心用户协议》</a>
    </p>
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
						var opener = lili.getDialog().opener;//弹出对话框的dom对象
						var jsonArray = opener.$('#shopCartInfDiv').text();//菜单json
						var divEle = opener.$('#chooseAddress').next();
						var name = divEle.find('span:eq(0)').text();//收货人
						var sex = divEle.find('span:eq(1)').text();//收货性别
						var tel = divEle.find('span:eq(2)').text();//收货电话
						var address = divEle.find('div:eq(1)').text();//收货地址
						var leaveMessage = opener.$('#leaveMessageInput').val();//给商家的留言
						var orderUrl = path + '/customer/order!genOrder.action';
						lili.ajax.sys(orderUrl,{
							jsonArray : jsonArray,
							name : name,
							sex : sex,
							tel : tel,
							address : address,
							leaveMessage : leaveMessage
						},function(data){
							if(data.success == true){
								opener.window.location.href = path + '/customer/order!toCheckOrder.action?orderId='
									+ data.info;
								lili.getDialog().get.omDialog("close");
							}
						});
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
</div>
</body>
</html>