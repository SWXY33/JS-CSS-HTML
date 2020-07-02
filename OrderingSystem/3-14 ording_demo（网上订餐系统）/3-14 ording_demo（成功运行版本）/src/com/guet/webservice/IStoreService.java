package com.guet.webservice;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.Store;
import com.guet.page.PageVO;

@WebService
public interface IStoreService {
	
	/**
	 * 新增或修改店铺
	 * @param store
	 * @return
	 */
	@WebMethod
	public boolean saveOrUpdate(
			@WebParam(name = "store") Store store);
	
	/**
	 * 分页查询店铺
	 * @param store 筛选条件
	 * @param start 页码
	 * @param pageSize 数目
	 * @return
	 */
	@WebMethod
	public PageVO<Store> findStorePage(
			@WebParam(name = "store") Store store,
			@WebParam(name = "start") int start,
			@WebParam(name = "pageSize") int pageSize);
	
	/**
	 * 根据店铺id查询店铺信息
	 * @param storeId
	 * @return
	 */
	@WebMethod
	public Store findStoreById(
			@WebParam(name = "storeId") String storeId);
	
	/**
	 * 判断商家是否有店铺
	 * @param businessId
	 * @return 存在则返回店铺id 否则返回null
	 */
	@WebMethod
	public String hasStore(
			@WebParam(name = "businessId") String businessId);
}
