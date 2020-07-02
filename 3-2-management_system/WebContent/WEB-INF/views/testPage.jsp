<%@ page contentType="text/html; charset=utf-8" language="java"	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta charset="utf-8">
  <title>vue分页</title>
  <link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<link href="css/Page.css" rel="stylesheet" />
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <style>
    * {
      padding: 0;
      margin: 0;
      list-style: none;
    }

    #app {
      width: 1000px;
      margin: 0 auto;
      margin-top: 100px;
      padding: 50px;
      border: 1px solid black;
    }

    .list {
      background: whitesmoke;
      width: 1000px;
      text-align: center;
    }

    .list li {
      width: 100%;
      height: 40px;
      line-height: 40px;
      border: 1px solid dimgrey;
      box-sizing: border-box;
    }

    .btn {
      width: 600px;
      height: 30px;
      text-align: center;
    }

    button {
      height: 30px;
      width: 40px;
    }

    button:hover {
      cursor: pointer;
    }

    .active {
      color: #fff;
      background-color: #337ab7;
      border-color: #337ab7;
    }
  </style>
</head>

<body>

  <div id="app">
    <ul class="list" :style=`height:${listheight}`>
      <li v-for="item in arr" :key="item.id">
       {{item.deviceType}}
       {{item.deviceId}}
       {{item.deviceMac}}
       {{item.connectionState}}
       {{item.phone}}
       null
       {{item.brandMode}}
       <a href="switchmodify?">编辑</a> |  <a href="operationlog?deviceId">操作记录</a>
     </li>
    </ul>
    <div class="btn">
      <button style="width: 50px" @click="handleCur('sub')">上一页</button>
      <button v-for="index in indexs" :key="index" :class="{ 'active': cur == index}"
        @click="btnClick(index)">{{index}}</button>
      <button style="width: 50px" @click="handleCur('add')">下一页</button>
      <button style="width: 50px">共{{total}}页</button>
    </div>
  </div>

</body>
<script type="text/javascript">
var switchArray =${requestScope.switchData};
  var app = new Vue({
    el: '#app',
    data: {
      list: switchArray,
      arr: [],  //存放当前页数据
      num: 10,   //每页数据个数，可直接修改 
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

</html>
