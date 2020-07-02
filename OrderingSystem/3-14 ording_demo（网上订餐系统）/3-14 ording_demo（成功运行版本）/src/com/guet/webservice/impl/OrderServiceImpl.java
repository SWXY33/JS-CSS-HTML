package com.guet.webservice.impl;

import java.util.ArrayList;
import java.util.List;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.springframework.transaction.annotation.Transactional;

import com.guet.constants.Constant;
import com.guet.entities.GoodsOrder;
import com.guet.entities.OrderMenu;
import com.guet.entities.ReceiptAddress;
import com.guet.entities.Store;
import com.guet.entities.StoreMenu;
import com.guet.entities.SystemUser;
import com.guet.page.PageVO;
import com.guet.utils.StringUtils;
import com.guet.utils.TimeUtil;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IOrderService;
import com.guet.webservice.IStoreMenuService;

@Transactional(readOnly = false)
public class OrderServiceImpl extends DBPersistenceImpl implements IOrderService {
	
	private IStoreMenuService storeMenuService;

	@SuppressWarnings("unchecked")
	@Override
	public String genOrder(SystemUser user,String menuJsonArray, String name, String sex,
			String tel, String address, String leaveMessage,int payMethod) {
		
		Session session = getSession().getSessionFactory().openSession();
		//事务
		Transaction tx = session.beginTransaction();
		try {
			GoodsOrder order = new GoodsOrder();
			order.setConsumer(user);
			order.setCreateTime(TimeUtil.now());
			
			ReceiptAddress addressObj = new ReceiptAddress();
			addressObj.setId(StringUtils.genUUID());
			StringBuffer columns = new StringBuffer("(id,create_time,db_status");
			StringBuffer columnsValues = new StringBuffer("'" + addressObj.getId() + "',now(),0");
			StringBuffer where = new StringBuffer();
			if(user != null && !StringUtils.isInvalid(user.getId())){
				columns.append(",user_id");
				columnsValues.append(",'" + user.getId() + "'");
				where.append(" and ra.user_id = '" + user.getId() + "'");
			}
			if(!StringUtils.isInvalid(name)){
				columns.append(",receive_name");
				columnsValues.append(",'" + name + "'");
				where.append(" and ra.receive_name = '" + name + "'");
			}
			if(!StringUtils.isInvalid(sex)){
				columns.append(",sex");
				columnsValues.append(",'" + sex + "'");
				where.append(" and ra.sex = '" + sex + "'");
			}
			if(!StringUtils.isInvalid(tel)){
				columns.append(",phone");
				columnsValues.append(",'" + tel + "'");
				where.append(" and ra.phone = '" + tel + "'");
			}
			if(!StringUtils.isInvalid(address)){
				columns.append(",street");
				columnsValues.append(",'" + address + "'");
				where.append(" and ra.street = '" + address + "'");
			}
			if(!StringUtils.isInvalid(leaveMessage)){
				columns.append(",guest_book");
				columnsValues.append(",'" + leaveMessage + "'");
				where.append(" and ra.guest_book = '" + leaveMessage + "'");
			}
			columns.append(")");
			String addressSql = "insert into rectipt_address" + columns.toString() + " select " + columnsValues.toString()
					+ " from dual where not exists ( select * from rectipt_address ra where 1=1" + where.toString() + ")";
			if(jdbc.update(addressSql) == 0){
				List<String> lg = findBySQL("select ra.id from rectipt_address ra where 1=1" + where.toString());
				if(lg != null && lg.size() > 0){
					addressObj.setId(lg.get(0));
				}
			}
			order.setAddress(addressObj);
			/**
			 * insert into rectipt_address(id) SELECT uuid() from dual WHERE not EXISTS (
 select * from rectipt_address ra WHERE ra.user_id = '402890f0536b5d8501536b5dbace0001'
	and ra.receive_name = '辛杰伟' and ra.phone = '15607732013' and ra.street = '桂电')			
			 */
			JSONArray array = JSONArray.fromObject(menuJsonArray);
			JSONObject object = array.getJSONObject(0);
			Store store = storeMenuService.findStoreByMenuId(object.getString("menuId"));
			order.setStore(store);
			
			order.setGuestBook(leaveMessage);
			order.setPaymentMethod(payMethod);
			session.save(order);
			
			for (int i = 0; i < array.size(); i++) {
				OrderMenu om = new OrderMenu();
				om.setOrder(order);
				String menuId = array.getJSONObject(i).getString("menuId");
				StoreMenu menu = new StoreMenu();
				menu.setId(menuId);
				om.setMenu(menu);
				String num = array.getJSONObject(i).getString("menuNum").trim();
				om.setCount(Integer.parseInt(num));
				session.save(om);
			}
			
			//提交事务
			tx.commit();
			return order.getId();
		} catch (Exception e) {
			try {
				//回滚
				tx.rollback();
			} catch (HibernateException e2) {}
			e.printStackTrace();
		} finally {
			try {
				if(session != null)session.close();
			} catch (Exception e2) {
			}
		}
		
		return null;
	}

	public void setStoreMenuService(IStoreMenuService storeMenuService) {
		this.storeMenuService = storeMenuService;
	}

	@Override
	public String findBusinessIdByOrderId(String orderId) {
		String columns = " sinf.business_id";
		String from = " goods_order ord left join store_information sinf on sinf.id = ord.store_id";
		String where = " where ord.id = ?";
		Object obj = findBySQLUnique(columns, from, where, new String[]{orderId});
		if(obj != null){
			return toStringFromObj(obj);
		}
		return null;
	}
	
