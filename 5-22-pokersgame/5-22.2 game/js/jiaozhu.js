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
				var numarrer = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];//牌数
				var heitao = [];//黑桃
				var hongtao = [];//红桃
				var meihua = [];//梅花
				var fangkuai = [];//方块
				var oneCards=[];//一副牌
				var fourCards=[];//四副牌
				for(var i=0;i<=12;i++){
				heitao.push(type[0]+numarrer[i]);//黑桃
				hongtao.push(type[1]+numarrer[i]);//红桃
				meihua.push(type[2]+numarrer[i]);//梅花
				fangkuai.push(type[3]+numarrer[i]);//方块
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
				console.log("一副牌:"+oneCards+"；一副牌的张数："+oneCards.length);
				console.log("四副牌："+fourCards+"；四副牌的张数："+fourCards.length);


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


function ChangeArr(arr){//把数组转化成拼音形式，方便统计每个元素出现次数，
//返回转换后每个元素统计结果的JSON字符串；如：{"dawang":2,"xiaowang":2,"heitao2":1,"fangkuai2":1,...，"fangkuai3":1}
	for(var x=0;x<54;x++){
	if(arr[x]==newA[0]){arr[x]="dawang";}
	else if(arr[x]==newA[1]){arr[x]="xiaowang";}
	else if(arr[x]==newA[2]){arr[x]="heitao2";}
	else if(arr[x]==newA[3]){arr[x]="hongtao2";}
	else if(arr[x]==newA[4]){arr[x]="meihua2";}
	else if(arr[x]==newA[5]){arr[x]="fangkuai2";}
	else if(arr[x]==newA[6]){arr[x]="heitaoA";}
	else if(arr[x]==newA[7]){arr[x]="hongtaoA";}
	else if(arr[x]==newA[8]){arr[x]="meihuaA";}
	else if(arr[x]==newA[9]){arr[x]="fangkuaiA";}
	else if(arr[x]==newA[10]){arr[x]="heitaoK";}
	else if(arr[x]==newA[11]){arr[x]="hongtaoK";}
	else if(arr[x]==newA[12]){arr[x]="meihuaK";}
	else if(arr[x]==newA[13]){arr[x]="fangkuaiK";}
	else if(arr[x]==newA[14]){arr[x]="heitaoQ";}
	else if(arr[x]==newA[15]){arr[x]="hongtaoQ";}
	else if(arr[x]==newA[16]){arr[x]="meihuaQ";}
	else if(arr[x]==newA[17]){arr[x]="fangkuaiQ";}
	else if(arr[x]==newA[18]){arr[x]="heitaoJ";}
	else if(arr[x]==newA[19]){arr[x]="hongtaoJ";}
	else if(arr[x]==newA[20]){arr[x]="meihuaJ";}
	else if(arr[x]==newA[21]){arr[x]="fangkuaiJ";}
	else if(arr[x]==newA[22]){arr[x]="heitao10";}
	else if(arr[x]==newA[23]){arr[x]="hongtao10";}
	else if(arr[x]==newA[24]){arr[x]="meihua10";}
	else if(arr[x]==newA[25]){arr[x]="fangkuai10";}
	else if(arr[x]==newA[26]){arr[x]="heitao9";}
	else if(arr[x]==newA[27]){arr[x]="hongtao9";}
	else if(arr[x]==newA[28]){arr[x]="meihua9";}
	else if(arr[x]==newA[29]){arr[x]="fangkuai9";}
	else if(arr[x]==newA[30]){arr[x]="heitao8";}
	else if(arr[x]==newA[31]){arr[x]="hongtao8";}
	else if(arr[x]==newA[32]){arr[x]="meihua8";}
	else if(arr[x]==newA[33]){arr[x]="fangkuai8";}
	else if(arr[x]==newA[34]){arr[x]="heitao7";}
	else if(arr[x]==newA[35]){arr[x]="hongtao7";}
	else if(arr[x]==newA[36]){arr[x]="meihua7";}
	else if(arr[x]==newA[37]){arr[x]="fangkuai7";}
	else if(arr[x]==newA[38]){arr[x]="heitao6";}
	else if(arr[x]==newA[39]){arr[x]="hongtao6";}
	else if(arr[x]==newA[40]){arr[x]="meihua6";}
	else if(arr[x]==newA[41]){arr[x]="fangkuai6";}
	else if(arr[x]==newA[42]){arr[x]="heitao5";}
	else if(arr[x]==newA[43]){arr[x]="hongtao5";}
	else if(arr[x]==newA[44]){arr[x]="meihua5";}
	else if(arr[x]==newA[45]){arr[x]="fangkuai5";}
	else if(arr[x]==newA[46]){arr[x]="heitao4";}
	else if(arr[x]==newA[47]){arr[x]="hongtao4";}
	else if(arr[x]==newA[48]){arr[x]="meihua4";}
	else if(arr[x]==newA[49]){arr[x]="fangkuai4";}
	else if(arr[x]==newA[50]){arr[x]="heitao3";}
	else if(arr[x]==newA[51]){arr[x]="hongtao3";}
	else if(arr[x]==newA[52]){arr[x]="meihua3";}
	else if(arr[x]==newA[53]){arr[x]="fangkuai3";}
	else {arr[x]="other";}
	}
	console.log("转换成拼音后的arr=["+arr+"]");
function  statisticalFieldNumarrer(arr) {//计算数组每个元素出现的次数（可统计每个玩家手牌的张数）
		return arr.reduce(function (prev, next) {//reduce() 方法接收一个函数作为累加器，数组中的每个值（从左到右）开始缩减，最终计算为一个值。
	                                           //reduce() 可以作为一个高阶函数，用于函数的 compose。
	                                           //注意: reduce() 对于空数组是不会执行回调函数的。
	        prev[next] = (prev[next] + 1) || 1;//(本行是核心代码)， prev是对象 (也就是oarrject)，初始化prev为{}, 也就是倒数第二行的声明；
			                                   //next指 one of the array elements，比如，当reduce遍历到数组arr的["♠2", "♚"]时，prev={"♠2":1};
											   //但是"♚"还没有，说明prev[next]=false,所以取||右边的值1，这时候prev={"♠2":1;"♚":1}
	     return prev;
	    }, {});
	 }
	 var NewArr=[];
	 NewArr.push(statisticalFieldNumarrer(arr));
	 var strArr=JSON.stringify(statisticalFieldNumarrer(arr));//将json对象转化为json字符串
	 console.log("转化成字符串后的strArr="+strArr);
	 
		 
		 
	 return strArr;//返回转换后每个元素统计结果的JSON字符串；如：{"dawang":2,"xiaowang":2,"heitao2":1,"fangkuai2":1,...，"fangkuai3":1}
}
function CountNum(strArr,NewArr){
	if(strArr.indexOf("dawang")<0&&strArr.indexOf("xiaowang")<0){//查找字符串（玩家arr中的手牌）中是否有大王，小于0为没有
		 	NewArr[0].dawang=0;//没有大王则设置大王张数为0
		 	NewArr[0].xiaowang=0;
		 }else if(strArr.indexOf("dawang")<0&&strArr.indexOf("xiaowang")>0){
		 	NewArr[0].dawang=0;
		 }else if(strArr.indexOf("xiaowang")<0&&strArr.indexOf("dawang")>0){
		 	NewArr[0].xiaowang=0;
		 }
		 console.log("大王张数："+NewArr[0].dawang+"；小王张数："+NewArr[0].xiaowang);
		 //计算♠2、♥2、♣2、♦2的张数，为了在亮主区显示叫主多少张
		 if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")>0){//手牌只有♥2、♣2、♦2
		 	NewArr[0].heitao2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")>0){//手牌只有♠2、♣2、♦2
		 	NewArr[0].hongtao2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")>0){//手牌只有♠2、♥2、♦2
		 	NewArr[0].meihua2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")<0){//手牌只有♠2、♥2、♣2
		 	NewArr[0].fangkuai2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")>0){//手牌只有♣2、♦2
		 	NewArr[0].heitao2=0;NewArr[0].hongtao2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")>0){//手牌只有♥2、♦2
		 	NewArr[0].heitao2=0;NewArr[0].meihua2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")<0){//手牌只有♥2、♣2
		 	NewArr[0].heitao2=0;NewArr[0].fangkuai2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")>0){//手牌只有♠2、♦2
		 	NewArr[0].hongtao2=0;NewArr[0].meihua2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")<0){//手牌只有♠2、♣2
		 	NewArr[0].hongtao2=0;NewArr[0].fangkuai2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")<0){//手牌只有♠2、♥2
		 	NewArr[0].fangkuai2=0;NewArr[0].meihua2=0;
		 }else if(strArr.indexOf("heitao2")>0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")<0){//手牌只有♠2
		 	NewArr[0].fangkuai2=0;NewArr[0].meihua2=0;NewArr[0].hongtao2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")>0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")<0){//手牌只有♥2
		 	NewArr[0].fangkuai2=0;NewArr[0].meihua2=0;NewArr[0].heitao2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")>0&&strArr.indexOf("fangkuai2")<0){//手牌只有♣2
		 	NewArr[0].fangkuai2=0;NewArr[0].hongtao2=0;NewArr[0].heitao2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")>0){//手牌只有♦2
		 	NewArr[0].meihua2=0;NewArr[0].hongtao2=0;NewArr[0].heitao2=0;
		 }else if(strArr.indexOf("heitao2")<0&&strArr.indexOf("hongtao2")<0&&strArr.indexOf("meihua2")<0&&strArr.indexOf("fangkuai2")<0){//手牌没有2
		 	NewArr[0].meihua2=0;NewArr[0].hongtao2=0;NewArr[0].heitao2=0;NewArr[0].fangkuai2=0;
		 }
		 console.log("♠2张数："+NewArr[0].heitao2+"；♥2张数："+NewArr[0].hongtao2+"；♣2张数："+NewArr[0].meihua2+"；♦2张数："+NewArr[0].fangkuai2);
		 

		 var CountNumArr=[];//生成Json数组格式
		 var data={};
		 data["dawang"]=NewArr[0].dawang;
		 data["xiaowang"]=NewArr[0].xiaowang;
		 data["heitao2"]=NewArr[0].heitao2;
		 data["hongtao2"]=NewArr[0].hongtao2;
		 data["meihua2"]=NewArr[0].meihua2;
		 data["fangkuai2"]=NewArr[0].fangkuai2;
		 CountNumArr.push(data);
		 var jsonString = JSON.stringify(CountNumArr);
		 console.log(CountNumArr);
		
		 return CountNumArr[0];//返回json对象
	
}
function ChangeBeforeArr(arr){//把数组转换回图标形式
for(var x=0;x<54;x++){
				if(arr[x]=="dawang"){arr[x]=newA[0];}
				else if(arr[x]=="xiaowang"){arr[x]=newA[1];}
				else if(arr[x]=="heitao2"){arr[x]=newA[2];}
				else if(arr[x]=="hongtao2"){arr[x]=newA[3];}
				else if(arr[x]=="meihua2"){arr[x]=newA[4];}
				else if(arr[x]=="fangkuai2"){arr[x]=newA[5];}
				else if(arr[x]=="heitaoA"){arr[x]=newA[6];}
				else if(arr[x]=="hongtaoA"){arr[x]=newA[7];}
				else if(arr[x]=="meihuaA"){arr[x]=newA[8];}
				else if(arr[x]=="fangkuaiA"){arr[x]=newA[9];}
				else if(arr[x]=="heitaoK"){arr[x]=newA[10];}
				else if(arr[x]=="hongtaoK"){arr[x]=newA[11];}
				else if(arr[x]=="meihuaK"){arr[x]=newA[12];}
				else if(arr[x]=="fangkuaiK"){arr[x]=newA[13];}
				else if(arr[x]=="heitaoQ"){arr[x]=newA[14];}
				else if(arr[x]=="hongtaoQ"){arr[x]=newA[15];}
				else if(arr[x]=="meihuaQ"){arr[x]=newA[16];}
				else if(arr[x]=="fangkuaiQ"){arr[x]=newA[17];}
				else if(arr[x]=="heitaoJ"){arr[x]=newA[18];}
				else if(arr[x]=="hongtaoJ"){arr[x]=newA[19];}
				else if(arr[x]=="meihuaJ"){arr[x]=newA[20];}
				else if(arr[x]=="fangkuaiJ"){arr[x]=newA[21];}
				else if(arr[x]=="heitao10"){arr[x]=newA[22];}
				else if(arr[x]=="hongtao10"){arr[x]=newA[23];}
				else if(arr[x]=="meihua10"){arr[x]=newA[24];}
				else if(arr[x]=="fangkuai10"){arr[x]=newA[25];}
				else if(arr[x]=="heitao9"){arr[x]=newA[26];}
				else if(arr[x]=="hongtao9"){arr[x]=newA[27];}
				else if(arr[x]=="meihua9"){arr[x]=newA[28];}
				else if(arr[x]=="fangkuai9"){arr[x]=newA[29];}
				else if(arr[x]=="heitao8"){arr[x]=newA[30];}
				else if(arr[x]=="hongtao8"){arr[x]=newA[31];}
				else if(arr[x]=="meihua8"){arr[x]=newA[32];}
				else if(arr[x]=="fangkuai8"){arr[x]=newA[33];}
				else if(arr[x]=="heitao7"){arr[x]=newA[34];}
				else if(arr[x]=="hongtao7"){arr[x]=newA[35];}
				else if(arr[x]=="meihua7"){arr[x]=newA[36];}
				else if(arr[x]=="fangkuai7"){arr[x]=newA[37];}
				else if(arr[x]=="heitao6"){arr[x]=newA[38];}
				else if(arr[x]=="hongtao6"){arr[x]=newA[39];}
				else if(arr[x]=="meihua6"){arr[x]=newA[40];}
				else if(arr[x]=="fangkuai6"){arr[x]=newA[41];}
				else if(arr[x]=="heitao5"){arr[x]=newA[42];}
				else if(arr[x]=="hongtao5"){arr[x]=newA[43];}
				else if(arr[x]=="meihua5"){arr[x]=newA[44];}
				else if(arr[x]=="fangkuai5"){arr[x]=newA[45];}
				else if(arr[x]=="heitao4"){arr[x]=newA[46];}
				else if(arr[x]=="hongtao4"){arr[x]=newA[47];}
				else if(arr[x]=="meihua4"){arr[x]=newA[48];}
				else if(arr[x]=="fangkuai4"){arr[x]=newA[49];}
				else if(arr[x]=="heitao3"){arr[x]=newA[50];}
				else if(arr[x]=="hongtao3"){arr[x]=newA[51];}
				else if(arr[x]=="meihua3"){arr[x]=newA[52];}
				else if(arr[x]=="fangkuai3"){arr[x]=newA[53];}
				else {arr[x]=0;}
				}
				 console.log("转换成原始的数组arr"+arr);
				return arr;
}
function ShowPoker(arr,select){//把数组元素逐个添加到某个选择器中
	for(var i=0;i<arr.length;i++){
		$(select).append("<div id='"+i+"' class='poker'>"+arr[i]+"</div>");//将数组每个元素以带有唯一标识id的<div>形式添加到被选元素select
	}
}

