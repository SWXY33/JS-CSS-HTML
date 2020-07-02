package com.guet.action.combox;

import com.guet.action.PageAction;
import com.guet.utils.OutputHelper;
import com.guet.webservice.ISystemComboxService;

public class ComboxAction extends PageAction {

	private static final long serialVersionUID = 1L;
	
	private ISystemComboxService comboxService;

	private String provinceId;
	private String cityId;
	public String provinceCombox(){
		try {
			String res = comboxService.findProvince();
			OutputHelper.outPut(res);
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("[]");
		}
		return null;
	}
	public String cityCombox(){
		try {
			if(provinceId != null){
				String res = comboxService.findCity(provinceId);
				OutputHelper.outPut(res);
			}else{
				OutputHelper.outPut("[]");
			}
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("[]");
		}
		return null;
	}
	public String countyCombox(){
		try {
			if(cityId != null){
				String res = comboxService.findCounty(cityId);
				OutputHelper.outPut(res);
			}else{
				OutputHelper.outPut("[]");
			}
		} catch (Exception e) {
			e.printStackTrace();
			OutputHelper.outPut("[]");
		}
		return null;
	}

	public void setComboxService(ISystemComboxService comboxService) {
		this.comboxService = comboxService;
	}

	public void setProvinceId(String provinceId) {
		this.provinceId = provinceId;
	}

	public void setCityId(String cityId) {
		this.cityId = cityId;
	}
}
