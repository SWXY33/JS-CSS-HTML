<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<% request.setCharacterEncoding("UTF-8");%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" /> 
<title>登录</title>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
</head>
<body>
<div id="app">
<h1>让我我猜………………………………………………………………………………………………………………</h1>
<h2>你目前所在地点为：{{city}}</h2>
</div>
<div id="app1">
<div v-for="item in ip" :key="item.cid" >
<a :href="getip(item.cip)">点击了解更多</a></div>
</div>
<script>${requestScope.inf}
var s=returnCitySN;
var jsonObj=JSON.stringify(s);
console.log("jsonObj="+jsonObj);
var obj=JSON.parse(jsonObj);
//form1.jsParam.value=obj;
//var location=obj.cname;
console.log("IP="+obj.cip);
console.log("行政编码为："+obj.cid);
console.log("所在城市是："+obj.cname);
var app = new Vue({
    el: '#app',
    data: {
      city: obj.cname
    }
})
var app = new Vue({
    el: '#app1',
    data: {
      ip:[obj]
    },
    methods:{
    	getip:function(a){
    		return 'more?ip='+a
    	}
    }
})

</script>
</body>
</html>