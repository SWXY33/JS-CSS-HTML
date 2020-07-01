var pokers=[];
	pokers[0]="4.jpg",pokers[1]="5.jpg",pokers[2]="6.jpg",pokers[3]="7.jpg",pokers[4]="8.jpg",pokers[5]="9.jpg",pokers[6]="10.jpg",
	pokers[7]="11.jpg",pokers[8]="12.jpg",pokers[9]="13.jpg",pokers[10]="14.jpg",pokers[11]="15.jpg",pokers[12]="3.jpg",pokers[13]="17.jpg",
	pokers[14]="18.jpg",pokers[15]="19.jpg",pokers[16]="20.jpg",pokers[17]="21.jpg",pokers[18]="22.jpg",pokers[19]="23.jpg",pokers[20]="24.jpg",
	pokers[21]="25.jpg",pokers[22]="26.jpg",pokers[23]="27.jpg",pokers[24]="28.jpg",pokers[25]="16.jpg",pokers[26]="30.jpg",pokers[27]="31.jpg",
	pokers[28]="32.jpg",pokers[29]="33.jpg",pokers[30]="34.jpg",pokers[31]="35.jpg",pokers[32]="36.jpg",pokers[33]="37.jpg",pokers[34]="38.jpg",
	pokers[35]="39.jpg",pokers[36]="40.jpg",pokers[37]="41.jpg",pokers[38]="29.jpg",pokers[39]="43.jpg",pokers[40]="44.jpg",pokers[41]="45.jpg",
	pokers[42]="46.jpg",pokers[43]="47.jpg",pokers[44]="48.jpg",pokers[45]="49.jpg",pokers[46]="50.jpg",pokers[47]="51.jpg",pokers[48]="52.jpg",
	pokers[49]="53.jpg",pokers[50]="54.jpg",pokers[51]="42.png";
var friend=[];
    friend[0]="4.jpg",friend[1]="5.jpg",friend[2]="6.jpg",friend[3]="7.jpg",friend[4]="8.jpg",friend[5]="9.jpg",friend[6]="10.jpg",//黑桃4-10
    friend[7]="17.jpg",friend[8]="18.jpg",friend[9]="19.jpg",friend[10]="20.jpg",friend[11]="21.jpg",friend[12]="22.jpg",friend[13]="23.jpg",//红桃4-10
    friend[14]="30.jpg",friend[15]="31.jpg",friend[16]="32.jpg",friend[17]="33.jpg",friend[18]="34.jpg",friend[19]="35.jpg",friend[20]="36.jpg",//梅花4-10
	friend[21]="43.jpg",friend[22]="44.jpg",friend[23]="45.jpg",friend[24]="46.jpg",friend[25]="47.jpg",friend[26]="48.jpg",friend[27]="49.jpg";//方块4-10
 /*工厂模式创建各种牌
     *number:牌上的数字
     *type:牌的花色
	 *img:牌的图片
     */
    var Cards = (function () {
        var Card = function (number, type, img) {
            this.number = number;
            this.type = type;
			this.img = img;
        }
        return function (number, type, img) {
            return new Card(number, type, img);
        }
    })()
	
