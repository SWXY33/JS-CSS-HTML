package com.guet.action.business;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import com.guet.action.PageAction;
import com.guet.constants.Constant;
import com.guet.entities.Store;
import com.guet.entities.StoreMenu;
import com.guet.entities.SystemFile;
import com.guet.entities.SystemUser;
import com.guet.page.PageVO;
import com.guet.utils.OutputHelper;
import com.guet.utils.TimeUtil;
import com.guet.utils.XWorkUtil;
import com.guet.webservice.IStoreMenuService;
import com.guet.webservice.IStoreService;

public class OpenStoreAction extends PageAction{
	private static final long serialVersionUID = 1L;

	private String storeId;
	private String storename;
	private String storeDescribe;
	private String province;
	private String city;
	private String county;
	private String address;
	private String storeImgName;
	
	private StoreMenu storeMenu;
	
	private IStoreService storeService;
	
	private IStoreMenuService storeMenuService;
	
	public String preOpen(){
		try {
			//如果没有登录
			SystemUser currentUser = getSessionUser();
			if(currentUser == null){
				return "businessLogin";
			}
			if(currentUser.getId() != null){
				String storeId = storeService.hasStore(currentUser.getId());
				if(storeId != null){
					XWorkUtil.getRequest().setAttribute("storeId",storeId);
					return "mystore";
				}
			}
			return "toOpenStore";
		} catch (Exception e) {
			e.printStackTrace();
		}
		return "businessLogin";
	}
	
	public String openStore(){
		try {
			SystemUser business = getSessionUser();
			if(business == null){
				return null;
			}
			Store store = new Store();
			store.setBusiness(business);
			if(storeImgName != null){
				SystemFile logo = new SystemFile();
				logo.setId(storeImgName);
				store.setLogo(logo);
			}
			store.setCreateTime(TimeUtil.now());
			store.setStoreName(storename);
			store.setStoreDescribe(storeDescribe);
			store.setStoreProvince(province);
			store.setStoreCity(city);
			store.setStoreCounty(county);
			store.setStreet(address);
			store.setDbStatus(0);
			storeService.saveOrUpdate(store);
			OutputHelper.outPut("{\"success\":true}");
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("{\"success\":false}");
		}
		return null;
	}
	
	public String getStoreInf(){
		try {
			Store store = storeService.findStoreById(storeId);
			JSONObject json = JSONObject.fromObject(store);
			OutputHelper.outPut(json.toString());
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("{}");
		}
		return null;
	}
	
	public String getStores(){
		try {
			PageVO<Store> page = storeService.findStorePage(
					null, getPageStart(), getPageLimit());
			if(page != null){
				JSONArray json = JSONArray.fromObject(page.getList());
				OutputHelper.outPut(json.toString());
			}
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("[]");
		}
		return null;
	}
	
	public String preAddMenu(){
		storeMenu = null;
		return "toAddMenu";
	}
	
	public String addMenu(){
		try {
			storeMenu.setCreateTime(TimeUtil.now());
			storeMenu.setDbStatus(Constant.DB_STATUS_0);
			storeMenuService.save(storeMenu);
			OutputHelper.outPut("{\"success\":true}");
		} catch (Exception e) {
			OutputHelper.outPut("{\"success\":false}");
			e.printStackTrace();
		}
		storeMenu = null;
		return null;
	}
	
	public String preEditMenu(){
		try {
			storeMenu = storeMenuService.findMenuById(storeMenu.getId());
		} catch (Exception e) {
			e.printStackTrace();
		}
		return "toAddMenu";
	}
	
	public String editMenu(){
		try {
			storeMenuService.update(storeMenu);
			OutputHelper.outPut("{\"success\":true}");
		} catch (Exception e) {
			OutputHelper.outPut("{\"success\":false}");
			e.printStackTrace();
		}
		return null;
	}
	
	public String storeMenus(){
		String array = null;
		try {
			String storeId = XWorkUtil.getRequest().getParameter("storeId");
			if(storeId != null){
				array = storeMenuService.findAllStoreMenuJson(storeId);
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		OutputHelper.outPut(array == null? "[]" : array);
		return null;
	}

	public void setStoreService(IStoreService storeService) {
		this.storeService = storeService;
	}

	public void setStoreMenuService(IStoreMenuService storeMenuService) {
		this.storeMenuService = storeMenuService;
	}

	public void setStoreId(String storeId) {
		this.storeId = storeId;
	}

	public void setStorename(String storename) {
		this.storename = storename;
	}

	public void setStoreDescribe(String storeDescribe) {
		this.storeDescribe = storeDescribe;
	}

	public void setProvince(String province) {
		this.province = province;
	}

	public void setCity(String city) {
		this.city = city;
	}

	public void setCounty(String county) {
		this.county = county;
	}

	public void setAddress(String address) {
		this.address = address;
	}

	public void setStoreImgName(String storeImgName) {
		this.storeImgName = storeImgName;
	}

	public void setStoreMenu(StoreMenu storeMenu) {
		this.storeMenu = storeMenu;
	}

	public StoreMenu getStoreMenu() {
		return storeMenu;
	}
}
