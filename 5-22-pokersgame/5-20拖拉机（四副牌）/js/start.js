var newA=[];
				newA[0]="♚",newA[1]="♖",newA[2]="♠2",newA[3]="♥2",newA[4]="♣2",newA[5]="♦2",newA[6]="♠A",newA[7]="♥A",
				newA[8]="♣A",newA[9]="♦A",newA[10]="♠K",newA[11]="♥K",newA[12]="♣K",newA[13]="♦K",newA[14]="♠Q",newA[15]="♥Q",
				newA[16]="♣Q",newA[17]="♦Q",newA[18]="♠J",newA[19]="♥J",newA[20]="♣J",newA[21]="♦J",newA[22]="♠10",newA[23]="♥10",
				newA[24]="♣10",newA[25]="♦10",newA[26]="♠9",newA[27]="♥9",newA[28]="♣9",newA[29]="♦9",newA[30]="♠8",newA[31]="♥8",
				newA[32]="♣8",newA[33]="♦8",newA[34]="♠7",newA[35]="♥7",newA[36]="♣7",newA[37]="♦7",newA[38]="♠6",newA[39]="♥6",
				newA[40]="♣6",newA[41]="♦6",newA[42]="♠5",newA[43]="♥5",newA[44]="♣5",newA[45]="♦5",newA[46]="♠4",newA[47]="♥4",
				newA[48]="♣4",newA[49]="♦4",newA[50]="♠3",newA[51]="♥3",newA[52]="♣3",newA[53]="♦3";
