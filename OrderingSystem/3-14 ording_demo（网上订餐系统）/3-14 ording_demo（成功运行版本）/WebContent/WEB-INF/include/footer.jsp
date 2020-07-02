<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>footer</title>
<script type="text/javascript">
$(function(){
	$('#ordingTip').click(function(event){
		event.preventDefault();
		messagePush.sendAll('test');
	});
});
</script>
</head>
<body>
<!-- <a href="#" id="ordingTip">tip</a> -->
<div id="ordingTipFlag" class="flag1"></div>
<div class="clear-10"></div>
<div class="footBg">
    <div class="footBglm">
    <a target="_blank" href="">关于我们</a> - 
    <a target="_blank" href="">联系我们</a> - 
    <a target="_blank" href="">诚聘英才</a> -
    <a target="_blank" href="">友情链接</a> - 
    <a onclick="SetHome(window.location)"href="javascript:void(0)">设为首页</a> - 
    <a onclick="AddFavorite(window.location,document.title)"href="javascript:void(0)">加入收藏</a>
    </div>
    <div class="clear-10"></div>
    电话：15607732013<br/>
    <a href="http://www.guet.edu.cn" target="_blank">桂林电子科技大学</a>
    Powered by JW.XIN Copyright &copy; 2012-2016 
    <a href="http://www.guet.edu.cn" target="_blank">http://www.guet.edu.cn</a>, All Rights Reserved
</div>
</body>
</html>