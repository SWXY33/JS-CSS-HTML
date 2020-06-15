//写Cookie
function addCookie(objName, objValue, objHours) {
    var str = objName + "=" + escape(objValue);
    if (objHours>0) {//为0时不设定过期时间，浏览器关闭时cookie自动消失
        var date = new Date();
        var ms = objHours * 3600 * 1000;
        date.setTime(date.getTime() + ms);
        str += "; expires=" + date.toGMTString();
    }
    document.cookie = str;
}

//读Cookie
function getCookie(objName) {//获取指定名称的cookie的值
    var arrStr = document.cookie.split("; ");
    for (var i = 0; i < arrStr.length; i++) {
        var temp = arrStr[i].split("=");
        if (temp[0] == objName) return unescape(temp[1]);
    }
    return "";
}

//页面加载完成时执行
$(function () {
    //点击切换按钮
    $(".icon-menu").click(function () {
        toggleMainMenu(); //切换按钮显示事件
    });
    loadMenuTree(true); //加载管理首页左边导航菜单
    mainiframeResize(); //主页面响应式

    //页面尺寸改变时
    $(window).resize(function () {
        //延迟执行,防止多次触发
        setTimeout(function () {
            mainiframeResize(); //主页面响应式
            popMenuTreeResize(); //快捷菜单的设置
        }, 100);
    });
});

//导航菜单显示和隐藏
function mainiframeResize() {
    var docWidth = $(window).width();
    if (docWidth > 1180) {
        $("body").removeClass("lay-mini");
        $("#main-nav").show();
        $(".nav-right").show();
    } else {
        $("body").addClass("lay-mini");
        $("#main-nav").hide();
    }
}

//切换按钮显示事件
function toggleMainMenu(){
	$("body").toggleClass("lay-mini");
	if(!$("body").hasClass("lay-mini") && $(window).width() > 1180){
		$("#main-nav").show();
		$(".nav-right").show();
	}else{
		$("#main-nav").hide();
		if(($(".main-top").width()-42) < $(".nav-right").width()){
			$(".nav-right").hide();
		}else{
			$(".nav-right").show();
		}
	}
}

//加载管理首页左边导航菜单
function loadMenuTree(_islink) {
	//判断是否跳转链接
	var islink = false;
	if (arguments.length == 1 && _islink) {
		islink = true;
	}
    //发送AJAX请求
    $.ajax({
        type: "get",
        url: "/index.php/menu/lists/?action=get_nav_list&time=" + Math.random(),
        dataType: "html",
        success: function (data, textStatus) {
            //将得到的数据插件到页面中
            $("#sidebar-nav").html(data);
            $("#pop-menu .list-box").html(data);
            //初始化导航菜单
            initMenuTree(islink);
            initPopMenuTree();
        }
    });
}

