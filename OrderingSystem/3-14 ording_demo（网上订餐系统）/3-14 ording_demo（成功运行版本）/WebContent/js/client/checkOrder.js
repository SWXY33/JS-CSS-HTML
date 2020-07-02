$(function(){
	var getBusinessIdUrl = path + '/customer/orderInf!findBusinessId.action';
	var orderId = $('#orderIdDiv').text();
	lili.ajax.sys(getBusinessIdUrl,{
		orderId : orderId
	},function(data){
		if(data.info)messagePush.sendByCondition(data.info);//消息推送,推送到某个商家
	});
	
	var getOrderUrl = path + '/customer/orderInf!findOrder.action';
	lili.ajax.sys(getOrderUrl,{
		orderId : orderId
	},function(data){
		if(data.id){
			$('#orderCreateTime').text(new Date(data.createTime.time).Format('yyyy-MM-dd hh:mm:ss'));
			$('#orderWaitBusTime').text(new Date().Format('yyyy-MM-dd hh:mm:ss'));
			$('#storeName1').text(data.store.storeName);
			$('#storeName2').text(data.store.storeName);
			for(var i = 0;i < data.menus.length;i++){
				var menuDiv = '<div class="food_list"><div class="order-food-name">' + data.menus[i].menu.menuName
					+ '</div><div class="order-food-price">¥<span>' + data.menus[i].menu.menuPrice + '</span>*<span>'
					+ data.menus[i].count + '</span></div></div>';
				$('#allPrice').parent().before(menuDiv);
			}
			$('#allpricenum span').text(data.totalPrice);
			
			var address = '<span>' + data.address.receiveName + '</span><span>' + data.address.sex + '</span>:<span>'
				+ data.address.phone + '</span>&nbsp;<span>' + data.address.street + '</span></div>';
			$('#addressDiv').append(address);
			
			var guestBook = '<span>' + data.guestBook + '</span>';
			$('#guestNeed').append(guestBook);
		}
	});
});