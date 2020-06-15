// JavaScript Document
$(function(){
    $("#loading").css("display", "none"); //加载动画

    /*弹出窗口封装代码*/
    $(".alert_page").on("click",
    function() {

        $("#menu_start").css("display", "none"); //收起开始菜单
        $('#rightMenu').css('display', 'none'); //右键菜单消失
        if (($(".taskContainer .taskGroup").length + 1) * 113 >= $(window).width() - 190) {
            layer.msg('打开窗口过多，请先关闭一些窗口');
            return false;
        }

        var id = $(this).data("id");

        //窗口已存在
        if ($(".d" + id).length >= 1) {

            var listdata = [];
            $(".desk_page").each(function() {
                listdata += parseInt($(this).css("z-index")) + ",";
                return listdata;
            });
            var indexarr = listdata.split(',');
            var nowZindex = Math.max.apply(null, indexarr) + 1;

            $(".desk_page").removeClass("aui_state_focus");
            $(".d" + id).addClass("aui_state_focus");
            $(".d" + id).css("display", "block");
            $(".d" + id).css("z-index", nowZindex);

            $("#taskContainer .taskGroup").removeClass("taskCurrent");
            $("#t" + id).addClass("taskCurrent");

            return false;

        }

        //窗口不存在
        title = $(this).data("title"); //获得标题
        url = $(this).attr("href") //获得打开URL
        icon = $(this).data("icon"); //获得标题
        width = $(this).data("width") ? $(this).data("width") : document.body.clientWidth * 0.8,
        //获得宽度
        height = $(this).data("height") ? $(this).data("height") : document.body.clientHeight * 0.82 //获得高度
        height = $(document).height() < height ? '80%': height;
        $.dialog.open(url, {
            id: id,
            content: '',
            title: title,
            width: width,
            height: height,
            max: true,
            min: true,
            fixed: true,
            lock: false,
            init: function() {

                $("#taskContainer .taskGroup").removeClass("taskCurrent");
                $("#taskContainer").append('<div class="taskGroup taskCurrent" id="t' + id + '"><div class="taskItemIcon"><img src="' + icon + '"/></i></div><div class="taskItemTxt">' + title + '</div></div>');

				//清除弹出层
				$('#menu_start').hide();
				$('.desk_rili').hide();
				$('.desk_more').hide();
				$('.desk_div').hide();

            },
            close: function() {

                $('#taskContainer #t' + id).remove();

            }
        });

        return false;

    });

    //任务栏控制
    $("body").on("click", ".taskGroup",
    function() {

        $("#taskContainer .taskGroup").removeClass("taskCurrent");
        $(this).addClass("taskCurrent");

        var id = $(this).attr('id').replace("t", ""); // 获取数字id
        var listdata = [];
        $(".desk_page").each(function() {
            listdata += parseInt($(this).css("z-index")) + ",";
            return listdata;
        });
        var indexarr = listdata.split(',');
        var nowZindex = Math.max.apply(null, indexarr) + 1;

        $(".desk_page").removeClass("aui_state_focus");
        $(".d" + id).addClass("aui_state_focus");
        $(".d" + id).css("display", "block");
        $(".d" + id).css("z-index", nowZindex);

    });

    //右键菜单
    //屏蔽浏览器右键菜单
    document.oncontextmenu = function() {
        return false;
    }

    //按下鼠标
    $(document).mousedown(function(e) {

        var key = e.which; //获取鼠标键位
        if (key == 3) //(1:代表左键； 2:代表中键； 3:代表右键)
        {
            //获取右键点击坐标
            var x = e.clientX;
            var y = e.clientY;

            $("#rightMenu").show().css({
                left: x,
                top: y
            });
        }
    });

    //点击任意部位隐藏
    $(document).click(function() {
        $("#rightMenu").hide();
    })

});

