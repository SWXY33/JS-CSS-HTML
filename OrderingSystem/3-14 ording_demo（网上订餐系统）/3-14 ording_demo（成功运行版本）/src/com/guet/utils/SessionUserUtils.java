package com.guet.utils;

import com.guet.OnlineUserBindingListener;
import com.guet.entities.SystemUser;
import com.guet.struts.StrutsContextFactory;

/**
 * @author X
 */
public class SessionUserUtils {
	/***
	 * 当前登录的用户的信息的ID，当用户登录后，把用户信息缓存到Session中
	 */
	public static final String LOGIN_USER = "LOGIN_USER_SESSION_KEY";

	/**
	 * 取得当前登录的用户
	 * 
	 * @return
	 */
	public final static SystemUser getLoginUser() {
		return (SystemUser) StrutsContextFactory.getSession().get(LOGIN_USER);
	}

	/**
	 * 把当前登录的用户存入Session中
	 * 
	 * @param user
	 */
	public final static void setLoginUser(SystemUser user) {
		//把用户放入在线列表
		StrutsContextFactory.getSession().put("onlineUserBindingListener", new OnlineUserBindingListener(user));
		StrutsContextFactory.getSession().put(LOGIN_USER, user);
	}

	/**
	 * 把当前登录的用户从Session中除掉
	 * 
	 * @param user
	 */
	public final static void removeCurrentLoginUser() {
		StrutsContextFactory.getSession().remove(LOGIN_USER);
	}
}