//i:花色4-黑桃 3-红桃 2-梅花 1-方块
//j:数值1-13代表 4,5,6,7,8,9,10,J,Q,K,A,1,2,3;
var A=[],B=[],C=[],D=[];//四个玩家
var arr = [];//一副完整的扑克牌
var chooseCard = [];//选择朋友的牌
var chooseImg=[];
var tmp;
var tmpArr=[];//存放出牌玩家最近一次出的牌
function SortType(pokers){//扑克牌冒泡排序
	for(var i=0;i<pokers.length-1;i++){
		for(var j=0;j<pokers.length-1-i;j++){
			//相邻元素两两比对，元素交换
			if(pokers[j].type<pokers[j+1].type){//按花色排序，从大到小排序
				tmp = pokers[j];
				pokers[j] = pokers[j+1];
				pokers[j+1] = tmp;
			}else if(pokers[j].type==pokers[j+1].type){//花色相同时，按牌面大小排序
					if(pokers[j].number<pokers[j+1].number){
						tmp = pokers[j];
						pokers[j] = pokers[j+1];
						pokers[j+1] = tmp;
					}
				}
		}
	}
	
}
function sortagain(pokers){//按相同数量大小排序
	    
		for(var i=0;i<pokers.length-1;i++){
			for(var j=0;j<pokers.length-1-i;j++){
				//相邻元素两两比对，元素交换
				if(pokers[j].number<pokers[j+1].number){//按牌面值大小排序
				//console.log("111pokers[j].number====="+pokers[j].number+"pokers[j+1].number========"+pokers[j+1].number)
					tmp = pokers[j];
					pokers[j] = pokers[j+1];
					pokers[j+1] = tmp;
					
				}else if(pokers[j].number==pokers[j+1].number){//牌面值相同时按花色大小排序
				//console.log("222pokers[j].number====="+pokers[j].number+"pokers[j+1].number========"+pokers[j+1].number)
						if(pokers[j].type<pokers[j+1].type){
							tmp = pokers[j];
							pokers[j] = pokers[j+1];
							pokers[j+1] = tmp;
						}
					}
			}					
		}
	}	
function CreatChooseCard() {//创建可选则叫朋友的扑克牌
        var index = 0;
		var k=0;
        for (var i = 4; i >=1; i--) {
                for (var j = 1; j <= 7; j++) {	
                    chooseCard[index] = new Cards(j, i, friend[k]);
                    index++;
					k++;
					console.log("花色i="+i+"数值---------j="+j+"---------k="+k);
                }
            }
		for(vari=0;i<chooseCard.length;i++){
			chooseImg.push(chooseCard[i].img);
		}
		console.log("可选则叫朋友的扑克牌："+chooseImg);
}
    function CreatCompeleteCard() {//创建一副完整的扑克牌
        var index = 0;
		var k=0;
        for (var i = 4; i >=1; i--) {
                for (var j = 1; j <= 13; j++) {	
                    arr[index] = new Cards(j, i, pokers[k]);
                    index++;
					k++;
					console.log("花色i="+i+"数值---------j="+j+"---------k="+k);
					//$("#test1").append("<div class='poker' id='poker_"+i+"_"+j+"'><img src='img/"+pokers[k]+"'/></div>");
                }
            }
			//洗牌
			arr.sort(function() {
				return (0.5-Math.random());
			});
			
			//发牌
			for(var m=0;m<arr.length;m++){
				if(A.length==B.length&&C.length==D.length&&A.length==C.length){
					A.push(arr[m]);
				}
				else if(A.length>B.length&&B.length==C.length&&C.length==D.length){
					B.push(arr[m]);
				}
				else if(A.length==B.length&&B.length>C.length&&C.length==D.length){
					C.push(arr[m]);
				}
				else if(A.length==B.length&&B.length==C.length&&C.length>D.length){
					D.push(arr[m]);
				}	
			}
			console.log("A========"+A);
			console.log("B========"+B);
			console.log("C========"+C);
			console.log("D========"+D);
	sort2();	//扑克牌排序			 
        }
