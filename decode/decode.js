


var getPassword1=[];
var getPassword2=[];
var message;
function getClickNum(id){//点击输入密码
var password = id;
var key;
			if(password=="zero"){
				key=0;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="one"){
				key=1;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="two"){
				key=2;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="three"){
				key=3;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="four"){
				key=4;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="five"){
				key=5;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="six"){
				key=6;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="seven"){
				key=7;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="eight"){
				key=8;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="nine"){
				key=9;	console.log("你点击的按键是："+key);getPassword1.push(key);}
			else if(password=="setPassword"){
				key="setPassword";
				console.log("你点击的按键是："+key);
				console.log("111你第一次输入的密码是："+getPassword2);
				console.log("111你第二次输入的密码是："+getPassword1);
				$("#setPassword").remove();
				$("#bottom").append('<input class="setPassword" id="comfirm" type="button" onclick="getClickNum(this.id)" value="确定"/>');
				alert("请输入密码，然后按确定键");
			}else if(password=="comfirm"){
				key="comfirm";
				console.log("你点击的按键是："+key);
				console.log("222你第一次输入的密码是："+getPassword1);
				console.log("222你第二次输入的密码是："+getPassword2);
				console.log("你输入的密码是"+getPassword1);
				for(var i=0;i<getPassword1.length;i++){
					getPassword2.push(getPassword1[i]);
				}
				getPassword1.length=0;
				$("#comfirm").removeAttr("onlick")
				$("#comfirm").remove();
				$("#bottom").append('<input class="setPassword" id="comfirmagain" type="button" onclick="getClickNum(this.id)" value="再次确定"/>');
				alert("请再输入一次密码，然后按确定键");
				
			}else if(password=="comfirmagain"){
				key="comfirmagain";
				console.log("你点击的按键是："+key);
				console.log("333你第一次输入的密码是："+getPassword2);
				console.log("333你第二次输入的密码是："+getPassword1);
				for(var i=0;i<getPassword2.length;i++){
				if(getPassword1.length==getPassword2.length&&getPassword1[i]==getPassword2[i]){
					console.log("两次输入密码相同，设置成功！");
					message="两次输入密码相同，设置成功！";
				}else{
					console.log("两次输入密码不一致，请重新设置！");
					message="两次输入密码不一致，请重新设置！";
					getPassword1.length=0;
					getPassword2.length=0;
					return ;
				}	
				}
				alert(message);
				$("#comfirmagain").remove();
				$("#bottom").append('<input class="setPassword" id="setPassword" type="button" onclick="getClickNum(this.id)" value="设置密码"/>	');
			}		
}
function decodePassword(){
	alert("破解的密码是："+getPassword2+"请输入密码后按确认解锁");
	console.log("111getPassword1=="+getPassword1+";getPassword2==="+getPassword2);
	getPassword1.length=0;
	console.log("222getPassword1=="+getPassword1+";getPassword2==="+getPassword2);
	$("#decodePassword").remove();
	$("#ComfirmDecode").remove();
	$("#bottom").append('<input class="decodePassword" id="ComfirmDecode" type="button" onclick="ComfirmDecode()" value="确认解锁"/>	');
}
function ComfirmDecode(){
	console.log("3333getPassword1=="+getPassword1+";getPassword2==="+getPassword2);
	for(var i=0;i<getPassword1.length;i++){
		if(getPassword1.length==getPassword2.length&&getPassword1[i]==getPassword2[i]){
			message="破解密码成功！";
		}else{
			message="输入密码有误，破解密码失败！";
			return decodePassword();
		}
	}
	if(message=="破解密码成功！"){
		$("#screen button").remove();
		$("#screen").append("<div class=\"success\">恭喜你解锁成功！</div>");
	}
	console.log("444getPassword1=="+getPassword1+";getPassword2==="+getPassword2);
}