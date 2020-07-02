<%@ page contentType="text/html; charset=utf-8" language="java"	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>testVue</title>
<link rel="stylesheet" type="text/css" href="css/Main.css" />
<link rel="stylesheet" type="text/css" href="css/Switch.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue.js"></script>
<script src="js/axios.min.js"></script>
<style>
  *{margin: 0;padding: 0;}
  #page-break{margin-top: 20px;margin-left: 20px;}
  #page-break li{list-style: none;}
  #page-break a{border: 1px solid #ddd; text-decoration: none;float: left;padding: 6px 12px;color: #337ab7;cursor: pointer}
  #page-break a:hover{background-color: #eee;}
  #page-break a .banclick{cursor: not-allowed;}
  #page-break .active a{color: #fff;cursor: default;background-color: #337ab7;border-color: #337ab7;}
  #page-break i{font-style: normal;color: #d44950;margin: 0px 4px;font-size: 12px;}
  #page-break .jumpbox .jumppage {border: 1px solid #ddd; margin-left: 40px; height: 33px; width: 40px; float: left;}
  #page-break .jumpbox .jumpbtn {cursor: pointer; margin-left: 10px;}
  #page-break .jumpbox .jumpbtn:active {color: #337ab7;}
</style>	
<style scoped>
  .page-helper {
    font-weight: 500;
    height: 40px;
    text-align: center;
    color: #888;
    margin: 10px auto;
  }
  .page-list {
    font-size: 0;
    height: 50px;
    line-height: 50px;
  }
  .page-list span {
    font-size: 14px;
    margin-right: 5px;
    user-select: none;
  }
  .page-list .page-item {
    border: 1px solid #aaa;
    padding: 5px 8px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
  }
  .page-ellipsis {
    padding: 0 8px;
  }
  .page-jump-to input {
    width: 45px;
	
    height: 26px;
    font-size: 13px;
    border: 1px solid #aaa;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    text-align: center;
  }
  .page-list .jump-go-btn {
    font-size: 12px;
  }
  .page-select{
    border: 1px solid #aaa;
    padding: 5px 8px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
    margin-left: 5px;
  }
  .page-list .page-item .disabled{
    pointer-events: none;
    background: #ddd;
  }
  .page-list .page-current {
    cursor: default;
    color: #fff;
    background: #337ab7;
    border-color: #337ab7;
  }
</style>
<style>
	.class1{
  background: #444;
  color: #bb9;
}

</style>
<style>
/* 可以设置不同的进入和离开动画 */
/* 设置持续时间和动画函数 */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active, 2.1.8 版本以下 */ {
    opacity: 0
}
</style>
</head>


<body>


 <div id="app2">
 Vue - 监听文本框数据
     <input type="text" v-model="firstname" @keyup="getFullname"/> +
    <input type="text" v-model="lastname" @keyup="getFullname"/> =
    <input type="text" v-model="fullname"/>
  </div>

  

  <script>
    // 创建 Vue 实例，得到 ViewModel
    //我们在input标签里绑定keyup事件
        var vm = new Vue({
      el: '#app2',
      data: {
          firstname: '',
          lastname: '',
          fullname: ''
      },
      methods: {
          getFullname() {
              this.fullname = this.firstname + '-' + this.lastname
          }
      }
    });
  </script>

  <div>
    <div class="page-helper" v-if="showPageHelper">

      <div class="page-list">
        <span>共{{ totalPage }}页 / {{ totalCount }}条</span>
        <span class="page-item" @click="jumpPage(1)">首页</span>
        <span class="page-item" :class="{'disabled': currentPage === 1}"  @click="prevPage">上一页</span>
        <span class="page-ellipsis" v-if="showPrevMore" @click="showPrevPage">...</span>
        <span class="page-item" v-for="num in groupList" :class="{'page-current':currentPage===num}" :key="num"
              @click="jumpPage(num)">{{num}}</span>
        <span class="page-ellipsis" v-if="showNextMore" @click="showNextPage">...</span>
        <span class="page-item" :class="{'disabled': currentPage === totalPage}" @click="nextPage">下一页</span>
        <span class="page-item" @click="jumpPage(totalPage)">末页</span>
        <select class="page-select" @change="jumpPage(currentPage)" v-model="currentSize">
          <option v-for="size in pageSizeArray" :key="size" :value="size">{{ size }}条/页</option>
        </select>
        <span class="ml20">跳至</span>
        <span class="page-jump-to"><input type="type" v-model="jumpPageNumber"></span>
        <span>页</span>
        <span class="page-item jump-go-btn" @click="goPage(jumpPageNumber)">GO</span>
      </div>
    </div>
  </div>


