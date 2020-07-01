function TurnColorB(){
	var list=$("#out_B .out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("B红色"+"list[i].id="+list[i].id);//list[i].id获取当前元素标签的id值
			$('div[id^="'+list[i].id+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("B黑色"+"list[i].id="+list[i].id);
			$('div[id^="'+list[i].id+'"]').css("color","black");
		}
	}
}
function TurnColorC(){
	var list=$("#out_C .out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("C红色"+"list[i].id="+list[i].id);//list[i].id获取当前元素标签的id值
			$('div[id^="'+list[i].id+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("C黑色"+"list[i].id="+list[i].id);
			$('div[id^="'+list[i].id+'"]').css("color","black");
		}
	}
}
function TurnColorD(){
	var list=$("#out_D .out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("D红色"+"list[i].id="+list[i].id);//list[i].id获取当前元素标签的id值
			$('div[id^="'+list[i].id+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("D黑色"+"list[i].id="+list[i].id);
			$('div[id^="'+list[i].id+'"]').css("color","black");
		}
	}
}
function TurnColorA(){
	var list=$("#out_A .out_pokers");
	for(var i=0;i<list.length;i++){
		console.log(list[i]);//list[i].id的输出结果为HTMLDivElement，如：<div id="Poker22_hongtao9" class="poker">9</div>
		if(getColor(list[i].innerHTML)==0){
			console.log("A红色"+"list[i].id="+list[i].id);//list[i].id获取当前元素标签的id值
			$('div[id^="'+list[i].id+'"]').css("color","red");//设置id值为list[i].id的div字体颜色为红色
		}else if(getColor(list[i].innerHTML)==1){
			console.log("A黑色"+"list[i].id="+list[i].id);
			$('div[id^="'+list[i].id+'"]').css("color","black");
		}
	}
}
function getpokersD(){//获取玩家D的手牌
	var list=$("#D .poker");
	var PokersD=[];
	for(var i=0;i<list.length;i++){
		PokersD.push(list[i].innerHTML);
	}
	console.log("D的手牌为："+PokersD);
	return PokersD;
}
function getpokersA(){//获取玩家A的手牌
	var list=$("#A .poker");
	var PokersA=[];
	for(var i=0;i<list.length;i++){
		PokersA.push(list[i].innerHTML);
	}
	console.log("A的手牌为："+PokersA);
	return PokersA;
}
function getpokersC(){//获取玩家C的手牌
	var list=$("#C .poker");
	var PokersC=[];
	for(var i=0;i<list.length;i++){
		PokersC.push(list[i].innerHTML);
	}
	console.log("D的手牌为："+PokersC);
	return PokersC;
}
function getpokersB(){//获取玩家B的手牌
	var list=$("#B .poker");
	var PokersB=[];
	for(var i=0;i<list.length;i++){
		PokersB.push(list[i].innerHTML);
	}
	console.log("B的手牌为："+PokersB);
	return PokersB;
}



