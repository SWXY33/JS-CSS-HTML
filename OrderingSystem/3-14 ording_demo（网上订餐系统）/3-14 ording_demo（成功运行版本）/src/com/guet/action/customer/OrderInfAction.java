package com.guet.action.customer;

import net.sf.json.JSONObject;

import com.guet.action.PageAction;
import com.guet.entities.GoodsOrder;
import com.guet.utils.OutputHelper;
import com.guet.webservice.IOrderService;

public class OrderInfAction extends PageAction {

	private static final long serialVersionUID = 1L;
	
	private IOrderService orderService;

	/**
	 * 订单id
	 */
	private String orderId;
	
	public String findBusinessId(){
		String busId = null;
		boolean flag = false;
		try {
			busId = orderService.findBusinessIdByOrderId(orderId);
			flag = true;
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if(busId == null)busId = "";
			OutputHelper.outPut("{\"success\":" + flag + ",\"info\":\"" + busId + "\"}");
		}
		return null;
	}
	
	public String findOrder(){
		JSONObject jo = null;
		try {
			GoodsOrder order = orderService.findOrderById(orderId);
			jo = JSONObject.fromObject(order);
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if(jo == null)jo = JSONObject.fromObject("{}");
			OutputHelper.outPut(jo.toString());
		}
		return null;
	}
	
	public void setOrderService(IOrderService orderService) {
		this.orderService = orderService;
	}

	public String getOrderId() {
		return orderId;
	}

	public void setOrderId(String orderId) {
		this.orderId = orderId;
	}
}
