package com.guet.webservice.impl;

import java.util.ArrayList;
import java.util.List;

import org.springframework.transaction.annotation.Transactional;

import com.guet.constants.Constant;
import com.guet.entities.Store;
import com.guet.entities.SystemFile;
import com.guet.entities.SystemUser;
import com.guet.page.PageVO;
import com.guet.utils.StringUtils;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IStoreService;

@Transactional(readOnly = false)
public class StoreServiceImpl extends DBPersistenceImpl implements IStoreService {

	@Override
	public boolean saveOrUpdate(Store store) {
		if (store == null)
			return false;
		boolean flag = false;
		if (!StringUtils.isInvalid(store.getId())) {
			// 数据修改
			flag = updateObject(store);
		} else {
			// 增加
			flag = saveObject(store);
		}
		return flag;
	}

	@Override
	public PageVO<Store> findStorePage(Store store, int start, int pageSize) {
		String columns = " ss.id,user.id userId,user.real_name,file.id fileId,file.relative_path,"
				+ "date_format(ss.create_time,'%Y-%m-%d %H:%i:%s') createTime,"
				+ "ss.store_name,ss.store_describe,ss.store_province,ss.store_city,ss.store_county,"
				+ "ss.street,ss.longitude,ss.latitude,ss.db_status";
		StringBuffer from = new StringBuffer(" store_information ss");
		from.append(" left join sys_users user on user.id = ss.business_id");
		from.append(" left join sys_files file on file.id = ss.logo_id");
		StringBuffer where = new StringBuffer(" where ss.db_status = " + Constant.DB_STATUS_0);
		String orderby = " order by ss.store_name asc";
		List<String> params = new ArrayList<String>();
		if (store != null) {
			// 根据店铺名称过滤
			if (!StringUtils.isInvalid(store.getStoreName())) {
				where.append(" and ss.store_name like ?");
				params.add("%" + store.getStoreName() + "%");
			}
			// 根据店铺所在省份过滤
			if (!StringUtils.isInvalid(store.getStoreProvince())) {
				where.append(" and ss.store_province = ?");
				params.add(store.getStoreProvince());
			}
			// 根据店铺所在城市过滤
			if (!StringUtils.isInvalid(store.getStoreCity())) {
				where.append(" and ss.store_city = ?");
				params.add(store.getStoreCity());
			}
			// 根据店铺所在县/区过滤
			if (!StringUtils.isInvalid(store.getStoreCounty())) {
				where.append(" and ss.store_county = ?");
				params.add(store.getStoreCounty());
			}
			// 根据店铺所在街道过滤
			if (!StringUtils.isInvalid(store.getStreet())) {
				where.append(" and ss.street = ?");
				params.add(store.getStreet());
			}
			if (store.getLongitude() != 0) {
				where.append(" and ss.longitude = ?");
				params.add(store.getLongitude() + "");
			}
			if (store.getLatitude() != 0) {
				where.append(" and ss.latitude = ?");
				params.add(store.getLatitude() + "");
			}
		}
		PageVO<Store> page = new PageVO<Store>(start, pageSize);
		List<Object[]> lg = findBySQLPage(columns, from.toString(),
				where.toString(), orderby, params.toArray(), page);
		if(lg != null && lg.size() > 0){
			List<Store> lresult = new ArrayList<Store>();
			Store ss = null;
			SystemUser user = null;
			SystemFile file = null;
			for (Object[] obj : lg) {
				ss = new Store();
				ss.setId(toStringFromObj(obj[0]));
				if(obj[1] != null){
					user = new SystemUser();
					user.setId(obj[1].toString());
					user.setRealName(toStringFromObj(obj[2]));
					ss.setBusiness(user);
				}
				if(obj[3] != null){
					file = new SystemFile();
					file.setId(obj[3].toString());
					file.setRelativePath(toStringFromObj(obj[4]));
					ss.setLogo(file);
				}
				ss.setCreateTime(toTimestamp(obj[5]));
				ss.setStoreName(toStringFromObj(obj[6]));
				ss.setStoreDescribe(toStringFromObj(obj[7]));
				ss.setStoreProvince(toStringFromObj(obj[8]));
				ss.setStoreCity(toStringFromObj(obj[9]));
				ss.setStoreCounty(toStringFromObj(obj[10]));
				ss.setStreet(toStringFromObj(obj[11]));
				ss.setLongitude(todouble(obj[12]));
				ss.setLatitude(todouble(obj[13]));
				ss.setDbStatus(toint(obj[14]));
				lresult.add(ss);
			}
			page.setList(lresult);
			return page;
		}
		return null;
	}
	
	@SuppressWarnings("unchecked")
	@Override
	public Store findStoreById(String storeId){
		String columns = " ss.id,user.id userId,user.real_name,file.id fileId,file.relative_path,"
				+ "date_format(ss.create_time,'%Y-%m-%d %H:%i:%s') createTime,"
				+ "ss.store_name,ss.store_describe,ss.store_province,ss.store_city,ss.store_county,"
				+ "ss.street,ss.longitude,ss.latitude,ss.db_status";
		StringBuffer from = new StringBuffer(" store_information ss");
		from.append(" left join sys_users user on user.id = ss.business_id");
		from.append(" left join sys_files file on file.id = ss.logo_id");
		StringBuffer where = new StringBuffer(" where ss.db_status = " + Constant.DB_STATUS_0);
		where.append(" and ss.id = ?");
		String orderby = "";
		List<Object[]> lg = findBySQLAll(columns, from.toString(),
				where.toString(), orderby, new Object[]{storeId});
		if(lg != null && lg.size() > 0){
			Store ss = null;
			SystemUser user = null;
			SystemFile file = null;
			for (Object[] obj : lg) {
				ss = new Store();
				ss.setId(toStringFromObj(obj[0]));
				if(obj[1] != null){
					user = new SystemUser();
					user.setId(obj[1].toString());
					user.setRealName(toStringFromObj(obj[2]));
					ss.setBusiness(user);
				}
				if(obj[3] != null){
					file = new SystemFile();
					file.setId(obj[3].toString());
					file.setRelativePath(toStringFromObj(obj[4]));
					ss.setLogo(file);
				}
				ss.setCreateTime(toTimestamp(obj[5]));
				ss.setStoreName(toStringFromObj(obj[6]));
				ss.setStoreDescribe(toStringFromObj(obj[7]));
				ss.setStoreProvince(toStringFromObj(obj[8]));
				ss.setStoreCity(toStringFromObj(obj[9]));
				ss.setStoreCounty(toStringFromObj(obj[10]));
				ss.setStreet(toStringFromObj(obj[11]));
				ss.setLongitude(todouble(obj[12]));
				ss.setLatitude(todouble(obj[13]));
				ss.setDbStatus(toint(obj[14]));
				return ss;
			}
		}
		return null;
	}

	@SuppressWarnings("unchecked")
	@Override
	public String hasStore(String businessId) {
		String columns = " ss.id,ss.business_id";
		String from = " store_information ss";
		String where = " where ss.db_status = "
				+ Constant.DB_STATUS_0 + " and ss.business_id = ?";
		String orderby = "";
		List<String> params = new ArrayList<String>();
		params.add(businessId);
		List<Object[]> lg = findBySQLAll(columns, from,
				where, orderby, params.toArray());
		if(lg != null && lg.size() > 0){
			Object[] obj = lg.get(0);
			return toStringFromObj(obj[0]);
		}
		return null;
	}

}
