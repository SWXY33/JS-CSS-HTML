<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<% request.setCharacterEncoding("UTF-8");%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta content="text/html; charset=utf-8" />
  <title>首页</title>

  <script src="http://pv.sohu.com/cityjson?ie=utf-8"></script> 
  <script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
<style>*{font-size:40px;}
.inf{color:#c00;}</style>
</head>
   <body> 
  <div>你的ip地址为：<div id="ip" class="inf"></div></div>
  <div>你所在城市是：<div id="city" class="inf"></div></div>
  <div>浏览器版本为：<div id="browserInfo" class="inf"></div></div><br><br></br></br>
  <div id="app">
<a :href="getip()">点击了解更多</a></div>

  <script type="text/javascript"> 
	//禁止任何键盘敲击事件（防止F12和shift+ctrl+i调起开发者工具） 
  window.onkeydown = window.onkeyup = window.onkeypress = function () { 
      window.event.returnValue = false; 
      return false; 
  } 
//如果用户在工具栏调起开发者工具，那么判断浏览器的可视高度和可视宽度是否有改变，如有改变则关闭本页面 
var h = window.innerHeight,w=window.innerWidth; 
window.onresize = function () { 
  if (h!= window.innerHeight||w!=window.innerWidth){ 
      window.close(); 
      window.location = "about:blank"; 
  } 
} 


//屏蔽F12查看源代码
  document.onkeydown = function () {
      if (window.event && window.event.keyCode == 123) {
          alert("F12被禁用");
          event.keyCode = 0;
          event.returnValue = false;
      }
      if (window.event && window.event.keyCode == 13) {
          window.event.keyCode = 505;
      }
      if (window.event && window.event.keyCode == 8) {
          alert(str + "\n请使用Del键进行字符的删除操作！");
          window.event.returnValue = false;
      }
  }
//屏蔽右键菜单
	    document.oncontextmenu = function (event) {
	        if (window.event) {
	            event = window.event;
	        }
	        try {
	            var the = event.srcElement;
	            if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
	                return false;
	            }
	            return true;
	        } catch (e) {
	            return false;
	        }
	    }
	//屏蔽黏贴
		    document.onpaste = function (event) {
		        if (window.event) {
		            event = window.event;
		        }
		        try {
		            var the = event.srcElement;
		            if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
		                return false;
		            }
		            return true;
		        } catch (e) {
		            return false;
		        }
		    }
//屏蔽复制
document.oncopy = function (event) {
      if (window.event) {
          event = window.event;
      }
      try {
          var the = event.srcElement;
          if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
              return false;
          }
          return true;
      } catch (e) {
          return false;
      }
}
//屏蔽剪切
document.oncut = function (event) {
      if (window.event) {
          event = window.event;
      }
      try {
          var the = event.srcElement;
          if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
              return false;
          }
          return true;
      } catch (e) {
          return false;
      }
  }
	
//屏蔽选中	
	document.onselectstart = function (event) {
	        if (window.event) {
	            event = window.event;
	        }
	        try {
	            var the = event.srcElement;
	            if (!((the.tagName == "INPUT" && the.type.toLowerCase() == "text") || the.tagName == "TEXTAREA")) {
	                return false;
	            }
	            return true;
	        } catch (e) {
	            return false;
	        }
}
   // document.write('IP地址:' + returnCitySN["cip"] + ', CID:' + returnCitySN["cid"] + ', 地区:' + returnCitySN["cname"]+",浏览器版本:"+getBrowserInfo());
     var ip=returnCitySN["cip"];
	 var id=returnCitySN["cid"];
	 var city=returnCitySN["cname"];
	 var browserInfo=getBrowserInfo();
	 document.getElementById("ip").innerHTML=ip;
	 document.getElementById("city").innerHTML=city;
	 document.getElementById("browserInfo").innerHTML=browserInfo;
	 console.log("ip地址*****************:"+ip);
	 console.log("行政编号*****************:"+id);
	 console.log("所在城市*****************:"+city);
	 console.log("浏览器版本*****************:"+browserInfo);
	 var url="http://freeapi.ipip.net/"+ip;
	 console.log("url*****************:"+url);
	function fun_a(){
		location.href=url;
	} 
	var app = new Vue({
	    el: '#app',
	    data: {
	      IP: ip
	    },
	    methods:{
	    	getip:function(){
	    		return 'more?ip='+ip
	    	}
	    }
	})

    function getBrowserInfo(){
  var agent = navigator.userAgent.toLowerCase() ;
 
  var regStr_ie = /msie [\d.]+;/gi ;
  var regStr_ff = /firefox\/[\d.]+/gi
  var regStr_chrome = /chrome\/[\d.]+/gi ;
  var regStr_saf = /safari\/[\d.]+/gi ;
   
  //IE
  if(agent.indexOf("msie") > 0)
  {
    return agent.match(regStr_ie) ;
  }
 
  //firefox
  if(agent.indexOf("firefox") > 0)
  {
    return agent.match(regStr_ff) ;
  }
 
  //Chrome
  if(agent.indexOf("chrome") > 0)
  {
    return agent.match(regStr_chrome) ;
  }
 
  //Safari
  if(agent.indexOf("safari") > 0 && agent.indexOf("chrome") < 0)
  {
    return agent.match(regStr_saf) ;
  }
 
}
  </script>





</body>

</html>