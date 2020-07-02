<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage=""%>
<% 
String a=(String)request.getAttribute("switchpercentage");
String b=(String)request.getAttribute("curtainspercentage");
String c=(String)request.getAttribute("socketpercentage");
String d=(String)request.getAttribute("fresh_air_systemppercentage");
String e=(String)request.getAttribute("otherpercentage");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left</title>
<link rel="stylesheet" type="text/css" href="css/center.css" />
<script src="js/prefixfree.min.js"></script>
<script src="js/index.js"></script>
<script src='js/jquery1.js'></script>
<title>Insert title here</title>

<script>  
            //绘制饼图  
            function drawCircle(canvasId, data_arr, color_arr, text_arr)  
            {  
                var c = document.getElementById(canvasId);  
                var ctx = c.getContext("2d");  
  
                var radius = c.height / 2 - 20; //半径  
                var ox = radius + 20, oy = radius + 20; //圆心  
  
                var width = 30, height = 10; //图例宽和高  
                var posX = ox * 2 + 20, posY = 30;   //  
                var textX = posX + width + 5, textY = posY + 10;  
  
                var startAngle = 0; //起始弧度  
                var endAngle = 0;   //结束弧度  
                for (var i = 0; i < data_arr.length; i++)  
                {  
                    //绘制饼图  
                    endAngle = endAngle + data_arr[i] * Math.PI * 2; //结束弧度  
                    ctx.fillStyle = color_arr[i];  
                    ctx.beginPath();  
                    ctx.moveTo(ox, oy); //移动到到圆心  
                    ctx.arc(ox, oy, radius, startAngle, endAngle, false);  
                    ctx.closePath();  
                    ctx.fill();  
                    startAngle = endAngle; //设置起始弧度  
  
                      
                     
                }  
                for (var i = 0; i < data_arr.length; i++)  
                {
              //绘制比例图及文字
                ctx.fillStyle = color_arr[i];  
                ctx.fillRect(posX, posY + 30 * i, width, height);  
                ctx.moveTo(posX, posY + 30 * i);  
                ctx.font = 'bold 15px 微软雅黑';    //斜体 30像素 微软雅黑字体  
                ctx.fillStyle = "#000000"; //"#000000";  
                var a=[( 100 * data_arr[i]).toFixed(1)];//toFixed()方法【括号中数字是多少就是保留几位小数】
                var percent = text_arr[i] + "：" ;  
                ctx.fillText(percent+a+"%", textX, textY + 30 * i); 
            }  
            }
           
  
            function init() {  
                //绘制饼图  
                //比例数据和颜色  
                var switchpercentage = "<%=a %>";
                var curtainspercentage = "<%=b %>";
                var socketpercentage = "<%=c %>";
                var fresh_air_systemppercentage = "<%=d %>";
                var otherpercentage = "<%=e %>";
                var data_arr = [fresh_air_systemppercentage, socketpercentage,curtainspercentage, otherpercentage,switchpercentage];  
                var color_arr = ["#9082BD", "#FFF45C", "#0CF", "#394", "#D42218"];  
                var text_arr = ["新风系统", "插座", "窗帘","其他", "开关"];  
  
                drawCircle("canvas_circle", data_arr, color_arr, text_arr);  
            }  
  
            //页面加载时执行init()函数  
            window.onload = init;  
        </script>  
</head>
<body>
	<div class="center">
		<div class="distribution">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>设备分布情况</b>
		</div>
		<div class="refresh">
			<a href="#" target="_blank"><img src="icon/refresh.png" width="48" height="45"/></a>
		</div>
		<div>
			<img src="icon/redline.png" width="1180" height="3"/>
		</div>
		<div class="mapData">
		<div class="areaData">
		<h3>设备分布地区情况</h3> 
		<canvas id="a_canvas" width="680" height="320"></canvas>
<script>
    (function (){
     
        window.addEventListener("load", function(){
          var diviceCount=${requestScope.diviceCount};
          var data = [500,600,300,diviceCount,100];
          var xinforma = ['深圳市','广州市','佛山市','江门市','湛江市'];
 
          // 获取上下文
          var a_canvas = document.getElementById('a_canvas');
          var context = a_canvas.getContext("2d");
 
 
          // 绘制背景
          var gradient = context.createLinearGradient(0,0,0,300);
 
 
          //gradient.addColorStop(0,"#e0e0e0");
          //gradient.addColorStop(1,"#ffffff");
 
 
          context.fillStyle = gradient;
 
          context.fillRect(0,0,a_canvas.width,a_canvas.height);
 
          var realheight = a_canvas.height-15;
          var realwidth = a_canvas.width-40;
          // 描绘边框
          var grid_cols = data.length + 1;
          var grid_rows = 4;
          var cell_height = realheight / grid_rows;
          var cell_width = realwidth / grid_cols;
          context.lineWidth = 1;
          context.strokeStyle = "#a0a0a0";
 
          // 结束边框描绘
          context.beginPath();
          
            //划横线
            context.moveTo(0,realheight);
            context.lineTo(realwidth,realheight);
                
             
            //画竖线
          context.moveTo(0,20);
           context.lineTo(0,realheight);
          context.lineWidth = 1;
          context.strokeStyle = "black";
          context.stroke();
              
 
          var max_v =0;
          
          for(var i = 0; i<data.length; i++){
            if (data[i] > max_v) { max_v =data[i]};
          }
          max_v = max_v * 1.1;
          // 将数据换算为坐标
          var points = [];
          for( var i=0; i < data.length; i++){
            var v= data[i];
            var px = cell_width*(i +1);
            var py = realheight - realheight*(v / max_v);
            //alert(py);
            points.push({"x":px,"y":py});
          }
 
          //绘制坐标图形
          for(var i in points){
            var p = points[i];
            context.beginPath();
            context.fillStyle="green";
            context.fillRect(p.x,p.y,30,realheight-p.y);//条形图宽度
             
            context.fill();
          }
          //添加文字
          for(var i in points)
          {  var p = points[i];
            context.beginPath();
            context.fillStyle="black";
            context.fillText(data[i], p.x + 1, p.y - 15);
             context.fillText(xinforma[i],p.x + 1,realheight+12);
             context.fillText('城市',realwidth,realheight+12);
             context.fillText('设备数量',0,10);
              }
        },false);
      })();
       
</script>
		</div>
		<div class="diviceaData">
		<h3>设备数量占比（总数：${requestScope.diviceAllCount2}）</h3>
        <p>  
            <canvas id="canvas_circle" width="450" height="280" >  
                浏览器不支持canvas  
            </canvas>  
        </p> </div>
		
		</div>
		
		
	</div>
	<!-- center-->

</body>
</html>