//初始化导航菜单
function initMenuTree(islink) {
	var navObj = $("#main-nav");
	var navGroupObj = $("#sidebar-nav .list-group");
	var navItemObj = $("#sidebar-nav .list-group .list-wrap");
	//先清空NAV菜单内容
	navObj.html('');
	navGroupObj.each(function (i) {
		//添加菜单导航
        var navHtml = $('<a>' + $(this).children("h1").attr("title") + '</a>').appendTo(navObj);
		//默认选中第一项
		if (i == 0) {
			//$(this).show();
			$(this).css("display","block");
			navHtml.addClass("selected");
		}
		//没有子菜单恩德隐藏顶部导航
		if(navGroupObj.eq($(this).index()).find("ul li ul li a").length<=0){
		navObj.children("a").eq($(this).index()).css("display","none");
		}
		
		//为菜单添加事件
		navHtml.click(function () {
			navObj.children("a").removeClass("selected");
			$(this).addClass("selected");
			//默认选中菜单;
			navGroupObj.hide();
			navGroupObj.eq(navObj.children("a").index($(this))).show();
			//先判断存在选中菜单记录
			//if(navGroupObj.eq(navObj.children("a").index($(this))).find("ul li ul li a.selected").length<=0){
			navGroupObj.eq(navObj.children("a").index($(this))).find("ul li ul li a").removeClass("selected");
			navGroupObj.eq(navObj.children("a").index($(this))).find("ul li ul li:nth-child(1) a").addClass("selected");
			//}
			//navGroupObj.find("ul li:nth-child(1) ul li:nth-child(1) a").addClass("selected");
			//检查是否需要跳转链接
			default_url = navGroupObj.eq(navObj.children("a").index($(this))).find("ul li ul li:nth-child(1) a").attr("href");
			default_navid = navGroupObj.eq(navObj.children("a").index($(this))).find("ul li ul li:nth-child(1) a").attr("navid");
			if (default_url) {
				frames["mainiframe"].location.href = default_url;
				if (default_navid) {
				addCookie("dt_manage_navigation_cookie", default_navid, 240);
				}
			}
			
        });
		//首先隐藏所有的UL
		$(this).find("ul").show();
		//绑定树菜单事件.开始
		$(this).find("ul").each(function (j) { //遍历所有的UL
			//遍历UL第一层LI
			$(this).children("li").each(function () {
				var liObj = $(this);
				//判断是否有子菜单和设置距左距离
				var parentIconLenght = liObj.parent().parent().children("a").children(".zhu").length; //父节点的左距离
				//设置左距离
				var lastIconObj;

				//如果有下级菜单
				if (liObj.children("ul").length>0) {
					liObj.children("a").removeAttr("href"); //删除链接，防止跳转
					//隐藏下级的UL
					liObj.children("ul").show();
					//绑定单击事件
					liObj.children("a").click(function () {
						//如果菜单已展开则闭合
						if($(this).children(".zhu").hasClass("fa-chevron-down")){
							//设置自身的右图标为+号
							$(this).children(".zhu").removeClass("fa-chevron-down");
							$(this).children(".zhu").addClass("fa-chevron-up");
							//隐藏自身父节点的UL子菜单
							$(this).parent().children("ul").slideUp(300);
						}else{
							//搜索所有同级LI且有子菜单的右图标为+号及隐藏子菜单
							/*$(this).parent().siblings().each(function () {
								if ($(this).children("ul").length>0) {
									//设置自身的右图标为+号
									$(this).children("a").children(".zhu").removeClass("fa-chevron-down");
									$(this).children("a").children(".zhu").addClass("fa-chevron-up");
									//隐藏自身子菜单
									$(this).children("ul").slideUp(300);
								}
							});*/
							//设置自身的右图标为-号
							$(this).children(".zhu").removeClass("fa-chevron-up");
							$(this).children(".zhu").addClass("fa-chevron-down");
							//显示自身父节点的UL子菜单
							$(this).parent().children("ul").slideDown(300);
						}
					});
					
				}else{
					//如果a有自定义图标则将图标插入，否则使用默认的样式
					if(typeof(liObj.children("a").attr("href"))!="undefined"){
						//绑定单击事件
						liObj.children("a").click(function () {
							//删除所有的选中样式
							navGroupObj.find("ul li a").removeClass("selected");
							//删除所有的list-group选中样式
							navGroupObj.removeClass("selected");
							//删除所有的main-nav选中样式
							navObj.children("a").removeClass("selected");
							//自身添加样式
							$(this).addClass("selected");
							//设置父list-group选中样式
							$(this).parents(".list-group").addClass("selected");
							//设置父main-nav选中样式
							navObj.children("a").eq(navGroupObj.index($(this).parents(".list-group"))).addClass("selected");
							//隐藏所有的list-group
							navGroupObj.hide();
							//显示自己的父list-group
							$(this).parents(".list-group").show();
							//保存到cookie
							if(typeof($(this).attr("navid"))!="undefined"){
								addCookie("dt_manage_navigation_cookie", $(this).attr("navid"), 240);
							}
						});
					}
				}

			});
			//显示第一个UL
			if (j == 0) {
				$(this).show();
				//展开第一个菜单
				/*if ($(this).children("li").first().children("ul").length>0) {
					$(this).children("li").first().children("ul").show();
				}*/
				//展开所有子菜单
				if ($(this).children("li").children("ul").length>0) {
					$(this).children("li").children("ul").show();
				}
			}
		});
		//绑定树菜单事件.结束
	});
	//定位或跳转到相应的菜单
    linkMenuTree(islink);
}

