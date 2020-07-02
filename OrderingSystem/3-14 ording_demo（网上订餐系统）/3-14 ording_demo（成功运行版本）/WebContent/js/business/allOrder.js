$(function(){
	var allOrderurl = path + '/business/orderInf!allOrderData.action';
	var storeId = $('#storeId').text();
	lili.ajax.sys(allOrderurl,{
		storeId : storeId,
		start : 0,
		limit : 20
	},function(data){
		if(data.length == 0)return;
		for(var i = 0;i < data.length;i++){
			var newTable = $('<table></table>');
			var newTbody = '<tbody><tr><td><label><input type="checkbox" /><span class="orderDateClass">'
				+ new Date(data[i].createTime.time).Format('yyyy-MM-dd hh:mm:ss') + '</span></label><span><span>订单号</span><span>:</span>'
				+ '<span class="orderNumClass">' + data[i].id + '</span></span></td><td><span><a>' + data[i].store.storeName
				+ '</a></span></td><td><a href="#" class="acceptOrder" onclick="acceptOrderClick(this);" name="' + data[i].id
				+ '">接受订单</a><a href="#" title="删除订单" target="_blank" id="delOrder">'
				+ '<i></i></a></td></tr></tbody>';
			var menuTbody = $('<tbody></tbody>');
			for(var j = 0;j < data[i].menus.length;j++){
				var newTr = '<tr><td><div><span>' + data[i].menus[j].menu.menuName + '</span></div></td><td><div><span>¥</span><span>'
					+ data[i].menus[j].menu.menuPrice + '</span>*<span>' + data[i].menus[j].count + '</span></div></td></tr>';
				menuTbody.append(newTr);
			}
			newTable.append(newTbody).append(menuTbody);
			$('#orderPageDiv').before(newTable);
		}
	});
});
function acceptOrderClick(obj){
	var objVal = $(obj).text();
	if(objVal == '接受订单'){
		var getCustomerIdUrl = path + '/business/orderInf!findCustomerId.action';
		var orderId = $(obj).attr('name');
		lili.ajax.sys(getCustomerIdUrl,{
			orderId : orderId
		},function(data){
			if(data.info){
				messagePush.sendAceptOrderToClient(data.info);//消息推送,推送到某个商家
				$(obj).text('已接单');
			}
		});
	}
}
function businessAceptOrder(){
}