	@Override
	public String findCustomerIdByOrderId(String orderId) {
		String columns = " ord.consumer_id";
		String from = " goods_order ord";
		String where = " where ord.id = ?";
		Object obj = findBySQLUnique(columns, from, where, new String[]{orderId});
		if(obj != null){
			return toStringFromObj(obj);
		}
		return null;
	}

	@Override
	public GoodsOrder findOrderById(String orderId) {
		if(StringUtils.isInvalid(orderId))return null;
		String columns = " ord.id,ord.create_time,addr.id addrId,addr.receive_name,addr.sex,"
				+ "addr.phone,addr.street,sinf.id storeId,sinf.store_name,ord.guest_book,"
				+ "ord.total_price,ord.payment_method";
		String from = " goods_order ord left join rectipt_address addr on addr.id = ord.address_id"
				+ " left join store_information sinf on sinf.id = ord.store_id";
		String where = " where ord.id = ? and ord.db_status >= ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where, new Object[]{orderId,Constant.DB_STATUS_0});
		if(obj != null){
			GoodsOrder order = new GoodsOrder();
			order.setId(toStringFromObj(obj[0]));
			order.setCreateTime(toTimestamp(obj[1]));
			if(obj[2] != null){
				ReceiptAddress addr = new ReceiptAddress();
				addr.setId(obj[2].toString());
				addr.setReceiveName(toStringFromObj(obj[3]));
				addr.setSex(toStringFromObj(obj[4]));
				addr.setPhone(toStringFromObj(obj[5]));
				addr.setStreet(toStringFromObj(obj[6]));
				
				order.setAddress(addr);
			}
			if(obj[7] != null){
				Store store = new Store();
				store.setId(obj[7].toString());
				store.setStoreName(toStringFromObj(obj[8]));
				order.setStore(store);
			}
			order.setGuestBook(toStringFromObj(obj[9]));
			order.setTotalPrice(todouble(obj[10]));
			order.setPaymentMethod(toint(obj[11]));
			order.setMenus(getOrderMenus(order));
			return order;
		}
		return null;
	}
	
	@SuppressWarnings("unchecked")
	private List<OrderMenu> getOrderMenus(GoodsOrder order){
		String columns = " aa.id,aa.menu_name,aa.menu_price,bb.count";
		String from = " store_menu aa inner join order_menu bb on bb.menu_id = aa.id";
		String where = " where bb.order_id = ? and aa.db_status >= ?";
		String orderby = "";
		List<Object[]> lg = findBySQLAll(columns, from, where, orderby, new Object[]{order.getId(),Constant.DB_STATUS_0});
		if(lg != null && lg.size() > 0){
			List<OrderMenu> list = new ArrayList<OrderMenu>();
			OrderMenu om = null;
			StoreMenu menu = null;
			double total = 0;
			for(Object[] obj : lg){
				om = new OrderMenu();
				menu = new StoreMenu();
				menu.setId(toStringFromObj(obj[0]));
				menu.setMenuName(toStringFromObj(obj[1]));
				menu.setMenuPrice(todouble(obj[2]));
				om.setMenu(menu);
				om.setCount(toint(obj[3]));
				total = total + menu.getMenuPrice() * om.getCount();
				list.add(om);
			}
			if(order.getTotalPrice() == 0)order.setTotalPrice(total);
			return list;
		}
		return null;
	}

	@Override
	public PageVO<GoodsOrder> findOrderByStore(String storeId,int start,int pageSize) {
		String columns = " ord.id ordId,ord.create_time,addr.id addrId,addr.receive_name,addr.sex,"
				+ "addr.phone,addr.street,sinf.id storeId,sinf.store_name,ord.guest_book,"
				+ "ord.total_price,ord.payment_method";
		StringBuffer from = new StringBuffer(" goods_order ord");
		from.append(" left join rectipt_address addr on addr.id = ord.address_id");
		from.append(" left join store_information sinf on sinf.id = ord.store_id");
		String where = " where ord.db_status >= " + Constant.DB_STATUS_0 + " and ord.store_id = ?";
		String orderby = " order by ord.create_time desc";
		List<String> params = new ArrayList<String>();
		params.add(storeId);
		PageVO<GoodsOrder> page = new PageVO<GoodsOrder>(start, pageSize);
		List<Object[]> lg = findBySQLPage(columns, from.toString(),
				where, orderby, params.toArray(), page);
		if(lg != null && lg.size() > 0){
			List<GoodsOrder> list = new ArrayList<GoodsOrder>();
			for (Object[] obj : lg) {
				GoodsOrder order = new GoodsOrder();
				order.setId(toStringFromObj(obj[0]));
				order.setCreateTime(toTimestamp(obj[1]));
				if(obj[2] != null){
					ReceiptAddress addr = new ReceiptAddress();
					addr.setId(obj[2].toString());
					addr.setReceiveName(toStringFromObj(obj[3]));
					addr.setSex(toStringFromObj(obj[4]));
					addr.setPhone(toStringFromObj(obj[5]));
					addr.setStreet(toStringFromObj(obj[6]));
					order.setAddress(addr);
				}
				if(obj[7] != null){
					Store store = new Store();
					store.setId(obj[7].toString());
					store.setStoreName(toStringFromObj(obj[8]));
					order.setStore(store);
				}
				order.setGuestBook(toStringFromObj(obj[9]));
				order.setTotalPrice(todouble(obj[10]));
				order.setPaymentMethod(toint(obj[11]));
				order.setMenus(getOrderMenus(order));
				list.add(order);
			}
			page.setList(list);
			return page;
		}
		return null;
	}
}