function CompareThree(three,MainPokers){//比较3张选牌是否为最大,three为当前选的3张牌,MainPokers为叫的主牌
		if(MainPokers=="dawang"||MainPokers=="xiaowang"){//无主时，选的三张最大（甩牌）
		var zhu=["♚","♖","♠2","♥2","♣2","♦2"];//定义主牌
		function find(item){//查找某张牌是否为无主的主牌			
			for(var k=0;k<zhu.length;k++){
				if(zhu.indexOf(item)>-1){//如果选的牌是主牌返回1，否则返回0
					return 1;
				}else{
					return 0;
				}
				}
		}	
		function rankNum(poker){//确定牌的优先级，2为最大，1为第二大，0为第三大
			if(poker=="♚"){return 2;}
			else if(poker=="♖"){return 1;}
			else if(poker=="♠2"||poker=="♠2"||poker=="♣2"||poker=="♦2"){return 0;}
		}
		function getWang(player){//判断某玩家的手牌是否有大小王，player为玩家的手牌
			var big=[],small=[];
			for(var i=0;i<player.length;i++)	{
				if(find(player[i])==1&&rankNum(player[i])==0){
					small.push(player[i]);
				}else if(find(player[i])==1&&rankNum(player[i])==2||find(player[i])==1&&rankNum(player[i])==1){
					big.push(player[i]);
				}
			}
			console.log("small="+small+"big="+big);
			if(big.length==0){console.log("玩家手中没有大王小王");return 1;}//玩家手中没有大王小王
			else{console.log("玩家手中有大王\小王");return 0;}////玩家手中有大王、小王
			}
		function CompareSameType(poker,type){ //type为选牌的花色，poker为某一张牌
					   if(type=="heitao"){
					   			   if(poker=="♠A"){poker=14;return poker;}
					   			   else if(poker=="♠K"){poker=13;return poker;}
					   			   else if(poker=="♠Q"){poker=12;return poker;}
					   			   else if(poker=="♠J"){poker=11;return poker;}
					   			   else if(poker=="♠10"){poker=10;return poker;}
					   			   else if(poker=="♠9"){poker=9;return poker;}
					   			   else if(poker=="♠8"){poker=8;return poker;}
					   			   else if(poker=="♠7"){poker=7;return poker;}
					   			   else if(poker=="♠6"){poker=6;return poker;}
					   			   else if(poker=="♠5"){poker=5;return poker;}
					   			   else if(poker=="♠4"){poker=4;return poker;}
					   			   else if(poker=="♠3"){poker=3;return poker;}
					   }else if(type=="hongtao"){
					   			  if(poker=="♥A"){poker=14;return poker;}
					   			  else if(poker=="♥K"){poker=13;return poker;}
					   			  else if(poker=="♥Q"){poker=12;return poker;}
					   			  else if(poker=="♥J"){poker=11;return poker;}
					   			  else if(poker=="♥10"){poker=10;return poker;}
					   			  else if(poker=="♥9"){poker=9;return poker;}
					   			  else if(poker=="♥8"){poker=8;return poker;}
					   			  else if(poker=="♥7"){poker=7;return poker;}
					   			  else if(poker=="♥6"){poker=6;return poker;}
					   			  else if(poker=="♥5"){poker=5;return poker;}
					   			  else if(poker=="♥4"){poker=4;return poker;}
					   			  else if(poker=="♥3"){poker=3;return poker;} 
					   }else if(type=="meihua"){
					   			 if(poker=="♣A"){poker=14;return poker;}
					   			 else if(poker=="♣K"){poker=13;return poker;}
					   			 else if(poker=="♣Q"){poker=12;return poker;}
					   			 else if(poker=="♣J"){poker=11;return poker;}
					   			 else if(poker=="♣10"){poker=10;return poker;}
					   			 else if(poker=="♣9"){poker=9;return poker;}
					   			 else if(poker=="♣8"){poker=8;return poker;}
					   			 else if(poker=="♣7"){poker=7;return poker;}
					   			 else if(poker=="♣6"){poker=6;return poker;}
					   			 else if(poker=="♣5"){poker=5;return poker;}
					   			 else if(poker=="♣4"){poker=4;return poker;}
					   			 else if(poker=="♣3"){poker=3;return poker;}  
					   }else if(type=="fangkuai"){
					   			 if(poker=="♦A"){poker=14;}
					   			 else if(poker=="♦K"){poker=13;return poker;}
					   			 else if(poker=="♦Q"){poker=12;return poker;}
					   			 else if(poker=="♦J"){poker=11;return poker;}
					   			 else if(poker=="♦10"){poker=10;return poker;}
					   			 else if(poker=="♦9"){poker=9;return poker;}
					   			 else if(poker=="♦8"){poker=8;return poker;}
					   			 else if(poker=="♦7"){poker=7;return poker;}
					   			 else if(poker=="♦6"){poker=6;return poker;}
					   			 else if(poker=="♦5"){poker=5;return poker;}
					   			 else if(poker=="♦4"){poker=4;return poker;}
					   			 else if(poker=="♦3"){poker=3;return poker;}  
					   
		}
		}
		function getSameType(arr,type){//获取相同类型的牌，type为当前玩家出牌的花色，arr为任意玩家的手牌
		   var SameTypeArr=[];
		   for(var i=0;i<arr.length;i++){
			   if(getType(arr[i])==type&&arr[i]!="♠2"&&arr[i]!="♥2"&&arr[i]!="♣2"&&arr[i]!="♦2"){
				   SameTypeArr.push(arr[i]);//把同花色的副牌放到SameTypeArr数组；
			   }
			 
		   }
		   console.log("同花色的副牌有："+SameTypeArr);
		   for(var j=0;j<SameTypeArr.length;j++){
		   	    SameTypeArr[j]=CompareSameType(SameTypeArr[j],type);
		   	}		  
		   console.log("同花色的副牌有(转变成数字后…………)："+SameTypeArr);
		   return SameTypeArr;
		   }
		
		   
		   
		   
		   
		   function ifSmall(out1,out2,out3,player){//如果其他玩家同花色牌都比选的牌小，out123分别为选的三张牌，player为任意玩家的手牌
		   	var SameType=getSameType(player,getType(out1));//获取某玩家与选牌花色一致的副牌
		   	var small=[];
			console.log("CompareSameType(out1,getType(out1))======="+CompareSameType(out1,getType(out1)))
		   	for(var x=0;x<SameType.length;x++){
		   	if(SameType[x]<CompareSameType(out1,getType(out1))&&SameType[x]<CompareSameType(out2,getType(out1))&&SameType[x]<CompareSameType(out3,getType(out1))){
		   		small.push(SameType[x]);
		   	}
		   	}
		   	console.log("比选牌小的牌有："+small);
			console.log("small.length================="+small.length+"SameType.length================"+SameType.length)
		   	if(small.length==SameType.length){
		   		return 1;
		   	}
		   	
		   }
		   
	
		if(find(three[0])==1&&find(three[1])==1&&find(three[2])==1){//选的3张牌都是主牌时
			//三张牌是最大的
			if(getWang(getpokersD())==1&&getWang(getpokersA())==1&&getWang(getpokersC())==1){//其他玩家都没有大小王
				return 1;
			}else{return 0;	}
			}else if(find(three[0])==0&&find(three[1])==0&&find(three[2])==0){//选的3张牌都是副牌时
			//三张牌是最大的				
		  if(ifSmall(three[0],three[1],three[2],getpokersD())==1&&
		  ifSmall(three[0],three[1],three[2],getpokersA())==1&&
		  ifSmall(three[0],three[1],three[2],getpokersC())==1){//判断选的三张牌是否都比其他玩家同花色的牌大
			 return 1; 
		  }else {
			  return 0;
		  }
			}
			
			
		}else if(MainPokers=="heitao"){//叫的是黑桃主时
			
		}else if(MainPokers=="heitao"){//叫的是红桃主时
			
		}else if(MainPokers=="heitao"){//叫的是梅花主时
			
		}else if(MainPokers=="heitao"){//叫的是方块主时
			
		}
		
	}



