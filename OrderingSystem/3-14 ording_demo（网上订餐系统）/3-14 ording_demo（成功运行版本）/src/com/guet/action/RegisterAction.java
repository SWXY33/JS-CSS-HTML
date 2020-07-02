package com.guet.action;

import com.guet.entities.SystemUser;
import com.guet.webservice.IUserService;

public class RegisterAction extends PageAction{
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private IUserService userService;
	private SystemUser user;
	public String clientrRegister(){
		if(user == null)return SUCCESS;
		user.setUserType(0);
		userService.saveOrUpdate(user);
		user = null;
		return SUCCESS;
	}
	
	public String businessRegister(){
		if(user == null)return SUCCESS;
		
		user.setUserType(1);
		userService.saveOrUpdate(user);
		user = null;
		return SUCCESS;
	}
	
	public SystemUser getUser() {
		return user;
	}
	public void setUser(SystemUser user) {
		this.user = user;
	}
	public IUserService getUserService() {
		return userService;
	}
	public void setUserService(IUserService userService) {
		this.userService = userService;
	}
}