function sort1(){//按牌面值大小排序
	$('div[class^="poker"]').remove();
	sortagain(A);
	sortagain(B);
	sortagain(C);
	sortagain(D);
	for(var i=0;i<13;i++){
		$("#A").append("<div class='poker' id='pokerA_"+i+"'><img id='"+A[i].img+"'  src='img/"+A[i].img+"'/></div>");
		$("#B").append("<div class='poker' id='pokerB_"+i+"'><img id='"+B[i].img+"' src='img/"+B[i].img+"'/></div>");
		$("#C").append("<div class='poker' id='pokerC_"+i+"'><img id='"+A[i].img+"'  src='img/"+C[i].img+"'/></div>");
		$("#D").append("<div class='poker' id='pokerD_"+i+"'><img id='"+A[i].img+"'  src='img/"+D[i].img+"'/></div>");
	}
	ChoosePoker();	//选择扑克牌
}
function sort2(){//按花色大小排序
	$('div[class^="poker"]').remove();
	SortType(A);
	SortType(B);
	SortType(C);
	SortType(D);
	for(var i=0;i<13;i++){
    $("#A").append("<div class='poker' id='pokerA_"+i+"'><img id='"+A[i].img+"'  src='img/"+A[i].img+"'/></div>");
	$("#B").append("<div class='poker' id='pokerB_"+i+"'><img id='"+B[i].img+"'  src='img/"+B[i].img+"'/></div>");
	$("#C").append("<div class='poker' id='pokerC_"+i+"'><img id='"+C[i].img+"'  src='img/"+C[i].img+"'/></div>");
	$("#D").append("<div class='poker' id='pokerD_"+i+"'><img id='"+D[i].img+"'  src='img/"+D[i].img+"'/></div>");
	}
		ChoosePoker();	//选择扑克牌
}	
function ChoosePoker(){//选牌
			$('div[class^="A"]').children().click(function () {//当类名为A的子元素出现点击事件时
				var clicktimes;
						if($(this).attr('class')=="poker"){//如果点击的这个元素它的类名为poker
						clicktimes=1;//那么设置点击次数为1
					    $(this).removeClass("poker");//移除这个poker类名
					    $(this).addClass("active");//并且添加一个类名叫active
				}else if($(this).attr('class')=="active"){//如果点击的这个元素它的类名为active
						clicktimes=0;//那么设置点击次数为0
					    $(this).removeClass("active");//移除这个active的类名
					    $(this).addClass("poker");//同时添加一个类名叫poker
				}
			    });
			$('div[class^="B"]').children().click(function () {
				var clicktimes;
						if($(this).attr('class')=="poker"){
						clicktimes=1;
					    $(this).removeClass("poker");
					    $(this).addClass("active");
					
				}else if($(this).attr('class')=="active"){
						clicktimes=0;
					    $(this).removeClass("active");
					    $(this).addClass("poker");
				}
			    });
	
		$('div[class^="C"]').children().click(function () {
			var clicktimes;
					if($(this).attr('class')=="poker"){
					clicktimes=1;
				    $(this).removeClass("poker");
				    $(this).addClass("active");
				
			}else if($(this).attr('class')=="active"){
					clicktimes=0;
				    $(this).removeClass("active");
				    $(this).addClass("poker");
			}
		    });
			$('div[class^="D"]').children().click(function () {
				var clicktimes;
						if($(this).attr('class')=="poker"){
						clicktimes=1;
					    $(this).removeClass("poker");
					    $(this).addClass("active");
					
				}else if($(this).attr('class')=="active"){
						clicktimes=0;
					    $(this).removeClass("active");
					    $(this).addClass("poker");
				}
			    });
	}
