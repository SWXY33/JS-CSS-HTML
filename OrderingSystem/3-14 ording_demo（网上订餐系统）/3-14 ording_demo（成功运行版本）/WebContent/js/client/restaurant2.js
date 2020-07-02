jQuery(function($){
	var storeInfUrl = path + '/business/openStore!getStoreInf.action'
		+ '?storeId=' + $('#storeId').val();
	lili.ajax.sys(storeInfUrl,null,function(data){
		if (!data || !data.id)return false;
		var newDiv = '<div class="store_menu"><div class="s_t"><img class="mystore_head" src="'
			+ images_server + data.logo.relativePath + '" /></div><div class="s_t">'
			+ '<div class="mystore_name">' + data.storeName + '</div><div class="mystar_rank">'
			+ '<span class="mystar_ranking"><span class="star_score">★★★★☆</span></span>'
			+ '<span class="mystar_num">4.3分</span><span class="mysale_num">月售3548单</span></div>'
			+ '<div class="myprice"><span class="mystart_price">起送：￥7</span>'
			+ '<span class="mysend_time"><span><img src="' + path
			+ '/icon/icon_send_time.jpg" />30分钟</span></span></div></div></div>';
		$('#order_manage_div').append(newDiv);
		var sDescribe = '<span class="gonggao">' + data.storeDescribe + '</span>';
		$('#sDescribeDiv').append(sDescribe);
	});
	var storeMeunsUrl = path + '/business/openStore!storeMenus.action'
		+ '?storeId=' + $('#storeId').val();
	lili.ajax.sys(storeMeunsUrl,null,function(data){
		if (data.length <= 0)return false;
		for(var i = 0; i < data.length; i++){
			var foodDiv = '<div class="store_food"><a href="#" title="' + data[i].menuName 
				+ '" class="' + data[i].id + '"><img class="store_head" src="'
				+ images_server + data[i].photo.relativePath + '" /></a>'
				+ '<div class="myfood_name" >' + data[i].menuName + '</div>'
				+ '<span class="mysale_num">月售35份</span><div class="myprice">'
				+ '<span class="mystart_price">￥<span class="priceNumSpan">' + data[i].menuPrice
				+ '</span>/份<a href="javascript:;" class="'
				+ data[i].id + '"><img src="' + path + '/icon/add2.png"/></a></span></div></div>';
			$('#store_foods_div').append(foodDiv);
		}
		$('.mystart_price').each(function() {
			$(this).children('a').click(function() {
				var aMenuId = $(this).attr('class');
				var theMenuName = $('.' + aMenuId+":eq(0)").attr('title');
				var imgSrc = $('.' + aMenuId + ':eq(0) img').attr('src');
				var priceStr = $(this).prev('span').text();
				$("#flyItem").find("img").attr("src", imgSrc);
				
				// 滚动大小
				var scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft||0;
				var scrollTop = document.documentElement.scrollTop||document.body.scrollTop||0;
				eleFlyElement.style.left = event.clientX + scrollLeft + "px";
                eleFlyElement.style.top = event.clientY + scrollTop + "px";
                eleFlyElement.style.visibility = "visible";
                
                // 需要重定位
                myParabola.position().move();
                
                if($('#quick_links_pop').find('.pop_panel').length == 0){
                	var fn = quickDataFns["message_list"];
    				var tmp = ds.tmpl(popTmpl, fn);
    				quickPop.html(tmp);
        			fn.init.call(this, fn);
                }
                
                var hasMenu = false;
                $('#shopCartUl li').each(function(){//判断购物车是否存在菜单
                	var aMenuName = $(this).find('div:eq(1) a:eq(0)').text();
                	if(aMenuName == theMenuName){
                		var cMenuNum = $(this).find('input:eq(0)').val().trim();
                		var cMenuNum2 = parseInt(cMenuNum);
                		var currPriceSpan = $(this).find('.priceNumSpan:last');
						var currPrice = currPriceSpan.text();
						var currPrice2 = parseFloat(currPrice);
						currPrice2 = currPrice2 / cMenuNum2;//单价
						currPrice2 = currPrice2 * cMenuNum2 + currPrice2;
						$(this).find('input:eq(0)').val(++cMenuNum2);//菜单个数
						currPriceSpan.text(currPrice2);//当前菜品总价钱
                		hasMenu = true;
                		return false;//跳出循环
                	}
                });
                
                var shopCartPrice = $('#total_cart_price').text();
				var shopCartPrice2 = parseFloat(shopCartPrice);
				var priceStr2 = parseFloat(priceStr);
				$('#total_cart_price').text(shopCartPrice2 + priceStr2);//购物车总价
				var shopCartNum = $('#total_cart_num').text();
				$('#total_cart_num').text(++shopCartNum);//购物车总数
				
				if(hasMenu)return;
				var newLi = '<li class="cart_item"><div class="cart_item_pic"><a href="#">'
					+'<img src="' + imgSrc + '" /></a></div>'
					+'<div class="cart_item_desc"><a href="#" class="cart_item_name">'
					+theMenuName+'</a><a style="display: none;">' + aMenuId + '</a>'
					+'<div class="cart_item_sku"><span class="mysale_num">'
					+'月售35份</span></div><div class="numDivfl modify clearfix">'
					+'<a href="javascript:;" class="numDivfl minus" onclick="aMinus(this)">-</a>'
					+'<input type="text" class="numDivfl txt-count" value="1 " maxlength="2">'
					+'<a href="javascript:;" class="numDivfl plus" onclick="aPlus(this)">+</a>'
					+'</div><div class="cart_item_price">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
					+'<span class="cart_price">￥<span class="priceNumSpan">'+priceStr
					+'</span></span></div></div></li>';
				$('#shopCartUl').append(newLi);
			});
		});
	});
	
	/*$('#shopCartUl li').each(function() {
		$(this).find('.plus:eq(0)').click(function() {
			
		});
		$(this).find('.minus:eq(0)').click(function() {
			
		});
	});*/
	
	/*加入购物车begin*/
	var eleFlyElement = document.querySelector('#flyItem');
	var eleShopCart = document.querySelector('#shopCart');
	// 抛物线运动
    var myParabola = funParabola(eleFlyElement, eleShopCart, {
    	speed: 400, //抛物线速度
    	curvature: 0.0008, //控制抛物线弧度
    	complete: function() {
    		eleFlyElement.style.visibility = 'hidden';
    		var shopCartNum = $('#total_cart_num').text();
            eleShopCart.querySelector('span').innerHTML = shopCartNum;
        }
    });
	/*加入购物车end*/
	
	/*购物车begin*/
	//创建DOM
	var 
	quickHTML = document.querySelector("div.quick_link_mian"),
	quickShell = $(document.createElement('div')).html(quickHTML).addClass('quick_links_wrap'),
	quickLinks = quickShell.find('.quick_links');
	quickPanel = quickLinks.next();
	quickShell.appendTo('.mui-mbar-tabs');
	
	//具体数据操作 
	var 
	quickPopXHR,
	loadingTmpl = '<div class="loading" style="padding:30px 80px">'
		+'<i></i><span>Loading...</span></div>',
	popTmpl = '<a href="javascript:;" class="ibar_closebtn" title="关闭"></a>'
		+'<div class="ibar_plugin_title"><h3><%=title%></h3></div>'
		+'<div class="pop_panel"><%=content%></div><div class="arrow"><i></i></div>'
		+'<div class="fix_bg"></div>',
	historyListTmpl = '<ul><%for(var i=0,len=items.length; i<5&&i<len; i++){%>'
		+'<li><a href="<%=items[i].productUrl%>" target="_blank" class="pic">'
		+'<img alt="<%=items[i].productName%>" src="<%=items[i].productImage%>"'
		+' width="60" height="60"/></a><a href="<%=items[i].productUrl%>" '
		+'title="<%=items[i].productName%>" target="_blank" '
		+'class="tit"><%=items[i].productName%></a><div class="price" title="单价">'
		+'<em>&yen;<%=items[i].productPrice%></em></div></li><%}%></ul>',
	newMsgTmpl = '<ul><li><a href="#"><span class="tips">新回复<em class="num">'
		+'<b><%=items.commentNewReply%></b></em></span>商品评价/晒单</a></li>'
		+'<li><a href="#"><span class="tips">新回复<em class="num"><b>'
		+'<%=items.consultNewReply%></b></em></span>商品咨询</a></li>'
		+'<li><a href="#"><span class="tips">新回复<em class="num"><b>'
		+'<%=items.messageNewReply%></b></em></span>我的留言</a>'
		+'</li><li><a href="#"><span class="tips">新通知<em class="num"><b>'
		+'<%=items.arrivalNewNotice%></b></em></span>到货通知</a></li><li>'
		+'<a href="#"><span class="tips">新通知<em class="num"><b><%=items.reduceNewNotice%>'
		+'</b></em></span>降价提醒</a></li></ul>',
	quickPop = quickShell.find('#quick_links_pop'),
	quickDataFns = {
		//购物信息
		message_list: {
			title: '购物车',
			content: '<div class="ibar_plugin_content"><div class="ibar_cart_group '
				+'ibar_cart_product"><div class="ibar_cart_group_header">'
				+'<a href="#">我的购物车</a></div><ul id="shopCartUl">'
				//+'<li class="cart_item">'
				//+'<div class="cart_item_pic"><a href="#"><img src="" /></a></div>'
				//+'<div class="cart_item_desc"><a href="#" class="cart_item_name">水煮肉片'
				//+'</a><div class="cart_item_sku"><span class="mysale_num">月售35份</span></div>'
				//+'<div class="numDivfl modify clearfix">'
				//+'<a href="javascript:;" class="numDivfl minus">-</a>'
				//+'<input type="text" class="numDivfl txt-count" value="1 " maxlength="2">'
				//+'<a href="javascript:;" class="numDivfl plus">+</a></div>'
				//+'<div class="cart_item_price">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
				//+'<span class="cart_price">￥<span class="priceNumSpan">12.00</span></span>'
				//+'</div></div></li>'
				+'</ul></div><div class="cart_handler">'
				+'<div class="cart_handler_header"><span class="cart_handler_left">'
				+'共<span id="total_cart_num" class="cart_price">0</span>件商品</span>'
				+'<span class="cart_handler_right">￥<span id="total_cart_price">0</span></span>'
				+'</div><a href="#" class="cart_go_btn" onclick="balanceShopCart()">'
				+'去购物车结算</a></div></div>',
			init:$.noop
		}
	};
	//showQuickPop
	var 
	prevPopType,
	prevTrigger,
	doc = $(document),
	popDisplayed = false,
	hideQuickPop = function(){
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
		popDisplayed = false;
		prevPopType = '';
		quickPop.hide();
		quickPop.animate({left:280,queue:true});
	},
	showQuickPop = function(type){
		if(quickPopXHR && quickPopXHR.abort){
			quickPopXHR.abort();
		}
		if(type !== prevPopType){
			var fn = quickDataFns[type];
			if(quickPop.find('.ibar_plugin_content').length == 0){
				var tmp = ds.tmpl(popTmpl, fn);
				quickPop.html(tmp);
			}
			fn.init.call(this, fn);
		}
		doc.unbind('click.quick_links').one('click.quick_links', hideQuickPop);

		quickPop[0].className = 'quick_links_pop quick_' + type;
		popDisplayed = true;
		prevPopType = type;
		quickPop.show();
		quickPop.animate({left:0,queue:true});
	};
	quickShell.bind('click.quick_links', function(e){
		e.stopPropagation();
	});
	quickPop.delegate('a.ibar_closebtn','click',function(){
		quickPop.hide();
		quickPop.animate({left:280,queue:true});
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
	});
	//通用事件处理
	var 
	view = $(window),
	quickLinkCollapsed = !!ds.getCookie('ql_collapse'),
	getHandlerType = function(className){
		return className.replace(/current/g, '').replace(/\s+/, '');
	},
	showPopFn = function(){
		var type = getHandlerType(this.className);
		if(popDisplayed && type === prevPopType){
			return hideQuickPop();
		}
		showQuickPop(this.className);
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
		prevTrigger = $(this).addClass('current');
	},
	quickHandlers = {
		//购物车，最近浏览，商品咨询
		my_qlinks: showPopFn,
		message_list: showPopFn,
		history_list: showPopFn,
		leave_message: showPopFn,
		mpbtn_histroy:showPopFn,
		mpbtn_recharge:showPopFn,
		mpbtn_wdsc:showPopFn,
		//返回顶部
		return_top: function(){
			ds.scrollTo(0, 0);
			hideReturnTop();
		}
	};
	quickShell.delegate('a', 'click', function(e){
		var type = getHandlerType(this.className);
		if(type && quickHandlers[type]){
			quickHandlers[type].call(this);
			e.preventDefault();
		}
	});
	
	//Return top
	var scrollTimer, resizeTimer, minWidth = 1350;

	function resizeHandler(){
		clearTimeout(scrollTimer);
		scrollTimer = setTimeout(checkScroll, 160);
	}
	
	function checkResize(){
		quickShell[view.width() > 1340 ? 'removeClass' : 'addClass']('quick_links_dockright');
	}
	function scrollHandler(){
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(checkResize, 160);
	}
	function checkScroll(){
		view.scrollTop()>100 ? showReturnTop() : hideReturnTop();
	}
	function showReturnTop(){
		quickPanel.addClass('quick_links_allow_gotop');
	}
	function hideReturnTop(){
		quickPanel.removeClass('quick_links_allow_gotop');
	}
	view.bind('scroll.go_top', resizeHandler).bind('resize.quick_links', scrollHandler);
	quickLinkCollapsed && quickShell.addClass('quick_links_min');
	resizeHandler();
	scrollHandler();
	/*购物车end*/
});
function aPlus(ele) {
	var menuNum = $(ele).prev().val().trim();//当前菜品的个数
	if(menuNum == 99)return;
	var shopCartNum = $('#shopCart span').text();
	$('#shopCart span').text(++shopCartNum);//购物车商品个数 在购物车列表点菜时用
	var currPriceSpan = $(ele).parent().next().find('.priceNumSpan');
	var currPrice = currPriceSpan.text();
	currPrice = currPrice / menuNum;//单价
	var shopCartPrice = $('#total_cart_price').text();
	var shopCartPrice2 = parseFloat(shopCartPrice);
	$('#total_cart_price').text(shopCartPrice2 + currPrice);//购物车总价
	var shopCartNum = $('#total_cart_num').text();
	$('#total_cart_num').text(++shopCartNum);//购物车总数
	currPrice = currPrice * menuNum + currPrice;
	currPriceSpan.text(currPrice);//当前菜品总价钱
	$(ele).prev().val(++menuNum);
	$('#shopCart span:last').text(shopCartNum);
}
function aMinus(ele) {
	var menuNum = $(ele).next().val().trim();
	var shopCartNum = $('#shopCart span').text();
	$('#shopCart span').text(--shopCartNum);
	var currPriceSpan = $(ele).parent().next().find('.priceNumSpan');
	var currPrice = currPriceSpan.text();
	currPrice = currPrice / menuNum;//单价
	var shopCartPrice = $('#total_cart_price').text();
	var shopCartPrice2 = parseFloat(shopCartPrice);
	$('#total_cart_price').text(shopCartPrice2 - currPrice);//购物车总价
	var shopCartNum = $('#total_cart_num').text();
	$('#total_cart_num').text(--shopCartNum);//购物车总数
	currPrice = currPrice * menuNum - currPrice;
	currPriceSpan.text(currPrice);
	$(ele).next().val(--menuNum);
	$('#shopCart span:last').text(shopCartNum);
	if(menuNum == 0){
		$(ele).parent().parent().parent().remove();
	}
}
function balanceShopCart(){
	var array = [];
	$('#shopCartUl li').each(function(index){
		var menuId = $(this).find('div:eq(1) a:eq(1)').text();
		var menuNum = $(this).find('div:eq(1) div:eq(1) input').val();
		var element = {};
		element.menuId = menuId;
		element.menuNum = menuNum;
		array[index] = element;
	});
	var url = path + '/customer/order!toOrder.action';
	var fromStr = '<form method="post"></form>';
	$('#shopCartUl').parent().append(fromStr);
	var from = $('#shopCartUl').next();
	from.attr('action',url);
	var input = $('<input type="hidden">');
	input.attr('name','jsonArray');
	input.val(JSON.stringify(array));
	from.append(input);
	from.submit();
    from.remove();
	return false;
}