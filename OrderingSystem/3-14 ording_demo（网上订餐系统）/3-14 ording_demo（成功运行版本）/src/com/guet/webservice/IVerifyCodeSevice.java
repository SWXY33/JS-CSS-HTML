package com.guet.webservice;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import com.guet.entities.PhoneAndCode;

@WebService
public interface IVerifyCodeSevice {
	
	/**
	 * 新增或修改验证码
	 * @param entity
	 * @return
	 */
	@WebMethod
	public boolean saveOrUpdate(
			@WebParam(name = "entity") PhoneAndCode entity);
	
	/**
	 * 根据电话查找验证码
	 * @param phone
	 * @return
	 */
	@WebMethod
	public PhoneAndCode findByPhone(
			@WebParam(name = "phone") String phone);
	
	/**
	 * 根据电话删除验证记录
	 * @param phone
	 * @return
	 */
	@WebMethod
	public boolean deleteByPhone(
			@WebParam(name = "phone") String phone);
}
