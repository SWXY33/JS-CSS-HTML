<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" /> 
<title>首页</title>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
<style>*{text-align:center;}

ul{float:left;width:1500px;}
li{float:left;widht:100px;}
.aa{width:300px;height:50px;float:left;}
hr{margin-top:-12px;}
</style>
</head>

<body>
<form>
<div>用户信息</div>
<div>
<ul><li><div class="aa" >用户ID</div><div class="aa" >用户名</div><div class="aa" >登录密码</div><div class="aa" >职务</div><div class="aa" >操作</div></li></ul></div>
<div id="app">
<ol id="showlater" class="list" :style=`height:${listheight}`>
      <li v-for="item in arr" :key="item.id" class="divicedata">
      <hr/>
       <div class="aa" id="	AA1" style="color:#0080ff">{{item.id}}</div>
       <div class="aa" style="color:#0080ff">{{item.loginname}}</div>
       <div class="aa" style="color:#0080ff">{{item.password}}</div>
       <div class="aa" style="color:#0080ff">{{item.job}}</div>
       <div class="aa" ><a :href="deleteu(item.id)" style="color:#c00">删除</a>|<a href="updateUser" style="color:#c00">修改</a></div>
</li>
</ol>
</div>
<script type="text/javascript">
var allUser=${requestScope.Array};
var app = new Vue({
    el: '#app',
    data: {
    	arr:allUser
    },
    methods: {
    	deleteu:function(userid){
    		return 'deleteUser?id='+userid
    		
    	}
    }
    })
 
</script>
</form>
</body>
</html>