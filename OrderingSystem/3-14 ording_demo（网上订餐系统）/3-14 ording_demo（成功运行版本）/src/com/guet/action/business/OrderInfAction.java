package com.guet.action.business;

import net.sf.json.JSONArray;

import com.guet.action.PageAction;
import com.guet.entities.GoodsOrder;
import com.guet.page.PageVO;
import com.guet.utils.OutputHelper;
import com.guet.webservice.IOrderService;

public class OrderInfAction extends PageAction {
	
	private static final long serialVersionUID = 1L;
	
	private IOrderService orderService;
	
	private String storeId;
	
	private String orderId;
	
	public String allOrder(){
		return "allOrder";
	}
	
	public String toSomeoneOrder(){
		return "toSomeoneOrder";
	}
	
	public String allOrderData(){
		JSONArray json = null;
		try {
			PageVO<GoodsOrder> page = orderService.findOrderByStore(storeId, getPageStart(), getPageLimit());
			if(page != null){
				json = JSONArray.fromObject(page.getList());
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if(json == null)json = JSONArray.fromObject("[]");
			OutputHelper.outPut(json.toString());
		}
		
		return null;
	}
	
	public String findCustomerId(){
		String cusId = null;
		boolean flag = false;
		try {
			cusId = orderService.findCustomerIdByOrderId(orderId);
			flag = true;
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if(cusId == null)cusId = "";
			OutputHelper.outPut("{\"success\":" + flag + ",\"info\":\"" + cusId + "\"}");
		}
		return null;
	}

	public void setOrderService(IOrderService orderService) {
		this.orderService = orderService;
	}

	public String getStoreId() {
		return storeId;
	}

	public void setStoreId(String storeId) {
		this.storeId = storeId;
	}

	public String getOrderId() {
		return orderId;
	}

	public void setOrderId(String orderId) {
		this.orderId = orderId;
	}
}
