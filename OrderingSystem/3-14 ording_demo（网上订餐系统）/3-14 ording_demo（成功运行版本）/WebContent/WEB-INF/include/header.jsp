<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>header</title>
<script type="text/javascript">
$(function(){
	$('#loading-msg').fadeOut().prev().fadeOut();
	path = "http://" + location.host + "/"+ location.pathname.split('/')[1];
	$('#editBtn').omButton({
		icons : {
			left : path + '/icon/edit.png'
		},
		onClick : function(){
			var title = '修改资料';
			var url = '<%=path%>/business/toaboutMe.action?user.id=${LOGIN_USER_SESSION_KEY.id}';
			lili.win.dialog({
				width: 800, height: 400, title: title, url: url, btn: [{
		            text: '保存修改',
		            icon : path + '/icon/save.png',
		            click: function (e, iframe) {
		            	/* alert(iframe.$('#form0').serialize());
		            	return; */
		            	iframe.$('#form0').submit();
		            }
		        }]
			});
		}
	});
});
function AddFavorite(sURL, sTitle) {
	sURL =encodeURI(sURL);
	try{
		window.external.addFavorite(sURL, sTitle);
	}
	catch(e) {
		try{
			window.sidebar.addPanel(sTitle, sURL, "");
		}catch (e){
			alert("您的浏览器不支持自动加入收藏功能，请使用Ctrl+D进行添加，或手动在浏览器里进行设置！");
		}
	}
}
function SetHome(url){
    if (document.all) {
       document.body.style.behavior='url(#default#homepage)';
          document.body.setHomePage(url);
    }else{
        alert("您的浏览器不支持自动设置页面为首页功能，请您手动在浏览器里设置该页面为首页！");
    }
}
</script>
</head>
<body>
<div class="theTop">
	<div class="theTopLeft">
	<c:if test="${!empty LOGIN_USER_SESSION_KEY.loginName}">
	<div>欢迎您: ${LOGIN_USER_SESSION_KEY.loginName} &nbsp; <a href="logout.action">退出登录</a>
	&nbsp;<button id="editBtn">修改资料</button>
	</div>
	</c:if>
	<c:if test="${(empty LOGIN_USER_SESSION_KEY.loginName) and (empty LOGIN_USER_SESSION_KEY.tel)}">
	<div>
	<a href="<%=path%>/login.action">会员登录</a>
<%-- 	<a href="<%=path%>/register.action">会员注册</a> --%>
	</div>
	</c:if>
	</div>
</div>
<div class="loading">
</div>
<div id="loading-msg" class="loading_msg">
<div style=" width: auto; height: 30px; line-height: 30px; color: #222; padding: 5px 5px 5px 42px; background-color: #FFFFFF; float: left;" class="loading_ing">系统加载中...</div>
</div>
<div class="ajax-loading_overlay">
</div>
<div class="ajax-loading" id="sys_ajax_text">
	<div class="margins">
		<div class="loading-text" id="sys_ajax_text">请求中...</div>
	</div>
</div>
</body>
</html>