function TurnColor(){
	var list=$(".out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("红色"+"list[i].className="+list[i].className);//list[i].id获取当前元素标签的id值
			$('div[class^="'+list[i].className+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("黑色"+"list[i].className="+list[i].className);
			$('div[id^="'+list[i].className+'"]').css("color","black");
		}
	}
}


function OutPokersB() { //B出牌
	var out=[];
	var list = $(".active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("出牌："+out);
	$("#desk").append("<div class='out_B' id='out_B'></div>");
	for(var i=0;i<out.length;i++){
		
		$("#out_B").append("<div class='out_pokers'>"+out[i]+"</div>");
		}
		TurnColor();
		$('button[class^="operate1"]').remove();//隐藏B出牌操作
		document.getElementById("operateD").style.visibility="visible";//显示D出牌操作
		setTimeout(function() {$("#operateD").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
		"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outD()'>出牌</button>"+
		"<button class='operate1' id='pass' style='background-color:#d30b4b'>不出</button>");}, 1000);
	}
function OutPokersD() { //D出牌
	var out=[];
	var list = $(".active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("出牌："+out);
	$("#desk").append("<div class='out_D' id='out_D'></div>");
	for(var i=0;i<out.length;i++){
		$("#out_D").append("<div class='out_pokers'>"+out[i]+"</div>");
		}
		TurnColor();
		$('button[class^="operate1"]').remove();//隐藏D出牌操作
		document.getElementById("operateA").style.visibility="visible";//显示A出牌操作
		setTimeout(function() {$("#operateA").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
		"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outA()'>出牌</button>"+
		"<button class='operate1' id='pass' style='background-color:#d30b4b'>不出</button>");}, 1000);
	}
function OutPokersA() { //A出牌
	var out=[];
	var list = $(".active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("出牌："+out);
	$("#desk").append("<div class='out_A' id='out_A'></div>");
	for(var i=0;i<out.length;i++){
		$("#out_A").append("<div class='out_pokers'>"+out[i]+"</div>");
		}
		TurnColor();
		$('button[class^="operate1"]').remove();//隐藏A出牌操作
		document.getElementById("operateC").style.visibility="visible";//显示C出牌操作
		setTimeout(function() {$("#operateC").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
		"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outC()'>出牌</button>"+
		"<button class='operate1' id='pass' style='background-color:#d30b4b'>不出</button>");}, 1000);
	}
function OutPokersC() { //C出牌
	var out=[];
	var list = $(".active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("出牌："+out);
	$("#desk").append("<div class='out_C' id='out_C'></div>");
	for(var i=0;i<out.length;i++){

		$("#out_C").append("<div class='out_pokers'>"+out[i]+"</div>");
		}
		TurnColor();
		$('button[class^="operate1"]').remove();//隐藏A出牌操作
		document.getElementById("operateB").style.visibility="visible";//显示C出牌操作
		setTimeout(function() {$("#operateB").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
		"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outB()'>出牌</button>"+
		"<button class='operate1' id='pass' style='background-color:#d30b4b'>不出</button>");}, 1000);
	}

function outB() {
	OutPokersB();
	$(".active").remove();
}
function outD() {
	OutPokersD();
	$(".active").remove();
}
function outA() {
	OutPokersA();
	$(".active").remove();
}
function outC() {
	OutPokersC();
	$(".active").remove();
	$('div[class^="out_pokers"]'),remove();
}
/*计分
K=10分，10=10分；5=5分
*/