/*$("body").mousedown(function(event){

	
if(event.button == 0){

	var e = e || window.event; //浏览器兼容性 
	var elem = e.target || e.srcElement;
	while (elem) { //循环判断至跟节点，防止点击的是div子元素 
		if (elem.id && elem.id == 'rightMenu') {
			return;
		}
		elem = elem.parentNode;
	}
	$('#rightMenu').css('display', 'none'); //点击的不是div或其子元素 
   
   
}else if(event.button == 2){

	//鼠标右键
	window.oncontextmenu=function(e){
	//取消默认的浏览器自带右键 很重要！！
	e.preventDefault();

	
	//根据事件对象中鼠标点击的位置，进行定位
	document.querySelector("#rightMenu").style.left=e.clientX+'px';
	document.querySelector("#rightMenu").style.top=e.clientY+'px';
	}
	
	
	$("#rightMenu").css("display","block");

}

})*/

function show_desktop() {
    $(".desk_page").css("display", "none");
    $('#rightMenu').css('display', 'none');
}

function closeall() {

    art.dialog({
        content: '是否确定关闭所有窗口?',
        icon: 'error',
        zindex: '99999',
        ok: function() {

            var list = art.dialog.list;
            for (var i in list) {
                list[i].close();
            };

        },
        cancelVal: '关闭',
        cancel: true //为true等价于function(){}
    });
    $('#rightMenu').css('display', 'none');

}

$("#desk_lock_btn").on("click", function() {
	
	
//询问框

layer.confirm('是否立即锁屏？', {
  btn: ['确定','取消'],icon:7
}, function(index){

$.ajax({
	url: "/index.php/login/locks",
	data: {action:'lock'},
	type:'post',
	dataType:'json',
	success:function(data){
		if (data.code=='100') {
        $(".lock_desktop").css("display","block");
		}else{
		layer.msg('失败：'+data.msg,{icon:5,zIndex:9999999999,time:2000});	
		}
	},
	error:function(data){
		layer.msg('失败：'+data.msg,{icon:5,zIndex:9999999999,time:2000});
	}
});

layer.close(index);

});

});

$("#unlock_btn").on("click", function() {
	
var unlock_pwd = $.trim($("#unlock_pwd").val());
if(unlock_pwd==""){
	layer.msg("请输入登录密码 ^_^ ",{icon:5,anim:5,zIndex:9999999999,time:2000});
	return false;
}

$.ajax({
	url: "/index.php/login/locks",
	data: {action:'unlock',userpwd:unlock_pwd},
	type:'post',
	dataType:'json',
	success:function(data){
		if (data.code=='100') {
        $(".lock_desktop").css("display","none");
		}else{
		layer.msg('失败：'+data.msg,{icon:5,zIndex:9999999999,time:2000});	
		}
	},
	error:function(data){
		layer.msg('失败：'+data.msg,{icon:5,zIndex:9999999999,time:2000});
	}
});


});



$(window).resize(function() {
    arrange();
});

arrange();

//排列图标
function arrange() {
    //位置坐标
    var position = {
        x: 5,
        y: 7,
        bottom: 40,
        width: 84,
        height: 100
    };

    All_height = $(window).height() - 40; //桌面图标区域总高度
    All_width = $(window).width();

    $(".appList").css("height", All_height + "px");

    $(".appList").find(".desk_app").each(function(index) {

        $(this).css("left", position.x + "px");
        $(this).css("top", position.y + "px");

        position.height = $(this).height();
        position.width = $(this).width();

        position.y = position.y + position.height + 10;

        if (position.y + position.height >= All_height) {
            position.y = 7;
            position.x = position.x + position.width + 5;
        }
    });

    //开始菜单右侧图标	
    $("#links li:eq(0)").css("width", "208px");
    $("#links li:eq(6)").css("width", "208px");
    $("#links li:eq(7)").css("width", "208px");
}

//任务栏时间开始
getNowFormatDate()

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var minutes = date.getMinutes();
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (minutes >= 0 && minutes <= 9) {
        minutes = "0" + minutes;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate + " " + date.getHours() + seperator2 + minutes + seperator2 + date.getSeconds();
    var time_ymd = date.getFullYear() + seperator1 + month + seperator1 + strDate;
    var time_hs = date.getHours() + seperator2 + minutes;

    $("#time-ymd").html(time_ymd);
    $("#time-hs").html(time_hs);
}

