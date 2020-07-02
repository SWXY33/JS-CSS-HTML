package com.guet.webservice;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.SystemUser;

@WebService
public interface IUserService {
	/**
	 * 新增或修改用户
	 * @param user
	 * @return
	 */
	@WebMethod
	public boolean saveOrUpdate(
			@WebParam(name = "user") SystemUser user);
	
	/**
	 * 根据用户名查找用户
	 * @param loginName
	 * @return
	 */
	@WebMethod
	public SystemUser login(
			@WebParam(name = "loginName") String loginName);
	
	/**
	 * 商家根据电话号码登录
	 * @param phone
	 * @return
	 */
	@WebMethod
	public SystemUser loginBusinessByPhone(
			@WebParam(name = "phone") String phone);
	
	/**
	 * 根据id查找用户
	 * @param id
	 * @return
	 */
	@WebMethod
	public SystemUser selectById(
			@WebParam(name = "id") String id);
	
	@WebMethod
	public SystemUser selectByPhone(
			@WebParam(name = "phone") String phone);
}
