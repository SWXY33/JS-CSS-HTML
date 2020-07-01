var newA=[];
				newA[0]="♚",newA[1]="♖",newA[2]="♠2",newA[3]="♥2",newA[4]="♣2",newA[5]="♦2",newA[6]="♠A",newA[7]="♥A",
				newA[8]="♣A",newA[9]="♦A",newA[10]="♠K",newA[11]="♥K",newA[12]="♣K",newA[13]="♦K",newA[14]="♠Q",newA[15]="♥Q",
				newA[16]="♣Q",newA[17]="♦Q",newA[18]="♠J",newA[19]="♥J",newA[20]="♣J",newA[21]="♦J",newA[22]="♠10",newA[23]="♥10",
				newA[24]="♣10",newA[25]="♦10",newA[26]="♠9",newA[27]="♥9",newA[28]="♣9",newA[29]="♦9",newA[30]="♠8",newA[31]="♥8",
				newA[32]="♣8",newA[33]="♦8",newA[34]="♠7",newA[35]="♥7",newA[36]="♣7",newA[37]="♦7",newA[38]="♠6",newA[39]="♥6",
				newA[40]="♣6",newA[41]="♦6",newA[42]="♠5",newA[43]="♥5",newA[44]="♣5",newA[45]="♦5",newA[46]="♠4",newA[47]="♥4",
				newA[48]="♣4",newA[49]="♦4",newA[50]="♠3",newA[51]="♥3",newA[52]="♣3",newA[53]="♦3";
function getType(e){//该方法可以判断某张牌的花色类型
	if(e==newA[0]){return "dawang";//大王
	}else if(e==newA[1]){return "xiaowang";}//小王
	else if(e==newA[2]||e==newA[6]||e==newA[10]||e==newA[14]||e==newA[18]||e==newA[22]||e==newA[26]||e==newA[30]||e==newA[34]||e==newA[38]||e==newA[42]||e==newA[46]
	||e==newA[50]){return "heitao";}//♠
	else if(e==newA[3]||e==newA[7]||e==newA[11]||e==newA[15]||e==newA[19]||e==newA[23]||e==newA[27]||e==newA[31]||e==newA[35]||e==newA[39]||e==newA[43]||e==newA[47]
	||e==newA[51]){return "hongtao";}//♥
	else if(e==newA[4]||e==newA[8]||e==newA[12]||e==newA[16]||e==newA[20]||e==newA[24]||e==newA[28]||e==newA[32]||e==newA[36]||e==newA[40]||e==newA[44]||e==newA[48]
	||e==newA[52]){return "meihua";}//♣
	else if(e==newA[5]||e==newA[9]||e==newA[13]||e==newA[17]||e==newA[21]||e==newA[25]||e==newA[29]||e==newA[33]||e==newA[37]||e==newA[41]||e==newA[45]||e==newA[49]
	||e==newA[53]){return "fangkuai";}//♦
}



var type = ['♠','♥','♣','♦'];//牌类型
				var L = ['♚'];//大王
				var S = ['♖'];//小王
				var number = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];//牌数
				var heitao = [];//黑桃
				var hongtao = [];//红桃
				var meihua = [];//梅花
				var fangkuai = [];//方块
				var oneCards=[];//一副牌
				var fourCards=[];//四副牌
				for(var i=0;i<=12;i++){
				heitao.push(type[0]+number[i]);//黑桃
				hongtao.push(type[1]+number[i]);//红桃
				meihua.push(type[2]+number[i]);//梅花
				fangkuai.push(type[3]+number[i]);//方块
				}
				oneCards.push(L);//在一副牌中存大王
				oneCards.push(S);//在一副牌中存小王
				
				for(var n=0;n<13;n++){//一副牌
					oneCards.push(heitao[n]);//在一副牌中存黑桃
					oneCards.push(hongtao[n]);
					oneCards.push(meihua[n]);
					oneCards.push(fangkuai[n]);
				}
				for(var m=0;m<54;m++){//四副牌
					for(var a=1;a<=4;a++){
				        fourCards.push(oneCards[m]);
				    }
				}
				console.log(heitao);
				console.log(hongtao);
				console.log(meihua);
				console.log(fangkuai);
				console.log("一副牌:"+oneCards+"一副牌张数："+oneCards.length);
				console.log("四副牌："+fourCards+"四副牌张数："+fourCards.length);

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
				console.log("A:"+A);
				console.log("B:"+B);
				console.log("C:"+C);
				console.log("D:"+D);
//玩家扑克牌排序
				var compare = function (x, y) {//比较函数
					return y-x;
				}
				
				
