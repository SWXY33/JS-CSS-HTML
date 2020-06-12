<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" /> 
<title>确认是否删除</title>
<script src="js/jquery-3.4.1.min.js"></script>

<style>*{text-align:left;}
div{width:1900px;height:50px;float:left;}
</style>
</head>

<body>
<div><a href="deleteu(item.id)">确认删除</a></div>
<div><a href="chaxun">取消</a></div>
<script type="text/javascript">
var id=${requestScope.id};
var app = new Vue({
    el: '#app',
  
    methods: {
    	deleteu:function(userid){
    		return 'deleteUser?id='+userid
    	}
    }
    })</script>


</body>
</html>