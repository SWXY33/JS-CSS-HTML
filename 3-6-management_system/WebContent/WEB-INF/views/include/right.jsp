<%@ page contentType="text/html; charset=utf-8" language="java"
	import="java.sql.*" errorPage=""%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>left</title>
<link rel="stylesheet" type="text/css" href="css/right.css" />
<script src="js/jquery-3.4.1.min.js"></script>
<title>Insert title here</title>
</head>
<body>
	<div class="right">
		<div class="calendar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>系统日历</b>
		</div>
		<div class="refresh1">
			<a href="#" target="_blank"><img src="icon/refresh1.png" width="45" height="45"></a>
		</div>
		<div>
			<img src="icon/redline.png" width="420" height="3">
		</div>

		<div class="calendar1">
			<div class="title1">
				<div class="year"></div>
				<div class="year"></div>
				<div class="year" id="calendar-year"></div>
				<div class="year1">年</div>
				<div class="month" id="calendar-month"></div>
				<div class="year"></div>
				<a href="" id="pre"> <b> < </b>
				</a> <a href="" id="next"><b> > </b></a>
			</div>

			<div class="body1">
				<div class="lightgrey body-list">
					<ul>
						<li>日</li>
						<li>一</li>
						<li>二</li>
						<li>三</li>
						<li>四</li>
						<li>五</li>
						<li>六</li>

					</ul>

				</div>

				<div class="darkgrey body-list">
					<ul id="days">

					</ul>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			var month_olypic = [ 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];//闰年每个月份的天数
			var month_normal = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
			var month_name = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月",
					"9月", "10月", "11月", "12月" ];
			//获取以上各个部分的id
			var holder = document.getElementById("days");
			var prev = document.getElementById("prev");
			var next = document.getElementById("next");
			var ctitle = document.getElementById("calendar-month");
			var cyear = document.getElementById("calendar-year");
			//获取当天的年月日
			var my_date = new Date();
			var my_year = my_date.getFullYear();//获取年份
			var my_month = my_date.getMonth(); //获取月份，一月份的下标为0
			var my_day = my_date.getDate();//获取当前日期

			//根据年月获取当月第一天是周几
			function dayStart(month, year) {
				var tmpDate = new Date(year, month, 1);
				return (tmpDate.getDay());
			}
			//根据年份判断某月有多少天(11,2018),表示2018年12月
			function daysMonth(month, year) {
				var tmp1 = year % 4;
				var tmp2 = year % 100;
				var tmp3 = year % 400;

				if ((tmp1 == 0 && tmp2 != 0) || (tmp3 == 0)) {
					return (month_olypic[month]);//闰年
				} else {
					return (month_normal[month]);//非闰年
				}
			}
			//js实现str插入li+class,不要忘了用innerhtml进行插入
			function refreshDate() {
				var str = "";
				//计算当月的天数和每月第一天都是周几，day_month和day_year都从上面获得
				var totalDay = daysMonth(my_month, my_year);
				var firstDay = dayStart(my_month, my_year);
				//添加每个月的空白部分
				for (var i = 0; i < firstDay; i++) {
					str += "<li>" + "</li>";
				}

				//从一号开始添加直到totalDay，并为pre，next和当天添加样式
				var myclass;
				for (var i = 1; i <= totalDay; i++) {
					//三种情况年份小，年分相等月份小，年月相等，天数小
					//点击pre和next之后，my_month和my_year会发生变化，将其与现在的直接获取的再进行比较
					//i与my_day进行比较,pre和next变化时，my_day是不变的
					console.log(my_year + " " + my_month + " " + my_day);
					console.log(my_date.getFullYear() + " "
							+ my_date.getMonth() + " " + my_date.getDay());
					if ((my_year < my_date.getFullYear())
							|| (my_year == my_date.getFullYear() && my_month < my_date
									.getMonth())
							|| (my_year == my_date.getFullYear()
									&& my_month == my_date.getMonth() && i < my_day)) {
						myclass = " class='lightgrey'";
					} else if (my_year == my_date.getFullYear()
							&& my_month == my_date.getMonth() && i == my_day) {
						myclass = "class = 'green greenbox'";
					} else {
						myclass = "class = 'darkgrey'";
					}
					str += "<li "+myclass+">" + i + "</li>";
				}
				holder.innerHTML = str;
				ctitle.innerHTML = month_name[my_month];
				cyear.innerHTML = my_year;
			}
			//调用refreshDate()函数，日历才会出现
			refreshDate();
			//实现onclick向前或向后移动
			pre.onclick = function(e) {
				e.preventDefault();
				my_month--;
				if (my_month < 0) {
					my_year--;
					my_month = 11; //即12月份
				}
				refreshDate();
			}

			next.onclick = function(e) {
				e.preventDefault();
				my_month++;
				if (my_month > 11) {
					my_month = 0;
					my_year++;
				}
				refreshDate();
			}
		</script>

	</div>
	<!--right-->
</body>
</html>