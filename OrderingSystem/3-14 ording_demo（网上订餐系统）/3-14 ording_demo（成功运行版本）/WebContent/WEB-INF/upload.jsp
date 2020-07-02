<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>upload</title>
<script language="javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#buttonAdd").click(function(){
		var html = "<div><input name='file' type='file'/><input type='button' value='删除' onclick='del(this)'/></div>";
		$("#buttons").append(html);
	});
});

function del(obj){
	$(obj).parent().remove();
}
</script>
</head>
<body>
	<form action="upload.action" method="post" enctype="multipart/form-data">
		<input name="file" type="file"/><br/>
		<div id="buttons"></div>
		<input type="button" id="buttonAdd" value="添加" />
		<input type="submit" value="上传"/>
	</form>
</body>
</html>