function CompareType(arr){//判断出牌类型，arr为选中想要出的牌，返回1则符合出牌规则允许出牌，否则出不了牌

    
		
	
	
    if(arr.length==1){//出一张牌时
		return 1;
    }else if(arr.length>1){//出多张牌时
	var Type=[];
	for(var i=0;i<arr.length;i++){
	Type.push(getType(arr[i]));		
	}
	
	console.log("选牌类型为=======："+Type);
	
			     if(arr.length==2&&arr[0]==arr[1]){//出牌数量为两张时，牌面必须相同
					 console.log("选牌类型相同"+arr[0]+Type[0]+arr[1]+Type[1]);
					 console.log("亮主类型是："+liangzhu+"选牌类型是："+Type[0]);
					 
					 return 1;
					 }else if(arr.length==3&&arr[0]==arr[1]&&arr[0]==arr[2]||arr.length==3&&CompareThree(arr,liangzhu)==1){//出3张牌时，可以出牌的情况有：1、3张相同；2、三张都比其他玩家大3、其他玩家没有这种类型的牌了
					      console.log("3张牌的类型是：：：："+arr[0]+Type[0]+arr[1]+Type[1]+arr[2]+Type[2]);
						  
					      return 1;	  
				 }else if(arr.length==4&&arr[0]==arr[1]&&arr[2]==arr[3]&&arr[0]==arr[2]){//出4张牌时,可以出牌的情况有：1、四张相同；2、一个A带三个K（在其他玩家没有三个A的前提下）；
				 //3、甩牌两对而且是最大的；4、四张牌都比其他玩家同类型的牌大；5、其他玩家没有这种类型的牌。
					 
				 }else{
			console.log("选牌类型不相同");
			 return 0;
		
	}
	
}

  }