var getFirstOutPlayer;//获得♦4的玩家
function findFangkuai4(){
	$('img').each(function() {//获取所有扑克牌图片路径
	if($(this).attr('src')=="img/43.jpg"){
		getFirstOutPlayer=$(this).parent().parent().attr('id');//找到获得方块4的玩家的id（A\B\C\D），该玩家可以获得首先出牌权	
	}
	});
 return getFirstOutPlayer;
}	
function IsExistFangkuai4(player){//判断是否存在方块4，有不能不出牌，没有的话可以不出牌，然后显示下家出牌操作区
	var nextplayer;
	if(player=="A"){nextplayer="C";
	}else if(player=="B"){nextplayer="D";
	}else if(player=="C"){nextplayer="B";
	}else if(player=="D"){nextplayer="A";
	}
		var pokers=[];
		var img=$("#"+player).children();
		for(var i=0;i<img.length;i++){
			pokers.push(img[i].innerHTML);
		}
		if(pokers.indexOf("<img id=\"43.jpg\" src=\"img/43.jpg\">")>-1){//如果玩家手牌有♦4
			console.log("有♦4不能不出牌！"); return;}//判断玩家A手牌是否有♦4
		else{//如果手牌没有♦4
		$("#desk").append("<div class='out_"+player+"' id='out_"+player+"'></div>");
		$("#out_"+player).append("<div class='out_pokers' id='Poker"+player+"_"+i+"'>"+"<div class='PASS'>不出</div>"+"</div>");
		document.getElementById("operate"+player).style.visibility="hidden";//隐藏出牌操作区
		ShowOperate(nextplayer);//显示下家出牌操作区
		console.log("玩家"+player+"选择不出牌。");
}
}
function ShowOperate(x){//显示出牌操作区，x为字符，代表玩家"A"、"B"、"C"、"D"
	var StringId="operate"+x;
	var JqueryId="#operate"+x;
	var outplayer;//当前出牌玩家
	if(x=="A"){outplayer="A";
	}else if(x=="B"){outplayer="B";
	}else if(x=="C"){outplayer="C";
	}else if(x=="D"){outplayer="D";}
	document.getElementById(StringId).style.visibility="visible";//显示出牌操作区
	setTimeout(function() {
	 $(JqueryId).append(
	 "<button class='operate1' id='sort' style='background-color:#aaaaff' onclick='sort()'>排序</button>"+
	 "<button class='operate1' id='hint' style='background-color:#55aaff' onclick='hint()'>提示</button>"+
	 "<button class='operate1' id='out'  style='background-color:#00aa00' onclick='out(\""+outplayer+"\")'>出牌</button>"+
	 "<button class='operate1' id='pass' style='background-color:#d30b4b' onclick='pass(\""+outplayer+"\")'>不要</button>"+
	 "<button class='operate1' id='last' style='background-color:#aaffff' onclick='Before()'>上轮</button>");}, 1000);
}
function VerifyThree(player){//验证出牌3张数值是否相同,player为当前出牌玩家
	var img=[];
	$('img').each(function(){
		if($(this).parent().attr("class")=="active"&&$(this).parent().parent().attr("id")==player){
			img.push($(this).attr("id"));
		}
	});
	console.log("3选中的扑克牌的图片是："+img);
		if(findFangkuai4()==player&&getSameNum(img[0],img[1])==1&&getSameNum(img[0],img[2])==1){
			if(img.indexOf("43.jpg")>-1){
				return 1;
			}else{
				console.log("请出♦4！");
				return 0;
			}
		}else if(findFangkuai4()!=player&&getSameNum(img[0],img[1])==1&&getSameNum(img[0],img[2])==1){
			console.log("您选的是3张数值相同的牌！");
		return 1;
	}else if(findFangkuai4()!=player&&getSameNum(img[0],img[1])==0||findFangkuai4()!=player&&getSameNum(img[0],img[2])==0
	||findFangkuai4()!=player&&getSameNum(img[1],img[2])==0){
			console.log("出牌不符合规则，您选择的不是三张相同数值的牌，请重新出牌！");
		return 0;
	}else{
			return 0;
			}	
}
function ConfirmFriend(){//确定朋友牌
	$('#ChooseFriendPoker img').each(function(){
		if($(this).parent().attr('class')=="active"){
			$("#friendPoker").append("<img id='"+$(this).attr('id')+"'  src='img/"+$(this).attr('id')+"'/>");
		}
	});
	$("#ChooseFriend").remove();
	$("#ChooseFriendPoker").remove();
	if(findFangkuai4()=="B"){ShowOperate("B");//方块4在谁手上谁就可以优先出牌
	}else if(findFangkuai4()=="D"){ShowOperate("D");
	}else if(findFangkuai4()=="A"){ShowOperate("A");
	}else if(findFangkuai4()=="C"){ShowOperate("C");
	}
}
var clicknums=0;
function sort(){//变换排序方式
			clicknums++;
			console.log("clicknums========="+clicknums);
			if(clicknums%2==0){
				sort2();
			}else{
				sort1();
			}				
}	
	
