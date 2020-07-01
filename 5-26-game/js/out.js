function TurnColor(){
	var list=$(".out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("红色"+"list[i].classid="+list[i].className);//list[i].id获取当前元素标签的id值
			$('div[class^="'+list[i].className+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("黑色"+"list[i].classid="+list[i].className);
			$('div[id^="'+list[i].className+'"]').css("color","black");
		}
	}
}


function OutPokers() { //出牌
	var out=[];
	var list = $(".active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);

	}
	console.log("出牌："+out);
	for(var i=0;i<out.length;i++){
		$("#desk").append("<div class='out_B' id='out_B'></div>");
		$("#out_B").append("<div class='out_pokers'>"+out[i]+"</div>");
		}
		TurnColor();
		setTimeout(function (){
			$("#out_B").remove();},3000);
	
	
	}

function out() {
	OutPokers();
	$(".active").remove();

}