function OutPokersB() { //B出牌
	var out=[];
	var list = $("#B .active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		// /console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("outB============"+out);
	if(out.length!=0&&CompareType(out)==1){	
	console.log("out.length："+out.length);
	if(document.getElementById("out_B")){//如果B出过牌（已经创建过id="out_B"的div元素）
	    $('#out_B').remove();
		$('#out_B .out_pokers').remove();
		$("#desk").append("<div class='out_B' id='out_B'></div>");
		for(var i=0;i<out.length;i++){
			$("#out_B").append("<div class='out_pokers' id='PokerB_"+i+"'>"+out[i]+"</div>");
			}
			TurnColorB();
			$('button[class^="operate1"]').remove();//隐藏B出牌操作
			document.getElementById("operateD").style.visibility="visible";//显示D出牌操作
			setTimeout(function() {$("#operateD").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
			"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outD()'>出牌</button>"+
			"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='Before()'>上轮</button>");}, 1000);
			$("#B .active").remove();
	}else{//如果B还没有出过牌
	$("#desk").append("<div class='out_B' id='out_B'></div>");
	for(var i=0;i<out.length;i++){
		$("#out_B").append("<div class='out_pokers' id='PokerB_"+i+"'>"+out[i]+"</div>");
		}
		TurnColorB();
		$('button[class^="operate1"]').remove();//隐藏B出牌操作
		document.getElementById("operateD").style.visibility="visible";//显示D出牌操作
		setTimeout(function() {$("#operateD").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
		"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outD()'>出牌</button>"+
		"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='Before()'>上轮</button>");}, 1000);
		$("#B .active").remove();
	
	}
	}else{
		console.log("出牌不符合规则，请重新选牌！");
		console.log("CompareType(out)="+CompareType(out));
		return;
	}
	}
function OutPokersD() { //D出牌
	var out=[];
	var list = $("#D .active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("D出牌："+out);
	var out_B=[];
	var out_pokersB=$("#out_B .out_pokers");
	for(var i=0;i<out_pokersB.length;i++){
		out_B.push(out_pokersB[i].innerHTML);
	}
	console.log("上家B出的牌是：：：：：：：：：：：：：：：：："+out_B);
	function OperateD(){
		if(out.length!=0&&out.length==out_B.length){//判断与上家出牌数量是否一致
		$("#desk").append("<div class='out_D' id='out_D'></div>");
		
		for(var i=0;i<out.length;i++){
			$("#out_D").append("<div class='out_pokers' id='PokerD_"+i+"'>"+out[i]+"</div>");
			}
			TurnColorD();
			$('button[class^="operate1"]').remove();//隐藏D出牌操作
			document.getElementById("operateA").style.visibility="visible";//显示A出牌操作
			setTimeout(function() {$("#operateA").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
			"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outA()'>出牌</button>"+
			"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='Before()'>上轮</button>");}, 1000);
			$("#D .active").remove();
			}else{
				return;
			}
	}
	if(document.getElementById("out_D")){//如果D出过牌（已经创建过id="out_D"的div元素）
	    $('#out_D').remove();
		$('#out_D .out_pokers').remove();
		OperateD();
	}else{	
	OperateD();
	}
	}
	
function OutPokersA() { //A出牌
	var out=[];
	var list = $("#A .active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("A出牌："+out);
	var out_D=[];
	var out_pokersD=$("#out_D .out_pokers");
	for(var i=0;i<out_pokersD.length;i++){
		out_D.push(out_pokersD[i].innerHTML);
	}
	console.log("上家D出的牌是：：：：：：：：：：：：：：：：："+out_D);
	function OperateA(){
		if(out.length!=0&&out.length==out_D.length){//判断与上家出牌数量是否一致
		$("#desk").append("<div class='out_A' id='out_A'></div>");
		
		for(var i=0;i<out.length;i++){
			$("#out_A").append("<div class='out_pokers' id='PokerA_"+i+"'>"+out[i]+"</div>");
			}
			TurnColorA();
			$('button[class^="operate1"]').remove();//隐藏A出牌操作
			document.getElementById("operateC").style.visibility="visible";//显示C出牌操作
			setTimeout(function() {$("#operateC").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
			"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outC()'>出牌</button>"+
			"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='Before()'>上轮</button>");}, 1000);
			$("#A .active").remove();
			}else{
				return;
			}
	}
	if(document.getElementById("out_A")){//如果A出过牌（已经创建过id="out_A"的div元素）
	    $('#out_A').remove();
		$('#out_A .out_pokers').remove();
		OperateA();
	}else{
	OperateA();
	}
	}