function start(){//游戏开始
    ChoosePoker();	//选择扑克牌
	CreatChooseCard();//创建可选则叫朋友的扑克牌
    CreatCompeleteCard();//创建扑克牌、洗牌、发牌、排序
	setTimeout(function() { $("#start").remove(); });
	$(".ready").append("<button class='again'><a href='javascript:location.reload();'> 再来一局</a></button>");
	console.log("找到♦4了！————>在玩家"+findFangkuai4()+"手上");
	$("#first").append(findFangkuai4());
	$("#desk").prepend('<div class="ChooseFriend" id="ChooseFriend">请选择一张朋友牌<button class="confirm" onclick="ConfirmFriend()">确定</button></div>'+
	'<div class="ChooseFriendPoker" id="ChooseFriendPoker"></div>');
	for(var i=0;i<chooseImg.length;i++){
		$("#ChooseFriendPoker").append("<div class='poker' id='poker_"+i+"'><img id='"+chooseImg[i]+"'  src='img/"+chooseImg[i]+"'/></div>");
	}
	$("#ChooseFriendPoker").children().click(function () {//当id="ChooseFriendPoker"的子元素出现点击事件时
					if($(this).attr('class')=="poker"){//如果点击的这个元素它的类名为poker
				    $(this).removeClass("poker");//移除这个poker类名
				    $(this).addClass("active");//并且添加一个类名叫active
					$(this).siblings().removeClass();
					$(this).siblings().addClass("poker");
			}else if($(this).attr('class')=="active"){//如果点击的这个元素它的类名为active
				    $(this).removeClass("active");//移除这个active的类名
				    $(this).addClass("poker");//同时添加一个类名叫poker
					$(this).siblings().removeClass();
					$(this).siblings().addClass("poker");
			}
		    });
    	
		}

/****************  出  牌  ***************/

var pokers=[];//当前玩家手牌
		
	var lastplayer;//定义上家
	var nextplayer;//定义下家 
	var last_out=[];//定义上家出的牌
	var last_out_img=[];//定义上家出牌的img
	var out_img=[];//定义当前玩家出牌的img
	
	
	function getLastOutPokers(){//获取上家出的牌
		var last_out_pokers=$("#out_"+lastplayer+" .out_pokers");
			for(var i=0;i<last_out_pokers.length;i++){
				last_out.push(last_out_pokers[i].innerHTML);
				
			}console.log("111上家"+lastplayer+"出的牌是："+last_out);
			if(last_out.length==0){
				console.log("111上家"+lastplayer+"没有出牌");
				tmpArr.length=0;
				for(var i=0;i<out.length;i++){
					tmpArr.push(out[i]);
				}
				console.log("111最近一次玩家出牌："+tmpArr);
			}else{
				if(last_out.indexOf('<div class="PASS">不出</div>')>-1){
				console.log("222上家"+lastplayer+"选择不出牌!");	
				console.log("222最近一次玩家出牌："+tmpArr);
				}else{
					console.log("222上家"+lastplayer+"出的牌是：：：：：：：：：：：：：：：：："+last_out);
					tmpArr.length=0;
					for(var i=0;i<out.length;i++){
						if(tmpArr.indexOf(out[i])<=-1){
							tmpArr.push(out[i]);
						}
					}
					console.log("333最近一次玩家出牌："+tmpArr);
			}
		}
			console.log("66666上家出牌："+last_out.length+"当前出牌："+out.length);
		if(last_out.length==out.length||out.indexOf("<img id=\"43.jpg\" src=\"img/43.jpg\">")>-1&&out.length!=last_out.length){
			console.log("1111与上家出牌数量一致！");
			last_out.length=0;//清空上家出牌记录
			return 1;
		}else{
			return 0;
		}
		}
	function out_pokers(){
			$("#desk").append("<div class='out_"+player+"' id='out_"+player+"'></div>");
			for(var i=0;i<out.length;i++){
				$("#out_"+player).append("<div class='out_pokers' id='Poker"+player+"_"+i+"'>"+out[i]+"</div>");
				}
				$('button[class^="operate1"]').remove();//隐藏当前玩家出牌操作
				ShowOperate(nextplayer);//显示下家出牌操作区
				$("#"+player+" .active").remove();//在当前玩家手牌中删掉所出的牌
				console.log("♦4在："+findFangkuai4());
			if(findFangkuai4()=="out_"+nextplayer){//如果♦4在下家
				removeout();//隐藏本轮出牌记录
			}
			var outpokersimg=[];
					$("#out_"+player+" img").each(function(){
						console.log("出牌的玩家是"+player);
						console.log("出的牌是："+$(this).attr("id"));
						outpokersimg.push($(this).attr("id"));
						if($(this).attr("id")==$("#friendPoker").children().attr('id')){//如果出的牌跟叫的朋友牌相同，则判断该玩家为叫牌玩家的友方
							$("#friendPoker").append('<div class="myfriend">朋友：'+player+'</div>');
						}
					});
					 for(var i=0;i<outpokersimg.length;i++){
						 console.log("2删除的元素时："+outpokersimg[i]);
						 removepokers(player,outpokersimg[i]);
					 }
		}
