<%@ page contentType="text/html; charset=utf-8" language="java"	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>已绑定设备信息</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/QueryUserId.css"/>
<link href="css/Page.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css"/>
<script type="text/javascript" src="js/sweetalert-dev.js"></script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>


<style>
	.class1{
  background: #444;
  color: #bb9;
 .diviceInfArea:after{
	content: "";
	display: block;
	clear: both;
}
.diviceInfArea ul li:hover{background-color:#EBF3FE}
}

</style>

</head>


<body>
<div class="container">
		<jsp:include page="include/menu.jsp" />

		<div class="displayArea">
			<div class="on-offDivice">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>已绑定设备信息</b>
			</div>
			<a href="#" target="_blank"><img src="icon/refresh.png"
				width="45" height="45" /> </a><img src="icon/redline.png" width="1680"
				height="3" />
		<div class="queryDiv">
					<form name="queryByUserId" action="queryuserid" method="post">
					<div class="SearchText">
						<input name="queryuserid" type="text" class="search-text" placeholder="请输入用户ID" /></div>
					<input name="Submit" value="◎ 搜索" class="search-i" type="submit"/></form></div>
				<div class="diviceInfTitle">
					<ul>		
					        <li>设备ID</li>	
							<li>设备MAC</li>
							<li>场景ID</li>
							<li>用户ID</li>
							<li>设备类型</li>	
							<li>设备标识</li>	
							<li>绑定时间</li>	
							<li>设备型号</li>						
						</ul>
				</div>
				
				<div class="diviceInfArea"> 
	   <div id="app">
	   <ul class="list" :style=`height:${listheight}`>
      <li v-for="item in arr" :key="item.id" class="divicedata">
       <div class="aa">{{item.deviceid}}</div>
       <div class="aa" style="color:#0080ff">{{item.devicemac}}</div>
       <div class="aa" style="color:#0080ff">{{item.sceneid}}</div>
       <div class="aa">{{item.userid}}</div>
       <div class="aa">{{item.devicetype}}</div>
       <div class="aa">{{item.deviceremark}}</div>
       <div class="aa" style="font-size:14px">{{item.created}}</div>
       <div class="aa">{{item.brandMode}}</div>
     </li>
    </ul>
    
    <div class="btn">
                    共{{datanum}}条 &nbsp;&nbsp;&nbsp; 
      <button style="width: 50px" @click="handleCur('sub')"><b> &lt; </b></button>
      <button v-for="index in indexs" :key="index" :class="{ 'active': cur == index}"
        @click="btnClick(index)">{{index}}</button>
      <button style="width: 50px" @click="handleCur('add')"><b>&gt;</b></button>
     &nbsp;&nbsp;&nbsp; 共{{total}}页
    </div>
  </div>
				
    </div>

<script type="text/javascript">
var alldata =${requestScope.allData};
var switchNum =${requestScope.DataCount};
var app = new Vue({
    el: '#app',
    data: {
      list: alldata,
      datanum:switchNum,
      arr: [],   //存放当前页数据
      num: 16,   //每页数据个数，可直接修改 
      cur: 1    //当前页数
    },
    	
    beforeMount() {                   //渲染之前初始化数据为第一页
      this.getArr(this.cur)
    },

    computed: {
      listheight(){                   //根据每页数据个数计算list的高度
        return this.num*40+'px'       //这里的40是每个list下的li的高度 如果li的高度要修改的话 这里记得修改
      },
      total() {                       //计算最大页数
        if (this.list.length % this.num == 0)              //可以除尽时直接除
          return total = (this.list.length / this.num)
        else                                               //否则转整加一
          return total = parseInt(this.list.length / this.num) + 1
      },
      indexs() {                      //计算页数显示数组
        var left = 1;
        var right = this.total;       //定义左右两边的数字
        var ar = [];                  //用数组来存储这些数字
        if (this.total >= 5) {
          if (this.cur > 3 && this.cur < this.total - 2) {  //当前页数大于3且小于总页数-2时 实现点击页数往后移动
            left = this.cur - 2
            right = this.cur + 2
          } else {
            if (this.cur <= 3) {      //小于等于3页的时候不用移动
              left = 1
              right = 5
            } else {                  //大于等于总页数-2时不用移动
              left = this.total - 4
              right = this.total
            }
          }
        }
        while (left <= right) {       //把要显示的数字存进数组
          ar.push(left)
          left++
        }
        return ar                     //将数组赋给indexs
      }
    },

    methods: {
      getArr(i) {                     //实现数据的过滤  （当前页数-1）*数据个数  ~  当前页数*数据个数
        this.arr = this.list.filter((item, index) => {
          return index >= (i - 1) * this.num && index < i * this.num
        })
      },
      btnClick(data) {                //button的点击事件  点击改变当前页数 调用过滤函数
        if (data != this.cur) {
          this.cur = data
          this.getArr(this.cur)
        }
      },
      handleCur(type) {                //上一页 与下一页 按钮的点击事件
        if (type == 'sub') {           //点击上一页
          if (this.cur == 1) return    //如果当前为1 就不执行操作 直接返回
          this.cur -= 1                //否则就将当前页数减一
          this.getArr(this.cur)        //再调用过滤函数
        } else {                       //点击下一页
          if (this.cur == this.total) return  //如果当前为最大页数 就不执行操作 直接返回
          this.cur += 1                //否则就将当前页数加一
          this.getArr(this.cur)        //再调用过滤函数
        }
      }
    }
})

</script>




</div></div>
</body>
</html>