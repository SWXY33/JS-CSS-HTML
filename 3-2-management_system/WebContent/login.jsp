<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<% request.setCharacterEncoding("UTF-8");%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" /> 
<title>度 本 科 技 后 台 管 理 系 统</title>
<link rel="stylesheet" type="text/css" href="css/Login.css" />
<script src="js/jquery-3.4.1.min.js"></script>


</head>
<body>
<div class="container" >
  <div class="loginForm">
    <form action="login" method="post" id="LoginDiv" name="loginform">
    <div class="Logo">
        <div class="Logo"> <img src="images/1.png" width="335" height="132" /> </div>
        <div class="SystemName"><b>度 本 科 技 后 台 管 理 系 统</b></div>
        <div class="LoginInput">
          <input name="username" type="text" class="login-infos" id="username" placeholder="请输入账号"/>
        </div>
        <div class="tb"></div>
        <div class="LoginInput">
          <input name="password" type="text" class="login-infos" id="password" placeholder="请输入密码"/>
        </div> 
        <div class="tb">
        <a class="forget" href="#" onclick="">忘记密码</a></div>
        <div class="LoginInput">
           <input type="submit" value="登    录" class="login-i"/> 
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>