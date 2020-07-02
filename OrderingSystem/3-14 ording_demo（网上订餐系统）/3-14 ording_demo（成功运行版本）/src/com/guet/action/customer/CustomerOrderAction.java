package com.guet.action.customer;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import com.guet.action.PageAction;
import com.guet.entities.ReceiptAddress;
import com.guet.entities.Store;
import com.guet.entities.StoreMenu;
import com.guet.entities.SystemUser;
import com.guet.utils.OutputHelper;
import com.guet.utils.XWorkUtil;
import com.guet.webservice.IOrderService;
import com.guet.webservice.IStoreMenuService;

public class CustomerOrderAction extends PageAction {
	
	private static final long serialVersionUID = 1L;
	
	private IStoreMenuService storeMenuService;
	private IOrderService orderService;
	
	/**
	 * 店铺
	 */
	private Store store;
	
	/**
	 * 菜单json
	 */
	private String jsonArray;
	
	//以下四个为收货地址信息
	private String name;
	private String sex;
	private String tel;
	private String address;
	
	/**
	 * 商家留言
	 */
	private String leaveMessage;
	
	private String orderId;
	
	public String toStore(){
		try {
			XWorkUtil.getRequest().setAttribute("storeId",store.getId());
		} catch (Exception e) {
			e.printStackTrace();
		}
		return "toStore";
	}
	
	public String toOrder(){
		return "toOrder";
	}
	
	public String myOrders(){
		try {
			//如果没有登录
			SystemUser currentUser = getSessionUser();
			if(currentUser == null){
				return "businessLogin";
			}
			return "myOrders";
		}catch (Exception e) {
			e.printStackTrace();
		}
		return "businessLogin";
	}
	
	public String orderInf(){
		try {
			JSONArray array = JSONArray.fromObject(jsonArray);
			JSONObject object = array.getJSONObject(0);
			Store store = storeMenuService.findStoreByMenuId(object.getString("menuId"));
			Map<String, Object> map = new HashMap<String, Object>();
			List<Map<String, Object>> menusInfo = new ArrayList<Map<String,Object>>();
			map.put("store", store);
			for (int i = 0; i < array.size(); i++) {
				object = array.getJSONObject(i);
				StoreMenu menu = storeMenuService.findMenuById(object.getString("menuId"));
				Map<String, Object> menuMap = new HashMap<String, Object>();
				menuMap.put("menu", menu);
				menuMap.put("num", object.getString("menuNum"));
				menusInfo.add(menuMap);
			}
			map.put("menusInf", menusInfo);
			JSONObject json = JSONObject.fromObject(map);
			OutputHelper.outPut(json.toString());
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("{}");
		}
		return null;
	}
	
	public String genOrder(){
		try {
			SystemUser currentUser = getSessionUser();
			if(currentUser == null){
				OutputHelper.outPut("{\"success\":false}");
				return null;
			}
			String id = orderService.genOrder(currentUser, jsonArray, name, sex, tel, address, leaveMessage, 0);
			if(id == null)id = "";
			OutputHelper.outPut("{\"success\":true,\"info\":\""+ id +"\"}");
		} catch (Exception e) {
			OutputHelper.outPut("{}");
			e.printStackTrace();
		}
		return null;
	}
	
	public String toAddress(){
		return "toAddress";
	}
	public String saveNeed(){
		ReceiptAddress receiptaddress = new ReceiptAddress();
		receiptaddress.setGuestBook(leaveMessage);
		return null;
	}
	
	public String toSendSms(){

		return "toSendSms";
	}
	
	public String toCheckOrder(){
		if(getSessionUser() == null){
			return "toHome";
		}
		return "toCheckOrder";
	}

	public void setStoreMenuService(IStoreMenuService storeMenuService) {
		this.storeMenuService = storeMenuService;
	}

	public void setOrderService(IOrderService orderService) {
		this.orderService = orderService;
	}

	public Store getStore() {
		return store;
	}

	public void setStore(Store store) {
		this.store = store;
	}

	public String getJsonArray() {
		return jsonArray;
	}

	public void setJsonArray(String jsonArray) {
		this.jsonArray = jsonArray;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getSex() {
		return sex;
	}

	public void setSex(String sex) {
		this.sex = sex;
	}

	public String getTel() {
		return tel;
	}

	public void setTel(String tel) {
		this.tel = tel;
	}

	public String getAddress() {
		return address;
	}

	public void setAddress(String address) {
		this.address = address;
	}

	public String getLeaveMessage() {
		return leaveMessage;
	}

	public void setLeaveMessage(String leaveMessage) {
		this.leaveMessage = leaveMessage;
	}

	public String getOrderId() {
		return orderId;
	}

	public void setOrderId(String orderId) {
		this.orderId = orderId;
	}
}
