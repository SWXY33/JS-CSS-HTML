package com.guet.webservice;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.GoodsOrder;
import com.guet.entities.SystemUser;
import com.guet.page.PageVO;

@WebService
public interface IOrderService {
	
	/**
	 * 生成订单
	 * @param user 用户
	 * @param menuJsonArray 点菜信息json数组
	 * @param name 收货人
	 * @param sex 性别
	 * @param tel 联系电话
	 * @param address 地址
	 * @param leaveMessage 给商家的留言
	 * @param payMethod 付款方式 0:货到付款 1:在线支付
	 * @return
	 */
	@WebMethod
	public String genOrder(
			@WebParam(name = "user") SystemUser user,
			@WebParam(name = "menuJsonArray") String menuJsonArray,
			@WebParam(name = "name") String name,
			@WebParam(name = "sex") String sex,
			@WebParam(name = "tel") String tel,
			@WebParam(name = "address") String address,
			@WebParam(name = "leaveMessage") String leaveMessage,
			@WebParam(name = "payMethod") int payMethod);
	
	/**
	 * 根据订单id查找商家id
	 * @param orderId
	 * @return
	 */
	@WebMethod
	public String findBusinessIdByOrderId(
			@WebParam(name = "orderId") String orderId);
	
	/**
	 * 根据订单id查找顾客id
	 * @param orderId
	 * @return
	 */
	@WebMethod
	public String findCustomerIdByOrderId(
			@WebParam(name = "orderId") String orderId);
	
	/**
	 * 查找订单信息
	 * @param orderId
	 * @return
	 */
	@WebMethod
	public GoodsOrder findOrderById(
			@WebParam(name = "orderId") String orderId);
	
	/**
	 * 分页查找店铺订单
	 * @param storeId 店铺id
	 * @param start 页码
	 * @param pageSize 数目
	 * @return
	 */
	@WebMethod
	public PageVO<GoodsOrder> findOrderByStore(
			@WebParam(name = "storeId") String storeId,
			@WebParam(name = "start") int start,
			@WebParam(name = "pageSize") int pageSize);
}
