$(function() {
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
				+'</span>/份</span></div></div>';
			$('#store_foods_div').append(foodDiv);
		}
		$('.store_food').each(function() {
			$(this).children('a').click(function() {
				var id = $(this).attr('class');
				var title = '修改菜色';
				var url = path + '/business/openStore!preEditMenu.action?storeMenu.id=' + id + '&test='+id;
				lili.win.dialog({
					width: 700, height: 300, title: title, url: url, btn: [{
			            text: '保存修改',
			            icon : path + '/icon/save.png',
			            click: function (e, iframe) {
			            	iframe.$('#storeId').val($('#storeId').val());
			            	var url = path + "/business/openStore!editMenu.action";
			        		lili.ajax.sys(url,iframe.$('#form0').serialize(),function(data){
			        			lili.win.msgjson(data);
			        			if (data.success == true){
			        				lili.getDialog().get.omDialog("close");
			        				window.location.href = path + '/business/openStore!preOpen.action';
			        			}
			        		});
			            }
			        }]
				});
			});
		});
	});
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
	$('#addMenuBtn').omButton({
		icons : {
			left : path + '/icon/edit.png'
		},
		onClick : function(){
			var title = '新增菜色';
			var url = path + '/business/openStore!preAddMenu.action';
			lili.win.dialog({
				width: 700, height: 300, title: title, url: url, btn: [{
		            text: '保存修改',
		            icon : path + '/icon/save.png',
		            click: function (e, iframe) {
		            	iframe.$('#storeId').val($('#storeId').val());
		            	//alert(iframe.$('#form0').serialize());
		            	var url = path + "/business/openStore!addMenu.action";
		        		lili.ajax.sys(url,iframe.$('#form0').serialize(),function(data){
		        			lili.win.msgjson(data);
		        			if (data.success == true){
		        				lili.getDialog().get.omDialog("close");
		        				window.location.href = path + '/business/openStore!preOpen.action';
		        			}
	        				
		        		});
		            }
		        }]
			});
		}
	});
});