<script>


export default {
  name: 'pageHelper',
  data () {
    return {
      currentPage: this.pageNumber,
      currentSize: this.pageSizeArray[0],
      jumpPageNumber: 1,
      showPrevMore: false,
      showNextMore: false
    }
  },
  props: {
    pageNumber: {   //当前页面
      type: Number,
      default: 1
    },
    pageSizeArray: {   //每页显示数量
      type: Array,
      default () {
        return [10,20,30,50]
      }
    },
    totalCount: {   //总条数
      type: Number,
      default: 1000
    },
    pageGroup: {   //连续页码个数
      type: Number,
      default: 5
    }
  },
  computed: {
    showPageHelper () {
      return this.totalCount > 0
    },
    totalPage () {   //总页数
      return Math.ceil(this.totalCount / this.currentSize);
    },
    groupList () {  //获取分页码
      const groupArray = []
      const totalPage = this.totalPage
      const pageGroup = this.pageGroup
      const _offset = (pageGroup - 1) / 2
      let current = this.currentPage
      const offset = {
        start: current - _offset,
        end: current + _offset
      }
      if (offset.start < 1) {
        offset.end = offset.end + (1 - offset.start)
        offset.start = 1
      }
      if (offset.end > totalPage) {
        offset.start = offset.start - (offset.end - totalPage)
        offset.end = totalPage
      }
      if (offset.start < 1) offset.start = 1
      this.showPrevMore = (offset.start > 1)
      this.showNextMore = (offset.end < totalPage)
      for (let i = offset.start; i <= offset.end; i++) {
        groupArray.push(i)
      }
      return groupArray
    }
  },
  methods: {
    prevPage () {
      if (this.currentPage > 1) {
        this.jumpPage(this.currentPage - 1)
      }
    },
    nextPage () {
      if (this.currentPage < this.totalPage) {
        this.jumpPage(this.currentPage + 1)
      }
    },
    showPrevPage() {
      this.currentPage = this.currentPage - this.pageGroup > 0 ? this.currentPage - this.pageGroup : 1
    },
    showNextPage() {
      this.currentPage = this.currentPage + this.pageGroup < this.totalPage ? this.currentPage + this.pageGroup : this.totalPage
    },
    goPage (jumpPageNumber) {
      if(Number(jumpPageNumber) <= 0){
        jumpPageNumber = 1
      }if(Number(jumpPageNumber) >= this.totalPage){
        jumpPageNumber = this.totalPage
      }
      this.jumpPage(Number(jumpPageNumber))
    },
    jumpPage (pageNumber) {
      if (this.currentPage !== pageNumber) {  //点击的页码不是当前页码
        this.currentPage = pageNumber
      //父组件通过change方法来接受当前的页码
      this.$emit('jumpPage', {currentPage: this.currentPage, currentSize: this.currentSize})
      }
    }
  },
  watch: {
    currentSize (newValue, oldValue) {
      if(newValue !== oldValue){
        if(this.currentPage >= this.totalPage){ //当前页面大于总页面数
          this.currentPage = this.totalPage
        }
        this.$emit('jumpPage', {currentPage: this.currentPage, currentSize: this.currentSize})
      }
    }
  }
}
</script>
</br></br>
 <div id='cycle'>
    <!--v-for循环普通数组-->
    <p v-for="(item,i) in list">--索引值--{{i}}   --每一项--{{item}}</p>
    <br/>
    <!--v-for循环对象数组-->
    <p v-for="(user,i) in listObj">--id--{{user.id}}   --姓名--{{user.name}}</p>
    <br/>
    <!--注意，在遍历对象的键值对的时候，除了有 val 和 key,在第三个位置还有一个索引-->
    <p v-for="(val,key) in user">--键是--{{key}}  --值是--{{val}}</p>
    <br/>
    <!-- in 后面我们放过数组、对象数组、对象，还可以放数字-->
    <!-- 注意：如果使用v-for迭代数字的话，前面 count 的值从 1 开始-->
    <p v-for="count in 10">这是第{{count}}次循环</p>
  </div>
