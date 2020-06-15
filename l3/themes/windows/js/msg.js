// JavaScript Document
$(function(){

	msg_top = $(window).height()-210-3; //桌面图标区域总高度
	msg_left = $(window).width()-320-3;
	ck_width=$(window).width()*0.5;
	ck_height=$(window).height()*0.5;
	
	//未读消息提醒开始
	var get_show_msg = function() {
	
		$.get("/index.php/message/msg_new",
		function(data) {
			
			$("#msg_nums").text(parseInt(data));
			
			if (parseInt(data) > 0) {
			$("#msg_nums").	show();	
				$.get("/index.php/message/get_msg_id",
				function(msg_id) {
					if (parseInt(msg_id) > 0) {
						new_msg(msg_id);
					}
				})
				
			}else{
			$("#msg_nums").	hide();
			}
		})
	};

	setInterval(get_show_msg,10000);
	
	function new_msg(msg_id){
	layer.open({
	  id: '101'+msg_id,
	  btn: ['<i class="fa fa-search"></i> 立即查看','忽略'],
	  type: 2,
	  anim: 2,
	  zIndex: 10000001,
	  title: '新消息提醒',
	  skin: 'new-msg',
	  area: ['320px', '210px'],
	  offset: [msg_top, msg_left],
	  shade: 0,
	  scrollbar: false,
	  content: '/index.php/message/view_min?id='+msg_id, //iframe的url
	  yes: function(index){
	  $.dialog.open('/index.php/message/view?id='+msg_id, {title:'处理消息',width:ck_width,height:ck_height,fixed:true,lock:false});
	  layer.close(index);
	  }
	});
	}
	
$(".taskbar-msg").on("click",
function() {

    $.get("/index.php/message/msg_new",
    function(data) {
        $("#msg_nums").text(data);
    });

    $(".taskbar-msg i.fa").removeClass('on-new-msg fa-commenting-o'); //不闪动了
    $(".tip_mp3").remove(); //关闭声音

    $.dialog.open('/index.php/message', {
        id: 1101,
        content: '',
        title: '未读消息',
        width: 1080,
        height: 520,
        max: true,
        min: true,
        fixed: true,
        lock: false,
        init: function() {
            //alert(1);	
        },
        close: function() {
            //alert(0);
        }
    });

    //点击消息图标
    /*	   layer.open({
	type: 2, 
	skin: 'msg-list-title',
	id: '9999',
	title: '<i class="fa fa-info-circle"></i> 消息提醒',
	content: '/index.php/message/weidu',
	zIndex:99999999,
	offset: 'rt',
	resize: true,
	area: ['420px', ($(window).height()-42)+'px' ],
	shade:0,
	//fixed:true,
	shadeClose:false,
	maxWidth: '80%',
	anim: 6
   });*/

});
//未读消息提醒结束


})



