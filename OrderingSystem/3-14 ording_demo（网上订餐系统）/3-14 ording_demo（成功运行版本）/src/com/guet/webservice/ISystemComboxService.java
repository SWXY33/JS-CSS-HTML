package com.guet.webservice;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

@WebService
public interface ISystemComboxService {
	
	/**
	 * 查找省份
	 * @return JSON字符串
	 */
	@WebMethod
	public String findProvince();
	
	/**
	 * 根据省份id查找城市
	 * @param provinceId
	 * @return JSON字符串
	 */
	@WebMethod
	public String findCity(
			@WebParam(name = "provinceId") String provinceId);
	
	/**
	 * 根据城市id查找区/县
	 * @param cityId
	 * @return
	 */
	@WebMethod
	public String findCounty(
			@WebParam(name = "cityId") String cityId);
}