</body>

<script>

  var vm = new Vue({
    el:'#cycle',
    data:{
      list:[1,2,3,4,5,6],
      listObj:[
        {id:1, name:'zs1'},
        {id:2, name:'zs2'},
        {id:3, name:'zs3'},
        {id:4, name:'zs4'},
        {id:5, name:'zs5'},
        {id:6, name:'zs6'},
      ],
      user:{
        id:1,
        name:'托尼.贾',
        gender:'男'
      }
    }
  });alert("设备ID/型号不存在！");
</script>



<div id="app">
  <label for="r1">1.修改颜色</label><input type="checkbox" v-model="use" id="r1" />
  <br/><br/>
  <div v-bind:class="{'class1': use}">
    v-bind:class 指令(判断 class1 的值，如果为 true 使用 class1 类的样式，否则不使用该类)
  </div>
</div>
    
<script>
new Vue({
    el: '#app',
  data:{
      use: false
  }
});
</script>
<br/><div id="test" style="color:#dbf">2.《div id="app1"》>
	{{5+5}}<br/>
	{{ ok ? 'YES' : 'NO' }}<br/>
	{{ message.split('').reverse().join('') }}<!-- 倒序输出“RUNOOB”：“BOONUR” <br/>
	split() 方法用于把一个字符串分割成字符串数组。<br/>
    reverse() 方法用于颠倒数组中元素的顺序。<br/>
    join() 方法用于把数组中的所有元素放入一个字符串。--><br/>
	《div v-bind:id="'list-' + id">Vue.js 都提供了完全的 JavaScript 表达式支持。《/div》><br/>
《/div》<br/>
	《script》<br/>
new Vue({<br/>
  el: '#app1',<br/>
  data: {<br/>
	ok: true,<br/>
    message: 'RUNOOB',<br/>
	id : 1<br/>
  }<br/>
})<br/>
《/script》<br/></div>
<div id="app1" style="color:#00F">
	{{5+5}}<br/>
	{{ ok ? 'YES' : 'NO' }}<br/>
	{{ message.split('').reverse().join('') }}<!-- 倒序输出“RUNOOB”：“BOONUR” 
	split() 方法用于把一个字符串分割成字符串数组。
    reverse() 方法用于颠倒数组中元素的顺序。
    join() 方法用于把数组中的所有元素放入一个字符串。-->
	<div v-bind:id="'list-' + id">Vue.js 都提供了完全的 JavaScript 表达式支持。</div>
</div>
	
<script>
new Vue({
  el: '#app1',
  data: {
	ok: true,
    message: 'RUNOOB',
	id : 1
  }
})
</script>


<br/><div style="color:#281">3.function f(value,index,array){<br>
	console.log("a=["+index+"]="+value+"数组对象:"+array[index])</br>
}</br>
var a=['a1','b1','c1'];<br/>
a.forEach(f);<br/></div><script>
function f(value,index,array){
	console.log("a=["+index+"]="+value+"数组对象:"+array[index])
}

var a=['a1','b1','c1'];
a.forEach(f);
</script>
按F12控制台输出信息为：<br/>	
a=[0]=a1数组对象:a1<br/>
a=[1]=b1数组对象:b1<br/>
a=[2]=c1数组对象:c1<br/>
<br/>4.参数在指令后以冒号指明;v-on:click="";v-bind:href="";<br/>v-on:submit.prevent="";v-model指令实现双向数据绑定

</br>
<div id = "databinding">
<button v-on:click = "show = !show">点我</button>
<transition name = "fade">
    <p v-show = "show" v-bind:style = "styleobj">动画实例</p>
</transition>
</div>
<script type = "text/javascript">
var vm = new Vue({
el: '#databinding',
    data: {
        show:true,
        styleobj :{
            fontSize:'30px',
            color:'red'
        }
    },
    methods : {
    }
});
</script>
</body>
</html>