function sortType(arr,type){//扑克牌按花色排序
	if(type=="dawang"||type=="xiaowang"||type=="heitao"){//如果亮主为大王或小王或黑桃，花色排序为♚>♖>♠>♥>♣>♦
		for(var i=0;i<arr.length;i++){
			if(arr[i]==newA[0]){arr[i]=54;}//♚
			else if(arr[i]==newA[1]){arr[i]=53;}//♖
			else if(arr[i]==newA[2]){arr[i]=52;}//♠2
			else if(arr[i]==newA[3]){arr[i]=51;}//♥2
			else if(arr[i]==newA[4]){arr[i]=50;}//♣2
			else if(arr[i]==newA[5]){arr[i]=49;}//♦2
			else if(arr[i]==newA[6]){arr[i]=48;}//♠A
			else if(arr[i]==newA[10]){arr[i]=47;}//♠K
			else if(arr[i]==newA[14]){arr[i]=46;}//♠Q
			else if(arr[i]==newA[18]){arr[i]=45;}//♠J
			else if(arr[i]==newA[22]){arr[i]=44;}//♠10
			else if(arr[i]==newA[26]){arr[i]=43;}//♠9
			else if(arr[i]==newA[30]){arr[i]=42;}//♠8
			else if(arr[i]==newA[34]){arr[i]=41;}//♠7
			else if(arr[i]==newA[38]){arr[i]=40;}//♠6
			else if(arr[i]==newA[42]){arr[i]=39;}//♠5
			else if(arr[i]==newA[46]){arr[i]=38;}//♠4
			else if(arr[i]==newA[50]){arr[i]=37;}//♠3
			else if(arr[i]==newA[7]){arr[i]=36;}//♥A
			else if(arr[i]==newA[11]){arr[i]=35;}//♥K
			else if(arr[i]==newA[15]){arr[i]=34;}//♥Q
			else if(arr[i]==newA[19]){arr[i]=33;}//♥J
			else if(arr[i]==newA[23]){arr[i]=32;}//♥10
			else if(arr[i]==newA[27]){arr[i]=31;}//♥9
			else if(arr[i]==newA[31]){arr[i]=30;}//♥8
			else if(arr[i]==newA[35]){arr[i]=29;}//♥7
			else if(arr[i]==newA[39]){arr[i]=28;}//♥6
			else if(arr[i]==newA[43]){arr[i]=27;}//♥5
			else if(arr[i]==newA[47]){arr[i]=26;}//♥4
			else if(arr[i]==newA[51]){arr[i]=25;}//♥3
			else if(arr[i]==newA[8]){arr[i]=24;}//♣A
			else if(arr[i]==newA[12]){arr[i]=23;}//♣K
			else if(arr[i]==newA[16]){arr[i]=22;}//♣Q
			else if(arr[i]==newA[20]){arr[i]=21;}//♣J
			else if(arr[i]==newA[24]){arr[i]=20;}//♣10
			else if(arr[i]==newA[28]){arr[i]=19;}//♣9
			else if(arr[i]==newA[32]){arr[i]=18;}//♣8
			else if(arr[i]==newA[36]){arr[i]=17;}//♣7
			else if(arr[i]==newA[40]){arr[i]=16;}//♣6
			else if(arr[i]==newA[44]){arr[i]=15;}//♣5
			else if(arr[i]==newA[48]){arr[i]=14;}//♣4
			else if(arr[i]==newA[52]){arr[i]=13;}//♣3
			else if(arr[i]==newA[9]){arr[i]=12;}//♦A
			else if(arr[i]==newA[13]){arr[i]=11;}//♦K
			else if(arr[i]==newA[17]){arr[i]=10;}//♦Q
			else if(arr[i]==newA[21]){arr[i]=9;}//♦J
			else if(arr[i]==newA[25]){arr[i]=8;}//♦10
			else if(arr[i]==newA[29]){arr[i]=7;}//♦9
			else if(arr[i]==newA[33]){arr[i]=6;}//♦8
			else if(arr[i]==newA[37]){arr[i]=5;}//♦7
			else if(arr[i]==newA[41]){arr[i]=4;}//♦6
			else if(arr[i]==newA[45]){arr[i]=3;}//♦5
			else if(arr[i]==newA[49]){arr[i]=2;}//♦4
			else if(arr[i]==newA[53]){arr[i]=1;}//♦3
		}
		var arr1=arr.sort(compare);//按照花色等级先后及牌数大小排序
		for(var m=0;m<54;m++){
			if(arr1[m]==54){arr1[m]="♚";}	
			else if(arr1[m]==53){arr1[m]="♖";}
			else if(arr1[m]==52){arr1[m]="♠2";}
			else if(arr1[m]==51){arr1[m]="♥2";}
			else if(arr1[m]==50){arr1[m]="♣2";}
			else if(arr1[m]==49){arr1[m]="♦2";}
			else if(arr1[m]==48){arr1[m]="♠A";}
			else if(arr1[m]==36){arr1[m]="♥A";}
			else if(arr1[m]==24){arr1[m]="♣A";}
			else if(arr1[m]==12){arr1[m]="♦A";}
			else if(arr1[m]==47){arr1[m]="♠K";}
			else if(arr1[m]==35){arr1[m]="♥K";}
			else if(arr1[m]==23){arr1[m]="♣K";}
			else if(arr1[m]==11){arr1[m]="♦K";}
			else if(arr1[m]==46){arr1[m]="♠Q";}
			else if(arr1[m]==34){arr1[m]="♥Q";}
			else if(arr1[m]==22){arr1[m]="♣Q";}
			else if(arr1[m]==10){arr1[m]="♦Q";}
			else if(arr1[m]==45){arr1[m]="♠J";}
			else if(arr1[m]==33){arr1[m]="♥J";}
			else if(arr1[m]==21){arr1[m]="♣J";}
			else if(arr1[m]==9){arr1[m]="♦J";}
			else if(arr1[m]==44){arr1[m]="♠10";}
			else if(arr1[m]==32){arr1[m]="♥10";}
			else if(arr1[m]==20){arr1[m]="♣10";}
			else if(arr1[m]==8){arr1[m]="♦10";}
			else if(arr1[m]==43){arr1[m]="♠9";}
			else if(arr1[m]==31){arr1[m]="♥9";}
			else if(arr1[m]==19){arr1[m]="♣9";}
			else if(arr1[m]==7){arr1[m]="♦9";}
			else if(arr1[m]==42){arr1[m]="♠8";}
			else if(arr1[m]==30){arr1[m]="♥8";}
			else if(arr1[m]==18){arr1[m]="♣8";}
			else if(arr1[m]==6){arr1[m]="♦8";}
			else if(arr1[m]==41){arr1[m]="♠7";}
			else if(arr1[m]==29){arr1[m]="♥7";}
			else if(arr1[m]==17){arr1[m]="♣7";}
			else if(arr1[m]==5){arr1[m]="♦7";}
			else if(arr1[m]==40){arr1[m]="♠6";}
			else if(arr1[m]==28){arr1[m]="♥6";}
			else if(arr1[m]==16){arr1[m]="♣6";}
			else if(arr1[m]==4){arr1[m]="♦6";}
			else if(arr1[m]==39){arr1[m]="♠5";}
			else if(arr1[m]==27){arr1[m]="♥5";}
			else if(arr1[m]==15){arr1[m]="♣5";}
			else if(arr1[m]==3){arr1[m]="♦5";}
			else if(arr1[m]==38){arr1[m]="♠4";}
			else if(arr1[m]==26){arr1[m]="♥4";}
			else if(arr1[m]==14){arr1[m]="♣4";}
			else if(arr1[m]==2){arr1[m]="♦4";}
			else if(arr1[m]==37){arr1[m]="♠3";}
			else if(arr1[m]==25){arr1[m]="♥3";}
			else if(arr1[m]==13){arr1[m]="♣3";}
			else if(arr1[m]==1){arr1[m]="♦3";}
			else{arr1[m]="";}
	}
	return arr1;//返回排序后的数组
}
else if(type=="hongtao"){
	for(var i=0;i<arr.length;i++){
		if(arr[i]==newA[0]){arr[i]=54;}//♚
		else if(arr[i]==newA[1]){arr[i]=53;}//♖
		else if(arr[i]==newA[3]){arr[i]=52;}//♥2
		else if(arr[i]==newA[2]){arr[i]=51;}//♠2
		else if(arr[i]==newA[4]){arr[i]=50;}//♣2
		else if(arr[i]==newA[5]){arr[i]=49;}//♦2
		else if(arr[i]==newA[8]){arr[i]=48;}//♣A
		else if(arr[i]==newA[12]){arr[i]=47;}//♣K
		else if(arr[i]==newA[16]){arr[i]=46;}//♣Q
		else if(arr[i]==newA[20]){arr[i]=45;}//♣J
		else if(arr[i]==newA[24]){arr[i]=44;}//♣10
		else if(arr[i]==newA[28]){arr[i]=43;}//♣9
		else if(arr[i]==newA[32]){arr[i]=42;}//♣8
		else if(arr[i]==newA[36]){arr[i]=41;}//♣7
		else if(arr[i]==newA[40]){arr[i]=40;}//♣6
		else if(arr[i]==newA[44]){arr[i]=39;}//♣5
		else if(arr[i]==newA[48]){arr[i]=38;}//♣4
		else if(arr[i]==newA[52]){arr[i]=37;}//♣3
		else if(arr[i]==newA[6]){arr[i]=36;}//♠A
		else if(arr[i]==newA[10]){arr[i]=35;}//♠K
		else if(arr[i]==newA[14]){arr[i]=34;}//♠Q
		else if(arr[i]==newA[18]){arr[i]=33;}//♠J
		else if(arr[i]==newA[22]){arr[i]=32;}//♠10
		else if(arr[i]==newA[26]){arr[i]=31;}//♠9
		else if(arr[i]==newA[30]){arr[i]=30;}//♠8
		else if(arr[i]==newA[34]){arr[i]=29;}//♠7
		else if(arr[i]==newA[38]){arr[i]=28;}//♠6
		else if(arr[i]==newA[42]){arr[i]=27;}//♠5
		else if(arr[i]==newA[46]){arr[i]=26;}//♠4
		else if(arr[i]==newA[50]){arr[i]=25;}//♠3
		else if(arr[i]==newA[7]){arr[i]=24;}//♥A
		else if(arr[i]==newA[11]){arr[i]=23;}//♥K
		else if(arr[i]==newA[15]){arr[i]=22;}//♥Q
		else if(arr[i]==newA[19]){arr[i]=21;}//♥J
		else if(arr[i]==newA[23]){arr[i]=20;}//♥10
		else if(arr[i]==newA[27]){arr[i]=19;}//♥9
		else if(arr[i]==newA[31]){arr[i]=18;}//♥8
		else if(arr[i]==newA[35]){arr[i]=17;}//♥7
		else if(arr[i]==newA[39]){arr[i]=16;}//♥6
		else if(arr[i]==newA[43]){arr[i]=15;}//♥5
		else if(arr[i]==newA[47]){arr[i]=14;}//♥4
		else if(arr[i]==newA[51]){arr[i]=13;}//♥3
		else if(arr[i]==newA[9]){arr[i]=12;}//♦A
		else if(arr[i]==newA[13]){arr[i]=11;}//♦K
		else if(arr[i]==newA[17]){arr[i]=10;}//♦Q
		else if(arr[i]==newA[21]){arr[i]=9;}//♦J
		else if(arr[i]==newA[25]){arr[i]=8;}//♦10
		else if(arr[i]==newA[29]){arr[i]=7;}//♦9
		else if(arr[i]==newA[33]){arr[i]=6;}//♦8
		else if(arr[i]==newA[37]){arr[i]=5;}//♦7
		else if(arr[i]==newA[41]){arr[i]=4;}//♦6
		else if(arr[i]==newA[45]){arr[i]=3;}//♦5
		else if(arr[i]==newA[49]){arr[i]=2;}//♦4
		else if(arr[i]==newA[53]){arr[i]=1;}//♦3
	}
	var arr1=arr.sort(compare);//按照花色等级先后及牌数大小排序
		for(var m=0;m<54;m++){
			if(arr1[m]==54){arr1[m]="♚";}	
			else if(arr1[m]==53){arr1[m]="♖";}
			else if(arr1[m]==52){arr1[m]="♥2";}
			else if(arr1[m]==51){arr1[m]="♠2";}
			else if(arr1[m]==50){arr1[m]="♣2";}
			else if(arr1[m]==49){arr1[m]="♦2";}
			else if(arr1[m]==48){arr1[m]="♥A";}
			else if(arr1[m]==36){arr1[m]="♠A";}
			else if(arr1[m]==24){arr1[m]="♣A";}
			else if(arr1[m]==12){arr1[m]="♦A";}
			else if(arr1[m]==47){arr1[m]="♥K";}
			else if(arr1[m]==35){arr1[m]="♠K";}
			else if(arr1[m]==23){arr1[m]="♣K";}
			else if(arr1[m]==11){arr1[m]="♦K";}
			else if(arr1[m]==46){arr1[m]="♥Q";}
			else if(arr1[m]==34){arr1[m]="♠Q";}
			else if(arr1[m]==22){arr1[m]="♣Q";}
			else if(arr1[m]==10){arr1[m]="♦Q";}
			else if(arr1[m]==45){arr1[m]="♥J";}
			else if(arr1[m]==33){arr1[m]="♠J";}
			else if(arr1[m]==21){arr1[m]="♣J";}
			else if(arr1[m]==9){arr1[m]="♦J";}
			else if(arr1[m]==44){arr1[m]="♥10";}
			else if(arr1[m]==32){arr1[m]="♠10";}
			else if(arr1[m]==20){arr1[m]="♣10";}
			else if(arr1[m]==8){arr1[m]="♦10";}
			else if(arr1[m]==43){arr1[m]="♥9";}
			else if(arr1[m]==31){arr1[m]="♠9";}
			else if(arr1[m]==19){arr1[m]="♣9";}
			else if(arr1[m]==7){arr1[m]="♦9";}
			else if(arr1[m]==42){arr1[m]="♥8";}
			else if(arr1[m]==30){arr1[m]="♠8";}
			else if(arr1[m]==18){arr1[m]="♣8";}
			else if(arr1[m]==6){arr1[m]="♦8";}
			else if(arr1[m]==41){arr1[m]="♥7";}
			else if(arr1[m]==29){arr1[m]="♠7";}
			else if(arr1[m]==17){arr1[m]="♣7";}
			else if(arr1[m]==5){arr1[m]="♦7";}
			else if(arr1[m]==40){arr1[m]="♥6";}
			else if(arr1[m]==28){arr1[m]="♠6";}
			else if(arr1[m]==16){arr1[m]="♣6";}
			else if(arr1[m]==4){arr1[m]="♦6";}
			else if(arr1[m]==39){arr1[m]="♥5";}
			else if(arr1[m]==27){arr1[m]="♠5";}
			else if(arr1[m]==15){arr1[m]="♣5";}
			else if(arr1[m]==3){arr1[m]="♦5";}
			else if(arr1[m]==38){arr1[m]="♥4";}
			else if(arr1[m]==26){arr1[m]="♠4";}
			else if(arr1[m]==14){arr1[m]="♣4";}
			else if(arr1[m]==2){arr1[m]="♦4";}
			else if(arr1[m]==37){arr1[m]="♥3";}
			else if(arr1[m]==25){arr1[m]="♠3";}
			else if(arr1[m]==13){arr1[m]="♣3";}
			else if(arr1[m]==1){arr1[m]="♦3";}
			else{arr1[m]="";}
	}
	return arr1;//返回排序后的数组
}
else if(type=="meihua"){
for(var i=0;i<arr.length;i++){
		if(arr[i]==newA[0]){arr[i]=54;}//♚
		else if(arr[i]==newA[1]){arr[i]=53;}//♖
		else if(arr[i]==newA[4]){arr[i]=52;}//♣2
		else if(arr[i]==newA[2]){arr[i]=51;}//♠2
		else if(arr[i]==newA[3]){arr[i]=50;}//♥2
		else if(arr[i]==newA[5]){arr[i]=49;}//♦2
		else if(arr[i]==newA[7]){arr[i]=48;}//♥A
		else if(arr[i]==newA[11]){arr[i]=47;}//♥K
		else if(arr[i]==newA[15]){arr[i]=46;}//♥Q
		else if(arr[i]==newA[19]){arr[i]=45;}//♥J
		else if(arr[i]==newA[23]){arr[i]=44;}//♥10
		else if(arr[i]==newA[27]){arr[i]=43;}//♥9
		else if(arr[i]==newA[31]){arr[i]=42;}//♥8
		else if(arr[i]==newA[35]){arr[i]=41;}//♥7
		else if(arr[i]==newA[39]){arr[i]=40;}//♥6
		else if(arr[i]==newA[43]){arr[i]=39;}//♥5
		else if(arr[i]==newA[47]){arr[i]=38;}//♥4
		else if(arr[i]==newA[51]){arr[i]=37;}//♥3
		else if(arr[i]==newA[6]){arr[i]=35;}//♠A
		else if(arr[i]==newA[10]){arr[i]=34;}//♠K
		else if(arr[i]==newA[14]){arr[i]=34;}//♠Q
		else if(arr[i]==newA[18]){arr[i]=33;}//♠J
		else if(arr[i]==newA[22]){arr[i]=32;}//♠10
		else if(arr[i]==newA[26]){arr[i]=31;}//♠9
		else if(arr[i]==newA[30]){arr[i]=30;}//♠8
		else if(arr[i]==newA[34]){arr[i]=29;}//♠7
		else if(arr[i]==newA[38]){arr[i]=28;}//♠6
		else if(arr[i]==newA[42]){arr[i]=27;}//♠5
		else if(arr[i]==newA[46]){arr[i]=26;}//♠4
		else if(arr[i]==newA[50]){arr[i]=25;}//♠3
		else if(arr[i]==newA[8]){arr[i]=24;}//♣A
		else if(arr[i]==newA[12]){arr[i]=23;}//♣K
		else if(arr[i]==newA[16]){arr[i]=22;}//♣Q
		else if(arr[i]==newA[20]){arr[i]=21;}//♣J
		else if(arr[i]==newA[24]){arr[i]=20;}//♣10
		else if(arr[i]==newA[28]){arr[i]=19;}//♣9
		else if(arr[i]==newA[32]){arr[i]=18;}//♣8
		else if(arr[i]==newA[36]){arr[i]=17;}//♣7
		else if(arr[i]==newA[40]){arr[i]=16;}//♣6
		else if(arr[i]==newA[44]){arr[i]=15;}//♣5
		else if(arr[i]==newA[48]){arr[i]=14;}//♣4
		else if(arr[i]==newA[52]){arr[i]=13;}//♣3
		else if(arr[i]==newA[9]){arr[i]=12;}//♦A
		else if(arr[i]==newA[13]){arr[i]=11;}//♦K
		else if(arr[i]==newA[17]){arr[i]=10;}//♦Q
		else if(arr[i]==newA[21]){arr[i]=9;}//♦J
		else if(arr[i]==newA[25]){arr[i]=8;}//♦10
		else if(arr[i]==newA[29]){arr[i]=7;}//♦9
		else if(arr[i]==newA[33]){arr[i]=6;}//♦8
		else if(arr[i]==newA[37]){arr[i]=5;}//♦7
		else if(arr[i]==newA[41]){arr[i]=4;}//♦6
		else if(arr[i]==newA[45]){arr[i]=3;}//♦5
		else if(arr[i]==newA[49]){arr[i]=2;}//♦4
		else if(arr[i]==newA[53]){arr[i]=1;}//♦3
	}
	var arr1=arr.sort(compare);//按照花色等级先后及牌数大小排序	
	for(var m=0;m<54;m++){
			if(arr1[m]==54){arr1[m]="♚";}	
			else if(arr1[m]==53){arr1[m]="♖";}
			else if(arr1[m]==52){arr1[m]="♣2";}
			else if(arr1[m]==51){arr1[m]="♠2";}
			else if(arr1[m]==50){arr1[m]="♥2";}
			else if(arr1[m]==49){arr1[m]="♦2";}
			else if(arr1[m]==48){arr1[m]="♣A";}
			else if(arr1[m]==36){arr1[m]="♠A";}
			else if(arr1[m]==24){arr1[m]="♥A";}
			else if(arr1[m]==12){arr1[m]="♦A";}
			else if(arr1[m]==47){arr1[m]="♣K";}
			else if(arr1[m]==35){arr1[m]="♠K";}
			else if(arr1[m]==23){arr1[m]="♥K";}
			else if(arr1[m]==11){arr1[m]="♦K";}
			else if(arr1[m]==46){arr1[m]="♣Q";}
			else if(arr1[m]==34){arr1[m]="♠Q";}
			else if(arr1[m]==22){arr1[m]="♥Q";}
			else if(arr1[m]==10){arr1[m]="♦Q";}
			else if(arr1[m]==45){arr1[m]="♣J";}
			else if(arr1[m]==33){arr1[m]="♠J";}
			else if(arr1[m]==21){arr1[m]="♥J";}
			else if(arr1[m]==9){arr1[m]="♦J";}
			else if(arr1[m]==44){arr1[m]="♣10";}
			else if(arr1[m]==32){arr1[m]="♠10";}
			else if(arr1[m]==20){arr1[m]="♥10";}
			else if(arr1[m]==8){arr1[m]="♦10";}
			else if(arr1[m]==43){arr1[m]="♣9";}
			else if(arr1[m]==31){arr1[m]="♠9";}
			else if(arr1[m]==19){arr1[m]="♥9";}
			else if(arr1[m]==7){arr1[m]="♦9";}
			else if(arr1[m]==42){arr1[m]="♣8";}
			else if(arr1[m]==30){arr1[m]="♠8";}
			else if(arr1[m]==18){arr1[m]="♥8";}
			else if(arr1[m]==6){arr1[m]="♦8";}
			else if(arr1[m]==41){arr1[m]="♣7";}
			else if(arr1[m]==29){arr1[m]="♠7";}
			else if(arr1[m]==17){arr1[m]="♥7";}
			else if(arr1[m]==5){arr1[m]="♦7";}
			else if(arr1[m]==40){arr1[m]="♣6";}
			else if(arr1[m]==28){arr1[m]="♠6";}
			else if(arr1[m]==16){arr1[m]="♥6";}
			else if(arr1[m]==4){arr1[m]="♦6";}
			else if(arr1[m]==39){arr1[m]="♣5";}
			else if(arr1[m]==27){arr1[m]="♠5";}
			else if(arr1[m]==15){arr1[m]="♥5";}
			else if(arr1[m]==3){arr1[m]="♦5";}
			else if(arr1[m]==38){arr1[m]="♣4";}
			else if(arr1[m]==26){arr1[m]="♠4";}
			else if(arr1[m]==14){arr1[m]="♥4";}
			else if(arr1[m]==2){arr1[m]="♦4";}
			else if(arr1[m]==37){arr1[m]="♣3";}
			else if(arr1[m]==25){arr1[m]="♠3";}
			else if(arr1[m]==13){arr1[m]="♥3";}
			else if(arr1[m]==1){arr1[m]="♦3";}
			else{arr1[m]="";}
	}
	return arr1;
}
else if(type=="fangkuai"){
	for(var i=0;i<arr.length;i++){
		if(arr[i]==newA[0]){arr[i]=54;}//♚
		else if(arr[i]==newA[1]){arr[i]=53;}//♖
		else if(arr[i]==newA[5]){arr[i]=52;}//♦2
		else if(arr[i]==newA[2]){arr[i]=41;}//♠2
		else if(arr[i]==newA[3]){arr[i]=50;}//♥2
		else if(arr[i]==newA[4]){arr[i]=49;}//♣2
		else if(arr[i]==newA[9]){arr[i]=48;}//♦A
		else if(arr[i]==newA[13]){arr[i]=47;}//♦K
		else if(arr[i]==newA[17]){arr[i]=46;}//♦Q
		else if(arr[i]==newA[21]){arr[i]=45;}//♦J
		else if(arr[i]==newA[25]){arr[i]=44;}//♦10
		else if(arr[i]==newA[29]){arr[i]=43;}//♦9
		else if(arr[i]==newA[33]){arr[i]=42;}//♦8
		else if(arr[i]==newA[37]){arr[i]=41;}//♦7
		else if(arr[i]==newA[41]){arr[i]=40;}//♦6
		else if(arr[i]==newA[45]){arr[i]=39;}//♦5
		else if(arr[i]==newA[49]){arr[i]=38;}//♦4
		else if(arr[i]==newA[53]){arr[i]=37;}//♦3
		else if(arr[i]==newA[6]){arr[i]=36;}//♠A
		else if(arr[i]==newA[10]){arr[i]=35;}//♠K
		else if(arr[i]==newA[14]){arr[i]=34;}//♠Q
		else if(arr[i]==newA[18]){arr[i]=33;}//♠J
		else if(arr[i]==newA[22]){arr[i]=32;}//♠10
		else if(arr[i]==newA[26]){arr[i]=31;}//♠9
		else if(arr[i]==newA[30]){arr[i]=30;}//♠8
		else if(arr[i]==newA[34]){arr[i]=29;}//♠7
		else if(arr[i]==newA[38]){arr[i]=28;}//♠6
		else if(arr[i]==newA[42]){arr[i]=27;}//♠5
		else if(arr[i]==newA[46]){arr[i]=26;}//♠4
		else if(arr[i]==newA[50]){arr[i]=25;}//♠3
		else if(arr[i]==newA[7]){arr[i]=24;}//♥A
		else if(arr[i]==newA[11]){arr[i]=23;}//♥K
		else if(arr[i]==newA[15]){arr[i]=22;}//♥Q
		else if(arr[i]==newA[19]){arr[i]=21;}//♥J
		else if(arr[i]==newA[23]){arr[i]=20;}//♥10
		else if(arr[i]==newA[27]){arr[i]=19;}//♥9
		else if(arr[i]==newA[31]){arr[i]=18;}//♥8
		else if(arr[i]==newA[35]){arr[i]=17;}//♥7
		else if(arr[i]==newA[39]){arr[i]=16;}//♥6
		else if(arr[i]==newA[43]){arr[i]=15;}//♥5
		else if(arr[i]==newA[47]){arr[i]=14;}//♥4
		else if(arr[i]==newA[51]){arr[i]=13;}//♥3
		else if(arr[i]==newA[8]){arr[i]=12;}//♣A
		else if(arr[i]==newA[12]){arr[i]=11;}//♣K
		else if(arr[i]==newA[16]){arr[i]=10;}//♣Q
		else if(arr[i]==newA[20]){arr[i]=9;}//♣J
		else if(arr[i]==newA[24]){arr[i]=8;}//♣10
		else if(arr[i]==newA[28]){arr[i]=7;}//♣9
		else if(arr[i]==newA[32]){arr[i]=6;}//♣8
		else if(arr[i]==newA[36]){arr[i]=5;}//♣7
		else if(arr[i]==newA[40]){arr[i]=4;}//♣6
		else if(arr[i]==newA[44]){arr[i]=3;}//♣5
		else if(arr[i]==newA[48]){arr[i]=2;}//♣4
		else if(arr[i]==newA[52]){arr[i]=1;}//♣3
		
	}
	var arr1=arr.sort(compare);//按照花色等级先后及牌数大小排序
		for(var m=0;m<54;m++){
			if(arr1[m]==54){arr1[m]="♚";}	
			else if(arr1[m]==53){arr1[m]="♖";}
			else if(arr1[m]==52){arr1[m]="♦2";}
			else if(arr1[m]==51){arr1[m]="♠2";}
			else if(arr1[m]==50){arr1[m]="♥2";}
			else if(arr1[m]==49){arr1[m]="♣2";}
			else if(arr1[m]==48){arr1[m]="♦A";}
			else if(arr1[m]==36){arr1[m]="♠A";}
			else if(arr1[m]==24){arr1[m]="♥A";}
			else if(arr1[m]==12){arr1[m]="♣A";}
			else if(arr1[m]==47){arr1[m]="♦K";}
			else if(arr1[m]==35){arr1[m]="♠K";}
			else if(arr1[m]==23){arr1[m]="♥K";}
			else if(arr1[m]==11){arr1[m]="♣K";}
			else if(arr1[m]==46){arr1[m]="♦Q";}
			else if(arr1[m]==34){arr1[m]="♠Q";}
			else if(arr1[m]==22){arr1[m]="♥Q";}
			else if(arr1[m]==10){arr1[m]="♣Q";}
			else if(arr1[m]==45){arr1[m]="♦J";}
			else if(arr1[m]==33){arr1[m]="♠J";}
			else if(arr1[m]==21){arr1[m]="♥J";}
			else if(arr1[m]==9){arr1[m]="♣J";}
			else if(arr1[m]==44){arr1[m]="♦10";}
			else if(arr1[m]==32){arr1[m]="♠10";}
			else if(arr1[m]==20){arr1[m]="♥10";}
			else if(arr1[m]==8){arr1[m]="♣10";}
			else if(arr1[m]==43){arr1[m]="♦9";}
			else if(arr1[m]==31){arr1[m]="♠9";}
			else if(arr1[m]==19){arr1[m]="♥9";}
			else if(arr1[m]==7){arr1[m]="♣9";}
			else if(arr1[m]==42){arr1[m]="♦8";}
			else if(arr1[m]==30){arr1[m]="♠8";}
			else if(arr1[m]==18){arr1[m]="♥8";}
			else if(arr1[m]==6){arr1[m]="♣8";}
			else if(arr1[m]==41){arr1[m]="♦7";}
			else if(arr1[m]==29){arr1[m]="♠7";}
			else if(arr1[m]==17){arr1[m]="♥7";}
			else if(arr1[m]==5){arr1[m]="♣7";}
			else if(arr1[m]==40){arr1[m]="♦6";}
			else if(arr1[m]==28){arr1[m]="♠6";}
			else if(arr1[m]==16){arr1[m]="♥6";}
			else if(arr1[m]==4){arr1[m]="♣6";}
			else if(arr1[m]==39){arr1[m]="♦5";}
			else if(arr1[m]==27){arr1[m]="♠5";}
			else if(arr1[m]==15){arr1[m]="♥5";}
			else if(arr1[m]==3){arr1[m]="♣5";}
			else if(arr1[m]==38){arr1[m]="♦4";}
			else if(arr1[m]==26){arr1[m]="♠4";}
			else if(arr1[m]==14){arr1[m]="♥4";}
			else if(arr1[m]==2){arr1[m]="♣4";}
			else if(arr1[m]==37){arr1[m]="♦3";}
			else if(arr1[m]==25){arr1[m]="♠3";}
			else if(arr1[m]==13){arr1[m]="♥3";}
			else if(arr1[m]==1){arr1[m]="♣3";}
			
			else{arr1[m]="";}
	}
	return arr1;//返回排序后的数组
}
else{
	return arr1;
}
}