$(function(){
	//载入声音文件
    $('<audio id="orderAudio"><source src="' + path + '/voice/orderNotify.mp3" type="audio/mpeg" /></audio>').appendTo('body');
    /*$("#trig").click(function(){
    	var a = $("#chatData").val().trim();//获取输入的内容
    	if(a.length > 0){
    		$("#chatData").val(''); //清空输入框
    		$("#chatData").focus(); //获得焦点
    		$("<li></li>").html('<img src="/images/qq.gif"/><span>'+a+'</span>')
    			.appendTo("#chatMessages");//将输入的内容追加的聊天区
    		$("#chat").animate({"scrollTop": $('#chat')[0].scrollHeight}, "slow");//调整滚动条
    		$('#orderAudio')[0].play(); //播放声音 
        }
    });*/
});