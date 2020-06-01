<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MySpringMvc</title>
</head>
<body>
 
<a href="helloworld">测试【SpringMvc】效果</a>
 
</body>
</html>
<!--
当访问index.jsp时，页面上会展示一个超链接，点击超链后，url中的地址就会发生跳转，由“http://localhost:8080/MySpringMvc/index.jsp”跳转到“http://localhost:8080/MySpringMvc/helloworld”，而这个url请求就会进入HelloWorld中的hello方法，因为其与该方法上的“/helloworld”匹配。-->