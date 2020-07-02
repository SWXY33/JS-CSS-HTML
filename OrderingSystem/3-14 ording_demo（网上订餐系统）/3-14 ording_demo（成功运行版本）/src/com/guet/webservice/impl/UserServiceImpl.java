package com.guet.webservice.impl;

import org.springframework.transaction.annotation.Transactional;

import com.guet.entities.SystemFile;
import com.guet.entities.SystemUser;
import com.guet.utils.StringUtils;
import com.guet.webservice.DBPersistenceImpl;
import com.guet.webservice.IUserService;

@Transactional(readOnly = false)
public class UserServiceImpl extends DBPersistenceImpl implements IUserService {
	@Override
	public boolean saveOrUpdate(SystemUser user){
		if(user == null)return false;
		boolean flag = false;
		if(!StringUtils.isInvalid(user.getId())){
			//数据修改
			flag = updateObject(user);
		}else{
			//增加
			flag = saveObject(user);
		}
		return flag;
	}
	
	@Override
	public SystemUser login(String loginName) {
		String columns = " usr.id,usr.login_name,usr.login_pwd,usr.real_name,usr.tel,"
				+ "file.id fileId,file.base_path,file.relative_path,usr.email,usr.user_type,"
				+ "usr.db_status ";
		String from = " sys_users usr left join sys_files file on file.id = usr.photo_id ";
		String where = " where usr.login_name = ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where,
				new String[] { loginName });
		if (obj != null) {
			SystemUser usr = new SystemUser();
			usr.setId(toStringFromObj(obj[0]));
			usr.setLoginName(toStringFromObj(obj[1]));
			usr.setLoginPwd(toStringFromObj(obj[2]));
			usr.setRealName(toStringFromObj(obj[3]));
			usr.setTel(toStringFromObj(obj[4]));
			if(obj[5] != null){
				SystemFile photo = new SystemFile();
				photo.setId(obj[5].toString());
				photo.setBasePath(toStringFromObj(obj[6]));
				photo.setRelativePath(toStringFromObj(obj[7]));
				usr.setPhoto(photo);
			}
			usr.setEmail(toStringFromObj(obj[8]));
			usr.setUserType(toint(obj[9]));
			usr.setDbStatus(toint(obj[10]));
			return usr;
		}
		return null;
	}
	
	@Override
	public SystemUser loginBusinessByPhone(String phone) {
		if(phone == null)return null;
		String columns = " usr.id,usr.login_name,usr.login_pwd,usr.real_name,usr.tel,"
				+ "file.id fileId,file.base_path,file.relative_path,usr.email,usr.user_type,"
				+ "usr.db_status ";
		String from = " sys_users usr left join sys_files file on file.id = usr.photo_id ";
		String where = " where usr.tel = ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where,
				new String[] { phone });
		if (obj != null) {
			SystemUser usr = new SystemUser();
			usr.setId(toStringFromObj(obj[0]));
			usr.setLoginName(toStringFromObj(obj[1]));
			usr.setLoginPwd(toStringFromObj(obj[2]));
			usr.setRealName(toStringFromObj(obj[3]));
			usr.setTel(toStringFromObj(obj[4]));
			if(obj[5] != null){
				SystemFile photo = new SystemFile();
				photo.setId(obj[5].toString());
				photo.setBasePath(toStringFromObj(obj[6]));
				photo.setRelativePath(toStringFromObj(obj[7]));
				usr.setPhoto(photo);
			}
			usr.setEmail(toStringFromObj(obj[8]));
			usr.setUserType(toint(obj[9]));
			usr.setDbStatus(toint(obj[10]));
			return usr;
		} else {
			SystemUser user = new SystemUser();
			user.setLoginName(phone);
			user.setTel(phone);
			user.setUserType(1);
			saveObject(user);
			return user;
		}
	}

	@Override
	public SystemUser selectById(String id) {
		String columns = " usr.id,usr.login_name,usr.login_pwd,usr.real_name,usr.tel,"
				+ "file.id fileId,file.base_path,file.relative_path,usr.email,usr.user_type,"
				+ "usr.db_status ";
		String from = " sys_users usr left join sys_files file on file.id = usr.photo_id ";
		String where = " where usr.id = ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where,
				new String[] { id });
		if (obj != null) {
			SystemUser usr = new SystemUser();
			usr.setId(toStringFromObj(obj[0]));
			usr.setLoginName(toStringFromObj(obj[1]));
			usr.setLoginPwd(toStringFromObj(obj[2]));
			usr.setRealName(toStringFromObj(obj[3]));
			usr.setTel(toStringFromObj(obj[4]));
			if(obj[5] != null){
				SystemFile photo = new SystemFile();
				photo.setId(obj[5].toString());
				photo.setBasePath(toStringFromObj(obj[6]));
				photo.setRelativePath(toStringFromObj(obj[7]));
				usr.setPhoto(photo);
			}
			usr.setEmail(toStringFromObj(obj[8]));
			usr.setUserType(toint(obj[9]));
			usr.setDbStatus(toint(obj[10]));
			return usr;
		}
		return null;
	}

	@Override
	public SystemUser selectByPhone(String phone) {
		String columns = " usr.id,usr.login_name,usr.login_pwd,usr.real_name,usr.tel,"
				+ "file.id fileId,file.base_path,file.relative_path,usr.email,usr.user_type,"
				+ "usr.db_status ";
		String from = " sys_users usr left join sys_files file on file.id = usr.photo_id ";
		String where = " where usr.tel = ?";
		Object[] obj = (Object[]) findBySQLUnique(columns, from, where,
				new String[] { phone });
		if (obj != null) {
			SystemUser usr = new SystemUser();
			usr.setId(toStringFromObj(obj[0]));
			usr.setLoginName(toStringFromObj(obj[1]));
			usr.setLoginPwd(toStringFromObj(obj[2]));
			usr.setRealName(toStringFromObj(obj[3]));
			usr.setTel(toStringFromObj(obj[4]));
			if(obj[5] != null){
				SystemFile photo = new SystemFile();
				photo.setId(obj[5].toString());
				photo.setBasePath(toStringFromObj(obj[6]));
				photo.setRelativePath(toStringFromObj(obj[7]));
				usr.setPhoto(photo);
			}
			usr.setEmail(toStringFromObj(obj[8]));
			usr.setUserType(toint(obj[9]));
			usr.setDbStatus(toint(obj[10]));
			return usr;
		}
		return null;
	}
}