//定位或跳转到相应的菜单
function linkMenuTree(islink, navid) {
	var navObj = $("#main-nav");
	var navGroupObj = $("#sidebar-nav .list-group");
	var navItemObj = $("#sidebar-nav .list-group .list-wrap");
	
	//读取Cookie,如果存在该ID则定位到对应的导航
	var cookieObj;
	var argument = arguments.length;
	if (argument == 2) {
		cookieObj = navGroupObj.find('a[navid="' + navid + '"]');
	} else {
		cookieObj = navGroupObj.find('a[navid="' + getCookie("dt_manage_navigation_cookie") + '"]');
	}
	if (cookieObj.length>0) {
		//显示所在的导航和组
		//删除所有的选中样式
		navGroupObj.find("ul li a").removeClass("selected");
		//删除所有的list-group选中样式
		navGroupObj.removeClass("selected");
		//删除所有的main-nav选中样式
		navObj.children("a").removeClass("selected");
		//自身添加样式
		cookieObj.addClass("selected");
		//设置父list-group选中样式
		cookieObj.parents(".list-group").addClass("selected");
		//设置父main-nav选中样式
		navObj.children("a").eq(navGroupObj.index(cookieObj.parents(".list-group"))).addClass("selected");
		//隐藏所有的list-group
		navGroupObj.hide();
		//显示自己的父list-group
		cookieObj.parents(".list-group").show();
		//遍历所有的LI父节点
		cookieObj.parents("li").each(function () {
			//搜索所有同级LI且有子菜单的右图标为+号及隐藏子菜单
			$(this).siblings().each(function () {
				if ($(this).children("ul").length>0) {
					//设置自身的右图标为+号
					//$(this).children("a").children(".zhu").removeClass("fa-chevron-down");
					//$(this).children("a").children(".zhu").addClass("fa-chevron-up");
					//隐藏自身子菜单
					$(this).children("ul").show();
				}
			});
			//设置自身的右图标为-号
			if ($(this).children("ul").length>0) {
				//$(this).children("a").children(".zhu").removeClass("fa-chevron-up");
				//$(this).children("a").children(".zhu").addClass("fa-chevron-down");
			}
			//显示自身的UL
			$(this).children("ul").show();
		});
		//检查是否需要保存到cookie
		if (argument == 2) {
			addCookie("dt_manage_navigation_cookie", navid, 240);
		}
		//检查是否需要跳转链接
		if (islink == true && cookieObj.attr("href") != "" && cookieObj.attr("href")!= "#") {
			frames["mainiframe"].location.href = cookieObj.attr("href");
		}
	} else if (argument == 2) {
		//删除所有的选中样式
		navGroupObj.find("ul li a").removeClass("selected");
		//保存到cookie
		addCookie("dt_manage_navigation_cookie", "", 240);
	}
}

//初始化快捷导航菜单
function initPopMenuTree() {
	//遍历及加载事件
	$("#pop-menu .pop-box .list-box li").each(function () {
		var linkObj = $(this).children("a");
		linkObj.removeAttr("href");
		if ($(this).children("ul").length>0) { //如果无下级菜单
			linkObj.addClass("nolink");
		}else{
			linkObj.addClass("link");
			linkObj.click(function () {
				linkMenuTree(true, linkObj.attr("navid")); //加载函数
			});
		}
	});
	//设置快捷菜单容器的大小
	popMenuTreeResize();
}

//设置快捷菜单容器的大小
function popMenuTreeResize() {
	//计算容器的宽度
	var groupWidth = $("#pop-menu .list-box .list-group").outerWidth();
	var divWidth = $("#pop-menu .list-box .list-group").length * groupWidth;
	var winWidth = $(window).width();
	if(divWidth > winWidth){
		var groupCount = Math.floor(winWidth/groupWidth);
		if(groupCount>0){
			groupWidth = groupWidth*groupCount;
		}
	}else{
		groupWidth = divWidth;
	}
	$("#pop-menu .pop-box").width(groupWidth);
	//只有显示的时候才能设置高度
	if($("#pop-menu").css("display") == "block"){
		setPopMenuHeight();
		//重设导航滚动条
		$("#pop-menu .list-box").getNiceScroll().resize();
	}
}

//设置快捷菜单的高度
function setPopMenuHeight(){
	//计算容器的高度
	var divHeight = $(window).height() * 0.6;
	var groupHeight = 0;
	$("#pop-menu .list-box .list-group").each(function () {
		if($(this).height() > groupHeight) {
			groupHeight = $(this).height();
		}
	});
	if (divHeight > groupHeight) {
		divHeight = groupHeight;
	}
	$("#pop-menu .list-box .list-group").height(groupHeight);
	$("#pop-menu .pop-box").height(divHeight);
}

//快捷菜单的显示与隐藏
function togglePopMenu() {
	if($("#pop-menu").css("display")=="none"){
		$("#pop-menu").show();
		//只有显示的时候才能设置高度
		setPopMenuHeight();
		//设置导航滚动条
		$("#pop-menu .list-box").niceScroll({ touchbehavior:false, cursorcolor:"#ccc", cursoropacitymax:0.6, cursorwidth:5, autohidemode:false });
	}else{
		$("#pop-menu").hide();
		$("#pop-menu .list-box").getNiceScroll().remove();
	}
}