package com.guet.webservice.impl;

import java.util.ArrayList;
import java.util.List;

import net.sf.json.JSONArray;

import org.springframework.transaction.annotation.Transactional;

import com.guet.constants.Constant;
import com.guet.entities.Store;
import com.guet.entities.StoreMenu;
import com.guet.entities.SystemFile;
import com.guet.page.PageVO;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IStoreMenuService;

@Transactional(readOnly = false)
public class StoreMenuServiceImpl extends DBPersistenceImpl implements IStoreMenuService {

	@Override
	public boolean save(StoreMenu menu) {
		if(menu == null)return false;
		boolean flag = false;
		flag = saveObject(menu);
		return flag;
	}
	
	@Override
	public boolean update(StoreMenu menu) {
		if(menu == null)return false;
		boolean flag = false;
		flag = updateObject(menu);
		return flag;
	}

	@Override
	public boolean deleteStoreMenu(String... ids) {
		return deleteByIds_db_status(ids, "store_menu");
	}
	
	@Override
	public StoreMenu findMenuById(String menuId) {
		String columns = " mm.id,store.id storeId,store.store_name,file.id fileId,file.relative_path,"
				+ "date_format(mm.create_time,'%Y-%m-%d %H:%i:%s') menuCreateTime,"
				+ "mm.menu_name,mm.menu_price,mm.menu_describe,mm.db_status";
		String from = " store_menu mm"
				+ " left join store_information store on store.id = mm.store_id"
				+ " left join sys_files file on file.id = mm.photo_id";
		String where = " where mm.db_status = ? and mm.id = ?";
		PageVO<Store> page = new PageVO<Store>(0, 1);
		List<Object[]> lg = findBySQLPage(columns, from,
				where, "", new Object[]{Constant.DB_STATUS_0,menuId},page);
		if(lg != null && lg.size() > 0){
			StoreMenu mm = null;
			Store ss = null;
			SystemFile ff = null;
			for (Object[] obj : lg) {
				mm = new StoreMenu();
				mm.setId(toStringFromObj(obj[0]));
				if(obj[1] != null){
					ss = new Store();
					ss.setId(obj[1].toString());
					ss.setStoreName(toStringFromObj(obj[2]));
					mm.setStore(ss);
				}
				if(obj[3] != null){
					ff = new SystemFile();
					ff.setId(obj[3].toString());
					ff.setRelativePath(toStringFromObj(obj[4]));
					mm.setPhoto(ff);
				}
				mm.setCreateTime(toTimestamp(obj[5]));
				mm.setMenuName(toStringFromObj(obj[6]));
				mm.setMenuPrice(todouble(obj[7]));
				mm.setMenuDescribe(toStringFromObj(obj[8]));
				mm.setDbStatus(toint(obj[9]));
				return mm;
			}
		}
		return null;
	}
	
	@SuppressWarnings("unchecked")
	@Override
	public List<StoreMenu> findAllStoreMenu(String storeId) {
		String columns = " mm.id,ss.id storeId,ss.store_name,ff.id fileId,ff.relative_path,"
				+ "date_format(mm.create_time,'%Y-%m-%d %H:%i:%s') menuCreateTime,"
				+ "mm.menu_name,mm.menu_price,mm.menu_describe,mm.db_status";
		String from = " store_menu mm"
				+ " left join store_information ss on ss.id = mm.store_id"
				+ " left join sys_files ff on ff.id = mm.photo_id";
		String where = " where ss.id = ? ";
		List<Object[]> lg = findBySQLAll(columns, from,
				where, "", new String[]{storeId});
		if(lg != null && lg.size() > 0){
			List<StoreMenu> menus = new ArrayList<StoreMenu>();
			StoreMenu mm = null;
			Store ss = null;
			SystemFile ff = null;
			for (Object[] obj : lg) {
				mm = new StoreMenu();
				mm.setId(toStringFromObj(obj[0]));
				if(obj[1] != null){
					ss = new Store();
					ss.setId(obj[1].toString());
					ss.setStoreName(toStringFromObj(obj[2]));
					mm.setStore(ss);
				}
				if(obj[3] != null){
					ff = new SystemFile();
					ff.setId(obj[3].toString());
					ff.setRelativePath(toStringFromObj(obj[4]));
					mm.setPhoto(ff);
				}
				mm.setCreateTime(toTimestamp(obj[5]));
				mm.setMenuName(toStringFromObj(obj[6]));
				mm.setMenuPrice(todouble(obj[7]));
				mm.setMenuDescribe(toStringFromObj(obj[8]));
				mm.setDbStatus(toint(obj[9]));
				
				menus.add(mm);
			}
			return menus;
		}
		return null;
	}

	@Override
	public String findAllStoreMenuJson(String storeId) {
		List<StoreMenu> list = findAllStoreMenu(storeId);
		if(list != null && list.size() > 0){
			JSONArray array = JSONArray.fromObject(list);
			return array.toString();
		}
		return "[]";
	}

	@Override
	public Store findStoreByMenuId(String menuId) {
		String columns = " inf.id,logo.id logoId,logo.relative_path,inf.create_time,inf.store_name,"
				+ "inf.store_describe";
		String from = " store_information inf"
				+ " inner join store_menu mm on mm.store_id = inf.id"
				+ " left join sys_files logo on logo.id = inf.logo_id";
		String where = " where mm.id = ? ";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where, new Object[]{menuId});
		if(obj != null){
			Store store = new Store();
			store.setId(toStringFromObj(obj[0]));
			if(obj[1] != null){
				SystemFile file = new SystemFile();
				file.setId(obj[1].toString());
				file.setRelativePath(toStringFromObj(obj[2]));
				store.setLogo(file);
			}
			store.setCreateTime(toTimestamp(obj[3]));
			store.setStoreName(toStringFromObj(obj[4]));
			store.setStoreDescribe(toStringFromObj(obj[5]));
			return store;
		}
		return null;
	}
}