function OutPokersC() { //C出牌
	var out=[];
	var list = $("#C .active");//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("C出牌："+out);
	var out_A=[];
	var out_pokersA=$("#out_A .out_pokers");
	for(var i=0;i<out_pokersA.length;i++){
		out_A.push(out_pokersA[i].innerHTML);
	}
	console.log("上家A出的牌是：：：：：：：：：：：：：：：：："+out_A);
	function OperateC(){
		if(out.length!=0&&out.length==out_A.length){//判断与上家出牌数量是否一致
		$("#desk").append("<div class='out_C' id='out_C'></div>");
		for(var i=0;i<out.length;i++){
			$("#out_C").append("<div class='out_pokers' id='PokerC_"+i+"'>"+out[i]+"</div>");
			}
			TurnColorC();
			$('button[class^="operate1"]').remove();//隐藏C出牌操作
			document.getElementById("operateB").style.visibility="visible";//显示B出牌操作
			setTimeout(function() {$("#operateB").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
			"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outB()'>出牌</button>"+
			"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='Before()'>上轮</button>");}, 1000);
			$("#C .active").remove();
			}else{
				return;
			}
	}
	if(document.getElementById("out_C")){//如果C出过牌（已经创建过id="out_C"的div元素）
	    $('#out_C').remove();
		$('#out_C .out_pokers').remove();
		OperateC();
	}else{
	OperateC();
	}
	}
//出牌
function outB() {
	//$('#out_B').remove();
	OutPokersB();
}
function outD() {
	//$('#out_B').remove();
	OutPokersD();
}
function outA() {
	//$('#out_B').remove();
	OutPokersA();
}
function outC() {
	//$('#out_B').remove();
	OutPokersC();
	setTimeout(function( ){
	HideOutPokers();
	},2000);
	//$('div[class^="out_pokers"]').hide();
}
function HideOutPokers(){
	document.getElementById("out_A").style.visibility="hidden";
	document.getElementById("out_B").style.visibility="hidden";
	document.getElementById("out_C").style.visibility="hidden";
	document.getElementById("out_D").style.visibility="hidden";
}
//上一轮出牌记录
function Before(){
	document.getElementById("out_A").style.visibility="visible";
	document.getElementById("out_B").style.visibility="visible";
	document.getElementById("out_C").style.visibility="visible";
	document.getElementById("out_D").style.visibility="visible";
    setTimeout(function( ){
	HideOutPokers();
	},2000);
}
//出牌规则：第一、获得优先出牌权的玩家可以随意出一种牌型，必须与上家出牌数量一致；


//比较牌型大小
function CompareOutPokers(){
	
}


/*不出牌
function PassB(){
	$('button[class^="operate1"]').remove();//隐藏B出牌操作	document.getElementById("operateD").style.visibility="visible";//显示D出牌操作	setTimeout(function() {$("#operateD").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+	"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outD()'>出牌</button>"+	"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='PassD()'>不出</button>");}, 1000);
}
function PassD(){
	$('button[class^="operate1"]').remove();//隐藏D出牌操作
	document.getElementById("operateA").style.visibility="visible";//显示A出牌操作
	setTimeout(function() {$("#operateA").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
	"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outA()'>出牌</button>"+
	"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='PassA()'>不出</button>");}, 1000);
}
function PassA(){
	$('button[class^="operate1"]').remove();//隐藏A出牌操作
	document.getElementById("operateC").style.visibility="visible";//显示C出牌操作
	setTimeout(function() {$("#operateC").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
	"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outC()'>出牌</button>"+
	"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='PassC()'>不出</button>");}, 1000);
}
function PassC(){
	$('button[class^="operate1"]').remove();//隐藏C出牌操作
	document.getElementById("operateB").style.visibility="visible";//显示B出牌操作
	setTimeout(function() {$("#operateB").append("<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
	"<button class='operate1' id='out'style='background-color:#00aa00' onclick='outB()'>出牌</button>"+
	"<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='PassB()'>不出</button>");}, 1000);
}
*/

/*计分
K=10分，10=10分；5=5分
*/

