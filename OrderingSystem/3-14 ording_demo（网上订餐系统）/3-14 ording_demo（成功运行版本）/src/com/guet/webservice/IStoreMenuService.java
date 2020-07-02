package com.guet.webservice;

import java.util.List;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.Store;
import com.guet.entities.StoreMenu;

/**
 * 菜单操作接口
 * @author lili
 *
 */
@WebService
public interface IStoreMenuService {
	
	/**
	 * 新增菜色
	 * @param menu
	 * @return
	 */
	@WebMethod
	public boolean save(
			@WebParam(name = "menu") StoreMenu menu);
	
	/**
	 * 修改菜色
	 * @param menu
	 * @return
	 */
	@WebMethod
	public boolean update(
			@WebParam(name = "menu") StoreMenu menu);
	
	/**
	 * 逻辑删除菜色
	 * @param ids
	 * @return
	 */
	@WebMethod
	public boolean deleteStoreMenu(
			@WebParam(name = "ids") String... ids);
	
	/**
	 * 根据id查找菜单
	 * @param menuId
	 * @return
	 */
	@WebMethod
	public StoreMenu findMenuById(
			@WebParam(name = "menuId") String menuId);
	
	/**
	 * 查询店铺菜单
	 * @param storeId
	 * @return
	 */
	@WebMethod
	public List<StoreMenu> findAllStoreMenu(
			@WebParam(name = "storeId") String storeId);
	
	/**
	 * 查询店铺菜单
	 * @param storeId
	 * @return json
	 */
	@WebMethod
	public String findAllStoreMenuJson(
			@WebParam(name = "storeId") String storeId);
	
	/**
	 * 根据菜单id查询店铺
	 * @param menuId
	 * @return
	 */
	@WebMethod
	public Store findStoreByMenuId(
			@WebParam(name = "menuId") String menuId);
}
