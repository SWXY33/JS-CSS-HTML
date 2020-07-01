var pokers=[];
				pokers[0]="4.jpg",pokers[1]="5.jpg",pokers[2]="6.jpg",pokers[3]="7.jpg",pokers[4]="8.jpg",pokers[5]="9.jpg",pokers[6]="10.jpg",
				pokers[7]="11.jpg",pokers[8]="12.jpg",pokers[9]="13.jpg",pokers[10]="14.jpg",pokers[11]="15.jpg",pokers[12]="3.jpg",pokers[13]="17.jpg",
				pokers[14]="18.jpg",pokers[15]="19.jpg",pokers[16]="20.jpg",pokers[17]="21.jpg",pokers[18]="22.jpg",pokers[19]="23.jpg",pokers[20]="24.jpg",
				pokers[21]="25.jpg",pokers[22]="26.jpg",pokers[23]="27.jpg",pokers[24]="28.jpg",pokers[25]="16.jpg",pokers[26]="30.jpg",pokers[27]="31.jpg",
				pokers[28]="32.jpg",pokers[29]="33.jpg",pokers[30]="34.jpg",pokers[31]="35.jpg",pokers[32]="36.jpg",pokers[33]="37.jpg",pokers[34]="38.jpg",
				pokers[35]="39.jpg",pokers[36]="40.jpg",pokers[37]="41.jpg",pokers[38]="29.jpg",pokers[39]="43.jpg",pokers[40]="44.jpg",pokers[41]="45.jpg",
				pokers[42]="46.jpg",pokers[43]="47.jpg",pokers[44]="48.jpg",pokers[45]="49.jpg",pokers[46]="50.jpg",pokers[47]="51.jpg",pokers[48]="52.jpg",
				pokers[49]="53.jpg",pokers[50]="54.jpg",pokers[51]="42.png";

 /*工厂模式创建各种牌
     *number:牌上的数字
     *type:牌的花色
	 *img:牌的图片
     */
	var RadomCards = [];//随机牌存储数组
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
var arr = [];
var tmp;
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
				console.log("111pokers[j].number====="+pokers[j].number+"pokers[j+1].number========"+pokers[j+1].number)
					tmp = pokers[j];
					pokers[j] = pokers[j+1];
					pokers[j+1] = tmp;
					
				}else if(pokers[j].number==pokers[j+1].number){//牌面值相同时按花色大小排序
				console.log("222pokers[j].number====="+pokers[j].number+"pokers[j+1].number========"+pokers[j+1].number)
						if(pokers[j].type<pokers[j+1].type){
							tmp = pokers[j];
							pokers[j] = pokers[j+1];
							pokers[j+1] = tmp;
						}
					}
			}
			
				
		}
		}	
	






    function CreatCompeleteCard() {
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
			for(var y=0;y<arr.length;y++){
			//console.log("洗牌后：花色类型==="+arr[y].type+"；牌面数字为："+arr[y].number+"；扑克牌图片是："+arr[y].img);	
			}
			
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
//扑克牌排序
	SortType(A);	
	SortType(B);
	SortType(C);
	SortType(D);
	
			for(var i=0;i<13;i++){
				$("#A").append("<div class='poker' id='pokerA_"+i+"'><img src='img/"+A[i].img+"'/></div>");
				$("#B").append("<div class='poker' id='pokerB_"+i+"'><img src='img/"+B[i].img+"'/></div>");
				$("#C").append("<div class='poker' id='pokerC_"+i+"'><img src='img/"+C[i].img+"'/></div>");
				$("#D").append("<div class='poker' id='pokerD_"+i+"'><img src='img/"+D[i].img+"'/></div>");
			}	
				 
        }
       





function sort(){
	$('div[class^="poker"]').remove();
	sortagain(A);
	sortagain(B);
	sortagain(C);
	sortagain(D);
	for(var i=0;i<13;i++){
		$("#A").append("<div class='poker' id='pokerA_"+i+"'><img src='img/"+A[i].img+"'/></div>");
		$("#B").append("<div class='poker' id='pokerB_"+i+"'><img src='img/"+B[i].img+"'/></div>");
		$("#C").append("<div class='poker' id='pokerC_"+i+"'><img src='img/"+C[i].img+"'/></div>");
		$("#D").append("<div class='poker' id='pokerD_"+i+"'><img src='img/"+D[i].img+"'/></div>");
	}
}				

function start(){
    CreatCompeleteCard();
		
	setTimeout(function() { $("#start").remove(); });
	$(".ready").append("<button class='again'><a href='javascript:location.reload();'> 再来一局</a></button>");

	document.getElementById("operateB").style.visibility="visible";//显示亮主牌选择区


			setTimeout(function() { 
			 $("#operateB").append(
			 "<button class='operate1' id='sort' style='background-color:#aaaaff' onclick='sort()'>排序</button>"+
			 "<button class='operate1' id='hint' style='background-color:#55aaff'>提示</button>"+
			 "<button class='operate1' id='out'style='background-color:#00aa00' onclick='outB()'>出牌</button>"+
			 "<button class='operate1' id='pass' style='background-color:#d30b4b'>不要</button>"+
			 "<button class='operate1' id='last' style='background-color:#aaffff' onclick='Before()'>上轮</button>");}, 1000);
			//出牌
		
		}
	
		


