package com.guet.action;

import org.springframework.stereotype.Component;

import com.guet.entities.SystemUser;
import com.guet.utils.SessionUserUtils;
import com.opensymphony.xwork2.ActionSupport;
import com.opensymphony.xwork2.Preparable;

@Component(value = "commonAction")
public class CommonAction extends ActionSupport implements Preparable {
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	/**
	 * 得到用户
	 * @return
	 */
	protected final SystemUser getSessionUser() {
		return SessionUserUtils.getLoginUser();
	}
	
	@Override
	public void prepare() throws Exception {
	}
}
