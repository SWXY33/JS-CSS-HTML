<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%String path = request.getContextPath();%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>search</title>
<style type="text/css">
.searchInput{
	border:0;
	width:98%;
	margin-top:9px;
	outline:none;
}
</style>
<script type="text/javascript">
var path = "http://" + location.host + "/"+ location.pathname.split('/')[1];
function searchInputOnfocus(a){
	if(a.value=="请输入关键词")a.value="";
}
function searchInputOnblur(a){
	if(a.value=="")a.value="请输入关键词";
}
function qkeypress(){
	//var q=$("input[name=q]");
}
</script>
</head>
<body>
<div class="pageTitle">
    <!-- LOGO_begin -->
    <div class="webLogo">
        <a href="<%=path%>/home.action"><img src="<%=path%>/images/logo3.png" /></a>
    </div>
    <!-- LOGO_end -->
    <!-- 搜索_begin -->
    <div class="searchCon">
        <form action="" id="searchForm">
        <div class="ui-widget">
            <div class="searchBg">
            	<input name="q" class="searchInput" value="请输入关键词" type="text" onfocus="searchInputOnfocus(this);" onkeypress="qkeypress()" onblur="searchInputOnblur(this);" maxlength="50" autocomplete="off"/>
            </div>
		</div>
		<input type="submit" class="searchMenu" value="" />
        </form>
    </div>
    <!-- 搜索_end -->
</div>
<div class="clear"></div>
</body>
</html>