$(function(){
	var inf = $('#shopCartInfDiv').text();
	var url = path + '/customer/order!orderInf.action';
	lili.ajax.sys(url,{
		jsonArray : inf
	},function(data){
		if(data && data.store){
			$('#storeName').text(data.store.storeName);
			$('#storeId').val(data.store.id);
			if(data.menusInf && data.menusInf.length > 0){
				var arrs = data.menusInf;
				var totalPrice = 0.0;
				for (var i = 0; i < arrs.length; i++) {
					var foodList = '<div class="food_list"><div class="order-food-name">'
						+ arrs[i].menu.menuName + '</div>'
						+ '<div class="order-food-price">¥' + arrs[i].menu.menuPrice
						+ '*' + arrs[i].num + '</div></div>';
					$('#fl_address').after(foodList);
					totalPrice = totalPrice + arrs[i].menu.menuPrice * arrs[i].num;
				}
				$('#totalPrice').text(totalPrice);
				$('#allpricenum').text(totalPrice);
			}
		}
		return;
	});

	$('#address-new').click(function(){
		var btnText = $(this).text();
		if(btnText == '添加新地址'){
			var title = '收货地址';
			var url = path + '/customer/order!toAddress.action';
			lili.win.dialog({
				width: 700, height: 150, title: title, url: url, btn: [{
					 text: '保存修改',
					 icon : path + '/icon/save.png',
					 click: function (e, iframe){
						 var newImg = '<img src="' + path + '/icon/edit.png" />编辑地址';
						 $('#address-new').html(newImg);
						 var addresDetail = iframe.$('#form0').serialize();
						 var params = decodeURIComponent(addresDetail).split("&");
						 var params2 = [];
						 for(var i = 0;i < params.length;i++){
							 params2[i] = params[i].substring(params[i].indexOf('=') + 1);
						 }
						 var newDiv = '<div class="address-head"><div class="destination"><span>' + params2[0] + '</span><span>'
						 	+ params2[1] + '</span>：<span>' + params2[2] + '</span></div>'
						 	+ '<div class="destination">' + params2[3] + '</div></div>';
						 $('#chooseAddress').after(newDiv);
						 lili.getDialog().get.omDialog("close");
					 }
				}]
			});
		} else if (btnText == '编辑地址') {
			var divEle = $('#chooseAddress').next();
			var name = divEle.find('span:eq(0)').text();
			var sex = divEle.find('span:eq(1)').text();
			var tel = divEle.find('span:eq(2)').text();
			var address = divEle.find('div:eq(1)').text();
			var title = '收货地址';
			var url = path + '/customer/order!toAddress.action?name=' + name + '&sex=' + sex + '&tel=' + tel
				+ '&address=' + address;
			lili.win.dialog({
				width: 700, height: 150, title: title, url: url, btn : [{
					 text: '保存修改',
					 icon : path + '/icon/save.png',
					 click: function (e, iframe){
						 var addresDetail = iframe.$('#form0').serialize();
						 var params = decodeURI(addresDetail).split("&");
						 var params2 = [];
						 for(var i = 0;i < params.length;i++){
							 params2[i] = params[i].substring(params[i].indexOf('=') + 1);
						 }
						 divEle.remove();
						 var newDiv = '<div class="address-head"><div class="destination"><span>' + params2[0] + '</span><span>'
						 	+ params2[1] + '</span>：<span>' + params2[2] + '</span></div>'
						 	+ '<div class="destination">' + params2[3] + '</div></div>';
						 $('#chooseAddress').after(newDiv);
						 lili.getDialog().get.omDialog("close");
					 }
				}]
			});
		}
	});

	$('#payOnline').click(function(){
		$('#totalPrice').next().remove();
		$('#confirmOrder span').text('去付款');
	});
	$('#payOnFace').click(function(){
		var newSpan = '<span>，饭到当面付款</span>';
		$('#totalPrice').after(newSpan);
		$('#confirmOrder span').text('确认订单');
	});
	$('#confirmOrder').click(function(){
		var btnText = $('#address-new').text();
		if(btnText == '添加新地址'){
			$('#order-address-warning').show();
			return;
		} else if (btnText == '编辑地址') {
			$('#order-address-warning').hide();
		}
		
		var payText = $(this).text();
		if(payText == '去付款'){
			$('#order-bank-card-warning').show();
		} else if (payText == '确认订单') {
			$('#order-bank-card-warning').hide();
			var needText = $(this).text();
			var url = path + '/customer/order!saveNeed.action';
			var title = '提示';
			var divEle = $('#chooseAddress').next();
			var tel = divEle.find('span:eq(2)').text();
			var url = path + '/customer/order!toSendSms.action?tel=' + tel;
			lili.win.dialog({
				width: 560, height: 326, title: title, url: url
			});
		}
	});
});