
function ChangeToArr(obj){
				var newArr=[];
				newArr.push(obj);
				console.log("把对象插入数组中：");
				console.log(newArr);
				console.log("(newArr[0].dawang="+newArr[0].dawang);
				return newArr;
			}

function start(){
	document.getElementById("operate").style.visibility="visible";//显示亮主牌选择区
				/**洗牌原理：
				sort 是对数组进行排序
				工作原理：1.每次从数组里面挑选两个数 进行运算。2.如果传入的参数是0两个数位置不变。
				3.如果参数小于0就交换位置。4.如果参数大于0就不交换位置。5.接下来用刚才的较大数字跟下一个进行比较。这样循环进行排序。
				6.利用这一点使用了0.5 - Math.random 这个运算的结果要么是大于0,要么是小于0.这样要么交换位置，要么不交换位置。
				当然大于或者小于0是随机出现的。所以数组就被随机排序了。**/
				//洗牌
				fourCards.sort(function() {
				     return (0.5-Math.random());
				})
				var A=[],B=[],C=[],D=[];
				//发牌
				for(var j=0;j<216;j++){
					if(A.length==B.length&&C.length==D.length&&A.length==C.length){
						A.push(fourCards[j]);
					}
					else if(A.length>B.length&&B.length==C.length&&C.length==D.length){
						B.push(fourCards[j]);
					}
					else if(A.length==B.length&&B.length>C.length&&C.length==D.length){
						C.push(fourCards[j]);
					}
					else if(A.length==B.length&&B.length==C.length&&C.length>D.length){
						D.push(fourCards[j]);
					}
					
				}

            sortType(A,"heitao")
			sortType(B,"heitao")
			sortType(C,"heitao")
			sortType(D,"heitao")
			console.log("A排序后：");
			console.log(A);
			console.log("B排序后：");
			console.log(sortType(B,"heitao"));
			console.log("C排序后：");
			console.log(sortType(C,"heitao"));
			console.log("D排序后：");
			console.log(sortType(D,"heitao"));	

				
			//亮主
			console.log("此时B的手牌是图标形式："+B);
			var dawangNum=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).dawang;//定义玩家B手牌中的大王张数
			console.log("此时B的手牌是拼音形式："+B);
			ChangeBeforeArr(B);//把手牌转换成图标形式
			console.log("此时B的手牌是图标形式："+B);
			var xiaowangNum=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).xiaowang;//定义玩家B手牌中的小王张数
			ChangeBeforeArr(B);//把手牌转换成图标形式
			var heitao2Num=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).heitao2;//定义玩家B手牌中的♠2张数
			ChangeBeforeArr(B);//把手牌转换成图标形式
			var hongtao2Num=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).hongtao2;//定义玩家B手牌中的♥2张数
			ChangeBeforeArr(B);//把手牌转换成图标形式
			var meihua2Num=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).meihua2;//定义玩家B手牌中的♣2张数
			ChangeBeforeArr(B);//把手牌转换成图标形式
			var fangkuai2Num=CountNum(ChangeArr(B),ChangeToArr(JSON.parse(ChangeArr(ChangeBeforeArr(B))))).fangkuai2;//定义玩家B手牌中的♦2张数
			ChangeBeforeArr(B);//把手牌转换成图标形式
			
			for(var x=0;x<54;x++){
			if(B[x]==newA[2]){document.getElementById("heitao").style.color="red";}
			else if(B[x]==newA[3]){document.getElementById("hongtao").style.color="red";}
			else if(B[x]==newA[4]){document.getElementById("meihua").style.color="red";}
			else if(B[x]==newA[5]){document.getElementById("fangkuai").style.color="red";}
			//如果获得四张大王或小王才有资格叫无主，几率比较小
			else if(dawangNum==4&&xiaowangNum<4){document.getElementById("dawang").style.color="red";}//dawangNum为玩家B获取大王的张数
			else if(xiaowangNum==4&&dawangNum<4){document.getElementById("xiaowang").style.color="red";}//xiaowangNum为玩家B获取小王的张数
			else if(xiaowangNum==4&&dawangNum==4){document.getElementById("xiaowang").style.color="red";document.getElementById("dawang").style.color="red";}}
			
			$('button').each(function () {
			if ($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="heitao") {//判断黑桃2是否为亮红，亮红才可以叫主
			$(this).click(function(){
			var num=[];
			for(var r=0;r<heitao2Num;r++){
			num.push("♠2");
			}
			document.getElementById("liangzhu").innerHTML=num;//亮主区显示多少张亮主
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			});}
			else if($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="hongtao"){//判断红桃2是否为亮红，亮红才可以叫主
			$("#hongtao").click(function(){
			var num=[];
			for(var r=0;r<NewB[0].hongtao2;r++){
			num.push("♥2");
			}	
			document.getElementById("liangzhu").innerHTML=num;	
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			for(var x=0;x<54;x++){
			if(B[x]==newA[0]){B[x]=54;}
			else if(B[x]==newA[1]){B[x]=53;}
			else if(B[x]==newA[3]){B[x]=52;}
			else if(B[x]==newA[2]){B[x]=51;}
			else if(B[x]==newA[4]){B[x]=50;}
			else if(B[x]==newA[5]){B[x]=49;}
			else if(B[x]==newA[7]){B[x]=48;}
			else if(B[x]==newA[6]){B[x]=47;}
			else if(B[x]==newA[8]){B[x]=46;}
			else if(B[x]==newA[9]){B[x]=45;}
			else if(B[x]==newA[11]){B[x]=44;}
			else if(B[x]==newA[10]){B[x]=43;}
			else if(B[x]==newA[12]){B[x]=42;}
			else if(B[x]==newA[13]){B[x]=41;}
			else if(B[x]==newA[15]){B[x]=40;}
			else if(B[x]==newA[14]){B[x]=39;}
			else if(B[x]==newA[16]){B[x]=38;}
			else if(B[x]==newA[17]){B[x]=37;}
			else if(B[x]==newA[19]){B[x]=36;}
			else if(B[x]==newA[18]){B[x]=35;}
			else if(B[x]==newA[20]){B[x]=34;}
			else if(B[x]==newA[21]){B[x]=33;}
			else if(B[x]==newA[23]){B[x]=32;}
			else if(B[x]==newA[22]){B[x]=31;}
			else if(B[x]==newA[24]){B[x]=30;}
			else if(B[x]==newA[25]){B[x]=29;}
			else if(B[x]==newA[27]){B[x]=28;}
			else if(B[x]==newA[26]){B[x]=27;}
			else if(B[x]==newA[28]){B[x]=26;}
			else if(B[x]==newA[29]){B[x]=25;}
			else if(B[x]==newA[31]){B[x]=24;}
			else if(B[x]==newA[30]){B[x]=23;}
			else if(B[x]==newA[32]){B[x]=22;}
			else if(B[x]==newA[33]){B[x]=21;}
			else if(B[x]==newA[35]){B[x]=20;}
			else if(B[x]==newA[34]){B[x]=19;}
			else if(B[x]==newA[36]){B[x]=18;}
			else if(B[x]==newA[37]){B[x]=17;}
			else if(B[x]==newA[39]){B[x]=16;}
			else if(B[x]==newA[38]){B[x]=15;}
			else if(B[x]==newA[40]){B[x]=14;}
			else if(B[x]==newA[41]){B[x]=13;}
			else if(B[x]==newA[43]){B[x]=12;}
			else if(B[x]==newA[42]){B[x]=11;}
			else if(B[x]==newA[44]){B[x]=10;}
			else if(B[x]==newA[45]){B[x]=9;}
			else if(B[x]==newA[47]){B[x]=8;}
			else if(B[x]==newA[46]){B[x]=7;}
			else if(B[x]==newA[48]){B[x]=6;}
			else if(B[x]==newA[49]){B[x]=5;}
			else if(B[x]==newA[51]){B[x]=4;}
			else if(B[x]==newA[50]){B[x]=3;}
			else if(B[x]==newA[52]){B[x]=2;}
			else if(B[x]==newA[53]){B[x]=1;}
			else {B[x]=0;}
			}
			var B1=B.sort(compare);
			console.log("B1=["+B1+"]");
			for(var m=0;m<54;m++){
				if(B1[m]==54){B1[m]="♚";}	
				else if(B1[m]==53){B1[m]="♖";}
				else if(B1[m]==52){B1[m]="♥2";}
				else if(B1[m]==51){B1[m]="♠2";}
				else if(B1[m]==50){B1[m]="♣2";}
				else if(B1[m]==49){B1[m]="♦2";}
				else if(B1[m]==48){B1[m]="♥A";}
				else if(B1[m]==47){B1[m]="♠A";}
				else if(B1[m]==46){B1[m]="♣A";}
				else if(B1[m]==45){B1[m]="♦A";}
				else if(B1[m]==44){B1[m]="♥K";}
				else if(B1[m]==43){B1[m]="♠K";}
				else if(B1[m]==42){B1[m]="♣K";}
				else if(B1[m]==41){B1[m]="♦K";}
				else if(B1[m]==40){B1[m]="♥Q";}
				else if(B1[m]==39){B1[m]="♠Q";}
				else if(B1[m]==38){B1[m]="♣Q";}
				else if(B1[m]==37){B1[m]="♦Q";}
				else if(B1[m]==36){B1[m]="♥J";}
				else if(B1[m]==35){B1[m]="♠J";}
				else if(B1[m]==34){B1[m]="♣J";}
				else if(B1[m]==33){B1[m]="♦J";}
				else if(B1[m]==32){B1[m]="♥10";}
				else if(B1[m]==31){B1[m]="♠10";}
				else if(B1[m]==30){B1[m]="♣10";}
				else if(B1[m]==29){B1[m]="♦10";}
				else if(B1[m]==28){B1[m]="♥9";}
				else if(B1[m]==27){B1[m]="♠9";}
				else if(B1[m]==26){B1[m]="♣9";}
				else if(B1[m]==25){B1[m]="♦9";}
				else if(B1[m]==24){B1[m]="♥8";}
				else if(B1[m]==23){B1[m]="♠8";}
				else if(B1[m]==22){B1[m]="♣8";}
				else if(B1[m]==21){B1[m]="♦8";}
				else if(B1[m]==20){B1[m]="♥7";}
				else if(B1[m]==19){B1[m]="♠7";}
				else if(B1[m]==18){B1[m]="♣7";}
				else if(B1[m]==17){B1[m]="♦7";}
				else if(B1[m]==16){B1[m]="♥6";}
				else if(B1[m]==15){B1[m]="♠6";}
				else if(B1[m]==14){B1[m]="♣6";}
				else if(B1[m]==13){B1[m]="♦6";}
				else if(B1[m]==12){B1[m]="♥5";}
				else if(B1[m]==11){B1[m]="♠5";}
				else if(B1[m]==10){B1[m]="♣5";}
				else if(B1[m]==9){B1[m]="♦5";}
				else if(B1[m]==8){B1[m]="♥4";}
				else if(B1[m]==7){B1[m]="♠4";}
				else if(B1[m]==6){B1[m]="♣4";}
				else if(B1[m]==5){B1[m]="♦4";}
				else if(B1[m]==4){B1[m]="♥3";}
				else if(B1[m]==3){B1[m]="♠3";}
				else if(B1[m]==2){B1[m]="♣3";}
				else if(B1[m]==1){B1[m]="♦3";}
				else{B1[m]="";}
			}
			console.log("B1="+B1);
			});}
			else if($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="meihua"){//判断梅花2是否为亮红，亮红才可以叫主
			$("#meihua").click(function(){
			var num=[];
			for(var r=0;r<NewB[0].meihua2;r++){
			num.push("♣2");
			}	
			document.getElementById("liangzhu").innerHTML=num;
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			});}
			else if($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="fangkuai"){//判断方块2是否为亮红，亮红才可以叫主
			$("#fangkuai").click(function(){
			var num=[];
			for(var r=0;r<NewB[0].fangkuai2;r++){
			num.push("♦2");
			}	
			document.getElementById("liangzhu").innerHTML=num;
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			
			});}
			else if($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="dawang"){//判断大王是否为亮红，亮红才可以叫主
			$("#dawang").click(function(){
			document.getElementById("liangzhu").innerHTML="♚♚♚♚";
			document.getElementById("dawang").style.color="black";	
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			});}
			else if($(this).css('color') === 'rgb(255, 0, 0)'&&this.id=="xiaowang"){//判断小王是否为亮红，亮红才可以叫主
			$("#xiaowang").click(function(){
			document.getElementById("liangzhu").innerHTML="♖♖♖♖";
			document.getElementById("dawang").style.color="black";	
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			$('button').attr("disabled", "disabled");//亮主后所有按钮不能再点，只能叫主一次
			});}
			});
				
			


				document.getElementById("A").innerHTML=A;
				document.getElementById("B").innerHTML=B;
				document.getElementById("C").innerHTML=C;
				document.getElementById("D").innerHTML=D;
				
				
			}