package com.guet.webservice.impl;

import java.util.ArrayList;
import java.util.List;

import net.sf.json.JSONArray;

import org.springframework.transaction.annotation.Transactional;

import com.guet.entities.SystemCombox;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.ISystemComboxService;

@Transactional(readOnly = false)
public class SystemComboxServiceImpl extends DBPersistenceImpl implements ISystemComboxService {

	@SuppressWarnings("unchecked")
	@Override
	public String findProvince() {
		String columns = " box.id,box.parent_id,box.text,box.level";
		String from = " sys_combox box";
		String where = " where box.level = 1";
		String orderby = " order by box.text asc";
		List<SystemCombox> list = new ArrayList<SystemCombox>();
		List<Object[]> res = findBySQLAll(columns, from, where,orderby,null);
		if (res != null && res.size() > 0) {
			SystemCombox box = null;
			for (Object[] obj : res) {
				box = new SystemCombox();
				box.setId(toStringFromObj(obj[0]));
				box.setParentId(toStringFromObj(obj[1]));
				box.setText(toStringFromObj(obj[2]));
				box.setLevel(toint(obj[3]));
				list.add(box);
			}
		}
		String str = JSONArray.fromObject(list).toString();
		return str;
	}

	@SuppressWarnings("unchecked")
	@Override
	public String findCity(String provinceId) {
		String columns = " box.id,box.parent_id,box.text,box.level";
		String from = " sys_combox box";
		String where = " where box.level = ? and box.parent_id = ?";
		String orderby = " order by box.text asc";
		List<SystemCombox> list = new ArrayList<SystemCombox>();
		List<Object[]> res = findBySQLAll(columns, from, where,orderby,new Object[]{2,provinceId});
		if (res != null && res.size() > 0) {
			SystemCombox box = null;
			for (Object[] obj : res) {
				box = new SystemCombox();
				box.setId(toStringFromObj(obj[0]));
				box.setParentId(toStringFromObj(obj[1]));
				box.setText(toStringFromObj(obj[2]));
				box.setLevel(toint(obj[3]));
				list.add(box);
			}
		}
		String str = JSONArray.fromObject(list).toString();
		return str;
	}

	@SuppressWarnings("unchecked")
	@Override
	public String findCounty(String cityId) {
		String columns = " box.id,box.parent_id,box.text,box.level";
		String from = " sys_combox box";
		String where = " where box.level = ? and box.parent_id = ?";
		String orderby = " order by box.text";
		List<SystemCombox> list = new ArrayList<SystemCombox>();
		List<Object[]> res = findBySQLAll(columns, from, where,orderby,new Object[]{3,cityId});
		if (res != null && res.size() > 0) {
			SystemCombox box = null;
			for (Object[] obj : res) {
				box = new SystemCombox();
				box.setId(toStringFromObj(obj[0]));
				box.setParentId(toStringFromObj(obj[1]));
				box.setText(toStringFromObj(obj[2]));
				box.setLevel(toint(obj[3]));
				list.add(box);
			}
		}
		String str = JSONArray.fromObject(list).toString();
		return str;
	}
}
