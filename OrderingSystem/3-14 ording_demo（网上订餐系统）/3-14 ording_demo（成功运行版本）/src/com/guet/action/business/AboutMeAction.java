package com.guet.action.business;

import net.sf.json.JSONObject;

import com.guet.action.CommonAction;
import com.guet.entities.SystemUser;
import com.guet.utils.OutputHelper;
import com.guet.utils.ResultJsonUtil;
import com.guet.webservice.IFileService;
import com.guet.webservice.IUserService;

public class AboutMeAction extends CommonAction{
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	
	private IUserService userService;
	private IFileService fileService;
	
	private SystemUser user;
	
	public String preEdit(){
		try {
			if(user != null && user.getId() != null){
				user = userService.selectById(user.getId());
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return SUCCESS;
	}
	
	public String edit(){
		ResultJsonUtil result =new ResultJsonUtil();
		if(user == null){
			result.setInfo(ResultJsonUtil.RESULT_ERROR);
			result.setMsg("修改失败");
			OutputHelper.outPut(JSONObject.fromObject(result).toString());
		}else{
			try {
				userService.saveOrUpdate(user);
				result.setInfo(ResultJsonUtil.RESULT_OK);
				result.setMsg("修改成功");
			} catch (Exception e) {
				result.setInfo(ResultJsonUtil.RESULT_ERROR);
				result.setMsg("修改失败");
				e.printStackTrace();
			} finally {
				OutputHelper.outPut(JSONObject.fromObject(result).toString());
			}
		}
		return null;
	}

	public IUserService getUserService() {
		return userService;
	}

	public void setUserService(IUserService userService) {
		this.userService = userService;
	}

	public IFileService getFileService() {
		return fileService;
	}

	public void setFileService(IFileService fileService) {
		this.fileService = fileService;
	}

	public SystemUser getUser() {
		return user;
	}

	public void setUser(SystemUser user) {
		this.user = user;
	}
}