function start(){
	document.getElementById("operate").style.visibility="visible";//显示
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
				
				//玩家扑克牌排序
				var compare = function (x, y) {//比较函数
					return y-x;
				}
				var tmp;
				
				for(var x=0;x<54;x++){
				if(A[x]==newA[0]){A[x]=54;}
				else if(A[x]==newA[1]){A[x]=53;}
				else if(A[x]==newA[2]){A[x]=52;}
				else if(A[x]==newA[3]){A[x]=51;}
				else if(A[x]==newA[4]){A[x]=50;}
				else if(A[x]==newA[5]){A[x]=49;}
				else if(A[x]==newA[6]){A[x]=48;}
				else if(A[x]==newA[7]){A[x]=47;}
				else if(A[x]==newA[8]){A[x]=46;}
				else if(A[x]==newA[9]){A[x]=45;}
				else if(A[x]==newA[10]){A[x]=44;}
				else if(A[x]==newA[11]){A[x]=43;}
				else if(A[x]==newA[12]){A[x]=42;}
				else if(A[x]==newA[13]){A[x]=41;}
				else if(A[x]==newA[14]){A[x]=40;}
				else if(A[x]==newA[15]){A[x]=39;}
				else if(A[x]==newA[16]){A[x]=38;}
				else if(A[x]==newA[17]){A[x]=37;}
				else if(A[x]==newA[18]){A[x]=36;}
				else if(A[x]==newA[19]){A[x]=35;}
				else if(A[x]==newA[20]){A[x]=34;}
				else if(A[x]==newA[21]){A[x]=33;}
				else if(A[x]==newA[22]){A[x]=32;}
				else if(A[x]==newA[23]){A[x]=31;}
				else if(A[x]==newA[24]){A[x]=30;}
				else if(A[x]==newA[25]){A[x]=29;}
				else if(A[x]==newA[26]){A[x]=28;}
				else if(A[x]==newA[27]){A[x]=27;}
				else if(A[x]==newA[28]){A[x]=26;}
				else if(A[x]==newA[29]){A[x]=25;}
				else if(A[x]==newA[30]){A[x]=24;}
				else if(A[x]==newA[31]){A[x]=23;}
				else if(A[x]==newA[32]){A[x]=22;}
				else if(A[x]==newA[33]){A[x]=21;}
				else if(A[x]==newA[34]){A[x]=20;}
				else if(A[x]==newA[35]){A[x]=19;}
				else if(A[x]==newA[36]){A[x]=18;}
				else if(A[x]==newA[37]){A[x]=17;}
				else if(A[x]==newA[38]){A[x]=16;}
				else if(A[x]==newA[39]){A[x]=15;}
				else if(A[x]==newA[40]){A[x]=14;}
				else if(A[x]==newA[41]){A[x]=13;}
				else if(A[x]==newA[42]){A[x]=12;}
				else if(A[x]==newA[43]){A[x]=11;}
				else if(A[x]==newA[44]){A[x]=10;}
				else if(A[x]==newA[45]){A[x]=9;}
				else if(A[x]==newA[46]){A[x]=8;}
				else if(A[x]==newA[47]){A[x]=7;}
				else if(A[x]==newA[48]){A[x]=6;}
				else if(A[x]==newA[49]){A[x]=5;}
				else if(A[x]==newA[50]){A[x]=4;}
				else if(A[x]==newA[51]){A[x]=3;}
				else if(A[x]==newA[52]){A[x]=2;}
				else if(A[x]==newA[53]){A[x]=1;}
				else {A[x]=0;}
				}
				
				var A1=A.sort(compare);
				for(var m=0;m<54;m++){
					if(A1[m]==54){A1[m]="♚";}	
					else if(A1[m]==53){A1[m]="♖";}
					else if(A1[m]==52){A1[m]="♠2";}
					else if(A1[m]==51){A1[m]="♥2";}
					else if(A1[m]==50){A1[m]="♣2";}
					else if(A1[m]==49){A1[m]="♦2";}
					else if(A1[m]==48){A1[m]="♠A";}
					else if(A1[m]==47){A1[m]="♥A";}
					else if(A1[m]==46){A1[m]="♣A";}
					else if(A1[m]==45){A1[m]="♦A";}
					else if(A1[m]==44){A1[m]="♠K";}
					else if(A1[m]==43){A1[m]="♥K";}
					else if(A1[m]==42){A1[m]="♣K";}
					else if(A1[m]==41){A1[m]="♦K";}
					else if(A1[m]==40){A1[m]="♠Q";}
					else if(A1[m]==39){A1[m]="♥Q";}
					else if(A1[m]==38){A1[m]="♣Q";}
					else if(A1[m]==37){A1[m]="♦Q";}
					else if(A1[m]==36){A1[m]="♠J";}
					else if(A1[m]==35){A1[m]="♥J";}
					else if(A1[m]==34){A1[m]="♣J";}
					else if(A1[m]==33){A1[m]="♦J";}
					else if(A1[m]==32){A1[m]="♠10";}
					else if(A1[m]==31){A1[m]="♥10";}
					else if(A1[m]==30){A1[m]="♣10";}
					else if(A1[m]==29){A1[m]="♦10";}
					else if(A1[m]==28){A1[m]="♠9";}
					else if(A1[m]==27){A1[m]="♥9";}
					else if(A1[m]==26){A1[m]="♣9";}
					else if(A1[m]==25){A1[m]="♦9";}
					else if(A1[m]==24){A1[m]="♠8";}
					else if(A1[m]==23){A1[m]="♥8";}
					else if(A1[m]==22){A1[m]="♣8";}
					else if(A1[m]==21){A1[m]="♦8";}
					else if(A1[m]==20){A1[m]="♠7";}
					else if(A1[m]==19){A1[m]="♥7";}
					else if(A1[m]==18){A1[m]="♣7";}
					else if(A1[m]==17){A1[m]="♦7";}
					else if(A1[m]==16){A1[m]="♠6";}
					else if(A1[m]==15){A1[m]="♥6";}
					else if(A1[m]==14){A1[m]="♣6";}
					else if(A1[m]==13){A1[m]="♦6";}
					else if(A1[m]==12){A1[m]="♠5";}
					else if(A1[m]==11){A1[m]="♥5";}
					else if(A1[m]==10){A1[m]="♣5";}
					else if(A1[m]==9){A1[m]="♦5";}
					else if(A1[m]==8){A1[m]="♠4";}
					else if(A1[m]==7){A1[m]="♥4";}
					else if(A1[m]==6){A1[m]="♣4";}
					else if(A1[m]==5){A1[m]="♦4";}
					else if(A1[m]==4){A1[m]="♠3";}
					else if(A1[m]==3){A1[m]="♥3";}
					else if(A1[m]==2){A1[m]="♣3";}
					else if(A1[m]==1){A1[m]="♦3";}
					else{A1[m]="";}
				}
				for(var x=0;x<54;x++){
				if(B[x]==newA[0]){B[x]="dawang";}
				else if(B[x]==newA[1]){B[x]="xiaowang";}
				else if(B[x]==newA[2]){B[x]="heitao2";}
				else if(B[x]==newA[3]){B[x]="hongtao2";}
				else if(B[x]==newA[4]){B[x]="meihua2";}
				else if(B[x]==newA[5]){B[x]="fangkuai2";}
				else if(B[x]==newA[6]){B[x]="heitaoA";}
				else if(B[x]==newA[7]){B[x]="hongtaoA";}
				else if(B[x]==newA[8]){B[x]="meihuaA";}
				else if(B[x]==newA[9]){B[x]="fangkuaiA";}
				else if(B[x]==newA[10]){B[x]="heitaoK";}
				else if(B[x]==newA[11]){B[x]="hongtaoK";}
				else if(B[x]==newA[12]){B[x]="meihuaK";}
				else if(B[x]==newA[13]){B[x]="fangkuaiK";}
				else if(B[x]==newA[14]){B[x]="heitaoQ";}
				else if(B[x]==newA[15]){B[x]="hongtaoQ";}
				else if(B[x]==newA[16]){B[x]="meihuaQ";}
				else if(B[x]==newA[17]){B[x]="fangkuaiQ";}
				else if(B[x]==newA[18]){B[x]="heitaoJ";}
				else if(B[x]==newA[19]){B[x]="hongtaoJ";}
				else if(B[x]==newA[20]){B[x]="meihuaJ";}
				else if(B[x]==newA[21]){B[x]="fangkuaiJ";}
				else if(B[x]==newA[22]){B[x]="heitao10";}
				else if(B[x]==newA[23]){B[x]="hongtao10";}
				else if(B[x]==newA[24]){B[x]="meihua10";}
				else if(B[x]==newA[25]){B[x]="fangkuai10";}
				else if(B[x]==newA[26]){B[x]="heitao9";}
				else if(B[x]==newA[27]){B[x]="hongtao9";}
				else if(B[x]==newA[28]){B[x]="meihua9";}
				else if(B[x]==newA[29]){B[x]="fangkuai9";}
				else if(B[x]==newA[30]){B[x]="heitao8";}
				else if(B[x]==newA[31]){B[x]="hongtao8";}
				else if(B[x]==newA[32]){B[x]="meihua8";}
				else if(B[x]==newA[33]){B[x]="fangkuai8";}
				else if(B[x]==newA[34]){B[x]="heitao7";}
				else if(B[x]==newA[35]){B[x]="hongtao7";}
				else if(B[x]==newA[36]){B[x]="meihua7";}
				else if(B[x]==newA[37]){B[x]="fangkuai7";}
				else if(B[x]==newA[38]){B[x]="heitao6";}
				else if(B[x]==newA[39]){B[x]="hongtao6";}
				else if(B[x]==newA[40]){B[x]="meihua6";}
				else if(B[x]==newA[41]){B[x]="fangkuai6";}
				else if(B[x]==newA[42]){B[x]="heitao5";}
				else if(B[x]==newA[43]){B[x]="hongtao5";}
				else if(B[x]==newA[44]){B[x]="meihua5";}
				else if(B[x]==newA[45]){B[x]="fangkuai5";}
				else if(B[x]==newA[46]){B[x]="heitao4";}
				else if(B[x]==newA[47]){B[x]="hongtao4";}
				else if(B[x]==newA[48]){B[x]="meihua4";}
				else if(B[x]==newA[49]){B[x]="fangkuai4";}
				else if(B[x]==newA[50]){B[x]="heitao3";}
				else if(B[x]==newA[51]){B[x]="hongtao3";}
				else if(B[x]==newA[52]){B[x]="meihua3";}
				else if(B[x]==newA[53]){B[x]="fangkuai3";}
				else {B[x]="other";}
				}
				console.log(B)
				//计算大小王张数
				function  statisticalFieldNumber(B) {
					return B.reduce(function (prev, next) {//reduce() 方法接收一个函数作为累加器，数组中的每个值（从左到右）开始缩减，最终计算为一个值。
                                                           //reduce() 可以作为一个高阶函数，用于函数的 compose。
                                                           //注意: reduce() 对于空数组是不会执行回调函数的。
				        prev[next] = (prev[next] + 1) || 1;//(本行是核心代码)， prev是对象 (也就是object)，初始化prev为{}, 也就是倒数第二行的声明；
						                                   //next指 one of the array elements，比如，当reduce遍历到数组B的["♠2", "♚"]时，prev={"♠2":1};
														   //但是"♚"还没有，说明prev[next]=false,所以取||右边的值1，这时候prev={"♠2":1;"♚":1}
				     return prev;
				    }, {});
				 }
				var NewB=[];
				NewB.push(statisticalFieldNumber(B));
				var strB=JSON.stringify(statisticalFieldNumber(B));//将json对象转化为json字符串
				console.log(strB);
				if(strB.indexOf("dawang")<0&&strB.indexOf("xiaowang")<0){//查找字符串（玩家B中的手牌）中是否有大王，小于0为没有
					NewB[0].dawang=0;//没有大王则设置大王张数为0
					NewAB[0].xiaowang=0;
				}else if(strB.indexOf("dawang")<0&&strB.indexOf("xiaowang")>0){
					NewB[0].dawang=0;
				}
				else if(strB.indexOf("xiaowang")<0&&strB.indexOf("dawang")>0){
					NewB[0].xiaowang=0;
				}
				console.log("大王张数："+NewB[0].dawang+"小王张数："+NewB[0].xiaowang);
				
				
				//计算♠2、♥2、♣2、♦2的张数，为了在亮主区显示叫主多少张
				if(strB.indexOf("heitao2")<0&&strB.indexOf("hongtao2")>0&&strB.indexOf("meihua2")>0&&strB.indexOf("fangkuai2")>0){//手牌有♥2、♣2、♦2
					NewB[0].heitao2=0;
				}
				
				
				
				for(var x=0;x<54;x++){
				if(B[x]=="dawang"){B[x]=54;}
				else if(B[x]=="xiaowang"){B[x]=53;}
				else if(B[x]=="heitao2"){B[x]=52;}
				else if(B[x]=="hongtao2"){B[x]=51;}
				else if(B[x]=="meihua2"){B[x]=50;}
				else if(B[x]=="fangkuai2"){B[x]=49;}
				else if(B[x]=="heitaoA"){B[x]=48;}
				else if(B[x]=="hongtaoA"){B[x]=47;}
				else if(B[x]=="meihuaA"){B[x]=46;}
				else if(B[x]=="fangkuaiA"){B[x]=45;}
				else if(B[x]=="heitaoK"){B[x]=44;}
				else if(B[x]=="hongtaoK"){B[x]=43;}
				else if(B[x]=="meihuaK"){B[x]=42;}
				else if(B[x]=="fangkuaiK"){B[x]=41;}
				else if(B[x]=="heitaoQ"){B[x]=40;}
				else if(B[x]=="hongtaoQ"){B[x]=39;}
				else if(B[x]=="meihuaQ"){B[x]=38;}
				else if(B[x]=="fangkuaiQ"){B[x]=37;}
				else if(B[x]=="heitaoJ"){B[x]=36;}
				else if(B[x]=="hongtaoJ"){B[x]=35;}
				else if(B[x]=="meihuaJ"){B[x]=34;}
				else if(B[x]=="fangkuaiJ"){B[x]=33;}
				else if(B[x]=="heitao10"){B[x]=32;}
				else if(B[x]=="hongtao10"){B[x]=31;}
				else if(B[x]=="meihua10"){B[x]=30;}
				else if(B[x]=="fangkuai10"){B[x]=29;}
				else if(B[x]=="heitao9"){B[x]=28;}
				else if(B[x]=="hongtao9"){B[x]=27;}
				else if(B[x]=="meihua9"){B[x]=26;}
				else if(B[x]=="fangkuai9"){B[x]=25;}
				else if(B[x]=="heitao8"){B[x]=24;}
				else if(B[x]=="hongtao8"){B[x]=23;}
				else if(B[x]=="meihua8"){B[x]=22;}
				else if(B[x]=="fangkuai8"){B[x]=21;}
				else if(B[x]=="heitao7"){B[x]=20;}
				else if(B[x]=="hongtao7"){B[x]=19;}
				else if(B[x]=="meihua7"){B[x]=18;}
				else if(B[x]=="fangkuai7"){B[x]=17;}
				else if(B[x]=="heitao6"){B[x]=16;}
				else if(B[x]=="hongtao6"){B[x]=15;}
				else if(B[x]=="meihua6"){B[x]=14;}
				else if(B[x]=="fangkuai6"){B[x]=13;}
				else if(B[x]=="heitao5"){B[x]=12;}
				else if(B[x]=="hongtao5"){B[x]=11;}
				else if(B[x]=="meihua5"){B[x]=10;}
				else if(B[x]=="fangkuai5"){B[x]=9;}
				else if(B[x]=="heitao4"){B[x]=8;}
				else if(B[x]=="hongtao4"){B[x]=7;}
				else if(B[x]=="meihua4"){B[x]=6;}
				else if(B[x]=="fangkuai4"){B[x]=5;}
				else if(B[x]=="heitao3"){B[x]=4;}
				else if(B[x]=="hongtao3"){B[x]=3;}
				else if(B[x]=="meihua3"){B[x]=2;}
				else if(B[x]=="fangkuai3"){B[x]=1;}
				else {B[x]=0;}
				}
				console.log("B=["+B+"]");
				var B1=B.sort(compare);
				console.log("B1=["+B1+"]");
				for(var m=0;m<54;m++){
					if(B1[m]==54){B1[m]="♚";}	
					else if(B1[m]==53){B1[m]="♖";}
					else if(B1[m]==52){B1[m]="♠2";}
					else if(B1[m]==51){B1[m]="♥2";}
					else if(B1[m]==50){B1[m]="♣2";}
					else if(B1[m]==49){B1[m]="♦2";}
					else if(B1[m]==48){B1[m]="♠A";}
					else if(B1[m]==47){B1[m]="♥A";}
					else if(B1[m]==46){B1[m]="♣A";}
					else if(B1[m]==45){B1[m]="♦A";}
					else if(B1[m]==44){B1[m]="♠K";}
					else if(B1[m]==43){B1[m]="♥K";}
					else if(B1[m]==42){B1[m]="♣K";}
					else if(B1[m]==41){B1[m]="♦K";}
					else if(B1[m]==40){B1[m]="♠Q";}
					else if(B1[m]==39){B1[m]="♥Q";}
					else if(B1[m]==38){B1[m]="♣Q";}
					else if(B1[m]==37){B1[m]="♦Q";}
					else if(B1[m]==36){B1[m]="♠J";}
					else if(B1[m]==35){B1[m]="♥J";}
					else if(B1[m]==34){B1[m]="♣J";}
					else if(B1[m]==33){B1[m]="♦J";}
					else if(B1[m]==32){B1[m]="♠10";}
					else if(B1[m]==31){B1[m]="♥10";}
					else if(B1[m]==30){B1[m]="♣10";}
					else if(B1[m]==29){B1[m]="♦10";}
					else if(B1[m]==28){B1[m]="♠9";}
					else if(B1[m]==27){B1[m]="♥9";}
					else if(B1[m]==26){B1[m]="♣9";}
					else if(B1[m]==25){B1[m]="♦9";}
					else if(B1[m]==24){B1[m]="♠8";}
					else if(B1[m]==23){B1[m]="♥8";}
					else if(B1[m]==22){B1[m]="♣8";}
					else if(B1[m]==21){B1[m]="♦8";}
					else if(B1[m]==20){B1[m]="♠7";}
					else if(B1[m]==19){B1[m]="♥7";}
					else if(B1[m]==18){B1[m]="♣7";}
					else if(B1[m]==17){B1[m]="♦7";}
					else if(B1[m]==16){B1[m]="♠6";}
					else if(B1[m]==15){B1[m]="♥6";}
					else if(B1[m]==14){B1[m]="♣6";}
					else if(B1[m]==13){B1[m]="♦6";}
					else if(B1[m]==12){B1[m]="♠5";}
					else if(B1[m]==11){B1[m]="♥5";}
					else if(B1[m]==10){B1[m]="♣5";}
					else if(B1[m]==9){B1[m]="♦5";}
					else if(B1[m]==8){B1[m]="♠4";}
					else if(B1[m]==7){B1[m]="♥4";}
					else if(B1[m]==6){B1[m]="♣4";}
					else if(B1[m]==5){B1[m]="♦4";}
					else if(B1[m]==4){B1[m]="♠3";}
					else if(B1[m]==3){B1[m]="♥3";}
					else if(B1[m]==2){B1[m]="♣3";}
					else if(B1[m]==1){B1[m]="♦3";}
					else{B1[m]="";}
				}
				for(var x=0;x<54;x++){
				if(C[x]==newA[0]){C[x]=54;}
				else if(C[x]==newA[1]){C[x]=53;}
				else if(C[x]==newA[2]){C[x]=52;}
				else if(C[x]==newA[3]){C[x]=51;}
				else if(C[x]==newA[4]){C[x]=50;}
				else if(C[x]==newA[5]){C[x]=49;}
				else if(C[x]==newA[6]){C[x]=48;}
				else if(C[x]==newA[7]){C[x]=47;}
				else if(C[x]==newA[8]){C[x]=46;}
				else if(C[x]==newA[9]){C[x]=45;}
				else if(C[x]==newA[10]){C[x]=44;}
				else if(C[x]==newA[11]){C[x]=43;}
				else if(C[x]==newA[12]){C[x]=42;}
				else if(C[x]==newA[13]){C[x]=41;}
				else if(C[x]==newA[14]){C[x]=40;}
				else if(C[x]==newA[15]){C[x]=39;}
				else if(C[x]==newA[16]){C[x]=38;}
				else if(C[x]==newA[17]){C[x]=37;}
				else if(C[x]==newA[18]){C[x]=36;}
				else if(C[x]==newA[19]){C[x]=35;}
				else if(C[x]==newA[20]){C[x]=34;}
				else if(C[x]==newA[21]){C[x]=33;}
				else if(C[x]==newA[22]){C[x]=32;}
				else if(C[x]==newA[23]){C[x]=31;}
				else if(C[x]==newA[24]){C[x]=30;}
				else if(C[x]==newA[25]){C[x]=29;}
				else if(C[x]==newA[26]){C[x]=28;}
				else if(C[x]==newA[27]){C[x]=27;}
				else if(C[x]==newA[28]){C[x]=26;}
				else if(C[x]==newA[29]){C[x]=25;}
				else if(C[x]==newA[30]){C[x]=24;}
				else if(C[x]==newA[31]){C[x]=23;}
				else if(C[x]==newA[32]){C[x]=22;}
				else if(C[x]==newA[33]){C[x]=21;}
				else if(C[x]==newA[34]){C[x]=20;}
				else if(C[x]==newA[35]){C[x]=19;}
				else if(C[x]==newA[36]){C[x]=18;}
				else if(C[x]==newA[37]){C[x]=17;}
				else if(C[x]==newA[38]){C[x]=16;}
				else if(C[x]==newA[39]){C[x]=15;}
				else if(C[x]==newA[40]){C[x]=14;}
				else if(C[x]==newA[41]){C[x]=13;}
				else if(C[x]==newA[42]){C[x]=12;}
				else if(C[x]==newA[43]){C[x]=11;}
				else if(C[x]==newA[44]){C[x]=10;}
				else if(C[x]==newA[45]){C[x]=9;}
				else if(C[x]==newA[46]){C[x]=8;}
				else if(C[x]==newA[47]){C[x]=7;}
				else if(C[x]==newA[48]){C[x]=6;}
				else if(C[x]==newA[49]){C[x]=5;}
				else if(C[x]==newA[50]){C[x]=4;}
				else if(C[x]==newA[51]){C[x]=3;}
				else if(C[x]==newA[52]){C[x]=2;}
				else if(C[x]==newA[53]){C[x]=1;}
				else {C[x]=0;}
				}
				
				var C1=C.sort(compare);
				for(var m=0;m<54;m++){
					if(C1[m]==54){C1[m]="♚";}	
					else if(C1[m]==53){C1[m]="♖";}
					else if(C1[m]==52){C1[m]="♠2";}
					else if(C1[m]==51){C1[m]="♥2";}
					else if(C1[m]==50){C1[m]="♣2";}
					else if(C1[m]==49){C1[m]="♦2";}
					else if(C1[m]==48){C1[m]="♠A";}
					else if(C1[m]==47){C1[m]="♥A";}
					else if(C1[m]==46){C1[m]="♣A";}
					else if(C1[m]==45){C1[m]="♦A";}
					else if(C1[m]==44){C1[m]="♠K";}
					else if(C1[m]==43){C1[m]="♥K";}
					else if(C1[m]==42){C1[m]="♣K";}
					else if(C1[m]==41){C1[m]="♦K";}
					else if(C1[m]==40){C1[m]="♠Q";}
					else if(C1[m]==39){C1[m]="♥Q";}
					else if(C1[m]==38){C1[m]="♣Q";}
					else if(C1[m]==37){C1[m]="♦Q";}
					else if(C1[m]==36){C1[m]="♠J";}
					else if(C1[m]==35){C1[m]="♥J";}
					else if(C1[m]==34){C1[m]="♣J";}
					else if(C1[m]==33){C1[m]="♦J";}
					else if(C1[m]==32){C1[m]="♠10";}
					else if(C1[m]==31){C1[m]="♥10";}
					else if(C1[m]==30){C1[m]="♣10";}
					else if(C1[m]==29){C1[m]="♦10";}
					else if(C1[m]==28){C1[m]="♠9";}
					else if(C1[m]==27){C1[m]="♥9";}
					else if(C1[m]==26){C1[m]="♣9";}
					else if(C1[m]==25){C1[m]="♦9";}
					else if(C1[m]==24){C1[m]="♠8";}
					else if(C1[m]==23){C1[m]="♥8";}
					else if(C1[m]==22){C1[m]="♣8";}
					else if(C1[m]==21){C1[m]="♦8";}
					else if(C1[m]==20){C1[m]="♠7";}
					else if(C1[m]==19){C1[m]="♥7";}
					else if(C1[m]==18){C1[m]="♣7";}
					else if(C1[m]==17){C1[m]="♦7";}
					else if(C1[m]==16){C1[m]="♠6";}
					else if(C1[m]==15){C1[m]="♥6";}
					else if(C1[m]==14){C1[m]="♣6";}
					else if(C1[m]==13){C1[m]="♦6";}
					else if(C1[m]==12){C1[m]="♠5";}
					else if(C1[m]==11){C1[m]="♥5";}
					else if(C1[m]==10){C1[m]="♣5";}
					else if(C1[m]==9){C1[m]="♦5";}
					else if(C1[m]==8){C1[m]="♠4";}
					else if(C1[m]==7){C1[m]="♥4";}
					else if(C1[m]==6){C1[m]="♣4";}
					else if(C1[m]==5){C1[m]="♦4";}
					else if(C1[m]==4){C1[m]="♠3";}
					else if(C1[m]==3){C1[m]="♥3";}
					else if(C1[m]==2){C1[m]="♣3";}
					else if(C1[m]==1){C1[m]="♦3";}
					else{C1[m]="";}
				}
				for(var x=0;x<54;x++){
				if(D[x]==newA[0]){D[x]=54;}
				else if(D[x]==newA[1]){D[x]=53;}
				else if(D[x]==newA[2]){D[x]=52;}
				else if(D[x]==newA[3]){D[x]=51;}
				else if(D[x]==newA[4]){D[x]=50;}
				else if(D[x]==newA[5]){D[x]=49;}
				else if(D[x]==newA[6]){D[x]=48;}
				else if(D[x]==newA[7]){D[x]=47;}
				else if(D[x]==newA[8]){D[x]=46;}
				else if(D[x]==newA[9]){D[x]=45;}
				else if(D[x]==newA[10]){D[x]=44;}
				else if(D[x]==newA[11]){D[x]=43;}
				else if(D[x]==newA[12]){D[x]=42;}
				else if(D[x]==newA[13]){D[x]=41;}
				else if(D[x]==newA[14]){D[x]=40;}
				else if(D[x]==newA[15]){D[x]=39;}
				else if(D[x]==newA[16]){D[x]=38;}
				else if(D[x]==newA[17]){D[x]=37;}
				else if(D[x]==newA[18]){D[x]=36;}
				else if(D[x]==newA[19]){D[x]=35;}
				else if(D[x]==newA[20]){D[x]=34;}
				else if(D[x]==newA[21]){D[x]=33;}
				else if(D[x]==newA[22]){D[x]=32;}
				else if(D[x]==newA[23]){D[x]=31;}
				else if(D[x]==newA[24]){D[x]=30;}
				else if(D[x]==newA[25]){D[x]=29;}
				else if(D[x]==newA[26]){D[x]=28;}
				else if(D[x]==newA[27]){D[x]=27;}
				else if(D[x]==newA[28]){D[x]=26;}
				else if(D[x]==newA[29]){D[x]=25;}
				else if(D[x]==newA[30]){D[x]=24;}
				else if(D[x]==newA[31]){D[x]=23;}
				else if(D[x]==newA[32]){D[x]=22;}
				else if(D[x]==newA[33]){D[x]=21;}
				else if(D[x]==newA[34]){D[x]=20;}
				else if(D[x]==newA[35]){D[x]=19;}
				else if(D[x]==newA[36]){D[x]=18;}
				else if(D[x]==newA[37]){D[x]=17;}
				else if(D[x]==newA[38]){D[x]=16;}
				else if(D[x]==newA[39]){D[x]=15;}
				else if(D[x]==newA[40]){D[x]=14;}
				else if(D[x]==newA[41]){D[x]=13;}
				else if(D[x]==newA[42]){D[x]=12;}
				else if(D[x]==newA[43]){D[x]=11;}
				else if(D[x]==newA[44]){D[x]=10;}
				else if(D[x]==newA[45]){D[x]=9;}
				else if(D[x]==newA[46]){D[x]=8;}
				else if(D[x]==newA[47]){D[x]=7;}
				else if(D[x]==newA[48]){D[x]=6;}
				else if(D[x]==newA[49]){D[x]=5;}
				else if(D[x]==newA[50]){D[x]=4;}
				else if(D[x]==newA[51]){D[x]=3;}
				else if(D[x]==newA[52]){D[x]=2;}
				else if(D[x]==newA[53]){D[x]=1;}
				else {D[x]=0;}
				}
				var D1=D.sort(compare);
				for(var m=0;m<54;m++){
					if(D1[m]==54){D1[m]="♚";}	
					else if(D1[m]==53){D1[m]="♖";}
					else if(D1[m]==52){D1[m]="♠2";}
					else if(D1[m]==51){D1[m]="♥2";}
					else if(D1[m]==50){D1[m]="♣2";}
					else if(D1[m]==49){D1[m]="♦2";}
					else if(D1[m]==48){D1[m]="♠A";}
					else if(D1[m]==47){D1[m]="♥A";}
					else if(D1[m]==46){D1[m]="♣A";}
					else if(D1[m]==45){D1[m]="♦A";}
					else if(D1[m]==44){D1[m]="♠K";}
					else if(D1[m]==43){D1[m]="♥K";}
					else if(D1[m]==42){D1[m]="♣K";}
					else if(D1[m]==41){D1[m]="♦K";}
					else if(D1[m]==40){D1[m]="♠Q";}
					else if(D1[m]==39){D1[m]="♥Q";}
					else if(D1[m]==38){D1[m]="♣Q";}
					else if(D1[m]==37){D1[m]="♦Q";}
					else if(D1[m]==36){D1[m]="♠J";}
					else if(D1[m]==35){D1[m]="♥J";}
					else if(D1[m]==34){D1[m]="♣J";}
					else if(D1[m]==33){D1[m]="♦J";}
					else if(D1[m]==32){D1[m]="♠10";}
					else if(D1[m]==31){D1[m]="♥10";}
					else if(D1[m]==30){D1[m]="♣10";}
					else if(D1[m]==29){D1[m]="♦10";}
					else if(D1[m]==28){D1[m]="♠9";}
					else if(D1[m]==27){D1[m]="♥9";}
					else if(D1[m]==26){D1[m]="♣9";}
					else if(D1[m]==25){D1[m]="♦9";}
					else if(D1[m]==24){D1[m]="♠8";}
					else if(D1[m]==23){D1[m]="♥8";}
					else if(D1[m]==22){D1[m]="♣8";}
					else if(D1[m]==21){D1[m]="♦8";}
					else if(D1[m]==20){D1[m]="♠7";}
					else if(D1[m]==19){D1[m]="♥7";}
					else if(D1[m]==18){D1[m]="♣7";}
					else if(D1[m]==17){D1[m]="♦7";}
					else if(D1[m]==16){D1[m]="♠6";}
					else if(D1[m]==15){D1[m]="♥6";}
					else if(D1[m]==14){D1[m]="♣6";}
					else if(D1[m]==13){D1[m]="♦6";}
					else if(D1[m]==12){D1[m]="♠5";}
					else if(D1[m]==11){D1[m]="♥5";}
					else if(D1[m]==10){D1[m]="♣5";}
					else if(D1[m]==9){D1[m]="♦5";}
					else if(D1[m]==8){D1[m]="♠4";}
					else if(D1[m]==7){D1[m]="♥4";}
					else if(D1[m]==6){D1[m]="♣4";}
					else if(D1[m]==5){D1[m]="♦4";}
					else if(D1[m]==4){D1[m]="♠3";}
					else if(D1[m]==3){D1[m]="♥3";}
					else if(D1[m]==2){D1[m]="♣3";}
					else if(D1[m]==1){D1[m]="♦3";}
					else{D1[m]="";}
				}
				
			//亮主
			for(var x=0;x<54;x++){
			if(B[x]==newA[2]){document.getElementById("heitao").style.color="red";}
			else if(B[x]==newA[3]){document.getElementById("hongtao").style.color="red";}
			else if(B[x]==newA[4]){document.getElementById("meihua").style.color="red";}
			else if(B[x]==newA[5]){document.getElementById("fangkuai").style.color="red";}
			//如果获得四张大王或小王才有资格叫无主，几率比较小
			else if(NewB[0].dawang==4&&NewB[0].xiaowang<4){document.getElementById("dawang").style.color="red";}//NewB[0].dawang为玩家B获取大王的张数
			else if(NewB[0].xiaowang==4&&NewB[0].dawang<4){document.getElementById("xiaowang").style.color="red";}//NewB[0].xiaowang为玩家B获取小王的张数
			else if(NewB[0].xiaowang==4&&NewB[0].dawang==4){document.getElementById("xiaowang").style.color="red";document.getElementById("dawang").style.color="red";}}
			
			$('button').each(function () {
			
			if ($(this).css('color') === 'rgb(255, 0, 0)') {//判断是否为红色
			if(this.id=="heitao"){//判断哪一种牌型
			$(this).click(function(){
			document.getElementById("liangzhu").innerHTML="♠2";
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			});}
			else if(this.id=="hongtao"){//判断哪一种牌型
			$("#hongtao").click(function(){
			document.getElementById("liangzhu").innerHTML="♥2";	
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			});}
			else if(this.id=="meihua"){//判断哪一种牌型
			$("#meihua").click(function(){
			document.getElementById("liangzhu").innerHTML="♣2";
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
				document.getElementById("heitao").style.color="black";
				document.getElementById("hongtao").style.color="black";
				document.getElementById("meihua").style.color="black";
				document.getElementById("fangkuai").style.color="black";
			});}
			else if(this.id=="fangkuai"){//判断哪一种牌型
			$("#fangkuai").click(function(){
			document.getElementById("liangzhu").innerHTML="♦2";
			document.getElementById("dawang").style.color="black";
			document.getElementById("xiaowang").style.color="black";	
				document.getElementById("heitao").style.color="black";
				document.getElementById("hongtao").style.color="black";
				document.getElementById("meihua").style.color="black";
				document.getElementById("fangkuai").style.color="black";
			});}
			else if(this.id=="dawang"){//判断哪一种牌型
			$("#dawang").click(function(){
			document.getElementById("liangzhu").innerHTML="♚♚♚♚";
			document.getElementById("dawang").style.color="black";	
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			});}
			else if(this.id=="xiaowang"){//判断哪一种牌型
			$("#xiaowang").click(function(){
			document.getElementById("liangzhu").innerHTML="♖♖♖♖";
			document.getElementById("dawang").style.color="black";	
			document.getElementById("xiaowang").style.color="black";	
			document.getElementById("heitao").style.color="black";
			document.getElementById("hongtao").style.color="black";
			document.getElementById("meihua").style.color="black";
			document.getElementById("fangkuai").style.color="black";
			});}
			}
			});
				
			
				console.log(A1);
				console.log(B1);
				console.log(C1);
				console.log(D1);
				
				console.log("newA:"+newA);
				console.log("newA长度:"+newA.length);
				console.log("A:"+A);
				console.log("B:"+B);
				console.log("C:"+C);
				console.log("D:"+D);
				document.getElementById("A").innerHTML=A;
				document.getElementById("B").innerHTML=B;
				document.getElementById("C").innerHTML=C;
				document.getElementById("D").innerHTML=D;
				
				
			}