function Out_Pokers(){
			$("#out_"+lastplayer+" img").each(function(){
				last_out_img.push($(this).attr('id'));
			});
			console.log("上家出牌的图片是："+last_out_img);
			$("#"+player+" img").each(function(){
				if($(this).parent().attr('class')=="active"){
						out_img.push($(this).attr('id'));
				}
			});
			console.log("当前玩家出牌的图片是："+out_img);
			var out_type,out_number,last_out_type,last_out_number;
			for(var i=0;i<arr.length;i++){
				if(out_img==arr[i].img){
					out_type=arr[i].type;
					out_number=arr[i].number;
				}else if(last_out_img==arr[i].img){
					last_out_type=arr[i].type;
					last_out_number=arr[i].number;
				}
			}
			if(last_out_type==undefined&&last_out_number==undefined){last_out_type=1;last_out_number=0;}
			console.log("当前玩家"+out_type+"*****"+out_number+"；上家："+last_out_type+"----"+last_out_number);
			if(out_type==last_out_type&&out_number>last_out_number){//花色相同，当前出牌数值比上家大
				out_pokers();
				return 1;
			}else if(out_number==last_out_number&&out_type>last_out_type){//数值相同，当前出牌花色比上家大
				out_pokers();
				return 1;
			}else{
					console.log("您选牌不符合规则，请重新选牌！");
				return;
			}
		}
function outpokers(){
						 if(document.getElementById("out_"+player)){//如果player出过牌（已经创建过id="out_B"的div元素）
						 if(getLastOutPokers()==1){
						 	console.log("222与上家出牌数量一致0000"+getLastOutPokers());
						     console.log(player+"已经出过牌！");
						     $('#out_'+player).remove();//清除出牌记录
						 	$('#out_'+player+' .out_pokers').remove();
							 if(Out_Pokers()==1){
								return 1; 
							 }
					 }else{
						return 0;
					 }
			}else{//如果当前玩家还没有出过牌
					 if(getLastOutPokers()==1){
					 		console.log("222(当前玩家还没有出过牌)与上家出牌数量一致...");
					 		//getLastOutPokers();
							console.log(player+"还没出过牌！");
						 if(Out_Pokers()==1){
						 	return 1; 
						 }
					 }else{
					 	return 0;
					 }
			}
		}
function out(player){//封装玩家出牌函数，player是字符，代表玩家"A"、"B"、"C"、"D"
var img=$("#"+player).children();
		for(var i=0;i<img.length;i++){
			pokers.push(img[i].innerHTML);
		}
	var out=[];//当前玩家选择出的牌
	id="#"+player+" .active";//获取当前玩家选中的扑克牌
	console.log("id="+id)
	var list = $(id);//获取所有选中的扑克
	for (var i = 0; i < list.length; i++) {
		//console.log(list[i].innerHTML); //innerHTML 属性设置或返回表格行的开始和结束标签之间的 HTML。
		out.push(list[i].innerHTML);
	}
	console.log("out"+player+"============"+out);
	console.log(player+"选择了："+out.length+"张牌");
	if(player=="A"){lastplayer="D";nextplayer="C";
	}else if(player=="B"){lastplayer="C";nextplayer="D";
	}else if(player=="C"){lastplayer="A";nextplayer="B";
	}else if(player=="D"){lastplayer="B";nextplayer="A";
	}
		if(out.length==1){//如果出1张牌
			out_one();
		}else if(out.length==2){//如果出2张牌
		out_two();
		}else if(out.length==3){//如果出3张牌
		out_three();	
		}else if(out.length==5){//如果出5张牌
		out_five();	
        }else if(out.length==4||out.length>5){
	    console.log("您选的牌不符合规则，选牌数量不对！");
		return;
	    }else{
		console.log("您还没选牌呢！");
		return;
	}
}
function removeout(){
	setTimeout(function( ){//隐藏本轮出牌记录
	HideOutPokers();
	},1000);
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