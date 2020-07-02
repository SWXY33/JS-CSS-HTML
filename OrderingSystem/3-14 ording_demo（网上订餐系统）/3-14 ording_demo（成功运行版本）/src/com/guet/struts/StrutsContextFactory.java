package com.guet.struts;

import java.util.Map;

import com.opensymphony.xwork2.ActionContext;

public class StrutsContextFactory {

	public static Map<String, Object> getSession() {
		return ActionContext.getContext().getSession();
	}
}