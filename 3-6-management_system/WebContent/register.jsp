<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>register page</title>
</head>
<body>
    <form action="register" method="post">
        <h5>用户登录</h5>
        <p>
            <label>姓名 </label> <input type="text" id="username" name="username"
                tabindex="1">
        </p>

        <p>
            <label>密码 </label> <input type="text" id="password" name="password"
                tabindex="2">
        </p>

        <p>
            <label>电话</label> <input type="text" id="tel" name="tel"
                tabindex="3">
        </p>
        <p id="buttons">
            <input id="submit" type="submit" tabindex="4" value="register">
            <input id="reset" type="reset" tabindex="5" value="reset">
        </p>
    </form>
</body>
</html>