setInterval("getNowFormatDate()", 1000);

//任务栏时间结束

//主题设置
function save_theme_id(themeid, bgurl) {
    $("body").css("background-image", "url(" + bgurl + ")");
    $.post("index.php/theme/save_ajax", {
        id: themeid
    },
    function(data) {
        if (data == "success") {
            layer.msg("设置成功");
        } else {
            layer.msg("设置失败")
        }
    })
}

//色彩设置
function save_theme_color(color) {
    $(".aui_title").css("background-color", color);
	$(".aui_header").css("border-color", color);
    if(color=='#F9F9F9'){
	$(".aui_state_focus .aui_title , .aui_title").css("color", "#2d2c2c");
	$(".aui_min").css("background", "url(/themes/default/js/skin/default/min-win.png) center center no-repeat");
	$(".aui_max").css("background", "url(/themes/default/js/skin/default/max-win.png) center center no-repeat");
	$(".aui_close").css("background", "url(/themes/default/js/skin/default/close-win.png) center center no-repeat");
    }else{
	$(".aui_state_focus .aui_title , .aui_title").css("color", "#ffffff");	
	$(".aui_min").css("background", "url(/themes/default/js/skin/default/min.png) center center no-repeat");
	$(".aui_max").css("background", "url(/themes/default/js/skin/default/max.png) center center no-repeat");
	$(".aui_close").css("background", "url(/themes/default/js/skin/default/close.png) center center no-repeat");
	}
	
    $.post("index.php/theme/save_color_ajax", {
        color: color
    },
    function(data) {
        if (data == "success") {
            layer.msg("设置成功");
        } else {
            layer.msg("设置失败")
        }
    })
}

//注销登录
$(".logout").on("click",
function() {
    $('#rightMenu').hide();
    $(".desktop-menu").hide();
    layer.alert("确定要注销登录吗?", {
        icon: 0,
        btn: ["确定", "取消"],
        zIndex: parseInt(99999999 + 1000),
        yes: function(index, layero) {
            $.post("/index.php/login/logout", {},
            function(data) {
                if (data.code=='100') {
                    layer.msg("注销成功");
                    location.href='/';
                } else {
                    layer.msg("操作失败")
                }
            },'json')
        },
        end: function() {}
    })
});


$("#layui-layim-new").on("click", function() {

$(".layui-layim").toggle();

});


$("#changefg").on("click", function() {
	layer.alert("是否要切换系统风格?", {
		icon: 0,
		zIndex:10000001,
		btn: ["确定", "取消"],
		yes: function(index, layero) {
			$.post("/index.php/home/theme_change", {}, function(data) {
				if (data.code=='1') {
					layer.msg(data.msg,{zIndex:10000001,anim:1,maxWidth:500,icon:1,time:1000,end:function(){window.location.reload();}});
				} else {
					layer.msg("操作失败")
				}
			},'json')
		},
		end: function() {}
	})
});
	
$(".start-win-btn").on("click",function() {
	$('#menu_start').slideToggle("fast");
	$(".desk_more").hide();
	$('.desk_rili').hide();
	$('.desk_div').show();
	
	var listdata = [];
	$(".desk_page").each(function() {
		listdata += parseInt($(this).css("z-index")) + ",";
		return listdata;
	});
	var indexarr = listdata.split(',');
	var nowZindex = Math.max.apply(null, indexarr) + 1;

	$("#menu_start").css("z-index", nowZindex);
	
});
	

$(".taskbar-more").on("click",function() {
	$(".desk_more").slideToggle();
	$('#menu_start').hide();
	$('.desk_rili').hide();
	$('.desk_div').show();
});

$('.taskbar-time').on('click',function(){
	$('.desk_rili').slideToggle();
	$('#menu_start').hide();
	$('.desk_more').hide();
	$('.desk_div').show();
})


$('.desk_div').on('click',function(){
	$('#menu_start').hide();
	$('.desk_rili').hide();
	$('.desk_more').hide();
	$('.desk_div').hide();
})



